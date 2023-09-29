<?php

namespace App\Http\Controllers;

use App\Imports\PasiensImport;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends APIController
{
    public function index(Request $request)
    {

        if ($request->search) {
            $pasiens = Pasien::orderBy('norm', 'desc')
                ->where('norm', 'LIKE', "%{$request->search}%")
                ->orWhere('nama', 'LIKE', "%{$request->search}%")
                ->orWhere('nomorkartu', 'LIKE', "%{$request->search}%")
                ->orWhere('nik', 'LIKE', "%{$request->search}%")
                ->simplePaginate(20);
        } else {
            $pasiens = Pasien::orderBy('norm', 'desc')->simplePaginate(20);;
        }
        $total_pasien = Pasien::count();
        // $pasien_jkn = Pasien::where('no_Bpjs', '!=', '')->count();
        // $pasien_nik = Pasien::where('nik_bpjs', '!=', '')->count();
        // $pasien_laki = Pasien::where('jenis_kelamin', 'L')->count();
        // $pasien_perempuan = Pasien::where('jenis_kelamin', 'P')->count();
        return view('sim.pasien_index', compact([
            'request',
            'pasiens',
            'total_pasien',
        ]));
    }
    public function create()
    {
        $file = public_path('pasien.xlsx');
        Excel::import(new PasiensImport, $file);
        return redirect()->route('pasien.index');
    }
    public function update($id, Request $request)
    {
        $pasien = Pasien::find($id);
        $pasien->update($request->all());
        Alert::success('Success', 'Data Pasien Diperbaharui.');
        return redirect()->back();
    }
    public function fingerprintPeserta(Request $request)
    {
        $peserta = null;
        if ($request->nomorkartu) {
            $request['jenisIdentitas'] = 'noka';
            $request['noIdentitas'] = $request->nomorkartu;
            $api = new AntrianController();
            $response =  $api->ref_pasien_fingerprint($request);
            if ($response->metadata->code == 200) {
                $peserta = $response->response;
                if ($peserta->daftarfp == 0) {
                    Alert::error('Maaf', 'Pasien Belum memeliki Fingerprint BPJS');
                } else {
                    Alert::success('Success', 'Pasien Belum memeliki Fingerprint BPJS');
                }
            } else {
                Alert::error('Maaf', $response->metadata->message);
            }
        }
        return view('bpjs.antrian.fingerprint_peserta', compact([
            'request',
            'peserta'
        ]));
    }
}
