<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'kategori',
        'tags',
        'thumbnail',
        'tanggal',
        'status',
        'author',
        'tanggal_publikasi',
        'featured',
        'views',
        'likes'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tanggal_publikasi' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    // Accessors
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            // Check if thumbnail path already includes storage path
            if (str_starts_with($this->thumbnail, 'thumbnails/')) {
                return asset('storage/' . $this->thumbnail);
            } elseif (str_starts_with($this->thumbnail, 'berita/')) {
                return asset('storage/' . $this->thumbnail);
            } else {
                // Default to thumbnails folder for backward compatibility
                return asset('storage/thumbnails/' . $this->thumbnail);
            }
        }
        return null;
    }
}
