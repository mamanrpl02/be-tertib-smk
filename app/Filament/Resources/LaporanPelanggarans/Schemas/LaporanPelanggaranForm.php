<?php

namespace App\Filament\Resources\LaporanPelanggarans\Schemas;

use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Models\Pelanggaran;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class LaporanPelanggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // --- Pilihan tipe laporan ---
                Select::make('tipe_laporan')
                    ->label('Laporkan Berdasarkan')
                    ->options([
                        'spesifik' => 'Siswa Spesifik',
                        'tingkat' => 'Semua Siswa di Tingkat',
                        'tingkat_jurusan' => 'Tingkat & Jurusan',
                    ])
                    ->default('spesifik')
                    ->required()
                    ->reactive(),

                // --- Jenis pelanggaran ---
                Select::make('pelanggaran_id')
                    ->label('Jenis Pelanggaran')
                    ->options(Pelanggaran::pluck('pelanggaran', 'id'))
                    ->searchable()
                    ->required(),


                // --- Pilihan siswa spesifik ---
                Select::make('siswa_id')
                    ->label('Pilih Siswa Spesifik')
                    ->multiple()
                    ->required()
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
                                    $siswa->id => "{$siswa->nama} - " . ($kelas?->nama_kelas ?? '-')
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
                        $selectedIds = $record->siswa()->pluck('siswas.id')->toArray();
                        $set('siswa_id', $selectedIds);
                    })
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => $get('tipe_laporan') === 'spesifik'),

                // --- Berdasarkan Tingkat ---
                Select::make('tingkat')
                    ->label('Pilih Tingkat')
                    ->options(['10' => '10', '11' => '11', '12' => '12'])
                    ->reactive()
                    ->visible(fn($get) => $get('tipe_laporan') === 'tingkat'),

                // --- Berdasarkan Tingkat & Jurusan ---
                Select::make('kelas_siswa_id')
                    ->label('Pilih Tingkat & Jurusan')
                    ->options(function () {
                        return \App\Models\KelasSiswa::query()
                            ->select('id', 'tingkat', 'jurusan')
                            ->get()
                            ->mapWithKeys(fn($k) => [
                                $k->id => "{$k->tingkat} - {$k->jurusan}"
                            ])
                            ->toArray();
                    })
                    ->visible(fn($get) => $get('tipe_laporan') === 'tingkat_jurusan')
                    ->searchable()
                    ->preload(),

                FileUpload::make('bukti_pelanggaran')
                    ->label('Bukti Pelanggaran')
                    ->directory('bukti-pelanggaran')
                    ->image()
                    ->required()
                    ->maxSize(5120) // 5MB
                    ->helperText('Maksimal ukuran file 5MB. Format: jpg, png, pdf, dll.')
                    ->nullable(),


                Textarea::make('deskripsi')
                    ->label('Deskripsi Pelanggaran')
                    ->rows(4),

                // --- Opsi approval ---
                Select::make('approval_action')
                    ->label('Tindakan')
                    ->options([
                        'approved' => 'Setujui Laporan',
                        'rejected' => 'Tolak Laporan',
                    ])
                    ->placeholder('Pilih tindakan...')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state === 'approved') {
                            $set('status_laporan', 'approved');
                            $set('approved_by', auth()->id());
                        } elseif ($state === 'rejected') {
                            $set('status_laporan', 'rejected');
                            $set('approved_by', auth()->id());
                        } else {
                            $set('status_laporan', 'pending');
                            $set('approved_by', null);
                        }
                    })
                    ->visibleOn(['edit', 'view']),

                // --- Status laporan ---
                Select::make('status_laporan')
                    ->label('Status Laporan')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->disabled(),

                // --- Tampilkan di beranda & toleransi ---
                Toggle::make('fl_beranda')
                    ->label('Tampilkan di Beranda')
                    ->default(false),

                Toggle::make('fl_toleransi')
                    ->label('Toleransi')
                    ->default(false),

                // --- Disetujui / Ditolak oleh ---
                TextInput::make('approved_by')
                    ->label(fn($record) => match ($record?->status_laporan) {
                        'approved' => 'Disetujui Oleh',
                        'rejected' => 'Ditolak Oleh',
                        default => 'Disetujui / Ditolak Oleh',
                    })
                    ->formatStateUsing(fn($record) => $record?->approver?->name ?? '-')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                // --- Dibuat oleh ---
                TextInput::make('created_by_display')
                    ->label('Dibuat Oleh')
                    ->formatStateUsing(function ($record) {
                        if (! $record) return '-';
                        if ($record->creator_user) {
                            return $record->creator_user->name;
                        } elseif ($record->creator_siswa) {
                            return $record->creator_siswa->nama;
                        }
                        return '-';
                    })
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                // --- Dibuat & Diperbarui pada ---
                TextInput::make('created_at')
                    ->label('Dibuat Pada')
                    ->formatStateUsing(fn($record) => $record?->created_at?->format('d M Y H:i'))
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                TextInput::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->formatStateUsing(fn($record) => $record?->updated_at?->format('d M Y H:i'))
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn(['edit', 'view']),

                Hidden::make('created_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),

                Hidden::make('updated_by')
                    ->default(auth()->id())
                    ->dehydrated(fn($state) => filled($state)),
            ]);
    }
}
