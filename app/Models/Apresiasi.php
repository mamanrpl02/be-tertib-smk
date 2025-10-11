<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apresiasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'siswa_ids',
        'tipe_apresiasi',
        'poin',
        'created_by',
        'updated_by',
        'fl_beranda',
        'deskripsi',
        'bukti_laporan',
        'tingkat',
        'kelas_siswa_id',
    ];

    protected $casts = [
        'siswa_ids' => 'array',
        'fl_beranda' => 'boolean',
    ];

    // 🔗 RELASI
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'apresiasi_siswa', 'apresiasi_id', 'siswa_id');
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // 🧠 Event otomatis saat create / update
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }

            self::generateSiswaIds($model);
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }

            self::generateSiswaIds($model);
        });
    }

    // 💡 Fungsi bantu untuk generate siswa_ids otomatis
    protected static function generateSiswaIds($model)
    {
        if ($model->tipe_apresiasi === 'tingkat' && $model->tingkat) {
            $model->siswa_ids = Siswa::whereHas('kelasSiswa', function ($q) use ($model) {
                $q->where('tingkat', $model->tingkat);
            })->pluck('id')->toArray();
        } elseif ($model->tipe_apresiasi === 'tingkat_jurusan' && $model->kelas_siswa_id) {
            $model->siswa_ids = Siswa::where('kelas_siswa_id', $model->kelas_siswa_id)
                ->pluck('id')->toArray();
        }

        // Jika tidak ada siswa yang cocok, tetap simpan array kosong
        $model->siswa_ids = $model->siswa_ids ?? [];
    }
}
