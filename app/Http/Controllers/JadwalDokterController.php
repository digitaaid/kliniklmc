<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poliklinik;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        $polikliniks = Poliklinik::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        $dokters = Dokter::get();
        $jadwaldokter = JadwalDokter::get();
        $request['tanggal'] = $request->tanggal ? $request->tanggal : now()->format('Y-m-d');
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $controller = new AntrianController();
            $response = $controller->ref_jadwal_dokter($request);
            if ($response->metadata->code == 200) {
                $jadwals = $response->response;
                Alert::success($response->metadata->message, 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('sim.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'units',
            'jadwals',
            'dokters',
            'jadwaldokter',
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kodesubspesialis' => 'required',
            'kodedokter' => 'required',
            'hari' => 'required',
            'jadwal' => 'required',
            'kapasitaspasien' => 'required',
        ]);
        $request['user'] = Auth::user()->name;
        if ($request->libur == "true") {
            $request['libur'] = 1;
        } else {
            $request['libur'] = 0;
        }
        if (empty($request->namasubspesialis)) {
            $poli = Unit::firstWhere('kode', $request->kodesubspesialis);
            $request['kodepoli'] = $poli->kode;
            $request['namapoli'] = $poli->nama;
            $request['namasubspesialis'] = $poli->nama;
        }
        if (empty($request->namadokter)) {
            $dokter = Dokter::firstWhere('kodedokter', $request->kodedokter);
            $request['namadokter'] = $dokter->namadokter;
        }
        $hari = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
        $jadwal = JadwalDokter::updateOrCreate([
            'kodesubspesialis' => $request->kodesubspesialis,
            'kodedokter' => $request->kodedokter,
            'hari' => $request->hari,
            'jadwal' => $request->jadwal,
        ], [
            'kodepoli' => $request->kodepoli,
            'namapoli' => $request->namapoli,
            'namasubspesialis' => $request->namasubspesialis,
            'namadokter' => $request->namadokter,
            'namahari' => $hari[$request->hari],
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $request->libur,
            'user' => $request->user,
        ]);
        Alert::success('Ok', 'Jadwal Dokter ditambahkan.');
        return redirect()->back();
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'jadwal' => 'required',
            'kapasitaspasien' => 'required',
        ]);
        if ($request->libur == "true") {
            $libur = 1;
        } else {
            $libur = 0;
        }
        $jadwal = JadwalDokter::find($id);
        $dokter = Dokter::firstWhere('kodedokter', $request->kodedokter);
        $poli = Unit::firstWhere('kode', $request->kodesubspesialis);
        $hari = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
        $jadwal->update([
            'kodesubspesialis' =>  $poli->kode,
            'namasubspesialis' =>  $poli->nama,
            'kodepoli' =>  $poli->kode,
            'namapoli' =>  $poli->nama,
            'kodedokter' =>  $dokter->kodedokter,
            'namadokter' =>  $dokter->namadokter,
            'hari' =>  $request->hari,
            'namahari' =>  $hari[$request->hari],
            'jadwal' => $request->jadwal,
            'kapasitaspasien' => $request->kapasitaspasien,
            'libur' => $libur,
        ]);
        Alert::success('Success', 'Jadwal Dokter Telah Diupdate');
        return redirect()->back();
    }
    public function jadwalDokterAntrianBpjs(Request $request)
    {
        $polikliniks = Poliklinik::where('status', 1)->get();
        $jadwal_save = JadwalDokter::all();
        // get jadwal
        $jadwals = null;
        if (isset($request->kodepoli)) {
            $api = new AntrianController();
            $response = $api->ref_jadwal_dokter($request);
            if ($response->metadata->code == 200) {
                $jadwals = $response->response;
                Alert::success($response->metadata->message, 'Jadwal Dokter Antrian BPJS Total : ' . count($jadwals));
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.jadwal_dokter', compact([
            'request',
            'polikliniks',
            'jadwals',
            'jadwal_save',
        ]));
    }
    public function destroy($id, Request $request)
    {
        $jadwal = JadwalDokter::find($id);
        $jadwal->delete();
        Alert::success('Success', 'Jadwal Telah Dihapus');
        return back();
    }
}
