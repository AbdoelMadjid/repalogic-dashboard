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

        // 2. Seed Admin & Core Users
        $user1 = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'status' => 'active',
            'approved_at' => now(),
        ]);
        $user1->assignRole('superadmin');

        $user2 = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'status' => 'active',
            'approved_at' => now(),
        ]);
        $user2->assignRole('admin');

        $user3 = User::firstOrCreate([
            'email' => 'operator@example.com',
        ], [
            'name' => 'Operator',
            'password' => bcrypt('password'),
            'status' => 'active',
            'approved_at' => now(),
        ]);
        $user3->assignRole('operator');

        // 3. Seed 10 Dummy Users dengan Role 'user' via Factory
        User::factory()->count(10)->create();

        // 4. Seed Menus & Permissions
        $this->call(MainMenuSeeder::class);

        // 5. Seed Profil Aplikasi
        $this->call(ProfilAplikasiSeeder::class);

        // 6. Seed Fitur Aplikasi
        $this->call(FiturAplikasiSeeder::class);

        // 7. Seed Pengaturan Sistem Aplikasi
        $this->call(AppSettingSeeder::class);

        // 8. Seed Tema & Seksi Website Landing Page
        $this->call(WebsiteThemeSeeder::class);
    }
}
