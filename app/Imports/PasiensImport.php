<?php

namespace App\Imports;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PasiensImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ((int) $row[4]) {
                $tgllahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int) $row[4]);
                // dd($tgllahir);
            }else{
                $tgllahir = now();
            }
            // dd($row,);
            // dd(Carbon::parse($tgllahir)->format('Y-m-d'));
            Pasien::updateOrCreate(
                [
                    'norm' => $row[0],
                ],
                [
                    'gender' => $row[1],
                    'nama' => $row[2],
                    'tempat_lahir' => $row[3],
                    'tgl_lahir' =>  Carbon::parse($tgllahir)->format('Y-m-d'),
                    'nomorkartu' => $row[5],
                    'nohp' => $row[6],
                    'alamat' => $row[7],
                ]
            );
        }
    }
}
