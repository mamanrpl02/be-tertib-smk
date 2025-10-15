<?php

namespace App\Filament\Resources\Apresiasis\Pages;

use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Filament\Resources\Apresiasis\ApresiasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApresiasi extends CreateRecord
{
    protected static string $resource = ApresiasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hapus field pivot sebelum disimpan di tabel utama
        unset($data['siswa'], $data['kecuali_siswa_tingkat'], $data['kecuali_siswa_jurusan']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncSiswaPivot();
    }

    /**
     * Sinkronisasi data siswa di pivot apresiasi_siswa
     */
    protected function syncSiswaPivot(): void
    {
        $record = $this->record;
        $data = $this->form->getState();

        // 🟩 CASE 1: Apresiasi untuk siswa spesifik
        if ($record->tipe_apresiasi === 'spesifik') {
            $siswaIds = collect($data['siswa'] ?? [])
                ->map(fn($id) => (int) $id)
                ->toArray();

            if (!empty($siswaIds)) {
                $record->siswa()->sync($siswaIds);
            }
            return;
        }

        // 🟩 CASE 2: Apresiasi berdasarkan tingkat (misalnya semua siswa kelas 10)
        if ($record->tipe_apresiasi === 'tingkat' && $record->tingkat) {
            $tingkat = $record->tingkat;

            // Ambil siswa yang BENAR-BENAR aktif di tingkat itu
            $siswaTingkat = match ($tingkat) {
                '10' => Siswa::whereNotNull('tingkat_10')->whereNull('tingkat_11')->whereNull('tingkat_12')->get(),
                '11' => Siswa::whereNotNull('tingkat_11')->whereNull('tingkat_12')->get(),
                '12' => Siswa::whereNotNull('tingkat_12')->get(),
                default => collect(),
            };

            // Ambil daftar siswa yang dikecualikan (konversi ke int)
            $kecuali = collect($data['kecuali_siswa_tingkat'] ?? [])
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Buat array pivot lengkap: siswa_id => ['dikecualikan' => true/false]
            $syncData = [];
            foreach ($siswaTingkat as $siswa) {
                $syncData[$siswa->id] = [
                    'dikecualikan' => in_array($siswa->id, $kecuali),
                ];
            }

            $record->siswa()->sync($syncData);
            return;
        }

        // 🟩 CASE 3: Apresiasi berdasarkan tingkat + jurusan
        if ($record->tipe_apresiasi === 'tingkat_jurusan' && $record->kelas_siswa_id) {
            $kelas = KelasSiswa::find($record->kelas_siswa_id);
            if (!$kelas) return;

            // Ambil semua siswa yang terkait dengan kelas tersebut (pada tingkat mana pun)
            $siswaKelas = Siswa::query()
                ->where(
                    fn($query) =>
                    $query->where('tingkat_10', $kelas->id)
                        ->orWhere('tingkat_11', $kelas->id)
                        ->orWhere('tingkat_12', $kelas->id)
                )
                ->pluck('id')
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Ambil daftar siswa yang dikecualikan
            $kecuali = collect($data['kecuali_siswa_jurusan'] ?? [])
                ->map(fn($id) => (int) $id)
                ->toArray();

            // Hanya siswa yang tidak dikecualikan
            $siswaFinal = array_diff($siswaKelas, $kecuali);

            if (!empty($siswaFinal)) {
                $record->siswa()->sync($siswaFinal);
            }
            return;
        }
    }
}
