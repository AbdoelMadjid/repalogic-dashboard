<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $this->call(RoleSeeder::class);

        // 2. Seed Admin Users
        $user1 = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole('superadmin');

        $user2 = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
        ]);
        $user2->assignRole('admin');

        $user3 = User::firstOrCreate([
            'email' => 'operator@example.com',
        ], [
            'name' => 'Operator',
            'password' => bcrypt('password'),
        ]);
        $user3->assignRole('operator');

        // 3. Seed Menus & Permissions
        $this->call(MainMenuSeeder::class);

        // 4. Seed Profil Aplikasi
        $this->call(ProfilAplikasiSeeder::class);

        // 5. Seed Fitur Aplikasi
        $this->call(FiturAplikasiSeeder::class);
    }
}
