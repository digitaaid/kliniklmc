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
                    'nama' => strtoupper($row['nama']),
                ],
                [
                    'bpom' => $row['bpom'],
                    'barcode' => $row['barcode'],
                    'stok_minimum' => $row['stok_minimum'],
                    'kemasan' => $row['kemasan'],
                    'konversi_satuan' => $row['konversi_satuan'],
                    'satuan' => $row['satuan'],
                    'harga_beli' => $row['harga_beli'] ?? 0,
                    'diskon_beli' => $row['diskon_beli'] ?? 0,
                    'harga_jual' => $row['harga_jual'] ?? 0,
                    'jenisobat' => $row['jenisobat'],
                    'tipeobat' => $row['tipeobat'],
                    'merk' => $row['merk'],
                    'distributor' => $row['distributor'],
                    'status' => $row['status'],
                    'user' => Auth::user()->id,
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                ]
            );
        }
    }
}
