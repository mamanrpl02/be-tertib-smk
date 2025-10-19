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


                TextInput::make('created_by')
                    ->label('Dibuat Oleh')
                    ->formatStateUsing(fn($record) => $record?->creator?->name ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                TextInput::make('created_at')
                    ->label('Dibuat Pada')
                    ->formatStateUsing(fn($record) => $record?->created_at?->format('d M Y H:i') ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                TextInput::make('updated_by')
                    ->label('Diperbarui Oleh')
                    ->formatStateUsing(fn($record) => $record?->updater?->name ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                TextInput::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->formatStateUsing(fn($record) => $record?->updated_at?->format('d M Y H:i') ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),


                Hidden::make('created_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),

                Hidden::make('updated_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),

            ]);
    }
}
