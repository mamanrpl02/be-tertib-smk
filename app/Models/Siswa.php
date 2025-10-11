<?php

namespace App\Models;

use delete;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'jenis_kelamin',
        'foto_profile',
        'tingkat_10',
        'tingkat_11',
        'tingkat_12',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function apresiasis()
    {
        return $this->belongsToMany(Apresiasi::class, 'apresiasi_siswa');
    }


    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kelas_siswa_id');
    }




    public function kelasSatu()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_10');
    }

    public function kelasDua()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_11');
    }

    public function kelasTiga()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_12');
    }
    public function kelas()
    {
        return $this->belongsTo(\App\Models\KelasSiswa::class, 'kelas_id');
    }


    // app/Models/Siswa.php
    public function kelasTingkat10()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_10');
    }

    public function kelasTingkat11()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_11');
    }

    public function kelasTingkat12()
    {
        return $this->belongsTo(KelasSiswa::class, 'tingkat_12');
    }

    // Di model Siswa.php
    protected static function booted()
    {
        static::updating(function ($siswa) {
            if ($siswa->isDirty('foto_profile')) {
                $old = $siswa->getOriginal('foto_profile');
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
        });

        static::deleting(function ($siswa) {
            if ($siswa->foto_profile && Storage::disk('public')->exists($siswa->foto_profile)) {
                Storage::disk('public')->delete($siswa->foto_profile);
            }
        });
    }
}
