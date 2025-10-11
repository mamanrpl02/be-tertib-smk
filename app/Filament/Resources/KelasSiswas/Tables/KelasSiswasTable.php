<?php

namespace App\Filament\Resources\KelasSiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelasSiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tingkat'),
                TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->jurusan
                            ? "{$record->jurusan->nama_jurusan} ({$record->jurusan->sub_kelas})"
                            : '-';
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('waliKelas.name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('s_ganjil')
                    ->searchable(),
                TextColumn::make('s_genap')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
