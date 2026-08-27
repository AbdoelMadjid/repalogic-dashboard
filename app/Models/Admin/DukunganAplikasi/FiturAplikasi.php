<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FiturAplikasi extends Model
{
    use HasFactory;

    protected $table = 'fitur_aplikasi';

    protected $fillable = [
        'kode_fitur',
        'nama_fitur',
        'kategori',
        'deskripsi',
        'icon',
        'status',
        'urutan',
        'is_system',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_system' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get cached feature settings map as a safe helper object.
     */
    public static function getSettings(): FeatureSettingMap
    {
        $features = Cache::rememberForever('fitur_aplikasi_raw_map', function () {
            try {
                return self::pluck('status', 'kode_fitur')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });

        return new FeatureSettingMap($features);
    }

    /**
     * Check if a specific feature is enabled.
     */
    public static function isActive(string $kodeFitur, bool $default = true): bool
    {
        $settings = self::getSettings();
        return $settings->isActive($kodeFitur, $default);
    }

    /**
     * Clear the cached feature settings.
     */
    public static function clearCache(): void
    {
        Cache::forget('fitur_aplikasi_raw_map');
        Cache::forget('fitur_aplikasi_settings_map');
        Cache::forget('fitur_aplikasi_settings');
    }
}
