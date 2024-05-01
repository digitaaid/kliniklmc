<?php

namespace App\Exports;

use App\Models\Tarif;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TarifExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tarif::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'nama',
            'klasifikasi',
            'jenispasien',
            'harga',
            'user',
            'created_at',
            'updated_at',
        ];
    }
}
