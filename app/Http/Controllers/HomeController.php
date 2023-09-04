<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Dokter;
use App\Models\TanyaJawab;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function landingpage()
    {
        $carousel = Carousel::get();
        $tanyajawab = TanyaJawab::get();
        $testimoni = Testimoni::get();
        $dokters = Dokter::get();
        return view('welcome', compact([
            'carousel',
            'tanyajawab',
            'testimoni',
            'dokters',
        ]));
    }
}
