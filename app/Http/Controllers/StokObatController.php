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
        $obats = Obat::get();
        return view('sim.stokobat_index', compact([
            'obats'
        ]));
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
        $request['harga_beli'] = str_replace(".", "", $request->harga_beli);
        $hargadiskon = $request->harga_beli - ($request->harga_beli * $request->diskon_beli / 100);
        $hargapppn = $hargadiskon + ($hargadiskon * 11 / 100);
        $hargabelisatuan = $hargapppn / $obat->konversi_satuan;
        $hargatotal = $hargabelisatuan * $request->jumlah;
        $request['harga_total'] = round($hargatotal);
        $stok = StokObat::create($request->all());
        Alert::success('Success', 'Berhasil Input Stok');
        return redirect()->back();
    }

    public function show(string $id)
    {
        $obat = Obat::with('reseps', 'reseps.resepobat')->find($id);
        return view('sim.obat_detail', compact(
            'obat'
        ));
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
