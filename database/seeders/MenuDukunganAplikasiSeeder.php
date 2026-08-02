<?php

namespace Database\Seeders;

use App\Models\Admin\DukunganAplikasi\Menu;

class MenuDukunganAplikasiSeeder extends BaseMenuSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Parent Menu: Manajemen Sistem
        $mm = $this->createMainMenu([
            'name' => 'Dukungan Aplikasi',
            'category' => 'MASTER DATA',
            'icon' => 'ti ti-user',
            'url' => 'admin/dukunganaplikasi',
            'route' => 'admin.dukunganaplikasi',
        ]);
        $this->attachMenupermission($mm, ['read'], ['superadmin', 'admin']);

        // 2. Sub-menu: Kelola Menu
        $sm1 = $this->createSubMenu($mm, [
            'name' => 'Menu',
            'url' => 'admin/dukunganaplikasi/menu',
            'route' => 'admin.dukunganaplikasi.menu.index',
        ]);
        $this->attachMenupermission($sm1, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm1 = $this->createSubMenu($mm, [
            'name' => 'Profil Aplikasi',
            'url' => 'admin/dukunganaplikasi/profil-aplikasi',
            'route' => 'admin.dukunganaplikasi.profil-aplikasi.index',
        ]);
        $this->attachMenupermission($sm1, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);
    }
}
