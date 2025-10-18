<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'ayat',
        'pelanggaran',
        'poin',
        'created_by',
        'updated_by',
    ];

    // 🔗 Relasi ke User (pembuat & pengedit)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // 🔗 Relasi ke LaporanPelanggaran (1 pelanggaran bisa punya banyak laporan)
    public function laporanPelanggarans()
    {
        return $this->hasMany(LaporanPelanggaran::class, 'pelanggaran_id');
    }
}
