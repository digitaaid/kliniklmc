<?php

namespace App\Imports;

use App\Models\ParameterLab;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ParameterLabImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $parameter = ParameterLab::updateOrCreate(
                [
                    'nama' => strtoupper($row['nama']),
                ],
                [
                    'group' => $row['group'],
                    'kelompok' => $row['kelompok'],
                    'pemeriksaan' => $row['pemeriksaan'],
                    'nilai_rujukan' => $row['nilai_rujukan'] ?? '-',
                    'satuan' => $row['satuan'] ?? '-',
                    'status' => $row['status'] ?? 1,
                    'user' => Auth::user()->id,
                ]
            );

            $pemeriksaans = json_decode($row['pemeriksaan']);
            $parameter->pemeriksaans()->sync($pemeriksaans);
        }
    }
}
