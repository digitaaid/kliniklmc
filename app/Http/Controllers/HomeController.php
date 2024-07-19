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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $antrianPerBulan = Antrian::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->where('method', 'Mobile JKN')
            ->whereYear('created_at', now()->year) // Menambahkan filter untuk tahun saat ini
            ->has('kunjungan')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc') // Mengurutkan hasil berdasarkan bulan
            ->get();
        $jumlahAntrianPerBulan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Menggunakan intval() untuk memastikan nilai adalah integer
            $jumlah = intval($antrianPerBulan->firstWhere('bulan', $bulan)['jumlah'] ?? 0);
            array_push($jumlahAntrianPerBulan, $jumlah);
        }
        $antrianjkn = $jumlahAntrianPerBulan;

        $antrianPerBulan = Antrian::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->where('method', '!=', 'Mobile JKN')
            ->whereYear('created_at', now()->year) // Menambahkan filter untuk tahun saat ini
            ->has('kunjungan')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc') // Mengurutkan hasil berdasarkan bulan
            ->get();
        $jumlahAntrianPerBulan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Menggunakan intval() untuk memastikan nilai adalah integer
            $jumlah = intval($antrianPerBulan->firstWhere('bulan', $bulan)['jumlah'] ?? 0);
            array_push($jumlahAntrianPerBulan, $jumlah);
        }
        $antrianlainya = $jumlahAntrianPerBulan;

        $hariIni = now();
        $tahunIni = $hariIni->year;
        $bulanIni = $hariIni->month;
        $jumlahHariDalamBulan = $hariIni->daysInMonth;
        $antrianPerTanggal = Antrian::select(DB::raw('DAY(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->where('method', '!=', 'Mobile JKN')
            ->whereYear('created_at', $tahunIni) // Filter untuk tahun saat ini
            ->whereMonth('created_at', $bulanIni) // Filter untuk bulan saat ini
            ->has('kunjungan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc') // Mengurutkan hasil berdasarkan tanggal
            ->get();
        $jumlahAntrianPerTanggal = [];
        for ($tanggal = 1; $tanggal <= $jumlahHariDalamBulan; $tanggal++) {
            // Menggunakan intval() untuk memastikan nilai adalah integer
            $jumlah = intval($antrianPerTanggal->firstWhere('tanggal', $tanggal)['jumlah'] ?? 0);
            array_push($jumlahAntrianPerTanggal, $jumlah);
        }
        $antrianbulaniniumum = $jumlahAntrianPerTanggal;


        $hariIni = now();
        $tahunIni = $hariIni->year;
        $bulanIni = $hariIni->month;
        $jumlahHariDalamBulan = $hariIni->daysInMonth;
        $antrianPerTanggal = Antrian::select(DB::raw('DAY(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->where('method', 'Mobile JKN')
            ->whereYear('created_at', $tahunIni) // Filter untuk tahun saat ini
            ->whereMonth('created_at', $bulanIni) // Filter untuk bulan saat ini
            ->has('kunjungan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc') // Mengurutkan hasil berdasarkan tanggal
            ->get();
        $jumlahAntrianPerTanggal = [];
        for ($tanggal = 1; $tanggal <= $jumlahHariDalamBulan; $tanggal++) {
            // Menggunakan intval() untuk memastikan nilai adalah integer
            $jumlah = intval($antrianPerTanggal->firstWhere('tanggal', $tanggal)['jumlah'] ?? 0);
            array_push($jumlahAntrianPerTanggal, $jumlah);
        }
        $antrianbulaninijkn = $jumlahAntrianPerTanggal;

        $jumlahHariDalamBulan = $hariIni->daysInMonth;
        $tanggalDalamBulanIni = range(1, $jumlahHariDalamBulan);
        // $antrianjkn = [65, 59, 80, 81, 56, 55, 40];
        // dd($tanggalDalamBulanIni, $antrianbulanini);
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
            'antrianjkn',
            'antrianlainya',
            'tanggalDalamBulanIni',
            'antrianbulaniniumum',
            'antrianbulaninijkn',
        ]));
    }
    public function landingpage()
    {
        $carousel = Carousel::get();
        $tanyajawab = TanyaJawab::get();
        $testimoni = Testimoni::get();
        $dokters = Dokter::get();
        $jadwals = JadwalDokter::get();
        return view('welcome', compact([
            'carousel',
            'tanyajawab',
            'testimoni',
            'dokters',
            'jadwals',
        ]));
    }
}
