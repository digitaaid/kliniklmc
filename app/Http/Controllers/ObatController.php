<?php

namespace App\Http\Controllers;

use App\Exports\ObatExport;
use App\Imports\ObatsImport;
use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->pencarian) {
            $obats = Obat::where('id', $request->pencarian)
                ->orWhere('nama', 'LIKE', "%{$request->pencarian}%")
                ->with(['pic'])->simplePaginate(20);
        } else {
            $obats = Obat::with(['pic'])->simplePaginate(20);
        }
        $total_obat = Obat::count();
        return view('sim.obat_index', compact([
            'request',
            'obats',
            'total_obat',
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
        return redirect()->back();
    }
    public function update($id, Request $request)
    {
        $request['user'] = Auth::user()->id;
        $obat = Obat::find($id);
        $request['harga_beli'] = str_replace(".", "", $request->harga_beli);
        $hargabelippn = $request->harga_beli + ($request->harga_beli * 11 / 100);
        $hargabelisatuan = $hargabelippn / $request->konversi_satuan;
        $marginjual = $hargabelisatuan + ($hargabelisatuan * 30 / 100);
        $hargajual = round($marginjual + ($marginjual * 11 / 100));
        $request['harga_jual'] =  $hargajual;
        $obat->update($request->all());
        Alert::success('Success', 'Data Nama Obat Diperbaharui.');
        return redirect()->back();
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
    public function ref_obat_cari(Request $request)
    {
        $data = array();
        $obats = Obat::where('status', 1)
            ->where('nama', 'LIKE', '%' . $request->nama . '%')
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
        $time = now()->format('Y-m-d');
        return Excel::download(new ObatExport, 'obat_backup_' . $time . '.xlsx');
    }
    public function obatimport(Request $request)
    {
        Excel::import(new ObatsImport, $request->file);
        Alert::success('Success', 'Import Obat Berhasil.');
        return redirect()->route('obat.index');
    }
    public function form_resep_obat(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kode)->first();
        $kunjungan = $antrian->kunjungan;
        return view('sim.form_resep_obat', compact('request', 'antrian', 'kunjungan'));
    }
}
