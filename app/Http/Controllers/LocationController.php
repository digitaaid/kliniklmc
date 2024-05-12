<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $units = Unit::get();
        return view('sim.unit_index', compact([
            'units'
        ]));
    }
}
