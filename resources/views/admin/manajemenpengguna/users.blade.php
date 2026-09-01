@extends('layouts.vertical', ['title' => 'Data Pengguna'])

@section('content')
    <link href="{{ asset('assets/css/admin/manajemenpengguna/users.css') }}" rel="stylesheet" type="text/css" />

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

                        <!-- DATATABLES HEADER CONTROLS (JUMLAH BARIS, FILTER ROLE, FILTER STATUS & LIVE SEARCH) -->
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-12 col-md-auto d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm" style="width: 105px;">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-auto d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-shield me-1"></i>Role:</label>
                                <select id="table-filter-role" class="form-select form-select-sm" style="min-width: 130px;">
                                    <option value="">Semua Role</option>
                                    @foreach ($roles as $roleItem)
                                        <option value="{{ $roleItem->name }}">{{ ucfirst($roleItem->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-auto d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-circle-check me-1"></i>Status:</label>
                                <select id="table-filter-status" class="form-select form-select-sm" style="min-width: 140px;">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="pending">Menunggu Persetujuan</option>
                                    <option value="inactive">Nonaktif</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>

                            <div class="col-12 col-md d-flex justify-content-md-end align-items-center gap-2 mt-2 mt-md-0">
                                <div class="input-group input-group-sm" style="max-width: 280px;">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="ti ti-search"></i></span>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm border-start-0 ps-0" placeholder="Cari nama, email, role..." value="{{ request('search', '') }}">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap" id="btn-reset-filters" title="Reset Semua Filter & Pencarian">
                                    <i class="ti ti-refresh me-1"></i>Reset
                                </button>
                            </div>
                        </div>

                        <!-- BULK ACTION TOOLBAR (PILIHAN CENTANG CHECKBOX USER) -->
                        @can('update manajemenpengguna/users')
                            <div class="p-3 bg-light-subtle rounded-3 mb-3 border d-flex flex-wrap align-items-center justify-content-between gap-3" id="bulk-user-action-bar">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="check-all-global-users" title="Pilih Semua Pengguna">
                                        <label class="form-check-label fw-semibold fs-13 text-dark user-select-none cursor-pointer" for="check-all-global-users" id="check-all-users-label">
                                            Pilih Semua ({{ $users->count() }})
                                        </label>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 px-2.5 py-1 ms-2" id="selected-user-badge" style="display: none;">
                                        <i class="ti ti-check me-1"></i><span id="selected-user-count">0</span> terpilih
                                    </span>
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-primary" id="btn-bulk-assign-role" disabled>
                                        <i class="ti ti-shield-check me-1"></i> Berikan / Atur Role Terpilih
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-deselect-all-users" style="display: none;">
                                        <i class="ti ti-x me-1"></i> Batal Pilih
                                    </button>
                                </div>
                            </div>
                        @endcan

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="users-table">
                                <thead class="align-middle text-center text-nowrap">
                                    <tr>
                                        @can('update manajemenpengguna/users')
                                            <th style="width: 40px;" class="text-center align-middle check-cell">
                                                <input type="checkbox" class="form-check-input" id="check-all-page-users" title="Pilih Semua Baris di Halaman Ini">
                                            </th>
                                        @endcan
                                        <th style="width: 50px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Identitas Pengguna</th>
                                        <th class="text-center align-middle text-nowrap">Peran (Role)</th>
                                        <th class="text-center align-middle text-nowrap">Status Akun</th>
                                        <th class="text-center align-middle text-nowrap">Tanggal Terdaftar</th>
                                        <th style="width: 190px;" class="text-center align-middle text-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="user-row" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-avatar="{{ $user->avatar_url }}" data-roles='@json($user->role_names)' data-status="{{ $user->status }}">
                                            @can('update manajemenpengguna/users')
                                                <td class="text-center check-cell cursor-pointer">
                                                    <input type="checkbox" class="form-check-input user-check-item" value="{{ $user->id }}" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-avatar="{{ $user->avatar_url }}" data-roles='@json($user->role_names)'>
                                                </td>
                                            @endcan
                                            <td class="text-center fw-semibold text-muted user-no">{{ $loop->iteration }}</td>
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

                                                    {{-- Tombol Switch Akun (Login Sebagai User Ini) --}}
                                                    @if ($user->id !== auth()->id() && $user->status === 'active' && !session()->has('impersonator_id'))
                                                        @if (auth()->user()->hasAnyRole(['superadmin', 'admin']) || auth()->user()->can('update manajemenpengguna/users'))
                                                            <form action="{{ route('admin.manajemenpengguna.users.switch-account', $user->id) }}" method="POST" class="d-inline" data-confirm="Beralih akun dan login sementara sebagai &quot;{{ $user->name }}&quot;?" data-confirm-type="switch">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Switch Akun (Login Sebagai {{ $user->name }})">
                                                                    <i class="ti ti-replace-user"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                    @can('update manajemenpengguna/users')
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-quick-role" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-avatar="{{ $user->avatar_url }}" data-user-roles='@json($user->role_names)' title="Atur Role Pengguna Ini"><i class="ti ti-shield-check"></i></button>
                                                    @endcan
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
                                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pengguna yang terdaftar.</td>
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

    <!-- BULK & QUICK ROLE ASSIGNMENT MODAL -->
    @include('admin.manajemenpengguna.partials.bulk_role_modal')

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

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.UsersConfig = {
            defaultAvatarUrl: "{{ asset('assets/images/users/default-avatar.svg') }}",
            defaultCoverUrl: "{{ asset('assets/images/profile-bg.jpg') }}",
            routes: {
                store: "{{ route('admin.manajemenpengguna.users.store') }}",
                bulkAssignRole: "{{ route('admin.manajemenpengguna.users.bulk-assign-role') }}",
                base: "{{ url('admin/manajemenpengguna/users') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/users.js') }}"></script>
@endsection
