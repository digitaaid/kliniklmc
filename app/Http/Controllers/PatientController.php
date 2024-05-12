<?php

namespace App\Http\Controllers;

use App\Models\IntegrasiApi;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Laravolt\Indonesia\Models\Kabupaten;
use RealRashid\SweetAlert\Facades\Alert;

class PatientController extends SatuSehatController
{
    public function index(Request $request)
    {
        if ($request->search) {
            $pasiens = Pasien::orderBy('norm', 'desc')
                ->where('norm', 'LIKE', "%{$request->search}%")
                ->orWhere('nama', 'LIKE', "%{$request->search}%")
                ->orWhere('nomorkartu', 'LIKE', "%{$request->search}%")
                ->orWhere('nik', 'LIKE', "%{$request->search}%")
                ->with(['pic'])->simplePaginate(20);
        } else {
            $pasiens = Pasien::orderBy('norm', 'desc')->with(['pic'])->simplePaginate(20);;
        }
        $total_pasien = Pasien::count();
        $kabupaten = Kabupaten::where('province_code', '32')->pluck('name', 'code');
        return view('sim.pasien_index', compact([
            'request',
            'pasiens',
            'total_pasien',
        ]));
    }
    public function patient_by_nik(Request $request)
    {
        $token = Cache::get('satusehat_access_token');
        $api = IntegrasiApi::where('name', 'Satu Sehat')->first();
        $url = $api->base_url . "/Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $request->nik;
        $response = Http::withToken($token)->get($url);
        $data = $response->json();
        return $this->responseSatuSehat($data);
    }
    public function patient_get_id(Request $request)
    {
        $pasien = Pasien::where('norm', $request->norm)->first();
        $request['nik'] = $pasien->nik;
        $res = $this->patient_by_nik($request);
        if ($res->metadata->code == 200) {
            if ($res->response->entry) {
                $id = $res->response->entry[0]->resource->id;
                $pasien->update([
                    'idpatient' => $id
                ]);
            } else {
                $data = [
                    'metadata' => [
                        'message' => "Data Pasien Tidak Ditemukan Di Server Satu Sehat",
                        'code' => 404,
                    ],
                ];
                $res = json_decode(json_encode($data));
            }
        }
        return $res;
    }
    public function patient_sync(Request $request)
    {
        $pasien = Pasien::where('norm', $request->norm)->first();
        $request['nik'] = $pasien->nik_bpjs;
        $res = $this->patient_by_nik($request);
        if ($res->metadata->code == 200) {
            if ($res->response->entry) {
                $id = $res->response->entry[0]->resource->id;
                $pasien->update([
                    'idpatient' => $id
                ]);
                Alert::success('Sukses', 'Berhasil Sync Patient Satu Sehat');
            } else {
                Alert::error('Mohon Maaf', 'Data Pasien Tidak Ditemukan Di Server Satu Sehat');
            }
        } else {
            Alert::error('Mohon Maaf', $res->metadata->message);
        }
        return redirect()->back();
    }
}
