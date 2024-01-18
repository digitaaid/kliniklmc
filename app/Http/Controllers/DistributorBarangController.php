<?php

namespace App\Http\Controllers;

use App\Models\DistributorBarang;
use Illuminate\Http\Request;

class DistributorBarangController extends APIController
{
    //
    public function store(Request $request)
    {
        $jenis = DistributorBarang::updateOrCreate([
            'nama' => $request->nama,
        ]);
        return $this->sendResponse($jenis);
    }
    public function show(Request $request)
    {
        if ($request->nama) {
            $jenis = DistributorBarang::where('nama', 'LIKE', "%{$request->nama}%")->get();
        } else {
            $jenis = DistributorBarang::get();
        }
        return $this->sendResponse($jenis);
    }
}
