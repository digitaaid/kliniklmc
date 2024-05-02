<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenDokter;
use App\Models\Dokter;
use App\Models\Jaminan;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\PemeriksaanLab;
use App\Models\ResepObat;
use App\Models\ResepObatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $dokter = Dokter::with(['pic'])->get();
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
        $request['user'] = Auth::user()->id;
        $dokter->update($request->all());
        Alert::success("Success", 'Data dokter berhasil diupdate.');
        return redirect()->route('dokter.index');
    }
    public function destroy($id, Request $request)
    {
        $dokter = Dokter::find($id);
        if ($dokter->status) {
            $status = 0;
        }
        $dokter->update([
            'status' => $status ?? 1,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Dokter Dinonaktifkan.');
        return redirect()->back();
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
    // poliklinik
    public function antrianpoliklinik(Request $request)
    {
        $antrians = [];
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->where('taskid', '>', 2)->get();
        }
        if ($request->pencarian) {
            $request->validate([
                'pencarian' => 'required|min:3',
            ]);
            $antrians = Antrian::where('norm', $request->pencarian)
                ->orWhere('nama', 'LIKE', '%' . $request->pencarian . '%')->get();
        }
        $now = now()->format('Y-m-d');
        $sedang_antrian = Antrian::where('tanggalperiksa', $now)
            ->where('taskid', '!=', 99)
            ->where('taskid', 4)->first();
        $sisa_antrian = Antrian::where('tanggalperiksa', $now)
            ->where('taskid', '!=', 99)
            ->where('taskid', '>=', 2)
            ->where('taskid', '<=', 3)->count();
        $total_antrian = Antrian::where('tanggalperiksa', $now)
            ->where('taskid', '!=', 99)
            ->where('taskid', '>=', 2)->count();
        return view('sim.antrian_poliklinik', compact([
            'request',
            'antrians',
            'sedang_antrian',
            'sisa_antrian',
            'total_antrian',
        ]));
    }
    public function prosespoliklinik(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $pasien = $antrian->pasien;
        $urlicare = null;
        $messageicare = null;
        $jaminans = Jaminan::pluck('nama', 'kode');
        if ($antrian) {
            try {
                if ($antrian->taskid == 3) {
                    // $api = new AntrianController();
                    // $now = now();
                    // $request['taskid'] = "3";
                    // $request['waktu'] = $now->subMinutes(random_int(4, 9));
                    // $res = $api->update_antrean($request);
                    // $request['taskid'] = "4";
                    // $request['waktu'] = $now;
                    // $res = $api->update_antrean($request);
                    // if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => 4,
                        'panggil' => 0,
                        'status' => '0',
                        'taskid4' => now(),
                    ]);
                    Alert::success('Success', 'Silahkan lakukan pemeriksaan kepada pasien');
                }
                $kunjungan = Kunjungan::find($antrian->kunjungan_id);
                $kunjungans = Kunjungan::where('norm', $antrian->norm)
                    ->with(['units', 'asesmenperawat', 'asesmendokter', 'files', 'resepobat', 'resepobat.resepdetail'])
                    ->orderBy('tgl_masuk', 'DESC')
                    ->get();
                $pemeriksaanlab = PemeriksaanLab::get();
                $permintaanlab = null;
                $hasillab = null;
                if ($antrian->layanans->where('klasifikasi', 'Laboratorium')) {
                    $permintaanlab = $antrian->permintaan_lab;
                    if ($antrian->permintaan_lab) {
                        if ($permintaanlab->permintaan_lab == "null") {
                            $permintaanlab = null;
                        }
                    }
                    $hasillab = $permintaanlab ?  $permintaanlab->hasillab : null;
                }
                return view('sim.antrian_poliklinik_proses', compact([
                    'request',
                    'jaminans',
                    'antrian',
                    'urlicare',
                    'messageicare',
                    'kunjungan',
                    'kunjungans',
                    'pemeriksaanlab',
                    'permintaanlab',
                    'hasillab',
                    'pasien',
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
        $request['user'] = Auth::user()->id;
        $request['pic'] = Auth::user()->name;
        $request['status'] = 1;
        $request['diagnosa'] = json_encode($request->diagnosa);
        $request['diagnosa2'] = json_encode($request->diagnosa2);
        // $asesmenperawat->update([
        //     'sumber_data' => $request->sumber_data,
        //     'keluhan_utama' => $request->keluhan_utama,
        //     'riwayat_pengobatan' => $request->riwayat_pengobatan,
        //     'riwayat_penyakit' => $request->riwayat_penyakit,
        //     'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
        //     'riwayat_alergi' => $request->riwayat_alergi,
        //     'tingkat_kesadaran' => $request->tingkat_kesadaran,
        //     'keadaan_tubuh' => $request->keadaan_tubuh,
        //     'pemeriksaan_lab' => $request->pemeriksaan_lab,
        //     'pemeriksaan_rad' => $request->pemeriksaan_rad,
        //     'pemeriksaan_penunjang' => $request->pemeriksaan_penunjang,
        //     'diagnosa_keperawatan' => $request->diagnosa_keperawatan,
        // ]);
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
            $request['dokter'] = $kunjungan->dokter;
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
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking)->first();
        $antrian->update([
            'user3' => Auth::user()->id,
        ]);
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
                $request['user3'] = Auth::user()->id;
                $api = new AntrianController();
                $res = $api->update_antrean($request);
                $antrian->update([
                    'status' => '0',
                    'taskid' => '7',
                    'user3' => Auth::user()->id,
                    'keterangan' => "Pasien pasien sudah selesai pelayanan.",
                    'taskid5' => now(),
                ]);
                if ($res->metadata->code == 200) {
                    Alert::success('Success', 'Antrian selesai di Poliklinik.');
                } else {
                    Alert::error('Gagal', $res->metadata->message);
                }
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
        $url = route('antrianpoliklinik') . "?tanggalperiksa=" . $antrian->tanggalperiksa;
        return redirect()->to($url);
    }
    function lanjutfarmasi(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        try {
            $request['keterangan'] = "Pasien dilanjutkan ke farmasi";
            $request['taskid'] = "5";
            $now = now();
            $request['waktu'] = $now;
            $request['taskid5'] = $now;
            $request['status'] = 0;
            $request['user3'] = Auth::user()->id;
            $api = new AntrianController();
            // $res = $api->update_antrean($request);
            $antrian->update($request->all());
            // if ($res->metadata->code == 200) {
            $request['nomorantrean'] = $antrian->angkaantrean;
            $request['jenisresep'] = 'racikan';
            // $res_farmasi = $api->tambah_antrean_farmasi($request);
            // }
            Alert::success('Success', "Pasien dilanjutkan ke farmasi");
            $url = route('antrianpoliklinik') . "?tanggalperiksa=" . $antrian->tanggalperiksa;
            return redirect()->to($url);
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }
}
