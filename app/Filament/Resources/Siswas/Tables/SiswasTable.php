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
                    ->disk('public') // <- ini penting
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

                TextColumn::make('kelasTingkat10.jurusan.nama_jurusan')
                    ->label('Kelas 10')
                    ->formatStateUsing(
                        fn($record) =>
                        optional($record->kelasTingkat10?->jurusan)
                            ? "{$record->kelasTingkat10->tingkat} - {$record->kelasTingkat10->jurusan->nama_jurusan} {$record->kelasTingkat10->jurusan->sub_kelas}"
                            : '-'
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kelasTingkat11.jurusan.nama_jurusan')
                    ->label('Kelas 11')
                    ->formatStateUsing(
                        fn($record) =>
                        optional($record->kelasTingkat11?->jurusan)
                            ? "{$record->kelasTingkat11->tingkat} - {$record->kelasTingkat11->jurusan->nama_jurusan} {$record->kelasTingkat11->jurusan->sub_kelas}"
                            : '-'
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kelasTingkat12.jurusan.nama_jurusan')
                    ->label('Kelas 12')
                    ->formatStateUsing(
                        fn($record) =>
                        optional($record->kelasTingkat12?->jurusan)
                            ? "{$record->kelasTingkat12->tingkat} - {$record->kelasTingkat12->jurusan->nama_jurusan} {$record->kelasTingkat12->jurusan->sub_kelas}"
                            : '-'
                    )
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
