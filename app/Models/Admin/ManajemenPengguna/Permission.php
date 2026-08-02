<?php

namespace App\Models\Admin\ManajemenPengguna;

use App\Models\Admin\DukunganAplikasi\Menu;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * Many-to-Many relation with Menu model via menu_permission pivot table.
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_permission', 'permission_id', 'menu_id');
    }
}
