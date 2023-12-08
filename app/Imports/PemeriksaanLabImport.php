<?php

namespace App\Imports;

use App\Models\PemeriksaanLab;
use App\Models\Tarif;
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
            $tarif = Tarif::updateOrCreate(
                [
                    'nama' => $row['nama'],
                    'klasifikasi' => 'Laboratorium',
                    'jenispasien' => 'SEMUA',

                ],
                [
                    'harga' =>  $row['harga'],
                    'user' =>  Auth::user()->id,
                ]
            );
            PemeriksaanLab::updateOrCreate(
                [
                    'kode' =>  $row['kode'],
                ],
                [
                    'nama' =>  $row['nama'],
                    'group' =>  $row['group'],
                    'kelompok' =>  $row['kelompok'],
                    'status' =>  $row['status'],
                    'tarif_id' =>  $tarif->id,
                    'user' =>  Auth::user()->id,
                ]
            );
        }
    }
}
