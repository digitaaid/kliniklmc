<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\TanyaJawab;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->email_verified_at == null) {
            auth()->logout();
            return redirect()->route('login')->withErrors("Mohon maaf, akun anda belum diverifikasi.");
        }
        $request['tahun'] = now()->format('Y');
        $request['bulan'] = now()->format('m');
        $request['waktu'] = 'rs';
        $api = new AntrianController();
        $antrians = null;
        $tanggalantrian = null;
        $jumlahantrian = null;
        $waktuantrian = null;
        $response =  $api->dashboard_bulan($request);
        if ($response->metadata->code == 200) {
            $antrians = collect($response->response->list);
            foreach ($antrians as  $value) {
                $tanggalantrian[] = $value->tanggal;
                $jumlahantrian[] = $value->jumlah_antrean;
                $waktuantrian[] = $value->avg_waktu_task1 + $value->avg_waktu_task2 + $value->avg_waktu_task3 + $value->avg_waktu_task4 + $value->avg_waktu_task5 + $value->avg_waktu_task6;
            }
            Alert::success($response->metadata->message . ' ' . $response->metadata->code);
        } else {
            Alert::error($response->metadata->message . ' ' . $response->metadata->code);
        }
        return view('home', compact([
            'user',
            'request',
            'antrians',
            'tanggalantrian',
            'jumlahantrian',
            'waktuantrian',
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
