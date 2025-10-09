<?php

namespace App\Filament\Resources\Apresiasis\Pages;

use App\Filament\Resources\Apresiasis\ApresiasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApresiasi extends EditRecord
{
    protected static string $resource = ApresiasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
