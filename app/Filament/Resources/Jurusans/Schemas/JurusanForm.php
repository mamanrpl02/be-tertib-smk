<?php

namespace App\Filament\Resources\Jurusans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JurusanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                Textarea::make('desk')
                    ->columnSpanFull(),
            ]);
    }
}
