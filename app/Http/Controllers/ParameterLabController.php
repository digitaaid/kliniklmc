<?php

namespace App\Http\Controllers;

use App\Exports\ParameterLabExport;
use App\Imports\ParameterLabImport;
use App\Models\ParameterLab;
use App\Models\PemeriksaanLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class ParameterLabController extends Controller
{
    public function index(Request $request)
    {
        $parameter = ParameterLab::with(['pemeriksaans'])->get();
        $pemeriksaan = PemeriksaanLab::pluck('nama', 'id');
        return view('sim.parameterlab_index', compact([
            'request',
            'parameter',
            'pemeriksaan',
        ]));
    }
    public function store(Request $request)
    {
        $request['user'] = Auth::user()->id;
        $request['pemeriksaans'] = $request->pemeriksaan;
        $request['pemeriksaan'] = json_encode($request->pemeriksaan);
        $parameter = ParameterLab::updateOrCreate(
            [
                'nama' => $request->nama,
            ],
            $request->all()
        );
        $parameter->update($request->all());
        $parameter->pemeriksaans()->sync($request->pemeriksaans);
        Alert::success('Success', 'Parameter Laboratorium Berhasil Ditambahkan');
        return redirect()->back();
    }
    public function update(Request $request, string $id)
    {
        $parameter = ParameterLab::find($id);
        $request['user'] = Auth::user()->id;
        $request['pemeriksaans'] = $request->pemeriksaan;
        $request['pemeriksaan'] = json_encode($request->pemeriksaan);
        $parameter->update($request->all());
        $parameter->pemeriksaans()->sync($request->pemeriksaans);
        Alert::success('Success', 'Parameter Laboratorium Berhasil Diupdate');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $parameter = ParameterLab::find($id);
        $parameter->delete();
        Alert::success('Success', 'Parameter Laboratorium Berhasil Ditambahkan');
        return redirect()->back();
    }
    public function parameterlabexport()
    {
        $time = now()->format('Y-m-d');
        return Excel::download(new ParameterLabExport(), 'parameterlab_backup_' . $time . '.xlsx');
    }
    public function parameterlabimport(Request $request)
    {
        Excel::import(new ParameterLabImport, $request->file);
        Alert::success('Success', 'Import Obat Berhasil.');
        return redirect()->route('parameterlab.index');
    }
}
