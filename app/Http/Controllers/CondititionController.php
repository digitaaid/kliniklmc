<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\IntegrasiApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CondititionController extends SatuSehatController
{
    public function conditition_sync(Request $request)
    {

        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $kunjungan = $antrian->kunjungan;
        $pasien = $antrian->pasien;
        $request['patient_id'] = $pasien->idpatient;
        $request['patient_name'] = $pasien->nama;
        $request['encounter_id'] = $kunjungan->idencounter;
        $request['code_idc10'] = $kunjungan->diagnosa_awal;
        $request['name_icd10'] = $kunjungan->diagnosa_awal;
        $res  = $this->conditition_create($request);
        if ($res->metadata->code == 201) {
            $kunjungan->update([
                'idcondititon' => $kunjungan->diagnosa_awal,
            ]);
            Alert::success('Success', 'Diagnosa Berhasil Diinput ke Satu Sehat');
        } else {
            Alert::error('Mohon maaf', $res->metadata->message);
        }
        return redirect()->back();
    }
    public function conditition_create(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "code_idc10" => "required",
            "name_icd10" => "required",
            "patient_id" => "required",
            "patient_name" => "required",
            "encounter_id" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Data Belum Lengkap ' . $validator->errors()->first(), 400);
        }
        $token = Cache::get('satusehat_access_token');
        $api = IntegrasiApi::where('name', 'Satu Sehat')->first();
        $url =  $api->base_url .  "/Condition";
        $data = [
            "resourceType" => "Condition",
            "clinicalStatus" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code" => "active",
                        "display" => "Active"
                    ]
                ]
            ],
            "category" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code" => "encounter-diagnosis",
                            "display" => "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code" => [
                "coding" => [
                    [
                        "system" => "http://hl7.org/fhir/sid/icd-10",
                        "code" =>  $request->code_idc10,
                        "display" =>  $request->name_icd10,
                    ]
                ]
            ],
            "subject" => [
                "reference" => "Patient/" . $request->patient_id,
                "display" => $request->patient_name,
            ],
            "encounter" => [
                "reference" => "Encounter/" . $request->encounter_id,
                "display" => "Kunjungan " . $request->patient_name,
            ]
        ];
        $response = Http::withToken($token)->post($url, $data);
        $res = $response->json();
        return $this->responseSatuSehat($res);
    }
}
