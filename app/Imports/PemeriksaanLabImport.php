<?php

namespace App\Imports;

use App\Models\PemeriksaanLab;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemeriksaanLabImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            PemeriksaanLab::updateOrCreate(
                [
                    'kode' =>  $row['kode'],
                ],
                [
                    'nama' =>  $row['nama'],
                    'group' =>  $row['group'],
                    'kelompok' =>  $row['kelompok'],
                    'harga' =>  $row['harga'],
                    'status' =>  $row['status'],
                    'status' =>  Auth::user()->id,
                ]
            );
        }
    }
}
