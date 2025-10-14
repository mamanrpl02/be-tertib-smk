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
        // Hilangkan field pivot dari form data sebelum create
        unset($data['siswa'], $data['kecuali_siswa_tingkat'], $data['kecuali_siswa_jurusan']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncSiswaPivot();
    }

    protected function syncSiswaPivot(): void
    {
        $record = $this->record;
        $data = $this->form->getState();
        $siswaIds = [];

        if ($record->tipe_apresiasi === 'spesifik') {
            $siswaIds = array_map('intval', $data['siswa'] ?? []);
        } elseif ($record->tipe_apresiasi === 'tingkat' && $record->tingkat) {
            $semuaSiswa = Siswa::all()->filter(function ($siswa) use ($record) {
                $aktif = $siswa->tingkat_10 ? '10' : ($siswa->tingkat_11 ? '11' : ($siswa->tingkat_12 ? '12' : null));
                return $aktif === $record->tingkat;
            });

            $semuaIds = $semuaSiswa->pluck('id')->map(fn($id) => (int) $id)->toArray();
            $kecuali = array_map('intval', $data['kecuali_siswa_tingkat'] ?? []);
            $siswaIds = array_values(array_diff($semuaIds, $kecuali));
        } elseif ($record->tipe_apresiasi === 'tingkat_jurusan' && $record->kelas_siswa_id) {
            $kelas = KelasSiswa::find($record->kelas_siswa_id);
            if (!$kelas) return;

            $tingkat = $kelas->tingkat;
            $siswaAktif = Siswa::all()->filter(function ($siswa) use ($tingkat, $kelas) {
                $aktif = $siswa->tingkat_10 ? '10' : ($siswa->tingkat_11 ? '11' : ($siswa->tingkat_12 ? '12' : null));
                return match ($tingkat) {
                    '10' => $aktif === '10' && $siswa->tingkat_10 == $kelas->id,
                    '11' => $aktif === '11' && $siswa->tingkat_11 == $kelas->id,
                    '12' => $aktif === '12' && $siswa->tingkat_12 == $kelas->id,
                    default => false,
                };
            });

            $semuaIds = $siswaAktif->pluck('id')->map(fn($id) => (int) $id)->toArray();
            $kecuali = array_map('intval', $data['kecuali_siswa_jurusan'] ?? []);
            $siswaIds = array_values(array_diff($semuaIds, $kecuali));
        }

        if (!empty($siswaIds)) {
            $record->siswa()->sync($siswaIds);
        }
    }
}
