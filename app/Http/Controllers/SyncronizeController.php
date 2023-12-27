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
            if ($request->sync == "ON") {
                $antriansx = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])
                    ->where('taskid', 7)->where('status', 0)->limit(2)->get();
                foreach ($antriansx as $key => $value) {
                    if ($value) {
                        try {
                            $request['kodebooking'] = $value->kodebooking;
                            // $request['taskid'] = 1;
                            // $request['waktu'] = Carbon::parse($value->taskid1, 'Asia/Jakarta');
                            // $res =  $api->update_antrean($request);
                            // $request['taskid'] = 2;
                            // $request['waktu'] = Carbon::parse($value->taskid2, 'Asia/Jakarta');
                            // $res =  $api->update_antrean($request);
                            $request['taskid'] = 3;
                            $request['waktu'] = Carbon::parse($value->taskid4, 'Asia/Jakarta')->subMinutes(random_int(4, 9));
                            $res = $api->update_antrean($request);
                            $request['taskid'] = 4;
                            $request['waktu'] = Carbon::parse($value->taskid4, 'Asia/Jakarta');
                            $res = $api->update_antrean($request);
                            $request['taskid'] = 5;
                            $request['waktu'] = Carbon::parse($value->taskid5, 'Asia/Jakarta');
                            $res =  $api->update_antrean($request);
                            if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=5 sudah ada") {
                                $value->update([
                                    'status' => 1
                                ]);
                            }
                            $request['taskid'] = 6;
                            $request['waktu'] = Carbon::parse($value->taskid6, 'Asia/Jakarta');
                            $res =  $api->update_antrean($request);
                            $request['taskid'] = 7;
                            $request['waktu'] = Carbon::parse($value->taskid7, 'Asia/Jakarta');
                            $res =  $api->update_antrean($request);
                            if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=7 sudah ada") {
                                $value->update([
                                    'status' => 1
                                ]);
                            }
                            Alert::success('Success', $res->metadata->message);
                        } catch (\Throwable $th) {
                            Alert::error('Error', $th->getMessage());
                        }
                    }
                }
            }
            $tanggal = explode('-', $request->tanggal);
            $request['tanggalawal'] = Carbon::parse($tanggal[0])->format('Y-m-d');
            $request['tanggalakhir'] = Carbon::parse($tanggal[1])->format('Y-m-d');
            $antrians = Antrian::whereBetween('tanggalperiksa', [$request->tanggalawal, $request->tanggalakhir])->get();
        }
        return view('sim.sync_antrian_bpjs', compact([
            'request',
            'antrians',
        ]));
    }
}
