<?php

namespace App\Filament\Resources\Apresiasis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ApresiasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Judul Apresiasi')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Siswa Teladan Bulan Oktober'),

                Select::make('siswa_ids')
                    ->label('Siswa')
                    ->multiple()
                    ->options(\App\Models\Siswa::pluck('nama', 'id')->toArray())
                    ->searchable()
                    ->required(),

                TextInput::make('poin')
                    ->numeric()
                    ->label('Poin')
                    ->minValue(1)
                    ->maxValue(100)
                    ->required(),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->required()
                    ->placeholder('Tuliskan alasan atau keterangan apresiasi...'),

                FileUpload::make('bukti_laporan')
                    ->label('Bukti Laporan (Opsional)')
                    ->directory('bukti_apresiasi')
                    ->image()
                    ->maxSize(2048),

                Toggle::make('fl_beranda')
                    ->label('Tampilkan di Beranda')
                    ->default(false),
            ]);
    }
}
