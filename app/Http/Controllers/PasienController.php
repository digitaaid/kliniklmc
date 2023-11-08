<?php

namespace App\Http\Controllers;

use App\Exports\PasienExport;
use App\Imports\PasienFileImport;
use App\Imports\PasiensImport;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\Kabupaten;
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
        $kabupaten = Kabupaten::where('province_code', '32')->pluck('name', 'code');
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
    public function reset()
    {
        $pasiens = Pasien::all();
        foreach ($pasiens as  $value) {
            $value->delete();
        }
        return redirect()->route('pasien.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|digits:16',
            'nohp' => 'required',
            'gender' => 'required',
        ]);
        if (empty($request->norm)) {
            $pasien_terakhir = Pasien::orderBy('norm', 'desc')->first();
            if ($pasien_terakhir) {
                $norm = sprintf("%09d", $pasien_terakhir->norm + 1);
            } else {
                $norm = '000000001';
            }
            $request['norm'] = $norm;
        }
        $request['user'] = Auth::user()->id;
        $pasien = Pasien::updateOrCreate(
            [
                'nik' => $request->nik,
                'norm' => $request->norm,
            ],
            $request->all()
        );
        Alert::success('Sucess', 'Data Pasien Berhasil Ditambahkan.');
        return redirect()->route('pasien.index');
    }
    public function update($id, Request $request)
    {
        $request['user'] = Auth::user()->id;
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
    public function search(Request $request)
    {
        $pasiens = Pasien::orderBy('norm', 'desc')
            ->where('norm', 'LIKE', "%{$request->search}%")
            ->orWhere('nama', 'LIKE', "%{$request->search}%")
            ->orWhere('nomorkartu', 'LIKE', "%{$request->search}%")
            ->orWhere('nik', 'LIKE', "%{$request->search}%")
            ->limit(20)
            ->get();
        return $this->sendResponse($pasiens, 200);
    }
    public function riwayatpasien(Request $request)
    {
        $pasien = Pasien::with(['kunjungans', 'antrians'])->firstWhere('norm', $request->norm);
        Alert::success('Sucess', 'Data Pasien Berhasil Ditambahkan.');
        return view('sim.riwayat_pasien', compact([
            'pasien'
        ]));
    }
    public function destroy($id, Request $request)
    {
        $pasien = Pasien::find($id);
        if ($pasien->status) {
            $status = 0;
        }
        $pasien->update([
            'status' => $status ?? 1,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Pasien Dinonaktifkan.');
        return redirect()->back();
    }
    public function pasienexport()
    {
        return Excel::download(new PasienExport, 'pasien.xlsx');
    }
    public function pasienimport(Request $request)
    {
        Excel::import(new PasienFileImport, $request->file);
        Alert::success('Success', 'Import Pasien Berhasil.');
        return redirect()->route('pasien.index');
    }
}
