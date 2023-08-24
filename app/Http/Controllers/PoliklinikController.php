<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PoliklinikController extends Controller
{
    public function index()
    {
        $polis = Unit::get();
        return view('sim.poli_index', [
            'polis' => $polis
        ]);
    }
    public function poliklikAntrianBpjs()
    {
        $controller = new AntrianController();
        $response = $controller->ref_poli();
        if ($response->metadata->code == 200) {
            $polikliniks = $response->response;
            Alert::success($response->metadata->message, 'Poliklinik Antrian BPJS');
        } else {
            $polikliniks = null;
            Alert::error($response->metadata->message . ' ' . $response->metadata->code);
        }
        $response = $controller->ref_poli_fingerprint();
        if ($response->metadata->code == 200) {
            $fingerprint = $response->response;
            Alert::success($response->metadata->message, 'Poliklinik Antrian BPJS');
        } else {
            $fingerprint = null;
            Alert::error($response->metadata->message . ' ' . $response->metadata->code,  'Poliklinik Fingerprint Antrian BPJS');
        }
        return view('bpjs.antrian.poliklinik', compact([
            'polikliniks',
            'fingerprint',
        ]));
    }
}
