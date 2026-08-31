<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\ProfilAplikasi;
use Illuminate\Database\Seeder;

class ProfilAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilAplikasi::clearCache();

        ProfilAplikasi::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'REPALOGIC Dashboard',
                'app_short_name' => 'REPALOGIC',
                'logo_lg' => null,
                'logo_sm' => null,
                'favicon' => null,
                'meta_description' => 'Inspinia Admin Dashboard & Management System',
                'meta_keywords' => 'admin, dashboard, repalogic, php, laravel',
                'meta_author' => 'Repalogic',
                'footer_text' => 'Inspinia By',
                'created_year' => '2026',
                'developer_name' => 'Repalogic',
                'developer_url' => 'https://github.com/AbdoelMadjid/repalogic-dashboard',
            ]
        );
    }
}
