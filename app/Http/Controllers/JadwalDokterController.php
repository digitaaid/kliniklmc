<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
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
