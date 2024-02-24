<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KunjunganController extends APIController
{
    public function index(Request $request)
    {
        if ($request->tgl_masuk) {
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)->simplePaginate();
        } else {
            if ($request->search) {
                $kunjungans = Kunjungan::orderby('created_at', 'desc')
                    ->where('norm', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('nama', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('kode', 'LIKE', '%' . $request->search . '%')
                    ->simplePaginate();
            } else {
                $kunjungans = Kunjungan::orderby('created_at', 'desc')->simplePaginate();
            }
        }
        $total_kunjungan = Kunjungan::count();
        return view('sim.kunjungan_index', compact([
            'request',
            'kunjungans',
            'total_kunjungan',
        ]));
    }
    public function kunjunganwaktu(Request $request)
    {
        $kunjungans = null;
        if ($request->waktu) {
            $tanggal = Carbon::parse($request->waktu)->format('Y-m-d');
            $kunjungans = Kunjungan::whereDate('tgl_masuk', $tanggal)->get();
        }
        return $this->sendResponse($kunjungans, 200);
    }
    public function riwayat_kunjungan_norm(Request $request)
    {
        $data = [];
        if ($request->norm) {
            $kunjungans = Kunjungan::whereDate('norm', $request->norm)->get();
            foreach ($kunjungans as $key => $value) {
                $datareg = Carbon::parse($value->tgl_masuk)->format('d/m/Y H:m:s') . "($value->kode)<br>" . "<b>Hemato</b>";
                $anamnesa = null;
                $asesmen_dokter = null;
                $resep = null;
                $penunjang = null;
                $data[] = [
                    "datareg" => $datareg,
                    "anamnesa" => $anamnesa ?? "Belum asesment",
                    "penunjang" => $penunjang ?? "-",
                    "asesmen_dokter" => $asesmen_dokter ?? "Belum asesment",
                    "resep" => $resep ?? "-",
                ];
            }
        }
        return $this->sendResponse($data, 200);
    }
}
