<?php

namespace App\Filament\Resources\Pasals;

use App\Filament\Resources\Pasals\Pages\CreatePasal;
use App\Filament\Resources\Pasals\Pages\EditPasal;
use App\Filament\Resources\Pasals\Pages\ListPasals;
use App\Filament\Resources\Pasals\Schemas\PasalForm;
use App\Filament\Resources\Pasals\Tables\PasalsTable;
use App\Models\Pasal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PasalResource extends Resource
{
    protected static ?string $model = Pasal::class;


    protected static ?string $navigationLabel = 'Pasal';


    protected static string|\UnitEnum|null $navigationGroup = 'Data Apresiasi & Pelanggaran';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_pasal';

    public static function form(Schema $schema): Schema
    {
        return PasalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PasalsTable::configure($table);
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
            'index' => ListPasals::route('/'),
            'create' => CreatePasal::route('/create'),
            'edit' => EditPasal::route('/{record}/edit'),
        ];
    }
}
