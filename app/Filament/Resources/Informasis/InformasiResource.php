<?php

namespace App\Filament\Resources\Informasis;

use App\Filament\Resources\Informasis\Pages\CreateInformasi;
use App\Filament\Resources\Informasis\Pages\EditInformasi;
use App\Filament\Resources\Informasis\Pages\ListInformasis;
use App\Filament\Resources\Informasis\Schemas\InformasiForm;
use App\Filament\Resources\Informasis\Tables\InformasisTable;
use App\Models\Informasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;


class InformasiResource extends Resource
{
    protected static ?string $model = Informasi::class;

    protected static ?string $navigationLabel = 'Informasi';

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi & Pengumuman';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return InformasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InformasisTable::configure($table);
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
            'index' => ListInformasis::route('/'),
            'create' => CreateInformasi::route('/create'),
            'edit' => EditInformasi::route('/{record}/edit'),
        ];
    }
}
