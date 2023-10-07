<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenPerawat;
use App\Models\Dokter;
use App\Models\FileUploadPasien;
use App\Models\Kunjungan;
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
            // $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
            // $polikliniks = Poliklinik::where('status', '1')->pluck('namasubspesialis', 'kodesubspesialis');
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
                // 'dokters',
                // 'polikliniks',
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
                // $dokters = Dokter::where('status', '1')->pluck('namadokter', 'kodedokter');
                // $polikliniks = Unit::where('status', '1')->pluck('nama', 'kode');
                $kunjungan = $antrian->kunjungan;
                if (empty($antrian->asesmenperawat)) {
                    Alert::info('Informasi', 'Silahkan Lakukan Assemen Keperawatan.');
                }
                return view('sim.antrian_perawat_proses', compact([
                    'request',
                    'antrian',
                    // 'dokters',
                    // 'polikliniks',
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
            $request['user'] = Auth::user()->id;
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
            $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking)->first();
            $antrian->update([
                'user2' => Auth::user()->id,
            ]);
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
