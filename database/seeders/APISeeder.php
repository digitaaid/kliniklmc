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
            'Eklaim BPJS',
            'Apotek BPJS',
            'Google Auth',
            'Satu Sehat',
        ];
        foreach ($apis as $item) {
            $role = IntegrasiApi::create(['name' => $item]);
        }
        IntegrasiApi::create([
            'name' => 'Antrian BPJS',
            'user_id' => '10468',
            'user_key' => '8cd80a9746b240421b5e9f446080148b',
            'secret_key' => '5uT04A732C',
            'base_url' => "https://apijkn.bpjs-kesehatan.go.id/antreanrs/",
        ]);
        IntegrasiApi::create([
            'name' => 'Vclaim BPJS',
            'user_id' => '10468',
            'user_key' => 'ee3c5b791c012c6c010d9e77440ca409',
            'secret_key' => '5uT04A732C',
            'base_url' => "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/",
        ]);
    }
}
