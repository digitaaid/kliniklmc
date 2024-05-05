<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Kunjungan;
use App\Models\Sep;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SepController extends Controller
{
    public function index(Request $request)
    {
        $kunjungans = Sep::where('tglSep', $request->tgl_masuk)->get();
        return view('sim.kunjungan_index', compact([
            'request',
            'kunjungans',
        ]));
    }
    public function sep_rajal(Request $request)
    {
        $sep = null;
        $vclaim = new VclaimController();
        if ($request->tanggal && $request->jenispelayanan) {
            $response =  $vclaim->monitoring_data_kunjungan($request);
            if ($response->metadata->code == 200) {
                $sep = $response->response->sep;
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.sep_rajal', compact(
            'request',
            'sep'
        ));
    }
    public function sep_ranap(Request $request)
    {
        $sep = null;
        $vclaim = new VclaimController();
        if ($request->tanggal && $request->jenispelayanan) {
            $response =  $vclaim->monitoring_data_kunjungan($request);
            if ($response->metadata->code == 200) {
                $sep = $response->response->sep;
            } else {
                Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
            }
        }
        return view('bpjs.vclaim.sep_ranap', compact(
            'request',
            'sep'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'noRujukan' => 'required_if:noSurat,null',
            'noSurat' => 'required_if:noRujukan,null',
        ]);
        $api = new VclaimController();
        if (!$request->tglSep) {
            $request['tglSep'] = now()->format('Y-m-d');
        }
        if (!$request->noKartu) {
            $request['noKartu'] = $request->nomorkartu;
        }
        if (!$request->noMR) {
            $request['noMR'] = $request->norm;
        }
        if (!$request->noTelp) {
            $request['noTelp'] = $request->nohp;
        }
        $request['ppkPelayanan'] = "0125S003";
        $request['eksekutif'] = "0";
        $request['user'] = Auth::user()->name;
        if ($request->flagProcedure == null) {
            $request['flagProcedure'] = "";
        }
        if ($request->kdPenunjang == null) {
            $request['kdPenunjang'] = "";
        }
        if ($request->assesmentPel == null) {
            $request['assesmentPel'] = "";
        }
        // kontrol
        if ($request->noSurat) {
            $request['noSuratKontrol'] = $request->noSurat;
            $request['nomorreferensi'] = $request->noSurat;
            $res_srt = $api->suratkontrol_nomor($request);
            $suratkontrol = $res_srt->response;
            $request['asalRujukan'] = $suratkontrol->sep->provPerujuk->asalRujukan;
            $request['tglRujukan'] = $suratkontrol->sep->provPerujuk->tglRujukan;
            $request['noRujukan'] = $suratkontrol->sep->provPerujuk->noRujukan;
            $request['ppkRujukan'] = $suratkontrol->sep->provPerujuk->kdProviderPerujuk;
            $request['jeniskunjungan'] = 3;
        } else {
            if ($request->asalRujukan == 2) {
                $request['jeniskunjungan'] = 4;
            } else {
                $request['jeniskunjungan'] = 1;
            }
            $request['nomorreferensi'] = $request->noRujukan;
        }
        $res = $api->sep_insert($request);
        if ($res->metadata->code == 200) {
            $sep = $res->response->sep;
            if ($request->kodebooking) {
                $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
                $antrian->update([
                    'sep' => $sep->noSep,
                    'nomorrujukan' => $request->noRujukan,
                    'nomorsuratkontrol' => $request->noSurat,
                    'jeniskunjungan' => $request->jeniskunjungan,
                    'nomorreferensi' => $request->nomorreferensi,
                ]);
            }
            Alert::success('Success', 'SEP berhasil dibuatkan');
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        return redirect()->back();
    }
    public function print(Request $request)
    {
        $vclaim = new VclaimController();
        $res = $vclaim->sep_nomor($request);
        if ($res->metadata->code == 200) {
            $sep = $res->response;
            $pdf = Pdf::loadView('print.pdf_sep', compact('sep'));
            return $pdf->stream('sep.pdf');
        } else {
            Alert::error('Gagal', 'SEP Tidak Ditemukan');
            return redirect()->back();
        }
    }
    public function sep_hapus(Request $request)
    {
        $vclaim = new VclaimController();
        $request['user'] = Auth::user()->name;
        $res = $vclaim->sep_delete($request);
        if ($res->metadata->code == 200) {
            $sep = $res->response;
            try {
                $antrian = Antrian::where('sep', $request->noSep)->first();
                $antrian->update([
                    'sep' => null
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
            Alert::success('Success', 'SEP behasil Dihapus');
            return redirect()->back();
        } else {
            Alert::error('Gagal', $res->metadata->message);
            return redirect()->back();
        }
    }
    public function laporansep(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('jenispasien', 'JKN')
                ->get();
        }
        return view('sim.laporan_sep', compact([
            'request',
            'antrians',
        ]));
    }
    public function pdflaporansep(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('jenispasien', 'JKN')
                ->get();
        }
        // return view('sim.pdf_laporan_sep',compact([
        //     'request',
        //     'antrians',
        // ]));
        $pdf = Pdf::loadView('sim.pdf_laporan_sep', compact([
            'request',
            'antrians',
        ]));
        return $pdf->download();
    }
    public function list_approval_sep(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $tanggal = explode('-', $request->tanggal);
            $request['tahun'] = $tanggal[0];
            $request['bulan'] = $tanggal[1];
            $api = new VclaimController();
            $response =  $api->list_approval_sep($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);
                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.vclaim.approval_sep', compact([
            'request',
            'antrians',
        ]));
    }
    public function pengajuan_approval_sep(Request $request)
    {
        $request->validate([
            "noKartu" => "required",
            "tglSep" => "required",
            "jnsPelayanan" => "required",
            "jnsPengajuan" => "required",
            "keterangan" => "required",
        ]);
        $request['user'] = Auth::user()->name;
        $api = new VclaimController();
        $res = $api->pengajuan_approval_sep($request);
        if ($res->metadata->code == 200) {
            Alert::success('Success', $res->metadata->message);
        } else {
            Alert::error('Mohon Maaf', $res->metadata->message);
        }
        return redirect()->back();
    }
    public function approval_sep(Request $request)
    {
        $request->validate([
            "noKartu" => "required",
            "tglSep" => "required",
            "jnsPelayanan" => "required",
            "jnsPengajuan" => "required",
            "keterangan" => "required",
        ]);
        $request['user'] = Auth::user()->name;
        $api = new VclaimController();
        $res = $api->approval_sep($request);
        if ($res->metadata->code == 200) {
            Alert::success('Success', $res->metadata->message);
        } else {
            Alert::error('Mohon Maaf', $res->metadata->message);
        }
        return redirect()->back();
    }
}
