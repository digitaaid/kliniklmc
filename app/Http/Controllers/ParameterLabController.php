<?php

namespace App\Http\Controllers;

use App\Models\ParameterLab;
use App\Models\PemeriksaanLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ParameterLabController extends Controller
{
    public function index(Request $request)
    {
        $parameter = ParameterLab::get();
        $pemeriksaan = PemeriksaanLab::pluck('nama', 'id');
        return view('sim.parameterlab_index', compact([
            'request',
            'parameter',
            'pemeriksaan',
        ]));
    }
    public function store(Request $request)
    {
        $request['user'] = Auth::user()->id;
        $request['pemeriksaans'] = $request->pemeriksaan;
        $request['pemeriksaan'] = json_encode($request->pemeriksaan);
        $parameter = ParameterLab::updateOrCreate(
            [
                'nama' => $request->nama,
            ],
            $request->all()
        );
        $parameter->update($request->all());
        $parameter->pemeriksaans()->sync($request->pemeriksaans);
        Alert::success('Success', 'Parameter Laboratorium Berhasil Ditambahkan');
        return redirect()->back();
    }
    public function update(Request $request, string $id)
    {
        $parameter = ParameterLab::find($id);
        $request['user'] = Auth::user()->id;
        $request['pemeriksaans'] = $request->pemeriksaan;
        $request['pemeriksaan'] = json_encode($request->pemeriksaan);
        $parameter->update($request->all());
        $parameter->pemeriksaans()->sync($request->pemeriksaans);
        Alert::success('Success', 'Parameter Laboratorium Berhasil Diupdate');
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        //
    }
}
