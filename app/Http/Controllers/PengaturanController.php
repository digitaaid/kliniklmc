<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('sim.pengaturan_index', compact('pengaturan'));
    }
    public function store(Request $request)
    {
        if ($request->file_logo_landing_page) {
            $request['logo_landing_page'] = $request->file_logo_landing_page->getClientOriginalName();
            $request->file_logo_landing_page->move(public_path('file_pengaturan'), $request->file_logo_landing_page->getClientOriginalName());
        }
        $pengaturan = Pengaturan::updateOrCreate(
            [
                'id' => 1,
            ],
            $request->all()
        );

        Alert::success('Success', 'Pengaturan Berhasil Disimpan');
        return redirect()->back();
    }
}
