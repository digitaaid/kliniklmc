<?php

namespace App\Http\Controllers;

use App\Exports\TarifExport;
use App\Imports\TarifImport;
use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Jaminan;
use App\Models\Kunjungan;
use App\Models\Layanan;
use App\Models\Tarif;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
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
                        'harga' => $request->harga,
                        'jumlah' =>  $request->jumlah,
                        'diskon' => $request->diskon,
                        'subtotal' => ($request->harga * $request->jumlah) - ($request->harga * $request->jumlah * $request->diskon / 100),
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
    function update_tarif_pasien(Request $request)
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
                $user = Auth::user()->id;
                if ($user ==  $tarif->user) {
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
                            'harga' => $request->harga,
                            'jumlah' =>  $request->jumlah,
                            'diskon' => $request->diskon,
                            'subtotal' => ($request->harga * $request->jumlah) - ($request->harga * $request->jumlah * $request->diskon / 100),
                            'klasifikasi' => $tarif->klasifikasi,
                            'jaminan' => $request->jaminan,
                            'pic' => Auth::user()->name,
                            'user' => Auth::user()->id,
                            'tgl_input' => now('Asia/Jakarta'),
                        ]
                    );
                    return $this->sendResponse($layanans, 200);
                } else {
                    return $this->sendError('Tidak bisa diedit oleh orang lain', 401);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError($th->getMessage(), $th->getCode());
        }
    }
    function delete_tarif_pasien(Request $request)
    {
        $user = Auth::user()->id;
        $tarif = Layanan::find($request->tarif);
        if ($user ==  $tarif->user) {
            $tarif->delete();
            return $this->sendResponse('Ok', 200);
        } else {
            return $this->sendError('Tidak bisa dihapus oleh orang lain', 401);
        }
    }
    function get_layanan_kunjungan(Request $request)
    {
        $kunjungan = Kunjungan::with(['layanans', 'layanans.jaminans', 'layanans.pic'])->find($request->kunjungan);
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
    public function print_invoice_billing(Request $request)
    {
        $antrian = Antrian::with(['kunjungan', 'pasien', 'layanans', 'kunjungan.units'])->firstWhere('kodebooking', $request->kodebooking);
        $kunjungan = $antrian->kunjungan;
        $pasien = $antrian->pasien;
        $layanans = $kunjungan->layanans;
        // dd($layanans);
        $pdf = Pdf::loadView('print.pdf_invoice_billing', compact(
            'kunjungan',
            'pasien',
            'layanans',
        ));
        return $pdf->stream($antrian->tanggalperiksa . '-INVOICE-' . strtoupper($pasien->nama) . '.pdf');
    }
    public function form_layanan(Request $request)
    {
        $antrian = Antrian::with(['layanans', 'kunjungan'])->firstWhere('kodebooking', $request->kode);
        $layanans = $antrian->layanans;
        $kunjungan = $antrian->kunjungan;
        $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
        $jaminans = Jaminan::pluck('nama', 'kode');
        $polikliniks = Unit::where('status', '1')->pluck('nama', 'kode');
        return view('sim.form_layanan', compact('request', 'antrian', 'layanans',  'jaminans', 'kunjungan', 'dokters', 'polikliniks'));
    }
}
