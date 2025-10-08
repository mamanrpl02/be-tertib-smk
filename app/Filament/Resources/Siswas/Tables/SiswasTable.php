<?php

namespace App\Filament\Resources\Siswas\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_profile')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                TextColumn::make('kelasSatu.nama_kelas')
                    ->label('Kelas 10')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kelasDua.nama_kelas')
                    ->label('Kelas 11')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kelasTiga.nama_kelas')
                    ->label('Kelas 12')
                    ->sortable()
                    ->searchable(),



            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
