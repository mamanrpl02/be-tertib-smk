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
        $siswaIds = [];

        // --- 1. Jika apresiasi untuk siswa spesifik ---
        if ($record->tipe_apresiasi === 'spesifik') {
            $siswaIds = array_map('intval', $data['siswa'] ?? []);
        }

        // --- 2. Jika apresiasi berdasarkan tingkat ---
        elseif ($record->tipe_apresiasi === 'tingkat' && $record->tingkat) {
            $tingkat = $record->tingkat;

            // 🔹 Ambil semua siswa di tingkat tersebut
            $siswaTingkat = Siswa::all()->filter(function ($siswa) use ($tingkat) {
                if ($siswa->tingkat_12) $aktif = '12';
                elseif ($siswa->tingkat_11) $aktif = '11';
                elseif ($siswa->tingkat_10) $aktif = '10';
                else $aktif = null;

                return $aktif === $tingkat;
            });

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
        }

        // --- 3. Jika apresiasi berdasarkan tingkat & jurusan ---
        elseif ($record->tipe_apresiasi === 'tingkat_jurusan' && $record->kelas_siswa_id) {
            $kelas = KelasSiswa::find($record->kelas_siswa_id);
            if (!$kelas) return;

            $siswaKelas = Siswa::query()
                ->where(function ($query) use ($kelas) {
                    $query->where('tingkat_10', $kelas->id)
                        ->orWhere('tingkat_11', $kelas->id)
                        ->orWhere('tingkat_12', $kelas->id);
                })
                ->pluck('id')
                ->toArray();

            $kecuali = array_map('intval', $data['kecuali_siswa_jurusan'] ?? []);
            $siswaIds = array_values(array_diff($siswaKelas, $kecuali));

            $record->siswa()->sync($siswaIds);
        }
    }
}
