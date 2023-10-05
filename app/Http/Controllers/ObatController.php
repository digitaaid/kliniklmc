<?php

namespace App\Http\Controllers;

use App\Imports\ObatsImport;
use App\Models\Obat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::get();
        return view('sim.obat_index', compact([
            'obats',
        ]));
    }
    public function create()
    {
        $file = public_path('obat.xlsx');
        Excel::import(new ObatsImport, $file);
        return redirect()->route('obat.index');
    }
    public function store(Request $request)
    {
        Obat::updateOrCreate([
            'nama' => $request->nama,
        ]);
        Alert::success('Success', 'Data Nama Obat Disimpan.');
        return redirect()->route('obat.index');
    }
    public function update($id, Request $request)
    {
        $obat = Obat::find($id);
        $obat->update([
            'nama' => $request->nama,
            'jenisobat' => $request->jenisobat,
        ]);
        Alert::success('Success', 'Data Nama Obat Diperbaharui.');
        return redirect()->route('obat.index');
    }
    public function reset_obat()
    {
        $obats = Obat::all();
        foreach ($obats as  $value) {
            $value->delete();
        }
        return redirect()->route('obat.index');
    }
    public function ref_obat_cari(Request $request)
    {
        $data = array();
        $obats = Obat::where('nama', 'LIKE', '%' . $request->nama . '%')
            ->limit(20)->get();
        if ($obats) {
            foreach ($obats as $item) {
                $data[] = array(
                    "id" => $item->id,
                    "text" => $item->nama
                );
            }
        }
        return response()->json($data);
    }
}
