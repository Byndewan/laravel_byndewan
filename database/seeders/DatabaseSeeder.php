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

        Pasien::insert([
            [
                'nama_pasien' => 'Budi B',
                'alamat' => 'Jl. Mayjen Prof. Moestopo No.6-8, Airlangga, Kec. Gubeng, Surabaya',
                'no_telepon' => '031-5501076',
                'rumah_sakit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Wina W',
                'alamat' => 'Jl. Sutomo No.16, Randusari, Kec. Semarang Sel., Kota Semarang',
                'no_telepon' => '024-8413476',
                'rumah_sakit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Andi P',
                'alamat' => 'Jl. Diponegoro No.45, Menteng, Jakarta Pusat',
                'no_telepon' => '021-3145567',
                'rumah_sakit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Siti Aminah',
                'alamat' => 'Jl. Ahmad Yani No.88, Klojen, Kota Malang',
                'no_telepon' => '0341-722889',
                'rumah_sakit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Rizky H',
                'alamat' => 'Jl. Veteran No.23, Denpasar Barat, Bali',
                'no_telepon' => '0361-234567',
                'rumah_sakit_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Maria L',
                'alamat' => 'Jl. Asia Afrika No.12, Sumurbandung, Kota Bandung',
                'no_telepon' => '022-5672345',
                'rumah_sakit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Joko S',
                'alamat' => 'Jl. Slamet Riyadi No.33, Laweyan, Kota Surakarta',
                'no_telepon' => '0271-667899',
                'rumah_sakit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Clara N',
                'alamat' => 'Jl. Gajah Mada No.10, Pontianak Kota, Kalimantan Barat',
                'no_telepon' => '0561-765432',
                'rumah_sakit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Agus T',
                'alamat' => 'Jl. Pattimura No.7, Ambon',
                'no_telepon' => '0911-234567',
                'rumah_sakit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pasien' => 'Linda K',
                'alamat' => 'Jl. Diponegoro No.55, Makassar',
                'no_telepon' => '0411-987654',
                'rumah_sakit_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
