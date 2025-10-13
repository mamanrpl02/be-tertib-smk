<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswaData = [
            ['nama' => 'Abdurrahman', 'email' => 'maman@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 4, 'tingkat_11' => 2],
            ['nama' => 'Aisyah Putri', 'email' => 'aisyah@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Rizky Maulana', 'email' => 'rizky@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 4, 'tingkat_11' => 2],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Fajar Nugraha', 'email' => 'fajar@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Nanda Sari', 'email' => 'nanda@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Bima Pratama', 'email' => 'bima@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Citra Ayu', 'email' => 'citra@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Fadil Ramadhan', 'email' => 'fadil@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Salsabila Rahma', 'email' => 'salsa@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Ilham Saputra', 'email' => 'ilham@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Nabila Zahra', 'email' => 'nabila@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Yusuf Alfiansyah', 'email' => 'yusuf@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1,  'tingkat_11' => 2],
            ['nama' => 'Lina Marlina', 'email' => 'lina@example.com', 'jenis_kelamin' => 'Perempuan', 'tingkat_10' => 1, 'tingkat_11' => 2],
            ['nama' => 'Rafi Kurniawan', 'email' => 'rafi@example.com', 'jenis_kelamin' => 'Laki-laki', 'tingkat_10' => 1,  'tingkat_11' => 2]
        ];

        foreach ($siswaData as $data) {
            Siswa::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'jenis_kelamin' => $data['jenis_kelamin'],
                'foto_profile' => null,
                'tingkat_10' => $data['tingkat_10'], // ID kelas contoh
                'tingkat_11' => $data['tingkat_11'],
                'tingkat_12' => null,
            ]);
        }
    }
}
