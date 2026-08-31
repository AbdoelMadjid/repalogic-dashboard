<style>
    /* High-contrast, clear checkbox styling for permission matrix */
    #permission-matrix-table .form-check-input,
    #check_all_permissions {
        width: 1.25em;
        height: 1.25em;
        border: 2px solid #475569 !important;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    }

    #permission-matrix-table .form-check-input:checked,
    #check_all_permissions:checked {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
    }

    #permission-matrix-table .form-check-input:hover,
    #check_all_permissions:hover {
        border-color: #0f172a !important;
    }
</style>

<div class="row">
    <div class="col-12 mb-2">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <label class="form-label fw-semibold m-0">Hak Akses Permission Spatie (Aksi CRUD Per Modul / Fitur)</label>
            <div class="form-check form-check-inline m-0">
                <input class="form-check-input cursor-pointer" type="checkbox" id="check_all_permissions">
                <label class="form-check-label fs-12 fw-semibold cursor-pointer" for="check_all_permissions">Pilih Semua Permission</label>
            </div>
        </div>

        <div class="border rounded bg-white">
            <table class="table table-hover align-middle mb-0" id="permission-matrix-table">
                <thead class="table-light align-middle text-center text-nowrap">
                    <tr class="text-uppercase fs-12 fw-bold text-muted border-bottom align-middle text-center text-nowrap">
                        <th class="py-3 text-center align-middle text-nowrap" style="min-width: 280px;">MODUL / FITUR</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 80px;">CREATE</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 80px;">READ</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 80px;">UPDATE</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 80px;">DELETE</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 90px;">LAINNYA</th>
                        <th class="text-center py-3 align-middle text-nowrap" style="width: 80px;">SEMUA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parentMenus as $pMenu)
                        @php
                            $pTarget = $pMenu->getPermissionTarget();
                            $pPerms = $pMenu->permissions->keyBy(function($p) {
                                return explode(' ', $p->name)[0];
                            });
                            $pOtherPerms = $pMenu->permissions->reject(function($p) {
                                return in_array(explode(' ', $p->name)[0], ['create', 'read', 'update', 'delete']);
                            });
                        @endphp
                        <!-- MAIN MENU ROW -->
                        <tr class="menu-row parent-row" data-menu-id="{{ $pMenu->id }}">
                            <td class="ps-3 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2 d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-3 flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="{{ $pMenu->icon ?: 'ti ti-folder' }} fs-18"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center flex-wrap gap-1">
                                            <span class="fw-bold text-dark fs-14">{{ $pMenu->name }}</span>
                                            <span class="badge bg-light text-muted font-monospace border fs-11 ms-1">{{ $pTarget }}</span>
                                        </div>
                                        <div class="mt-1">
                                            <span class="badge bg-light text-secondary border fs-10"><i class="ti ti-home me-1"></i>Menu Utama</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- ACTION COLUMNS -->
                            @foreach (['create', 'read', 'update', 'delete'] as $act)
                                <td class="text-center py-2">
                                    @if (isset($pPerms[$act]))
                                        <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $pMenu->id }} cursor-pointer"
                                            type="checkbox" name="permissions[]" value="{{ $pPerms[$act]->name }}" id="perm_{{ $pPerms[$act]->id }}"
                                            data-menu-id="{{ $pMenu->id }}" data-action="{{ $act }}">
                                    @else
                                        <span class="text-muted fs-12">-</span>
                                    @endif
                                </td>
                            @endforeach

                            <!-- LAINNYA COLUMN -->
                            <td class="text-center py-2">
                                @if ($pOtherPerms->count() > 0)
                                    @foreach ($pOtherPerms as $oPerm)
                                        <div class="form-check d-inline-block m-0">
                                            <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $pMenu->id }} cursor-pointer"
                                                type="checkbox" name="permissions[]" value="{{ $oPerm->name }}" id="perm_{{ $oPerm->id }}" title="{{ $oPerm->name }}"
                                                data-menu-id="{{ $pMenu->id }}" data-action="other">
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted fs-12">-</span>
                                @endif
                            </td>

                            <!-- ROW ALL COLUMN -->
                            <td class="text-center py-2 pe-3">
                                <input class="form-check-input check-row-all cursor-pointer" type="checkbox" data-target-class="row-perm-{{ $pMenu->id }}" data-menu-id="{{ $pMenu->id }}" title="Pilih Semua Aksi untuk {{ $pMenu->name }}">
                            </td>
                        </tr>

                        <!-- SUB MENUS (LEVEL 2) -->
                        @foreach ($pMenu->subMenus as $cMenu)
                            @php
                                $cTarget = $cMenu->getPermissionTarget();
                                $cPerms = $cMenu->permissions->keyBy(function($p) {
                                    return explode(' ', $p->name)[0];
                                });
                                $cOtherPerms = $cMenu->permissions->reject(function($p) {
                                    return in_array(explode(' ', $p->name)[0], ['create', 'read', 'update', 'delete']);
                                });
                            @endphp
                            <tr class="menu-row child-row" data-menu-id="{{ $cMenu->id }}" data-parent-menu-id="{{ $pMenu->id }}">
                                <td class="ps-4 py-2">
                                    <div class="d-flex align-items-center ps-2">
                                        <span class="text-muted me-2 font-monospace fs-14">└─</span>
                                        <div class="avatar-xs me-2 d-flex align-items-center justify-content-center bg-info-subtle text-info rounded-3 flex-shrink-0" style="width: 28px; height: 28px;">
                                            <i class="{{ $cMenu->icon ?: 'ti ti-category' }} fs-15"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <span class="fw-bold text-dark fs-13">{{ $cMenu->name }}</span>
                                                <span class="badge bg-light text-muted font-monospace border fs-11 ms-1">{{ $cTarget }}</span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-10"><i class="ti ti-corner-down-right me-1"></i>Sub: {{ $pMenu->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                @foreach (['create', 'read', 'update', 'delete'] as $act)
                                    <td class="text-center py-2">
                                        @if (isset($cPerms[$act]))
                                            <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $cMenu->id }} cursor-pointer"
                                                type="checkbox" name="permissions[]" value="{{ $cPerms[$act]->name }}" id="perm_{{ $cPerms[$act]->id }}"
                                                data-menu-id="{{ $cMenu->id }}" data-parent-menu-id="{{ $pMenu->id }}" data-action="{{ $act }}">
                                        @else
                                            <span class="text-muted fs-12">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="text-center py-2">
                                    @if ($cOtherPerms->count() > 0)
                                        @foreach ($cOtherPerms as $oPerm)
                                            <div class="form-check d-inline-block m-0">
                                                <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $cMenu->id }} cursor-pointer"
                                                    type="checkbox" name="permissions[]" value="{{ $oPerm->name }}" id="perm_{{ $oPerm->id }}" title="{{ $oPerm->name }}"
                                                    data-menu-id="{{ $cMenu->id }}" data-parent-menu-id="{{ $pMenu->id }}" data-action="other">
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted fs-12">-</span>
                                    @endif
                                </td>

                                <td class="text-center py-2 pe-3">
                                    <input class="form-check-input check-row-all cursor-pointer" type="checkbox" data-target-class="row-perm-{{ $cMenu->id }}" data-menu-id="{{ $cMenu->id }}" data-parent-menu-id="{{ $pMenu->id }}" title="Pilih Semua Aksi untuk {{ $cMenu->name }}">
                                </td>
                            </tr>

                            <!-- LEVEL 3 SUB-MENUS IF ANY -->
                            @if ($cMenu->subMenus && $cMenu->subMenus->count() > 0)
                                @foreach ($cMenu->subMenus as $scMenu)
                                    @php
                                        $scTarget = $scMenu->getPermissionTarget();
                                        $scPerms = $scMenu->permissions->keyBy(function($p) {
                                            return explode(' ', $p->name)[0];
                                        });
                                        $scOtherPerms = $scMenu->permissions->reject(function($p) {
                                            return in_array(explode(' ', $p->name)[0], ['create', 'read', 'update', 'delete']);
                                        });
                                    @endphp
                                    <tr class="menu-row sub-child-row" data-menu-id="{{ $scMenu->id }}" data-parent-menu-id="{{ $cMenu->id }}" data-root-parent-id="{{ $pMenu->id }}">
                                        <td class="ps-5 py-2">
                                            <div class="d-flex align-items-center ps-3">
                                                <span class="text-muted me-2 font-monospace fs-14">└─ └─</span>
                                                <div class="avatar-xs me-2 d-flex align-items-center justify-content-center bg-purple-subtle text-purple rounded-3 flex-shrink-0" style="width: 26px; height: 26px;">
                                                    <i class="{{ $scMenu->icon ?: 'ti ti-dots-vertical' }} fs-14"></i>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center flex-wrap gap-1">
                                                        <span class="fw-bold text-dark fs-13">{{ $scMenu->name }}</span>
                                                        <span class="badge bg-light text-muted font-monospace border fs-11 ms-1">{{ $scTarget }}</span>
                                                    </div>
                                                    <div class="mt-1">
                                                        <span class="badge bg-purple-subtle text-purple border border-purple-subtle fs-10"><i class="ti ti-corner-down-right me-1"></i>Sub: {{ $cMenu->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        @foreach (['create', 'read', 'update', 'delete'] as $act)
                                            <td class="text-center py-2">
                                                @if (isset($scPerms[$act]))
                                                    <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $scMenu->id }} cursor-pointer"
                                                        type="checkbox" name="permissions[]" value="{{ $scPerms[$act]->name }}" id="perm_{{ $scMenu->id }}"
                                                        data-menu-id="{{ $scMenu->id }}" data-parent-menu-id="{{ $cMenu->id }}" data-root-parent-id="{{ $pMenu->id }}" data-action="{{ $act }}">
                                                @else
                                                    <span class="text-muted fs-12">-</span>
                                                @endif
                                            </td>
                                        @endforeach

                                        <td class="text-center py-2">
                                            @if ($scOtherPerms->count() > 0)
                                                @foreach ($scOtherPerms as $oPerm)
                                                    <div class="form-check d-inline-block m-0">
                                                        <input class="form-check-input role-input role-permission-checkbox row-perm-{{ $scMenu->id }} cursor-pointer"
                                                            type="checkbox" name="permissions[]" value="{{ $oPerm->name }}" id="perm_{{ $oPerm->id }}" title="{{ $oPerm->name }}"
                                                            data-menu-id="{{ $scMenu->id }}" data-parent-menu-id="{{ $cMenu->id }}" data-root-parent-id="{{ $pMenu->id }}" data-action="other">
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted fs-12">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center py-2 pe-3">
                                            <input class="form-check-input check-row-all cursor-pointer" type="checkbox" data-target-class="row-perm-{{ $scMenu->id }}" data-menu-id="{{ $scMenu->id }}" data-parent-menu-id="{{ $cMenu->id }}" data-root-parent-id="{{ $pMenu->id }}" title="Pilih Semua Aksi untuk {{ $scMenu->name }}">
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach

                    <!-- OTHER STANDALONE PERMISSIONS IF ANY -->
                    @if (isset($otherPermissions) && $otherPermissions->count() > 0)
                        <tr class="table-light border-top border-bottom">
                            <td colspan="7" class="fw-bold fs-12 text-uppercase text-muted ps-3 py-2">PERMISSION SISTEM LAINNYA</td>
                        </tr>
                        <tr class="menu-row">
                            <td class="ps-3 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2 d-flex align-items-center justify-content-center bg-secondary-subtle text-secondary rounded-3" style="width: 32px; height: 32px;">
                                        <i class="ti ti-shield-lock fs-18"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-13">Permission Standalone</div>
                                        <span class="badge bg-light text-muted font-monospace border fs-11">system/standalone</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center py-2" colspan="4"><span class="text-muted fs-12">-</span></td>
                            <td class="text-center py-2">
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    @foreach ($otherPermissions as $oPerm)
                                        <div class="form-check form-check-inline m-0">
                                            <input class="form-check-input role-input role-permission-checkbox row-perm-other cursor-pointer"
                                                type="checkbox" name="permissions[]" value="{{ $oPerm->name }}" id="perm_{{ $oPerm->id }}">
                                            <label class="form-check-label fs-12 cursor-pointer" for="perm_{{ $oPerm->id }}">{{ $oPerm->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center py-2 pe-3">
                                <input class="form-check-input check-row-all cursor-pointer" type="checkbox" data-target-class="row-perm-other" title="Pilih Semua Permission Standalone">
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
