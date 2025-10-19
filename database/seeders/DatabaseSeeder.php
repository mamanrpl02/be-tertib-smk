<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\KelasSiswa;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Admin Maman',
                'email' => 'admin@tertib.com',
                'password' => bcrypt('12341234'),
            ],
            [
                'name' => 'Guru Budi',
                'email' => 'guru@tertib.com',
                'password' => bcrypt('12341234'),
                'role' => 'guru',
            ],
            [
                'name' => 'Guru Joko',
                'email' => 'joko@tertib.com',
                'password' => bcrypt('12341234'),
                'role' => 'guru',
            ],
            [
                'name' => 'Staf RPL',
                'email' => 'staf.rpl@tertib.com',
                'password' => bcrypt('12341234'),
                'role' => 'staf',
            ],
        ]);


        $this->call([
            KelasSiswaSeeder::class,
        ]);
        $this->call(SiswaSeeder::class);
        $this->call(PelanggaranSeeder::class);
    }
}
