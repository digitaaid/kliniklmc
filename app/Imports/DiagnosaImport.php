<?php

namespace App\Imports;

use App\Models\Diagnosa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiagnosaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Diagnosa::updateOrCreate([
                'diagnosa' => strtoupper($row[0]),
            ]);
        }
    }
}
