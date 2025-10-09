<?php

namespace App\Filament\Resources\Apresiasis\Pages;

use App\Filament\Resources\Apresiasis\ApresiasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApresiasis extends ListRecords
{
    protected static string $resource = ApresiasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
