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
    public function obatkemoterapi(Request $request)
    {
        $reseps = ResepKemoterapi::get();
        $obatkemoterapi = Obat::where('jenisobat', 'Obat Kemoterapi')->get();
        $penunjangkemoterapi = Obat::where('jenisobat', 'Penunjang Kemoterapi')->get();
        return view('sim.obat_kemoterapi_index', compact([
            'request',
            'reseps',
            'obatkemoterapi',
            'penunjangkemoterapi',
        ]));
        // dd($request->all(), $reseps);
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
