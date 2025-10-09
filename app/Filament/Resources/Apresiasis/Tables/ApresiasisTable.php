<?php

namespace App\Filament\Resources\Apresiasis\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;

class ApresiasisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Judul')->searchable()->sortable(),
          TextColumn::make('siswa_ids')
    ->label('Siswa')
    ->formatStateUsing(function ($state) {
        // Pastikan selalu dalam bentuk array
        if (is_null($state)) {
            $ids = [];
        } elseif (is_string($state)) {
            $decoded = json_decode($state, true);
            $ids = is_array($decoded) ? $decoded : [$state];
        } elseif (is_int($state)) {
            $ids = [$state];
        } elseif (is_array($state)) {
            $ids = $state;
        } else {
            $ids = [];
        }

        // Kalau kosong, tampilkan tanda '-'
        if (empty($ids)) {
            return '-';
        }

        // Ambil nama siswa berdasarkan ID
        return \App\Models\Siswa::whereIn('id', $ids)
            ->pluck('nama')
            ->join(', ');
    })
    ->wrap(),




                BadgeColumn::make('poin')
                    ->label('Poin')
                    ->color(fn($state) => $state >= 80 ? 'success' : ($state >= 50 ? 'warning' : 'danger')),
                ToggleColumn::make('fl_beranda')
                    ->label('Beranda')
                    ->sortable(),
                TextColumn::make('creator.name')->label('Dibuat Oleh')->default('-'),
                TextColumn::make('created_at')->label('Tanggal Dibuat')->dateTime('d M Y H:i')->sortable(),
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
