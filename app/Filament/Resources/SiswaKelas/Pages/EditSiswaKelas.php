<?php

namespace App\Filament\Resources\SiswaKelas\Pages;

use App\Filament\Resources\SiswaKelas\SiswaKelasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiswaKelas extends EditRecord
{
    protected static string $resource = SiswaKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
