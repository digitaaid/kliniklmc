<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PrintController extends Controller
{
    public function printtest()
    {
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();

        $pdf = Pdf::loadView('print.pdf_print');
        return $pdf->setPaper('A8')->stream('pdf_asesmen_ranap_awal.pdf');


        // return view('print.pdf_print');
        // return $pdf->stream('pdf_asesmen_ranap_awal.pdf');

        // $pdf = Pdf::loadView('simrs.ranap.pdf_asesmen_ranap_awal', compact('kunjungan', 'pasien'));
        // return $pdf->stream('pdf_asesmen_ranap_awal.pdf');

        // Pdf::loadHTML('<h1>Test</h1>')->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')
    }
}
