<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\IntegrasiApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class PractitionerController extends SatuSehatController
{
    public function index(Request $request)
    {
        $dokter = Dokter::get();
        return view('sim.dokter_index', compact([
            'request',
            'dokter',
        ]));
    }
    public function practitioner_by_nik(Request $request)
    {
        $token = Cache::get('satusehat_access_token');
        $api = IntegrasiApi::where('name', 'Satu Sehat')->first();
        $url = $api->base_url . "/Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|" . $request->nik;
        $response = Http::withToken($token)->get($url);
        $data = $response->json();
        return $this->responseSatuSehat($data);
    }
    public function practitioner_sync(Request $request)
    {
        $dokter = Dokter::where('kodedokter', $request->kodedokter)->first();
        $request['nik'] = $dokter->nik;
        if ($request->nik) {
            $res = $this->practitioner_by_nik($request);
            if ($res->metadata->code == 200) {
                if (count($res->response->entry)) {
                    $id = $res->response->entry[0]->resource->id;
                    $dokter->update([
                        'idpractitioner' => $id
                    ]);
                    Alert::success('Success', 'Berhasil Sync Practitioner Satu Sehat');
                } else {
                    Alert::error('Mohon Maaf', $res->metadata->message);
                }
            } else {
                Alert::error('Mohon Maaf', 'Gagal Sync Practitioner ' . $res->metadata->message);
            }
        } else {
            Alert::error('Mohon Maaf', 'Dokter belum memiliki nik');
        }
        return redirect()->back();

    }
}
