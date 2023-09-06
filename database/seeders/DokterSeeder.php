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
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Menik Herdwiyanti, Sp.PD, FINASIM",
            "kodedokter" => "79887",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Ahmad Fariz M. Z. Zein, Sp.P.D., M.M., FACP.",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Isti Noviani, Sp.PK(K), MMRS",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Lestari Putri, Sp. PA",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Asih Ambarsari, Sp.PA",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Nunik Royyani, Sp.Rad",
            "gender" => "P",
            "subtitle" => "Dokter Klinik",
        ]);
        Dokter::create([
            "namadokter" => "dr. Rizki Nataprawira",
            "gender" => "L",
            "subtitle" => "Dokter Klinik",
        ]);
    }
}
