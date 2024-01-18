<?php

namespace App\Http\Controllers;

use App\Models\TipeBarang;
use Illuminate\Http\Request;

class TipeBarangController extends APIController
{
    //
    public function store(Request $request)
    {
        $jenis = TipeBarang::updateOrCreate([
            'nama' => $request->nama,
        ]);
        return $this->sendResponse($jenis);
    }
    public function show(Request $request)
    {
        if ($request->nama) {
            $jenis = TipeBarang::where('nama', 'LIKE', "%{$request->nama}%")->get();
        } else {
            $jenis = TipeBarang::get();
        }
        return $this->sendResponse($jenis);
    }
}
