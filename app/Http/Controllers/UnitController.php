<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::get();
        return view('sim.unit_index', compact([
            'units'
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required',
        ]);
        $request['user'] = Auth::user()->id;
        $request['pic'] = Auth::user()->name;
        $request['kodedokter'] = 'asdasd';
        Unit::updateOrCreate(
            [
                'nama' => $request->nama,
                'kode' => $request->kode,
            ],
            $request->all()
        );
        Alert::success("Success", 'Unit berhasil diupdate.');
        return redirect()->back();
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);
        $unit = Unit::find($id);
        $request['user'] = Auth::user()->id;
        $request['pic'] = Auth::user()->name;
        $unit->update($request->all());
        Alert::success("Success", 'Unit berhasil diupdate.');
        return redirect()->back();
    }
    public function destroy($id, Request $request)
    {
        $unit = Unit::find($id);
        $unit->update([
            'status' => $unit->status ? 0 :  1,
            'user' => Auth::user()->id,
            'pic' => Auth::user()->name,
        ]);
        Alert::success('Success', 'Unit Dinonaktifkan.');
        return redirect()->back();
    }
}
