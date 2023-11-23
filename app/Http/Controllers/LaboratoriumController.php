<?php

namespace App\Http\Controllers;

use App\Imports\PemeriksaanLabImport;
use App\Models\PemeriksaanLab;
use App\Models\PermintaanLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class LaboratoriumController extends Controller
{
    public function index()
    {
        $tarifs = PemeriksaanLab::get();
        return view('sim.pemeriksaanlab_index', compact([
            'tarifs'
        ]));
    }
    public function create()
    {
        $file = public_path('pemeriksaanlab.xlsx');
        Excel::import(new PemeriksaanLabImport, $file);
        return redirect()->route('pemeriksaanlab.index');
    }
    public function store(Request $request)
    {
        PemeriksaanLab::updateOrCreate(
            [
                'code' => $request->code,
            ],
            $request->all(),
        );
        Alert::success('Success', 'Data Pemeriksaan Laboratium Telah Disimpan');
        return redirect()->back();
    }
    public function permintaanlab_simpan(Request $request)
    {
        $request['permintaan_lab'] = json_encode($request->permintaan_lab);
        $request['user'] = Auth::user()->id;
        PermintaanLab::updateOrCreate(
            [
                'antrian_id' => $request->antrian_id,
                'kodebooking' => $request->kodebooking,
                'kunjungan_id' => $request->kunjungan_id,
                'kodekunjungan' => $request->kodekunjungan,
            ],
            $request->all()
        );
        Alert::success('Success', 'Berhasil simpan permintaan laboratorium');
        return redirect()->back();
    }
    public function permintaanlab_index(Request $request)
    {
        $permintaanlab = PermintaanLab::get();
        $pemeriksaanlab = PemeriksaanLab::pluck('nama', 'code');
        return view('sim.permintaanlab_index', compact([
            'request',
            'permintaanlab',
            'pemeriksaanlab',
        ]));
    }
    public function permintaanlab_proses(Request $request)
    {
        $permintaan = PermintaanLab::firstWhere('kode', $request->kode);
        $kode = json_decode($permintaan->permintaan_lab);
        $pemeriksaan = PemeriksaanLab::whereIn('code', $kode)
            ->with(['parameters'])
            ->get();

            dd($pemeriksaan->first());
        return view('sim.permintaanlab_proses', compact([
            'request',
            'permintaan',
            'pemeriksaan',
        ]));
    }
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        $lab = PemeriksaanLab::firstWhere('id', $request->id);
        $lab->update($request->all());
        Alert::success('Succes', 'Berhasil Update Pemeriksaan Laboratorium');
        return redirect()->back();
    }
    public function destroy(string $id, Request $request)
    {
        $lab = PemeriksaanLab::firstWhere('id', $id);
        $lab->update([
            'status' => !$lab->status,
        ]);
        Alert::success('Succes', 'Berhasil Update Status Pemeriksaan Laboratorium');
        return redirect()->back();
    }
}
