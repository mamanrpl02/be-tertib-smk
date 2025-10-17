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
                        $allSiswa = \App\Models\Siswa::with([
                            'kelasTingkat10',
                            'kelasTingkat11',
                            'kelasTingkat12',
                        ])
                            ->get()
                            ->mapWithKeys(function ($siswa) {
                                $kelas = $siswa->kelasTingkat12
                                    ?: ($siswa->kelasTingkat11
                                        ?: ($siswa->kelasTingkat10));

                                return [
                                    $siswa->id => "{$siswa->nama} - " . ($kelas?->nama_kelas ?? '-') . ""
                                ];
                            });

                        $selectedIds = $record
                            ? $record->siswa()->pluck('siswas.id')->toArray()
                            : [];

                        $filtered = $allSiswa->except($selectedIds);

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

                Select::make('kecuali_siswa_tingkat')
                    ->label('Kecuali Siswa di Tingkat Ini')
                    ->helperText('Semua siswa di tingkat ini akan mendapatkan apresiasi, kecuali siswa yang dipilih.')
                    ->multiple()
                    ->options(function ($get, $record) {
                        $tingkat = $get('tingkat') ?? $record?->tingkat;
                        if (!$tingkat) return [];

                        // Ambil siswa yang BENAR-BENAR aktif di tingkat tersebut
                        $students = match ($tingkat) {
                            '10' => Siswa::whereNotNull('tingkat_10')->whereNull('tingkat_11')->whereNull('tingkat_12')->get(),
                            '11' => Siswa::whereNotNull('tingkat_11')->whereNull('tingkat_12')->get(),
                            '12' => Siswa::whereNotNull('tingkat_12')->get(),
                            default => collect(),
                        };

                        // semua opsi diubah ke string key agar validasi aman
                        return $students->pluck('nama', 'id')
                            ->mapWithKeys(fn($label, $id) => [(string) $id => $label])
                            ->toArray();
                    })
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if (!$record) return;

                        // Ambil siswa yang dikecualikan
                        $selected = $record->siswa()
                            ->where('apresiasi_siswa.dikecualikan', true)
                            ->pluck('siswas.id')
                            ->map(fn($id) => (string) $id) // harus string agar match dengan options()
                            ->toArray();

                        $set('kecuali_siswa_tingkat', $selected);
                    })
                    ->getOptionLabelUsing(fn($value) => Siswa::find((int)$value)?->nama ?? "Siswa #$value")
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat')
                    ->reactive()
                    ->searchable()
                    ->preload(),

                Select::make('kelas_siswa_id')
                    ->label('Pilih Tingkat & Jurusan')
                    ->options(function () {
                        return \App\Models\KelasSiswa::all()
                            ->groupBy(fn($k) => "{$k->tingkat}-{$k->jurusan}") // grup berdasarkan tingkat & jurusan
                            ->mapWithKeys(function ($group) {
                                $first = $group->first();
                                return [
                                    $first->id => "{$first->tingkat} - {$first->jurusan}"
                                ];
                            })
                            ->sortKeys()
                            ->toArray();
                    })
                    ->visible(fn($get) => $get('tipe_apresiasi') === 'tingkat_jurusan') // ⬅️ pindah ke sini
                    ->searchable()
                    ->preload(),

                Select::make('kecuali_siswa_jurusan')
                    ->label('Kecuali Siswa dari Tingkat & Jurusan Ini')
                    ->helperText('Semua siswa di kelas ini akan mendapatkan apresiasi, kecuali siswa yang dipilih.')
                    ->multiple()
                    ->options(function ($get, $record) {
                        $kelasId = $get('kelas_siswa_id');
                        if (!$kelasId) return [];

                        $kelas = \App\Models\KelasSiswa::find($kelasId);
                        if (!$kelas) return [];

                        $tingkat = $kelas->tingkat;
                        $jurusan = $kelas->jurusan;

                        // 🔹 Ambil semua siswa aktif berdasarkan tingkat & jurusan
                        $query = \App\Models\Siswa::query();
                        if ($tingkat === '10') {
                            $query->whereHas('kelasTingkat10', fn($q) => $q->where('jurusan', $jurusan))
                                ->whereNull('tingkat_11')
                                ->whereNull('tingkat_12');
                        } elseif ($tingkat === '11') {
                            $query->whereHas('kelasTingkat11', fn($q) => $q->where('jurusan', $jurusan))
                                ->whereNull('tingkat_12');
                        } elseif ($tingkat === '12') {
                            $query->whereHas('kelasTingkat12', fn($q) => $q->where('jurusan', $jurusan));
                        }

                        $siswaAktif = $query->get();

                        // 🔹 Ambil siswa yang sudah dikecualikan di pivot
                        $siswaDikecualikan = [];
                        if ($record) {
                            $siswaDikecualikan = $record->siswa()
                                ->wherePivot('dikecualikan', true)
                                ->pluck('siswas.id')
                                ->toArray();
                        }

                        // 🔹 Opsi hanya berisi siswa yang BELUM dikecualikan
                        $options = $siswaAktif
                            ->reject(fn($s) => in_array($s->id, $siswaDikecualikan))
                            ->pluck('nama', 'id')
                            ->toArray();

                        // 🔹 Tambahkan lagi siswa yang tersellect agar tidak error validasi saat edit
                        if (!empty($siswaDikecualikan)) {
                            $selected = \App\Models\Siswa::whereIn('id', $siswaDikecualikan)
                                ->pluck('nama', 'id')
                                ->toArray();

                            // merge agar selected tetap muncul meski tidak tampil di opsi normal
                            $options = $selected + $options;
                        }

                        return $options;
                    })
                    ->afterStateHydrated(function ($set, $record) {
                        if (!$record) return;

                        // Set siswa yang dikecualikan otomatis terselct
                        $selected = $record->siswa()
                            ->wherePivot('dikecualikan', true)
                            ->pluck('siswas.id')
                            ->toArray();

                        $set('kecuali_siswa_jurusan', $selected);
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
