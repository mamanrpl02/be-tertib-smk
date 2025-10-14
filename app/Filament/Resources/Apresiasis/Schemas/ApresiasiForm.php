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
                    ->label('Tambahkan Apresiasi Berdasarkan')
                    ->options([
                        'spesifik' => 'Siswa Spesifik',
                        'tingkat' => 'Semua Siswa di Tingkat',
                        'tingkat_jurusan' => 'Tingkat & Jurusan',
                    ])
                    ->default('spesifik')
                    ->reactive(),

                // --- Siswa Spesifik ---
                Select::make('siswa')
                    ->label('Pilih Siswa Spesifik')
                    ->multiple()
                    ->options(function ($get, $record) {
                        // Ambil semua siswa
                        $allSiswa = \App\Models\Siswa::pluck('nama', 'id');

                        // Ambil siswa yang sudah terpilih dari record (jika ada)
                        $selectedIds = $record
                            ? $record->siswa()->pluck('siswas.id')->toArray()
                            : [];

                        // Filter siswa agar tidak muncul 2x di daftar (kecuali yang sudah terpilih)
                        $filtered = \App\Models\Siswa::whereNotIn('id', $selectedIds)
                            ->pluck('nama', 'id');

                        // Gabungkan siswa yang sudah terpilih agar tetap bisa tampil label-nya saat edit
                        return $filtered->union($allSiswa->only($selectedIds));
                    })
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if (!$record) return;

                        // Ambil siswa yang sudah terkait di pivot
                        $selectedIds = $record->siswa()->pluck('siswas.id')->toArray();

                        // Set nilai select ke ID-ID tersebut
                        $set('siswa', $selectedIds);
                    })
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'spesifik'),



                // --- Berdasarkan Tingkat ---
                Select::make('tingkat')
                    ->label('Pilih Tingkat')
                    ->options(['10' => '10', '11' => '11', '12' => '12'])
                    ->reactive()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat'),

                // --- Berdasarkan Tingkat ---
                Select::make('kecuali_siswa_tingkat')
                    ->label('Kecuali Siswa di Tingkat Ini')
                    ->helperText('Semua siswa di tingkat ini akan mendapatkan apresiasi, kecuali siswa yang dipilih.')
                    ->multiple()
                    ->options(function ($get, $record) {
                        $tingkat = $get('tingkat');
                        if (!$tingkat) return [];

                        // Semua siswa di tingkat tersebut
                        $semuaSiswa = Siswa::all()->filter(function ($siswa) use ($tingkat) {
                            if ($siswa->tingkat_12) $aktif = '12';
                            elseif ($siswa->tingkat_11) $aktif = '11';
                            elseif ($siswa->tingkat_10) $aktif = '10';
                            else $aktif = null;

                            return $aktif === $tingkat;
                        });

                        // Ambil ID siswa yang sudah ada di pivot
                        $pivotIds = $record?->siswa()->pluck('siswas.id')->toArray() ?? [];

                        // Hanya tampilkan siswa yang belum dipilih
                        return $semuaSiswa->whereNotIn('id', $pivotIds)->pluck('nama', 'id')->toArray();
                    })
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if (!$record || !$record->tingkat) return;

                        // Siswa yang sudah dipilih sebelumnya
                        $pivotIds = $record->siswa()->pluck('siswas.id')->toArray();

                        $set('kecuali_siswa_tingkat', $pivotIds);
                    })
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat')
                    ->searchable()
                    ->preload(),

                // --- Berdasarkan Tingkat & Jurusan ---
                Select::make('kelas_siswa_id')
                    ->label('Pilih Tingkat & Jurusan')
                    ->options(function ($get, $record) {
                        $tingkat = $get('tingkat');
                        if (!$tingkat) return [];

                        $semuaKelas = KelasSiswa::all()->filter(function ($kelas) use ($tingkat) {
                            if ($kelas->tingkat_12) $aktif = '12';
                            elseif ($kelas->tingkat_11) $aktif = '11';
                            elseif ($kelas->tingkat_10) $aktif = '10';
                            else $aktif = null;

                            return $aktif === $tingkat;
                        });

                        // Tampilkan semua siswa di tingkat, termasuk yang sudah dipilih
                        return $semuaKelas->pluck('nama', 'id')->toArray();
                    })

                    ->reactive()
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat_jurusan'),

                // --- Berdasarkan Tingkat & Jurusan ---
                Select::make('kecuali_siswa_jurusan')
                    ->label('Kecuali Siswa dari Tingkat & Jurusan Ini')
                    ->helperText('Semua siswa di kelas ini akan mendapatkan apresiasi, kecuali siswa yang dipilih.')
                    ->multiple()
                    ->options(function ($get, $record) {
                        $kelasId = $get('kelas_siswa_id');
                        if (!$kelasId) return [];

                        $kelas = KelasSiswa::find($kelasId);
                        if (!$kelas) return [];

                        $tingkat = $kelas->tingkat;

                        $siswaAktif = Siswa::all()->filter(function ($siswa) use ($tingkat, $kelas) {
                            if ($siswa->tingkat_12) $aktif = '12';
                            elseif ($siswa->tingkat_11) $aktif = '11';
                            elseif ($siswa->tingkat_10) $aktif = '10';
                            else $aktif = null;

                            return match ($tingkat) {
                                '10' => $aktif === '10' && $siswa->tingkat_10 == $kelas->id,
                                '11' => $aktif === '11' && $siswa->tingkat_11 == $kelas->id,
                                '12' => $aktif === '12' && $siswa->tingkat_12 == $kelas->id,
                                default => false,
                            };
                        });

                        // Ambil ID siswa yang sudah ada di pivot
                        $pivotIds = $record?->siswa()->pluck('siswas.id')->toArray() ?? [];

                        // Hanya tampilkan siswa yang belum dipilih
                        return $siswaAktif->whereNotIn('id', $pivotIds)->pluck('nama', 'id')->toArray();
                    })
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if (!$record || !$record->kelas_siswa_id) return;

                        // Siswa yang sudah dipilih sebelumnya
                        $pivotIds = $record->siswa()->pluck('siswas.id')->toArray();

                        $set('kecuali_siswa_jurusan', $pivotIds);
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
