<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PoliklinikController extends Controller
{
    public function index()
    {
        $polikliniks = Poliklinik::get();
        return view('sim.poli_index', [
            'polikliniks' => $polikliniks
        ]);
    }
    public function create()
    {
        $api = new AntrianController();
        $response = $api->ref_poli();
        foreach ($response->response as  $value) {
            Poliklinik::updateOrCreate([
                'kodepoli' => $value->kdpoli,
                'kodesubspesialis' => $value->kdsubspesialis,
            ], [
                'namapoli' => $value->nmpoli,
                'namasubspesialis' => $value->nmsubspesialis,
                'user' => Auth::user()->name,

            ]);
        }
        Alert::success($response->metadata->message, 'Data Poliklinik Telah Di Refresh');
        return redirect()->route('poliklinik.index');
    }
    public function edit($id)
    {
        $poliklinik = Poliklinik::find($id);
        if ($poliklinik->status) {
            $status = 0;
            $keterangan = 'Non-Aktifkan';
        } else {
            $status = 1;
            $keterangan = 'Aktifkan';
        }
        $poliklinik->update([
            'status' => $status,
        ]);
        Alert::success('Success', 'Poliklinik ' . $poliklinik->namasubspesialis . ' Telah Di ' . $keterangan);
        return redirect()->route('poliklinik.index');
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
