@extends('layouts.vertical')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Data Permission System</h4>
                            <p class="text-muted fs-12 mb-0">
                                Draf pendaftaran tipe aksi izin (CRUD) per Modul / Fitur Aplikasi dan distribusinya ke Role.
                            </p>
                        </div>
                        @can('create manajemenpengguna/permission')
                            <button type="button" class="btn btn-primary btn-sm btn-modul-permission-trigger" data-type="create">
                                <i class="ti ti-plus me-1"></i> Tambah Permission Baru
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
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Modul / Fitur:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama modul...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="permission-table">
                                <thead class="table-light">
                                    <tr class="text-uppercase fs-12 fw-bold text-muted border-bottom">
                                        <th class="ps-3 py-3" style="min-width: 250px;">MODUL / FITUR APLIKASI</th>
                                        <th class="py-3">TIPE AKSI TERDAFTAR (CRUD)</th>
                                        <th class="py-3" style="min-width: 180px;">DITUGASKAN KE ROLE</th>
                                        <th class="text-center py-3" style="width: 140px;">JUMLAH IZIN</th>
                                        <th class="text-center py-3" style="width: 150px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedPermissions as $target => $permList)
                                        @php
                                            $linkedMenu = $permList->flatMap->menus->first();
                                            $roles = $permList->flatMap->roles->unique('id');
                                            $firstPerm = $permList->first();
                                            $firstPermId = $firstPerm ? $firstPerm->id : 0;
                                            $actionsStr = implode(',', $permList->pluck('name')->map(function($n) {
                                                return strtolower(explode(' ', $n)[0] ?? '');
                                            })->toArray());
                                        @endphp
                                        <tr class="permission-row">
                                            <td class="ps-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-light text-dark font-monospace border fs-12 px-2 py-1 shadow-sm me-2">
                                                        {{ $target }}
                                                    </span>
                                                    @if ($linkedMenu)
                                                        <span class="fw-medium text-muted fs-12">({{ $linkedMenu->name }})</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($permList as $perm)
                                                        @php
                                                            $actionWord = strtoupper(explode(' ', $perm->name)[0] ?? $perm->name);
                                                            $badgeStyle = match (strtolower($actionWord)) {
                                                                'create' => 'bg-success-subtle text-success border border-success-subtle',
                                                                'read' => 'bg-info-subtle text-info border border-info-subtle',
                                                                'update' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                                'delete' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                                default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeStyle }} fw-bold px-2 py-1 fs-11" title="{{ $perm->name }}">
                                                            {{ $actionWord }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @forelse ($roles as $role)
                                                        @php
                                                            $roleBadge = match ($role->name) {
                                                                'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                                'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                                                default => 'bg-info-subtle text-info border-info-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $roleBadge }} border fs-11 text-capitalize">
                                                            {{ $role->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted fs-12">- Belum Ditugaskan -</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-semibold">
                                                    {{ $permList->count() }} Akses
                                                </span>
                                            </td>
                                            <td class="text-center py-3">
                                                @can('read manajemenpengguna/permission')
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-modul-permission-trigger me-1"
                                                        data-type="view"
                                                        data-module="{{ $target }}"
                                                        data-menu-id="{{ $linkedMenu ? $linkedMenu->id : '' }}"
                                                        data-actions="{{ $actionsStr }}"
                                                        data-first-id="{{ $firstPermId }}"
                                                        title="Detail Modul">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                @endcan
                                                @can('update manajemenpengguna/permission')
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-modul-permission-trigger me-1"
                                                        data-type="edit"
                                                        data-module="{{ $target }}"
                                                        data-menu-id="{{ $linkedMenu ? $linkedMenu->id : '' }}"
                                                        data-actions="{{ $actionsStr }}"
                                                        data-first-id="{{ $firstPermId }}"
                                                        title="Edit Modul">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('delete manajemenpengguna/permission')
                                                    <form action="{{ route('admin.manajemenpengguna.permission.destroy', $firstPermId) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus seluruh izin permission untuk modul {{ $target }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Modul"><i class="ti ti-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data modul permission yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ count($groupedPermissions) }}</strong> modul
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
    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="permissionForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="permissionModalTitle">Permission Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.manajemenpengguna.partials.permission_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Permission</button>
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
                document.querySelectorAll('.permission-row').forEach(row => {
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
                        tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> modul';
                    } else if (pageSize === Infinity) {
                        tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> modul`;
                    } else {
                        tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> modul`;
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
            const permissionModalElement = document.getElementById('permissionModal');
            const permissionModal = new bootstrap.Modal(permissionModalElement);
            const permissionForm = document.getElementById('permissionForm');
            const modalTitle = document.getElementById('permissionModalTitle');
            const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.permission-input');

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-modul-permission-trigger');
                if (!btn) return;
                e.preventDefault();

                const actionType = btn.getAttribute('data-type');
                const target = btn.getAttribute('data-module');
                const menuId = btn.getAttribute('data-menu-id');
                const actionsStr = btn.getAttribute('data-actions') || '';
                const firstId = btn.getAttribute('data-first-id') || 0;
                const actionsArr = actionsStr ? actionsStr.split(',') : [];

                permissionForm.reset();
                methodSpoofingContainer.innerHTML = '';
                formInputs.forEach(input => input.disabled = false);
                btnSubmitForm.classList.remove('d-none');

                document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = false);

                if (actionType === 'create') {
                    modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Permission Baru';
                    permissionForm.action = "{{ route('admin.manajemenpengguna.permission.store') }}";
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Permission';

                    document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);

                } else if (actionType === 'edit' && target) {
                    modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Permission Modul: ${target}`;
                    permissionForm.action = `{{ url('admin/manajemenpengguna/permission') }}/${firstId}`;
                    methodSpoofingContainer.innerHTML = '@method("PUT")';
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Permission';

                    document.getElementById('form_permission_target').value = target;
                    document.getElementById('form_permission_menu_id').value = menuId || '';

                    document.querySelectorAll('.action-checkbox').forEach(cb => {
                        cb.checked = actionsArr.includes(cb.value);
                    });

                } else if (actionType === 'view' && target) {
                    modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Permission Modul: ${target}`;
                    permissionForm.action = '#';
                    btnSubmitForm.classList.add('d-none');

                    document.getElementById('form_permission_target').value = target;
                    document.getElementById('form_permission_menu_id').value = menuId || '';

                    document.querySelectorAll('.action-checkbox').forEach(cb => {
                        cb.checked = actionsArr.includes(cb.value);
                    });

                    formInputs.forEach(input => input.disabled = true);
                }

                permissionModal.show();
            });
        });
    </script>
@endsection
