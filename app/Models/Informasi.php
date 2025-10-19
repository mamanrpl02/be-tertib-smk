<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'status',
        'foto_informasi',
        'valid_to',
        'created_by',
        'updated_by',
    ];

    // ==========================
    // 🔗 RELASI
    // ==========================

    // Pembuat informasi (user admin/guru)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    // Siswa yang memberikan like ke informasi ini
    public function likedBy()
    {
        return $this->belongsToMany(Siswa::class, 'informasi_siswa_likes')
            ->withTimestamps();
    }

    // ==========================
    // ⚙️ SCOPE DAN HELPER
    // ==========================

    /**
     * Scope: hanya informasi yang masih berlaku
     * (valid_to kosong atau lebih dari hari ini)
     */
    public function scopeMasihBerlaku($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('valid_to')
                ->orWhere('valid_to', '>', now());
        });
    }

    /**
     * Hitung total like
     */
    public function getTotalLikesAttribute()
    {
        return $this->likedBy()->count();
    }

    /**
     * Cek apakah informasi sudah di-like oleh siswa tertentu
     */
    public function isLikedBy($siswa)
    {
        return $this->likedBy()->where('siswa_id', $siswa->id)->exists();
    }
}
