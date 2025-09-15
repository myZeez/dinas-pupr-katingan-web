<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanHistory extends Model
{
    use HasFactory;

    protected $table = 'pengaduan_histories';

    protected $fillable = [
        'pengaduan_id',
        'status_from',
        'status_to',
        'action',
        'keterangan',
        'admin_name',
        'admin_email'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi ke pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Status dengan icon dan warna
    public function getStatusIconAttribute()
    {
        return match ($this->action) {
            'Dibuat' => 'fas fa-plus-circle text-primary',
            'Diubah' => 'fas fa-edit text-warning',
            'Selesai' => 'fas fa-check-circle text-success',
            'Ditolak' => 'fas fa-times-circle text-danger',
            'Diproses' => 'fas fa-clock text-info',
            default => 'fas fa-info-circle text-secondary'
        };
    }

    // Keterangan otomatis berdasarkan action
    public function getKeteranganDefaultAttribute()
    {
        return match ($this->action) {
            'Dibuat' => 'Pengaduan baru dibuat oleh masyarakat',
            'Diubah' => 'Status pengaduan diubah oleh admin',
            'Selesai' => 'Pengaduan telah diselesaikan',
            'Ditolak' => 'Pengaduan ditolak',
            'Diproses' => 'Pengaduan sedang diproses',
            default => 'Update status pengaduan'
        };
    }
}
