<?php

namespace App\Filament\Resources\Pelanggarans;

use App\Filament\Resources\Pelanggarans\Pages\CreatePelanggaran;
use App\Filament\Resources\Pelanggarans\Pages\EditPelanggaran;
use App\Filament\Resources\Pelanggarans\Pages\ListPelanggarans;
use App\Filament\Resources\Pelanggarans\Schemas\PelanggaranForm;
use App\Filament\Resources\Pelanggarans\Tables\PelanggaransTable;
use App\Models\Pelanggaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PelanggaranResource extends Resource
{
    protected static ?string $model = Pelanggaran::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Data Apresiasi & Pelanggaran';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNoSymbol;

    protected static ?string $recordTitleAttribute = 'pelanggaran';

    public static function form(Schema $schema): Schema
    {
        return PelanggaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PelanggaransTable::configure($table);
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
            'index' => ListPelanggarans::route('/'),
            'create' => CreatePelanggaran::route('/create'),
            'edit' => EditPelanggaran::route('/{record}/edit'),
        ];
    }
}
