<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicContent extends Model
{
    use SoftDeletes;

    protected $table = 'public_content_news';

    protected $fillable = [
        'tipe',
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'urutan',
        'status',
        'user_id'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Helper method to get content by tipe
    public static function getByTipe($tipe)
    {
        return self::where('tipe', $tipe)->where('status', 'aktif')->orderBy('urutan')->get();
    }

    // Helper method to get single content by tipe
    public static function getSingleByTipe($tipe)
    {
        return self::where('tipe', $tipe)->where('status', 'aktif')->first();
    }
}
