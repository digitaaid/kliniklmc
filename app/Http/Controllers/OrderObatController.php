<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\OrderObat;
use App\Models\OrderObatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderObatController extends Controller
{
    public function create_order_obat(Request $request)
    {
        // dd($request->all(), $request->obat);
        if ($request->obat) {
            $order =  OrderObat::create([
                'kode' => strtoupper(uniqid()),
                'waktu' => $request->waktu,
                'nama' => $request->nama,
                'nomorkartu' => $request->nomorkartu,
                'nik' => $request->nik,
                'catatan_resep' => $request->nik,
                'resep_obat' => $request->nik,
                'pic' => Auth::user()->name,
                'user' => Auth::user()->id,

            ]);
            // peresepan
            foreach ($request->obat as $key => $value) {
                $obat = Obat::find($value);
                $resepdetail = OrderObatDetail::updateOrCreate(
                    [
                        'kodeorder' => $order->kode,
                        'order_id' => $order->id,
                        'obat_id' =>  $obat->id,
                    ],
                    [
                        'nama' => $obat->nama,
                        'jumlah' => $request->jumlah[$key] ?? 0,
                        'interval' => $request->frekuensi[$key] ?? null,
                        'waktu' => $request->waktuobat[$key] ?? null,
                        'keterangan' => $request->keterangan_obat[$key] ?? null,
                    ]
                );
            }
            Alert::success("Success", "Order Obat Berhasil Dibuatkan");
        } else {
            Alert::error("Mohon Maaf", "Silahkan isi / masukan obat yang akan di order");
        }
        return redirect()->back();
    }
    public function batal_order_obat(Request $request)
    {
        $order = OrderObat::firstWhere('kode', $request->kode);
        $order->update([
            'status' => 99,
            'pic' => Auth::user()->name,
            'user' => Auth::user()->id,
        ]);
        foreach ($order->orderdetail as $key => $orderobat) {
            $orderobat->update([
                'status' => 99
            ]);
        }
        Alert::success('Berhasil', 'Berhasil Batalkan Order Obat');
        return redirect()->back();
    }
    public function reset_order_obat(Request $request)
    {
        $order = OrderObat::firstWhere('kode', $request->kode);
        $order->update([
            'status' => 1,
            'pic' => Auth::user()->name,
            'user' => Auth::user()->id,
        ]);
        foreach ($order->orderdetail as $key => $orderobat) {
            $orderobat->update([
                'status' => 1
            ]);
        }
        Alert::success('Berhasil', 'Berhasil Rest Order Obat');
        return redirect()->back();
    }
    public function selesai_order_obat(Request $request)
    {
        $order = OrderObat::firstWhere('kode', $request->kode);
        $order->update([
            'status' => 2,
            'pic' => Auth::user()->name,
            'user' => Auth::user()->id,
        ]);
        foreach ($order->orderdetail as $key => $orderobat) {
            $orderobat->update([
                'status' => 2
            ]);
        }
        Alert::success('Berhasil', 'Berhasil Selesai Order Obat');
        return redirect()->back();
    }
}
