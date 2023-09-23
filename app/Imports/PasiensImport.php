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
            } else {
                $tgllahir = now();
            }
            switch ($row[1]) {
                case 'Tn':
                    $gender = 'L';
                    break;
                case 'Ny':
                    $gender = 'P';
                    break;
                case 'Nn':
                    $gender = 'P';
                    break;

                default:
                    $gender = null;
                    break;
            }
            // dd($row,);
            // dd(Carbon::parse($tgllahir)->format('Y-m-d'));
            Pasien::updateOrCreate(
                [
                    'norm' =>  sprintf("%06d",  $row[0]),
                ],
                [
                    'gender' => $gender,
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
