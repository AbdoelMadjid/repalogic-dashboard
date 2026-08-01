<?php

namespace Database\Seeders;

use App\Models\Admin\ManajemenSistem\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

class MainMenuSeeder extends Seeder
{
    /**
     * Run the database seeds cleanly by truncating menu & permission tables first to prevent duplicates.
     */
    public function run(): void
    {
        // 1. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. DISABLE FOREIGN KEY CHECKS & TRUNCATE MENU & PERMISSION TABLES
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach (['menu_permission', 'role_has_permissions', 'permissions', 'menus'] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 1;");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Call Modular Menu Seeders
        $this->call([
            MenuManajemenPenggunaSeeder::class,
        ]);

        // 4. Normalize Menu Orders
        $this->normalizeMenuOrders();

        // 5. Clear Menu Cache
        Cache::forget('menus');
        Cache::forget('urlMenu');
    }

    /**
     * Rapikan ulang urutan menu berdasarkan urutan insert/orders.
     */
    protected function normalizeMenuOrders(): void
    {
        $mainMenus = Menu::query()
            ->whereNull('main_menu_id')
            ->orderBy('orders')
            ->orderBy('id')
            ->get();

        foreach ($mainMenus as $mainIndex => $mainMenu) {
            $mainMenu->update(['orders' => $mainIndex + 1]);

            $subMenus = Menu::query()
                ->where('main_menu_id', $mainMenu->id)
                ->orderBy('orders')
                ->orderBy('id')
                ->get();

            foreach ($subMenus as $subIndex => $subMenu) {
                $subMenu->update(['orders' => $subIndex + 1]);
            }
        }
    }
}
