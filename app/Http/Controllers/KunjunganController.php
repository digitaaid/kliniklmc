<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tgl_masuk) {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)->get();
        }else{
            $kunjungans = Kunjungan::simplePaginate(25);
        }
        return view('sim.kunjungan_index', compact([
            'request',
            'kunjungans',
        ]));
    }
}
