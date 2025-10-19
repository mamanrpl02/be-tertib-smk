<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggaran_id',
        'fl_beranda',
        'fl_toleransi',
        'deskripsi',
        'tipe_laporan',
        'tingkat',
        'kelas_siswa_id',
        'bukti_pelanggaran',
        'status_laporan',
        'approved_by',
        'created_by',
        'updated_by',
    ];

    // 🔗 Relasi ke Siswa (pelaku)
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'laporan_pelanggaran_siswa')
            ->withTimestamps();
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class);
    }

    // 🔗 Relasi ke Pelanggaran (jenis pelanggaran)
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    // 🔗 Relasi ke User (yang menyetujui laporan)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // 🔗 Relasi ke User (jika dibuat oleh user)
    public function creator_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function creator_siswa()
    {
        return $this->belongsTo(Siswa::class, 'created_by');
    }

    // 🔗 Relasi ke User yang mengupdate
    public function updaterUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // 🔗 Relasi ke Siswa yang mengupdate (opsional)
    public function updaterSiswa()
    {
        return $this->belongsTo(Siswa::class, 'updated_by');
    }

    /**
     * Getter dinamis: otomatis deteksi apakah dibuat oleh user atau siswa
     */
    public function getCreatorAttribute()
    {
        return $this->creatorUser ?? $this->creatorSiswa;
    }

    public function getUpdaterAttribute()
    {
        return $this->updaterUser ?? $this->updaterSiswa;
    }
}
