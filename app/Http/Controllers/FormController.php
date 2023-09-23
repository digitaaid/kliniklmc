<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenDokter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FormController extends Controller
{
    public function form_identitaspasien(Request $request)
    {
        if ($request->printer == 1) {
            $pdf = Pdf::loadView('form.identitaspasien', compact(['request']));
            return $pdf->download('identitaspasien.pdf');
        }
        return view('form.identitaspasien', compact(['request']));
    }
    public function form_assesmentrajal(Request $request)
    {
        if ($request->printer == 1) {
            $pdf = Pdf::loadView('form.assesment_rajal', compact(['request']));
            // return $pdf->download('assesment_rajal.pdf');
            return $pdf->stream();
        }
        return view('form.assesment_rajal', compact(['request']));
    }
    public function form_assesmentdokter(Request $request)
    {
        if ($request->printer == 1) {
            $pdf = Pdf::loadView('form.pemeriksaan_dokter', compact(['request']));
            // return $pdf->download('assesment_rajal.pdf');
            return $pdf->stream();
        }
        return view('form.pemeriksaan_dokter', compact(['request']));
    }

    public function print_asesmenfarmasi(Request $request)
    {
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $kunjungan = $antrian->kunjungan;
        return view('print.print_asesmen_resep_obat', compact([
            'request',
            'antrian',
            'kunjungan',
        ]));
    }

    public function print_asesmendokter(Request $request)
    {
        $asesmen = AsesmenDokter::firstWhere('kodekunjungan', $request->id);
        $antrian = $asesmen->antrian;
        $kunjungan = $antrian->kunjungan;
        return view('print.print_asesmen_dokter_rajal', compact([
            'request',
            'antrian',
            'kunjungan',
        ]));
    }
}
