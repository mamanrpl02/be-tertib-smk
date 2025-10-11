<?php

namespace App\Filament\Resources\Apresiasis\Schemas;

use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\KelasSiswa;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ApresiasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Judul Apresiasi')
                    ->required(),

                TextInput::make('poin')
                    ->numeric()
                    ->required(),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->required(),

                Radio::make('tipe_apresiasi')
                    ->label('Tambahkan Apresiasi Siswa Berdasarkan')
                    ->options([
                        'spesifik' => 'Siswa Spesifik',
                        'tingkat' => 'Semua Tingkat',
                        'tingkat_jurusan' => 'Tingkat & Jurusan',
                    ])
                    ->default('spesifik')
                    ->reactive(),

                // --- Siswa Spesifik ---
                Select::make('siswa')
                    ->label('Pilih Siswa')
                    ->multiple()
                    ->options(Siswa::pluck('nama', 'id'))
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'spesifik'),

                // --- Berdasarkan Tingkat ---
                Select::make('tingkat')
                    ->label('Pilih Tingkat')
                    ->options(['10' => '10', '11' => '11', '12' => '12'])
                    ->reactive()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat'),

                Select::make('siswa_tingkat')
                    ->label('Pilih Siswa di Tingkat Ini')
                    ->multiple()
                    ->options(function ($get) {
                        $tingkat = $get('tingkat');
                        if (!$tingkat) {
                            return [];
                        }

                        // Tentukan kolom foreign key berdasarkan tingkat
                        $kolom = match ($tingkat) {
                            '10' => 'tingkat_10',
                            '11' => 'tingkat_11',
                            '12' => 'tingkat_12',
                            default => null,
                        };

                        if (!$kolom) {
                            return [];
                        }

                        // Ambil siswa yang punya relasi kelas di kolom tersebut
                        return \App\Models\Siswa::whereNotNull($kolom)
                            ->whereHas('kelasTingkat' . $tingkat, function ($q) use ($tingkat) {
                                $q->where('tingkat', $tingkat);
                            })
                            ->pluck('nama', 'id');
                    })
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat')
                    ->searchable()
                    ->preload(),



                // --- Berdasarkan Tingkat & Jurusan ---
                Select::make('kelas_siswa_id')
                    ->label('Pilih Tingkat & Jurusan')
                    ->options(
                        KelasSiswa::with('jurusan')
                            ->get()
                            ->mapWithKeys(fn($kelas) => [
                                $kelas->id => "{$kelas->tingkat} - {$kelas->jurusan->nama_jurusan} {$kelas->jurusan->sub_kelas}"
                            ])->toArray()
                    )
                    ->reactive()
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat_jurusan'),



                Select::make('siswa_jurusan')
                    ->label('Pilih Siswa dari Tingkat & Jurusan Ini')
                    ->multiple()
                    ->options(function ($get) {
                        $kelasId = $get('kelas_siswa_id');
                        if (!$kelasId) return [];

                        // Cek di kolom mana kelas ini muncul
                        return \App\Models\Siswa::where(function ($q) use ($kelasId) {
                            $q->where('tingkat_10', $kelasId)
                                ->orWhere('tingkat_11', $kelasId)
                                ->orWhere('tingkat_12', $kelasId);
                        })->pluck('nama', 'id');
                    })
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat_jurusan')
                    ->searchable()
                    ->preload(),


                FileUpload::make('bukti_laporan')
                    ->label('Bukti Laporan')
                    ->directory('bukti_apresiasi')
                    ->image(),

                Toggle::make('fl_beranda')
                    ->label('Tampilkan di Beranda')
                    ->default(false),

            ]);
    }
}
