<?php

namespace App\Filament\Resources\LaporanPelanggarans\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class LaporanPelanggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->searchable(),

                TextColumn::make('pelanggaran.pelanggaran')
                    ->label('Jenis Pelanggaran'),

                IconColumn::make('fl_beranda')
                    ->boolean()
                    ->label('Tampil di Beranda'),

                IconColumn::make('fl_toleransi')
                    ->boolean()
                    ->label('Toleransi'),

                TextColumn::make('status_laporan')
                    ->label('Status Laporan')
                    ->badge()
                    ->colors([
                        'secondary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                TextColumn::make('approver.name')
                    ->label('Disetujui Oleh')
                    ->default('-'),

                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->default('-'),

                TextColumn::make('updater.name')
                    ->label('Diperbarui Oleh')
                    ->default('-'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat Pada'),

                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Diperbarui Pada'),
            ])
            ->filters([
                SelectFilter::make('status_laporan')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
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
