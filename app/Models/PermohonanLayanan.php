<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PermohonanLayanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permohonan_layanan';

    protected $fillable = [
        // Data Pemohon
        'nomor_permohonan',
        'nama_pemohon',
        'nik',
        'email',
        'telepon',
        'alamat',

        // Data Permohonan
        'jenis_layanan',
        'jenis_layanan_code',
        'deskripsi',
        'keperluan', // Backward compatibility

        // File & Dokumen
        'dokumen_persyaratan',
        'file_hasil',

        // Status & Admin
        'status',
        'tanggal_permohonan',
        'tanggal_selesai',
        'catatan_admin',
        'admin_id',

        // Metadata
        'ip_address',
        'user_agent',

        // Legacy fields for backward compatibility
        'alamat_project',
        'catatan',
        'data_tambahan'
    ];

    protected $casts = [
        'dokumen_persyaratan' => 'array',
        'data_tambahan' => 'array',
        'tanggal_permohonan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Status badge styling
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Diajukan' => 'bg-info text-white',
            'Verifikasi' => 'bg-warning text-dark',
            'Diproses' => 'bg-primary text-white',
            'Selesai' => 'bg-success text-white',
            'Ditolak' => 'bg-danger text-white'
        ];

        return $badges[$this->status] ?? 'bg-secondary text-white';
    }

    // Status progress percentage
    public function getProgressPercentageAttribute()
    {
        $progress = [
            'Diajukan' => 20,
            'Verifikasi' => 40,
            'Diproses' => 60,
            'Selesai' => 100,
            'Ditolak' => 0
        ];

        return $progress[$this->status] ?? 0;
    }

    // Get formatted creation date
    public function getFormattedDateAttribute()
    {
        return $this->tanggal_permohonan ? $this->tanggal_permohonan->format('d M Y H:i') : '-';
    }

    // Get formatted completion date
    public function getFormattedCompletionDateAttribute()
    {
        return $this->tanggal_selesai ? $this->tanggal_selesai->format('d M Y H:i') : '-';
    }

    // Check if has supporting documents
    public function getHasSupportingDocsAttribute()
    {
        return !empty($this->dokumen_persyaratan) && is_array($this->dokumen_persyaratan);
    }

    // Check if has result files
    public function getHasResultFilesAttribute()
    {
        return !empty($this->file_hasil) && is_string($this->file_hasil);
    }

    // Get file count
    public function getSupportingDocsCountAttribute()
    {
        return $this->has_supporting_docs ? count($this->dokumen_persyaratan) : 0;
    }

    public function getResultFilesCountAttribute()
    {
        return $this->has_result_files ? 1 : 0;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByJenisLayanan($query, $jenis)
    {
        return $query->where('jenis_layanan', $jenis);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Selesai');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['Diajukan', 'Verifikasi', 'Diproses']);
    }

    // Boot method for default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->status)) {
                $model->status = 'Diajukan';
            }
        });

        static::updating(function ($model) {
            // Auto set completion date when status changes to Selesai
            if ($model->isDirty('status') && $model->status === 'Selesai' && !$model->tanggal_selesai) {
                $model->tanggal_selesai = Carbon::now();
            }
        });
    }
}
