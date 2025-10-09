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
        'poin',
        'created_by',
        'updated_by',
        'fl_beranda',
        'deskripsi',
        'bukti_laporan',
    ];

    protected $casts = [
        'siswa_ids' => 'array',
        'fl_beranda' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

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

    // Tambahan opsional untuk bantu ambil nama siswa dari array ID
    public function getSiswaListAttribute()
    {
        return \App\Models\Siswa::whereIn('id', $this->siswa_ids)->pluck('nama')->toArray();
    }
}
