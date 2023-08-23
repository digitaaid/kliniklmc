<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function dokterAntrianBpjs()
    {
        $controller = new AntrianController();
        $response = $controller->ref_dokter();
        if ($response->metadata->code == 200) {
            $dokters = $response->response;
            Alert::success($response->metadata->message, 'Dokter Antrian BPJS Total : ' . count($dokters));
        } else {
            $dokters = null;
            Alert::error($response->metadata->message . ' ' . $response->metadata->code);
        }
        return view('bpjs.antrian.dokter', compact([
            'dokters',
        ]));
    }
}
