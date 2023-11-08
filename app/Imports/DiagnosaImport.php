<?php

namespace App\Imports;

use App\Models\Diagnosa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiagnosaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Diagnosa::updateOrCreate([
                'diagnosa' => strtoupper($row['diagnosa']),
            ]);
        }
    }
}
