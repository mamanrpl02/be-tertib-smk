<?php

namespace App\Filament\Resources\Pelanggarans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;

class PelanggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ayat')
                    ->numeric()
                    ->label('Ayat'),

                TextInput::make('pelanggaran')
                    ->required()
                    ->label('Deskripsi Pelanggaran'),

                TextInput::make('poin')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->label('Poin'),

                Hidden::make('created_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),

                Hidden::make('updated_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),

            ]);
    }
}
