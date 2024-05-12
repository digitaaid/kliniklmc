<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Carousel;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\TanyaJawab;
use App\Models\Testimoni;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user =  Auth::user();
        if (empty($user->email_verified_at)) {
            auth()->logout();
            return redirect()->route('login')->withErrors('Mohon maaf, akun anda belum diverifikasi');
        }
        $kunjungans = new Kunjungan;
        $antrians = new Antrian;
        $pasiens = Pasien::where('status', 1)->count();
        $dokters = Dokter::where('status', 1)->count();
        $units = Unit::where('status', 1)->count();
        $obats = Obat::where('status', 1)->count();

        $antriansep = $antrians::whereMonth('tanggalperiksa', now()->month)->where('sep', '!=', null)->count() ?? 1;
        $kunjungansep =  $kunjungans::whereMonth('tgl_masuk', now()->month)->where('sep', '!=', null)->count() ?? 1;
        return view('home', compact([
            'user',
            'request',
            'kunjungans',
            'antrians',
            'kunjungansep',
            'antriansep',
            'dokters',
            'pasiens',
            'units',
            'obats',
        ]));
    }
    public function landingpage()
    {
        $carousel = Carousel::get();
        $tanyajawab = TanyaJawab::get();
        $testimoni = Testimoni::get();
        $dokters = Dokter::get();
        $jadwals = JadwalDokter::get();
        return view('kitasehat', compact([
            'carousel',
            'tanyajawab',
            'testimoni',
            'dokters',
            'jadwals',
        ]));
    }
}
