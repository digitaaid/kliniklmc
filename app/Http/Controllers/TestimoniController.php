<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::get();
        return view('web.testimoni', compact(['testimoni']));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subtitle' => 'required',
            'testimoni' => 'required',
            'image' => 'required',
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'storage/testimoni/';
            $imageName =  $image->getClientOriginalName();
            $imageUrl = $destinationPath . $imageName;
            $image->move($destinationPath, $imageName);
            $input['image'] = "$imageUrl";
        }
        Testimoni::create($input);
        Alert::success('Success', 'Berhasil ditambahkan.');
        return redirect()->back();
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

        $request->validate([
            'name' => 'required',
            'subtitle' => 'required',
            'testimoni' => 'required',
            'image' => 'required',
        ]);
        $testimoni = Testimoni::find($id);
        $input = $request->all();
        if ($image = $request->file('image')) {
            // hapus gambar sebelumnya
            $image_path = public_path($testimoni->image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            // upload gambar
            $destinationPath = 'storage/testimoni/';
            $imageName =  $image->getClientOriginalName();
            $imageUrl = $destinationPath . $imageName;
            $image->move($destinationPath, $imageName);
            $input['image'] = "$imageUrl";
        } else {
            unset($input['image']);
        }
        $testimoni->update($input);
        Alert::success('Success', 'Berhasil diupdate.');
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        //
    }
}
