<?php

namespace App\Exports;

use App\Models\Diagnosa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiagnosaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Diagnosa::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'diagnosa',
            'created_at',
            'updated_at',
        ];
    }
}
