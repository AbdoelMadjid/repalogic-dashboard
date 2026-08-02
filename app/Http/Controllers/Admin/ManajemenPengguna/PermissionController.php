<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManajemenPengguna\PermissionRequest;
use App\Models\Admin\DukunganAplikasi\Menu;
use App\Models\Admin\ManajemenPengguna\Permission;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    use HasNotification;

    /**
     * Display a listing of grouped permissions matching the module target table design.
     * Supports both Yajra DataTables AJAX and standard Blade view.
     */
    public function index(Request $request)
    {
        $permissions = Permission::with(['roles', 'menus'])->get();

        // Group permissions by module target (e.g. "dukunganaplikasi/menu", "manajemenpengguna/role")
        $groupedPermissions = $permissions->groupBy(function ($perm) {
            $parts = explode(' ', $perm->name, 2);
            return $parts[1] ?? $perm->name;
        });

        // Handle Yajra DataTables AJAX request if called by DataTables JS
        if ($request->ajax() && $request->has('draw')) {
            $data = [];
            $index = 1;
            foreach ($groupedPermissions as $target => $permList) {
                $linkedMenu = $permList->flatMap->menus->first();
                $roles = $permList->flatMap->roles->unique('id');
                $firstPerm = $permList->first();
                $firstPermId = $firstPerm ? $firstPerm->id : 0;
                $actionsStr = implode(',', $permList->pluck('name')->map(function($n) {
                    return strtolower(explode(' ', $n)[0] ?? '');
                })->toArray());

                // 1. Modul / Fitur Aplikasi
                $targetHtml = "<div class='d-flex align-items-center'><span class='badge bg-light text-dark font-monospace border fs-12 px-2 py-1 shadow-sm me-2'>{$target}</span>";
                if ($linkedMenu) {
                    $targetHtml .= "<span class='fw-medium text-muted fs-12'>({$linkedMenu->name})</span>";
                }
                $targetHtml .= "</div>";

                // 2. Tipe Aksi Terdaftar (CRUD)
                $crudHtml = "<div class='d-flex flex-wrap gap-1'>";
                foreach ($permList as $perm) {
                    $actionWord = strtoupper(explode(' ', $perm->name)[0] ?? $perm->name);
                    $badgeStyle = match (strtolower($actionWord)) {
                        'create' => 'bg-success-subtle text-success border border-success-subtle',
                        'read' => 'bg-info-subtle text-info border border-info-subtle',
                        'update' => 'bg-warning-subtle text-warning border border-warning-subtle',
                        'delete' => 'bg-danger-subtle text-danger border border-danger-subtle',
                        default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                    };
                    $crudHtml .= "<span class='badge {$badgeStyle} fw-bold px-2 py-1 fs-11' title='{$perm->name}'>{$actionWord}</span>";
                }
                $crudHtml .= "</div>";

                // 3. Ditugaskan Ke Role
                $roleHtml = "<div class='d-flex flex-wrap gap-1'>";
                if ($roles->count() > 0) {
                    foreach ($roles as $role) {
                        $roleBadge = match ($role->name) {
                            'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                            'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                            default => 'bg-info-subtle text-info border-info-subtle'
                        };
                        $roleHtml .= "<span class='badge {$roleBadge} border fs-11 text-capitalize'>{$role->name}</span>";
                    }
                } else {
                    $roleHtml .= "<span class='text-muted fs-12'>- Belum Ditugaskan -</span>";
                }
                $roleHtml .= "</div>";

                // 4. Jumlah Izin
                $countHtml = "<span class='badge bg-light text-dark border px-2 py-1 fs-12 fw-semibold'>{$permList->count()} Akses</span>";

                // 5. Aksi (Detail, Edit, Hapus)
                $actionHtml = "";
                $menuIdVal = $linkedMenu ? $linkedMenu->id : '';

                if (auth()->user()->can('read manajemenpengguna/permission')) {
                    $actionHtml .= "<button type='button' class='btn btn-sm btn-outline-info btn-modul-permission-trigger me-1' data-type='view' data-target='{$target}' data-menu-id='{$menuIdVal}' data-actions='{$actionsStr}' data-first-id='{$firstPermId}' title='Detail Modul'><i class='ti ti-eye'></i></button>";
                }
                if (auth()->user()->can('update manajemenpengguna/permission')) {
                    $actionHtml .= "<button type='button' class='btn btn-sm btn-outline-warning btn-modul-permission-trigger me-1' data-type='edit' data-target='{$target}' data-menu-id='{$menuIdVal}' data-actions='{$actionsStr}' data-first-id='{$firstPermId}' title='Edit Modul'><i class='ti ti-edit'></i></button>";
                }
                if (auth()->user()->can('delete manajemenpengguna/permission')) {
                    $actionHtml .= "<form action='" . route('admin.manajemenpengguna.permission.destroy', $firstPermId) . "' method='POST' class='d-inline' onsubmit='return confirm(\"Hapus seluruh izin permission untuk modul {$target}?\")'>"
                        . csrf_field() . method_field('DELETE')
                        . "<button type='submit' class='btn btn-sm btn-outline-danger' title='Hapus Modul'><i class='ti ti-trash'></i></button></form>";
                }

                $data[] = [
                    'DT_RowIndex' => $index++,
                    'target_formatted' => $targetHtml,
                    'crud_formatted' => $crudHtml,
                    'roles_formatted' => $roleHtml,
                    'count_formatted' => $countHtml,
                    'action' => $actionHtml,
                ];
            }

            return DataTables::of($data)
                ->rawColumns(['target_formatted', 'crud_formatted', 'roles_formatted', 'count_formatted', 'action'])
                ->make(true);
        }

        $parentMenus = Menu::with(['subMenus.subMenus'])->parents()->orderBy('orders', 'asc')->get();

        return view('admin.manajemenpengguna.permission', compact('permissions', 'groupedPermissions', 'parentMenus'));
    }

    public function create()
    {
        return redirect()->route('admin.manajemenpengguna.permission.index');
    }

    /**
     * Store module target CRUD permissions.
     */
    public function store(PermissionRequest $request)
    {
        $validated = $request->validated();
        $target = strtolower(trim($validated['target']));
        $actions = $validated['actions'];

        foreach ($actions as $act) {
            $permName = "{$act} {$target}";
            $permission = Permission::firstOrCreate([
                'name' => $permName,
                'guard_name' => 'web',
            ]);

            if (!empty($validated['menu_id'])) {
                $menu = Menu::find($validated['menu_id']);
                if ($menu) {
                    $menu->permissions()->syncWithoutDetaching([$permission->id]);
                }
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Aksi permission untuk modul \"{$target}\" berhasil ditambahkan.");

        return redirect()->route('admin.manajemenpengguna.permission.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.manajemenpengguna.permission.index');
    }

    /**
     * Update module target CRUD permissions.
     */
    public function update(PermissionRequest $request, $id)
    {
        $validated = $request->validated();
        $target = strtolower(trim($validated['target']));
        $selectedActions = $validated['actions'];
        $allPossibleActions = ['create', 'read', 'update', 'delete'];

        foreach ($allPossibleActions as $act) {
            $permName = "{$act} {$target}";
            if (in_array($act, $selectedActions)) {
                $perm = Permission::firstOrCreate([
                    'name' => $permName,
                    'guard_name' => 'web',
                ]);

                if (!empty($validated['menu_id'])) {
                    $menu = Menu::find($validated['menu_id']);
                    if ($menu) {
                        $menu->permissions()->syncWithoutDetaching([$perm->id]);
                    }
                }
            } else {
                $toDelete = Permission::where('name', $permName)->first();
                if ($toDelete) {
                    $toDelete->menus()->detach();
                    $toDelete->roles()->detach();
                    $toDelete->delete();
                }
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->notifySuccess("Aksi permission untuk modul \"{$target}\" berhasil diperbarui.");

        return redirect()->route('admin.manajemenpengguna.permission.index');
    }

    /**
     * Remove all permissions associated with the specified module target.
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if ($permission) {
            $parts = explode(' ', $permission->name, 2);
            $target = $parts[1] ?? null;

            if ($target) {
                $perms = Permission::where('name', 'like', "% {$target}")->get();
                foreach ($perms as $p) {
                    $p->menus()->detach();
                    $p->roles()->detach();
                    $p->delete();
                }
                $this->notifySuccess("Seluruh permission untuk modul \"{$target}\" berhasil dihapus.");
            } else {
                $permission->menus()->detach();
                $permission->roles()->detach();
                $permission->delete();
                $this->notifySuccess("Permission berhasil dihapus.");
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.manajemenpengguna.permission.index');
    }
}
