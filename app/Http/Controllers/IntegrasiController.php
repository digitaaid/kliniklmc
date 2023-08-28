<?php

namespace App\Http\Controllers;

use App\Models\IntegrasiApi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IntegrasiController extends Controller
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
}
