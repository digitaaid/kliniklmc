<?php

namespace App\Http\Controllers;

use App\Models\IntegrasiApi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LocationController extends SatuSehatController
{
    public function index()
    {
        $units = Unit::get();
        return view('sim.unit_index', compact([
            'units'
        ]));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "organization_id" => "required",
            "identifier" => "required",
            "name" => "required",
            "description" => "required",
            "phone" => "required",
            "email" => "required|email",
            "url" => "required",
            "address" => "required",
            "postalCode" => "required",
            "province" => "required",
            "city" => "required",
            "district" => "required",
            "village" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError('Data Belum Lengkap', $validator->errors()->first(), 400);
        }

        $token = Cache::get('satusehat_access_token');
        $api = IntegrasiApi::where('name', 'Satu Sehat')->first();
        $url =  $api->base_url . "/Location";
        $data = [
            "resourceType" => "Location",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/location/" . $request->organization_id,
                    "value" => $request->identifier,
                ]
            ],
            "status" => "active",
            "name" => $request->name,
            "description" => $request->description,
            "mode" => "instance",
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $request->phone,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" =>  $request->email,
                ],
                [
                    "system" => "url",
                    "value" =>  $request->url,
                    "use" => "work"
                ]
            ],
            "address" => [
                "use" => "work",
                "line" => [
                    $request->address,
                ],
                "city" =>  $request->cityText,
                "postalCode" =>  $request->postalCode,
                "country" => "ID",
                "extension" => [
                    [
                        "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension" => [
                            [
                                "url" => "province",
                                "valueCode" =>  "10"
                            ],
                            [
                                "url" => "city",
                                "valueCode" =>  "1010"
                            ],
                            [
                                "url" => "district",
                                "valueCode" =>  "1010101"
                            ],
                            [
                                "url" => "village",
                                "valueCode" => "1010101101"
                            ],
                        ]
                    ]
                ]
            ],
            "physicalType" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code" => "ro",
                        "display" => "Room"
                    ]
                ]
            ],
            "position" => [
                "longitude" => -6.23115426275766,
                "latitude" => 106.83239885393944,
                "altitude" => 0
            ],
            "managingOrganization" => [
                "reference" => "Organization/" . $request->organization_id,
            ]
        ];
        $response = Http::withToken($token)->post($url, $data);
        $res = $response->json();
        return $this->responseSatuSehat($res);
    }
    public function location_sync(Request $request)
    {
        $unit = Unit::where('kode', $request->kode)->first();
        if ($unit->id_location) {
            Alert::error('Sudah memiliki id satu sehat');
        } else {
            $request['organization_id'] = $unit->idorganization;
            $request['identifier'] = $unit->kode;
            $request['name'] = $unit->nama;
            $request['phone'] = "08983311118";
            $request['email'] = "brsud.waled@gmail.com";
            $request['url'] = "rsudwaled.id";
            $request['address'] = "Jl. Prabu Kiansantang No.4";
            $request['postalCode'] = "45187";
            $request['province'] = "Jawa Barat";
            $request['city'] = "Kab. Cirebon";
            $request['district'] = "Waled";
            $request['village'] = "Waled Kota";
            $request['district'] = "Waled";
            $request['description'] = "Lokasi poliklinik " . $unit->lokasi;
            $res = $this->store($request);
            $json = $res->response;
            if ($res->metadata->code == 200) {
                $unit->update([
                    'idlocation' => $json->id,
                ]);
                Alert::success('Success', 'Berhasil Sync Location');
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return redirect()->back();
    }
}
