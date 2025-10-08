<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

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
}
