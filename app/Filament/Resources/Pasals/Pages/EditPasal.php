<?php

namespace App\Filament\Resources\Pasals\Pages;

use App\Filament\Resources\Pasals\PasalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPasal extends EditRecord
{
    protected static string $resource = PasalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
