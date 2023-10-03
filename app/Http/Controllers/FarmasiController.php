<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FarmasiController extends Controller
{
    public function laporanfarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                ->where('taskid', '!=', 99)
                ->get();
        }
        return view('sim.laporan_farmasi', compact([
            'request',
            'antrians',
        ]));
    }
}
