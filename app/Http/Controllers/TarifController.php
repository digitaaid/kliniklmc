<?php

namespace App\Http\Controllers;

use App\Exports\TarifExport;
use App\Imports\TarifImport;
use App\Models\Kunjungan;
use App\Models\Layanan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TarifController extends APIController
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
        $tarifs = Tarif::whereIn('jenispasien', ['SEMUA', $request->jenispasien])
            ->where('nama', 'LIKE', '%' . $request->search . '%')
            ->get();
        if ($tarifs) {
            foreach ($tarifs as $item) {
                $data[] = array(
                    "id" => $item->id,
                    "text" => $item->nama . ' ' . money($item->harga, 'IDR'),
                    "harga" => $item->harga,
                );
            }
            return response()->json($data);
        }
    }
    function input_tarif_pasien(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'kodebooking' => 'required',
                'antrian_id' => 'required',
                'kunjungan_id' => 'required',
                'kodekunjungan' => 'required',
                'layanan' => 'required',
                'jumlah' => 'required',
                'harga' => 'required',
                'diskon' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 400);
            }
            // add layanan
            if ($request->layanan) {
                $tarif = Tarif::find($request->layanan);
                $layanans = Layanan::updateOrCreate(
                    [
                        'kodebooking' => $request->kodebooking,
                        'antrian_id' => $request->antrian_id,
                        'kodekunjungan' => $request->kodekunjungan,
                        'kunjungan_id' => $request->kunjungan_id,
                        'tarif_id' =>  $tarif->id,
                    ],
                    [
                        'nama' => $tarif->nama,
                        'harga' => $tarif->harga,
                        'jumlah' =>  $request->jumlah,
                        'diskon' => $request->diskon,
                        'subtotal' => ($tarif->harga * $request->jumlah) - ($tarif->harga * $request->jumlah * $request->diskon / 100),
                        'klasifikasi' => $tarif->klasifikasi,
                        'jaminan' => $request->jaminan,
                        'pic' => Auth::user()->name,
                        'user' => Auth::user()->id,
                        'tgl_input' => now('Asia/Jakarta'),
                    ]
                );
                return $this->sendResponse($layanans, 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError($th->getMessage(), $th->getCode());
        }
    }
    function delete_tarif_pasien(Request $request)
    {
        $tarif = Layanan::find($request->tarif);
        $tarif->delete();
        return $this->sendResponse('Ok', 200);
    }
    function get_layanan_kunjungan(Request $request)
    {
        $kunjungan = Kunjungan::with(['layanans', 'layanans.jaminans'])->find($request->kunjungan);
        $layanans = $kunjungan->layanans;
        return $this->sendResponse($layanans);
    }
    function laporan_layanan_tindakan(Request $request)
    {
        $laydet = Layanan::with(['jaminans'])->latest()->simplePaginate();
        $laydet_total = Layanan::count();
        return view('sim.layanan_detail_index', compact([
            'laydet',
            'laydet_total',
        ]));
    }
    public function tarifexport()
    {
        $time = now()->format('Y-m-d');
        return Excel::download(new TarifExport, 'tarif_backup_' . $time . '.xlsx');
    }
    public function tarifimport(Request $request)
    {
        Excel::import(new TarifImport, $request->file);
        Alert::success('Success', 'Import Tarif Berhasil.');
        return redirect()->route('tarif.index');
    }
}
