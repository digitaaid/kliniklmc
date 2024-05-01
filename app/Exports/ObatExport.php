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
            'nama',
            'bpom',
            'barcode',
            'stok_minimum',
            'kemasan',
            'konversi_satuan',
            'satuan',
            'harga_beli',
            'diskon_beli',
            'harga_jual',
            'jenisobat',
            'tipeobat',
            'merk',
            'distributor',
            'status',
            'user',
            'created_at',
            'updated_at',
        ];
    }
}
