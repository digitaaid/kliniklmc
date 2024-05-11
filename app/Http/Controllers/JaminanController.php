<?php

namespace App\Http\Controllers;

use App\Models\Jaminan;
use Illuminate\Http\Request;

class JaminanController extends Controller
{
    function index(Request $request)
    {
        $jaminans = Jaminan::get();
        return view('sim.jaminan_index', compact('jaminans'));
    }
}
