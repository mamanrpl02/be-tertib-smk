<?php

namespace App\Filament\Resources\Apresiasis\Pages;

use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Filament\Resources\Apresiasis\ApresiasiResource;
use Filament\Resources\Pages\EditRecord;

class EditApresiasi extends EditRecord
{
    protected static string $resource = ApresiasiResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['siswa'], $data['kecuali_siswa_tingkat'], $data['kecuali_siswa_jurusan']);
        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncSiswaPivot();
    }

    protected function syncSiswaPivot(): void
    {
        $record = $this->record;
        $data = $this->form->getState();

        // --- 1️⃣ Jika apresiasi untuk siswa spesifik ---
        if ($record->tipe_apresiasi === 'spesifik') {
            $siswaIds = array_map('intval', $data['siswa'] ?? []);
            $record->siswa()->sync($siswaIds);
            return;
        }

        // --- 2️⃣ Jika apresiasi berdasarkan tingkat ---
        elseif ($record->tipe_apresiasi === 'tingkat' && $record->tingkat) {
            $tingkat = $record->tingkat;

            // 🔹 Ambil semua siswa aktif di tingkat tersebut
            $siswaTingkat = match ($tingkat) {
                '10' => Siswa::whereNotNull('tingkat_10')->whereNull('tingkat_11')->whereNull('tingkat_12')->get(),
                '11' => Siswa::whereNotNull('tingkat_11')->whereNull('tingkat_12')->get(),
                '12' => Siswa::whereNotNull('tingkat_12')->get(),
                default => collect(),
            };

            // 🔹 Ambil siswa yang dikecualikan dari form
            $kecuali = collect($data['kecuali_siswa_tingkat'] ?? [])->map(fn($id) => (int) $id);

            // 🔹 Sinkronisasi pivot
            $syncData = [];
            foreach ($siswaTingkat as $siswa) {
                $syncData[$siswa->id] = [
                    'dikecualikan' => $kecuali->contains($siswa->id),
                ];
            }

            $record->siswa()->sync($syncData);
            return;
        }

        // --- 3️⃣ Jika apresiasi berdasarkan tingkat & jurusan ---
        elseif ($record->tipe_apresiasi === 'tingkat_jurusan' && $record->kelas_siswa_id) {
            $kelas = KelasSiswa::find($record->kelas_siswa_id);
            if (! $kelas) return;

            $tingkat = $kelas->tingkat;
            $jurusan = $kelas->jurusan;

            // 🔹 Ambil semua siswa aktif sesuai tingkat + jurusan
            $siswaKelas = match ($tingkat) {
                '10' => Siswa::whereHas('kelasTingkat10', fn($q) => $q->where('jurusan', $jurusan))
                    ->whereNull('tingkat_11')
                    ->whereNull('tingkat_12')
                    ->get(),

                '11' => Siswa::whereHas('kelasTingkat11', fn($q) => $q->where('jurusan', $jurusan))
                    ->whereNull('tingkat_12')
                    ->get(),

                '12' => Siswa::whereHas('kelasTingkat12', fn($q) => $q->where('jurusan', $jurusan))
                    ->get(),

                default => collect(),
            };

            // 🔹 Ambil siswa yang dikecualikan dari form
            $kecuali = collect($data['kecuali_siswa_jurusan'] ?? [])->map(fn($id) => (int) $id);

            // 🔹 Sinkronisasi pivot
            $syncData = [];
            foreach ($siswaKelas as $siswa) {
                $syncData[$siswa->id] = [
                    'dikecualikan' => $kecuali->contains($siswa->id),
                ];
            }

            $record->siswa()->sync($syncData);
            return;
        }
    }
}
