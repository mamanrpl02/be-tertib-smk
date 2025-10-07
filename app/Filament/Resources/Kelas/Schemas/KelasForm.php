<?php

namespace App\Filament\Resources\Kelas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tingkat')
                    ->required()
                    ->numeric(),
                TextInput::make('jurusan')
                    ->required(),
                TextInput::make('sub_kelas')
                    ->required(),
                Select::make('wali_kelas_id')
                    ->relationship('waliKelas', 'name'),
            ]);
    }
}
