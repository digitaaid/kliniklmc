<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\SuratKontrol;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SuratKontrolController extends APIController
{
    public function index(Request $request)
    {
        $suratkontrols = null;
        if ($request->tanggal && $request->formatfilter) {
            $request['tglawal']  = Carbon::parse(explode('-', $request->tanggal)[0])->format('Y-m-d');
            $request['tglakhir'] = Carbon::parse(explode('-', $request->tanggal)[1])->format('Y-m-d');
            $vclaim = new VclaimController();
            $res = $vclaim->suratkontrol_tanggal($request);
            if ($res->metadata->code == 200) {
                $suratkontrols = $res->response->list;
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return view('bpjs.vclaim.suratkontrol', compact([
            'request',
            'suratkontrols',
        ]));
    }
    public function suratKontrolBpjs(Request $request)
    {
        $suratkontrol = null;
        if ($request->tanggal && $request->formatFilter) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalMulai'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalAkhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $vclaim = new VclaimController();
            $response =  $vclaim->suratkontrol_tanggal($request);
            if ($response->metadata->code == 200) {
                $suratkontrol = $response->response->list;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        if ($request->nomorkartu) {
            $bulan = explode('-', $request->bulan);
            $request['tahun'] = $bulan[0];
            $request['bulan'] = $bulan[1];
            $api = new VclaimController();
            $response =  $api->suratkontrol_peserta($request);
            if ($response->metadata->code == 200) {
                $suratkontrol = $response->response->list;
                Alert::success($response->metadata->message, 'Total Data Kunjungan BPJS ' . count($suratkontrol) . ' Pasien');
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.surat_kontrol_index', compact([
            'request', 'suratkontrol'
        ]));
    }
    public function edit($id)
    {
        $suratkontrol = SuratKontrol::find($id);
        return response()->json($suratkontrol);
    }
    public function store(Request $request)
    {
        $poli = Poliklinik::where('kodesubspesialis', $request->poliKontrol)->first();
        $request['user'] = Auth::user()->name;
        $request['noSep'] = $request->noSEP;
        $request['noSepAsalKontrol'] = $request->noSEP;
        $request['tglTerbitKontrol'] = now()->format('Y-m-d');
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_insert($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $request['noSuratKontrol'] = $suratkontrol->noSuratKontrol;
            $request['namaDokter'] = $suratkontrol->namaDokter;
            $request['kelamin'] = $suratkontrol->kelamin;
            $request['tglLahir'] = $suratkontrol->tglLahir;
            SuratKontrol::create($request->all());
            Alert::success('Success', 'Surat Kontrol Berhasil Dibuat.');
        } else {
            Alert::error('Gagal', $response->metadata->message);
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_update($request);
        return $response;
    }
    public function destroy(Request $request)
    {
        $request['user'] = "Klinik LMC";
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_delete($request);
        if ($response->metadata->code == 200) {
            try {
                $sk = SuratKontrol::firstWhere('noSuratKontrol', $request->noSuratKontrol);
                $sk->delete();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return $response;
    }
    public function suratKontrolPrint($nomorsuratkontrol, Request $request)
    {
        $request['noSuratKontrol'] = $nomorsuratkontrol;
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_nomor($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $sep = $response->response->sep;
            $peserta = $response->response->sep->peserta;
            $pasien = Pasien::firstWhere('no_Bpjs', $peserta->noKartu);
            $dokter = Dokter::firstWhere('kode_dokter_jkn', $suratkontrol->kodeDokter);
            return view('simrs.suratkontrol.suratkontrol_print', compact([
                'suratkontrol',
                'sep',
                'peserta',
                'pasien',
                'dokter',
            ]));
        } else {
            return $response->metadata->message;
        }
    }
    public function print(Request $request)
    {
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_nomor($request);
        if ($response->metadata->code == 200) {
            $suratkontrol = $response->response;
            $sep = $response->response->sep;
            $peserta = $response->response->sep->peserta;
            $dokter = Dokter::firstWhere('kodedokter', $suratkontrol->kodeDokter);
            $pdf = Pdf::loadView('print.pdf_suratkontrol', compact(
                'suratkontrol',
                'sep',
                'peserta',
                'dokter',
            ));
            return $pdf->stream('pdf_surat_kontrol.pdf');
        } else {
            return $response->metadata->message;
        }
    }
    public function suratkontrol_sep(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "nomorkartu" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $request['tanggalAkhir'] = now()->format('Y-m-d');
        $request['tanggalMulai'] = now()->subDays(90)->format('Y-m-d');
        $vclaim = new VclaimController();
        $response = $vclaim->monitoring_pelayanan_peserta($request);
        if ($response->metadata->code == 200) {
            $data = $response->response->histori;
            return $this->sendResponse($data, 200);
        } else {
            return $this->sendError($response->metadata->message);
        }
    }
    public function suratkontrol_hapus(Request $request)
    {
        $request['user'] = Auth::user()->name;
        $vclaim = new VclaimController();
        $response = $vclaim->suratkontrol_delete($request);
        if ($response->metadata->code == 200) {
            try {
                $sk = SuratKontrol::firstWhere('noSuratKontrol', $request->noSuratKontrol);
                $sk->delete();
                Alert::success('Success', 'Surat Kontrol behasil Dihapus');
            } catch (\Throwable $th) {
                //throw $th;
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        } else {
            Alert::error('Gagal', $response->metadata->message);
            return redirect()->back();
        }
    }
    public function suratkontrol_update_web(Request $request)
    {
        $api = new VclaimController();
        $res = $api->suratkontrol_update($request);
        if ($res->metadata->code == 200) {
            $request['success'] =  "Berhasil update tanggal surat kontrol.";
        } else {
            $request['error'] =  $res->metadata->message;
        }
        try {
            $res = $api->suratkontrol_nomor($request);
            if ($res->metadata->code == 200) {
                $suratkontrol = $res->response;
            } else {
                $request['error'] =  $res->metadata->message;
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        } catch (\Throwable $th) {
            $request['error'] = $th->getMessage();
            Alert::error('Gagal', $th->getMessage());
        }
        return view('sim.suratkontrol_cek', compact([
            'request',
            'suratkontrol',
        ]));
    }
    public function ceksuratkontrol(Request $request)
    {
        $suratkontrol = null;
        if ($request->noSuratKontrol) {
            $vclaim = new VclaimController();
            try {
                $res = $vclaim->suratkontrol_nomor($request);
                if ($res->metadata->code == 200) {
                    $suratkontrol = $res->response;
                } else {
                    $request['error'] =  $res->metadata->message;
                    Alert::error('Mohon Maaf', $res->metadata->message);
                }
            } catch (\Throwable $th) {
                $request['error'] = $th->getMessage();
                Alert::error('Gagal', $th->getMessage());
            }
        }
        return view('sim.suratkontrol_cek', compact([
            'request',
            'suratkontrol',
        ]));
    }
}
