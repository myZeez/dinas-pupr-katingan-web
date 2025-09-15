<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Ulasan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ulasan';

    protected $fillable = [
        'nama',
        'email',
        'instansi',
        'rating',
        'ulasan',
        'kategori',
        'rating_detail',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'rating_detail' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Get star display (Bootstrap Icons version)
    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="bi bi-star-fill"></i>';
            } else {
                $stars .= '<i class="bi bi-star"></i>';
            }
        }
        return $stars;
    }

    // Get rating score
    public function getRatingScoreAttribute()
    {
        return $this->rating;
    }

    // Get star display
    public function getStarDisplayAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    // Get rating color
    public function getRatingColorAttribute()
    {
        if ($this->rating >= 4) return 'text-success';
        if ($this->rating >= 3) return 'text-warning';
        return 'text-danger';
    }

    // Get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y') : '-';
    }

    // Get short ulasan for preview
    public function getShortUlasanAttribute()
    {
        return strlen($this->ulasan) > 150 ? substr($this->ulasan, 0, 150) . '...' : $this->ulasan;
    }

    // Get detailed ratings display
    public function getDetailedRatingsAttribute()
    {
        if (!$this->rating_detail || !is_array($this->rating_detail)) {
            return null;
        }

        $labels = [
            'pelayanan' => 'Pelayanan',
            'kecepatan' => 'Kecepatan',
            'kualitas' => 'Kualitas',
            'komunikasi' => 'Komunikasi'
        ];

        $result = [];
        foreach ($this->rating_detail as $key => $value) {
            if (isset($labels[$key])) {
                $result[] = [
                    'label' => $labels[$key],
                    'rating' => $value,
                    'stars' => $this->generateStars($value)
                ];
            }
        }

        return $result;
    }

    // Generate stars for rating
    private function generateStars($rating)
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    // Get average detailed rating
    public function getAverageDetailedRatingAttribute()
    {
        if (!$this->rating_detail || !is_array($this->rating_detail)) {
            return null;
        }

        $total = array_sum($this->rating_detail);
        $count = count($this->rating_detail);

        return $count > 0 ? round($total / $count, 1) : null;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeHighRated($query)
    {
        return $query->where('rating', '>=', 4);
    }

    // Boot method for default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->is_featured === null) {
                $model->is_featured = false;
            }
            if ($model->is_published === null) {
                $model->is_published = false;
            }
        });
    }
}
