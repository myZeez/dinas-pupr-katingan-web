<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CaptchaSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        //
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        return Cache::remember("captcha_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->getCastedValue() : $default;
        });
    }

    /**
     * Set setting value by key
     */
    public static function setValue($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("captcha_setting_{$key}");
        return $setting;
    }

    /**
     * Get casted value based on type
     */
    public function getCastedValue()
    {
        // For simplified table, handle common conversions
        if (in_array($this->key, ['captcha_required', 'nocaptcha_enterprise'])) {
            return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
        }

        return $this->value;
    }

    /**
     * Clear all captcha settings cache
     */
    public static function clearCache()
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("captcha_setting_{$key}");
        }
    }
}
