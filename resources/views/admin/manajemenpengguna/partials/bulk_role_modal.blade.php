<!-- MODAL ATUR PERAN (BULK & QUICK ROLE ASSIGNMENT) -->
<div class="modal fade" id="bulkRoleModal" tabindex="-1" aria-labelledby="bulkRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="bulkRoleModalLabel">
                    <i class="ti ti-shield-check fs-20"></i>
                    <span id="bulkRoleModalTitleText">Atur Peran (Role) Pengguna</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formBulkAssignRole" action="{{ route('admin.manajemenpengguna.users.bulk-assign-role') }}" method="POST">
                @csrf
                <div id="bulkRoleUserIdsContainer"></div>

                <div class="modal-body p-4">
                    <!-- TARGET USER PREVIEW (SINGLE USER BANNER vs BULK CHIPS) -->
                    <div class="mb-4">
                        <!-- Single User Profile View -->
                        <div id="singleUserRoleCard" class="p-3 bg-light-subtle rounded-3 border d-none">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-3">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-2.5 gap-md-3">
                                    <img src="" id="singleUserAvatar" alt="Avatar" class="rounded-circle border object-fit-cover shadow-sm flex-shrink-0" style="width: 52px; height: 52px;">
                                    <div class="d-flex flex-column align-items-center align-items-md-start">
                                        <h6 class="mb-0.5 fs-15 fw-bold text-dark text-center text-md-start" id="singleUserName">-</h6>
                                        <span class="text-muted fs-12 text-center text-md-start" id="singleUserEmail">-</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center align-items-md-end">
                                    <span class="text-muted fs-11 d-block mb-1 fw-semibold text-center text-md-end">Role Saat Ini:</span>
                                    <div id="singleUserCurrentRoles" class="d-flex flex-wrap justify-content-center justify-content-md-end gap-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Multi Users (Bulk) Chips View -->
                        <div id="multiUserRoleBox" class="d-none">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold text-dark fs-13 mb-0">
                                    <i class="ti ti-users me-1 text-primary"></i> Pengguna yang Akan Diperbarui:
                                </label>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 px-2.5 py-1" id="bulkRoleUserCountBadge">
                                    0 Pengguna
                                </span>
                            </div>
                            <div class="p-3 bg-light-subtle rounded-3 border d-flex flex-wrap gap-2 align-items-center" id="bulkRoleUserChipsList" style="max-height: 130px; overflow-y: auto;">
                                <!-- Populated dynamically via JS -->
                            </div>
                        </div>
                    </div>

                    <!-- PILIHAN MODE TINDAKAN (ACTION MODE) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark fs-13 mb-2">
                            <i class="ti ti-settings-cog me-1 text-primary"></i> Pilih Mode Penetapan Peran:
                        </label>
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="card h-100 p-3 border rounded-3 cursor-pointer role-mode-card shadow-none active-mode" for="mode_sync">
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input role-mode-radio" type="radio" name="action_mode" id="mode_sync" value="sync" checked>
                                        <span class="form-check-label fw-bold text-dark fs-13">
                                            Ganti Semua Role
                                        </span>
                                    </div>
                                    <p class="text-muted fs-11 mb-0 mt-2">
                                        Menggantikan seluruh role pengguna dengan pilihan di bawah.
                                    </p>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="card h-100 p-3 border rounded-3 cursor-pointer role-mode-card shadow-none" for="mode_append">
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input role-mode-radio" type="radio" name="action_mode" id="mode_append" value="append">
                                        <span class="form-check-label fw-bold text-dark fs-13">
                                            Tambahkan Role
                                        </span>
                                    </div>
                                    <p class="text-muted fs-11 mb-0 mt-2">
                                        Menambahkan role baru tanpa menghapus role yang sudah ada.
                                    </p>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="card h-100 p-3 border rounded-3 cursor-pointer role-mode-card shadow-none" for="mode_remove">
                                    <div class="form-check m-0 d-flex align-items-center gap-2">
                                        <input class="form-check-input role-mode-radio" type="radio" name="action_mode" id="mode_remove" value="remove">
                                        <span class="form-check-label fw-bold text-danger fs-13">
                                            Cabut Role Tertentu
                                        </span>
                                    </div>
                                    <p class="text-muted fs-11 mb-0 mt-2">
                                        Mencabut role yang dicentang dari akun pengguna terpilih.
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- DAFTAR ROLE TERSEDIA -->
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold text-dark fs-13 mb-0">
                                <i class="ti ti-shield me-1 text-primary"></i> Pilih Peran / Role yang Diterapkan:
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none fs-12 fw-semibold" id="btn-select-all-modal-roles">Pilih Semua</button>
                                <span class="text-muted fs-12">|</span>
                                <button type="button" class="btn btn-link btn-sm text-secondary p-0 text-decoration-none fs-12" id="btn-clear-modal-roles">Kosongkan</button>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 border">
                            <div class="row g-3">
                                @forelse ($roles as $r)
                                    @php
                                        $badgeClass = match ($r->name) {
                                            'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                            'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                            'user' => 'bg-info-subtle text-info border-info-subtle',
                                            default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                        };
                                    @endphp
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input bulk-role-checkbox m-0 flex-shrink-0" type="checkbox" name="roles[]" value="{{ $r->name }}" id="bulk_role_{{ $r->id }}" style="cursor: pointer;">
                                            <label class="form-check-label user-select-none cursor-pointer mb-0" for="bulk_role_{{ $r->id }}">
                                                <span class="badge {{ $badgeClass }} border fs-12 text-capitalize">
                                                    <i class="ti ti-shield me-1"></i>{{ $r->name }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted fs-12 text-center py-2">Belum ada role sistem yang terdaftar.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2.5 px-4 d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold px-3" id="btnSubmitBulkRole">
                        <i class="ti ti-device-floppy me-1"></i> Terapkan Role Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
