<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasal',
        'judul',
        'deskripsi',
    ];

    public function pelanggarans()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
