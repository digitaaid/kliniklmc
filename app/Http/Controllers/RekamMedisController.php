<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function resumerawatjalan(Request $request)
    {
        dd($request->all());
    }
    public function diagnosa_rekammedis(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->has('kunjungan')->where('kodepoli', '!=', 'FAR')
                ->get();
        }
        return view('sim.antrian_rekammedis', compact('request', 'antrians'));
    }
}
