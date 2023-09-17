<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dokter::create([
            "namadokter" => "dr. Mohamad Luthfi., Sp.PD., MMRS, FINASIM",
            "kodedokter" => "8297",
            "kodejkn" => "8297",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Menik Herdwiyanti, Sp.PD, FINASIM",
            "kodedokter" => "79887",
            "kodejkn" => "79887",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Ahmad Fariz M. Z. Zein, Sp.P.D., M.M., FACP.",
            "kodedokter" => "00001",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Isti Noviani, Sp.PK(K), MMRS",
            "kodedokter" => "00002",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Lestari Putri, Sp. PA",
            "kodedokter" => "00003",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Asih Ambarsari, Sp.PA",
            "kodedokter" => "00004",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Nunik Royyani, Sp.Rad",
            "kodedokter" => "00005",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
        Dokter::create([
            "namadokter" => "dr. Rizki Nataprawira",
            "kodedokter" => "00006",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
            "user" => "Admin Super",

        ]);
    }
}
