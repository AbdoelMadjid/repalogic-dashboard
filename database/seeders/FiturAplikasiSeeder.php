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
                'topbar_megamenu_header' => false,
                'topbar_megamenu_apps' => false,
                'topbar_theme_toggler' => true,
                'topbar_apps_dropdown' => false,
                'topbar_messages' => true,
                'topbar_notifications' => true,
                'topbar_fullscreen' => true,
                'topbar_monochrome' => true,
                'topbar_customizer' => false,
                'topbar_language' => true,
                'topbar_user_dropdown' => true,
                'menu_group_main' => false,
                'menu_group_apps' => false,
                'menu_group_custom_pages' => false,
                'menu_group_layouts' => false,
                'menu_group_components' => false,
                'menu_group_documentation' => false,
                'menu_group_menu_item' => false,
                'menu_special_menu' => true,
            ]
        );
    }
}
