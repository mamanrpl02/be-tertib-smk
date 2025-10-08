<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'desk'];

    public function kelasSiswas()
    {
        return $this->hasMany(KelasSiswa::class, 'jurusan_id');
    }
}
