<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasal;
use App\Models\Pelanggaran;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Pasal 1 — KETERLAMBATAN
            [
                'pasal' => 'Pasal 1',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Datang terlambat tanpa alasan yang jelas', 'poin' => 5],
                    ['ayat' => 2, 'pelanggaran' => 'Tidak mengikuti upacara tanpa keterangan', 'poin' => 10],
                    ['ayat' => 3, 'pelanggaran' => 'Membolos tanpa izin guru atau wali kelas', 'poin' => 20],
                ],
            ],

            // Pasal 2 — KEHADIRAN
            [
                'pasal' => 'Pasal 2',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Tidak hadir tanpa surat izin atau keterangan sah', 'poin' => 10],
                    ['ayat' => 2, 'pelanggaran' => 'Pulang sebelum waktunya tanpa izin guru piket', 'poin' => 15],
                ],
            ],

            // Pasal 3 — PAKAIAN
            [
                'pasal' => 'Pasal 3',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Seragam tidak sesuai ketentuan sekolah', 'poin' => 5],
                    ['ayat' => 2, 'pelanggaran' => 'Rambut panjang atau berwarna', 'poin' => 5],
                    ['ayat' => 3, 'pelanggaran' => 'Tidak mengenakan atribut sekolah lengkap', 'poin' => 3],
                ],
            ],

            // Pasal 4 — KEPRIBADIAN
            [
                'pasal' => 'Pasal 4',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Bersikap tidak sopan terhadap guru atau staf', 'poin' => 15],
                    ['ayat' => 2, 'pelanggaran' => 'Berbohong kepada guru atau wali kelas', 'poin' => 10],
                    ['ayat' => 3, 'pelanggaran' => 'Berbicara kasar kepada teman atau guru', 'poin' => 10],
                ],
            ],

            // Pasal 5 — KETERTIBAN
            [
                'pasal' => 'Pasal 5',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Menggunakan HP saat pelajaran tanpa izin', 'poin' => 10],
                    ['ayat' => 2, 'pelanggaran' => 'Makan di kelas saat pembelajaran berlangsung', 'poin' => 5],
                    ['ayat' => 3, 'pelanggaran' => 'Tidur saat pelajaran tanpa izin', 'poin' => 5],
                ],
            ],

            // Pasal 6 — KEBERSIHAN
            [
                'pasal' => 'Pasal 6',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Membuang sampah sembarangan', 'poin' => 3],
                    ['ayat' => 2, 'pelanggaran' => 'Tidak melaksanakan jadwal piket', 'poin' => 5],
                    ['ayat' => 3, 'pelanggaran' => 'Merusak fasilitas kebersihan sekolah', 'poin' => 15],
                ],
            ],

            // Pasal 7 — MEROKOK
            [
                'pasal' => 'Pasal 7',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Membawa rokok, vape, atau alat sejenis ke sekolah', 'poin' => 30],
                    ['ayat' => 2, 'pelanggaran' => 'Merokok di lingkungan sekolah', 'poin' => 40],
                ],
            ],

            // Pasal 8 — PORNOGRAFI
            [
                'pasal' => 'Pasal 8',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Mengakses situs atau konten pornografi', 'poin' => 40],
                    ['ayat' => 2, 'pelanggaran' => 'Menyebarkan konten tidak senonoh melalui media sosial', 'poin' => 50],
                ],
            ],

            // Pasal 9 — SENJATA TAJAM
            [
                'pasal' => 'Pasal 9',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Membawa senjata tajam tanpa izin', 'poin' => 50],
                    ['ayat' => 2, 'pelanggaran' => 'Menggunakan benda berbahaya untuk mengancam', 'poin' => 60],
                ],
            ],

            // Pasal 10 — NARKOBA DAN MINUMAN KERAS
            [
                'pasal' => 'Pasal 10',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Mengonsumsi narkoba atau alkohol', 'poin' => 80],
                    ['ayat' => 2, 'pelanggaran' => 'Mengedarkan atau mempengaruhi teman untuk memakai narkoba', 'poin' => 100],
                ],
            ],

            // Pasal 11 — TAWURAN
            [
                'pasal' => 'Pasal 11',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Terlibat tawuran antar pelajar', 'poin' => 80],
                    ['ayat' => 2, 'pelanggaran' => 'Memprovokasi terjadinya perkelahian', 'poin' => 60],
                ],
            ],

            // Pasal 12 — INTIMIDASI / ANCAMAN DAN KEKERASAN
            [
                'pasal' => 'Pasal 12',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Melakukan perundungan (bullying) secara fisik atau verbal', 'poin' => 50],
                    ['ayat' => 2, 'pelanggaran' => 'Mengancam teman atau guru', 'poin' => 60],
                ],
            ],

            // Pasal 13 — PERBUATAN ASUSILA
            [
                'pasal' => 'Pasal 13',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Berduaan di tempat sepi dengan lawan jenis', 'poin' => 40],
                    ['ayat' => 2, 'pelanggaran' => 'Melakukan tindakan yang melanggar norma kesusilaan', 'poin' => 70],
                ],
            ],

            // Pasal 14 — TEKNOLOGI INFORMASI
            [
                'pasal' => 'Pasal 14',
                'pelanggaran' => [
                    ['ayat' => 1, 'pelanggaran' => 'Menggunakan akun media sosial untuk menjelekkan sekolah', 'poin' => 40],
                    ['ayat' => 2, 'pelanggaran' => 'Menyebarkan informasi palsu atas nama sekolah', 'poin' => 50],
                    ['ayat' => 3, 'pelanggaran' => 'Menggunakan jaringan sekolah untuk hal negatif', 'poin' => 30],
                ],
            ],
        ];

        foreach ($data as $item) {
            $pasal = Pasal::where('nama_pasal', $item['pasal'])->first();
            if (!$pasal) continue;

            foreach ($item['pelanggaran'] as $p) {
                Pelanggaran::create([
                    'pasal_id' => $pasal->id,
                    'ayat' => $p['ayat'],
                    'pelanggaran' => $p['pelanggaran'],
                    'poin' => $p['poin'],
                ]);
            }
        }
    }
}
