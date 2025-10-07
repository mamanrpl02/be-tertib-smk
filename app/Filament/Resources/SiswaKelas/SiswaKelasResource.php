<?php

namespace App\Filament\Resources\SiswaKelas;

use App\Filament\Resources\SiswaKelas\Pages\CreateSiswaKelas;
use App\Filament\Resources\SiswaKelas\Pages\EditSiswaKelas;
use App\Filament\Resources\SiswaKelas\Pages\ListSiswaKelas;
use App\Filament\Resources\SiswaKelas\Schemas\SiswaKelasForm;
use App\Filament\Resources\SiswaKelas\Tables\SiswaKelasTable;
use App\Models\SiswaKelas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SiswaKelasResource extends Resource
{
    protected static ?string $model = SiswaKelas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = '$table->unsignedBigInteger(\'siswa_id\');';

    public static function form(Schema $schema): Schema
    {
        return SiswaKelasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswaKelasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiswaKelas::route('/'),
            'create' => CreateSiswaKelas::route('/create'),
            'edit' => EditSiswaKelas::route('/{record}/edit'),
        ];
    }
}
