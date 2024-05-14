<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    //
    public function layanan_keuangan(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->has('kunjungan')
                ->get();
        }
        return view('sim.antrian_keuangan', compact('request', 'antrians'));
    }
}
