<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $kunjungans = Kunjungan::where('tgl_masuk', $request->tgl_masuk)->get();
        return view('sim.kunjungan_index', compact([
            'request',
            'kunjungans',
        ]));
    }
}
