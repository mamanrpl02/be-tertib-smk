<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\KelasSiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Maman',
            'email' => 'maman@tertib.com',
            'password' => bcrypt('12341234'),
        ]);

        $jurusans = [
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak (RPL)', 'sub_kelas' => 'A'],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak (RPL)', 'sub_kelas' => 'B'],
            ['nama_jurusan' => 'Teknik Kendaraan Ringan Otomotif (TKRO)', 'sub_kelas' => 'A'],
            ['nama_jurusan' => 'Teknik Kendaraan Ringan Otomotif (TKRO)', 'sub_kelas' => 'B'],
            ['nama_jurusan' => 'Teknik Alat Berat', 'sub_kelas' => 'A'],
        ];

        foreach ($jurusans as $data) {
            Jurusan::create($data);
        }

        $this->call([
            KelasSiswaSeeder::class,
        ]);
        $this->call(SiswaSeeder::class);
        // $this->call(ApresiasiSeeder::class);
    }
}
