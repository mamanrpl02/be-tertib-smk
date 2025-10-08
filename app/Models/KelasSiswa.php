<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'tingkat',
        'jurusan_id',
        'wali_kelas',
        's_ganjil',
        's_genap',
    ];

    // Relasi ke jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke siswa di tiap tingkat
    public function siswas10()
    {
        return $this->hasMany(Siswa::class, 'tingkat_10');
    }

    public function siswas11()
    {
        return $this->hasMany(Siswa::class, 'tingkat_11');
    }

    public function siswas12()
    {
        return $this->hasMany(Siswa::class, 'tingkat_12');
    }

    // Nama kelas gabungan
    public function getNamaKelasAttribute(): string
    {
        return "{$this->tingkat} - {$this->jurusan->nama}";
    }


    public function waliKelas()
    {
        return $this->belongsTo(\App\Models\User::class, 'wali_kelas');
    }
}
