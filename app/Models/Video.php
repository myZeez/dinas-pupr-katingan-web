<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'youtube_id',
        'video_file',
        'thumbnail',
        'category',
        'is_active',
        'views',
        'user_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHero($query)
    {
        return $query->where('category', 'hero');
    }

    public function scopeKonten($query)
    {
        return $query->where('category', 'konten');
    }

    // Mutators
    public function setYoutubeUrlAttribute($value)
    {
        $this->attributes['youtube_url'] = $value;

        if ($value) {
            $this->attributes['youtube_id'] = $this->extractYouTubeId($value);
        }
    }

    // Accessors
    public function getVideoUrlAttribute()
    {
        if ($this->youtube_url) {
            return $this->youtube_url;
        }

        return $this->video_file ? asset('storage/' . $this->video_file) : null;
    }

    public function getEmbedUrlAttribute()
    {
        if ($this->youtube_url) {
            $youtubeId = $this->youtube_id ?: self::extractYouTubeId($this->youtube_url);
            return $youtubeId ? 'https://www.youtube.com/embed/' . $youtubeId : null;
        }

        return null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        if ($this->youtube_url) {
            $youtubeId = $this->youtube_id ?: self::extractYouTubeId($this->youtube_url);
            return $youtubeId ? 'https://img.youtube.com/vi/' . $youtubeId . '/maxresdefault.jpg' : null;
        }

        return asset('img/video-placeholder.jpg');
    }

    public function getIsYouTubeAttribute()
    {
        return !empty($this->youtube_url);
    }

    public function getIsUploadAttribute()
    {
        return !empty($this->video_file) && empty($this->youtube_url);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public static function extractYouTubeId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
