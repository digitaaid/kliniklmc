<?php

namespace App\Imports;

use App\Models\Tarif;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TarifImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Tarif::updateOrCreate([
                'nama' => $row['nama'],
                'jenispasien' => strtoupper($row['jenispasien']),
            ], [
                'klasifikasi' => $row['klasifikasi'],
                'harga' => $row['harga'] ?? 0,
                'user' => $row['user'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]);
        }
    }
}
