<?php

namespace App\Filament\Resources\SiswaKelas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class SiswaKelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('siswa_id')
                ->label('Nama Siswa')
                ->relationship('siswa', 'nama') // ← ambil nama dari relasi siswa
                ->searchable()
                ->required(),

            Select::make('kelas_id')
                ->label('Kelas')
                ->relationship('kelas', 'id')
                ->getOptionLabelFromRecordUsing(fn($record) => $record->nama_kelas) // pakai accessor dari model Kelas
                ->searchable()
                ->required(),

            TextInput::make('tahun_ajaran')
                ->label('Tahun Ajaran')
                ->required(),

            Toggle::make('aktif')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}
