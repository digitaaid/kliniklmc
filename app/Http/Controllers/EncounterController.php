<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function index(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->has('kunjungan')->get();
        }
        return view('sim.antrian_rekammedis', compact('request', 'antrians'));
    }
}
