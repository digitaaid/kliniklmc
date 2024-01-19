<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokObat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StokObatController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $now = now()->timestamp;
        $request['kode'] = 'SO' . $now;

        $obat = Obat::find($request->obat_id);
        if ($request->jumlah_kemasan) {
            $request['jumlah'] = $request->jumlah + ($obat->konversi_satuan * $request->jumlah_kemasan);
        }
        $stok = StokObat::create($request->all());
        Alert::success('Success', 'Berhasil Input Stok');
        return redirect()->back();
    }

    public function show(string $id)
    {
        $obat = Obat::find($id);
        // dd($obat, $obat->reseps->sum('jumlah'));
        return view('sim.obat_detail', compact([
            'obat'
        ]));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
