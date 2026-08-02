<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\FiturAplikasi;
use Illuminate\Database\Seeder;

class FiturAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FiturAplikasi::clearCache();

        FiturAplikasi::firstOrCreate(
            ['id' => 1],
            [
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
            ]
        );
    }
}
