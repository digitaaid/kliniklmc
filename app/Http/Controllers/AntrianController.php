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
                // $res = $this->update_antrean($request);
                // if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'keterangan' => "Pasien telah checkin",
                ]);
                Alert::success('Success', 'Checkin antrian berhasil.');
                return redirect()->to(route('karcisantrian') . "?kodebooking=" . $request->kodebooking);
                // } else {
                //     Alert::error('Gagal', $res->metadata->message);
                // }
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
                return redirect()->route('anjunganantrian');
            }
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            return redirect()->route('anjunganantrian');
        }
    }
    public function ambilkarcis(Request $request)
    {
        $jadwal = JadwalDokter::find($request->jadwal);
        if ($jadwal) {
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
            $request['jeniskunjungan'] = "0";
            $request['pasienbaru'] = "0";
            $request['taskid'] = "1";
            $request['method'] = "OFFLINE";
            $request['tanggalperiksa'] = now()->format('Y-m-d');
            // angka antrian
            $request['kodebooking'] = strtoupper(uniqid());
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
            try {
                $wapi = new WhatsappController();
                $request['message'] = "Berhasil daftar antrian method " . $request->method . ".\nAngka antrian : " . $request->angkaantrean . "\nKodebooking : " . $request->kodebooking .  "\nJenis Pasien : " . $request->jenispasien . "\nNama " . $request->nama . "\nTanggal Periksa " . $request->tanggalperiksa . "\nDokter : " . $request->namadokter . "\nUser : " . Auth::user()->name;
                $request['number'] = "120363170262520539";
                $wapi->send_message_group($request);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return redirect()->to(route('karcisantrian') . "?kodebooking=" . $request->kodebooking);
        } else {
            Alert::error('Mohon Maaf', 'Jadwal tidak ditemukan.');
            return redirect()->route('anjunganantrian');
        }
    }
    function karcisantrian(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian == null) {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            return redirect()->route('anjunganantrian');
        }
        return view('sim.karcis_antrian', compact([
            'antrian'
        ]));
    }
    // pendaftaran
    public function antrianpendaftaran(Request $request)
    {
        $antrians = null;
        $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
        $polikliniks = Poliklinik::where('status', '1')->pluck('namasubspesialis', 'kodesubspesialis');
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->get();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_pendaftaran', compact([
            'request',
            'antrians',
            'dokters',
            'polikliniks',
        ]));
    }
    public function prosespendaftaran(Request $request)
    {
        $request['taskid'] = "2";
        $request['waktu'] = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            if ($antrian->taskid == 1) {
                $antrian->update([
                    'taskid' => $request->taskid,
                ]);
                Alert::success('Success', 'Antrian dipanggil ke pendaftaran.');
            }
            $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
            $polikliniks = Unit::where('status', '1')->pluck('nama', 'kode');
            $jaminans = Jaminan::pluck('nama', 'kode');
            return view('sim.antrian_pendaftaran_proses', compact([
                'request',
                'antrian',
                'dokters',
                'jaminans',
                'polikliniks',
            ]));
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            $url = route('antrianpendaftaran') . "?tanggalperiksa=" . now()->format("Y-m-d");
            return redirect()->to($url);
        }
    }
    function panggilpendaftaran(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
        ]);
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            $antrian->update([
                'panggil' => 0,
            ]);
            Alert::success('Success', 'Antrian telah dipanggil.');
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan.');
        }
        return redirect()->back();
    }
    function editantrian(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'nomorkartu' => 'required',
            'nik' => 'required',
            'norm' => 'required',
            'nama' => 'required',
            'nohp' => 'required',
            'tanggalperiksa' => 'required',
            'jenispasien' => 'required',
            'kodepoli' => 'required',
            'kodedokter' => 'required',
        ]);
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($request->jenispasien == "JKN") {
            $request->validate([
                'noRujukan' => 'required_if:noSurat,null',
                'noSurat' => 'required_if:noRujukan,null',
            ]);
            if ($request->noSurat) {
                $request['jeniskunjungan'] = 3;
                $request['nomorsuratkontrol'] = $request->noSurat;
            } else {
                $request['nomorrujukan'] = $request->noRujukan;
                if ($request->asalRujukan == 2) {
                    $request['jeniskunjungan'] = 4;
                } else {
                    $request['jeniskunjungan'] = 1;
                }
            }
            $request['nomorreferensi'] = $request->noRujukan ?? $request->noSurat;
        } else {
            $request['jeniskunjungan'] = 2;
        }
        $request['user1'] = Auth::user()->name;
        $request['namapoli'] = $antrian->namapoli;
        $request['namadokter'] = $antrian->namadokter;
        $request['jampraktek'] = $antrian->jampraktek;
        $request['pasienbaru'] = $antrian->pasienbaru;
        $request['nomorantrean'] = $antrian->nomorantrean;
        $request['angkaantrean'] = $antrian->angkaantrean;
        $request['estimasidilayani'] = $antrian->estimasidilayani;
        $request['sisakuotajkn'] = $antrian->sisakuotajkn;
        $request['kuotajkn'] = $antrian->kuotajkn;
        $request['sisakuotanonjkn'] = $antrian->sisakuotanonjkn;
        $request['kuotanonjkn'] = $antrian->kuotanonjkn;
        $request['keterangan'] = "Antrian proses di pendaftaran";
        $request['status'] = 1;
        try {
            $res =  $this->tambah_antrean($request);
            $antrian->update($request->all());
            if ($res->metadata->code == 200) {
                try {
                    $wapi = new WhatsappController();
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
                    // notif pasien
                    $request['keterangan'] = "Silahkan menunggu untuk mendapatkan pelayanan. (TIKET MOHON TIDAK HILANG SAMPAI DENGAN SELESAI PELAYANAN)";
                    $request['message'] = "*Pendaftaran Berhasil*\nAntrian anda berhasil didaftarkan ke sistem KLINIK LMC dengan data sebagai berikut : \n\n*Kode Antrian :* " . $request->kodebooking .  "\n*Angka Antrian :* " . $request->angkaantrean .  "\n*Nomor Antrian :* " . $request->nomorantrean . "\n*Jenis Pasien :* " . $request->jenispasien .  "\n*Jenis Kunjungan :* " . $jeniskunjungan .  "\n\n*Nama :* " . $request->nama . "\n*Poliklinik :* " . $request->namapoli  . "\n*Dokter :* " . $request->namadokter  .  "\n*Jam Praktek :* " . $request->jampraktek  .  "\n*Tanggal Periksa :* " . $request->tanggalperiksa . "\n\n*Keterangan :* " . $request->keterangan  .  "\n\nLink Kodebooking QR Code :\nhttps://luthfimedicalcenter.com/statusantrian?kodebooking=" . $request->kodebooking . "\n\nTerima kasih. \nSalam Hangat dan Sehat Selalu.\nUntuk pertanyaan & pengaduan silahkan hubungi :\n*Customer Care KLINIK LMC (0231)8850943 / 0823 1169 6919*";
                    $request['number'] = $request->nohp;
                    $wapi->send_message($request);
                    // sholawat
                    $sholawat = "اَللّٰهُمَّ صَلِّ عَلٰى سَيِّدِنَا مُحَمَّدٍ، طِبِّ الْقُلُوْبِ وَدَوَائِهَا، وَعَافِيَةِ الْاَبْدَانِ وَشِفَائِهَا، وَنُوْرِ الْاَبْصَارِ وَضِيَائِهَا، وَعَلٰى اٰلِهِ وَصَحْبِهِ وَسَلِّمْ";
                    $request['message'] = $sholawat;
                    $request['number'] = '6289529909036@c.us';
                    $wapi->send_message($request);
                    // notif group
                    $request['message'] = "Berhasil integrasi antrian \nAngka antrian : " . $request->angkaantrean . "\nKodebooking : " . $request->kodebooking .  "\nJenis Pasien : " . $request->jenispasien . "\nNama " . $request->nama . "\nTanggal Periksa " . $request->tanggalperiksa . "\nDokter : " . $request->namadokter;
                    $request['number'] = "120363170262520539";
                    $wapi->send_message_group($request);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                Alert::success('Success', 'Antrian telah diperbaharui.');
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }
    function editkunjungan(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'antrian_id' => 'required',
            'tgl_masuk' => 'required',
            'jaminan' => 'required',
            'nomorkartu' => 'required',
            'nik' => 'required',
            'norm' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'gender' => 'required',
            'kelas' => 'required',
            'penjamin' => 'required',
            'kodepoli' => 'required',
            'cara_masuk' => 'required',
            'jeniskunjungan' => 'required',
            // 'nomorreferensi' => 'required',
            // 'sep' => 'required',
        ]);
        // if ($request->jeniskunjungan != "2") {
        //     $request->validate([
        //         'nomorreferensi' => 'required',
        //         'sep' => 'required',
        //     ]);
        // }else{
        // }
        $antrian = Antrian::find($request->antrian_id);
        $request['counter'] = Kunjungan::where('nomorkartu', $request->nomorkartu)->count() + 1;
        $request['kode'] = $antrian->kodebooking;
        $request['unit'] = $request->kodepoli;
        $request['dokter'] = $request->kodedokter;
        $request['diagnosa_awal'] = 'C50';
        $request['alasan_masuk'] = $request->cara_masuk;
        $request['status'] = 1;
        $request['user1'] = Auth::user()->name;
        if ($antrian->kunjungan_id) {
            $kunjungan = Kunjungan::find($antrian->kunjungan_id);
            $kunjungan->update($request->all());
        } else {
            $kunjungan = Kunjungan::create($request->all());
        }
        $antrian->update([
            'kunjungan_id' => $kunjungan->id,
            'kodekunjungan' => $kunjungan->kode,
        ]);
        Alert::success('Success', 'Kunjungan antrian telah disimpan');
        return redirect()->back();
    }
    function lanjutpoliklinik(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            if ($antrian->taskid == 2) {
                $request['taskid'] = "3";
                $request['waktu'] = now();
                $antrian->update([
                    'taskid' => $request->taskid,
                    'user1' => Auth::user()->name,
                ]);
                Alert('Success', 'Pasien dilanjutkan ke poliklinik');
                // $res = $this->update_antrean($request);
                // if ($res->metadata->code == 200) {
                // Alert::success('Success',  $res->metadata->message);
                // } else {
                //     Alert::error('Mohon Maaf', $res->metadata->message);
                // }
            }
        } catch (\Throwable $th) {
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }
    function batalantrian(Request $request)
    {
        $request['taskid'] = "99";
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            try {
                // $res = $this->batal_antrean($request);
                // if ($res->metadata->code == 200) {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'user1' => Auth::user()->name,
                ]);
                Alert::success('Success', 'Antrian telah dibatalkan.');
                // } else {
                //     Alert::error('Gagal', $res->metadata->message);
                // }
            } catch (\Throwable $th) {
                Alert::error('Mohon Maaf', $th->getMessage());
            }
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan.');
        }
        return redirect()->back();
    }
    function tidakjadibatal(Request $request)
    {
        $request['taskid'] = "1";
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            try {
                $antrian->update([
                    'taskid' => $request->taskid,
                    'user1' => Auth::user()->name,
                ]);
            } catch (\Throwable $th) {
                Alert::error('Mohon Maaf', $th->getMessage());
            }
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan.');
        }
        return redirect()->back();
    }
    function batalantrianweb(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            try {
                $request['taskid'] = "99";
                // $res = $this->batal_antrean($request);
                $antrian->update([
                    'taskid' => $request->taskid,
                    'keterangan' => $request->keterangan,
                    'user1' => $antrian->nama,
                ]);
                return $this->sendResponse('Antrian telah dibatalkan', 200);
            } catch (\Throwable $th) {
                return $this->sendError('Mohon Maaf', $th->getMessage(), 400);
            }
        } else {
            return $this->sendError('Antrian tidak ditemukan', 404);
        }
    }
    // perawat
    public function antrianperawat(Request $request)
    {
        $antrians = null;
        $antrian_asesmen = null;
        $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
        $polikliniks = Poliklinik::where('status', '1')->pluck('namasubspesialis', 'kodesubspesialis');
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->get();
            $antrian_asesmen = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->whereHas('asesmenperawat')->count();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_perawat', compact([
            'request',
            'antrians',
            'antrian_asesmen',
            'dokters',
            'polikliniks',
        ]));
    }
    public function prosesperawat(Request $request)
    {
        $antrian = Antrian::with(['kunjungan', 'kunjungan.asesmenperawat'])->where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            // if (!$antrian->pasien) {
            //     Alert::error('Mohon Maaf', 'Silahkan perbaiki data norm pasien terlebih dahulu menjadi ' . $antrian->norm);
            //     return redirect()->back();
            // }
            $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
            $polikliniks = Unit::where('status', '1')->pluck('nama', 'kode');
            $kunjungan = $antrian->kunjungan;
            if (empty($antrian->asesmenperawat)) {
                Alert::info('Informasi', 'Silahkan Lakukan Assemen Keperawatan.');
            }
            return view('sim.antrian_perawat_proses', compact([
                'request',
                'antrian',
                'dokters',
                'polikliniks',
                'kunjungan',
            ]));
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            return redirect()->back();
        }
    }
    function editasesmenperawat(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'antrian_id' => 'required',
            'kodekunjungan' => 'required',
            'kunjungan_id' => 'required',
        ]);
        $request['waktu'] = now();
        $kunjungan = Kunjungan::find($request->kunjungan_id);
        $request['counter'] = $kunjungan->counter;
        $request['norm'] = $kunjungan->norm;
        $request['nama'] = $kunjungan->nama;
        $request['tgl_lahir'] = $kunjungan->tgl_lahir;
        $request['gender'] = $kunjungan->gender;
        $request['user'] = Auth::user()->name;
        $request['status'] = 1;
        AsesmenPerawat::updateOrCreate(
            [
                'kodebooking' => $request->kodebooking,
                'antrian_id' => $request->antrian_id,
                'kodekunjungan' => $request->kodekunjungan,
                'kunjungan_id' => $request->kunjungan_id,
            ],
            $request->all()
        );
        Alert::success('Success', 'Simpan Assemen Keperawatan.');
        return redirect()->back();
    }
    function uploadpenunjang(Request $request)
    {
        try {
            $url = 'http://103.39.50.206/lmc/public/api/uploadfile';
            $file               = request('file');
            $file_path          = $file->getPathname();
            $file_mime          = $file->getMimeType();
            $file_uploaded_name = $file->getClientOriginalName();
            $client = new Client();
            $response = $client->request("POST", $url, [
                /** Multipart form data is your actual file upload form */
                'multipart' => [
                    [
                        /** This is the actual fields name that you will use to access in API */
                        'name'      => 'file',
                        'filename' => $file_uploaded_name,
                        'Mime-Type' => $file_mime,

                        /** This is the main line, we are reading from file temporary uploaded location  */
                        'contents' => fopen($file_path, 'r'),
                    ],
                    /** Other form fields here, as we can't send form_fields with multipart same time */
                    [
                        /** This is the form filed that we will use to acess in API */
                        'name' => 'form-data',
                        /** We need to use json_encode to send the encoded data */
                        'contents' => json_encode(
                            [
                                'nama' => 'Channaveer',
                            ]
                        )
                    ]
                ]
            ]);
            $responseData = json_decode($response->getBody(), true);
            $res = json_decode(json_encode($responseData));
            if ($res->metadata->code == 200) {
                $request['fileurl'] = $res->metadata->message;
                $request['type'] = $file_mime;
                FileUploadPasien::create($request->all());
                Alert::success('Success', 'Upload File Penunjang Pasien Berhasil');
            } else {
                Alert::error('Mohon Maaf', $res->metadata->code);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Mohon Maaf', $th->getMessage());
        }

        return redirect()->back();
    }
    function hapusfilepenunjang(Request $request)
    {
        $file = FileUploadPasien::find($request->id);
        $file->delete();
        Alert::success('Success', 'File Penunjang Pasien berhasil dihapus.');
        return redirect()->back();
    }

    // poliklinik
    public function antrianpoliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->get();
        } else {
            $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_poliklinik', compact([
            'request',
            'antrians',
        ]));
    }
    public function prosespoliklinik(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            try {
                if ($antrian->taskid == 3) {
                    $request['taskid'] = "3";
                    $request['waktu'] = now()->subMinutes(random_int(4, 9));
                    $res = $this->update_antrean($request);
                    $request['taskid'] = "4";
                    $request['waktu'] = now();
                    $res = $this->update_antrean($request);
                    // if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => $request->taskid,
                    ]);
                    Alert::success('Success', $res->metadata->message);
                    // }
                }
                $kunjungan = Kunjungan::find($antrian->kunjungan_id);
                return view('sim.antrian_poliklinik_proses', compact([
                    'request',
                    'antrian',
                    'kunjungan',
                ]));
            } catch (\Throwable $th) {
                Alert::error('Mohon Maaf', $th->getMessage());
                return redirect()->back();
            }
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            return redirect()->back();
        }
    }
    function editasesmendokter(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'antrian_id' => 'required',
            'kodekunjungan' => 'required',
            'kunjungan_id' => 'required',
        ]);
        $request['waktu'] = now();
        $kunjungan = Kunjungan::find($request->kunjungan_id);
        $request['counter'] = $kunjungan->counter;
        $request['norm'] = $kunjungan->norm;
        $request['nama'] = $kunjungan->nama;
        $request['tgl_lahir'] = $kunjungan->tgl_lahir;
        $request['gender'] = $kunjungan->gender;
        $request['user'] = Auth::user()->name;
        $request['status'] = 1;
        $diagnosa2 = null;
        if ($request->diagnosa2) {
            foreach ($request->diagnosa2 as $key => $value) {
                if ($key == 0) {
                    $diagnosa2 =  $value;
                } else {
                    $diagnosa2 =  $diagnosa2 . '#' . $value;
                }
            }
            $request['diagnosa2'] = $diagnosa2;
        }
        $asesmenperawat = $kunjungan->asesmenperawat;
        $asesmenperawat->update([
            'keluhan_utama' => $request->keluhan_utama,
        ]);
        AsesmenDokter::updateOrCreate(
            [
                'kodebooking' => $request->kodebooking,
                'antrian_id' => $request->antrian_id,
                'kodekunjungan' => $request->kodekunjungan,
                'kunjungan_id' => $request->kunjungan_id,
            ],
            $request->all()
        );
        if ($request->obat) {
            $request['status'] = 0;
            $request['tinggi_badan'] = $kunjungan->asesmenperawat->tinggi_badan ?? null;
            $request['berat_badan'] = $kunjungan->asesmenperawat->berat_badan ?? null;
            $request['bsa'] = $kunjungan->asesmenperawat->bsa ?? null;
            $request['kode'] = $kunjungan->kode;
            $resep = ResepObat::updateOrCreate(
                [
                    'kodebooking' => $request->kodebooking,
                    'antrian_id' => $request->antrian_id,
                    'kodekunjungan' => $request->kodekunjungan,
                    'kunjungan_id' => $request->kunjungan_id,
                ],
                $request->all()
            );
            // hapus obat jika tidak diresepkan
            if ($resep->resepdetail) {
                foreach ($resep->resepdetail as  $obadetail) {
                    $ada = 0;
                    foreach ($request->obat as $key => $obatid) {
                        if ($obadetail->obat_id == $obatid) {
                            $ada = 1;
                        }
                    }
                    if ($ada == 0) {
                        $obadetail->delete();
                    }
                }
            }
            // peresepan
            foreach ($request->obat as $key => $value) {
                $obat = Obat::find($value);
                $resepdetail = ResepObatDetail::updateOrCreate(
                    [
                        'koderesep' => $resep->kodebooking,
                        'resep_id' => $resep->id,
                        'obat_id' =>  $obat->id,
                    ],
                    [
                        'nama' => $obat->nama,
                        'jumlah' => $request->jumlah[$key] ?? 0,
                        'interval' => $request->frekuensi[$key] ?? null,
                        'waktu' => $request->waktuobat[$key] ?? null,
                        'keterangan' => $request->keterangan_obat[$key] ?? null,
                    ]
                );
            }
        }
        Alert::success('Success', 'Simpan Assemen Dokter.');
        return redirect()->back();
    }
    function selesaipoliklinik(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            if ($antrian->taskid == 4) {
                $request['taskid'] = "5";
                $request['waktu'] = now();
                $request['user3'] = Auth::user()->name;
                $res = $this->update_antrean($request);
                if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => '7',
                        'user2' => Auth::user()->name,
                        'keterangan' => "Pasien pasien sudah selesai pelayanan.",
                    ]);
                    Alert::success('Success', 'Antrian selesai di Poliklinik.');
                } else {
                    Alert::error('Gagal', $res->metadata->message);
                }
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    function lanjutfarmasi(Request $request)
    {

        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            if ($antrian->taskid == 4) {
                $request['keterangan'] = "Pasien dilanjutkan ke farmasi";
                $request['taskid'] = "5";
                $request['waktu'] = now();
                $request['user3'] = Auth::user()->name;
                $res = $this->update_antrean($request);
                $antrian->update($request->all());
                // if ($res->metadata->code == 200) {
                $request['nomorantrean'] = $antrian->angkaantrean;
                $request['jenisresep'] = 'racikan';
                $res_farmasi = $this->tambah_antrean_farmasi($request);
                // }
                Alert::success('Success', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    // farmasi
    public function antrianfarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->get();
        } else {
            // $request['tanggalperiksa'] = now()->format('Y-m-d');
        }
        return view('sim.antrian_farmasi', compact([
            'request',
            'antrians',
        ]));
    }
    public function getantrianfarmasi(Request $request)
    {
        if ($request->tanggalperiksa) {
            $antrian = Antrian::whereDate('tanggalperiksa', $request->tanggalperiksa)
                ->where('taskid', 5)
                ->first('kodebooking');
            if ($antrian) {
                return $this->sendResponse($antrian, 200);
            } else {
                return $this->sendError('Tidak ada order',  404);
            }
        } else {
            return $this->sendError('Tidak ada order',  404);
        }
    }
    function terimafarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $request['taskid'] = "6";
            $request['waktu'] = now();
            if ($antrian->taskid == 5) {
                $res = $this->update_antrean($request);
                $antrian->update([
                    'taskid' => $request->taskid,
                    'keterangan' => "Resep Pasien sudah diterima di farmasi.",
                ]);
                Alert::success('Success', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
    function selesaifarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $request['taskid'] = "7";
            $request['waktu'] = now();
            $res = $this->update_antrean($request);
            // if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => $request->taskid,
                'keterangan' => "Pasien telah selesai semua pelayanan",
            ]);
            // }
            Alert::success('Success', $res->metadata->message);
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
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
        $antrianakhir = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->orderBy('updated_at', 'DESC')->get();
        $data = [
            "pendaftaran" => $antrianakhir->where('taskid', 2)->first()->angkaantrean ?? "-",
            "pendaftaranstatus" => $antrianakhir->where('taskid', 2)->first()->panggil ?? "-",
            "pendaftarankodebooking" => $antrianakhir->where('taskid', 2)->first()->kodebooking ?? "-",
            "pendaftaranselanjutnya" => $antrian->where('taskid', 1)->first()->angkaantrean ?? "-",
            "poliklinik" => $antrianakhir->where('taskid', 4)->first()->angkaantrean ?? "-",
            "poliklinikstatus" => $antrianakhir->where('taskid', 4)->first()->panggil ?? "-",
            "poliklinikkodebooking" => $antrianakhir->where('taskid', 4)->first()->kodebooking ?? "-",
            "poliklinikselanjutnya" => $antrian->where('taskid', 3)->first()->angkaantrean ?? "-",
            "farmasi" => $antrianakhir->where('taskid', 7)->first()->angkaantrean ?? "-",
            "farmasiselanjutnya" => $antrian->where('taskid', 6)->first()->angkaantrean ?? "-",
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
        $request['kodebooking'] = strtoupper(uniqid());
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
