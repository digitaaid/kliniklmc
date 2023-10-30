<?php

namespace App\Imports;

use App\Models\Tarif;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class TarifImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Tarif::updateOrCreate([
                'nama' => $row[0],
                'jenispasien' => strtoupper($row[3]),
            ], [
                'klasifikasi' => $row[1],
                'harga' => $row[2],
                'user' => Auth::user()->id,
            ]);
        }
    }
}
