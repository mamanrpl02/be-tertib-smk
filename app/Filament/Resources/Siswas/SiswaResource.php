<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class SiswaResource extends Resource
{
    protected static ?string $model = \App\Models\Siswa::class;

    protected static ?string $navigationLabel = 'Siswa';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Data Siswa';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Siswas\Schemas\SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\Siswas\Tables\SiswasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Siswas\Pages\ListSiswas::route('/'),
            'create' => \App\Filament\Resources\Siswas\Pages\CreateSiswa::route('/create'),
            'edit' => \App\Filament\Resources\Siswas\Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
