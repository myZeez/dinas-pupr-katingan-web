<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageHelper
{
    /**
     * Check and debug image storage issues
     */
    public static function debugImageStorage($filename, $directory = 'konten-public')
    {
        $paths = [
            'Storage Path' => storage_path("app/public/{$directory}/{$filename}"),
            'Public Path' => public_path("storage/{$directory}/{$filename}"),
            'Asset URL' => asset("storage/{$directory}/{$filename}"),
        ];

        $debug = [
            'filename' => $filename,
            'directory' => $directory,
            'paths' => [],
        ];

        foreach ($paths as $label => $path) {
            $exists = file_exists($path);
            $debug['paths'][$label] = [
                'path' => $path,
                'exists' => $exists,
                'readable' => $exists ? is_readable($path) : false,
            ];
        }

        // Check storage disk
        $storagePath = "public/{$directory}/{$filename}";
        $debug['storage_disk'] = [
            'exists' => Storage::exists($storagePath),
            'url' => Storage::url($storagePath),
        ];

        Log::info('Image Storage Debug', $debug);

        return $debug;
    }

    /**
     * Ensure directory exists and has proper permissions
     */
    public static function ensureDirectoryExists($directory)
    {
        $storagePath = "public/{$directory}";

        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
            Log::info("Created directory: {$storagePath}");
        }

        // Check if public symlink exists
        $publicPath = public_path("storage/{$directory}");
        if (!file_exists($publicPath)) {
            Log::warning("Public symlink missing for: {$directory}");
        }

        return Storage::exists($storagePath);
    }

    /**
     * Get secure image URL with fallback
     */
    public static function getImageUrl($filename, $directory = 'konten-public', $fallback = null)
    {
        if (!$filename) {
            return $fallback ?: self::getPlaceholderImage();
        }

        // Check if file exists in storage
        $storagePath = "public/{$directory}/{$filename}";
        if (Storage::exists($storagePath)) {
            return Storage::url($storagePath);
        }

        // Check if file exists in public directory
        $publicPath = public_path("storage/{$directory}/{$filename}");
        if (file_exists($publicPath)) {
            return asset("storage/{$directory}/{$filename}");
        }

        // For backward compatibility, check old konten-public folder
        if ($directory !== 'konten-public') {
            $legacyPath = "public/konten-public/{$filename}";
            if (Storage::exists($legacyPath)) {
                return Storage::url($legacyPath);
            }
        }

        Log::warning("Image not found: {$filename} in {$directory}");

        return $fallback ?: self::getPlaceholderImage();
    }
    /**
     * Generate placeholder image as data URL
     */
    public static function getPlaceholderImage($width = 300, $height = 200, $text = 'Image')
    {
        $svg = '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f8f9fa" stroke="#dee2e6" stroke-width="1"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="14" fill="#6c757d" text-anchor="middle" dy=".3em">
                ' . htmlspecialchars($text) . '
            </text>
        </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
