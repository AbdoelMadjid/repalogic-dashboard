<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteTheme extends Model
{
    use HasFactory;

    protected $table = 'website_themes';

    protected $fillable = [
        'name',
        'slug',
        'folder',
        'description',
        'preview_image',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * Memeriksa apakah tema bertipe Multi-Page Portal.
     */
    public function isMultipage(): bool
    {
        return $this->folder === 'education' || (($this->settings['type'] ?? '') === 'multipage');
    }

    /**
     * Memeriksa apakah tema bertipe One-Page Landing.
     */
    public function isOnePage(): bool
    {
        return !$this->isMultipage();
    }

    /**
     * Relasi ke seksi-seksi halaman pada tema ini.
     */
    public function sections()
    {
        return $this->hasMany(WebsiteSection::class, 'website_theme_id')->orderBy('orders', 'asc');
    }

    /**
     * Relasi seksi aktif yang akan ditampilkan di landing page.
     */
    public function activeSections()
    {
        return $this->hasMany(WebsiteSection::class, 'website_theme_id')
            ->where('is_active', true)
            ->orderBy('orders', 'asc');
    }

    /**
     * Mengambil Tema Aktif dengan Cache.
     */
    public static function getActiveTheme(): ?self
    {
        $cached = Cache::get('active_website_theme');
        if (!($cached instanceof self)) {
            Cache::forget('active_website_theme');
            $theme = self::where('is_active', true)->with('activeSections')->first();
            if (!$theme) {
                $theme = self::with('activeSections')->first();
            }
            if ($theme) {
                Cache::forever('active_website_theme', $theme);
            }
            return $theme;
        }

        return $cached;
    }

    /**
     * Clear Cache Tema Website.
     */
    public static function clearCache(): void
    {
        Cache::forget('active_website_theme');
    }
}
