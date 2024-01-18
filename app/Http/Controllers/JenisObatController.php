<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use Illuminate\Http\Request;

class JenisObatController extends APIController
{

    public function store(Request $request)
    {
        $jenis = JenisObat::updateOrCreate([
            'nama' => $request->nama,
        ]);
        return $this->sendResponse($jenis);
    }
    public function show(Request $request)
    {
        if ($request->nama) {
            $jenis = JenisObat::where('nama', 'LIKE', "%{$request->nama}%")->get();
        } else {
            $jenis = JenisObat::get();
        }
        return $this->sendResponse($jenis);
    }
}
