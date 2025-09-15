<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicContentNew extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public_content_news';

    protected $fillable = [
        'tipe',
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'youtube_url',
        'youtube_id',
        'urutan',
        'status',
        'user_id'
    ];

    protected $casts = [
        'status' => 'string',
        'urutan' => 'integer',
        'file_size' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeKarousel($query)
    {
        return $query->where('tipe', 'karousel');
    }

    public function scopeVideo($query)
    {
        return $query->where('tipe', 'video');
    }

    public function scopeMitra($query)
    {
        return $query->where('tipe', 'mitra');
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getUrlAttribute()
    {
        return $this->youtube_url ?: $this->file_url;
    }

    public function getMediaUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getMediaAttribute()
    {
        return $this->file_path;
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getIsImageAttribute()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $imageExtensions);
    }

    public function getIsVideoAttribute()
    {
        $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'flv'];
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $videoExtensions);
    }

    // Static methods
    public static function getKarousels()
    {
        return self::aktif()->karousel()->orderBy('urutan')->get();
    }

    public static function getVideos()
    {
        return self::aktif()->video()->orderBy('created_at', 'desc')->get();
    }

    public static function getMitras()
    {
        return self::aktif()->mitra()->orderBy('urutan')->get();
    }
}
