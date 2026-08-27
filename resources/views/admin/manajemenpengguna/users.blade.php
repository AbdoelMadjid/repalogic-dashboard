@extends('layouts.vertical', ['title' => 'Data Pengguna'])

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Data Pengguna'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Data Pengguna System (User Management)</h4>
                            <p class="text-muted fs-12 mb-0">
                                Kelola akun pengguna aplikasi, status persetujuan registrasi, dan atribusi Peran (Role).
                            </p>
                        </div>
                        @can('create manajemenpengguna/users')
                            <button type="button" class="btn btn-primary btn-sm btn-user-action" data-action="create">
                                <i class="ti ti-plus me-1"></i> Tambah Pengguna Baru
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
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Pengguna:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama, email, atau role..." value="{{ request('search', '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="users-table">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 50px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Identitas Pengguna</th>
                                        <th class="text-center align-middle text-nowrap">Peran (Role)</th>
                                        <th class="text-center align-middle text-nowrap">Status Akun</th>
                                        <th class="text-center align-middle text-nowrap">Tanggal Terdaftar</th>
                                        <th style="width: 180px;" class="text-center align-middle text-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="user-row">
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
                                                                'user' => 'bg-info-subtle text-info border-info-subtle',
                                                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} border fs-11 text-capitalize">
                                                            <i class="ti ti-shield me-1"></i>{{ $role->name }}
                                                        </span>
                                                    @empty
                                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-11">
                                                            <i class="ti ti-alert-circle me-1"></i>Belum Ada Role
                                                        </span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center py-2">
                                                @if ($user->status === 'pending')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-11">
                                                        <i class="ti ti-clock me-1"></i>Menunggu Persetujuan
                                                    </span>
                                                @elseif ($user->status === 'inactive')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-11">
                                                        <i class="ti ti-ban me-1"></i>Nonaktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle fs-11">
                                                        <i class="ti ti-circle-check me-1"></i>Aktif
                                                    </span>
                                                @endif

                                                @if ($user->isPasswordResetRequested())
                                                    <div class="mt-1">
                                                        <span class="badge bg-info-subtle text-info border border-info-subtle fs-10 px-1.5 py-0.5" title="Permintaan Reset Password Masuk">
                                                            <i class="ti ti-key me-0.5"></i>Minta Reset
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center text-muted fs-12">
                                                {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                            </td>
                                            <td class="text-center py-2 text-nowrap">
                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                    {{-- Tombol Setujui Khusus User Pending --}}
                                                    @if ($user->status === 'pending')
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.approve', $user->id) }}" method="POST" class="d-inline" data-confirm="Setujui dan aktifkan akun {{ $user->name }} dengan Role User?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui Akun &amp; Berikan Role User">
                                                                    <i class="ti ti-user-check me-1"></i>Setujui
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif

                                                    {{-- Tombol Reset Password Khusus Permintaan Reset --}}
                                                    @if ($user->isPasswordResetRequested())
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.reset-password', $user->id) }}" method="POST" class="d-inline" data-confirm="Reset password pengguna {{ $user->name }} ke password standar ('password*')?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-info text-white" title="Reset Password ke Standar ('password*')">
                                                                    <i class="ti ti-key me-1"></i>Reset Password
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif

                                                    @can('read manajemenpengguna/users')
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-user-action" data-action="view" data-user='@json($user)' title="Detail Pengguna"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update manajemenpengguna/users')
                                                        <button type="button" class="btn btn-sm btn-outline-warning btn-user-action" data-action="edit" data-user='@json($user)' title="Edit Pengguna"><i class="ti ti-edit"></i></button>
                                                    @endcan
                                                    @can('delete manajemenpengguna/users')
                                                        @if (auth()->id() === $user->id)
                                                            <button type="button" class="btn btn-sm btn-outline-secondary disabled" title="Akun Anda yang sedang aktif tidak dapat dihapus"><i class="ti ti-lock"></i></button>
                                                        @else
                                                            <form action="{{ route('admin.manajemenpengguna.users.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Hapus akun pengguna {{ $user->name }}?">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                            </form>
                                                        @endif
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

    <!-- SINGLE UNIFIED MODAL (CREATE, EDIT, VIEW/SHOW) -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="userForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalTitle">Form Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.manajemenpengguna.partials.user_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Pengguna</button>
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
                document.querySelectorAll('.user-row').forEach(row => {
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

            // Auto search jika terdapat parameter ?search= di URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam && searchInput) {
                searchInput.value = searchParam;
            }

            if (searchInput && searchInput.value.trim() !== '') {
                setTimeout(function() {
                    searchInput.focus();
                    searchInput.select();
                }, 150);
            }

            updateTableDisplay();

            // Modal & Action Handlers (Event Delegation)
            const userModalElement = document.getElementById('userModal');
            const userModal = new bootstrap.Modal(userModalElement);
            const userForm = document.getElementById('userForm');
            const modalTitle = document.getElementById('userModalTitle');
            const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.user-input');
            const passwordInput = document.getElementById('form_user_password');
            const passwordHelp = document.getElementById('help_user_password');
            const passwordLabel = document.getElementById('label_user_password');

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-user-action');
                if (!btn) return;
                e.preventDefault();

                const action = btn.getAttribute('data-action');
                const userDataRaw = btn.getAttribute('data-user');
                const user = userDataRaw ? JSON.parse(userDataRaw) : null;

                userForm.reset();
                methodSpoofingContainer.innerHTML = '';
                formInputs.forEach(input => input.disabled = false);
                btnSubmitForm.classList.remove('d-none');
                document.querySelectorAll('.user-role-checkbox').forEach(cb => cb.checked = false);

                if (action === 'create') {
                    modalTitle.innerHTML = '<i class="ti ti-user-plus me-1"></i> Tambah Pengguna Baru';
                    userForm.action = "{{ route('admin.manajemenpengguna.users.store') }}";
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Pengguna';
                    passwordInput.required = true;
                    passwordLabel.innerHTML = 'Kata Sandi (Password) <span class="text-danger">*</span>';
                    passwordHelp.textContent = 'Wajib diisi saat membuat akun baru (minimal 8 karakter).';
                    document.getElementById('form_user_status').value = 'active';

                } else if (action === 'edit' && user) {
                    modalTitle.innerHTML = `<i class="ti ti-user-edit me-1"></i> Edit Pengguna: ${user.name}`;
                    userForm.action = `{{ url('admin/manajemenpengguna/users') }}/${user.id}`;
                    methodSpoofingContainer.innerHTML = '@method("PUT")';
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Pengguna';
                    passwordInput.required = false;
                    passwordLabel.innerHTML = 'Kata Sandi Baru (Opsional)';
                    passwordHelp.textContent = 'Kosongkan jika tidak ingin mengubah kata sandi.';

                    populateForm(user);

                } else if (action === 'view' && user) {
                    modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Pengguna: ${user.name}`;
                    userForm.action = '#';
                    btnSubmitForm.classList.add('d-none');
                    populateForm(user);
                    formInputs.forEach(input => input.disabled = true);
                }

                userModal.show();
            });

            function populateForm(user) {
                document.getElementById('form_user_name').value = user.name || '';
                document.getElementById('form_user_email').value = user.email || '';
                document.getElementById('form_user_status').value = user.status || 'active';

                const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
                userRoles.forEach(rName => {
                    const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
                    roleCb.forEach(cb => cb.checked = true);
                });
            }
        });
    </script>
@endsection
