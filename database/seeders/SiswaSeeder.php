<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'nama' => 'Abdurrahman',
            'email' => 'maman@example.com',
            'password' => Hash::make('password123'),
            'jenis_kelamin' => 'Laki-laki',
            'foto_profile' => null,
            'tingkat_10' => 1, // ID kelas dari tabel kelas_siswas
            'tingkat_11' => null,
            'tingkat_12' => null,
        ]);
    }
}
