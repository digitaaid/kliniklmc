<?php

namespace App\Http\Controllers;

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

}
