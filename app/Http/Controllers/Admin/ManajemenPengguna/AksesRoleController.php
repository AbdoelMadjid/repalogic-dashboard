<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\AksesRoleRequest;
use App\Models\Admin\DukunganAplikasi\Menu;
use App\Models\Admin\ManajemenPengguna\Permission;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AksesRoleController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of roles and their assigned Spatie permissions.
     */
    public function index(Request $request)
    {
        $roles = Role::withCount(['permissions', 'users'])->with('permissions')->get();
        $permissions = Permission::all();

        // Fetch menus with their sub-menus and attached Spatie permissions for permission matrix UI
        $parentMenus = Menu::with([
            'permissions',
            'subMenus' => function ($q) {
                $q->with([
                    'permissions',
                    'subMenus' => function ($q2) {
                        $q2->with('permissions')->orderBy('orders', 'asc');
                    }
                ])->orderBy('orders', 'asc');
            }
        ])
        ->parents()
        ->orderBy('orders', 'asc')
        ->get();

        // Find standalone permissions not linked to any Menu model
        $menuPermissionNames = [];
        foreach (Menu::with('permissions')->get() as $m) {
            foreach ($m->permissions as $p) {
                $menuPermissionNames[$p->name] = true;
            }
        }

        $otherPermissions = $permissions->reject(function ($p) use ($menuPermissionNames) {
            return isset($menuPermissionNames[$p->name]);
        });

        return view('admin.manajemenpengguna.akses_role', compact('roles', 'permissions', 'parentMenus', 'otherPermissions'));
    }

    /**
     * Show role details or redirect back.
     */
    public function show($id)
    {
        return redirect()->route('admin.manajemenpengguna.akses-role.index');
    }

    /**
     * Update Spatie permissions assigned to the specified role.
     */
    public function update(AksesRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validated();
        $selectedPermissions = $validated['permissions'] ?? [];

        $role->syncPermissions($selectedPermissions);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Hak Akses (Permission) untuk role \"{$role->name}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.akses-role.index');
    }

    /**
     * Clear all Spatie permissions assigned to the specified role.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin') {
            $this->notifyError("Hak akses untuk role Superadmin tidak dapat dikosongkan.");
            return redirect()->route('admin.manajemenpengguna.akses-role.index');
        }

        $role->syncPermissions([]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Seluruh Hak Akses untuk role \"{$role->name}\" berhasil dikosongkan.");

        return redirect()->route('admin.manajemenpengguna.akses-role.index');
    }
}
