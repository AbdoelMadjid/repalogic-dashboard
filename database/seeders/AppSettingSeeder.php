<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds for application settings.
     */
    public function run(): void
    {
        $defaultSettings = [
            'idle_timeout_minutes' => '5',
            'maintenance_mode' => '0',
            'maintenance_message' => 'Sistem sedang dalam proses pemeliharaan berkala. Silakan coba beberapa saat lagi.',
            'rate_limit_attempts' => '5',
            'auto_user_approval' => '0',
            'new_device_alert' => '1',
            'polling_interval' => '20',
            'sound_notification' => '1',
            'toast_notification' => '1',
        ];

        foreach ($defaultSettings as $key => $value) {
            AppSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        AppSetting::clearCache();
    }
}
