<?php

namespace App\Http\Controllers;

use App\Imports\DiagnosaImport;
use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DiagnosaController extends Controller
{
    public function create()
    {
        $file = public_path('diagnosa.xlsx');
        Excel::import(new DiagnosaImport, $file);
        return "ok";
    }
    function diagnosa_autocomplete(Request $request)
    {
        $data = array();
        $diag = Diagnosa::where('diagnosa', 'LIKE', '%' . $request->search . '%')
            ->get();

        foreach ($diag as $item) {
            $data[] = array(
                "id" => $item->id,
                "name" => $item->diagnosa
            );
        }
        return response()->json($data);
    }
}
