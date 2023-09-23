<?php

namespace App\Http\Controllers;

use App\Imports\PasiensImport;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends APIController
{
    public function index()
    {
        $pasiens = Pasien::get();
        return view('sim.pasien_index', compact([
            'pasiens',
        ]));
    }
    public function create()
    {
        $file = public_path('pasien.xlsx');
        Excel::import(new PasiensImport, $file);
        return redirect()->route('pasien.index');
    }
    public function fingerprintPeserta(Request $request)
    {
        $peserta = null;
        if ($request->nomorkartu) {
            $request['jenisIdentitas'] = 'noka';
            $request['noIdentitas'] = $request->nomorkartu;
            $api = new AntrianController();
            $response =  $api->ref_pasien_fingerprint($request);
            if ($response->metadata->code == 200) {
                $peserta = $response->response;
                if ($peserta->daftarfp == 0) {
                    Alert::error('Maaf', 'Pasien Belum memeliki Fingerprint BPJS');
                } else {
                    Alert::success('Success', 'Pasien Belum memeliki Fingerprint BPJS');
                }
            } else {
                Alert::error('Maaf', $response->metadata->message);
            }
        }
        return view('bpjs.antrian.fingerprint_peserta', compact([
            'request',
            'peserta'
        ]));
    }
}
