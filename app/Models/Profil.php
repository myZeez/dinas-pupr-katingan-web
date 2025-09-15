<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_instansi',
        'visi',
        'misi',
        'tupoksi',
        'sejarah',
        'motto',
        'filosofi',
        'nilai_nilai',
        'sasaran',
        'tujuan',
        'kebijakan_mutu',
        'alamat',
        'telepon',
        'fax',
        'email',
        'website',
        'logo',
        'background_image',
        'latitude',
        'longitude',
        'jam_operasional',
        'status',
        'user_id'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'status' => 'string'
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

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors
    public function getShortVisiAttribute()
    {
        return strlen($this->visi) > 200 ? substr($this->visi, 0, 200) . '...' : $this->visi;
    }

    public function getShortMisiAttribute()
    {
        return strlen($this->misi) > 300 ? substr($this->misi, 0, 300) . '...' : $this->misi;
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('img/default-logo.png');
    }

    // Static methods
    public static function getActiveProfile()
    {
        return self::where('status', 'aktif')->first();
    }

    public static function getOrCreateDefault()
    {
        $profil = self::first();

        if (!$profil) {
            $profil = self::create([
                'nama_instansi' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'status' => 'aktif'
            ]);
        }

        return $profil;
    }
}
