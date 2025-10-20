<?php

namespace App\Filament\Resources\Pasals\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PasalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_pasal')
                    ->label('Nama Pasal')
                    ->placeholder('Contoh: Pasal 1')
                    ->required()
                    ->maxLength(100),

                TextInput::make('judul')
                    ->label('Judul Pasal')
                    ->placeholder('Contoh: KETERLAMBATAN')
                    ->required()
                    ->maxLength(255),

                Textarea::make('deskripsi')
                    ->label('Deskripsi (opsional)')
                    ->rows(3)
                    ->placeholder('Tuliskan penjelasan tambahan tentang pasal ini...'),

            ]);
    }
}
