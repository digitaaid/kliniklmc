<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $unit = [
            [
                'kode' => '008',
                'nama' => 'HEMATOLOGI - ONKOLOGI MEDIK',
                'kodejkn' => '008',
                'status' => 1,

            ],
            [
                'kode' => 'LAB',
                'nama' => 'LABORATORIUM',
                'kodejkn' => null,
                'status' => 1,

            ],
            [
                'kode' => 'RAD',
                'nama' => 'RADIOLOGI',
                'status' => 1,
                'kodejkn' => null,
            ],
            [
                'kode' => 'KMT',
                'nama' => 'KEMOTERAPI',
                'status' => 1,
                'kodejkn' => null,
            ],
            [
                'kode' => 'FAR',
                'nama' => 'FARMASI',
                'status' => 1,
                'kodejkn' => null,
            ],
            [
                'kode' => 'PRT',
                'nama' => 'PERAWAT',
                'status' => 2,
                'kodejkn' => null,
            ],
            [
                'kode' => 'ADM',
                'nama' => 'ADMINISTRASI',
                'status' => 2,
                'kodejkn' => null,
            ],
            [
                'kode' => 'RM',
                'nama' => 'REKAM MEDIS',
                'status' => 2,
                'kodejkn' => null,
            ],

        ];
        foreach ($unit as  $value) {
            $user = Unit::create([
                "kode" => $value['kode'],
                "nama" => $value['nama'],
                "kodejkn" => $value['kodejkn'],
                "status" => $value['status'],
                "user" => "Admin Super",
            ]);
        }
    }
}
