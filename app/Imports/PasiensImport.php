<?php

namespace App\Imports;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PasiensImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pasien::updateOrCreate(
                [
                    'norm' =>  sprintf("%09d",  $row['norm']),
                ],
                [
                    'nik' => $row['nik'],
                    'nomorkartu' => $row['nomorkartu'],
                    'nama' => $row['nama'],
                    'nohp' => $row['nohp'],
                    'gender' => $row['gender'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'tgl_lahir' =>   $row['tgl_lahir'],
                    'desa_id' => $row['desa_id'],
                    'kecamatan_id' => $row['kecamatan_id'],
                    'kabuapten_id' => $row['kabuapten_id'],
                    'provinsi_id' => $row['provinsi_id'],
                    'alamat' => $row['alamat'],
                    'status' => $row['status'],
                    'keterangan' => $row['keterangan'],
                    'user' => $row['user'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                ]
            );
        }
    }
}
