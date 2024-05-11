<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenDokter;
use App\Models\AsesmenPerawat;
use App\Models\Dokter;
use App\Models\FileUploadPasien;
use App\Models\IntegrasiApi;
use App\Models\JadwalDokter;
use App\Models\Jaminan;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\ResepObat;
use App\Models\ResepObatDetail;
use App\Models\Unit;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends APIController
{
    public function daftar(Request $request)
    {
        return view('sim.daftar', compact([
            'request',
        ]));
    }
    public function daftarbpjs(Request $request)
    {
        $request['button'] = "Cek Nomor Kartu";
        return view('sim.daftarbpjs', compact([
            'request',
        ]));
    }
    public function prosesdaftarbpjs(Request $request)
    {
        $jadwals = null;
        $suratkontrols = null;
        $rujukans = null;
        $api = new VclaimController();
        $request['button'] = "Cek Nomor Kartu";
        if ($request->nomorkartu && $request->nohp && empty($request->nik)) {
            $request['tanggal'] = now()->format('Y-m-d');
            $res = $api->peserta_nomorkartu($request);
            if ($res->metadata->code == 200) {
                $peserta = $res->response->peserta;
                $request['nik'] = $peserta->nik;
                $request['nama'] = $peserta->nama;
                $request['nomorkartu'] = $peserta->noKartu;
                $request['norm'] = $peserta->mr->noMR;
                if ($peserta->mr->noMR == null) {
                    $request['error'] = "Anda belum terdaftar sebagai pasien klinik. Silahkan daftar secara ditempat.";
                }
            } else {
                $request['error'] = $res->metadata->message;
            }
            $request['button'] = "Cek Jadwal Dokter";
        }
        if ($request->nik) {
            $request['button'] = "Cek Jadwal Rujukan / Surat Kontrol";
        }
        if ($request->tanggalperiksa) {
            $hari = Carbon::parse($request->tanggalperiksa)->dayOfWeek;
            $jadwals = JadwalDokter::where('hari', $hari)->get();
            $request['button'] = "Cek Jadwal Rujukan / Surat Kontrol";
            if ($jadwals->count() == 0) {
                $request['warning'] = "Tidak ada jadwal hari terserbut.";
            }
            if ($request->jeniskunjungan) {
                switch ($request->jeniskunjungan) {
                    case '1':
                        $res = $api->rujukan_peserta($request);
                        if ($res->metadata->code == 200) {
                            foreach ($res->response->rujukan as  $value) {
                                $waktu = Carbon::parse($value->tglKunjungan)->diffInDays(now());
                                if ($waktu < 90) {
                                    $rujukans[] = $value;
                                }
                            }
                            if ($rujukans == null) {
                                $request['warning'] = "Rujukan Tidak Ada / Sudah Kadaluarsa.";
                            }
                        } else {
                            $request['warning'] = $res->metadata->message;
                        }
                        break;

                    case '3':
                        $request['bulan'] = Carbon::parse($request->tanggalperiksa)->month;
                        $request['tahun'] = Carbon::parse($request->tanggalperiksa)->year;
                        $request['formatfilter'] = 2;
                        $res = $api->suratkontrol_peserta($request);
                        if ($res->metadata->code == 200) {
                            foreach ($res->response->list as  $value) {
                                $suratkontrols[] = $value;
                            }
                            if ($suratkontrols == null) {
                                $request['warning'] = "Surat Kontrol Tidak Ada / Sudah Digunakan Semua.";
                            }
                        } else {
                            $request['warning'] = $res->metadata->message;
                        }
                        break;

                    case '4':
                        $res = $api->rujukan_rs_peserta($request);
                        if ($res->metadata->code == 200) {
                            foreach ($res->response->rujukan as  $value) {
                                $waktu = Carbon::parse($value->tglKunjungan)->diffInDays(now());
                                if ($waktu < 90) {
                                    $rujukans[] = $value;
                                }
                            }
                            if ($rujukans == null) {
                                $request['warning'] = "Rujukan Tidak Ada / Sudah Kadaluarsa.";
                            }
                        } else {
                            $request['warning'] = $res->metadata->message;
                        }
                        break;
                    default:
                        break;
                }
            }
            if ($rujukans || $suratkontrols) {
                $request['button'] = "Daftar";
            }
        }
        if ($request->nomorreferensi && $request->jeniskunjungan && $request->jadwal) {
            $jadwal = JadwalDokter::find($request->jadwal);
            $request['kodepoli'] = $jadwal->kodesubspesialis;
            $request['namapoli'] = $jadwal->namasubspesialis;
            $request['namadokter'] = $jadwal->namadokter;
            $request['kodedokter'] = $jadwal->kodedokter;
            $request['jampraktek'] = $jadwal->jadwal;
            $request['button'] = "Daftar";
            $request['jenispasien'] = "JKN";
            $request['pasienbaru'] = 0;
            $request['method'] = "WEB";
            if ($request->jeniskunjungan == 3) {
                $request['nomorsuratkontrol'] = $request->nomorreferensi;
            } else {
                $request['nomorrujukan'] = $request->nomorreferensi;
            }
            $request['keterangan'] = "Silahkan datang dan checkin sesuai dengan jadwal dokter yang anda pilih.";
            $res = $this->ambil_antrian($request);
            if ($res->metadata->code == 200) {
                $url = route('statusantrian') . "?kodebooking=" . $request->kodebooking;
                return redirect()->to($url);
            } else {
                $request['warning'] = $res->metadata->message;
                $request['taggalperiksa'] = null;
                $request['jadwal'] = null;
                $request['nomorreferensi'] = null;
                $request['jeniskunjungan'] = null;
            }
        }
        return view('sim.daftarbpjs', compact([
            'request',
            'jadwals',
            'rujukans',
            'suratkontrols',
        ]));
    }
    public function daftarumum(Request $request)
    {
        $request['button'] = "Cek NIK Pasien";
        return view('sim.daftarumum', compact([
            'request',
        ]));
    }
    public function prosesdaftarumum(Request $request)
    {
        $jadwals = null;
        $suratkontrols = null;
        $rujukans = null;
        $api = new VclaimController();
        $request['button'] = "Cek NIK Pasien";
        if ($request->nik && $request->nohp && empty($request->nomorkartu)) {
            $request['button'] = "Cek Jadwal Dokter";
            $request['tanggal'] = now()->format('Y-m-d');
            $res = $api->peserta_nik($request);
            if ($res->metadata->code == 200) {
                $peserta = $res->response->peserta;
                $request['nik'] = $peserta->nik;
                $request['nama'] = $peserta->nama;
                $request['nomorkartu'] = $peserta->noKartu;
                $request['norm'] = $peserta->mr->noMR;
                if ($peserta->mr->noMR == null) {
                    $request['norm'] = '000000';
                }
            } else {
                $request['error'] = $res->metadata->message;
            }
        }
        if ($request->tanggalperiksa) {
            $hari = Carbon::parse($request->tanggalperiksa)->dayOfWeek;
            $jadwals = JadwalDokter::where('hari', $hari)->get();
            $request['button'] = "Daftar";
            if ($jadwals->count() == 0) {
                $request['button'] = "Cek Jadwal Dokter";
                $request['warning'] = 'Tidak ada jadwal dokter dihari tersebut';
            }
        }
        if ($request->tanggalperiksa && $request->jadwal) {
            $jadwal = JadwalDokter::find($request->jadwal);
            $request['kodepoli'] = $jadwal->kodesubspesialis;
            $request['namapoli'] = $jadwal->namasubspesialis;
            $request['namadokter'] = $jadwal->namadokter;
            $request['kodedokter'] = $jadwal->kodedokter;
            $request['jampraktek'] = $jadwal->jadwal;
            $request['jenispasien'] = "NON-JKN";
            $request['jeniskunjungan'] = "2";
            $request['keterangan'] = "Silahkan datang dan checkin sesuai dengan jadwal dokter yang anda pilih.";
            if ($request->norm == '000000') {
                $request['pasienbaru'] = 1;
            } else {
                $request['pasienbaru'] = 0;
            }
            $request['method'] = "WEB";
            $res = $this->ambil_antrian($request);
            if ($res->metadata->code == 200) {
                $url = route('statusantrian') . "?kodebooking=" . $request->kodebooking;
                return redirect()->to($url);
            } else {
                $request['warning'] = $res->metadata->message;
            }
        }
        return view('sim.daftarumum', compact([
            'request',
            'jadwals',
            'rujukans',
            'suratkontrols',
        ]));
    }
    public function statusantrian(Request $request)
    {
        $antrian = null;
        $res = null;
        if ($request->kodebooking) {
            $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
            if ($antrian) {
                $request['kodebooking'] = $antrian->kodebooking;
                $res = $this->sisa_antrian($request);
            } else {
                $request['error'] = "Kodebooking antrian tidak ditemukan.";
            }
        }
        return view('sim.antrian_status', compact([
            'request',
            'res',
            'antrian',
        ]));
    }
    public function displayantrian()
    {
        return view('sim.display_antrian');
    }
    public function displaynomor()
    {
        $antrian = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->orderBy('angkaantrean', 'ASC')->get();
        $data = [
            "pendaftaran" => $antrian->where('taskid', 2)->first()->angkaantrean ?? "-",
            "pendaftarankodebooking" => $antrian->where('taskid', 2)->first()->kodebooking ?? "-",
            "pendaftaranstatus" => $antrian->where('taskid', 2)->first()->panggil ?? "-",
            "pendaftaranselanjutnya" => $antrian->where('taskid', 1)->pluck('kodebooking', 'nomorantrean'),
            "poliklinik" => $antrian->where('taskid', 4)->first()->angkaantrean ?? "-",
            "poliklinikkodebooking" => $antrian->where('taskid', 4)->first()->kodebooking ?? "-",
            "poliklinikstatus" => $antrian->where('taskid', 4)->first()->panggil ?? "-",
            "poliklinikselanjutnya" => $antrian->where('taskid', 3)->pluck('kodebooking', 'nomorantrean',),
            // "farmasi" => $antrian->where('taskid', 7)->first()->angkaantrean ?? "-",
            // "farmasistatus" => $antrian->where('taskid', 7)->first()->panggil ?? "-",
            // "farmasikodebooking" => $antrian->where('taskid', 7)->first()->kodebooking ?? "-",
            // "farmasiselanjutnya" => $antrian->where('taskid', 6)->first()->angkaantrean ?? "-",
        ];
        return $this->sendResponse($data, 200);
    }
    public function updatenomorantrean(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            $antrian->update([
                'panggil' => 1,
            ]);
            return $this->sendResponse('Antrian telah dipanggil', 200);
        } else {
            return $this->sendError('Antrian tidak ditemukan', 400);
        }
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
        if (isset($request->waktu)) {
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
        ]));
    }
    public function dashboardBulanAntrian(Request $request)
    {
        $antrians = null;
        $tanggalantrian = null;
        $jumlahantrian = null;
        $waktuantrian = null;
        if (isset($request->tanggal)) {
            $tanggal = explode('-', $request->tanggal);
            $request['tahun'] = $tanggal[0];
            $request['bulan'] = $tanggal[1];
            $response =  $this->dashboard_bulan($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);
                foreach ($antrians as  $value) {
                    $tanggalantrian[] = $value->tanggal;
                    $jumlahantrian[] = $value->jumlah_antrean;
                    $waktuantrian[] = $value->avg_waktu_task1 + $value->avg_waktu_task2 + $value->avg_waktu_task3 + $value->avg_waktu_task4 + $value->avg_waktu_task5 + $value->avg_waktu_task6;
                }
                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.dashboard_bulan_index', compact([
            'request',
            'antrians',
            'tanggalantrian',
            'jumlahantrian',
            'waktuantrian',
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
            }
        }
        return view('bpjs.antrian.antrian_per_tanggal', compact(['request', 'antrians']));
    }
    public function monitoringAntrian(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $response = $this->antrian_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
                foreach ($antrians as $key => $value) {
                    $request['kodebooking'] = $value->kodebooking;
                    $taskid = $this->taskid_antrean($request);
                    if ($taskid->metadata->code == 200) {
                        $dataid = $taskid->response;
                        $value->taskid = $dataid;
                    } else {
                        $value->taskid = [];
                    }
                    // dd(count($value->taskid));
                }
                // dd($antrians);
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            }
        }
        return view('bpjs.antrian.monitoring_antrian', compact(['request', 'antrians']));
    }
    public function antrianPerKodebooking(Request $request)
    {
        $antrian = null;
        $taskid = null;
        if ($request->kodebooking) {
            $request['kodeBooking'] = $request->kodebooking;
            $response = $this->antrian_kodebooking($request);
            if ($response->metadata->code == 200) {
                $antrian = $response->response[0];
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }

            $res =  $this->taskid_antrean($request);
            if ($res->metadata->code == 200) {
                $taskid = $res->response;
            }
        }
        return view('bpjs.antrian.antrian_per_kodebooking', compact([
            'request',
            'antrian',
            'taskid',
        ]));
    }
    public function antrianKodebookingLanjut(Request $request)
    {
        // $request['waktu'] = now();
        // $res = $this->update_antrean($request);
        $request['keterangan'] = "Batal";
        $res = $this->batal_antrean($request);
        Alert::success('Success',  $res->metadata->message);
        return redirect()->back();
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
        try {
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
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
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
    public function tambah_antrean(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "jenispasien" =>  "required",
            "nomorkartu" =>  "required|digits:13|numeric",
            "nik" =>  "required|digits:16|numeric",
            "nohp" => "required|numeric",
            "kodepoli" =>  "required",
            "namapoli" =>  "required",
            "pasienbaru" =>  "required",
            "norm" =>  "required",
            "tanggalperiksa" =>  "required|date|date_format:Y-m-d",
            "kodedokter" =>  "required",
            "namadokter" =>  "required",
            "jampraktek" =>  "required",
            "jeniskunjungan" => "required",
            // "nomorreferensi" =>  "required",
            "nomorantrean" =>  "required",
            "angkaantrean" =>  "required",
            "estimasidilayani" =>  "required",
            "sisakuotajkn" =>  "required",
            "kuotajkn" => "required",
            "sisakuotanonjkn" => "required",
            "kuotanonjkn" => "required",
            "keterangan" =>  "required",
            "nama" =>  "required",

        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        try {
            $url =  $this->api()->base_url .  "antrean/add";
            $signature = $this->signature();
            $response = Http::withHeaders($signature)->post(
                $url,
                [
                    "kodebooking" => $request->kodebooking,
                    "jenispasien" => $request->jenispasien,
                    "nomorkartu" => $request->nomorkartu,
                    "nik" => $request->nik,
                    "nohp" => $request->nohp,
                    "kodepoli" => $request->kodepoli,
                    "namapoli" => $request->namapoli,
                    "pasienbaru" => $request->pasienbaru,
                    "norm" => $request->norm,
                    "tanggalperiksa" => $request->tanggalperiksa,
                    "kodedokter" => $request->kodedokter,
                    "namadokter" => $request->namadokter,
                    "jampraktek" => $request->jampraktek,
                    "jeniskunjungan" => $request->jeniskunjungan,
                    "nomorreferensi" => $request->nomorreferensi,
                    "nomorantrean" => $request->nomorantrean,
                    "angkaantrean" => $request->angkaantrean,
                    "estimasidilayani" => $request->estimasidilayani,
                    "sisakuotajkn" => $request->sisakuotajkn,
                    "kuotajkn" => $request->kuotajkn,
                    "sisakuotanonjkn" => $request->sisakuotanonjkn,
                    "kuotanonjkn" => $request->kuotanonjkn,
                    "keterangan" => $request->keterangan,
                ]
            );
            return $this->response_decrypt($response, $signature);
        } catch (\Throwable $th) {
            return $this->sendError('Tidak terhubung ke jaringan', 500);
        }
    }
    public function tambah_antrean_farmasi(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "jenisresep" =>  "required",
            "nomorantrean" =>  "required",
            "keterangan" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->api()->base_url . "antrean/farmasi/add";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "jenisresep" => $request->jenisresep,
                "nomorantrean" => $request->nomorantrean,
                "keterangan" => $request->keterangan,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function update_antrean(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "taskid" =>  "required",
            "waktu" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url =  $this->api()->base_url .  "antrean/updatewaktu";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "taskid" => $request->taskid,
                "waktu" => $request->waktu,
                "jenisresep" => $request->jenisresep,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function batal_antrean(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "keterangan" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url =  $this->api()->base_url .  "antrean/batal";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "keterangan" => $request->keterangan,
            ]
        );
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
    // WS BPJS
    public function token(Request $request)
    {
        if (Auth::attempt(['username' => $request->header('x-username'), 'password' => $request->header('x-password')])) {
            $user = Auth::user();
            $data['token'] =  $user->createToken('MyApp')->plainTextToken;
            return $this->sendResponse($data, 200);
        } else {
            return $this->sendError("Unauthorized (Username dan Password Salah)",  401);
        }
    }
    public function status_antrian(Request $request)
    {
        // validator
        $validator = Validator::make(request()->all(), [
            "kodepoli" => "required",
            "kodedokter" => "required",
            "tanggalperiksa" => "required|date",
            "jampraktek" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        // check tanggal backdate
        $request['tanggal'] = $request->tanggalperiksa;
        if (Carbon::parse($request->tanggalperiksa)->endOfDay()->isPast()) {
            return $this->sendError("Tanggal periksa sudah terlewat", 404);
        }
        // get jadwal poliklinik dari simrs
        $jadwal = JadwalDokter::where("hari",  Carbon::parse($request->tanggalperiksa)->dayOfWeek)
            ->where("kodepoli", $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->where("jadwal", $request->jampraktek)
            ->first();
        // tidak ada jadwal
        if (!isset($jadwal)) {
            return $this->sendError("Tidak ada jadwal poliklinik dihari tersebut", 404);
        }
        if ($jadwal->libur == 1) {
            return $this->sendError("Jadwal Dokter dihari tersebut sedang diliburkan.",  403);
        }
        // get hitungan antrian
        $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodepoli', $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->where('jampraktek', $request->jampraktek)
            ->where('taskid', '!=', 99)
            ->count();
        // cek kapasitas pasien
        if ($antrians >= $jadwal->kapasitaspasien) {
            return $this->sendError("Kuota Dokter Telah Penuh",  201);
        }
        //  get nomor antrian
        $antreanpanggil =  Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', 4)
            ->first();
        // get jumlah antrian jkn dan non-jkn
        $antrianjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', '!=', 99)
            ->where('kodedokter', $request->kodedokter)
            ->where('jenispasien', "JKN")->count();
        $antriannonjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodedokter', $request->kodedokter)
            ->where('taskid', '!=', 99)
            ->where('jenispasien', "NON-JKN")->count();
        $response = [
            "namapoli" => $jadwal->namasubspesialis,
            "namadokter" => $jadwal->namadokter,
            "totalantrean" => $antrians,
            "sisaantrean" => $jadwal->kapasitaspasien - $antrians,
            "antreanpanggil" => $antreanpanggil->nomorantrean ?? 0,
            "sisakuotajkn" => round($jadwal->kapasitaspasien * 80 / 100) -  $antrianjkn,
            "kuotajkn" => round($jadwal->kapasitaspasien * 80 / 100),
            "sisakuotanonjkn" => round($jadwal->kapasitaspasien * 20 / 100) - $antriannonjkn,
            "kuotanonjkn" =>  round($jadwal->kapasitaspasien * 20 / 100),
            "keterangan" => "Informasi antrian poliklinik",
            "jadwal_id" => $jadwal->id,
        ];
        return $this->sendResponse($response, 200);
    }
    public function status_antrian_mjkn(Request $request)
    {
        // validator
        $validator = Validator::make(request()->all(), [
            "kodepoli" => "required",
            "kodedokter" => "required",
            "tanggalperiksa" => "required|date",
            "jampraktek" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        // check tanggal backdate
        $request['tanggal'] = $request->tanggalperiksa;
        if (Carbon::parse($request->tanggalperiksa)->endOfDay()->isPast()) {
            return $this->sendError("Tanggal periksa sudah terlewat", 404);
        }
        // get jadwal poliklinik dari simrs
        $jadwal = JadwalDokter::where("hari",  Carbon::parse($request->tanggalperiksa)->dayOfWeek)
            ->where("kodepoli", $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->where("jadwal", $request->jampraktek)
            ->first();
        // tidak ada jadwal
        if (!isset($jadwal)) {
            return $this->sendError("Tidak ada jadwal poliklinik dihari tersebut", 404);
        }
        if ($jadwal->libur == 1) {
            return $this->sendError("Jadwal Dokter dihari tersebut sedang diliburkan.",  403);
        }
        // get hitungan antrian
        $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodepoli', $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->where('jampraktek', $request->jampraktek)
            ->where('taskid', '!=', 99)
            ->count();
        // cek kapasitas pasien
        if ($antrians >= $jadwal->kapasitaspasien) {
            return $this->sendError("Kuota Dokter Telah Penuh",  201);
        }
        //  get nomor antrian
        $antreanpanggil =  Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', 4)
            ->first();
        // get jumlah antrian jkn dan non-jkn
        $antrianjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', '!=', 99)
            ->where('kodedokter', $request->kodedokter)
            ->where('jenispasien', "JKN")->count();
        $antriannonjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodedokter', $request->kodedokter)
            ->where('taskid', '!=', 99)
            ->where('jenispasien', "NON-JKN")->count();
        $response = [
            "namapoli" => $jadwal->namasubspesialis,
            "namadokter" => $jadwal->namadokter,
            "totalantrean" => $antrians,
            "sisaantrean" => $jadwal->kapasitaspasien - $antrians,
            "antreanpanggil" => $antreanpanggil->nomorantrean ?? 0,
            "sisakuotajkn" => round($jadwal->kapasitaspasien * 80 / 100) -  $antrianjkn,
            "kuotajkn" => round($jadwal->kapasitaspasien * 80 / 100),
            "sisakuotanonjkn" => round($jadwal->kapasitaspasien * 20 / 100) - $antriannonjkn,
            "kuotanonjkn" =>  round($jadwal->kapasitaspasien * 20 / 100),
            "keterangan" => "Informasi antrian poliklinik",
        ];
        return $this->sendResponse($response, 200);
    }
    public function ambil_antrian(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required|numeric|digits:13",
            "nik" => "required|numeric|digits:16",
            "nohp" => "required",
            "kodepoli" => "required",
            // "norm" => "required",
            "tanggalperiksa" => "required",
            "kodedokter" => "required",
            "jampraktek" => "required",
            "jeniskunjungan" => "required|numeric",
            // "nomorreferensi" => "numeric",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $request['kodebooking'] = strtoupper(uniqid());
        $antiranhari = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->count();
        $request['nomorantrean'] = 'A' . $antiranhari + 1;
        $request['angkaantrean'] =  $antiranhari + 1;
        $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
        $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(5 * ($antiranhari + 1));
        $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
        $statusantrian = $this->status_antrian($request);
        if ($statusantrian->metadata->code == 200) {
            $request['sisakuotajkn']  = $statusantrian->response->sisakuotajkn;
            $request['kuotajkn']  = $statusantrian->response->kuotajkn;
            $request['sisakuotanonjkn']  = $statusantrian->response->sisakuotanonjkn;
            $request['kuotanonjkn']  = $statusantrian->response->kuotanonjkn;
            $request['jadwal_id']  = $statusantrian->response->jadwal_id;
        } else {
            return $this->sendError($statusantrian->metadata->message, 400);
        }
        $request['keterangan'] = $request->keterangan;
        $res = $this->tambah_antrean($request);
        if ($res->metadata->code == 200) {
            $request['status'] = 1;
            Antrian::create($request->all());
            try {
                $wapi = new WhatsappController();
                if ($request->method != "OFFLINE") {
                    switch ($request->jeniskunjungan) {
                        case 1:
                            $jeniskunjungan = "Rujukan FKTP";
                            break;

                        case 2:
                            $jeniskunjungan = "Umum";
                            break;

                        case 3:
                            $jeniskunjungan = "Surat Kontrol";
                            break;

                        case 4:
                            $jeniskunjungan = "Rujukan Antar RS";
                            break;

                        default:
                            $jeniskunjungan = "-";
                            break;
                    }
                    $request['keterangan'] = "Peserta harap datang 60 menit lebih awal dari jadwal praktik dokter. Lakukan check-in pada anjungan antrian untuk mencetak tiket antrian sebelum menuju loket pendaftaran. (TIKET MOHON TIDAK HILANG SAMPAI DENGAN SELESAI PELAYANAN)";
                    $request['message'] = "*Antrian Berhasil di Daftarkan*\nAntrian anda berhasil didaftarkan melalui Layanan " . $request->method . " KLINIK LMC dengan data sebagai berikut : \n\n*Kode Antrian :* " . $request->kodebooking .  "\n*Angka Antrian :* " . $request->angkaantrean .  "\n*Nomor Antrian :* " . $request->nomorantrean . "\n*Jenis Pasien :* " . $request->jenispasien .  "\n*Jenis Kunjungan :* " . $jeniskunjungan .  "\n\n*Nama :* " . $request->nama . "\n*Poliklinik :* " . $request->namapoli  . "\n*Dokter :* " . $request->namadokter  .  "\n*Jam Praktek :* " . $request->jampraktek  .  "\n*Tanggal Periksa :* " . $request->tanggalperiksa . "\n\n*Keterangan :* " . $request->keterangan  .  "\n\nLink Kodebooking QR Code :\nhttps://luthfimedicalcenter.com/statusantrian?kodebooking=" . $request->kodebooking . "\n\nTerima kasih. \nSalam Hangat dan Sehat Selalu.\nUntuk pertanyaan & pengaduan silahkan hubungi :\n*Customer Care KLINIK LMC (0231)8850943 / 0823 1169 6919*";
                    $request['number'] = $request->nohp;
                    $wapi->send_message($request);
                }
                // sholawat
                $sholawat = "اَللّٰهُمَّ صَلِّ عَلٰى سَيِّدِنَا مُحَمَّدٍ، طِبِّ الْقُلُوْبِ وَدَوَائِهَا، وَعَافِيَةِ الْاَبْدَانِ وَشِفَائِهَا، وَنُوْرِ الْاَبْصَارِ وَضِيَائِهَا، وَعَلٰى اٰلِهِ وَصَحْبِهِ وَسَلِّمْ";
                $request['message'] = $sholawat;
                $request['number'] = '6289529909036@c.us';
                $wapi->send_message($request);
                // notif group
                $request['message'] = "Berhasil daftar antrian method " . $request->method . ".\nAngka antrian : " . $request->angkaantrean . "\nKodebooking : " . $request->kodebooking .  "\nJenis Pasien : " . $request->jenispasien . "\nNama " . $request->nama . "\nTanggal Periksa " . $request->tanggalperiksa . "\nDokter : " . $request->namadokter;
                $request['number'] = "120363170262520539";
                $wapi->send_message_group($request);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $data = [
                'nomorantrean' => $request->nomorantrean,
                'angkaantrean' => $request->angkaantrean,
                'kodebooking' => $request->kodebooking,
                'norm' => $request->norm,
                'namapoli' => $request->namapoli,
                'namadokter' => $request->namadokter,
                'estimasidilayani' => $request->estimasidilayani,
                'sisakuotajkn' => $request->sisakuotajkn,
                'kuotajkn' => $request->kuotajkn,
                'sisakuotanonjkn' => $request->sisakuotanonjkn,
                'kuotanonjkn' => $request->kuotanonjkn,
                'keterangan' => $request->keterangan,
            ];
            return $this->sendResponse($data, 200);
        } else {
            return $this->sendError($res->metadata->message, 400);
        }
    }
    public function ambil_antrian_mjkn(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required|numeric|digits:13",
            "nik" => "required|numeric|digits:16",
            "nohp" => "required",
            "kodepoli" => "required",
            // "norm" => "required",
            "tanggalperiksa" => "required",
            "kodedokter" => "required",
            "jampraktek" => "required",
            "jeniskunjungan" => "required|numeric",
            // "nomorreferensi" => "numeric",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $pasien = Pasien::where('nik', $request->nik)
            ->orWhere('nomorkartu', $request->nomorkartu)
            ->first();
        $request['keterangan'] = 'Pendaftaran melalui mjkn, silahkan checkin pada mesin anjungan di klinik LMC';
        if ($pasien) {
            $request['norm'] = $pasien->norm;
            $request['pasienbaru'] = 0;
        } else {
            $request['pasienbaru'] = 1;
            $request['nama'] = 'PASIEN BARU MJKN';
            // return $this->sendError('Mohon maaf untuk pasien baru silahkan melakukan pendaftaran secara langsung', 400);
        }
        $request['kodebooking'] = strtoupper(uniqid());
        $request['jenispasien'] = "NON-JKN";
        $request['method'] = "Mobile JKN";
        $antiranhari = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->count();
        $request['nomorantrean'] = 'A' . $antiranhari + 1;
        $request['angkaantrean'] =  $antiranhari + 1;
        $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
        $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(5 * ($antiranhari + 1));
        $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
        $statusantrian = $this->status_antrian($request);
        if ($statusantrian->metadata->code == 200) {
            $request['namapoli']  = $statusantrian->response->namapoli;
            $request['namadokter']  = $statusantrian->response->namadokter;
            $request['sisakuotajkn']  = $statusantrian->response->sisakuotajkn;
            $request['kuotajkn']  = $statusantrian->response->kuotajkn;
            $request['sisakuotanonjkn']  = $statusantrian->response->sisakuotanonjkn;
            $request['kuotanonjkn']  = $statusantrian->response->kuotanonjkn;
            $request['jadwal_id']  = $statusantrian->response->jadwal_id;
        } else {
            return $this->sendError($statusantrian->metadata->message, 400);
        }
        $request['keterangan'] = $request->keterangan;
        $res = $this->tambah_antrean($request);
        if ($res->metadata->code == 200) {
            $request['status'] = 1;
            Antrian::create($request->all());
            try {
                $wapi = new WhatsappController();
                if ($request->method != "OFFLINE") {
                    switch ($request->jeniskunjungan) {
                        case 1:
                            $jeniskunjungan = "Rujukan FKTP";
                            break;

                        case 2:
                            $jeniskunjungan = "Umum";
                            break;

                        case 3:
                            $jeniskunjungan = "Surat Kontrol";
                            break;

                        case 4:
                            $jeniskunjungan = "Rujukan Antar RS";
                            break;

                        default:
                            $jeniskunjungan = "-";
                            break;
                    }
                    $request['keterangan'] = "Peserta harap datang 60 menit lebih awal dari jadwal praktik dokter. Lakukan check-in pada anjungan antrian untuk mencetak tiket antrian sebelum menuju loket pendaftaran. (TIKET MOHON TIDAK HILANG SAMPAI DENGAN SELESAI PELAYANAN)";
                    $request['message'] = "*Antrian Berhasil di Daftarkan*\nAntrian anda berhasil didaftarkan melalui Layanan " . $request->method . " KLINIK LMC dengan data sebagai berikut : \n\n*Kode Antrian :* " . $request->kodebooking .  "\n*Angka Antrian :* " . $request->angkaantrean .  "\n*Nomor Antrian :* " . $request->nomorantrean . "\n*Jenis Pasien :* " . $request->jenispasien .  "\n*Jenis Kunjungan :* " . $jeniskunjungan .  "\n\n*Nama :* " . $request->nama . "\n*Poliklinik :* " . $request->namapoli  . "\n*Dokter :* " . $request->namadokter  .  "\n*Jam Praktek :* " . $request->jampraktek  .  "\n*Tanggal Periksa :* " . $request->tanggalperiksa . "\n\n*Keterangan :* " . $request->keterangan  .  "\n\nLink Kodebooking QR Code :\nhttps://luthfimedicalcenter.com/statusantrian?kodebooking=" . $request->kodebooking . "\n\nTerima kasih. \nSalam Hangat dan Sehat Selalu.\nUntuk pertanyaan & pengaduan silahkan hubungi :\n*Customer Care KLINIK LMC (0231)8850943 / 0823 1169 6919*";
                    $request['number'] = $request->nohp;
                    $wapi->send_message($request);
                }
                // sholawat
                $sholawat = "اَللّٰهُمَّ صَلِّ عَلٰى سَيِّدِنَا مُحَمَّدٍ، طِبِّ الْقُلُوْبِ وَدَوَائِهَا، وَعَافِيَةِ الْاَبْدَانِ وَشِفَائِهَا، وَنُوْرِ الْاَبْصَارِ وَضِيَائِهَا، وَعَلٰى اٰلِهِ وَصَحْبِهِ وَسَلِّمْ";
                $request['message'] = $sholawat;
                $request['number'] = '6289529909036@c.us';
                $wapi->send_message($request);
                // notif group
                $request['message'] = "Berhasil daftar antrian method " . $request->method . ".\nAngka antrian : " . $request->angkaantrean . "\nKodebooking : " . $request->kodebooking .  "\nJenis Pasien : " . $request->jenispasien . "\nNama " . $request->nama . "\nTanggal Periksa " . $request->tanggalperiksa . "\nDokter : " . $request->namadokter;
                $request['number'] = "120363170262520539";
                $wapi->send_message_group($request);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $data = [
                'nomorantrean' => $request->nomorantrean,
                'angkaantrean' => $request->angkaantrean,
                'kodebooking' => $request->kodebooking,
                'norm' => $request->norm,
                'namapoli' => $request->namapoli,
                'namadokter' => $request->namadokter,
                'estimasidilayani' => $request->estimasidilayani,
                'sisakuotajkn' => $request->sisakuotajkn,
                'kuotajkn' => $request->kuotajkn,
                'sisakuotanonjkn' => $request->sisakuotanonjkn,
                'kuotanonjkn' => $request->kuotanonjkn,
                'keterangan' => $request->keterangan,
            ];
            return $this->sendResponse($data, 200);
        } else {
            return $this->sendError($res->metadata->message, 400);
        }
    }
    public function sisa_antrian(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $sisaantrian = Antrian::where('tanggalperiksa', $antrian->tanggalperiksa)->where('taskid', "<=", 3)->count();
        $antreanpanggil = Antrian::where('tanggalperiksa', $antrian->tanggalperiksa)->where('taskid', 4)->first()->nomorantrean ?? 'Belum ada yang dipanggil';
        $waktutunggu = 300 +  300 * ($sisaantrian - 1);
        $data = [
            'nomorantrean' => $antrian->nomorantrean,
            'namapoli' => $antrian->namapoli,
            'namadokter' => $antrian->namadokter,
            'sisaantrean' => $sisaantrian - 1,
            'antreanpanggil' => $antreanpanggil,
            'waktutunggu' => $waktutunggu,
            'keterangan' => $antrian->keterangan,
        ];
        return $this->sendResponse($data, 200);
    }
    public function batal_antrian(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "keterangan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (isset($antrian)) {
            $response = $this->batal_antrean($request);
            $antrian->update([
                "taskid" => 99,
                "keterangan" => $request->keterangan,
            ]);
            return $this->sendError($response->metadata->message, 200);
        } else {
            return $this->sendError('Antrian tidak ditemukan',  201);
        }
    }
    public function checkin_antrian(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
            "waktu" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        return $this->sendError("Silahkan untuk checkin secara langsung di anjungan antrian.", 500);
    }
    public function info_pasien_baru(Request $request)
    {
        return $this->sendError("Anda belum memiliki No RM (Pasien Baru). Silahkan daftar secara langsung ditempat.", 400);
    }
    public function jadwal_operasi_rs(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "tanggalawal" => "required|date",
            "tanggalakhir" => "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        return $this->sendError("Klinik belum memiliki jadwal operasi.", 400);
    }
    public function jadwal_operasi_pasien(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nopeserta" => "required|digits:13",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        return $this->sendError("Klinik belum memiliki jadwal operasi.", 400);
    }
    public function ambil_antrian_farmasi(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (empty($antrian)) {
            return $this->sendError("Kode booking tidak ditemukan",  201);
        }
        $request['nomorantrean'] = $antrian->angkaantrean;
        $request['keterangan'] = "resep sistem antrian";
        $request['jenisresep'] = "Racikan/Non Racikan";
        $res = $this->tambah_antrean_farmasi($request);
        $responses = [
            "jenisresep" => $request->jenisresep,
            "nomorantrean" => $request->nomorantrean,
            "keterangan" => $request->keterangan,
        ];
        return $this->sendResponse($responses, 200);
    }
    public function status_antrian_farmasi(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (empty($antrian)) {
            return $this->sendError("Kode booking tidak ditemukan",  201);
        }
        $totalantrean = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('taskid', '!=', 99)
            ->count();
        $antreanpanggil = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('taskid', 3)
            ->first();
        $antreansudah = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->count();
        $request['totalantrean'] = $totalantrean ?? 0;
        $request['sisaantrean'] = $totalantrean - $antreansudah ?? 0;
        $request['antreanpanggil'] = $antreanpanggil->angkaantrean ?? 0;
        $request['keterangan'] = $antrian->keterangan;
        $request['jenisresep'] = "Racikan/Non Racikan";
        $responses = [
            "jenisresep" => $request->jenisresep,
            "totalantrean" => $request->totalantrean,
            "sisaantrean" => $request->sisaantrean,
            "antreanpanggil" => $request->antreanpanggil,
            "keterangan" => $request->keterangan,
        ];
        return $this->sendResponse($responses, 200);
    }
}
