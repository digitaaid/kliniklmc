<?php

namespace App\Http\Controllers;

use App\Models\FileUploadPasien;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        $fileuploads = FileUploadPasien::with(['pasien'])->get();
        return view('sim.fileupload_index', compact([
            'request',
            'fileuploads',
        ]));
    }
}
