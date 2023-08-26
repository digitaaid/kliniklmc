<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\IntegrasiApi;
use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends APIController
{

    // pendaftaran
    public function antrianConsole()
    {
        $jadwals = JadwalDokter::where('hari',  now()->dayOfWeek)
            ->orderBy('namasubspesialis', 'asc')->get();
        $antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))->get();
        return view('sim.antrian_console', compact(
            [
                'jadwals',
                'antrians',
            ]
        ));
    }

    public function statusAntrianBpjs()
    {
        $api = IntegrasiApi::where('name', 'Antrian BPJS')->first();
        return view('bpjs.antrian.status', compact([
            'api'
        ]));
    }
    public function listTaskID(Request $request)
    {
        // get antrian
        $taskid = null;
        if (isset($request->kodebooking)) {
            $response =  $this->taskid_antrean($request);
            if ($response->metadata->code == 200) {
                $taskid = $response->response;
            }
            Alert::success($response->metadata->message . ' ' . $response->metadata->code);
        }
        return view('bpjs.antrian.list_task', compact([
            'request',
            'taskid',
        ]));
    }
    public function dashboardTanggalAntrian(Request $request)
    {
        $antrians = null;
        $antrianx = null;
        if (isset($request->waktu)) {
            $antrianx = Antrian::whereDate('tanggalperiksa', '=', $request->tanggal)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->where('taskid', '!=', 0)
                ->get();
            $response =  $this->dashboard_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);
                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.dashboard_tanggal_index', compact([
            'request',
            'antrians',
            'antrianx',
        ]));
    }
    public function dashboardBulanAntrian(Request $request)
    {
        $antrians = null;
        $antrianx = null;
        if (isset($request->tanggal)) {
            $tanggal = explode('-', $request->tanggal);
            $request['tahun'] = $tanggal[0];
            $request['bulan'] = $tanggal[1];
            $response =  $this->dashboard_bulan($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);
                $antrianx = Antrian::whereYear('tanggalperiksa', '=', $request->tahun)
                    ->whereMonth('tanggalperiksa', '=', $request->bulan)
                    ->where('method', '!=', 'Offline')
                    ->where('taskid', '!=', 99)
                    ->where('taskid', '!=', 0)
                    ->get();
                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.dashboard_bulan_index', compact([
            'request',
            'antrians',
            'antrianx',
        ]));
    }
    public function antrianPerTanggal(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $response = $this->antrian_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }
        }
        return view('bpjs.antrian.antrian_per_tanggal', compact(['request', 'antrians']));
    }
    public function antrianPerKodebooking(Request $request)
    {
        $antrian = null;
        if ($request->kodebooking) {
            $request['kodeBooking'] = $request->kodebooking;
            $response = $this->antrian_kodebooking($request);
            if ($response->metadata->code == 200) {
                $antrian = $response->response[0];
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }
        }
        return view('bpjs.antrian.antrian_per_kodebooking', compact([
            'request', 'antrian'
        ]));
    }
    public function antrianBelumDilayani(Request $request)
    {
        $request['tanggal'] = now()->format('Y-m-d');
        $response = $this->antrian_belum_dilayani($request);
        if ($response->metadata->code == 200) {
            $antrians = $response->response;
        } else {
            $antrians = null;
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
        }
        return view('bpjs.antrian.antrian_belum_dilayani', compact(['request', 'antrians']));
    }
    public function antrianPerDokter(Request $request)
    {
        $antrians = null;
        $jadwaldokter = JadwalDokter::orderBy('hari', 'ASC')->get();
        if (isset($request->jadwaldokter)) {
            $jadwal = JadwalDokter::find($request->jadwaldokter);
            $request['kodePoli'] = $jadwal->kodesubspesialis;
            $request['kodeDokter'] = $jadwal->kodedokter;
            $request['hari'] = $jadwal->hari;
            $request['jamPraktek'] = $jadwal->jadwal;
            $response = $this->antrian_poliklinik($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            }
        }
        return view('bpjs.antrian.antrian_per_dokter', [
            'antrians' => $antrians,
            'jadwaldokter' => $jadwaldokter,
            'request' => $request,
        ]);
    }
    public function antrianPoliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal);
            if ($request->kodepoli != null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->get();
            }
            if ($request->kodedokter != null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->where('kodedokter', $request->kodedokter)->get();
            }
            if ($request->kodepoli == null && $request->kodedokter == null) {
                $antrians = $antrians->where('method', '!=', 'Offline')->get();
            }
        }
        $polis = Poliklinik::where('status', 1)->get();
        $dokters = Dokter::where('kode_dokter_jkn', "!=", null)
            ->where('unit', "!=", null)
            ->get();
        if (isset($request->kodepoli)) {
            $poli = Unit::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = Dokter::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        return view(
            'simrs.poliklinik.poliklinik_antrian',
            compact([
                'antrians',
                'request',
                'polis',
                'dokters'
            ])
        );
    }

    // API FUNCTION
    public function api()
    {
        $api = IntegrasiApi::where('name', 'Antrian BPJS')->first();
        $data['base_url'] =  $api->base_url;
        $data['user_id'] = $api->user_id;
        $data['user_key'] = $api->user_key;
        $data['secret_key'] = $api->secret_key;
        return json_decode(json_encode($data));
    }
    public function signature()
    {
        $api = IntegrasiApi::where('name', 'Antrian BPJS')->first();
        $cons_id = $api->user_id;
        $secretKey = $api->secret_key;
        $userkey = $api->user_key;
        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $cons_id . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);
        $data['user_key'] =  $userkey;
        $data['x-cons-id'] = $cons_id;
        $data['x-timestamp'] = $tStamp;
        $data['x-signature'] = $encodedSignature;
        $data['decrypt_key'] = $cons_id . $secretKey . $tStamp;
        return $data;
    }
    public function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }
    public function response_decrypt($response, $signature)
    {
        $code = json_decode($response->body())->metadata->code;
        $message = json_decode($response->body())->metadata->message;
        if ($code == 200 || $code == 1) {
            $response = json_decode($response->body())->response ?? null;
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response);
            $data = json_decode($decrypt);
            if ($code == 1)
                $code = 200;
            return $this->sendResponse($data, $code);
        } else {
            $response = json_decode($response);
            return json_decode(json_encode($response));
        }
    }
    public function response_no_decrypt($response)
    {
        $response = json_decode($response);
        return json_decode(json_encode($response));
    }
    // API BPJS
    public function ref_poli()
    {
        $url = $this->api()->base_url . "ref/poli";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_dokter()
    {
        $url = $this->api()->base_url . "ref/dokter";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_jadwal_dokter(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodepoli" => "required",
            "tanggal" =>  "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->api()->base_url . "jadwaldokter/kodepoli/" . $request->kodepoli . "/tanggal/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_poli_fingerprint()
    {
        $url = $this->api()->base_url . "ref/poli/fp";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_pasien_fingerprint(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "jenisIdentitas" => "required",
            "noIdentitas" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url = $this->api()->base_url . "ref/pasien/fp/identitas/" . $request->jenisIdentitas . "/noidentitas/" . $request->noIdentitas;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function taskid_antrean(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->api()->base_url . "antrean/getlisttask";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function dashboard_tanggal(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggal" =>  "required|date|date_format:Y-m-d",
            "waktu" => "required|in:rs,server",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->api()->base_url . "dashboard/waktutunggu/tanggal/" . $request->tanggal . "/waktu/" . $request->waktu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_no_decrypt($response, $signature);
    }
    public function dashboard_bulan(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "bulan" =>  "required|date_format:m",
            "tahun" =>  "required|date_format:Y",
            "waktu" => "required|in:rs,server",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->api()->base_url . "dashboard/waktutunggu/bulan/" . $request->bulan . "/tahun/" . $request->tahun . "/waktu/" . $request->waktu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_no_decrypt($response);
    }
    public function antrian_tanggal(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggal" =>  "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->api()->base_url . "antrean/pendaftaran/tanggal/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_kodebooking(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodeBooking" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->api()->base_url . "antrean/pendaftaran/kodebooking/" . $request->kodeBooking;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_belum_dilayani(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggal" =>  "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->api()->base_url . "antrean/pendaftaran/aktif";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_pendaftaran(Request $request)
    {
        $url = $this->api()->base_url . "antrean/pendaftaran/aktif";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_poliklinik(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodePoli" =>  "required",
            "kodeDokter" =>  "required",
            "hari" =>  "required",
            "jamPraktek" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->api()->base_url . "antrean/pendaftaran/kodepoli/" . $request->kodePoli . "/kodedokter/" . $request->kodeDokter . "/hari/" . $request->hari . "/jampraktek/" . $request->jamPraktek;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
}
