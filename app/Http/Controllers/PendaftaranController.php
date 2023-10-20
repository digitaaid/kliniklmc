<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Jaminan;
use App\Models\Kunjungan;
use App\Models\Poliklinik;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranController extends APIController
{
    // anjungan
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
                // $api = new AntrianController();
                // $res = $api->update_antrean($request);
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
            $request['nomorantrean'] = 'A' .  $antiranhari + 1;
            $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
            $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(5 * ($antiranhari + 1));
            $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
            // status antrian
            $api = new AntrianController();
            $statusantrian = $api->status_antrian($request);
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
            $request['keterangan'] = "Ambil antrian dari anjungan";
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
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            if ($antrian->taskid == 1) {
                $antrian->update([
                    'taskid' => 2,
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
        $vclaim = new VclaimController();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($request->jenispasien == "JKN") {
            $request->validate([
                'noRujukan' => 'required_if:noSurat,null',
                'noSurat' => 'required_if:noRujukan,null',
            ]);
            if ($request->noSurat) {
                $request['jeniskunjungan'] = 3;
                $request['nomorsuratkontrol'] = $request->noSurat;
                $request['noSuratKontrol'] = $request->noSurat;
                $res =  $vclaim->suratkontrol_nomor($request);
                if ($res->metadata->code == 200) {
                    $request['perujuk'] = $res->response->sep->provPerujuk->nmProviderPerujuk;
                }
            } else {
                $request['nomorrujukan'] = $request->noRujukan;
                if ($request->asalRujukan == 2) {
                    $request['jeniskunjungan'] = 4;
                    $res =  $vclaim->rujukan_rs_nomor($request);
                } else {
                    $request['jeniskunjungan'] = 1;
                    $res =  $vclaim->rujukan_nomor($request);
                }
                if ($res->metadata->code == 200) {
                    $request['perujuk'] = $res->response->rujukan->provPerujuk->nama;
                }
            }
            $request['nomorreferensi'] = $request->noRujukan ?? $request->noSurat;
        } else {
            $request['jeniskunjungan'] = 2;
        }
        $request['user1'] = Auth::user()->id;
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
        $request['status'] = 0;
        $api = new AntrianController();
        $antrian->update($request->all());
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
            $request['message'] = "Berhasil integrasi antrian \nAngka antrian : " . $request->angkaantrean . "\nKodebooking : " . $request->kodebooking .  "\nJenis Pasien : " . $request->jenispasien . "\nNama " . $request->nama . "\nTanggal Periksa " . $request->tanggalperiksa . "\nDokter : " . $request->namadokter . "\nUser : " . Auth::user()->name;
            $request['number'] = "120363170262520539";
            $wapi->send_message_group($request);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $res =  $api->tambah_antrean($request);
        if ($res->metadata->code == 200) {
            $antrian->update([
                'status' => 1
            ]);
            Alert::success('Success', 'Antrian telah diperbaharui.');
        } else {
            Alert::error('Mohon Maaf', $res->metadata->message);
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
        if ($request->jeniskunjungan != "2") {
            $request->validate([
                'nomorreferensi' => 'required',
                'sep' => 'required',
            ]);
        }
        $antrian = Antrian::find($request->antrian_id);
        $request['counter'] = Kunjungan::where('nomorkartu', $request->nomorkartu)->count() + 1;
        $request['kode'] = $antrian->kodebooking;
        $request['unit'] = $request->kodepoli;
        $request['dokter'] = $request->kodedokter;
        $request['diagnosa_awal'] = 'C50';
        $request['alasan_masuk'] = $request->cara_masuk;
        $request['status'] = 1;
        $request['user1'] = Auth::user()->id;
        if ($antrian->kunjungan_id) {
            $kunjungan = Kunjungan::find($antrian->kunjungan_id);
            $kunjungan->update($request->all());
        } else {
            $kunjungan = Kunjungan::create($request->all());
        }
        $antrian->update([
            'kunjungan_id' => $kunjungan->id,
            'kodekunjungan' => $kunjungan->kode,
            'user1' =>  Auth::user()->id,
        ]);
        Alert::success('Success', 'Kunjungan antrian telah disimpan');
        return redirect()->back();
    }
    function lanjutpoliklinik(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            if ($antrian->taskid == 2) {
                $antrian->update([
                    'taskid' => 3,
                    'user1' => Auth::user()->id,
                ]);
                Alert('Success', 'Pasien dilanjutkan ke poliklinik');
            }
        } catch (\Throwable $th) {
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }
    function batalantrian(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            $antrian->update([
                'taskid' => 99,
                'user1' => Auth::user()->id,
            ]);
            Alert::success('Success', 'Antrian telah dibatalkan.');
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan.');
        }
        return redirect()->back();
    }
    function tidakjadibatal(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        if ($antrian) {
            $antrian->update([
                'taskid' => 1,
                'user1' => Auth::user()->id,
            ]);
            Alert::success('Success', 'Antrian tidak jadi dbatalkan.');
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
    public function laporanpendaftaran(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])->get();
        }
        return view('sim.laporan_pendaftaran', compact([
            'request',
            'antrians',
        ]));
    }
    public function pdflaporanpendaftaran(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])->get();
        }
        $pdf = Pdf::loadView('sim.pdf_laporan_pendaftaran', compact([
            'request',
            'antrians',
        ]));
        return $pdf->stream();
    }
}
