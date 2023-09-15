<?php

namespace Database\Seeders;

use App\Models\Poliklinik;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "Marwan Dhiaur Rahman",
            "email" => "marwandhiaurrahman@gmail.com",
            "username" => "marwan",
            "phone" => "089529909036",
            'password' => bcrypt('qweqwe123'),
            'user_verify' => 1,
            'email_verified_at' => now()
        ]);
        $user->assignRole('Admin Super');
        $user = User::create([
            "name" => "Admin Klinik",
            "email" => "admin@gmail.com",
            "username" => "admins",
            "phone" => "089529909036",
            'password' => bcrypt('qweqwe123'),
            'user_verify' => 1,
            'email_verified_at' => now()
        ]);
        $user->assignRole('Admin Super');
        $roles = [
            'Admin',
            'Pasien',
            'Pendaftaran',
            'Perawat',
            'Dokter',
            'Farmasi',
            'Laboratorium',
            'Radiologi',
            'Rekam Medis',
            'Casemix',
            'Manajemen',
        ];
        foreach ($roles as  $value) {
            $user = User::create([
                "name" => $value,
                "email" => Str::slug($value) . "@gmail.com",
                "username" => Str::slug($value),
                "phone" => "089529909036",
                'password' => bcrypt(Str::slug($value)),
                'user_verify' => 1,
                'email_verified_at' => now()
            ]);
            $user->assignRole('Admin Super');
        }
    }
}
