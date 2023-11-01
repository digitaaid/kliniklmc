<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Obat;
use App\Models\ResepKemoterapi;
use App\Models\ResepObatDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class FarmasiController extends APIController
{
    // farmasi
    public function antrianfarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->get();
        } else {
            // $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_farmasi', compact([
            'request',
            'antrians',
        ]));
    }
    public function getantrianfarmasi(Request $request)
    {
        if ($request->tanggalperiksa) {
            $antrian = Antrian::whereDate('tanggalperiksa', $request->tanggalperiksa)
                ->where('taskid', 5)
                ->first('kodebooking');
            if ($antrian) {
                return $this->sendResponse($antrian, 200);
            } else {
                return $this->sendError('Tidak ada order',  404);
            }
        } else {
            return $this->sendError('Tidak ada order',  404);
        }
    }
    function terimafarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $request['taskid'] = "6";
            $request['waktu'] = now();
            if ($antrian->taskid == 5) {
                $api = new AntrianController();
                $res = $api->update_antrean($request);
                $antrian->update([
                    'taskid' => $request->taskid,
                    'user4' => Auth::user()->id,
                    'keterangan' => "Resep Pasien sudah diterima di farmasi.",
                ]);
                Alert::success('Success', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    function panggilfarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $antrian->update([
                'taskid' => $request->taskid,
                'panggil' => 0,
                'user4' => Auth::user()->id,
                'keterangan' => "Pasien telah selesai semua pelayanan",
            ]);
            Alert::success('Success', 'Antrian dipanggil farmasi');
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    function selesaifarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $request['taskid'] = "7";
            $request['waktu'] = now();
            $api = new AntrianController();
            $res = $api->update_antrean($request);
            // if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'panggil' => 0,
                'user4' => Auth::user()->id,
                'keterangan' => "Pasien telah selesai semua pelayanan",
            ]);
            // }
            Alert::success('Success', $res->metadata->message);
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    public function laporanfarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('taskid', '!=', 99)
                ->get();
        }
        return view('sim.laporan_farmasi', compact([
            'request',
            'antrians',
        ]));
    }
    public function laporanobat(Request $request)
    {
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('taskid', '!=', 99)
                ->get();
        } else {
            $obats = ResepObatDetail::get()->groupBy('nama');
        }
        return view('sim.laporan_obat', compact([
            'request',
            'obats',
        ]));
    }
    public function obatkemoterapi(Request $request)
    {
        $reseps = ResepKemoterapi::get();
        $obatkemoterapi = Obat::where('jenisobat', 'Obat Kemoterapi')->get();
        $penunjangkemoterapi = Obat::where('jenisobat', 'Penunjang Kemoterapi')->get();
        $title = 'Batal Kemoterapi!';
        $text = "Apakah anda yakin akan membatalkan permintaan obat kemoterapi ?";
        confirmDelete($title, $text);
        return view('sim.obat_kemoterapi_index', compact([
            'request',
            'reseps',
            'obatkemoterapi',
            'penunjangkemoterapi',
        ]));
    }
    public function batalkemotarapi(Request $request)
    {
        $resep = ResepKemoterapi::where('kode', $request->kode)->first();
        $resep->update([
            'status' => 99
        ]);
        Alert::success('Success', 'Permintaan Obat Kemoterapi Berhasil dibatalkan');
        return redirect()->back();
        dd($request->all(), $resep);
        $reseps = ResepKemoterapi::get();
        $obatkemoterapi = Obat::where('jenisobat', 'Obat Kemoterapi')->get();
        $penunjangkemoterapi = Obat::where('jenisobat', 'Penunjang Kemoterapi')->get();
        return view('sim.obat_kemoterapi_index', compact([
            'request',
            'reseps',
            'obatkemoterapi',
            'penunjangkemoterapi',
        ]));
    }
    public function store_resepkemoterapi(Request $request)
    {
        if (empty($request->kode)) {
            $request['kode'] = strtoupper(uniqid());
        }
        $request['user'] = Auth::user()->id;
        $resep = ResepKemoterapi::updateOrCreate(
            [
                'kode' => $request->kode
            ],
            $request->all()
        );
        foreach ($request->jumlah as $key => $value) {
            if ($value) {
                $obat = Obat::find($request->obat[$key]);
                $resepdetail = ResepObatDetail::updateOrCreate(
                    [
                        'koderesep' => $resep->kode,
                        'resep_id' => $resep->id,
                        'obat_id' =>  $obat->id,
                    ],
                    [
                        'nama' => $obat->nama,
                        'jumlah' => $request->jumlah[$key] ?? 0,
                        'interval' => $request->frekuensi[$key] ?? null,
                        'waktu' => $request->waktuobat[$key] ?? null,
                        'keterangan' => $request->keterangan_obat[$key] ?? null,
                    ]
                );
            } else {
                $obat = Obat::find($request->obat[$key]);
                $resepdetail = ResepObatDetail::where('koderesep', $resep->kode)
                    ->where('obat_id', $request->obat[$key])
                    ->first();
                if ($resepdetail) {
                    $resepdetail->delete();
                }
            }
        }
        Alert::success('Success', 'Resep kemoterapi berhasil disimpan');
        return redirect()->back();
    }
    public function get_resepkemoterapi(Request $request)
    {
        $reseps = ResepObatDetail::where('koderesep', $request->kode)->get();
        return $this->sendResponse($reseps, 200);
    }
}
