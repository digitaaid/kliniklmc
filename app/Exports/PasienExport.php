<?php

namespace App\Exports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PasienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pasien::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'norm',
            'nomorkartu',
            'nik',
            'nama',
            'nohp',
            'gender',
            'tempat_lahir',
            'tgl_lahir',
            'desa_id',
            'kecamatan_id',
            'kabupaten_id',
            'provinsi_id',
            'alamat',
            'status',
            'keterangan',
            'user',
            'created_at',
            'updated_at',
        ];
    }
}
