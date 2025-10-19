<?php

namespace App\Filament\Resources\Informasis\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Informasis\InformasiResource;

class CreateInformasi extends CreateRecord
{
    protected static string $resource = InformasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        return $data;
    }
}
