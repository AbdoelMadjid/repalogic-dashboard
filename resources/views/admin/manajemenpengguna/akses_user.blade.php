@extends('layouts.vertical', ['title' => 'Akses User'])

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Akses User'])
    <div class="container-fluid mt-2">
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
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 60px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Identitas Pengguna</th>
                                        <th class="text-center align-middle text-nowrap">Peran Utama (Role)</th>
                                        <th class="text-center align-middle text-nowrap">Izin Langsung (Direct)</th>
                                        <th class="text-center align-middle text-nowrap">Total Akses Aktif</th>
                                        <th style="width: 140px;" class="text-center align-middle text-nowrap">Aksi Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="akses-user-row">
                                            <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle me-2 object-fit-cover border" style="width: 38px; height: 38px; object-fit: cover; object-position: top;">
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
                                                        <form action="{{ route('admin.manajemenpengguna.akses-user.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Kosongkan seluruh izin khusus langsung (direct permissions) untuk user {{ $user->name }}?">
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

            // Master "Pilih Semua Permission" checkbox
            const checkAllPerms = document.getElementById('check_all_permissions');
            if (checkAllPerms) {
                checkAllPerms.addEventListener('change', function() {
                    const isChecked = this.checked;
                    document.querySelectorAll('.role-permission-checkbox, .check-row-all').forEach(cb => {
                        if (!cb.disabled) {
                            cb.checked = isChecked;
                        }
                    });
                    syncAllParentMenuStates();
                });
            }

            // Helper to automatically sync all parent menu states (check if any submenu is checked, uncheck completely if all submenus are unchecked)
            function syncAllParentMenuStates() {
                // 1. Process Level 2 submenus that have Level 3 children
                document.querySelectorAll('.child-row[data-menu-id]').forEach(row => {
                    const cMenuId = row.getAttribute('data-menu-id');
                    const level3Children = document.querySelectorAll(`.role-permission-checkbox[data-parent-menu-id="${cMenuId}"]`);
                    if (level3Children.length > 0) {
                        const checkedLevel3 = document.querySelectorAll(`.role-permission-checkbox[data-parent-menu-id="${cMenuId}"]:checked`);
                        if (checkedLevel3.length > 0) {
                            let readCb = row.querySelector(`.role-permission-checkbox[data-action="read"]`) || row.querySelector(`.role-permission-checkbox`);
                            if (readCb && !readCb.disabled) readCb.checked = true;
                        } else {
                            row.querySelectorAll('.role-permission-checkbox').forEach(cb => {
                                if (!cb.disabled) cb.checked = false;
                            });
                        }
                    }
                });

                // 2. Process Level 1 Menu Utama (parents)
                document.querySelectorAll('.parent-row[data-menu-id]').forEach(row => {
                    const pMenuId = row.getAttribute('data-menu-id');
                    const allChildren = document.querySelectorAll(
                        `.role-permission-checkbox[data-parent-menu-id="${pMenuId}"], ` +
                        `.role-permission-checkbox[data-root-parent-id="${pMenuId}"]`
                    );
                    if (allChildren.length > 0) {
                        const checkedChildren = document.querySelectorAll(
                            `.role-permission-checkbox[data-parent-menu-id="${pMenuId}"]:checked, ` +
                            `.role-permission-checkbox[data-root-parent-id="${pMenuId}"]:checked`
                        );
                        if (checkedChildren.length > 0) {
                            let readCb = row.querySelector(`.role-permission-checkbox[data-action="read"]`) || row.querySelector(`.role-permission-checkbox`);
                            if (readCb && !readCb.disabled) readCb.checked = true;
                        } else {
                            row.querySelectorAll('.role-permission-checkbox').forEach(cb => {
                                if (!cb.disabled) cb.checked = false;
                            });
                        }
                    }
                });
            }

            // Permission Row Check All & Individual Permission Checkboxes (Event Delegation)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('check-row-all')) {
                    const targetClass = e.target.getAttribute('data-target-class');
                    if (targetClass) {
                        document.querySelectorAll(`.${targetClass}`).forEach(cb => {
                            if (!cb.disabled) {
                                cb.checked = e.target.checked;
                            }
                        });
                    }
                    syncAllParentMenuStates();
                    updateRowAllStates();
                    updateCheckAllState();
                } else if (e.target && e.target.classList.contains('role-permission-checkbox')) {
                    syncAllParentMenuStates();
                    updateRowAllStates();
                    updateCheckAllState();
                }
            });

            // Update row-all and check-all checkbox states based on checked items
            function updateRowAllStates() {
                document.querySelectorAll('.check-row-all').forEach(rowAll => {
                    const targetClass = rowAll.getAttribute('data-target-class');
                    if (targetClass) {
                        const items = document.querySelectorAll(`.${targetClass}`);
                        const checkedItems = document.querySelectorAll(`.${targetClass}:checked`);
                        if (items.length > 0) {
                            rowAll.checked = (items.length === checkedItems.length);
                        }
                    }
                });
            }

            function updateCheckAllState() {
                const checkAll = document.getElementById('check_all_permissions');
                const totalItems = document.querySelectorAll('.role-permission-checkbox').length;
                const checkedItems = document.querySelectorAll('.role-permission-checkbox:checked').length;
                if (checkAll && totalItems > 0) {
                    checkAll.checked = (totalItems === checkedItems);
                }
            }

            // All roles data for dynamic role-to-permissions sync
            const allRolesData = @json($roles);

            // Role Checkbox Toggle Handler (Auto-check / sync permissions for selected roles)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('user-role-checkbox')) {
                    const isChecked = e.target.checked;
                    const roleName = e.target.value;
                    const roleObj = allRolesData.find(r => r.name === roleName);
                    if (roleObj && roleObj.permissions) {
                        roleObj.permissions.forEach(perm => {
                            const permCb = document.querySelectorAll(`input[name="permissions[]"][value="${perm.name}"]`);
                            permCb.forEach(cb => {
                                if (!cb.disabled) {
                                    if (isChecked) {
                                        cb.checked = true;
                                    } else {
                                        // Only uncheck if no other checked role has this permission
                                        const otherCheckedRoles = Array.from(document.querySelectorAll('.user-role-checkbox:checked')).map(el => el.value);
                                        const stillHasPerm = allRolesData.some(r => otherCheckedRoles.includes(r.name) && r.permissions.some(p => p.name === perm.name));
                                        if (!stillHasPerm) {
                                            cb.checked = false;
                                        }
                                    }
                                }
                            });
                        });
                    }
                    syncAllParentMenuStates();
                    updateRowAllStates();
                    updateCheckAllState();
                }
            });

            // Modal & Action Handlers (Event Delegation)
            const aksesUserModalElement = document.getElementById('aksesUserModal');
            const aksesUserModal = new bootstrap.Modal(aksesUserModalElement);
            const aksesUserForm = document.getElementById('aksesUserForm');
            const modalTitle = document.getElementById('aksesUserModalTitle');
            const modalUserNameDisplay = document.getElementById('modal_user_name_display');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.user-role-checkbox, .role-permission-checkbox, .check-row-all, #check_all_permissions');

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

                document.querySelectorAll('.user-role-checkbox, .role-permission-checkbox, .check-row-all, #check_all_permissions').forEach(cb => {
                    cb.checked = false;
                });

                document.getElementById('form_user_name').value = user.name || '';
                document.getElementById('form_user_email').value = user.email || '';
                modalUserNameDisplay.textContent = `${user.name} (${user.email})`;
                aksesUserForm.action = `{{ url('admin/manajemenpengguna/akses-user') }}/${user.id}`;

                // 1. Check active roles
                const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
                userRoles.forEach(rName => {
                    const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
                    roleCb.forEach(cb => cb.checked = true);
                });

                // 2. Check active permissions (all permissions inherited from roles + direct permissions)
                const userPerms = user.all_permission_names || user.direct_permission_names || (user.permissions ? user.permissions.map(p => p.name || p) : []);
                userPerms.forEach(pName => {
                    const permCb = document.querySelectorAll(`input[name="permissions[]"][value="${pName}"]`);
                    permCb.forEach(cb => cb.checked = true);
                });

                syncAllParentMenuStates();
                updateRowAllStates();
                updateCheckAllState();

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
        });
    </script>
@endsection
