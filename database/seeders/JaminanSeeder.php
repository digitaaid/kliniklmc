<?php

namespace Database\Seeders;

use App\Models\Jaminan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JaminanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jaminan = [
            [
                'kode' => '00003',
                'slug' => 'JKN',
                'nama' => 'JKN',
            ],
            [
                'kode' => '00071',
                'slug' => 'JAMINAN COVID-19',
                'nama' => 'COVID-19',
            ],
            [
                'kode' => '00072',
                'slug' => 'JAMINAN KIPI',
                'nama' => 'KIPI',
            ],
            [
                'kode' => '00073',
                'slug' => 'JAMINAN BAYI BARU LAHIR',
                'nama' => 'BBL',
            ],
            [
                'kode' => '00074',
                'slug' => 'JAMINAN PERPANJANGAN MASA RAWAT',
                'nama' => 'PMR',
            ],
            [
                'kode' => '00075',
                'slug' => 'JAMINAN CO-INSIDENSE',
                'nama' => 'CO-INS',
            ],
            [
                'kode' => '00076',
                'slug' => 'JAMPERSAL',
                'nama' => 'JPS',
            ],
            [
                'kode' => '00077',
                'slug' => 'JAMINAN PEMULIHAN KESEHATAN PRIORITAS',
                'nama' => 'JPKP',
            ],
            [
                'kode' => '00005',
                'slug' => '001',
                'nama' => 'JAMKESDA',
            ],
            [
                'kode' => '00006',
                'slug' => 'JKS',
                'nama' => 'JAMKESOS',
            ],
            [
                'kode' => '00001',
                'slug' => 'PASIEN BAYAR',
                'nama' => '999',
            ],
        ];
        foreach ($jaminan as  $value) {
            Jaminan::create([
                'kode' => $value['kode'],
                'slug' => $value['slug'],
                'nama' => $value['nama'],
            ]);
        }
    }
}
