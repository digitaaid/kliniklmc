<?php

namespace App\Http\Controllers;

use App\Imports\PemeriksaanLabImport;
use App\Models\PemeriksaanLab;
use App\Models\PermitaanLab;
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
    public function permintaanlab(Request $request)
    {
        $request['permintaan_lab'] = json_encode($request->permintaan_lab);
        $request['user'] = Auth::user()->id;
        PermitaanLab::updateOrCreate(
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
            'status' => 0,
        ]);
        Alert::success('Succes', 'Berhasil Update Status Pemeriksaan Laboratorium');
        return redirect()->back();
    }
}
