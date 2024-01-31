<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function edit_kartustokobat(Request $request)
    {
        $stok = StokObat::with('obat')->find($request->id);
        $obat = $stok->obat;
        return view('sim.stokobat_edit', compact(
            'stok',
            'obat',
        ));
    }

    public function update_kartustokobat(Request $request)
    {
        $stok = StokObat::with('obat')->find($request->stok_id);
        $obat = $stok->obat;
        if ($stok->status == 1) {
            if ($request->jumlah_kemasan) {
                $request['jumlah'] = $request->jumlah + ($obat->konversi_satuan * $request->jumlah_kemasan);
            }
            $request['user_id'] = Auth::user()->id;
            $request['pic'] = Auth::user()->name;
            $request['harga_beli'] = str_replace(".", "", $request->harga_beli);
            $hargadiskon = $request->harga_beli - ($request->harga_beli * $request->diskon_beli / 100);
            $hargapppn = $hargadiskon + ($hargadiskon * 11 / 100);
            $hargabelisatuan = $hargapppn / $obat->konversi_satuan;
            $hargatotal = $hargabelisatuan * $request->jumlah;
            $request['harga_total'] = round($hargatotal);
            $stok->updateOrCreate([
                'kode' => $stok->kode
            ], $request->all());
            Alert::success('Success', 'Berhasil Update Stok');
        } else {
            Alert::error('Error', 'Tidak bisa diupdate karena sudah dikunci');
        }
        return redirect()->back();
    }

    public function kunci_kartustokobat(Request $request)
    {
        $stok = StokObat::with('obat')->find($request->kodestok);
        $request['user_id'] = Auth::user()->id;
        $request['pic'] = Auth::user()->name;
        $request['status'] = $stok->status == 1 ? 2 : 1;
        $stok->update($request->all());
        Alert::success('Success', 'Berhasil Kunci Stok');
        return redirect()->back();
    }
    public function hapus_kartustokobat(Request $request)
    {
        $stok = StokObat::with('obat')->find($request->kodestok);
        if ($stok->status == 1) {
            $request['user_id'] = Auth::user()->id;
            $request['pic'] = Auth::user()->name;
            $request['status'] = $stok->status == 99 ? 1 : 99;
            $stok->update($request->all());
            Alert::success('Success', 'Berhasil Hapus Stok');
        } else {
            Alert::error('Error', 'Tidak bisa diupdate karena sudah dikunci');
        }
        return redirect()->back();
    }

    public function print_kartustokobat(Request $request)
    {
        $obat = Obat::find($request->obat);
        $kartu = [];

        foreach ($obat->stoks as $key => $stok) {
            $kartu[] = [
                'tgl' => Carbon::parse($stok->tgl_input)->format('Y-m-d'),
                'nama' => 'FARMASI',
                'kode' => $stok->kode,
                'obat' => $stok->nama,
                'jumlah' => $stok->jumlah,
            ];
        }
        foreach ($obat->reseps as $key => $resep) {
            $kartu[] = [
                'tgl' => Carbon::parse($resep->created_at)->format('Y-m-d'),
                'nama' => $resep->resepobat ? $resep->resepobat->nama : '-',
                'kode' => $resep->koderesep,
                'obat' =>  $obat->nama,
                'jumlah' =>  $resep->jumlah,
            ];
        }
        dd($kartu = sort($kartu));
        uasort($entity_list, 'mySort');
        return view('print.print_kartu_stok_obat', compact(
            'request',
            'obat',
            'stok',
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
