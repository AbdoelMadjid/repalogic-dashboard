@extends('layouts.vertical')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Manajemen Hak Akses Pengguna (User Access Assignment)</h4>
                            <p class="text-muted fs-12 mb-0">
                                Kelola penugasan Peran (Role) dan Izin Khusus Langsung (Direct Permissions) per pengguna individual.
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- DATATABLES HEADER CONTROLS (JUMLAH BARIS & LIVE SEARCH) -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm datatable-length-select" style="width: 120px;">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <div class="d-flex align-items-center datatable-search-input">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Pengguna:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama atau email user...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="akses-user-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;" class="text-center">#</th>
                                        <th>Identitas Pengguna</th>
                                        <th style="width: 160px;" class="text-center">Peran Utama (Role)</th>
                                        <th style="width: 160px;" class="text-center">Izin Langsung (Direct)</th>
                                        <th style="width: 150px;" class="text-center">Total Akses Aktif</th>
                                        <th style="width: 140px;" class="text-center text-nowrap">Aksi Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="akses-user-row">
                                            <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fs-13 fw-semibold">{{ $user->name }}</h6>
                                                        <span class="text-muted fs-12">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-2">
                                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                    @forelse ($user->roles as $role)
                                                        @php
                                                            $badgeClass = match ($role->name) {
                                                                'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                                'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} border fs-11 text-capitalize">
                                                            <i class="ti ti-shield me-1"></i>{{ $role->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted fs-12">- Tanpa Role -</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center py-2">
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-12">
                                                    <i class="ti ti-key me-1"></i>{{ $user->permissions->count() }} Direct
                                                </span>
                                            </td>
                                            <td class="text-center py-2">
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12 fw-semibold">
                                                    <i class="ti ti-check me-1"></i>{{ $user->getAllPermissions()->count() }} Akses
                                                </span>
                                            </td>
                                            <td class="text-center py-2 text-nowrap">
                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                    @can('read manajemenpengguna/akses-user')
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-akses-user-trigger" data-action="view" data-user='@json($user)' title="Lihat Detail Akses"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update manajemenpengguna/akses-user')
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-akses-user-trigger" data-action="edit" data-user='@json($user)' title="Atur Akses Pengguna"><i class="ti ti-key"></i></button>
                                                    @endcan
                                                    @can('delete manajemenpengguna/akses-user')
                                                        <form action="{{ route('admin.manajemenpengguna.akses-user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kosongkan seluruh izin khusus langsung (direct permissions) untuk user {{ $user->name }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Reset Izin Langsung"><i class="ti ti-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ $users->count() }}</strong> pengguna
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <ul class="pagination pagination-sm m-0" id="table-pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SINGLE UNIFIED MODAL (ATUR & DETAIL HAK AKSES PENGGUNA) -->
    <div class="modal fade" id="aksesUserModal" tabindex="-1" aria-labelledby="aksesUserModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="aksesUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="aksesUserModalTitle"><i class="ti ti-key me-1"></i> Atur Hak Akses Individual Pengguna</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-info fs-13 d-flex align-items-center mb-3">
                            <i class="ti ti-info-circle fs-18 me-2"></i>
                            <div>
                                Anda dapat menugaskan <strong>Role Utama</strong> dan memberikan <strong>Izin Khusus Langsung (Direct Permissions)</strong> secara opsional untuk pengguna <strong id="modal_user_name_display">...</strong>.
                            </div>
                        </div>

                        @include('admin.manajemenpengguna.partials.akses_user_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Hak Akses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            let pageSize = 25;

            const searchInput = document.getElementById('table-search-input');
            const lengthSelect = document.getElementById('table-length-select');
            const tableInfoBar = document.getElementById('table-info-bar');
            const paginationUl = document.getElementById('table-pagination');

            function updateTableDisplay() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const selectedLength = lengthSelect ? lengthSelect.value : '25';
                pageSize = selectedLength === 'all' ? Infinity : parseInt(selectedLength, 10);

                let matchingRows = [];
                document.querySelectorAll('.akses-user-row').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (query === '' || text.includes(query)) {
                        matchingRows.push(row);
                    } else {
                        row.style.display = 'none';
                    }
                });

                const totalMatching = matchingRows.length;
                const totalPages = pageSize === Infinity ? 1 : (Math.ceil(totalMatching / pageSize) || 1);

                if (currentPage > totalPages) currentPage = totalPages;
                if (currentPage < 1) currentPage = 1;

                const startIndex = pageSize === Infinity ? 0 : (currentPage - 1) * pageSize;
                const endIndex = pageSize === Infinity ? totalMatching : Math.min(startIndex + pageSize, totalMatching);

                matchingRows.forEach((row, index) => {
                    if (index >= startIndex && index < endIndex) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (tableInfoBar) {
                    if (totalMatching === 0) {
                        tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> pengguna';
                    } else if (pageSize === Infinity) {
                        tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> pengguna`;
                    } else {
                        tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> pengguna`;
                    }
                }

                renderPagination(totalPages);
            }

            function renderPagination(totalPages) {
                if (!paginationUl) return;

                if (totalPages <= 1 || pageSize === Infinity) {
                    paginationUl.innerHTML = '';
                    return;
                }

                let html = '';
                const prevDisabled = currentPage === 1 ? ' disabled' : '';
                html += `<li class="page-item${prevDisabled}" data-page="1" title="Halaman Awal"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-left fs-14"></i></a></li>`;
                html += `<li class="page-item${prevDisabled}" data-page="${currentPage - 1}" title="Sebelumnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left fs-14"></i></a></li>`;

                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                for (let p = startPage; p <= endPage; p++) {
                    const activeClass = p === currentPage ? ' active' : '';
                    html += `<li class="page-item${activeClass}" data-page="${p}"><a class="page-link" href="javascript:void(0);">${p}</a></li>`;
                }

                const nextDisabled = currentPage === totalPages ? ' disabled' : '';
                html += `<li class="page-item${nextDisabled}" data-page="${currentPage + 1}" title="Berikutnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right fs-14"></i></a></li>`;
                html += `<li class="page-item${nextDisabled}" data-page="${totalPages}" title="Halaman Akhir"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-right fs-14"></i></a></li>`;

                paginationUl.innerHTML = html;

                paginationUl.querySelectorAll('.page-item:not(.disabled)').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetPage = parseInt(this.getAttribute('data-page'), 10);
                        if (targetPage && targetPage !== currentPage) {
                            currentPage = targetPage;
                            updateTableDisplay();
                        }
                    });
                });
            }

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function() {
                    currentPage = 1;
                    updateTableDisplay();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    currentPage = 1;
                    updateTableDisplay();
                });
            }

            updateTableDisplay();

            // Modal & Action Handlers (Event Delegation)
            const aksesUserModalElement = document.getElementById('aksesUserModal');
            const aksesUserModal = new bootstrap.Modal(aksesUserModalElement);
            const aksesUserForm = document.getElementById('aksesUserForm');
            const modalTitle = document.getElementById('aksesUserModalTitle');
            const modalUserNameDisplay = document.getElementById('modal_user_name_display');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.user-role-checkbox, .user-permission-checkbox, .check-user-row-all, #check_all_user_permissions');

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-akses-user-trigger');
                if (!btn) return;
                e.preventDefault();

                const action = btn.getAttribute('data-action');
                const userDataRaw = btn.getAttribute('data-user');
                const user = userDataRaw ? JSON.parse(userDataRaw) : null;

                if (!user) return;

                formInputs.forEach(input => input.disabled = false);
                btnSubmitForm.classList.remove('d-none');

                document.querySelectorAll('.user-role-checkbox, .user-permission-checkbox, .check-user-row-all, #check_all_user_permissions').forEach(cb => {
                    cb.checked = false;
                });

                document.getElementById('form_user_name').value = user.name || '';
                document.getElementById('form_user_email').value = user.email || '';
                modalUserNameDisplay.textContent = `${user.name} (${user.email})`;
                aksesUserForm.action = `{{ url('admin/manajemenpengguna/akses-user') }}/${user.id}`;

                // 1. Check active roles (supports role_names string array or roles object array)
                const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
                userRoles.forEach(rName => {
                    const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
                    roleCb.forEach(cb => cb.checked = true);
                });

                // 2. Check active permissions (supports all_permission_names, direct_permission_names, or permissions)
                const userPerms = user.all_permission_names || user.direct_permission_names || (user.permissions ? user.permissions.map(p => p.name || p) : []);
                userPerms.forEach(pName => {
                    const permCb = document.querySelectorAll(`input[name="permissions[]"][value="${pName}"]`);
                    permCb.forEach(cb => cb.checked = true);
                });

                updateUserRowAllStates();
                updateUserCheckAllState();

                if (action === 'edit') {
                    modalTitle.innerHTML = `<i class="ti ti-key me-1"></i> Atur Hak Akses Pengguna: ${user.name}`;
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Hak Akses';

                } else if (action === 'view') {
                    modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Hak Akses Pengguna: ${user.name}`;
                    btnSubmitForm.classList.add('d-none');
                    formInputs.forEach(input => input.disabled = true);
                }

                aksesUserModal.show();
            });

            // Master "Pilih Semua Permission" checkbox
            const checkAllUserMaster = document.getElementById('check_all_user_permissions');
            if (checkAllUserMaster) {
                checkAllUserMaster.addEventListener('change', function() {
                    const isChecked = this.checked;
                    document.querySelectorAll('.user-permission-checkbox, .check-user-row-all').forEach(cb => {
                        if (!cb.disabled) cb.checked = isChecked;
                    });
                });
            }

            // Per-row "SEMUA" checkboxes
            document.querySelectorAll('.check-user-row-all').forEach(rowAll => {
                rowAll.addEventListener('change', function() {
                    const tr = this.closest('tr');
                    if (tr) {
                        const rowItems = tr.querySelectorAll('.check-user-row-item');
                        rowItems.forEach(cb => {
                            if (!cb.disabled) cb.checked = this.checked;
                        });
                    }
                    updateUserCheckAllState();
                });
            });

            function updateUserRowAllStates() {
                document.querySelectorAll('.user-matrix-row').forEach(tr => {
                    const items = tr.querySelectorAll('.check-user-row-item');
                    const checkedItems = tr.querySelectorAll('.check-user-row-item:checked');
                    const rowAll = tr.querySelector('.check-user-row-all');
                    if (rowAll && items.length > 0) {
                        rowAll.checked = items.length === checkedItems.length;
                    }
                });
            }

            function updateUserCheckAllState() {
                const totalItems = document.querySelectorAll('.check-user-row-item').length;
                const checkedItems = document.querySelectorAll('.check-user-row-item:checked').length;
                if (checkAllUserMaster && totalItems > 0) {
                    checkAllUserMaster.checked = totalItems === checkedItems;
                }
            }

            document.querySelectorAll('.check-user-row-item').forEach(item => {
                item.addEventListener('change', function() {
                    updateUserRowAllStates();
                    updateUserCheckAllState();
                });
            });
        });
    </script>
@endsection
