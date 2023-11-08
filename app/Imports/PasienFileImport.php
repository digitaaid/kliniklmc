<?php

namespace App\Imports;

use App\Models\Pasien;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PasienFileImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pasien::updateOrCreate(
                [
                    'norm' => strtoupper($row['norm']),
                ],
                [
                    'nomorkartu' => $row['nomorkartu'],
                    'nik' => $row['nik'],
                    'nama' => $row['nama'],
                    'nohp' => $row['nohp'],
                    'gender' => $row['gender'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'tgl_lahir' => $row['tgl_lahir'],
                    'desa_id' => $row['desa_id'],
                    'kecamatan_id' => $row['kecamatan_id'],
                    'kabupaten_id' => $row['kabupaten_id'],
                    'provinsi_id' => $row['provinsi_id'],
                    'alamat' => $row['alamat'],
                    'status' => $row['status'] ?? 1,
                    'keterangan' => $row['keterangan'],
                    'user' => Auth::user()->id,
                ]
            );
        }
    }
}
