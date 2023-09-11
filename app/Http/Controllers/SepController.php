<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
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
            $request['nomorreferensi'] = $request->noSurat;
            $res_srt = $api->suratkontrol_nomor($request);
            $suratkontrol = $res_srt->response;
            $request['asalRujukan'] = $suratkontrol->sep->provPerujuk->asalRujukan;
            $request['tglRujukan'] = $suratkontrol->sep->provPerujuk->tglRujukan;
            $request['noRujukan'] = $suratkontrol->sep->provPerujuk->noRujukan;
            $request['ppkRujukan'] = $suratkontrol->sep->provPerujuk->kdProviderPerujuk;
        } else {
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
                'nomorreferensi' => $request->nomorreferensi,
            ]);
            Alert::success('Success', 'SEP berhasil dibuatkan');
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        return redirect()->back();
    }
}
