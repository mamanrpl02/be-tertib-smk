<?php

namespace App\Filament\Resources\KelasSiswas\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class KelasSiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tingkat')
                    ->options(['10' => '10', '11' => '11', '12' => '12'])
                    ->required(),
                Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama') // relasi ke model Jurusan
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('wali_kelas')
                    ->label('Wali Kelas')
                    ->options(
                        User::where('role', 'guru') // atau sesuaikan dengan role yang kamu pakai
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('s_ganjil')
                    ->label('Semester Ganjil')
                    ->options(
                        collect(range(now()->year - 5, now()->year + 8))
                            ->mapWithKeys(fn($y) => [$y => $y])
                    )
                    ->searchable()
                    ->required(),

                Select::make('s_genap')
                    ->label('Semester Genap')
                    ->options(
                        collect(range(now()->year - 5, now()->year + 8))
                            ->mapWithKeys(fn($y) => [$y => $y])
                    )
                    ->searchable()
                    ->required(),

            ]);
    }
}
