<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\IntegrasiApi;
use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AntrianController extends APIController
{
    public function index(Request $request)
    {
        $antrians = null;
        $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
        $polikliniks = Poliklinik::where('status', '1')->pluck('namasubspesialis', 'kodesubspesialis');
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->get();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_index', compact([
            'request',
            'antrians',
            'dokters',
            'polikliniks',
        ]));
    }
    // pendaftaran
    public function anjunganantrian()
    {
        $jadwals = JadwalDokter::where('hari',  now()->dayOfWeek)->get();
        $antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))
            ->where('taskid', "!=", 99)
            ->get();
        return view('sim.antrian_anjungan', compact([
            'jadwals',
            'antrians',
        ]));
    }
    function checkinantrian(Request $request)
    {
        $request['taskid'] = "1";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            try {
                $res = $this->update_antrean($request);
                if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => $request->taskid,
                        'keterangan' => "Pasien telah checkin",
                    ]);
                    Alert::success('Success', 'Checkin antrian berhasil.');
                } else {
                    Alert::error('Gagal', $res->metadata->message);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            return redirect()->route('karcisantrian', $request->kodebooking);
        } else {
            Alert::error('Gagal', 'Kodebooking tidak ditemukan');
            return redirect()->route('anjunganantrian');
        }
    }
    function karcisantrian($kodebooking, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        return view('sim.karcis_antrian', compact([
            'antrian'
        ]));
    }
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
        if ($request->nomorkartu && empty($request->nik)) {
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
        if ($request->tanggalperiksa) {
            $hari = Carbon::parse($request->tanggalperiksa)->dayOfWeek;
            $jadwals = JadwalDokter::where('hari', $hari)->get();
            $request['button'] = "Cek Rujukan / Surat Kontrol";
            if ($jadwals->count() == 0) {
                $request['warning'] = "Tidak ada jadwal hari terserbut.";
            }
        }
        if ($request->jeniskunjungan && $request->jadwal) {
            $jadwal = JadwalDokter::find($request->jadwal);
            $request['kodepoli'] = $jadwal->kodesubspesialis;
            $request['namapoli'] = $jadwal->namasubspesialis;
            $request['namadokter'] = $jadwal->namadokter;
            $request['kodedokter'] = $jadwal->kodedokter;
            $request['jampraktek'] = $jadwal->jadwal;
            switch ($request->jeniskunjungan) {
                case '1':
                    $res = $api->rujukan_peserta($request);
                    if ($res->metadata->code == 200) {
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
            $request['button'] = "Daftar";
        }
        if ($request->nomorreferensi) {
            $request['jenispasien'] = "JKN";
            $request['pasienbaru'] = 0;
            $request['method'] = "WEB";
            $res = $this->ambil_antrian($request);
            if ($res->metadata->code == 200) {
                $url = route('statusantrian') . "?kodebooking=" . $request->kodebooking;
                return redirect()->to($url);
            } else {
                $request['error'] = $res->metadata->message;
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
        if ($request->nik && empty($request->nomorkartu)) {
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
        if ($request->jadwal) {
            $jadwal = JadwalDokter::find($request->jadwal);
            $request['kodepoli'] = $jadwal->kodesubspesialis;
            $request['namapoli'] = $jadwal->namasubspesialis;
            $request['namadokter'] = $jadwal->namadokter;
            $request['kodedokter'] = $jadwal->kodedokter;
            $request['jampraktek'] = $jadwal->jadwal;
            $request['jenispasien'] = "NON-JKN";
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
                $request['error'] = $res->metadata->message;
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
        return view('sim.antrian_pasien', compact([
            'request',
            'res',
            'antrian',
        ]));
    }
    public function ambilkarcis(Request $request)
    {
        $jadwal = JadwalDokter::find($request->jadwal);
        $request['nomorkartu'] = "0000000000000";
        $request['nik'] = "0000000000000000";
        $request['nohp'] = "000000000000";
        $request['norm'] = "000000";
        $request['jenispasien'] = $request->jenispasien;
        $request['kodepoli'] = $jadwal->kodesubspesialis;
        $request['namapoli'] = $jadwal->namasubspesialis;
        $request['kodedokter'] = $jadwal->kodedokter;
        $request['namadokter'] = $jadwal->namadokter;
        $request['nama'] = "Pasien Offline";
        $request['jampraktek'] = $jadwal->jadwal;
        $request['jadwal_id'] = $jadwal->id;
        $request['jeniskunjungan'] = "2";
        $request['pasienbaru'] = "0";
        $request['taskid'] = "1";
        $request['method'] = "OFFLINE";
        $request['tanggalperiksa'] = now()->format('Y-m-d');
        // angka antrian
        $request['kodebooking'] = date('ym') . random_int(1000, 9999);
        $antiranhari = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->count();
        $request['angkaantrean'] =  $antiranhari + 1;
        $request['nomorantrean'] = 'A' . sprintf("%03d", $antiranhari + 1);
        $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
        $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(5 * ($antiranhari + 1));
        $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
        // status antrian
        $statusantrian = $this->status_antrian($request);
        if ($statusantrian->metadata->code == 200) {
            $request['sisakuotajkn']  = $statusantrian->response->sisakuotajkn;
            $request['kuotajkn']  = $statusantrian->response->kuotajkn;
            $request['sisakuotanonjkn']  = $statusantrian->response->sisakuotanonjkn;
            $request['kuotanonjkn']  = $statusantrian->response->kuotanonjkn;
            $request['jadwal_id']  = $statusantrian->response->jadwal_id;
        } else {
            Alert::error('Gagal', $statusantrian->metadata->message);
            return redirect()->route('anjunganantrian');
        }
        $request['keterangan'] = "Oke";
        Antrian::create($request->all());
        Alert::success('Success', 'Berhasil cetak karcis antrian dengan nomorantrean ' . $request->nomorantrean);
        return redirect()->route('karcisantrian', $request->kodebooking);
    }
    function layanipendaftaran(Request $request)
    {
        $request['taskid'] = "2";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        // antrian offline
        if ($antrian->method == "OFFLINE") {
            $antrian->update([
                'taskid' => $request->taskid,
            ]);
            Alert::success('Success', 'Antrian dipanggil ke pendaftaran.');
        }
        // antrian online
        else {
            $res = $this->update_antrean($request);
            if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                ]);
                Alert::success('Success', 'Antrian dipanggil ke pendaftaran.');
            } else {
                Alert::error('Gagal', $res->metadata->message);
            }
        }
        return redirect()->back();
    }
    function editantrian(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $antrian->update($request->all());
        Alert::success('Success', 'Antrian telah diperbaharui.');
        return redirect()->back();
    }
    function lanjutpoliklinik(Request $request)
    {
        $request['taskid'] = "3";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian->method == "OFFLINE") {
            $request['jenispasien'] = $antrian->jenispasien;
            $request['nomorkartu'] = $antrian->nomorkartu;
            $request['nik'] = $antrian->nik;
            $request['nohp'] = $antrian->nohp;
            $request['kodepoli'] = $antrian->kodepoli;
            $request['namapoli'] = $antrian->namapoli;
            $request['pasienbaru'] = $antrian->pasienbaru;
            $request['norm'] = $antrian->norm;
            $request['tanggalperiksa'] = $antrian->tanggalperiksa;
            $request['kodedokter'] = $antrian->kodedokter;
            $request['namadokter'] = $antrian->namadokter;
            $request['jampraktek'] = $antrian->jampraktek;
            $request['jeniskunjungan'] = $antrian->jeniskunjungan;
            $request['nomorreferensi'] = $antrian->nomorreferensi;
            $request['nomorantrean'] = $antrian->nomorantrean;
            $request['angkaantrean'] = $antrian->angkaantrean;
            $request['estimasidilayani'] = $antrian->estimasidilayani;
            $request['sisakuotajkn'] = $antrian->sisakuotajkn;
            $request['kuotajkn'] = $antrian->kuotajkn;
            $request['sisakuotanonjkn'] = $antrian->sisakuotanonjkn;
            $request['kuotanonjkn'] = $antrian->kuotanonjkn;
            $request['keterangan'] = $antrian->keterangan;
            $request['nama'] = $antrian->nama;
            $res = $this->tambah_antrean($request);
            if ($res->metadata->code != 200) {
                Alert::error('Gagal', $res->metadata->message);
                return redirect()->back();
            }
        }
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
            ]);
            Alert::success('Success', 'Antrian dilanjutkan ke Poliklinik.');
        } else {
            Alert::error('Gagal', $res->metadata->message);
        }
        return redirect()->back();
    }
    function batalantrian(Request $request)
    {
        $request['taskid'] = "99";
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $res = $this->batal_antrean($request);
            if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                ]);
                Alert::success('Success', 'Antrian telah dibatalkan.');
            } else {
                Alert::error('Gagal', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->back();
    }

    public function antrianpoliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->get();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_poliklinik', compact([
            'request',
            'antrians',
        ]));
    }
    function panggilpoliklinik(Request $request)
    {
        $request['taskid'] = "4";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $res = $this->update_antrean($request);
            if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'keterangan' => "Pasien sedang dilayani dipoliklinik",
                ]);
                Alert::success('Success', 'Antrian dilayani di Poliklinik.');
            } else {
                Alert::error('Gagal', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->back();
    }
    function selesaipoliklinik(Request $request)
    {
        $request['taskid'] = "5";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $res = $this->update_antrean($request);
            if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'keterangan' => "Pasien pasien sudah dilayani dipoliklinik",
                ]);
                Alert::success('Success', 'Antrian selesai di Poliklinik.');
            } else {
                Alert::error('Gagal', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->back();
    }
    function lanjutfarmasi(Request $request)
    {
        $request['taskid'] = "5";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $request['keterangan'] = $request->catatan;
        try {
            $res = $this->update_antrean($request);
            $antrian->update($request->all());
            $request['nomorantrean'] = $antrian->angkaantrean;
            $res_farmasi = $this->tambah_antrean_farmasi($request);
            Alert::success('Success', 'Antrian dilanjutkan ke farmasi.');
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    public function antrianfarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->get();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_farmasi', compact([
            'request',
            'antrians',
        ]));
    }
    function terimafarmasi(Request $request)
    {
        $request['taskid'] = "6";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $res = $this->update_antrean($request);
            $antrian->update([
                'taskid' => $request->taskid,
                'keterangan' => "Resep Pasien sudah diterima di farmasi.",
            ]);
            Alert::success('Success', 'Antrian Resep telah diterima Farmasi.');
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    function selesaifarmasi(Request $request)
    {
        $request['taskid'] = "7";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'keterangan' => "Pasien telah selesai semua pelayanan",
            ]);
            Alert::success('Success', 'Antrian Selesai.');
        } else {
            Alert::error('Gagal', $res->metadata->message);
        }
        return redirect()->back();
    }
    public function displayantrian()
    {
        return view('sim.display_antrian');
        // $jadwals = JadwalDokter::where('hari',  now()->dayOfWeek)
        //     ->orderBy('namasubspesialis', 'asc')->get();
        // $antrians = Antrian::whereDate('tanggalperiksa', now()->format('Y-m-d'))->get();
        // return view('sim.antrian_console', compact(
        //     [
        //         'jadwals',
        //         'antrians',
        //     ]
        // ));
    }
    public function displaynomor()
    {
        $antrian = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->get();
        $data = [
            "pendaftaran" => $antrian->where('taskid', 2)->first()->nomorantrean ?? "-",
            "pendaftaranselanjutnya" => $antrian->where('taskid', 1)->first()->nomorantrean ?? "-",
            "poliklinik" => $antrian->where('taskid', 4)->first()->nomorantrean ?? "-",
            "poliklinikselanjutnya" => $antrian->where('taskid', 3)->first()->nomorantrean ?? "-",
            "farmasi" => $antrian->where('taskid', 6)->first()->nomorantrean ?? "-",
            "farmasiselanjutnya" => $antrian->where('taskid', 5)->first()->nomorantrean ?? "-",
        ];
        return $this->sendResponse($data, 200);
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
            // $data['token'] =  $user->createToken('MyApp')->plainTextToken;
            $data['token'] =  "token";
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
            return $this->sendError("Tanggal periksa sudah terlewat", 401);
        }
        // get jadwal poliklinik dari simrs
        $jadwals = JadwalDokter::where("hari",  Carbon::parse($request->tanggalperiksa)->dayOfWeek)
            ->where("kodesubspesialis", $request->kodepoli)
            ->where("jadwal", $request->jampraktek)
            ->get();
        // tidak ada jadwal
        if (!isset($jadwals)) {
            return $this->sendError("Tidak ada jadwal poliklinik dihari tersebut", 404);
        }
        // get jadwal dokter
        $jadwal = $jadwals->where('kodedokter', $request->kodedokter)->first();
        // tidak ada dokter
        if (!isset($jadwal)) {
            return $this->sendError("Tidak ada jadwal dokter dihari tersebut",  404);
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
        $nomorantean = 0;
        $antreanpanggil =  Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', 4)
            ->first();
        if (isset($antreanpanggil)) {
            $nomorantean = $antreanpanggil->nomorantrean;
        }
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
            "antreanpanggil" => $nomorantean,
            "sisakuotajkn" => round($jadwal->kapasitaspasien * 80 / 100) -  $antrianjkn,
            "kuotajkn" => round($jadwal->kapasitaspasien * 80 / 100),
            "sisakuotanonjkn" => round($jadwal->kapasitaspasien * 20 / 100) - $antriannonjkn,
            "kuotanonjkn" =>  round($jadwal->kapasitaspasien * 20 / 100),
            "keterangan" => "Informasi antrian poliklinik",
            "jadwal_id" => $jadwal->id,

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
        $request['kodebooking'] = date('ym') . random_int(1000, 9999);
        $antiranhari = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->count();
        $request['nomorantrean'] = 'A' . sprintf("%03d", $antiranhari + 1);
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
        $request['keterangan'] = "Oke";
        $res = $this->tambah_antrean($request);
        if ($res->metadata->code == 200) {
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
            Antrian::create($request->all());
            try {
                $api = new WhatsappController();
                if ($request->method != "OFFLINE") {
                    $request['message'] = "Anda mendaftar antrian di Klinik LMC \n\nLink Status Antrian : https://luthfimedicalcenter.com/statusantrian?kodebooking=" . $request->kodebooking;
                    $request['number'] = $request->nohp;
                    $api->send_message($request);
                }
                $request['message'] = "Telah daftar antas nama " . $request->nama . " dengan angka antrian " . $request->angkaantrean;
                $request['number'] = "120363170262520539";
                $api->send_message_group($request);
            } catch (\Throwable $th) {
                //throw $th;
            }

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
            ->where('status_api', 0)
            ->first();
        $antreansudah = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('taskid', 5)->where('status_api', 1)
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
