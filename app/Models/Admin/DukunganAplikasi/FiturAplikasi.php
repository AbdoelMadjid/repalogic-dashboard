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
        'topbar_search_box',
        'topbar_megamenu_header',
        'topbar_megamenu_apps',
        'topbar_theme_toggler',
        'topbar_apps_dropdown',
        'topbar_messages',
        'topbar_notifications',
        'topbar_fullscreen',
        'topbar_monochrome',
        'topbar_customizer',
        'topbar_language',
        'topbar_user_dropdown',
        'menu_group_main',
        'menu_group_apps',
        'menu_group_custom_pages',
        'menu_group_layouts',
        'menu_group_components',
        'menu_group_documentation',
        'menu_group_menu_item',
        'menu_special_menu',
    ];

    protected $casts = [
        'topbar_search_box' => 'boolean',
        'topbar_megamenu_header' => 'boolean',
        'topbar_megamenu_apps' => 'boolean',
        'topbar_theme_toggler' => 'boolean',
        'topbar_apps_dropdown' => 'boolean',
        'topbar_messages' => 'boolean',
        'topbar_notifications' => 'boolean',
        'topbar_fullscreen' => 'boolean',
        'topbar_monochrome' => 'boolean',
        'topbar_customizer' => 'boolean',
        'topbar_language' => 'boolean',
        'topbar_user_dropdown' => 'boolean',
        'menu_group_main' => 'boolean',
        'menu_group_apps' => 'boolean',
        'menu_group_custom_pages' => 'boolean',
        'menu_group_layouts' => 'boolean',
        'menu_group_components' => 'boolean',
        'menu_group_documentation' => 'boolean',
        'menu_group_menu_item' => 'boolean',
        'menu_special_menu' => 'boolean',
    ];

    /**
     * Get cached feature settings singleton safely.
     */
    public static function getSettings(): self
    {
        $cached = Cache::get('fitur_aplikasi_settings');

        if (!($cached instanceof self)) {
            Cache::forget('fitur_aplikasi_settings');

            $settings = self::first();
            if (!$settings) {
                $settings = self::create([
                    'topbar_search_box' => true,
                    'topbar_megamenu_header' => true,
                    'topbar_megamenu_apps' => true,
                    'topbar_theme_toggler' => true,
                    'topbar_apps_dropdown' => true,
                    'topbar_messages' => true,
                    'topbar_notifications' => true,
                    'topbar_fullscreen' => true,
                    'topbar_monochrome' => true,
                    'topbar_customizer' => true,
                    'topbar_language' => true,
                    'topbar_user_dropdown' => true,
                    'menu_group_main' => true,
                    'menu_group_apps' => true,
                    'menu_group_custom_pages' => true,
                    'menu_group_layouts' => true,
                    'menu_group_components' => true,
                    'menu_group_documentation' => true,
                    'menu_group_menu_item' => true,
                    'menu_special_menu' => true,
                ]);
            }

            Cache::forever('fitur_aplikasi_settings', $settings);
            return $settings;
        }

        return $cached;
    }

    /**
     * Clear the cached feature settings.
     */
    public static function clearCache(): void
    {
        Cache::forget('fitur_aplikasi_settings');
    }
}
