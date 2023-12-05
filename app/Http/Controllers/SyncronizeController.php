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
        $antrian = Antrian::where('taskid', 7)->where('status', 0)->first();
        if ($antrian) {
            try {
                $request['kodebooking'] = $antrian->kodebooking;
                $request['taskid'] = 1;
                $request['waktu'] = Carbon::parse($antrian->taskid1, 'Asia/Jakarta');
                $res =  $api->update_antrean($request);
                $request['taskid'] = 2;
                $request['waktu'] = Carbon::parse($antrian->taskid2, 'Asia/Jakarta');
                $res =  $api->update_antrean($request);
                $request['taskid'] = 3;
                $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta')->subMinutes(random_int(4, 9));
                $res = $api->update_antrean($request);
                $request['taskid'] = 4;
                $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta');
                $res = $api->update_antrean($request);
                $request['taskid'] = 5;
                $request['waktu'] = Carbon::parse($antrian->taskid5, 'Asia/Jakarta');
                $res =  $api->update_antrean($request);
                $request['taskid'] = 6;
                $request['waktu'] = Carbon::parse($antrian->taskid6, 'Asia/Jakarta');
                $res =  $api->update_antrean($request);
                $request['taskid'] = 7;
                $request['waktu'] = Carbon::parse($antrian->taskid7, 'Asia/Jakarta');
                $res =  $api->update_antrean($request);
                dd($res);
                if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=7 sudah ada") {
                    $antrian->update([
                        'status' => 1
                    ]);
                }
                Alert::success('Success', 'Berhasil snyc');
            } catch (\Throwable $th) {
                Alert::error('Error', $th->getMessage());
            }
        }
        $antrians = Antrian::where('taskid', 7)->where('status', 0)->get();
        return view('sim.sync_antrian_bpjs', compact([
            'request',
            'antrians',
        ]));
    }
}
