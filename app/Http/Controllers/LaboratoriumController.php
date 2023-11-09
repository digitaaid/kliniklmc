<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function permintaanlab(Request $request)
    {
        $request['permintaan_lab'] = json_encode($request->permintaan_lab);
        dd($request->all());

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
