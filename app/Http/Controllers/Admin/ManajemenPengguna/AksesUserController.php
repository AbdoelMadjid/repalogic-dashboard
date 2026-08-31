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
        $roles = Role::with('permissions')->get();
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

        return view('admin.manajemenpengguna.akses_user', compact('users', 'roles', 'permissions', 'parentMenus', 'otherPermissions'));
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

        $selectedRoles = $validated['roles'] ?? [];
        $user->syncRoles($selectedRoles);

        $submittedPermissions = $validated['permissions'] ?? [];

        // Ambil seluruh permission yang sudah diberikan secara otomatis melalui role yang dipilih
        $rolePermissionNames = Role::whereIn('name', $selectedRoles)
            ->with('permissions')
            ->get()
            ->flatMap(fn($role) => $role->permissions->pluck('name'))
            ->unique()
            ->toArray();

        // Hanya simpan izin langsung (direct permissions) yang belum dicakup oleh role
        $directPermissions = array_values(array_diff($submittedPermissions, $rolePermissionNames));

        $user->syncPermissions($directPermissions);

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
