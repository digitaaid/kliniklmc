<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SepController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());
    }
    public function store(Request $request)
    {

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
            $res_srt = $api->suratkontrol_nomor($request);
            $suratkontrol = $res_srt->response;
            $request['asalRujukan'] = $suratkontrol->sep->provPerujuk->asalRujukan;
            $request['tglRujukan'] = $suratkontrol->sep->provPerujuk->tglRujukan;
            $request['noRujukan'] = $suratkontrol->sep->provPerujuk->noRujukan;
            $request['ppkRujukan'] = $suratkontrol->sep->provPerujuk->kdProviderPerujuk;
        } else {
            # code...
        }
        $res = $api->sep_insert($request);
        if ($res->metadata->code == 200) {
            dd($request->all(), $res);
        } else {
            Alert::error('Error', $res->metadata->message);
            return redirect()->back();
        }
    }
}
