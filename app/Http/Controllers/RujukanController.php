<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RujukanController extends Controller
{
    public function index(Request $request)
    {
        $rujukans = null;
        if ($request->tanggal) {
            $request['tglMulai']  = Carbon::parse(explode('-', $request->tanggal)[0])->format('Y-m-d');
            $request['tglAkhir'] = Carbon::parse(explode('-', $request->tanggal)[1])->format('Y-m-d');
            $vclaim = new VclaimController();
            $res = $vclaim->list_rujukan_keluar($request);
            if ($res->metadata->code == 200) {
                $rujukans = $res->response->list;
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return view('bpjs.vclaim.rujukan', compact([
            'request',
            'rujukans',
        ]));
    }
    public function rujukankhusus(Request $request)
    {
        $rujukans = null;
        if ($request->tanggal) {
            $request['tglMulai']  = Carbon::parse(explode('-', $request->tanggal)[0])->format('Y-m-d');
            $request['tglAkhir'] = Carbon::parse(explode('-', $request->tanggal)[1])->format('Y-m-d');
            $vclaim = new VclaimController();
            $res = $vclaim->list_rujukan_keluar($request);
            if ($res->metadata->code == 200) {
                $rujukans = $res->response->list;
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return view('bpjs.vclaim.rujukan', compact([
            'request',
            'rujukans',
        ]));
    }
}
