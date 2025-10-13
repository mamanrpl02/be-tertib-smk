<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_jurusan', 'sub_kelas'];

    public function kelasSiswas()
    {
        return $this->hasMany(KelasSiswa::class, 'jurusan_id');
    }
    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }
}
