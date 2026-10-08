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
     * Supports both Yajra DataTables AJAX and standard Blade view.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            $roles = Role::withCount(['permissions', 'users'])->with('permissions')->get();

            return \Yajra\DataTables\Facades\DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('name_formatted', function ($row) {
                    $badgeClass = match ($row->name) {
                        'superadmin' => 'bg-danger',
                        'admin' => 'bg-primary',
                        default => 'bg-secondary'
                    };
                    return "<span class='badge {$badgeClass} fs-13 py-1 px-2 text-capitalize'><i class='ti ti-shield me-1.5'></i>{$row->name}</span>";
                })
                ->addColumn('users_count_formatted', function ($row) {
                    return "<span class='badge bg-light text-dark border'><i class='ti ti-users me-1.5'></i>{$row->users_count} User</span>";
                })
                ->addColumn('permissions_count_formatted', function ($row) {
                    return "<span class='badge bg-info-subtle text-info border border-info-subtle'><i class='ti ti-key me-1.5'></i>{$row->permissions_count} Permission</span>";
                })
                ->addColumn('action', function ($row) {
                    $roleJson = htmlspecialchars(json_encode($row->load('permissions')), ENT_QUOTES, 'UTF-8');
                    $buttons = '<div class="d-inline-flex gap-1">';
                    if (auth()->user()->can('read manajemenpengguna/akses-role')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-info btn-akses-role-trigger' data-action='view' data-role='{$roleJson}' title='Lihat Detail Akses'><i class='ti ti-eye'></i></button>";
                    }
                    if (auth()->user()->can('update manajemenpengguna/akses-role')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-primary btn-akses-role-trigger' data-action='edit' data-role='{$roleJson}' title='Atur Hak Akses'><i class='ti ti-key'></i></button>";
                    }
                    if (auth()->user()->can('delete manajemenpengguna/akses-role')) {
                        if ($row->name === 'superadmin') {
                            $buttons .= "<button type='button' class='btn btn-sm btn-outline-secondary disabled' title='Akses Superadmin tidak dapat dikosongkan'><i class='ti ti-lock'></i></button>";
                        } else {
                            $buttons .= "<form action='" . route('admin.manajemenpengguna.akses-role.destroy', $row->id) . "' method='POST' class='d-inline' data-confirm='Kosongkan seluruh izin permission untuk role {$row->name}?'>
                                            " . csrf_field() . method_field('DELETE') . "
                                            <button type='submit' class='btn btn-sm btn-outline-danger' title='Kosongkan Akses'><i class='ti ti-trash'></i></button>
                                        </form>";
                        }
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['name_formatted', 'users_count_formatted', 'permissions_count_formatted', 'action'])
                ->make(true);
        }

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
