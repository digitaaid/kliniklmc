<?php

namespace App\Http\Controllers;

use App\Exports\DiagnosaExport;
use App\Imports\DiagnosaImport;
use App\Models\Diagnosa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DiagnosaController extends Controller
{
    public function index()
    {
        $diagnosa = Diagnosa::get();
        return view('sim.diagnosa_index', compact([
            'diagnosa',
        ]));
    }
    public function create()
    {
        $file = public_path('diagnosa.xlsx');
        Excel::import(new DiagnosaImport, $file);
        return "ok";
    }
    public function store(Request $request)
    {
        Diagnosa::updateOrCreate([
            'diagnosa' => $request->diagnosa,
        ]);
        Alert::success('Success', 'Data Diagosa Disimpan.');
        return redirect()->route('diagnosa.index');
    }
    public function update($id, Request $request)
    {
        $diag = Diagnosa::find($id);
        $diag->update([
            'diagnosa' => $request->diagnosa,
        ]);
        Alert::success('Success', 'Data Diagnosa Diperbaharui.');
        return redirect()->route('diagnosa.index');
    }
    function search(Request $request)
    {
        $data = array();
        $diag = Diagnosa::where('diagnosa', 'LIKE', '%' . $request->search . '%')
            ->limit(20)->get();
        foreach ($diag as $item) {
            $data[] = array(
                "id" => $item->diagnosa,
                "text" => $item->diagnosa
            );
        }
        return response()->json($data);
    }
    public function export()
    {
        return Excel::download(new DiagnosaExport, 'diagnosa.xlsx');
    }
    public function diagnosaimport(Request $request)
    {
        Excel::import(new DiagnosaImport, $request->file);
        Alert::success('Success', 'Import Diagnosa Berhasil.');
        return redirect()->route('diagnosa.index');
    }
}
