<?php

namespace App\Http\Controllers;

use App\Exports\ObatExport;
use App\Imports\ObatsImport;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request)
    {
        $request['user'] = Auth::user()->id;
        Obat::updateOrCreate(
            [
                'nama' => $request->nama,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data Nama Obat Disimpan.');
        return redirect()->route('obat.index');
    }
    public function update($id, Request $request)
    {
        $obat = Obat::find($id);
        $obat->update([
            'nama' => $request->nama,
            'jenisobat' => $request->jenisobat,
            'harga' => $request->harga,
            'satuan' => $request->satuan,
            'tipebarang' => $request->tipebarang,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Nama Obat Diperbaharui.');
        return redirect()->route('obat.index');
    }
    public function destroy($id, Request $request)
    {
        $obat = Obat::find($id);
        if ($obat->status) {
            $status = 0;
        }
        $obat->update([
            'status' => $status ?? 1,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Obat Dinonaktifkan.');
        return redirect()->back();
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
    public function obatexport()
    {
        return Excel::download(new ObatExport, 'obat.xlsx');
    }
    public function obatimport(Request $request)
    {
        Excel::import(new ObatsImport, $request->file);
        Alert::success('Success', 'Import Obat Berhasil.');
        return redirect()->route('obat.index');
    }
}
