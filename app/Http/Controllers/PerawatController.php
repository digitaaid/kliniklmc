<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenPerawat;
use App\Models\Dokter;
use App\Models\FileUploadPasien;
use App\Models\Jaminan;
use App\Models\Kunjungan;
use App\Models\PemeriksaanLab;
use App\Models\Poliklinik;
use App\Models\Unit;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PerawatController extends Controller
{
    // perawat
    public function antrianperawat(Request $request)
    {
        $antrians = null;
        $antrian_asesmen = null;
        if ($request->tanggalperiksa) {
            $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->where('taskid', '!=', 99)->get();
            $antrian_asesmen = Antrian::where('tanggalperiksa', $request->tanggalperiksa)->whereHas('asesmenperawat')->count();
        }
        return view('sim.antrian_perawat', compact([
            'request',
            'antrians',
            'antrian_asesmen',
        ]));
    }
    public function prosesperawat(Request $request)
    {
        $antrian = Antrian::with(['kunjungan', 'kunjungan.asesmenperawat'])->where('kodebooking', $request->kodebooking)->first();
        $urlicare = null;
        $messageicare = null;
        $jaminans = Jaminan::pluck('nama', 'kode');
        if ($antrian) {
            // icare
            // $api = new IcareController();
            // $request['nomorkartu'] = $antrian->nomorkartu;
            // $request['kodedokter'] = $antrian->kodedokter;
            // $res =  $api->icare($request);
            // if ($res->metadata->code == 200) {
            //     $urlicare = $res->response->url;
            //     $messageicare = 'ok';
            // } else {
            //     $messageicare = $res->metadata->message;
            // }
            $kunjungan = $antrian->kunjungan;
            $kunjungans = Kunjungan::where('norm', $antrian->norm)
                ->with(['units', 'asesmenperawat', 'asesmendokter', 'files', 'resepobat', 'resepobat.resepdetail'])
                ->orderBy('tgl_masuk', 'DESC')
                ->get();
            if (empty($antrian->asesmenperawat)) {
                Alert::info('Informasi', 'Silahkan Lakukan Assemen Keperawatan.');
            }
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
            return view('sim.antrian_perawat_proses', compact([
                'request',
                'jaminans',
                'antrian',
                'urlicare',
                'messageicare',
                'kunjungans',
                'kunjungan',
                'pemeriksaanlab',
                'permintaanlab',
                'hasillab',
            ]));
        } else {
            Alert::error('Mohon Maaf', 'Antrian tidak ditemukan');
            return redirect()->back();
        }
    }
    public function editasesmenperawat(Request $request)
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
        if ($request->tinggi_badan && $request->berat_badan) {
            $request['bsa'] = number_format(sqrt(($request->tinggi_badan * $request->berat_badan) / 3600), 2) ?? null;
        }
        AsesmenPerawat::updateOrCreate(
            [
                'kodebooking' => $request->kodebooking,
                'antrian_id' => $request->antrian_id,
                'kodekunjungan' => $request->kodekunjungan,
                'kunjungan_id' => $request->kunjungan_id,
            ],
            $request->all()
        );
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking)->first();
        $antrian->update([
            'user2' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Simpan Assemen Keperawatan.');
        return redirect()->back();
    }
    public function uploadberkas(Request $request)
    {
        dd($request->all());
        try {
            $url = 'http://103.39.50.206/lmc/public/api/uploadfile';
            $file               = request('file');
            $file_path          = $file->getPathname();
            $file_mime          = $file->getMimeType('application/pdf');
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
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }
    public function hapusfilepenunjang(Request $request)
    {
        $file = FileUploadPasien::find($request->id);
        $file->delete();
        Alert::success('Success', 'File Penunjang Pasien berhasil dihapus.');
        return redirect()->back();
    }
    public function laporanperawat(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('taskid', '!=', 99)
                ->get();
        }
        return view('sim.laporan_perawat', compact([
            'request',
            'antrians',
        ]));
    }
}
