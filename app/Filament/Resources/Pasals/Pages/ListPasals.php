<?php

namespace App\Filament\Resources\Pasals\Pages;

use App\Filament\Resources\Pasals\PasalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPasals extends ListRecords
{
    protected static string $resource = PasalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
