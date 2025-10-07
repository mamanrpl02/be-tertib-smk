<?php

namespace App\Filament\Resources\SiswaKelas\Pages;

use App\Filament\Resources\SiswaKelas\SiswaKelasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiswaKelas extends ListRecords
{
    protected static string $resource = SiswaKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
