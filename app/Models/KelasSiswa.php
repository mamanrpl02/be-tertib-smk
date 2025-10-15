<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'tingkat',
        'jurusan',
        'sub_kelas',
        'wali_kelas',
        's_ganjil',
        's_genap',
    ];



    // 🔗 Relasi ke jurusan


    // 🔗 Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_siswa_id');
    }

    // 🔗 Relasi wali kelas (User)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas');
    }

    // 🧩 Accessor nama kelas
    public function getNamaKelasAttribute(): string
    {
        $jurusanNama = $this->jurusan ? $this->jurusan->nama_jurusan : 'Tanpa Jurusan';
        return "{$this->tingkat} - {$jurusanNama}";
    }
}
