<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileDownload extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_file',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'kategori',
        'status',
        'download_count',
        'urutan',
        'user_id'
    ];

    protected $casts = [
        'status' => 'string',
        'kategori' => 'string',
        'download_count' => 'integer',
        'urutan' => 'integer'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Methods
    public function incrementDownload()
    {
        $this->increment('download_count');
    }

    public function getKategoriLabelAttribute()
    {
        $labels = [
            'dokumen' => 'Dokumen',
            'formulir' => 'Formulir',
            'peraturan' => 'Peraturan',
            'panduan' => 'Panduan',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->kategori] ?? 'Unknown';
    }
}
