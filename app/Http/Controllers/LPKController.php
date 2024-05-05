<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LPKController extends Controller
{
    public function index(Request $request)
    {
        $lpk = null;
        if ($request->tanggal && $request->jenispelayanan) {
            $vclaim = new VclaimController();
            $res = $vclaim->data_lpk($request);
            if ($res->metadata->code == 200) {
                $lpk = $res->response->list;
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return view('bpjs.vclaim.lpk', compact([
            'request',
            'lpk',
        ]));
    }
}
