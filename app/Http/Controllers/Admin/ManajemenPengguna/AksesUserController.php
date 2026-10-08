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
     * Supports both Yajra DataTables AJAX and standard Blade view.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            $query = User::with(['roles.permissions', 'permissions']);

            return \Yajra\DataTables\Facades\DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('user_formatted', function ($row) {
                    return "<div class='d-flex align-items-center'>
                        <img src='{$row->avatar_url}' alt='{$row->name}' class='rounded-circle me-2 object-fit-cover border flex-shrink-0' style='width: 38px; height: 38px;'>
                        <div class='text-break'>
                            <h6 class='mb-0 fs-13 fw-semibold text-dark text-break'>{$row->name}</h6>
                            <span class='text-muted fs-12 text-break'>{$row->email}</span>
                        </div>
                    </div>";
                })
                ->addColumn('roles_formatted', function ($row) {
                    $rolesHtml = "<div class='d-flex flex-wrap gap-1 justify-content-center'>";
                    if ($row->roles->count() > 0) {
                        foreach ($row->roles as $role) {
                            $badgeClass = match ($role->name) {
                                'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                            };
                            $rolesHtml .= "<span class='badge {$badgeClass} border fs-11 text-capitalize'><i class='ti ti-shield me-1'></i>{$role->name}</span>";
                        }
                    } else {
                        $rolesHtml .= "<span class='text-muted fs-12'>- Tanpa Role -</span>";
                    }
                    $rolesHtml .= "</div>";
                    return $rolesHtml;
                })
                ->addColumn('direct_perms_formatted', function ($row) {
                    $directCount = $row->permissions->count();
                    return "<span class='badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-12'><i class='ti ti-key me-1.5'></i>{$directCount} Direct</span>";
                })
                ->addColumn('total_perms_formatted', function ($row) {
                    $direct = $row->permissions;
                    $fromRoles = $row->roles->flatMap->permissions;
                    $totalCount = $direct->merge($fromRoles)->unique('id')->count();
                    return "<span class='badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12 fw-semibold'><i class='ti ti-check me-1.5'></i>{$totalCount} Akses</span>";
                })
                ->addColumn('action', function ($row) {
                    $directNames = $row->permissions->pluck('name')->toArray();
                    $roleNames = $row->roles->pluck('name')->toArray();
                    $allNames = $row->permissions->merge($row->roles->flatMap->permissions)->pluck('name')->unique()->values()->toArray();

                    $userPayload = [
                        'id' => $row->id,
                        'name' => $row->name,
                        'email' => $row->email,
                        'avatar_url' => $row->avatar_url,
                        'role_names' => $roleNames,
                        'direct_permission_names' => $directNames,
                        'all_permission_names' => $allNames,
                    ];
                    $userJson = htmlspecialchars(json_encode($userPayload), ENT_QUOTES, 'UTF-8');

                    $buttons = '<div class="d-inline-flex gap-1">';
                    if (auth()->user()->can('read manajemenpengguna/akses-user')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-info btn-akses-user-trigger' data-action='view' data-user='{$userJson}' title='Lihat Detail Akses'><i class='ti ti-eye'></i></button>";
                    }
                    if (auth()->user()->can('update manajemenpengguna/akses-user')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-primary btn-akses-user-trigger' data-action='edit' data-user='{$userJson}' title='Atur Akses Pengguna'><i class='ti ti-key'></i></button>";
                    }
                    if (auth()->user()->can('delete manajemenpengguna/akses-user')) {
                        $buttons .= "<form action='" . route('admin.manajemenpengguna.akses-user.destroy', $row->id) . "' method='POST' class='d-inline' data-confirm='Kosongkan seluruh izin khusus langsung (direct permissions) untuk user {$row->name}?'>
                                        " . csrf_field() . method_field('DELETE') . "
                                        <button type='submit' class='btn btn-sm btn-outline-danger' title='Reset Izin Langsung'><i class='ti ti-trash'></i></button>
                                    </form>";
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['user_formatted', 'roles_formatted', 'direct_perms_formatted', 'total_perms_formatted', 'action'])
                ->make(true);
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

        return view('admin.manajemenpengguna.akses_user', compact('roles', 'permissions', 'parentMenus', 'otherPermissions'));
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
