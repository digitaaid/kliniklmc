<?php

namespace App\Exports;

use App\Models\ParameterLab;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParameterLabExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ParameterLab::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'nama',
            'group',
            'kelompok',
            'pemeriksaan',
            'nilai_rujukan',
            'satuan',
            'status',
            'user',
            'created_at',
            'updated_at',
        ];
    }
}
