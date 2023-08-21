<?php

namespace App\Http\Controllers;

use App\Models\IntegrasiApi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class APIController extends Controller
{

    public function index(Request $request)
    {
        $api = IntegrasiApi::get();
        return view('admin.integrasi_api', compact([
            'api',
            'request'
        ]));
    }
    public function update(Request $request)
    {
        $api = IntegrasiApi::findOrFail($request->id);
        $api->update($request->all());
        Alert::success('Success', 'Data API Disimpan');
        return redirect()->route('integrasiAPI.index');
    }
    public function sendResponse($data, int $code = 200)
    {
        $response = [
            'response' => $data,
            'metadata' => [
                'message' => 'Ok',
                'code' =>  $code,
            ],
        ];
        return json_decode(json_encode($response));
    }
    public function sendError($error,  $code = 404)
    {
        $code = $code ?? 404;
        $response = [
            'metadata' => [
                'message' => $error,
                'code' => $code,
            ],
        ];
        return json_decode(json_encode($response));
    }
}
