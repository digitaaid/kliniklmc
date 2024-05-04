<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SPRIController extends Controller
{
    //

    function store(Request $request)
    {
        $api = new VclaimController();
        $request['user'] = Auth::user()->name;
        $res = $api->spri_insert($request);
        Alert::info('Information', $res->metadata->message);
        return redirect()->back();
    }
}
