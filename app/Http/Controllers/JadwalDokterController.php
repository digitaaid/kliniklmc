<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        $polikliniks = Unit::get();
        $dokters = Dokter::get();
        $jadwal_antrian = JadwalDokter::get();
        $request['tanggal'] = $request->tanggal ? $request->tanggal : now()->format('Y-m-d');
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $controller = new AntrianController();
            $response = $controller->ref_jadwal_dokter($request);
            if ($response->metadata->code == 200) {
                $jadwals = $response->response;
                Alert::success($response->metadata->message, 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('sim.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'jadwals',
            'dokters',
            'jadwal_antrian',
        ]));
    }

    public function jadwalDokterAntrianBpjs(Request $request)
    {
        $polikliniks = Poliklinik::all();
        $jadwal_save = JadwalDokter::all();
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $api = new AntrianController();
            $response = $api->ref_jadwal_dokter($request);
            if ($response->metadata->code == 200) {
                $jadwals = $response->response;
                Alert::success($response->metadata->message, 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        $api = new AntrianController();
        $response =  $api->ref_poli();
        $polikliniks = $response->response;
        return view('bpjs.antrian.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'jadwals',
            'jadwal_save',
        ]));
    }
}
