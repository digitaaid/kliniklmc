<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\SbarTbak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SbarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodebooking' => 'required',
            'antrian_id' => 'required',
            'kodekunjungan' => 'required',
            'kunjungan_id' => 'required',
        ]);
        $kunjungan = Kunjungan::find($request->kunjungan_id);
        $request['counter'] = $kunjungan->counter;
        $request['norm'] = $kunjungan->norm;
        $request['nama'] = $kunjungan->nama;
        $request['tgl_lahir'] = $kunjungan->tgl_lahir;
        $request['gender'] = $kunjungan->gender;
        $request['user_pengirim'] = Auth::user()->id;
        $request['status'] = 1;
        SbarTbak::updateOrCreate(
            [
                'kodebooking' => $request->kodebooking,
                'antrian_id' => $request->antrian_id,
                'kodekunjungan' => $request->kodekunjungan,
                'kunjungan_id' => $request->kunjungan_id,
            ],
            $request->all()
        );
        Alert::success('Success', 'Simpan SBAR Keperawatan.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
