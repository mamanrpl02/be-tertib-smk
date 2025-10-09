<?php

namespace App\Filament\Resources\Apresiasis;

use App\Filament\Resources\Apresiasis\Pages\CreateApresiasi;
use App\Filament\Resources\Apresiasis\Pages\EditApresiasi;
use App\Filament\Resources\Apresiasis\Pages\ListApresiasis;
use App\Filament\Resources\Apresiasis\Schemas\ApresiasiForm;
use App\Filament\Resources\Apresiasis\Tables\ApresiasisTable;
use App\Models\Apresiasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApresiasiResource extends Resource
{
    protected static ?string $model = Apresiasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return ApresiasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApresiasisTable::configure($table);
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
            'index' => ListApresiasis::route('/'),
            'create' => CreateApresiasi::route('/create'),
            'edit' => EditApresiasi::route('/{record}/edit'),
        ];
    }
}
