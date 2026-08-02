<?php

namespace Database\Seeders;

class MenuDukunganAplikasiSeeder extends BaseMenuSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Parent Menu: Dukungan Aplikasi
        $mm = $this->createMainMenu([
            'name' => 'Dukungan Aplikasi',
            'category' => 'MASTER DATA',
            'icon' => 'ti ti-api-app',
            'url' => 'admin/dukunganaplikasi',
            'route' => 'admin.dukunganaplikasi',
        ]);
        $this->attachMenupermission($mm, ['read'], ['superadmin', 'admin']);

        // 2. Sub-menus
        $sm1 = $this->createSubMenu($mm, [
            'name' => 'Menu',
            'url' => 'admin/dukunganaplikasi/menu',
            'route' => 'admin.dukunganaplikasi.menu.index',
        ]);
        $this->attachMenupermission($sm1, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm2 = $this->createSubMenu($mm, [
            'name' => 'Profil Aplikasi',
            'url' => 'admin/dukunganaplikasi/profil-aplikasi',
            'route' => 'admin.dukunganaplikasi.profil-aplikasi.index',
        ]);
        $this->attachMenupermission($sm2, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm3 = $this->createSubMenu($mm, [
            'name' => 'Fitur Aplikasi',
            'url' => 'admin/dukunganaplikasi/fitu-aplikasi',
            'route' => 'admin.dukunganaplikasi.fitur-aplikasi.index',
        ]);
        $this->attachMenupermission($sm3, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm4 = $this->createSubMenu($mm, [
            'name' => 'Backup DB',
            'url' => 'admin/dukunganaplikasi/backup-db',
            'route' => 'admin.dukunganaplikasi.backup-db.index',
        ]);
        $this->attachMenupermission($sm4, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);
    }
}
