<?php

namespace App\Http\Controllers;

use App\Imports\TarifImport;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TarifController extends Controller
{
    public function index(Request $request)
    {
        $tarifs = Tarif::get();
        return view('sim.tarif_index', compact([
            'tarifs'
        ]));
    }

    public function create()
    {
        $file = public_path('tarif.xlsx');
        Excel::import(new TarifImport, $file);
        return redirect()->route('tarif.index');
    }

    public function store(Request $request)
    {
        $request['user'] = Auth::user()->id;
        Tarif::updateOrCreate(
            [
                'nama' => $request->nama,
                'jenispasien' => $request->jenispasien,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data Tarif Disimpan.');
        return redirect()->route('tarif.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function ref_tarif_pendaftaran(Request $request)
    {
        $data = array();
        $tarifs = Tarif::whereIn('klasifikasi', ['Administrasi', 'Konsultasi'])->whereIn('jenispasien', ['SEMUA', $request->jenispasien])
            ->where('nama', 'LIKE', '%' . $request->search . '%')
            ->get();
        if ($tarifs) {
            foreach ($tarifs as $item) {
                $data[] = array(
                    "id" => $item->id,
                    "text" => $item->nama . ' ' . money($item->harga, 'IDR'),
                );
            }
            return response()->json($data);
        }
    }
    public function ref_tarif_layanan(Request $request)
    {
        $data = array();
        $tarifs = Tarif::whereNotIn('klasifikasi', ['Administrasi', 'Konsultasi'])
            ->whereIn('jenispasien', ['SEMUA', $request->jenispasien])
            ->where('nama', 'LIKE', '%' . $request->search . '%')
            ->get();
        if ($tarifs) {
            foreach ($tarifs as $item) {
                $data[] = array(
                    "id" => $item->id,
                    "text" => $item->nama . ' ' . money($item->harga, 'IDR'),
                );
            }
            return response()->json($data);
        }
    }
    public function update(Request $request, string $id)
    {
        $obat = Tarif::find($id);
        $obat->update([
            'nama' => $request->nama,
            'klasifikasi' => $request->klasifikasi,
            'harga' => $request->harga,
            'jenispasien' => $request->jenispasien,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Tarif Diperbaharui.');
        return redirect()->route('tarif.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
