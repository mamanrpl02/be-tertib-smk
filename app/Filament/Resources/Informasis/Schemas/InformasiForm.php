<?php

namespace App\Filament\Resources\Informasis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class InformasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Judul Informasi')
                    ->required()
                    ->maxLength(255),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(5),

                FileUpload::make('foto_informasi')
                    ->label('Foto Informasi')
                    ->image()
                    ->directory('foto-informasi')
                    ->imageEditor()
                    ->nullable(),

                DatePicker::make('valid_to')
                    ->label('Berlaku Sampai')
                    ->minDate(now())
                    ->helperText('Informasi tidak akan tampil di beranda siswa setelah tanggal ini.')
                    ->nullable(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'publish' => 'Publish',
                    ])
                    ->default('publish')
                    ->required(),

                // Saat create: tampilkan user login
                TextInput::make('created_by_display')
                    ->label('Dibuat Oleh')
                    ->default(fn() => auth()->user()?->name)
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['create']),
                TextInput::make('created_by')
                    ->label('Dibuat Oleh')
                    ->formatStateUsing(fn($state, $record) => $record?->creator?->name ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                TextInput::make('updated_by')
                    ->label('Diperbarui Oleh')
                    ->formatStateUsing(fn($state, $record) => $record?->updater?->name ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

            ]);
    }
}
