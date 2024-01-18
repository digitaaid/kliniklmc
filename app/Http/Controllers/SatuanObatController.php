<?php

namespace App\Http\Controllers;

use App\Models\SatuanObat;
use Illuminate\Http\Request;

class SatuanObatController extends APIController
{
    public function store(Request $request)
    {
        $satuan = SatuanObat::updateOrCreate([
            'nama' => $request->nama,
        ]);
        return $this->sendResponse($satuan);
    }
    public function show(Request $request)
    {
        if ($request->nama) {
            $satuan = SatuanObat::where('nama', 'LIKE', "%{$request->nama}%")->get();
        } else {
            $satuan = SatuanObat::get();
        }
        return $this->sendResponse($satuan);
    }
}
