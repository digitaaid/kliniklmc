<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KunjunganController extends APIController
{
    public function index(Request $request)
    {
        if ($request->tgl_masuk) {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)->get();
        } else {
            $kunjungans = Kunjungan::orderby('created_at', 'desc')->simplePaginate(25);
        }
        return view('sim.kunjungan_index', compact([
            'request',
            'kunjungans',
        ]));
    }
    public function kunjunganwaktu(Request $request)
    {
        $kunjungans = null;
        if ($request->waktu) {
            $tanggal = Carbon::parse($request->waktu)->format('Y-m-d');
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $tanggal)->get();
        }
        return $this->sendResponse($kunjungans, 200);
    }
}
