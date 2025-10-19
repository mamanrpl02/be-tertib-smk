<?php

namespace App\Filament\Resources\LaporanPelanggarans\Pages;

use App\Models\Siswa;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\LaporanPelanggarans\LaporanPelanggaranResource;

class EditLaporanPelanggaran extends EditRecord
{
    protected static string $resource = LaporanPelanggaranResource::class;

    // 🧩 Tambahkan juga di sini
    protected array $siswaIds = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['approval_action']);
        $tipe = $data['tipe_laporan'] ?? 'spesifik';

        if ($tipe === 'spesifik') {
            $this->siswaIds = (array) ($data['siswa_id'] ?? []);
        } elseif ($tipe === 'tingkat' && isset($data['tingkat'])) {
            $this->siswaIds = Siswa::whereHas('kelasTingkat' . $data['tingkat'])->pluck('id')->toArray();
        } elseif ($tipe === 'tingkat_jurusan' && isset($data['kelas_siswa_id'])) {
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

    protected function afterSave(): void
    {
        if (!empty($this->siswaIds)) {
            $this->record->siswa()->sync($this->siswaIds);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
