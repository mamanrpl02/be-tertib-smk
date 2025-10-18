<?php

namespace App\Filament\Resources\Informasis\Pages;

use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Informasis\InformasiResource;

class EditInformasi extends EditRecord
{
    protected static string $resource = InformasiResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = Auth::id();
        return $data;
    }
    
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
