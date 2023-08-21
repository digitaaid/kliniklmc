<?php

namespace Database\Seeders;

use App\Models\IntegrasiApi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class APISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $apis = [
            'Vclaim BPJS',
            'Antrian BPJS',
            'Eklaim BPJS',
            'Apotek BPJS',
            'Google Auth',
            'Satu Sehat',
        ];
        foreach ($apis as $item) {
            $role = IntegrasiApi::create(['name' => $item]);
        }
    }
}
