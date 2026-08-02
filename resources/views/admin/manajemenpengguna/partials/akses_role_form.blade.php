<div class="card border mb-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
        <span class="fw-semibold text-dark fs-13">
            <i class="ti ti-shield-lock me-1 text-primary"></i> Matriks Otorisasi Permisi Sistem (Spatie Permission)
        </span>
        <div class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox" id="check_all_permissions" style="cursor: pointer;">
            <label class="form-check-label fw-bold text-primary fs-12 ms-1" for="check_all_permissions" style="cursor: pointer;">
                Pilih Semua Permission
            </label>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0" id="matrix-permission-table">
                <thead class="table-dark fs-12 text-center text-uppercase">
                    <tr>
                        <th class="text-start ps-3" style="min-width: 260px;">MODUL / FITUR APLIKASI</th>
                        <th style="width: 90px;" class="text-success">CREATE</th>
                        <th style="width: 90px;" class="text-info">READ</th>
                        <th style="width: 90px;" class="text-warning">UPDATE</th>
                        <th style="width: 90px;" class="text-danger">DELETE</th>
                        <th style="min-width: 140px;" class="text-secondary">LAINNYA</th>
                        <th style="width: 90px;" class="bg-primary text-white">SEMUA</th>
                    </tr>
                </thead>
                <tbody class="fs-13">
                    @php
                        // Group all registered permissions by their module target slug (e.g. "manajemenpengguna/role")
                        $groupedPerms = $permissions->groupBy(function ($perm) {
                            $parts = explode(' ', $perm->name, 2);
                            return $parts[1] ?? 'Lainnya';
                        });
                    @endphp

                    @forelse ($groupedPerms as $moduleTarget => $permList)
                        @php
                            $linkedMenu = $permList->flatMap->menus->first();
                            $createPerm = $permList->first(fn($p) => str_starts_with(strtolower($p->name), 'create'));
                            $readPerm   = $permList->first(fn($p) => str_starts_with(strtolower($p->name), 'read'));
                            $updatePerm = $permList->first(fn($p) => str_starts_with(strtolower($p->name), 'update'));
                            $deletePerm = $permList->first(fn($p) => str_starts_with(strtolower($p->name), 'delete'));
                            $otherPerms = $permList->filter(function($p) {
                                $first = strtolower(explode(' ', $p->name)[0] ?? '');
                                return !in_array($first, ['create', 'read', 'update', 'delete']);
                            });
                        @endphp
                        <tr class="matrix-row">
                            <td class="ps-3 py-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark font-monospace border fs-12 px-2 py-1 shadow-sm me-2">
                                        {{ $moduleTarget }}
                                    </span>
                                    @if ($linkedMenu)
                                        <span class="fw-semibold text-muted fs-12">({{ $linkedMenu->name }})</span>
                                    @endif
                                </div>
                            </td>
                            <!-- CREATE -->
                            <td class="text-center py-2">
                                @if ($createPerm)
                                    <input type="checkbox" name="permissions[]" value="{{ $createPerm->name }}" class="form-check-input role-permission-checkbox check-row-item" style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em; cursor: pointer;">
                                @else
                                    <span class="text-muted fs-12">-</span>
                                @endif
                            </td>
                            <!-- READ -->
                            <td class="text-center py-2">
                                @if ($readPerm)
                                    <input type="checkbox" name="permissions[]" value="{{ $readPerm->name }}" class="form-check-input role-permission-checkbox check-row-item" style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em; cursor: pointer;">
                                @else
                                    <span class="text-muted fs-12">-</span>
                                @endif
                            </td>
                            <!-- UPDATE -->
                            <td class="text-center py-2">
                                @if ($updatePerm)
                                    <input type="checkbox" name="permissions[]" value="{{ $updatePerm->name }}" class="form-check-input role-permission-checkbox check-row-item" style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em; cursor: pointer;">
                                @else
                                    <span class="text-muted fs-12">-</span>
                                @endif
                            </td>
                            <!-- DELETE -->
                            <td class="text-center py-2">
                                @if ($deletePerm)
                                    <input type="checkbox" name="permissions[]" value="{{ $deletePerm->name }}" class="form-check-input role-permission-checkbox check-row-item" style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em; cursor: pointer;">
                                @else
                                    <span class="text-muted fs-12">-</span>
                                @endif
                            </td>
                            <!-- LAINNYA -->
                            <td class="py-2">
                                @if ($otherPerms->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($otherPerms as $op)
                                            <div class="form-check m-0">
                                                <input type="checkbox" name="permissions[]" value="{{ $op->name }}" id="perm_{{ $op->id }}" class="form-check-input role-permission-checkbox check-row-item" style="border: 2px solid #475569 !important; width: 1.1em; height: 1.1em; cursor: pointer;">
                                                <label class="form-check-label fs-12" for="perm_{{ $op->id }}">{{ $op->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fs-12 text-center d-block">-</span>
                                @endif
                            </td>
                            <!-- SEMUA BARIS -->
                            <td class="text-center py-2 bg-light">
                                <input type="checkbox" class="form-check-input check-row-all" style="border: 2px solid #0d6efd !important; width: 1.3em; height: 1.3em; cursor: pointer;" title="Pilih Semua di baris ini">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data permission yang terdaftar di sistem.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
