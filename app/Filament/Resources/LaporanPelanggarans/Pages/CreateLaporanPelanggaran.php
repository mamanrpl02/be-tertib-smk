<?php

namespace App\Filament\Resources\LaporanPelanggarans\Pages;

use App\Filament\Resources\LaporanPelanggarans\LaporanPelanggaranResource;
use App\Models\Siswa;
use Filament\Resources\Pages\CreateRecord;

class CreateLaporanPelanggaran extends CreateRecord
{
    protected static string $resource = LaporanPelanggaranResource::class;

    protected array $siswaIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tipe = $data['tipe_laporan'] ?? 'spesifik';

        // 🔹 Jika spesifik → langsung ambil dari input siswa_id
        if ($tipe === 'spesifik') {
            $this->siswaIds = (array) ($data['siswa_id'] ?? []);
        }

        // 🔹 Jika tingkat → ambil semua siswa yang punya kelas dengan tingkat itu
        elseif ($tipe === 'tingkat' && isset($data['tingkat'])) {
            $tingkat = $data['tingkat'];

            $this->siswaIds = Siswa::whereHas('kelasTingkat10', fn($q) => $q->where('tingkat', $tingkat))
                ->orWhereHas('kelasTingkat11', fn($q) => $q->where('tingkat', $tingkat))
                ->orWhereHas('kelasTingkat12', fn($q) => $q->where('tingkat', $tingkat))
                ->get()
                ->filter(function ($siswa) use ($tingkat) {
                    // 🔹 Pastikan siswa hanya aktif di satu tingkat
                    return match ($tingkat) {
                        '10' => $siswa->kelasTingkat10 && !$siswa->kelasTingkat11 && !$siswa->kelasTingkat12,
                        '11' => $siswa->kelasTingkat11 && !$siswa->kelasTingkat12,
                        '12' => $siswa->kelasTingkat12 != null,
                        default => false,
                    };
                })
                ->pluck('id')
                ->toArray();
        }

        // 🔹 Jika tingkat_jurusan → ambil semua siswa di kelas_siswa_id tersebut
        elseif ($tipe === 'tingkat_jurusan' && isset($data['kelas_siswa_id'])) {
            $kelas = \App\Models\KelasSiswa::find($data['kelas_siswa_id']);

            if ($kelas) {
                $tingkat = $kelas->tingkat;
                $jurusan = $kelas->jurusan;

                $this->siswaIds = Siswa::where(function ($q) use ($tingkat, $jurusan) {
                    $q->whereHas('kelasTingkat10', fn($r) => $r->where('tingkat', $tingkat)->where('jurusan', $jurusan))
                        ->orWhereHas('kelasTingkat11', fn($r) => $r->where('tingkat', $tingkat)->where('jurusan', $jurusan))
                        ->orWhereHas('kelasTingkat12', fn($r) => $r->where('tingkat', $tingkat)->where('jurusan', $jurusan));
                })
                    ->get()
                    ->filter(function ($siswa) use ($tingkat) {
                        // Hanya siswa aktif di satu tingkat
                        return match ($tingkat) {
                            '10' => $siswa->kelasTingkat10 && !$siswa->kelasTingkat11 && !$siswa->kelasTingkat12,
                            '11' => $siswa->kelasTingkat11 && !$siswa->kelasTingkat12,
                            '12' => $siswa->kelasTingkat12 != null,
                            default => false,
                        };
                    })
                    ->pluck('id')
                    ->toArray();
            }
        }

        unset($data['siswa_id']);
        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->siswaIds)) {
            $this->record->siswa()->sync($this->siswaIds);
        }
    }
}
