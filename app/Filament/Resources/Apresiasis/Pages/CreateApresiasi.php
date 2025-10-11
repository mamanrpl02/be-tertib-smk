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
        if ($data['tipe_apresiasi'] === 'tingkat') {
            $data['siswa_ids'] = Siswa::whereHas('kelasSiswa', function ($q) use ($data) {
                $q->where('tingkat', $data['tingkat']);
            })->pluck('id')->toArray();
        } elseif ($data['tipe_apresiasi'] === 'tingkat_jurusan') {
            $data['siswa_ids'] = Siswa::where('kelas_siswa_id', $data['kelas_siswa_id'])->pluck('id')->toArray();
        }

        return $data;
    }
}
