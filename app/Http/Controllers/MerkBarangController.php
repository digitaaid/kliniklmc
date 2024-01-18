<?php

namespace App\Http\Controllers;

use App\Models\MerkBarang;
use Illuminate\Http\Request;

class MerkBarangController extends APIController
{
    public function store(Request $request)
    {
        $jenis = MerkBarang::updateOrCreate([
            'nama' => $request->nama,
        ]);
        return $this->sendResponse($jenis);
    }
    public function show(Request $request)
    {
        if ($request->nama) {
            $jenis = MerkBarang::where('nama', 'LIKE', "%{$request->nama}%")->get();
        } else {
            $jenis = MerkBarang::get();
        }
        return $this->sendResponse($jenis);
    }
}
