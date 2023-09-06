<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::firstWhere('email', $user_google->email);
            //jika user ada maka langsung di redirect ke halaman home
            if ($user) {
                $user->update([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
            }
            //jika user tidak ada maka simpan ke database
            else {
                //$user_google menyimpan data google account seperti email, foto, dsb
                $user = User::Create([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'password' => Hash::make('password'),
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
                $user->assignRole('Pasien');
            }
            if ($user->email_verified_at) {
                auth()->login($user, true);
                return redirect()->route('home');
            } else {
                return redirect()->route('login')->withErrors("Mohon maaf, akun anda belum diverifikasi.");
            }
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}
