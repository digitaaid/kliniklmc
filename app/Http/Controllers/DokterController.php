<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $dokter = Dokter::get();
        return view('sim.dokter_index', compact([
            'request',
            'dokter',
        ]));
    }
    public function create()
    {
        $api = new AntrianController();
        $response = $api->ref_dokter();
        foreach ($response->response as $value) {
            Dokter::updateOrCreate([
                'kodedokter' => $value->kodedokter,
            ], [
                'namadokter' => $value->namadokter,
            ]);
        }
        Alert::success($response->metadata->message, 'Data Dokter Telah Di Refresh');
        return redirect()->route('dokter.index');
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'namadokter' => 'required',
            'kodedokter' => 'required',
            'subtitle' => 'required',
        ]);
        $dokter = Dokter::find($id);
        $dokter->update($request->all());
        Alert::success("Success", 'Data dokter berhasil diupdate.');
        return redirect()->route('dokter.index');
    }
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
