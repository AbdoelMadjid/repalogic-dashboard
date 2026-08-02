<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\AksesUserRequest;
use App\Models\Admin\DukunganAplikasi\Menu;
use App\Models\Admin\ManajemenPengguna\Permission;
use App\Models\User;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AksesUserController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of users, their assigned roles, and direct permissions.
     */
    public function index(Request $request)
    {
        $users = User::with(['roles', 'permissions'])->get();
        foreach ($users as $user) {
            $user->all_permission_names = $user->getAllPermissions()->pluck('name')->toArray();
            $user->direct_permission_names = $user->permissions->pluck('name')->toArray();
            $user->role_names = $user->roles->pluck('name')->toArray();
        }
        $roles = Role::all();
        $permissions = Permission::with(['menus'])->get();
        $parentMenus = Menu::with(['subMenus.subMenus.permissions', 'subMenus.permissions', 'permissions'])->parents()->orderBy('orders', 'asc')->get();

        return view('admin.manajemenpengguna.akses_user', compact('users', 'roles', 'permissions', 'parentMenus'));
    }

    /**
     * Show user details or redirect back.
     */
    public function show($id)
    {
        return redirect()->route('admin.manajemenpengguna.akses-user.index');
    }

    /**
     * Update Spatie roles and direct permissions assigned to the specified user.
     */
    public function update(AksesUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        $user->syncPermissions($validated['permissions'] ?? []);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Role & Hak Akses khusus untuk pengguna \"{$user->name}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.akses-user.index');
    }

    /**
     * Reset all direct permissions assigned specifically to the user (keeping role permissions intact).
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->syncPermissions([]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Seluruh izin langsung khusus untuk pengguna \"{$user->name}\" berhasil dikosongkan.");

        return redirect()->route('admin.manajemenpengguna.akses-user.index');
    }
}
