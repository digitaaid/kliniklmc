<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Sep;
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
    public function store(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'noRujukan' => 'required_if:noSurat,null',
            'noSurat' => 'required_if:noRujukan,null',
        ]);
        $api = new VclaimController();
        $request['tglSep'] = now()->format('Y-m-d');
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
            $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
            $antrian->update([
                'sep' => $sep->noSep,
                'nomorrujukan' => $request->noRujukan,
                'nomorsuratkontrol' => $request->noSurat,
                'jeniskunjungan' => $request->jeniskunjungan,
                'nomorreferensi' => $request->nomorreferensi,
            ]);
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
            $antrian = Antrian::where('sep', $request->noSep)->first();
            return view('print.print_sep', compact([
                'sep',
                'antrian',
            ]));
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
}
