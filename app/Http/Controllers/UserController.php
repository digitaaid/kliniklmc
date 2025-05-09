<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $users = User::with(['roles', 'verificator'])
                ->latest()
                ->where('name', "like", "%" . $request->search . "%")
                ->orWhere('email', "like", "%" . $request->search . "%")
                ->simplePaginate(50);
        } else {
            $users = User::with(['roles', 'verificator'])
                ->latest()
                ->simplePaginate(50);
        }
        $users_total = User::count();
        $roles = Role::pluck('name');
        return view('admin.user_index', compact([
            'request',
            'users_total',
            'users',
            'roles',
        ]));
    }
    public function edit(User $user)
    {
        $roles = Role::pluck('name');
        return view('admin.user_edit', compact(['user', 'roles']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
        if (!empty($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            $request = Arr::except($request, array('password'));
        }
        $user = User::updateOrCreate(['id' => $request->id], $request->except(['_token', 'id', 'role']));
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role);
        Alert::success('Success', 'Data User Disimpan');
        return redirect()->back();
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
            'password' => 'confirmed',
        ]);
        if (!empty($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            $request = Arr::except($request, array('password'));
        }
        $user = User::find($id);
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role);
        Alert::success('Success', 'Data User Diupdate');
        return redirect()->back();
    }
    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Success', 'Data Telah Dihapus');
        return redirect()->back();
    }
    public function profile()
    {
        $user = Auth::user();
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.user_profile', compact(
            'user',
            'roles',
            'userRole',
        ));
    }
    public function profile_update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email,' . $user->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $user->id,
        ]);
        $user->update($request->all());
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('profil');
    }
    public function user_verifikasi(User $user, Request $request)
    {
        if ($user->email_verified_at) {
            $user->update([
                'email_verified_at' =>  null,
                'user_verify' => null,
            ]);
            $wa = new WhatsappController();
            $request['message'] = "*Nonaktif Akun Sistem* \nAkun anda telah dinonaktifkan. Data akun anda sebagai berikut.\n\nNAMA : " . $user->name . "\nPHONE : " . $user->phone . "\nEMAIL : " . $user->email . "\n\nTerima kasih telah bijak menggunakan sistem.";
            $request['number'] = $user->phone;
            $wa->send_message($request);
            Alert::success('Success', 'Akun telah dinonaktifkan');
        } else {
            $user->update([
                'email_verified_at' => Carbon::now(),
                'user_verify' => Auth::user()->id,
            ]);
            $wa = new WhatsappController();
            $request['message'] = "*Verifikasi Akun Sistem* \nAkun anda telah diverifikasi. Data akun anda sebagai berikut.\n\nNAMA : " . $user->name . "\nPHONE : " . $user->phone . "\nEMAIL : " . $user->email . "\n\nSilahkan gunakan akun ini baik-baik.";
            $request['number'] = $user->phone;
            $wa->send_message($request);
            Alert::success('Success', 'Akun telah diverifikasi');
        }
        return redirect()->back();
    }
    public function user_synchronize(Request $request)
    {
        $users = User::all();
        $url = env('APP_DOMAIN') . 'api/user_data';
        $res = Http::get($url);
        $data = collect(json_decode($res->body()));
        return view('admin.user_sync', compact([
            'request',
            'users',
            'data',
        ]));
    }
    public function user_sync(Request $request)
    {
        try {
            // get
            $users = User::all()->keyBy('username');
            $url = env('APP_DOMAIN') . 'api/user_data';
            $res = Http::get($url);
            $data = collect(json_decode($res->body()))->keyBy('username');
            // check
            $localUser = $users->keys();
            $externalUser = $data->keys();
            $missingInExternal = $localUser->diff($externalUser);
            $missingInLocal = $externalUser->diff($localUser);
            // add user
            foreach ($missingInExternal as $username) {
                $user = $users[$username];
                $res = Http::post(env('APP_DOMAIN') . 'api/user_add', $user->toArray());
            }
            foreach ($missingInLocal as $username) {
                $userData = $data[$username];
                if (is_object($userData)) {
                    $userData = (array) $userData;
                }
                $userData['password'] = $userData['username'];
                $user = new User($userData);
                $user->save();
            }
            Alert::success('Success', 'Berhasil Synchronize');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }

    public function user_data(Request $request)
    {
        $users = User::all();
        return json_decode(json_encode($users));
    }
    public function user_add(Request $request)
    {
        $request['password'] = $request['username'];
        $user = User::create($request->all());
        return json_decode(json_encode($user));
    }
}
