<?php

namespace App\Filament\Resources\LaporanPelanggarans\Pages;

use App\Filament\Resources\LaporanPelanggarans\LaporanPelanggaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanPelanggaran extends EditRecord
{
    protected static string $resource = LaporanPelanggaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
