<?php

namespace App\Imports;

use App\Models\Obat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Obat::updateOrCreate(
                [
                    'nama' => strtoupper($row['nama_obat']),
                ],
                [
                    'satuan' => $row['satuan'],
                    'harga' => $row['harga_satuan'] ?? 0,
                    'tipebarang' => $row['tipe_barang'],
                    'jenisobat' => $row['jenis_obat'],
                    'user' => Auth::user()->id,
                ]
            );
        }
    }
}
