<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Obat::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'nama_obat',
            'satuan',
            'harga_satuan',
            'tipe_barang',
            'jenis_obat',
            'user',
            'created_at',
            'updated_at',
        ];
    }
}
