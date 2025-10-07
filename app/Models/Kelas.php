<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $fillable = [
        'tingkat',
        'jurusan',
        'sub_kelas',
        'wali_kelas_id',
    ];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'kelas_id');
    }


    public function getNamaKelasAttribute(): string
    {
        return "{$this->tingkat} {$this->jurusan} {$this->sub_kelas}";
    }
}
