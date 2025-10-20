<?php

namespace App\Filament\Resources\Pelanggarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelanggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pasal.nama_pasal')
                    ->label('Pasal')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->pasal
                            ? "{$record->pasal->nama_pasal} - {$record->pasal->judul}"
                            : '-'
                    )
                    ->sortable()
                    ->searchable(),

                TextColumn::make('ayat')->sortable(),
                TextColumn::make('pelanggaran')->searchable(),
                TextColumn::make('poin')->sortable(),
                TextColumn::make('creator.name')->label('Dibuat Oleh')->default('-'),

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
