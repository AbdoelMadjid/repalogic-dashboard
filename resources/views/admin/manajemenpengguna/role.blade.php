@extends('layouts.vertical', ['title' => 'Data Role & Hak Akses'])

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Data Role & Hak Akses'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Data Role & Hak Akses System</h4>
                            <p class="text-muted fs-12 mb-0">
                                Kelola peran pengguna (Role) dan distribusi Spatie Permission ke tiap peran.
                            </p>
                        </div>
                        @can('create manajemenpengguna/role')
                            <button type="button" class="btn btn-primary btn-sm btn-role-action" data-action="create">
                                <i class="ti ti-plus me-1"></i> Tambah Role Baru
                            </button>
                        @endcan
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
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Role:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama role...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="role-table">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 60px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Nama Role</th>
                                        <th class="text-center align-middle text-nowrap">Jumlah User</th>
                                        <th class="text-center align-middle text-nowrap">Jumlah Permission</th>
                                        <th style="width: 150px;" class="text-center align-middle text-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        @php
                                            $badgeClass = match ($role->name) {
                                                'superadmin' => 'bg-danger',
                                                'admin' => 'bg-primary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <tr class="role-row">
                                            <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge {{ $badgeClass }} fs-13 py-1 px-2 text-capitalize">
                                                    <i class="ti ti-shield me-1"></i>{{ $role->name }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    <i class="ti ti-users me-1"></i>{{ $role->users_count ?? $role->users->count() }} User
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                    <i class="ti ti-key me-1"></i>{{ $role->permissions_count ?? $role->permissions->count() }} Permission
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @can('read manajemenpengguna/role')
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-role-action" data-action="view" data-role='@json($role->load("permissions"))' title="Detail"><i class="ti ti-eye"></i></button>
                                                @endcan
                                                @can('update manajemenpengguna/role')
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-role-action" data-action="edit" data-role='@json($role->load("permissions"))' title="Edit"><i class="ti ti-edit"></i></button>
                                                @endcan
                                                @can('delete manajemenpengguna/role')
                                                    @if ($role->name === 'superadmin')
                                                        <button type="button" class="btn btn-sm btn-outline-secondary disabled" title="Superadmin tidak dapat dihapus"><i class="ti ti-lock"></i></button>
                                                    @else
                                                        <form action="{{ route('admin.manajemenpengguna.role.destroy', $role->id) }}" method="POST" class="d-inline" data-confirm="Hapus role {{ $role->name }}?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data role yang ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ $roles->count() }}</strong> data
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

    <!-- SINGLE UNIFIED MODAL (CREATE, EDIT, VIEW/SHOW) -->
    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="roleForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="roleModalTitle">Role Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.manajemenpengguna.partials.role_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Role</button>
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
                document.querySelectorAll('.role-row').forEach(row => {
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
                        tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> data';
                    } else if (pageSize === Infinity) {
                        tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> data`;
                    } else {
                        tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> data`;
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

            // Permission Check All Handler (Header SEMUA Checkbox)
            const checkAllPerms = document.getElementById('check_all_permissions');
            if (checkAllPerms) {
                checkAllPerms.addEventListener('change', function() {
                    const isChecked = this.checked;
                    document.querySelectorAll('.role-permission-checkbox, .check-row-all').forEach(cb => {
                        cb.checked = isChecked;
                    });
                });
            }

            // Permission Row Check All Handler (Row SEMUA Checkbox)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('check-row-all')) {
                    const targetClass = e.target.getAttribute('data-target-class');
                    if (targetClass) {
                        document.querySelectorAll(`.${targetClass}`).forEach(cb => {
                            cb.checked = e.target.checked;
                        });
                    }
                }
            });

            // Modal & Action Handlers (Event Delegation)
            const roleModalElement = document.getElementById('roleModal');
            const roleModal = new bootstrap.Modal(roleModalElement);
            const roleForm = document.getElementById('roleForm');
            const modalTitle = document.getElementById('roleModalTitle');
            const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.role-input, .check-row-all, #check_all_permissions');

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-role-action');
                if (!btn) return;
                e.preventDefault();

                const action = btn.getAttribute('data-action');
                const roleDataRaw = btn.getAttribute('data-role');
                const role = roleDataRaw ? JSON.parse(roleDataRaw) : null;

                roleForm.reset();
                methodSpoofingContainer.innerHTML = '';
                formInputs.forEach(input => input.disabled = false);
                btnSubmitForm.classList.remove('d-none');

                document.querySelectorAll('.role-permission-checkbox, .check-row-all, #check_all_permissions').forEach(cb => {
                    cb.checked = false;
                });

                if (action === 'create') {
                    modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Role Baru';
                    roleForm.action = "{{ route('admin.manajemenpengguna.role.store') }}";
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Role';

                } else if (action === 'edit' && role) {
                    modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Role: ${role.name}`;
                    roleForm.action = `{{ url('admin/manajemenpengguna/role') }}/${role.id}`;
                    methodSpoofingContainer.innerHTML = '@method("PUT")';
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Role';
                    populateForm(role);

                    if (role.name === 'superadmin') {
                        document.getElementById('form_role_name').readOnly = true;
                    } else {
                        document.getElementById('form_role_name').readOnly = false;
                    }

                } else if (action === 'view' && role) {
                    modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Role: ${role.name}`;
                    roleForm.action = '#';
                    btnSubmitForm.classList.add('d-none');
                    populateForm(role);
                    formInputs.forEach(input => input.disabled = true);
                }

                roleModal.show();
            });

            function populateForm(role) {
                document.getElementById('form_role_name').value = role.name || '';

                if (role.permissions && role.permissions.length > 0) {
                    role.permissions.forEach(perm => {
                        const permCb = document.querySelectorAll(`input[value="${perm.name}"]`);
                        permCb.forEach(cb => cb.checked = true);
                    });
                }
            }
        });
    </script>
@endsection
