<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        RumahSakit::insert([
            [
                'nama_rumah_sakit' => 'RSUD Soetomo',
                'alamat' => 'Jl. Mayjen Prof. Moestopo No.6-8, Airlangga, Kec. Gubeng, Surabaya',
                'email' => 'info@rsudsoetomo.com',
                'telepon' => '031-5501076',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_rumah_sakit' => 'RSUP Kariadi',
                'alamat' => 'Jl. Sutomo No.16, Randusari, Kec. Semarang Sel., Kota Semarang',
                'email' => 'info@rskariadi.com',
                'telepon' => '024-8413476',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        Pasien::factory()->count(50000)->create();
    }
}
