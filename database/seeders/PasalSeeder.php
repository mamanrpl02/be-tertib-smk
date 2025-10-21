<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasal;

class PasalSeeder extends Seeder
{
    public function run(): void
    {
        $pasals = [
            [
                'nama_pasal' => 'Pasal 1',
                'judul' => 'KETERLAMBATAN',
                'deskripsi' => 'Mengatur ketepatan waktu siswa dalam hadir ke sekolah dan mengikuti kegiatan pembelajaran.',
            ],
            [
                'nama_pasal' => 'Pasal 2',
                'judul' => 'KEHADIRAN',
                'deskripsi' => 'Menjelaskan kewajiban siswa untuk hadir dalam seluruh kegiatan akademik maupun non-akademik.',
            ],
            [
                'nama_pasal' => 'Pasal 3',
                'judul' => 'PAKAIAN',
                'deskripsi' => 'Mengatur ketentuan berpakaian siswa agar rapi, sopan, dan sesuai aturan sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 4',
                'judul' => 'KEPRIBADIAN',
                'deskripsi' => 'Mendorong siswa memiliki sikap sopan santun, tanggung jawab, dan kejujuran di lingkungan sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 5',
                'judul' => 'KETERTIBAN',
                'deskripsi' => 'Menjaga suasana belajar yang kondusif dengan mengikuti tata tertib yang berlaku di sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 6',
                'judul' => 'KEBERSIHAN',
                'deskripsi' => 'Menanamkan kebiasaan hidup bersih dan menjaga lingkungan sekolah tetap nyaman dan sehat.',
            ],
            [
                'nama_pasal' => 'Pasal 7',
                'judul' => 'MEROKOK',
                'deskripsi' => 'Melarang keras siswa merokok atau membawa alat rokok dalam bentuk apa pun di lingkungan sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 8',
                'judul' => 'PORNOGRAFI',
                'deskripsi' => 'Melarang siswa memiliki, menyebarkan, atau mengakses konten pornografi dalam bentuk apa pun.',
            ],
            [
                'nama_pasal' => 'Pasal 9',
                'judul' => 'SENJATA TAJAM',
                'deskripsi' => 'Melarang siswa membawa, memiliki, atau menggunakan senjata tajam atau benda berbahaya di sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 10',
                'judul' => 'NARKOBA DAN MINUMAN KERAS',
                'deskripsi' => 'Melarang siswa menggunakan, membawa, atau mengedarkan narkoba serta minuman keras.',
            ],
            [
                'nama_pasal' => 'Pasal 11',
                'judul' => 'TAWURAN',
                'deskripsi' => 'Mengatur larangan bagi siswa untuk terlibat dalam tindakan kekerasan atau perkelahian antar pelajar.',
            ],
            [
                'nama_pasal' => 'Pasal 12',
                'judul' => 'INTIMIDASI / ANCAMAN DAN KEKERASAN',
                'deskripsi' => 'Melarang segala bentuk kekerasan fisik maupun verbal, termasuk perundungan dan ancaman.',
            ],
            [
                'nama_pasal' => 'Pasal 13',
                'judul' => 'PERBUATAN ASUSILA',
                'deskripsi' => 'Menegaskan larangan terhadap perbuatan yang melanggar norma kesopanan dan moral di lingkungan sekolah.',
            ],
            [
                'nama_pasal' => 'Pasal 14',
                'judul' => 'TEKNOLOGI INFORMASI',
                'deskripsi' => 'Mengatur penggunaan perangkat teknologi agar bermanfaat secara positif dan tidak disalahgunakan.',
            ],
        ];

        Pasal::insert($pasals);
    }
}
