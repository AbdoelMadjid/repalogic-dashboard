<?php

namespace Database\Seeders;

class MenuManajemenPenggunaSeeder extends BaseMenuSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Parent Menu: Manajemen Pengguna
        $mm = $this->createMainMenu([
            'name' => 'Manajemen Pengguna',
            'category' => 'MASTER DATA',
            'icon' => 'ti ti-users-plus',
            'url' => 'admin/manajemenpengguna',
            'route' => 'admin.manajemenpengguna',
        ]);
        $this->attachMenupermission($mm, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        // 2. Sub-menus under Manajemen Pengguna
        $sm1 = $this->createSubMenu($mm, [
            'name' => 'Role',
            'url' => 'admin/manajemenpengguna/role',
            'route' => 'admin.manajemenpengguna.role.index',
        ]);
        $this->attachMenupermission($sm1, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm2 = $this->createSubMenu($mm, [
            'name' => 'Permission',
            'url' => 'admin/manajemenpengguna/permission',
            'route' => 'admin.manajemenpengguna.permission.index',
        ]);
        $this->attachMenupermission($sm2, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm3 = $this->createSubMenu($mm, [
            'name' => 'Akses Role',
            'url' => 'admin/manajemenpengguna/akses-role',
            'route' => 'admin.manajemenpengguna.akses-role.index',
        ]);
        $this->attachMenupermission($sm3, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm4 = $this->createSubMenu($mm, [
            'name' => 'Akses User',
            'url' => 'admin/manajemenpengguna/akses-user',
            'route' => 'admin.manajemenpengguna.akses-user.index',
        ]);
        $this->attachMenupermission($sm4, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm5 = $this->createSubMenu($mm, [
            'name' => 'Users',
            'url' => 'admin/manajemenpengguna/users',
            'route' => 'admin.manajemenpengguna.users.index',
        ]);
        $this->attachMenupermission($sm5, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm6 = $this->createSubMenu($mm, [
            'name' => 'Reset Password',
            'url' => 'admin/manajemenpengguna/reset-password',
            'route' => 'admin.manajemenpengguna.reset-password.index',
        ]);
        $this->attachMenupermission($sm6, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        $sm7 = $this->createSubMenu($mm, [
            'name' => 'Data Login',
            'url' => 'admin/manajemenpengguna/data-login',
            'route' => 'admin.manajemenpengguna.data-login.index',
        ]);
        $this->attachMenupermission($sm7, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']);

        // Sub-menu Level 3 (Di bawah Data Login)
        /* $ssm1 = $this->createSubMenu($sm7, [
            'name' => 'Riwayat Sesi',
            'url' => 'admin/manajemenpengguna/data-login/riwayat-sesi',
            'route' => 'admin.manajemenpengguna.data-login.riwayat-sesi.index',
        ]);
        $this->attachMenupermission($ssm1, ['create', 'read', 'update', 'delete'], ['superadmin', 'admin']); */
    }
}
