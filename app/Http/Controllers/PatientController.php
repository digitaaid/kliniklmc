<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Kabupaten;

class PatientController extends SatuSehatController
{
    public function index(Request $request)
    {
        if ($request->search) {
            $pasiens = Pasien::orderBy('norm', 'desc')
                ->where('norm', 'LIKE', "%{$request->search}%")
                ->orWhere('nama', 'LIKE', "%{$request->search}%")
                ->orWhere('nomorkartu', 'LIKE', "%{$request->search}%")
                ->orWhere('nik', 'LIKE', "%{$request->search}%")
                ->with(['pic'])->simplePaginate(20);
        } else {
            $pasiens = Pasien::orderBy('norm', 'desc')->with(['pic'])->simplePaginate(20);;
        }
        $total_pasien = Pasien::count();
        $kabupaten = Kabupaten::where('province_code', '32')->pluck('name', 'code');
        return view('sim.pasien_index', compact([
            'request',
            'pasiens',
            'total_pasien',
        ]));
    }
}
