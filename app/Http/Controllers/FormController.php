<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\AsesmenDokter;
use App\Models\AsesmenPerawat;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepKemoterapi;
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
    public function print_asesmen_perawat(Request $request)
    {
        $asesmen = AsesmenPerawat::firstWhere('kodekunjungan', $request->kodekunjungan);
        $antrian = $asesmen->antrian;
        $kunjungan = $antrian->kunjungan;
        return view('print.print_asesmen_perawat_rajal', compact([
            'request',
            'antrian',
            'kunjungan',
        ]));
    }
    public function print_resume_rajal(Request $request)
    {
        $asesmen = AsesmenPerawat::firstWhere('kodekunjungan', $request->kodekunjungan);
        $antrian = $asesmen->antrian;
        $kunjungan = $antrian->kunjungan;
        return view('print.print_resume_rajal', compact([
            'request',
            'antrian',
            'kunjungan',
        ]));
    }
    public function print_asesmen_rajal(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode', $request->kodekunjungan);
        $antrian = $kunjungan->antrian;
        $asesmenperawat = $kunjungan->asesmenperawat;
        $asesmendokter = $kunjungan->asesmendokter;
        return view('print.print_asesmen_rajal', compact([
            'request',
            'antrian',
            'kunjungan',
            'asesmenperawat',
            'asesmendokter',
        ]));
    }

    public function print_cppt(Request $request)
    {
        $pasien = Pasien::firstWhere('norm', $request->pasien);
        $kunjungans =  $pasien->kunjungans->sortByDesc('tgl_masuk');
        return view('print.print_cppt', compact([
            'request',
            'kunjungans',
            'pasien',
        ]));
    }
    public function print_resepkemoterapi(Request $request)
    {
        $resep = ResepKemoterapi::firstWhere('kode', $request->kode);
        $obatkemo = Obat::where('jenisobat', 'Obat Kemoterapi')->get();
        $penunjangkemo = Obat::where('jenisobat', 'Penunjang Kemoterapi')->get();
        return view('print.print_resep_kemoterapi', compact([
            'request',
            'resep',
            'obatkemo',
            'penunjangkemo',
        ]));
    }
}
