@extends('layouts.vertical', ['title' => 'Data Login Pengguna'])

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Data Login Pengguna'])

    <div class="container-fluid mt-2">
        <!-- 1. KARTU STATISTIK LOGIN -->
        <div class="row g-3 mb-3">
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-12 fw-medium text-uppercase">Login Hari Ini</span>
                                <h3 class="fw-bold my-1 text-primary">{{ number_format($stats['total_today']) }}</h3>
                                <span class="fs-12 text-muted">Total sesi masuk</span>
                            </div>
                            <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-login fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-12 fw-medium text-uppercase">Pengguna Aktif Hari Ini</span>
                                <h3 class="fw-bold my-1 text-success">{{ number_format($stats['unique_users_today']) }}</h3>
                                <span class="fs-12 text-muted">User unik terdeteksi</span>
                            </div>
                            <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-users fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-12 fw-medium text-uppercase">Poin Diberikan Hari Ini</span>
                                <h3 class="fw-bold my-1 text-warning">{{ number_format($stats['points_today']) }}</h3>
                                <span class="fs-12 text-muted">Maksimal 1 poin/24 jam</span>
                            </div>
                            <div class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-award fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-12 fw-medium text-uppercase">Total Riwayat Tersimpan</span>
                                <h3 class="fw-bold my-1 text-info">{{ number_format($stats['total_all_time']) }}</h3>
                                <span class="fs-12 text-muted">Semua sesi waktu</span>
                            </div>
                            <div class="avatar-md bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-history fs-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. FILTER & PENCARIAN WIDGET -->
        <div class="card shadow-sm border-0 rounded-3 mb-3">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-filter fs-18"></i>
                    <h5 class="card-title text-white mb-0">Filter & Parameter Pencarian</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-light btn-sm fw-semibold text-danger" id="btnOpenClearLogsModal">
                        <i class="ti ti-trash me-1"></i> Bersihkan Log Lama
                    </button>
                </div>
            </div>
            <div class="card-body bg-light-subtle py-3">
                <form method="GET" action="{{ route('admin.manajemenpengguna.data-login.index') }}" id="filterForm">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fs-12 fw-semibold mb-1">Periode Tanggal:</label>
                            <select name="period" id="filterPeriod" class="form-select form-select-sm">
                                <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="last7" {{ $period === 'last7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                                <option value="this_month" {{ $period === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Rentang Kustom...</option>
                            </select>
                        </div>

                        <div class="col-md-3 {{ $period === 'custom' ? '' : 'd-none' }}" id="customDateRangeCol">
                            <label class="form-label fs-12 fw-semibold mb-1">Rentang Tanggal:</label>
                            <div class="input-group input-group-sm">
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" placeholder="Mulai">
                                <span class="input-group-text bg-light">-</span>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" placeholder="Sampai">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fs-12 fw-semibold mb-1">Filter Pengguna:</label>
                            <select name="user_id" class="form-select form-select-sm">
                                <option value="">-- Semua Pengguna --</option>
                                @foreach ($usersList as $u)
                                    <option value="{{ $u->id }}" {{ (string) $userId === (string) $u->id ? 'selected' : '' }}>
                                        {{ $u->name }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fs-12 fw-semibold mb-1">Kata Kunci Pencarian:</label>
                            <input type="text" name="search" class="form-control form-control-sm"
                                placeholder="Cari IP, browser, nama, email..." value="{{ $searchTerm ?? '' }}">
                        </div>

                        <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                            <a href="{{ route('admin.manajemenpengguna.data-login.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="ti ti-refresh me-1"></i> Reset Filter
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm px-3">
                                <i class="ti ti-search me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- 3. TABEL DATA UTAMA DENGAN TAB NAVIGASI -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-2 px-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                <ul class="nav nav-pills card-header-pills" id="loginDataTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold py-1.5 px-3 fs-13" id="tab-today-users" data-bs-toggle="pill"
                            data-bs-target="#content-today-users" type="button" role="tab" aria-selected="true">
                            <i class="ti ti-user-check me-1"></i> Pengguna Login Hari Ini
                            <span class="badge bg-success-subtle text-success ms-1 rounded-pill">{{ count($todayUsers) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold py-1.5 px-3 fs-13" id="tab-all-history" data-bs-toggle="pill"
                            data-bs-target="#content-all-history" type="button" role="tab" aria-selected="false">
                            <i class="ti ti-history me-1"></i> Semua Riwayat Aktivitas Login
                            <span class="badge bg-primary-subtle text-primary ms-1 rounded-pill">{{ $allLogins->total() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="loginDataTabContent">
                    <!-- TAB 1: PENGGUNA LOGIN HARI INI -->
                    <div class="tab-pane fade show active" id="content-today-users" role="tabpanel" aria-labelledby="tab-today-users">
                        <div class="p-3 bg-light-subtle border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="fs-13 text-muted">
                                <i class="ti ti-info-circle text-primary me-1"></i> Menampilkan daftar seluruh pengguna yang melakukan aktivitas login pada hari ini (<strong>{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</strong>).
                            </div>
                            <span class="badge bg-primary fs-12 px-2.5 py-1.5">
                                {{ count($todayUsers) }} Pengguna Aktif
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="align-middle text-center text-nowrap table-light">
                                    <tr>
                                        <th style="width: 50px;">NO</th>
                                        <th>PENGGUNA</th>
                                        <th>ROLE</th>
                                        <th>TOTAL POIN LOGIN</th>
                                        <th>SESI HARI INI</th>
                                        <th>POIN HARI INI</th>
                                        <th>LOGIN PERTAMA HARI INI</th>
                                        <th>LOGIN TERAKHIR</th>
                                        <th>BROWSER & PERANGKAT</th>
                                        <th>IP & LOKASI</th>
                                        <th style="width: 90px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($todayUsers as $index => $item)
                                        <tr>
                                            <td class="text-center fw-medium">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $item->user?->avatar_url ?? asset('assets/images/users/default-avatar.svg') }}"
                                                        alt="{{ $item->user?->name }}" class="rounded-circle avatar-sm border flex-shrink-0"
                                                        style="width: 38px; height: 38px; object-fit: cover;">
                                                    <div>
                                                        <div class="fw-semibold text-dark">{{ $item->user?->name ?? 'User Tidak Diketahui' }}</div>
                                                        <div class="text-muted fs-12">{{ $item->user?->email ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                                    {{ $item->user?->role_name ?? 'User' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fs-12 px-2.5 py-1 fw-bold">
                                                    <i class="ti ti-award me-0.5"></i> {{ number_format($item->user?->login_count ?? 0) }} Poin
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary-subtle text-primary fs-12 px-2.5 py-1">
                                                    {{ $item->total_sessions_today }} Sesi
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->points_earned_today > 0)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                        <i class="ti ti-check me-0.5"></i> +{{ $item->points_earned_today }} Poin
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-muted px-2 py-1" title="Sudah dapat poin hari ini">
                                                        0 Poin (Maks 1/hari)
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center text-nowrap fs-12">
                                                {{ $item->first_login_today ? $item->first_login_today->format('H:i:s') . ' WIB' : '-' }}
                                            </td>
                                            <td class="text-center text-nowrap fs-12">
                                                <span class="fw-semibold text-dark">{{ $item->last_login_today ? $item->last_login_today->format('H:i:s') . ' WIB' : '-' }}</span>
                                                <div class="text-muted fs-11">{{ $item->last_login_today ? $item->last_login_today->diffForHumans() : '' }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-inline-flex flex-column align-items-center">
                                                    <span class="badge bg-light text-dark border px-2 py-1 mb-1">
                                                        <i class="ti ti-browser me-1 text-primary"></i> {{ $item->latest_browser }}
                                                    </span>
                                                    <span class="badge bg-light text-muted border px-2 py-0.5 fs-11">
                                                        <i class="ti ti-device-laptop me-1"></i> {{ $item->latest_platform }} ({{ $item->latest_device_type }})
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-dark-subtle text-dark font-monospace px-2 py-1 d-block mb-1">
                                                    {{ $item->latest_ip ?? '-' }}
                                                </span>
                                                @if ($item->latest_latitude && $item->latest_longitude)
                                                    <a href="{{ $item->latest_map_url }}" target="_blank" class="btn btn-xs btn-outline-info py-0 px-1.5 fs-11">
                                                        <i class="ti ti-map-pin me-0.5"></i> Peta Koordinat
                                                    </a>
                                                @else
                                                    <span class="text-muted fs-11">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-info btn-view-detail" data-login-id="{{ $item->latest_login_id }}" title="Lihat Rincian">
                                                    <i class="ti ti-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ti ti-user-x fs-36 d-block mb-2 text-secondary opacity-50"></i>
                                                    <h5 class="fw-semibold">Belum Ada Pengguna Login Hari Ini</h5>
                                                    <p class="fs-13 mb-0">Belum ada aktivitas masuk akun pengguna yang tercatat pada hari ini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 2: SEMUA RIWAYAT AKTIVITAS LOGIN -->
                    <div class="tab-pane fade" id="content-all-history" role="tabpanel" aria-labelledby="tab-all-history">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle mb-0">
                                <thead class="align-middle text-center text-nowrap table-light">
                                    <tr>
                                        <th style="width: 50px;">NO</th>
                                        <th>WAKTU LOGIN</th>
                                        <th>PENGGUNA</th>
                                        <th>STATUS POIN</th>
                                        <th>BROWSER & PERANGKAT</th>
                                        <th>ALAMAT IP</th>
                                        <th>KOORDINAT GPS</th>
                                        <th style="width: 100px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($allLogins as $index => $login)
                                        <tr>
                                            <td class="text-center fw-medium">
                                                {{ $allLogins->firstItem() + $index }}
                                            </td>
                                            <td class="text-center text-nowrap fs-12">
                                                <span class="fw-semibold text-dark">
                                                    {{ $login->login_at ? $login->login_at->translatedFormat('d/m/Y H:i:s') : '-' }} WIB
                                                </span>
                                                <div class="text-muted fs-11">
                                                    {{ $login->login_at ? $login->login_at->diffForHumans() : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $login->user?->avatar_url ?? asset('assets/images/users/default-avatar.svg') }}"
                                                        alt="{{ $login->user?->name }}" class="rounded-circle avatar-sm border flex-shrink-0"
                                                        style="width: 34px; height: 34px; object-fit: cover;">
                                                    <div>
                                                        <div class="fw-semibold text-dark fs-13">{{ $login->user?->name ?? 'User Terhapus' }}</div>
                                                        <div class="text-muted fs-11">{{ $login->user?->email ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($login->points_awarded)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                        <i class="ti ti-plus me-0.5"></i> 1 Poin Diberikan
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-muted px-2 py-1">
                                                        0 Poin (Riwayat Sesi)
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border px-2 py-1 me-1">
                                                    <i class="ti ti-browser me-0.5 text-primary"></i> {{ $login->browser }}
                                                </span>
                                                <span class="badge bg-light text-muted border px-2 py-0.5 fs-11">
                                                    <i class="ti ti-device-laptop me-0.5"></i> {{ $login->platform }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-dark-subtle text-dark font-monospace px-2 py-1">
                                                    {{ $login->ip_address ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($login->latitude && $login->longitude)
                                                    <div class="d-inline-flex align-items-center gap-1">
                                                        <span class="badge bg-info-subtle text-info font-monospace fs-11 px-2 py-0.5">
                                                            {{ number_format($login->latitude, 4) }}, {{ number_format($login->longitude, 4) }}
                                                        </span>
                                                        <a href="{{ $login->map_url }}" target="_blank" class="btn btn-xs btn-outline-info p-1" title="Buka di Google Maps">
                                                            <i class="ti ti-map-2"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted fs-12">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-info btn-view-detail" data-login-id="{{ $login->id }}" title="Lihat Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.manajemenpengguna.data-login.destroy', $login->id) }}" class="d-inline"
                                                        data-confirm="Apakah Anda yakin ingin menghapus data riwayat login ini?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Hapus Riwayat">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="ti ti-history-off fs-36 d-block mb-2 text-secondary opacity-50"></i>
                                                    <h5 class="fw-semibold">Tidak Ada Data Riwayat Login</h5>
                                                    <p class="fs-13 mb-0">Belum ada riwayat aktivitas login yang sesuai dengan kriteria filter.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINASI RIWAYAT LOGIN -->
                        @if ($allLogins->hasPages())
                            <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div class="fs-13 text-muted">
                                    Menampilkan <strong>{{ $allLogins->firstItem() }}</strong> sampai <strong>{{ $allLogins->lastItem() }}</strong> dari <strong>{{ $allLogins->total() }}</strong> riwayat login
                                </div>
                                <div>
                                    {{ $allLogins->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL RIWAYAT LOGIN -->
    <div class="modal fade" id="modalDetailLogin" tabindex="-1" aria-labelledby="modalDetailLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalDetailLoginLabel">
                        <i class="ti ti-info-circle fs-18"></i> Rincian Informasi Sesi Login
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modalLoadingSpinner" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Memuat...</span>
                        </div>
                        <p class="text-muted fs-13 mt-2 mb-0">Mengambil data sesi...</p>
                    </div>

                    <div id="modalDetailContent" class="d-none">
                        <!-- USER SUMMARY -->
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3 border">
                            <img id="detailUserAvatar" src="" alt="Avatar" class="rounded-circle avatar-md border"
                                style="width: 54px; height: 54px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold text-dark mb-0.5" id="detailUserName">-</h5>
                                <div class="text-muted fs-13 mb-1" id="detailUserEmail">-</div>
                                <span class="badge bg-primary-subtle text-primary" id="detailUserRole">-</span>
                            </div>
                        </div>

                        <!-- DETAIL GRID -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100 bg-white">
                                    <div class="fs-12 text-muted fw-semibold text-uppercase mb-2">Informasi Waktu & Poin</div>
                                    <table class="table table-sm table-borderless fs-13 mb-0">
                                        <tr>
                                            <td class="text-muted ps-0" style="width: 140px;">Waktu Login:</td>
                                            <td class="fw-semibold text-dark" id="detailLoginAt">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0">Relatif:</td>
                                            <td class="fw-semibold text-dark" id="detailLoginHuman">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0">Poin Login:</td>
                                            <td id="detailPointsAwarded">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100 bg-white">
                                    <div class="fs-12 text-muted fw-semibold text-uppercase mb-2">Informasi Jaringan & Klien</div>
                                    <table class="table table-sm table-borderless fs-13 mb-0">
                                        <tr>
                                            <td class="text-muted ps-0" style="width: 140px;">Alamat IP:</td>
                                            <td class="fw-bold font-monospace text-dark" id="detailIpAddress">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0">Browser:</td>
                                            <td class="fw-semibold text-dark" id="detailBrowser">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0">Sistem Operasi:</td>
                                            <td class="fw-semibold text-dark" id="detailPlatform">-</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-0">Tipe Perangkat:</td>
                                            <td class="fw-semibold text-dark" id="detailDeviceType">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- USER AGENT STRING -->
                        <div class="p-3 border rounded-3 bg-light-subtle mb-3">
                            <div class="fs-12 text-muted fw-semibold text-uppercase mb-1">User Agent Header</div>
                            <div class="font-monospace fs-12 text-break text-muted bg-white p-2 rounded border" id="detailUserAgent">
                                -
                            </div>
                        </div>

                        <!-- GEOLOCATION MAP PREVIEW -->
                        <div id="detailMapSection" class="p-3 border rounded-3 bg-white d-none">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fs-12 text-muted fw-semibold text-uppercase">
                                    <i class="ti ti-map-pin text-danger me-1"></i> Titik Lokasi Geografis (Koordinat GPS)
                                </div>
                                <a href="#" id="detailGoogleMapsBtn" target="_blank" class="btn btn-xs btn-outline-primary px-2 py-1 fs-12">
                                    <i class="ti ti-external-link me-1"></i> Buka Google Maps
                                </a>
                            </div>
                            <div class="fs-13 text-muted mb-2 font-monospace" id="detailCoordinatesText">-</div>
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden border">
                                <iframe id="detailMapIframe" src="" style="border:0;" loading="lazy" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BERSIHKAN LOG LAMA -->
    <div class="modal fade" id="modalClearLogs" tabindex="-1" aria-labelledby="modalClearLogsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white py-3">
                    <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalClearLogsLabel">
                        <i class="ti ti-trash fs-18"></i> Bersihkan Riwayat Login Lama
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.manajemenpengguna.data-login.clear') }}"
                    data-confirm="Apakah Anda yakin ingin membersihkan riwayat login lama sesuai periode yang dipilih? Tindakan ini tidak dapat dibatalkan.">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted fs-13">
                            Pembersihan log lama membantu mengoptimalkan ukuran database aplikasi tanpa menghapus total poin login akumulasi masing-masing pengguna.
                        </p>
                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-13">Hapus riwayat yang lebih lama dari:</label>
                            <select name="days" class="form-select">
                                <option value="30">Lebih dari 30 Hari Lalu</option>
                                <option value="60">Lebih dari 60 Hari Lalu</option>
                                <option value="90" selected>Lebih dari 90 Hari Lalu (Direkomendasikan)</option>
                                <option value="180">Lebih dari 180 Hari Lalu (6 Bulan)</option>
                                <option value="365">Lebih dari 1 Tahun Lalu</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="ti ti-trash me-1"></i> Bersihkan Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT LOGIC --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Toggle Tampilan Rentang Tanggal Kustom pada Filter
        const periodSelect = document.getElementById('filterPeriod');
        const customDateRangeCol = document.getElementById('customDateRangeCol');

        if (periodSelect && customDateRangeCol) {
            periodSelect.addEventListener('change', function () {
                if (this.value === 'custom') {
                    customDateRangeCol.classList.remove('d-none');
                } else {
                    customDateRangeCol.classList.add('d-none');
                }
            });
        }

        // 2. Modal Pembersihan Log
        const btnOpenClearLogsModal = document.getElementById('btnOpenClearLogsModal');
        const modalClearLogsEl = document.getElementById('modalClearLogs');
        let bsModalClearLogs = null;
        if (modalClearLogsEl) {
            bsModalClearLogs = new bootstrap.Modal(modalClearLogsEl);
        }

        if (btnOpenClearLogsModal && bsModalClearLogs) {
            btnOpenClearLogsModal.addEventListener('click', function () {
                bsModalClearLogs.show();
            });
        }

        // 3. Modal Detail Login Sesi & Map Geolocation
        const modalDetailLoginEl = document.getElementById('modalDetailLogin');
        let bsModalDetail = null;
        if (modalDetailLoginEl) {
            bsModalDetail = new bootstrap.Modal(modalDetailLoginEl);
        }

        const modalLoadingSpinner = document.getElementById('modalLoadingSpinner');
        const modalDetailContent = document.getElementById('modalDetailContent');
        const detailUserAvatar = document.getElementById('detailUserAvatar');
        const detailUserName = document.getElementById('detailUserName');
        const detailUserEmail = document.getElementById('detailUserEmail');
        const detailUserRole = document.getElementById('detailUserRole');
        const detailLoginAt = document.getElementById('detailLoginAt');
        const detailLoginHuman = document.getElementById('detailLoginHuman');
        const detailPointsAwarded = document.getElementById('detailPointsAwarded');
        const detailIpAddress = document.getElementById('detailIpAddress');
        const detailBrowser = document.getElementById('detailBrowser');
        const detailPlatform = document.getElementById('detailPlatform');
        const detailDeviceType = document.getElementById('detailDeviceType');
        const detailUserAgent = document.getElementById('detailUserAgent');
        const detailMapSection = document.getElementById('detailMapSection');
        const detailCoordinatesText = document.getElementById('detailCoordinatesText');
        const detailGoogleMapsBtn = document.getElementById('detailGoogleMapsBtn');
        const detailMapIframe = document.getElementById('detailMapIframe');

        // Event Delegation untuk Tombol Detail (Sesuai Rule 2)
        document.addEventListener('click', function (e) {
            const btnDetail = e.target.closest('.btn-view-detail');
            if (!btnDetail) return;

            const loginId = btnDetail.getAttribute('data-login-id');
            if (!loginId || !bsModalDetail) return;

            // Reset modal state
            modalLoadingSpinner.classList.remove('d-none');
            modalDetailContent.classList.add('d-none');
            detailMapSection.classList.add('d-none');
            detailMapIframe.src = '';
            bsModalDetail.show();

            // Fetch detail data via AJAX
            fetch(`{{ url('admin/manajemenpengguna/data-login') }}/${loginId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengambil data detail login.');
                return res.json();
            })
            .then(res => {
                if (res.status === 'success' && res.data) {
                    const d = res.data;
                    detailUserAvatar.src = d.user_avatar;
                    detailUserName.textContent = d.user_name;
                    detailUserEmail.textContent = d.user_email;
                    detailUserRole.textContent = d.user_role;
                    detailLoginAt.textContent = d.login_at;
                    detailLoginHuman.textContent = d.created_at_human;

                    if (d.points_awarded) {
                        detailPointsAwarded.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="ti ti-check me-1"></i>+1 Poin Diberikan</span>';
                    } else {
                        detailPointsAwarded.innerHTML = '<span class="badge bg-secondary-subtle text-muted px-2 py-1">0 Poin (Maks 1 poin per 24 jam)</span>';
                    }

                    detailIpAddress.textContent = d.ip_address;
                    detailBrowser.textContent = d.browser;
                    detailPlatform.textContent = d.platform;
                    detailDeviceType.textContent = d.device_type;
                    detailUserAgent.textContent = d.user_agent;

                    if (d.latitude && d.longitude) {
                        detailCoordinatesText.innerHTML = `<strong>Latitude:</strong> ${d.latitude} &nbsp;|&nbsp; <strong>Longitude:</strong> ${d.longitude}`;
                        detailGoogleMapsBtn.href = d.map_url;
                        detailMapIframe.src = d.osm_embed_url;
                        detailMapSection.classList.remove('d-none');
                    } else {
                        detailMapSection.classList.add('d-none');
                    }

                    modalLoadingSpinner.classList.add('d-none');
                    modalDetailContent.classList.remove('d-none');
                }
            })
            .catch(err => {
                modalLoadingSpinner.classList.add('d-none');
                if (window.showError) {
                    window.showError(err.message || 'Terjadi kesalahan saat memuat detail data.');
                } else {
                    alert(err.message || 'Terjadi kesalahan saat memuat detail data.');
                }
                bsModalDetail.hide();
            });
        });
    });
    </script>
@endsection
