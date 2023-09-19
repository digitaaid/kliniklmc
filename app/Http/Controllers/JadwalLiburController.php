<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\JadwalLibur;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalLiburController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kodepoli' => 'required',
            'kodedokter' => 'required',
            'tanggallibur' => 'required',
        ]);
        $tanggal = explode('-', $request->tanggallibur);
        $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
        $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
        $request['namadokter'] = Dokter::firstWhere('kodedokter', $request->kodedokter)->namadokter;
        $request['namapoli'] = Unit::firstWhere('kode', $request->kodepoli)->nama;
        JadwalLibur::create($request->all());
        Alert::success('Succes', 'Berhasil menambahkan jadwal libur');
        return redirect()->back();
    }
    public function kirimpesanlibur(Request $request)
    {
        $jadwal = JadwalLibur::find($request->jadwallibur);
        $antrians = Antrian::whereBetween('tanggalperiksa', [$jadwal->tanggalawal, $jadwal->tanggalakhir])
            ->where('kodepoli', $jadwal->kodepoli)
            ->where('kodedokter', $jadwal->kodedokter)->get();
        if ($antrians->count()) {
            foreach ($antrians as  $value) {
                $request['number'] = $value->nohp;
                $request['message'] = "Mohon maaf, antrian atas nama pasien " . $value->nama . " pada tanggal " . $value->tanggalperiksa . " dengan nomor antrian " . $value->nomorantrean . " dibatalkan karena dokter tidak bisa hadir / diliburkan. \nSilahkan daftar ulang dijadwal hari yang lain. Terimakasih.\n\nLink Daftar : luthfimedicalcenter.com/daftar";
                $wa = new WhatsappController();
                $wa->send_message($request);
                Alert::success('Succes', 'Berhasil kirim pesan informasi libur');
            }
        } else {
            Alert::error('Mohon maaf', 'Tidak ada antrian pada tanggal tersebut.');
        }
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        $jadwal = JadwalLibur::find($id);
        $jadwal->delete();
        Alert::success('Succes', 'Jadwal libur berhasil dihapus');
        return redirect()->back();
    }
}
