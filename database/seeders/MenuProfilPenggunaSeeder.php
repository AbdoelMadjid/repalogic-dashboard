<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;

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

        // Ambil seluruh role yang ada di database agar menu dapat diakses oleh role apapun
        $allRoles = Role::pluck('name')->toArray();
        if (empty($allRoles)) {
            $allRoles = ['superadmin', 'admin', 'operator', 'user'];
        }

        $this->attachMenupermission($mm, ['create', 'read', 'update'], $allRoles);
    }
}
