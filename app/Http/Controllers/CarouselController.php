<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarouselController extends Controller
{
    public function index()
    {
        $carousel = Carousel::get();
        return view('web.carousel', compact(['carousel']));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_url' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'storage/carousel/';
            $imageName =  $image->getClientOriginalName();
            $imageUrl = $destinationPath . $imageName;
            $image->move($destinationPath, $imageName);
            $input['image'] = "$imageUrl";
        }
        Carousel::create($input);
        return redirect()->route('carousel.index')
            ->with('success', 'Product created successfully.');
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

        $carousel = Carousel::find($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_url' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            // hapus gambar sebelumnya
            $image_path = public_path($carousel->image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            // upload gambar
            $destinationPath = 'storage/carousel/';
            $imageName =  $image->getClientOriginalName();
            $imageUrl = $destinationPath . $imageName;
            $image->move($destinationPath, $imageName);
            $input['image'] = "$imageUrl";
        } else {
            unset($input['image']);
        }
        $carousel->update($input);
        return redirect()->route('carousel.index')
            ->with('success', 'Product updated successfully');
    }
    public function destroy(string $id)
    {
        //
    }
}
