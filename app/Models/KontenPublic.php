<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KontenPublic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public_content_news'; // FIXED: Use existing table

    protected $fillable = [
        'key',
        'title',
        'content',
        'image',
        'link',
        'order',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Helper methods
    public static function getByKey($key)
    {
        return self::where('key', $key)->where('is_active', true)->orderBy('order')->get();
    }

    public static function getSingleByKey($key)
    {
        return self::where('key', $key)->where('is_active', true)->first();
    }
}
