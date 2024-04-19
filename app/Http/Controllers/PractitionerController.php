<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class PractitionerController extends SatuSehatController
{
    public function index(Request $request)
    {
        $dokter = Dokter::get();
        return view('satusehat.practitioner_index', compact([
            'request',
            'dokter',
        ]));
    }
}
