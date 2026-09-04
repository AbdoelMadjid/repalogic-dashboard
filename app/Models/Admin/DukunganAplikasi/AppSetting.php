<?php

namespace App\Models\Admin\DukunganAplikasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    use HasFactory;

    protected $table = 'app_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Default fallback values when database record is empty or before seeding.
     */
    public static array $defaults = [
        'idle_timeout_minutes' => 5,
        'maintenance_mode' => 0,
        'maintenance_message' => 'Sistem sedang dalam proses pemeliharaan berkala. Silakan coba beberapa saat lagi.',
        'rate_limit_attempts' => 5,
        'auto_user_approval' => 0,
        'new_device_alert' => 1,
        'polling_interval' => 20,
        'sound_notification' => 1,
        'toast_notification' => 1,
    ];

    /**
     * Get a setting by key with smart fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $fallback = $default !== null ? $default : (self::$defaults[$key] ?? null);

        return Cache::rememberForever('app_setting_' . $key, function () use ($key, $fallback) {
            try {
                $setting = self::where('key', $key)->first();
                return $setting !== null ? $setting->value : $fallback;
            } catch (\Throwable $e) {
                return $fallback;
            }
        });
    }

    /**
     * Set a setting by key.
     */
    public static function set(string $key, mixed $value): void
    {
        $stringValue = is_bool($value) ? ($value ? '1' : '0') : (string) $value;

        self::updateOrCreate(
            ['key' => $key],
            ['value' => $stringValue]
        );

        Cache::forever('app_setting_' . $key, $value);
    }

    /**
     * Clear and reload all setting caches from DB.
     */
    public static function clearCache(): void
    {
        try {
            $settings = self::all();
            foreach ($settings as $setting) {
                Cache::forever('app_setting_' . $setting->key, $setting->value);
            }
        } catch (\Throwable $e) {
            // Ignore error
        }
    }
}
