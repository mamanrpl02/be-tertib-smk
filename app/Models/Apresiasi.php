<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apresiasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'poin',
        'tipe_apresiasi',
        'deskripsi',
        'bukti_laporan',
        'fl_beranda',
        'tingkat',
        'kelas_siswa_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fl_beranda' => 'boolean',
    ];

    // 🔗 RELASI

    public function likedBy()
    {
        return $this->belongsToMany(Siswa::class, 'apresiasi_siswa_likes')
            ->withTimestamps();
    }


    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'apresiasi_siswa');
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    // 🧠 Event otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }


    // 🧩 Fungsi untuk isi tabel pivot otomatis
    protected static function syncPivot($model)
    {
        $siswaIds = [];

        if ($model->tipe_apresiasi === 'tingkat' && $model->tingkat) {
            $siswaIds = Siswa::where(function ($q) use ($model) {
                $q->whereHas('kelasTingkat10', fn($q) => $q->where('tingkat', $model->tingkat))
                    ->orWhereHas('kelasTingkat11', fn($q) => $q->where('tingkat', $model->tingkat))
                    ->orWhereHas('kelasTingkat12', fn($q) => $q->where('tingkat', $model->tingkat));
            })->pluck('id')->toArray();
        } elseif ($model->tipe_apresiasi === 'tingkat_jurusan' && $model->kelas_siswa_id) {
            $siswaIds = Siswa::where(function ($q) use ($model) {
                $q->where('tingkat_10', $model->kelas_siswa_id)
                    ->orWhere('tingkat_11', $model->kelas_siswa_id)
                    ->orWhere('tingkat_12', $model->kelas_siswa_id);
            })->pluck('id')->toArray();
        }

        // Sync ke tabel pivot
        if (!empty($siswaIds)) {
            $model->siswa()->sync($siswaIds);
        }
    }
}
