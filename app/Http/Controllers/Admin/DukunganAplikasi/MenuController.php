<?php

namespace App\Http\Controllers\Admin\DukunganAplikasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DukunganAplikasi\MenuRequest;
use App\Models\Admin\DukunganAplikasi\Menu;
use App\Traits\HasMenuPermission;
use App\Traits\HasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    use HasNotification, HasMenuPermission;

    /**
     * Display a listing of the menus (Supports Yajra DataTables AJAX & standard view).
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            $menus = Menu::with(['parent', 'subMenus.permissions.roles', 'permissions.roles'])
                ->orderBy('orders', 'asc')
                ->get();

            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('name_formatted', function ($row) {
                    $icon = $row->icon ? "<i class='{$row->icon} me-1 fs-18'></i>" : '';
                    $prefix = $row->main_menu_id ? "<span class='text-muted me-1'>└─</span>" : '';
                    return "{$prefix}{$icon} {$row->name}";
                })
                ->addColumn('route_url', function ($row) {
                    if ($row->route) {
                        return "<span class='badge bg-info-subtle text-info'>Route: {$row->route}</span>";
                    } elseif ($row->url) {
                        return "<span class='badge bg-secondary-subtle text-dark'>URL: {$row->url}</span>";
                    }
                    return "<span class='text-muted fs-12'>(Header Parent)</span>";
                })
                ->addColumn('permissions_formatted', function ($row) {
                    $badges = '';
                    foreach ($row->permissions as $perm) {
                        $actionWord = explode(' ', $perm->name)[0] ?? $perm->name;
                        $badgeColor = match ($actionWord) {
                            'read' => 'bg-info',
                            'create' => 'bg-success',
                            'update' => 'bg-warning',
                            'delete' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        $badges .= "<span class='badge {$badgeColor} me-1 mb-1'><i class='ti ti-shield-lock me-1'></i>" . strtoupper($actionWord) . "</span>";
                    }
                    return $badges ?: "<span class='badge bg-light text-muted'>Publik</span>";
                })
                ->addColumn('roles_formatted', function ($row) {
                    $assignedRoles = [];
                    foreach ($row->permissions as $perm) {
                        foreach ($perm->roles as $r) {
                            $assignedRoles[$r->name] = $r->name;
                        }
                    }
                    $badges = '';
                    foreach ($assignedRoles as $rName) {
                        $badges .= "<span class='badge bg-dark-subtle text-dark border me-1 mb-1'>{$rName}</span>";
                    }
                    return $badges ?: "<span class='badge bg-light text-muted'>Superadmin Only</span>";
                })
                ->addColumn('status_switch', function ($row) {
                    $checked = $row->active ? 'checked' : '';
                    $statusText = $row->active ? 'Aktif' : 'Nonaktif';
                    return "<div class='form-check form-switch'>
                                <input class='form-check-input switch-toggle-status' type='checkbox' data-type='parent' data-id='{$row->id}' {$checked}>
                                <label class='form-check-label ms-1 fs-12 status-label-{$row->id}'>{$statusText}</label>
                            </div>";
                })
                ->addColumn('action', function ($row) {
                    $target = $row->getPermissionTarget();
                    $buttons = '';
                    if (auth()->user()->can("read {$target}")) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-info btn-menu-action me-1' data-action='view' data-menu='" . json_encode($row) . "' title='Detail'><i class='ti ti-eye'></i></button>";
                    }
                    if (auth()->user()->can("update {$target}")) {
                        $buttons .= "<button type='button' class='btn btn-sm btn-outline-warning btn-menu-action me-1' data-action='edit' data-menu='" . json_encode($row) . "' title='Edit'><i class='ti ti-edit'></i></button>";
                    }
                    if (auth()->user()->can("delete {$target}")) {
                        $buttons .= "<form action='" . route('admin.dukunganaplikasi.menu.destroy', $row->id) . "' method='POST' class='d-inline' onsubmit='return confirm(\"Hapus menu ini?\")'>
                                        " . csrf_field() . method_field('DELETE') . "
                                        <button type='submit' class='btn btn-sm btn-outline-danger' title='Hapus'><i class='ti ti-trash'></i></button>
                                    </form>";
                    }
                    return $buttons;
                })
                ->rawColumns(['name_formatted', 'route_url', 'permissions_formatted', 'roles_formatted', 'status_switch', 'action'])
                ->make(true);
        }

        $menus = Menu::with(['parent', 'subMenus.permissions.roles', 'permissions.roles'])
            ->parents()
            ->orderBy('orders', 'asc')
            ->get();

        $groupedMenus = $menus->groupBy(function ($item) {
            return !empty($item->category) ? strtoupper(trim($item->category)) : 'LAINNYA / UNCATEGORIZED';
        });

        $parentMenus = Menu::parents()->get();
        $permissions = Permission::all();
        $allRoles = Role::all();

        return view('admin.dukunganaplikasi.menu', compact('menus', 'groupedMenus', 'parentMenus', 'permissions', 'allRoles'));
    }

    /**
     * Redirect to index since CRUD uses modals.
     */
    public function create()
    {
        return redirect()->route('admin.dukunganaplikasi.menu.index');
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(MenuRequest $request)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active') ? 1 : 0;
        $validated['orders'] = $validated['orders'] ?? 0;

        $menu = Menu::create($validated);

        $actions = $request->input('actions', []);
        $rolesInput = $request->input('roles', ['superadmin', 'admin']);
        $this->syncMenuActions($menu, $actions, $rolesInput);

        $this->notifySuccess('Menu berhasil ditambahkan.');

        return redirect()->route('admin.dukunganaplikasi.menu.index');
    }

    /**
     * Redirect to index since CRUD uses modals.
     */
    public function edit(Menu $menu)
    {
        return redirect()->route('admin.dukunganaplikasi.menu.index');
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active') ? 1 : 0;
        $validated['orders'] = $validated['orders'] ?? 0;

        $menu->update($validated);

        $actions = $request->input('actions', []);
        $rolesInput = $request->input('roles', ['superadmin', 'admin']);
        $this->syncMenuActions($menu, $actions, $rolesInput);

        $this->notifySuccess('Menu berhasil diperbarui.');

        return redirect()->route('admin.dukunganaplikasi.menu.index');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        $this->notifySuccess('Menu berhasil dihapus.');

        return redirect()->route('admin.dukunganaplikasi.menu.index');
    }

    /**
     * Toggle active status per Category, Main Menu (Parent), or Sub-Menu.
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'type' => 'required|in:category,parent,submenu',
            'active' => 'required|boolean',
            'id' => 'nullable|exists:menus,id',
            'category' => 'nullable|string',
        ]);

        $type = $request->input('type');
        $active = (bool) $request->input('active');

        if ($type === 'category') {
            $categoryName = $request->input('category');

            // Fetch parent menus under this category
            $parentIds = Menu::whereRaw('UPPER(category) = ?', [strtoupper($categoryName)])->pluck('id')->toArray();

            // Update parent menus
            Menu::whereRaw('UPPER(category) = ?', [strtoupper($categoryName)])->update(['active' => $active]);

            // Update sub-menus under these parents
            if (!empty($parentIds)) {
                Menu::whereIn('main_menu_id', $parentIds)->update(['active' => $active]);
            }

            $msg = "Status seluruh menu pada Kategori \"{$categoryName}\" berhasil " . ($active ? 'diaktifkan' : 'dinonaktifkan') . '.';
        } elseif ($type === 'parent') {
            $menu = Menu::findOrFail($request->input('id'));
            $menu->update(['active' => $active]);

            // Cascade update all sub-menus under this main menu
            $menu->subMenus()->update(['active' => $active]);

            $msg = "Status Menu Utama \"{$menu->name}\" beserta seluruh sub-menunya berhasil " . ($active ? 'diaktifkan' : 'dinonaktifkan') . '.';
        } else { // submenu
            $menu = Menu::findOrFail($request->input('id'));
            $menu->update(['active' => $active]);

            $msg = "Status Sub-Menu \"{$menu->name}\" berhasil " . ($active ? 'diaktifkan' : 'dinonaktifkan') . '.';
        }

        // Clear menu cache & permission cache
        Cache::forget('menus');
        Cache::forget('urlMenu');
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json([
            'status' => 'success',
            'message' => $msg,
            'active' => $active,
        ]);
    }

    /**
     * Reorder menus via Drag and Drop (Category, Main Menu Parent, or Sub-Menu).
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'type' => 'required|in:category,parent,submenu',
            'items' => 'required|array',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $type = $request->input('type');
        $items = $request->input('items');

        if ($type === 'category') {
            // $items contains ordered category names
            $orderCounter = 1;
            foreach ($items as $categoryName) {
                $parentMenus = Menu::whereNull('main_menu_id')
                    ->whereRaw('UPPER(category) = ?', [strtoupper($categoryName)])
                    ->orderBy('orders')
                    ->get();

                foreach ($parentMenus as $menu) {
                    $menu->update(['orders' => $orderCounter++]);
                }
            }
            $msg = 'Urutan Kategori menu berhasil diperbarui.';
        } elseif ($type === 'parent') {
            // $items contains ordered parent menu IDs
            foreach ($items as $index => $id) {
                Menu::where('id', $id)->update(['orders' => $index + 1]);
            }
            $msg = 'Urutan Menu Utama berhasil diperbarui.';
        } else { // submenu
            // $items contains ordered sub-menu IDs
            foreach ($items as $index => $id) {
                Menu::where('id', $id)->update(['orders' => $index + 1]);
            }
            $msg = 'Urutan Sub-Menu berhasil diperbarui.';
        }

        // Clear menu cache
        Cache::forget('menus');
        Cache::forget('urlMenu');
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json([
            'status' => 'success',
            'message' => $msg,
        ]);
    }
}
