<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\RoleRequest;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of roles (Supports Yajra DataTables AJAX & standard view).
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            $roles = Role::withCount(['permissions', 'users'])->get();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('name_formatted', function ($row) {
                    $badgeClass = match ($row->name) {
                        'superadmin' => 'bg-danger',
                        'admin' => 'bg-primary',
                        default => 'bg-secondary'
                    };
                    return "<span class='badge {$badgeClass} fs-13 py-1 px-2 text-capitalize'><i class='ti ti-shield me-1'></i>{$row->name}</span>";
                })
                ->addColumn('users_count_formatted', function ($row) {
                    return "<span class='badge bg-light text-dark border'><i class='ti ti-users me-1'></i>{$row->users_count} User</span>";
                })
                ->addColumn('permissions_count_formatted', function ($row) {
                    return "<span class='badge bg-info-subtle text-info border border-info-subtle'><i class='ti ti-key me-1'></i>{$row->permissions_count} Permission</span>";
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if (auth()->user()->can('read manajemenpengguna/role')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-info btn-role-action me-1' data-action='view' data-role='" . json_encode($row->load('permissions')) . "' title='Detail'><i class='ti ti-eye'></i></button>";
                    }
                    if (auth()->user()->can('update manajemenpengguna/role')) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-warning btn-role-action me-1' data-action='edit' data-role='" . json_encode($row->load('permissions')) . "' title='Edit'><i class='ti ti-edit'></i></button>";
                    }
                    if (auth()->user()->can('delete manajemenpengguna/role')) {
                        if ($row->name === 'superadmin') {
                            $buttons .= "<button type='button' class='btn btn-sm btn-outline-secondary disabled' title='Superadmin tidak dapat dihapus'><i class='ti ti-lock'></i></button>";
                        } else {
                            $buttons .= "<form action='" . route('admin.manajemenpengguna.role.destroy', $row->id) . "' method='POST' class='d-inline' onsubmit='return confirm(\"Hapus role {$row->name}?\")'>
                                            " . csrf_field() . method_field('DELETE') . "
                                            <button type='submit' class='btn btn-sm btn-outline-danger' title='Hapus'><i class='ti ti-trash'></i></button>
                                        </form>";
                        }
                    }
                    return $buttons;
                })
                ->rawColumns(['name_formatted', 'users_count_formatted', 'permissions_count_formatted', 'action'])
                ->make(true);
        }

        $roles = Role::withCount(['permissions', 'users'])->get();
        $permissions = Permission::all();

        // Fetch menus with their sub-menus and attached Spatie permissions for permission matrix UI
        $parentMenus = \App\Models\Admin\DukunganAplikasi\Menu::with([
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
        foreach (\App\Models\Admin\DukunganAplikasi\Menu::with('permissions')->get() as $m) {
            foreach ($m->permissions as $p) {
                $menuPermissionNames[$p->name] = true;
            }
        }

        $otherPermissions = $permissions->reject(function ($p) use ($menuPermissionNames) {
            return isset($menuPermissionNames[$p->name]);
        });

        return view('admin.manajemenpengguna.role', compact('roles', 'permissions', 'parentMenus', 'otherPermissions'));
    }

    /**
     * Redirect to index since CRUD uses modals.
     */
    public function create()
    {
        return redirect()->route('admin.manajemenpengguna.role.index');
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(RoleRequest $request)
    {
        $validated = $request->validated();

        $role = Role::create([
            'name' => strtolower(trim($validated['name'])),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Role \"{$role->name}\" berhasil ditambahkan.");

        return redirect()->route('admin.manajemenpengguna.role.index');
    }

    /**
     * Redirect to index since CRUD uses modals.
     */
    public function edit(Role $role)
    {
        return redirect()->route('admin.manajemenpengguna.role.index');
    }

    /**
     * Update the specified role in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->update([
            'name' => strtolower(trim($validated['name'])),
        ]);

        $role->syncPermissions($request->input('permissions', []));

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Role \"{$role->name}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.role.index');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'superadmin') {
            $this->notifySwal("Role Superadmin tidak dapat dihapus.", "Gagal Hapus", "error");
            return redirect()->route('admin.manajemenpengguna.role.index');
        }

        $roleName = $role->name;
        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Role \"{$roleName}\" berhasil dihapus.");

        return redirect()->route('admin.manajemenpengguna.role.index');
    }
}
