<?php

namespace App\Imports;

use App\Models\Obat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ObatsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Obat::updateOrCreate([
                'nama' => strtoupper($row[0]),
            ]);
        }
    }
}
