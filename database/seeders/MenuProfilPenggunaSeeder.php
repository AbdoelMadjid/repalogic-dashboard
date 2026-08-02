<?php

namespace Database\Seeders;

class MenuProfilPenggunaSeeder extends BaseMenuSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Menu: Profil Pengguna
        $mm = $this->createMainMenu([
            'name' => 'Profil Pengguna',
            'category' => 'MASTER DATA',
            'icon' => 'ti ti-user-circle',
            'url' => 'admin/profil-pengguna',
            'route' => 'admin.profil-pengguna.index',
        ]);
        $this->attachMenupermission($mm, ['create', 'read', 'update'], ['superadmin', 'admin', 'operator']);
    }
}
