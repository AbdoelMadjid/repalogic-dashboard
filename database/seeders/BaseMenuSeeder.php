<?php

namespace Database\Seeders;

use App\Models\Admin\ManajemenSistem\Menu;
use App\Traits\HasMenuPermission;
use Illuminate\Database\Seeder;

abstract class BaseMenuSeeder extends Seeder
{
    use HasMenuPermission;

    /**
     * Order counter for main menus
     */
    protected static int $mainOrder = 1;

    /**
     * Create or Update Main Menu entry with automatic order increment
     */
    protected function createMainMenu(array $data): Menu
    {
        $data['orders'] = $data['orders'] ?? self::$mainOrder++;
        $data['active'] = $data['active'] ?? 1;

        $searchKey = !empty($data['url']) ? ['url' => $data['url']] : ['name' => $data['name']];

        return Menu::updateOrCreate($searchKey, $data);
    }

    /**
     * Create or Update Sub Menu under a parent menu with auto order increment
     */
    protected function createSubMenu(Menu $parent, array $data): Menu
    {
        $nextOrder = ($parent->subMenus()->max('orders') ?? 0) + 1;
        $data['orders'] = $data['orders'] ?? $nextOrder;
        $data['active'] = $data['active'] ?? 1;
        $data['category'] = $data['category'] ?? $parent->category;
        $data['main_menu_id'] = $parent->id;

        $searchKey = !empty($data['url'])
            ? ['main_menu_id' => $parent->id, 'url' => $data['url']]
            : ['main_menu_id' => $parent->id, 'name' => $data['name']];

        return Menu::updateOrCreate($searchKey, $data);
    }
}
