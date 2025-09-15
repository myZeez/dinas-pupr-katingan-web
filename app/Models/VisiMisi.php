<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi';

    protected $fillable = [
        'visi',
        'misi',
        'tupoksi',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public static function getActive()
    {
        return self::active()->first();
    }

    public function getFormattedVisiAttribute()
    {
        return nl2br(e($this->visi));
    }

    public function getFormattedMisiAttribute()
    {
        return nl2br(e($this->misi));
    }

    public function getFormattedTupoksiAttribute()
    {
        return nl2br(e($this->tupoksi));
    }

    public function getMisiListAttribute()
    {
        return array_filter(explode("\n", $this->misi));
    }

    public function getTupoksiListAttribute()
    {
        return array_filter(explode("\n", $this->tupoksi));
    }
}
