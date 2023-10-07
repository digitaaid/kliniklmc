<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenDokter;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\ResepObat;
use App\Models\ResepObatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $dokter = Dokter::get();
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
        $dokter->update($request->all());
        Alert::success("Success", 'Data dokter berhasil diupdate.');
        return redirect()->route('dokter.index');
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
                    $api = new AntrianController();
                    $request['taskid'] = "3";
                    $request['waktu'] = now()->subMinutes(random_int(4, 9));
                    $res = $api->update_antrean($request);
                    $request['taskid'] = "4";
                    $request['waktu'] = now();
                    $res = $api->update_antrean($request);
                    // if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => $request->taskid,
                        'panggil' => 0,
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
        $request['user'] = Auth::user()->id;
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
                if ($res->metadata->code == 200) {
                    $antrian->update([
                        'taskid' => '7',
                        'user3' => Auth::user()->id,
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
                $request['user3'] = Auth::user()->id;
                $api = new AntrianController();
                $res = $api->update_antrean($request);
                $antrian->update($request->all());
                // if ($res->metadata->code == 200) {
                $request['nomorantrean'] = $antrian->angkaantrean;
                $request['jenisresep'] = 'racikan';
                $res_farmasi = $api->tambah_antrean_farmasi($request);
                // }
                Alert::success('Success', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }
}
