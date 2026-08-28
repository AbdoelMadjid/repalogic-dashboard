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
                                                @elseif ($user->status === 'rejected')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-11" title="{{ $user->rejection_reason ? 'Alasan: ' . $user->rejection_reason : 'Pendaftaran ditolak' }}">
                                                        <i class="ti ti-user-x me-1"></i>Pendaftaran Ditolak
                                                    </span>
                                                @elseif ($user->status === 'inactive')
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-11">
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

                                                @if ($user->isDeactivationRequested())
                                                    <div class="mt-1">
                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-10 px-1.5 py-0.5" title="Permohonan Nonaktif: {{ $user->deactivation_reason ?? 'Tanpa alasan' }}">
                                                            <i class="ti ti-user-x me-0.5"></i>Minta Nonaktif
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($user->isReactivationRequested())
                                                    <div class="mt-1">
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle fs-10 px-1.5 py-0.5" title="Permohonan Aktivasi: {{ $user->reactivation_reason ?? 'Tanpa alasan' }}">
                                                            <i class="ti ti-user-check me-0.5"></i>Minta Aktivasi
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center text-muted fs-12">
                                                {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                            </td>
                                            <td class="text-center py-2 text-nowrap">
                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                    {{-- Tombol Setujui / Tolak Khusus User Pending atau Rejected --}}
                                                    @if ($user->status === 'pending')
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.approve', $user->id) }}" method="POST" class="d-inline" data-confirm="Setujui dan aktifkan akun {{ $user->name }} dengan Role User?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui Akun &amp; Berikan Role User">
                                                                    <i class="ti ti-user-check me-1"></i>Setujui
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-outline-danger btn-reject-registration-modal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" title="Tolak Pendaftaran Akun">
                                                                <i class="ti ti-x me-1"></i>Tolak
                                                            </button>
                                                        @endcan
                                                    @elseif ($user->status === 'rejected')
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.approve', $user->id) }}" method="POST" class="d-inline" data-confirm="Setujui dan aktifkan akun {{ $user->name }} yang sebelumnya ditolak?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui &amp; Aktifkan Akun">
                                                                    <i class="ti ti-user-check me-1"></i>Setujui Akun
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

                                                    {{-- Tombol Nonaktifkan / Tolak Khusus Permintaan Nonaktif --}}
                                                    @if ($user->isDeactivationRequested())
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.deactivate', $user->id) }}" method="POST" class="d-inline" data-confirm="Nonaktifkan akun pengguna {{ $user->name }} sesuai permohonan?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger text-white" title="Nonaktifkan Akun Pengguna">
                                                                    <i class="ti ti-user-off me-1"></i>Nonaktifkan
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-reject-deactivation-modal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-reason="{{ $user->deactivation_reason }}" title="Tolak Permohonan Penonaktifan">
                                                                <i class="ti ti-x me-1"></i>Tolak Nonaktif
                                                            </button>
                                                        @endcan
                                                    @endif

                                                    {{-- Tombol Aktifkan Khusus Permintaan Aktivasi --}}
                                                    @if ($user->isReactivationRequested())
                                                        @can('update manajemenpengguna/users')
                                                            <form action="{{ route('admin.manajemenpengguna.users.activate', $user->id) }}" method="POST" class="d-inline" data-confirm="Aktifkan kembali akun pengguna {{ $user->name }} sesuai permohonan?">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Aktifkan Kembali Akun Pengguna">
                                                                    <i class="ti ti-user-check me-1"></i>Aktifkan
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="userForm" action="" method="POST" enctype="multipart/form-data">
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

    <!-- MODAL TOLAK PENDAFTARAN REGISTRASI -->
    <div class="modal fade" id="modal-reject-registration" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white py-3">
                    <h5 class="modal-title text-white mb-0" id="modalRejectRegTitle"><i class="ti ti-user-x me-1"></i> Tolak Pendaftaran Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-reject-registration" method="POST" action="">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted fs-13 mb-3">Tuliskan alasan penolakan pendaftaran akun untuk <strong id="reject-reg-user-name" class="text-dark"></strong>:</p>
                        <div class="mb-3">
                            <label for="reject_reg_reason" class="form-label fw-semibold text-dark">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="reason" id="reject_reg_reason" rows="3" class="form-control" placeholder="Contoh: Identitas diri tidak sesuai dengan foto KTP..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 fw-semibold"><i class="ti ti-send me-1"></i> Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL TOLAK PERMINTAAN NONAKTIFKAN AKUN -->
    <div class="modal fade" id="modal-reject-deactivation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark py-3">
                    <h5 class="modal-title text-dark mb-0" id="modalRejectDeactTitle"><i class="ti ti-user-x me-1"></i> Tolak Permohonan Penonaktifan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-reject-deactivation" method="POST" action="">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted fs-13 mb-2">Permohonan penonaktifan akun oleh <strong id="reject-deact-user-name" class="text-dark"></strong>:</p>
                        <div id="reject-deact-user-reason-box" class="p-3 bg-light rounded border fs-12 mb-3 fst-italic text-secondary"></div>
                        <div class="mb-3">
                            <label for="reject_deact_reason" class="form-label fw-semibold text-dark">Alasan Penolakan dari Admin <span class="text-danger">*</span></label>
                            <textarea name="reason" id="reject_deact_reason" rows="3" class="form-control" placeholder="Contoh: Akun Anda masih memiliki transaksi aktif..." required></textarea>
                            <span class="fs-12 text-muted mt-1 d-block">Alasan penolakan ini akan dikirimkan langsung ke Notifikasi/Pesan pengguna.</span>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold text-dark"><i class="ti ti-send me-1"></i> Kirim Penolakan & Notifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event delegation untuk tombol Tolak Pendaftaran & Tolak Nonaktif
            document.addEventListener('click', function(e) {
                const btnRejectReg = e.target.closest('.btn-reject-registration-modal');
                if (btnRejectReg) {
                    const userId = btnRejectReg.getAttribute('data-user-id');
                    const userName = btnRejectReg.getAttribute('data-user-name');
                    const form = document.getElementById('form-reject-registration');
                    const nameLabel = document.getElementById('reject-reg-user-name');

                    if (form && userId) {
                        form.action = `/admin/manajemenpengguna/users/${userId}/reject-registration`;
                    }
                    if (nameLabel) nameLabel.textContent = userName || 'Pengguna';

                    const modalEl = document.getElementById('modal-reject-registration');
                    if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                        const modal = new window.bootstrap.Modal(modalEl);
                        modal.show();
                    }
                }

                const btnRejectDeact = e.target.closest('.btn-reject-deactivation-modal');
                if (btnRejectDeact) {
                    const userId = btnRejectDeact.getAttribute('data-user-id');
                    const userName = btnRejectDeact.getAttribute('data-user-name');
                    const userReason = btnRejectDeact.getAttribute('data-user-reason');
                    const form = document.getElementById('form-reject-deactivation');
                    const nameLabel = document.getElementById('reject-deact-user-name');
                    const reasonBox = document.getElementById('reject-deact-user-reason-box');

                    if (form && userId) {
                        form.action = `/admin/manajemenpengguna/users/${userId}/reject-deactivation`;
                    }
                    if (nameLabel) nameLabel.textContent = userName || 'Pengguna';
                    if (reasonBox) {
                        reasonBox.textContent = userReason ? `Alasan Pengajuan User: "${userReason}"` : 'Alasan Pengajuan User: Tidak mencantumkan alasan khusus.';
                    }

                    const modalEl = document.getElementById('modal-reject-deactivation');
                    if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                        const modal = new window.bootstrap.Modal(modalEl);
                        modal.show();
                    }
                }
            });

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

            const avatarInput = document.getElementById('form_user_avatar');
            const avatarPreview = document.getElementById('form_avatar_preview');
            const btnResetAvatar = document.getElementById('btn_reset_avatar');
            const removeAvatarInput = document.getElementById('form_remove_avatar');
            const defaultAvatarUrl = "{{ asset('assets/images/users/default-avatar.svg') }}";
            const defaultCoverUrl = "{{ asset('assets/images/profile-bg.jpg') }}";

            // Live Avatar Preview Listener
            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            if (avatarPreview) avatarPreview.src = evt.target.result;
                            if (btnResetAvatar) btnResetAvatar.classList.remove('d-none');
                            if (removeAvatarInput) removeAvatarInput.value = '0';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Reset Avatar Button Listener
            if (btnResetAvatar) {
                btnResetAvatar.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (avatarInput) avatarInput.value = '';
                    if (avatarPreview) avatarPreview.src = defaultAvatarUrl;
                    if (removeAvatarInput) removeAvatarInput.value = '1';
                    btnResetAvatar.classList.add('d-none');
                });
            }

            function formatDateTime(dateStr) {
                if (!dateStr) return '-';
                try {
                    const d = new Date(dateStr);
                    if (isNaN(d.getTime())) return dateStr;
                    return d.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } catch (e) {
                    return dateStr;
                }
            }

            function formatDateOnly(dateStr) {
                if (!dateStr) return '-';
                try {
                    const d = new Date(dateStr);
                    if (isNaN(d.getTime())) return dateStr;
                    return d.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                } catch (e) {
                    return dateStr;
                }
            }

            function resetTabsToFirst() {
                const firstTabBtn = document.getElementById('user-tab-account-btn');
                if (firstTabBtn) {
                    const tabInstance = bootstrap.Tab.getOrCreateInstance(firstTabBtn);
                    tabInstance.show();
                }
            }

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
                if (removeAvatarInput) removeAvatarInput.value = '0';
                if (btnResetAvatar) btnResetAvatar.classList.add('d-none');
                if (avatarPreview) avatarPreview.src = defaultAvatarUrl;

                resetTabsToFirst();

                if (action === 'create') {
                    modalTitle.innerHTML = '<i class="ti ti-user-plus me-1 text-primary"></i> Tambah Pengguna Baru';
                    userForm.action = "{{ route('admin.manajemenpengguna.users.store') }}";
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Pengguna';
                    passwordInput.required = true;
                    passwordLabel.innerHTML = 'Kata Sandi (Password) <span class="text-danger">*</span>';
                    passwordHelp.textContent = 'Wajib diisi saat membuat akun baru (minimal 8 karakter).';
                    document.getElementById('form_user_status').value = 'active';

                    // Reset detail & config views for new user
                    populateDetailsAndConfig(null);
                    const auditBox = document.getElementById('user_approval_audit_box');
                    if (auditBox) auditBox.classList.add('d-none');

                } else if (action === 'edit' && user) {
                    modalTitle.innerHTML = `<i class="ti ti-user-edit me-1 text-warning"></i> Edit Pengguna: ${user.name}`;
                    userForm.action = `{{ url('admin/manajemenpengguna/users') }}/${user.id}`;
                    methodSpoofingContainer.innerHTML = '@method("PUT")';
                    btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Pengguna';
                    passwordInput.required = false;
                    passwordLabel.innerHTML = 'Kata Sandi Baru (Opsional)';
                    passwordHelp.textContent = 'Kosongkan jika tidak ingin mengubah kata sandi.';

                    populateForm(user, false);

                } else if (action === 'view' && user) {
                    modalTitle.innerHTML = `<i class="ti ti-eye me-1 text-info"></i> Detail Pengguna: ${user.name}`;
                    userForm.action = '#';
                    btnSubmitForm.classList.add('d-none');
                    populateForm(user, true);
                    formInputs.forEach(input => input.disabled = true);
                }

                userModal.show();
            });

            function populateForm(user, isViewMode = false) {
                // 1. Tab Akun & Kredensial
                document.getElementById('form_user_name').value = user.name || '';
                document.getElementById('form_user_email').value = user.email || '';
                document.getElementById('form_user_status').value = user.status || 'active';

                if (user.avatar_url) {
                    avatarPreview.src = user.avatar_url;
                } else {
                    avatarPreview.src = defaultAvatarUrl;
                }

                if (!isViewMode && user.avatar) {
                    btnResetAvatar.classList.remove('d-none');
                } else {
                    btnResetAvatar.classList.add('d-none');
                }

                const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
                userRoles.forEach(rName => {
                    const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
                    roleCb.forEach(cb => cb.checked = true);
                });

                // Audit Persetujuan
                const auditBox = document.getElementById('user_approval_audit_box');
                if (auditBox) {
                    if (user.approved_at || user.approver) {
                        auditBox.classList.remove('d-none');
                        document.getElementById('audit_approved_by').textContent = user.approver ? user.approver.name : (user.approved_by ? `User ID #${user.approved_by}` : '-');
                        document.getElementById('audit_approved_at').textContent = user.approved_at ? formatDateTime(user.approved_at) : '-';
                    } else {
                        auditBox.classList.add('d-none');
                    }
                }

                // 2. Tab Identitas KTP & Preferensi
                populateDetailsAndConfig(user);
            }

            function populateDetailsAndConfig(user) {
                const detail = user ? user.detail : null;
                const detailEmptyAlert = document.getElementById('detail_empty_alert');

                if (detail) {
                    if (detailEmptyAlert) detailEmptyAlert.classList.add('d-none');
                    document.getElementById('view_detail_nik').textContent = detail.nik || '-';
                    document.getElementById('view_detail_nama_ktp').textContent = detail.nama_ktp || '-';

                    let ttl = [];
                    if (detail.tempat_lahir) ttl.push(detail.tempat_lahir);
                    if (detail.tanggal_lahir) ttl.push(formatDateOnly(detail.tanggal_lahir));
                    document.getElementById('view_detail_ttl').textContent = ttl.length > 0 ? ttl.join(', ') : '-';

                    document.getElementById('view_detail_jenis_kelamin').textContent = detail.jenis_kelamin || '-';
                    document.getElementById('view_detail_golongan_darah').textContent = detail.golongan_darah || '-';
                    document.getElementById('view_detail_agama').textContent = detail.agama || '-';
                    document.getElementById('view_detail_status_perkawinan').textContent = detail.status_perkawinan || '-';
                    document.getElementById('view_detail_pekerjaan').textContent = detail.pekerjaan || '-';
                    document.getElementById('view_detail_kewarganegaraan').textContent = detail.kewarganegaraan || 'WNI';

                    document.getElementById('view_detail_alamat_jalan').textContent = detail.alamat_jalan || '-';

                    let rtrwblok = [];
                    if (detail.blok) rtrwblok.push('Blok ' + detail.blok);
                    if (detail.rt || detail.rw) rtrwblok.push('RT ' + (detail.rt || '-') + ' / RW ' + (detail.rw || '-'));
                    document.getElementById('view_detail_rt_rw_blok').textContent = rtrwblok.length > 0 ? rtrwblok.join(', ') : '-';

                    document.getElementById('view_detail_desa_kelurahan').textContent = detail.desa_kelurahan || '-';
                    document.getElementById('view_detail_kecamatan').textContent = detail.kecamatan || '-';
                    document.getElementById('view_detail_kabupaten_kota').textContent = detail.kabupaten_kota || '-';
                    document.getElementById('view_detail_provinsi').textContent = detail.provinsi || '-';
                    document.getElementById('view_detail_kode_pos').textContent = detail.kode_pos || '-';

                    const fotoKtpContainer = document.getElementById('view_detail_foto_ktp_container');
                    if (detail.foto_ktp_url) {
                        fotoKtpContainer.innerHTML = `
                            <a href="${detail.foto_ktp_url}" target="_blank" class="d-inline-block border rounded overflow-hidden shadow-sm" title="Klik untuk memperbesar Foto KTP">
                                <img src="${detail.foto_ktp_url}" alt="Foto KTP" class="img-fluid" style="max-height: 140px; object-fit: contain;">
                            </a>
                        `;
                    } else {
                        fotoKtpContainer.innerHTML = '<span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>';
                    }
                } else {
                    if (detailEmptyAlert) detailEmptyAlert.classList.remove('d-none');
                    document.getElementById('view_detail_nik').textContent = '-';
                    document.getElementById('view_detail_nama_ktp').textContent = '-';
                    document.getElementById('view_detail_ttl').textContent = '-';
                    document.getElementById('view_detail_jenis_kelamin').textContent = '-';
                    document.getElementById('view_detail_golongan_darah').textContent = '-';
                    document.getElementById('view_detail_agama').textContent = '-';
                    document.getElementById('view_detail_status_perkawinan').textContent = '-';
                    document.getElementById('view_detail_pekerjaan').textContent = '-';
                    document.getElementById('view_detail_kewarganegaraan').textContent = '-';
                    document.getElementById('view_detail_alamat_jalan').textContent = '-';
                    document.getElementById('view_detail_rt_rw_blok').textContent = '-';
                    document.getElementById('view_detail_desa_kelurahan').textContent = '-';
                    document.getElementById('view_detail_kecamatan').textContent = '-';
                    document.getElementById('view_detail_kabupaten_kota').textContent = '-';
                    document.getElementById('view_detail_provinsi').textContent = '-';
                    document.getElementById('view_detail_kode_pos').textContent = '-';
                    document.getElementById('view_detail_foto_ktp_container').innerHTML = '<span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>';
                }

                // 3. Tab Preferensi & Sampul (user_configs)
                const config = user ? user.config : null;
                const configEmptyAlert = document.getElementById('config_empty_alert');
                const completionPct = user ? (user.profile_completion_percentage || 0) : 0;

                const completionBadge = document.getElementById('view_config_completion_badge');
                const completionBar = document.getElementById('view_config_completion_bar');
                if (completionBadge) completionBadge.textContent = `${completionPct}%`;
                if (completionBar) {
                    completionBar.style.width = `${completionPct}%`;
                    completionBar.setAttribute('aria-valuenow', completionPct);
                }

                const coverImg = document.getElementById('view_config_cover_preview');
                const coverPosText = document.getElementById('view_config_cover_pos_text');
                const mottoBox = document.getElementById('view_config_motto_box');
                const themeBadge = document.getElementById('view_config_theme_badge');

                if (user && user.cover_bg_url) {
                    if (coverImg) coverImg.src = user.cover_bg_url;
                } else {
                    if (coverImg) coverImg.src = defaultCoverUrl;
                }

                const posY = (config && config.cover_position_y !== null && config.cover_position_y !== undefined) ? config.cover_position_y : (user && user.cover_position_y ? user.cover_position_y : 0);
                if (coverImg) coverImg.style.objectPosition = `center ${posY}%`;
                if (coverPosText) coverPosText.textContent = `${posY}%`;

                const motto = (config && config.motto) ? config.motto : (user && user.motto ? user.motto : 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.');
                if (mottoBox) mottoBox.textContent = `"${motto}"`;

                const themeMode = (config && config.theme_mode) ? config.theme_mode : 'light';
                if (themeBadge) {
                    themeBadge.innerHTML = `<i class="ti ti-sun-moon me-1"></i> ${themeMode.toUpperCase()}`;
                }

                if (config) {
                    if (configEmptyAlert) configEmptyAlert.classList.add('d-none');
                } else {
                    if (configEmptyAlert) configEmptyAlert.classList.remove('d-none');
                }
            }
        });
    </script>
@endsection
