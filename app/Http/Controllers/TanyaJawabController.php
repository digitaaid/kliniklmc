<?php

namespace App\Http\Controllers;

use App\Models\TanyaJawab;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TanyaJawabController extends Controller
{
    public function index()
    {
        $tanyajawab = TanyaJawab::get();
        return view('web.tanyajawab', compact(['tanyajawab']));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);
        TanyaJawab::create($request->all());
        Alert::success('Success','Tanya Jawab Berhasil dibuatkan.');
        return redirect()->route('tanyajawab.index');
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

        $tanyajawab = TanyaJawab::find($id);
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);
        $tanyajawab->update($request->all());
        Alert::success('Success','Tanya Jawab Berhasil diupdate.');
        return redirect()->route('tanyajawab.index');
    }
    public function destroy(string $id)
    {
        //
    }
}
