<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderObatController extends Controller
{
    public function create_order_obat(Request $request)
    {
        dd($request->all());
    }
}
