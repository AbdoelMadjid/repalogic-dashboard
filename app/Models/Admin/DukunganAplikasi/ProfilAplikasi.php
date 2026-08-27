<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProfilAplikasi extends Model
{
    use HasFactory;

    protected $table = 'profil_aplikasi';

    protected $fillable = [
        'app_name',
        'app_short_name',
        'app_version',
        'logo_lg',
        'logo_sm',
        'favicon',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'footer_text',
        'created_year',
        'developer_name',
        'developer_url',
    ];

    /**
     * Get cached application settings singleton.
     */
    public static function getSettings(): self
    {
        $currentAppVersion = config('app.version', 'v1.9.1');
        $cached = Cache::get('profil_aplikasi_settings');

        if (!($cached instanceof self) || $cached->app_version !== $currentAppVersion) {
            Cache::forget('profil_aplikasi_settings');

            $settings = self::first();
            if (!$settings) {
                $settings = self::create([
                    'app_name' => 'REPALOGIC Dashboard',
                    'app_short_name' => 'REPALOGIC',
                    'app_version' => $currentAppVersion,
                    'meta_description' => 'Inspinia Admin Dashboard & Management System',
                    'meta_keywords' => 'admin, dashboard, repalogic, php, laravel',
                    'meta_author' => 'WebAppLayers',
                    'footer_text' => 'Inspinia By',
                    'created_year' => date('Y'),
                    'developer_name' => 'WebAppLayers',
                    'developer_url' => 'https://wrapbootstrap.com',
                ]);
            } else if ($settings->app_version !== $currentAppVersion) {
                $settings->update(['app_version' => $currentAppVersion]);
                $settings->refresh();
            }

            Cache::forever('profil_aplikasi_settings', $settings);
            return $settings;
        }

        return $cached;
    }

    /**
     * Clear the cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget('profil_aplikasi_settings');
    }
}
