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
        $permissions = Permission::with(['menus'])->get();
        $parentMenus = Menu::with(['subMenus.subMenus.permissions', 'subMenus.permissions', 'permissions'])->parents()->orderBy('orders', 'asc')->get();

        return view('admin.manajemenpengguna.akses_role', compact('roles', 'permissions', 'parentMenus'));
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
