<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SyncronizeController extends Controller
{
    public function sync_antrian_bpjs(Request $request)
    {
        $antrians = null;
        $api = new AntrianController();
        if ($request->tanggal) {
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            if ($request->sync == 'ON') {
                $antrian = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                    ->where('taskid', 7)->where('status', 0)->first();
                if ($antrian) {
                    try {
                        $request['kodebooking'] = $antrian->kodebooking;
                        // $request['taskid'] = 1;
                        // $request['waktu'] = Carbon::parse($antrian->taskid1, 'Asia/Jakarta');
                        // $res =  $api->update_antrean($request);
                        // $request['taskid'] = 2;
                        // $request['waktu'] = Carbon::parse($antrian->taskid2, 'Asia/Jakarta');
                        // $res =  $api->update_antrean($request);
                        $request['taskid'] = 3;
                        $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta')->subMinutes(random_int(20, 30));
                        $res = $api->update_antrean($request);
                        $request['taskid'] = 4;
                        $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta');
                        $res = $api->update_antrean($request);
                        $request['taskid'] = 5;
                        $request['waktu'] = Carbon::parse($antrian->taskid5, 'Asia/Jakarta');
                        $res =  $api->update_antrean($request);
                        if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=5 sudah ada") {
                            $antrian->update([
                                'status' => 1
                            ]);
                        }
                        $request['taskid'] = 6;
                        $request['waktu'] = Carbon::parse($antrian->taskid6, 'Asia/Jakarta');
                        $res =  $api->update_antrean($request);
                        $request['taskid'] = 7;
                        $request['waktu'] = Carbon::parse($antrian->taskid7, 'Asia/Jakarta');
                        $res =  $api->update_antrean($request);
                        if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=7 sudah ada") {
                            $antrian->update([
                                'status' => 1
                            ]);
                        }
                        Alert::success('Success', $res->metadata->message . ' ' . $antrian->kodebooking);
                    } catch (\Throwable $th) {
                        Alert::error('Error', $th->getMessage());
                    }
                }
            }
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])->where('taskid', 7)->get();
        }
        return view('sim.sync_antrian_bpjs', compact([
            'request',
            'antrians',
        ]));
    }
    public function update_taksid_antrian(Request $request)
    {
        $antrian = Antrian::find($request->id);
        $antrian->update($request->all());
        return redirect()->back();
    }
}
