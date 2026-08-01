<?php

namespace App\Traits;

use App\Models\Admin\ManajemenSistem\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

trait HasMenuPermission
{
    /**
     * Attach CRUD permissions to a menu item and assign them to roles.
     *
     * @param Menu $menu
     * @param array|null $permissions (Default: ['create', 'read', 'update', 'delete'])
     * @param array|string|null $roles (Role names to assign these permissions to, defaults dynamically from DB)
     */
    public function attachMenupermission(Menu $menu, array|null $permissions = null, array|string|null $roles = null): void
    {
        if (!is_array($permissions) || empty($permissions)) {
            $permissions = ['create', 'read', 'update', 'delete'];
        }

        // Dynamically fetch default admin roles from database if not specified
        if ($roles === null) {
            $roles = Role::whereIn('name', ['superadmin', 'admin', 'master'])->pluck('name')->toArray();
            if (empty($roles)) {
                $roles = Role::pluck('name')->toArray();
            }
        }

        $this->syncMenuActions($menu, $permissions, $roles);
    }

    /**
     * Compute clean permission target string.
     * Example:
     * - Route: admin.manajemenpengguna.user.index -> 'manajemenpengguna/user'
     * - Route: admin.manajemenpengguna.reset-password -> 'manajemenpengguna/reset-password'
     * - URL: admin/manajemenpengguna/reset-password -> 'manajemenpengguna/reset-password'
     */
    public function getPermissionTarget(Menu $menu): string
    {
        if (!empty($menu->route)) {
            $route = $menu->route;
            $route = preg_replace('/^admin\./i', '', $route);
            $route = preg_replace('/\.index$/i', '', $route);
            $route = preg_replace('/\.\*$/i', '', $route);
            return str_replace('.', '/', $route);
        }

        if (!empty($menu->url)) {
            $url = trim($menu->url, '/');
            $url = preg_replace('/^admin\//i', '', $url);
            return $url;
        }

        if (!empty($menu->category)) {
            return Str::slug($menu->category) . '/' . Str::slug($menu->name);
        }

        return Str::slug($menu->name);
    }

    /**
     * Dynamically generate/sync Spatie permissions based on checked actions (create, read, update, delete).
     * Output format: create {kelompok}/{fitur}, read {kelompok}/{fitur}, etc.
     */
    public function syncMenuActions(Menu $menu, array $actions = [], array|string|null $roles = null): void
    {
        $target = $this->getPermissionTarget($menu);

        // Dynamically fetch roles from database if not specified
        if ($roles === null) {
            $roles = Role::whereIn('name', ['superadmin', 'admin', 'master'])->pluck('name')->toArray();
            if (empty($roles)) {
                $roles = Role::pluck('name')->toArray();
            }
        }

        if (empty($actions)) {
            $menu->permissions()->detach();
        } else {
            $permissionIds = [];

            foreach ($actions as $action) {
                $permName = "{$action} {$target}";

                $permission = Permission::firstOrCreate([
                    'name' => $permName,
                    'guard_name' => 'web',
                ]);

                $permissionIds[] = $permission->id;

                // Assign permission to specified roles
                if ($roles) {
                    foreach ((array) $roles as $roleName) {
                        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
                        if (!$role->hasPermissionTo($permission->name)) {
                            $role->givePermissionTo($permission);
                        }
                    }
                }
            }

            $menu->permissions()->sync($permissionIds);
        }

        // Reset permission and menu cache immediately so new menu shows up right away!
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Cache::forget('menus');
        Cache::forget('urlMenu');
    }
}
