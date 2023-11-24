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
                ->with(['pic'])->simplePaginate(20);
        } else {
            $pasiens = Pasien::orderBy('norm', 'desc')->with(['pic'])->simplePaginate(20);;
        }
        $total_pasien = Pasien::count();
        $kabupaten = Kabupaten::where('province_code', '32')->pluck('name', 'code');
        return view('sim.pasien_index', compact([
            'request',
            'pasiens',
            'total_pasien',
        ]));
    }
    public function create()
    {
        // $file = public_path('pasien.xlsx');
        // Excel::import(new PasiensImport, $file);
        return redirect()->route('pasien.index');
    }
    public function reset()
    {
        // $pasiens = Pasien::all();
        // foreach ($pasiens as  $value) {
        //     $value->delete();
        // }
        return redirect()->route('pasien.index');
    }
    public function store(Request $request)
    {
        try {
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
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
        }
        return redirect()->route('pasien.index');
    }
    public function update($id, Request $request)
    {
        try {
            $request['user'] = Auth::user()->id;
            $pasien = Pasien::find($id);
            $pasien->update($request->all());
            Alert::success('Success', 'Data Pasien Diperbaharui.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
        }
        return redirect()->back();
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
    public function destroy($id, Request $request)
    {
        $pasien = Pasien::find($id);
        $pasien->update([
            'status' => !$pasien->status,
            'user' => Auth::user()->id,
        ]);
        Alert::success('Success', 'Data Pasien Dinonaktifkan.');
        return redirect()->back();
    }
    public function pasienexport()
    {
        $time = now()->format('Y-m-d');
        return Excel::download(new PasienExport, 'pasien_backup_' . $time . '.xlsx');
    }
    public function pasienimport(Request $request)
    {
        try {
            Excel::import(new PasienFileImport, $request->file);
            Alert::success('Success', 'Import Pasien Berhasil.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
        }
        return redirect()->route('pasien.index');
    }
    public function riwayatpasien(Request $request)
    {
        $pasien = Pasien::with(['kunjungans', 'antrians'])->firstWhere('norm', $request->norm);
        Alert::success('Sucess', 'Data Pasien Berhasil Ditambahkan.');
        return view('sim.riwayat_pasien', compact([
            'pasien'
        ]));
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
