<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaduan extends Model
{
    use HasFactory, SoftDeletes;  // FIXED: MySQL table HAS deleted_at column

    protected $table = 'pengaduan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',  // FIXED: Database uses 'subjek' not 'kategori'
        'pesan',
        'status',
        'tanggal_pengaduan',
        'nomor_tiket'  // Add nomor_tiket to fillable
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'Baru');
    }

    public function scopeDigerDoses($query)
    {
        return $query->where('status', 'Diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'Selesai');
    }

    // Generate nomor tiket otomatis
    public static function generateNomorTiket()
    {
        $date = now();
        $prefix = 'TKT';
        $dateFormat = $date->format('Ymd');

        // Hitung jumlah pengaduan hari ini untuk sequence
        $todayCount = static::whereDate('created_at', $date->toDateString())->count();
        $sequence = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

        return "{$prefix}-{$dateFormat}-{$sequence}";
    }

    // Boot method untuk auto generate nomor tiket
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengaduan) {
            if (empty($pengaduan->nomor_tiket)) {
                $pengaduan->nomor_tiket = static::generateNomorTiket();
            }
        });
    }

    // Relasi dengan history
    public function histories()
    {
        return $this->hasMany(PengaduanHistory::class)->orderBy('created_at', 'desc');
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Baru' => 'bg-primary',
            'Diproses' => 'bg-warning',
            'Selesai' => 'bg-success',
            'Ditolak' => 'bg-danger'
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }

    // Accessor untuk format tanggal
    public function getTanggalPengaduanFormatAttribute()
    {
        return $this->tanggal_pengaduan ? $this->tanggal_pengaduan->format('d/m/Y H:i') : '-';
    }
}
