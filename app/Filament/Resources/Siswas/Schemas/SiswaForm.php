<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\PasswordInput;
use App\Models\KelasSiswa;


class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),

                Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->label('Jenis Kelamin')
                    ->required(),
                FileUpload::make('foto_profile')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->directory('foto_siswa')
                    ->image()
                    ->maxSize(2048)
                    ->imageEditor()
                    ->imagePreviewHeight('150')
                    ->downloadable()
                    ->deleteUploadedFileUsing(function ($file) {
                        if ($file && Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    })
                    ->preserveFilenames(false) // biar nama file unik dan tidak bentrok
                    ->reorderable(false)
                    ->moveFiles(), // otomatis pindahkan kalau direplace

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->label('Password')
                    ->helperText('Kosongkan jika tidak ingin mengubah password.')
                    ->required(fn(string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state)), // hanya kirim kalau diisi


                Select::make('tingkat_10')
                    ->label('Kelas Tingkat 10')
                    ->options(
                        \App\Models\KelasSiswa::with('jurusan')
                            ->where('tingkat', '10')
                            ->get()
                            ->mapWithKeys(fn($kelas) => [
                                $kelas->id => "{$kelas->tingkat} - {$kelas->jurusan->nama_jurusan} {$kelas->jurusan->sub_kelas}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->nullable(),



                Select::make('tingkat_11')
                    ->label('Kelas Tingkat 11')
                    ->options(
                        \App\Models\KelasSiswa::with('jurusan')
                            ->where('tingkat', '11')
                            ->get()
                            ->mapWithKeys(fn($kelas) => [
                                $kelas->id => "{$kelas->tingkat} - {$kelas->jurusan->nama_jurusan} {$kelas->jurusan->sub_kelas}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Select::make('tingkat_12')
                    ->label('Kelas Tingkat 12')
                    ->options(
                        \App\Models\KelasSiswa::with('jurusan')
                            ->where('tingkat', '12')
                            ->get()
                            ->mapWithKeys(fn($kelas) => [
                                $kelas->id => "{$kelas->tingkat} - {$kelas->jurusan->nama_jurusan} {$kelas->jurusan->sub_kelas}"
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->nullable(),


            ]);
    }
}
