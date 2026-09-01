@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/css/admin/dashboard.css') }}" rel="stylesheet" type="text/css" />

    <!-- 1. HERO GREETING & PROFILE OVERVIEW CARD WITH USER CUSTOM COVER PHOTO -->
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <div class="card dashboard-hero-card border-0 shadow-sm"
                style="min-height: {{ $user->cover_height }}px; background-image: url('{{ $user->cover_bg_url }}'); background-position: center {{ $user->cover_position_y }}%;">
                <div class="card-body p-4 p-lg-4.5 d-flex align-items-center">
                    <div class="row align-items-center g-3 w-100">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="hero-avatar-wrapper flex-shrink-0">
                                    <img src="{{ $user->avatar_url }}"
                                        alt="{{ $user->name }}" class="rounded-circle hero-avatar-img shadow">
                                    <span class="hero-status-dot" title="Akun Aktif & Sedang Masuk"></span>
                                </div>
                                @php
                                    $rolePriority = ['superadmin' => 'Superadmin', 'admin' => 'Admin', 'operator' => 'Operator', 'user' => 'User'];
                                    $primaryRoleName = 'User';
                                    foreach ($rolePriority as $roleKey => $roleLabel) {
                                        if ($user->hasRole($roleKey)) {
                                            $primaryRoleName = $roleLabel;
                                            break;
                                        }
                                    }
                                    if ($primaryRoleName === 'User' && $user->roles->isNotEmpty()) {
                                        $primaryRoleName = ucfirst($user->roles->first()->name);
                                    }
                                @endphp
                                <div>
                                    <h3 class="fw-bold text-white mb-1.5">{{ $greeting }}, {{ $user->name }}!</h3>
                                    @if ($lastLoginRecord)
                                        <p class="text-white-50 fs-13 mb-2">
                                            Login terakhir Anda tercatat pada <span class="text-white fw-semibold">{{ \Carbon\Carbon::parse($lastLoginRecord->login_at)->translatedFormat('d M Y, H:i') }} WIB</span>
                                            dari IP <span class="badge bg-white bg-opacity-20 text-white font-monospace">{{ $lastLoginRecord->ip_address }}</span>.
                                        </p>
                                    @endif
                                    <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 fs-13 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-mail text-white-50 me-1.5"></i>
                                            <span class="text-white fw-medium">{{ $user->email }}</span>
                                        </div>
                                        <span class="text-white-50 opacity-25">•</span>
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-shield-check text-white-50 me-1.5"></i>
                                            <span class="text-white fw-medium">{{ $primaryRoleName }}</span>
                                        </div>
                                        <span class="text-white-50 opacity-25">•</span>
                                        <div class="d-flex align-items-center" title="Total Teman Terhubung">
                                            <i class="ti ti-friends text-info me-1.5"></i>
                                            <span class="text-white fw-medium">{{ number_format($totalFriendsCount) }} Teman</span>
                                        </div>
                                        <span class="text-white-50 opacity-25">•</span>
                                        <div class="d-flex align-items-center" title="Total Suka Profil yang Diterima">
                                            <i class="ti ti-heart-filled text-danger me-1.5"></i>
                                            <span class="text-white fw-medium">{{ number_format($totalProfileLikesCount) }} Suka</span>
                                        </div>
                                        <span class="text-white-50 opacity-25">•</span>
                                        <div class="d-flex align-items-center" title="Total Poin Login yang Dikumpulkan">
                                            <i class="ti ti-award text-warning me-1.5"></i>
                                            <span class="text-white fw-medium">{{ number_format($user->login_count ?? 0) }} Poin Login</span>
                                        </div>
                                    </div>
                                    @if (!empty($user->motto))
                                        <div class="pt-2 border-top border-white border-opacity-10 d-flex align-items-center gap-1.5 fs-12 text-white-50 fst-italic">
                                            <i class="ti ti-quote me-1"></i>"{{ $user->motto }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-inline-flex flex-wrap gap-2">
                                <a href="{{ route('admin.profil-pengguna.index') }}" class="btn btn-sm btn-light text-dark fw-semibold px-3 py-1.5 rounded-pill shadow-sm">
                                    <i class="ti ti-user me-1.5"></i>Profil Saya
                                </a>
                                <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-sm btn-primary bg-primary text-white fw-semibold px-3 py-1.5 rounded-pill shadow-sm">
                                    <i class="ti ti-messages me-1.5"></i>Buka Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
        <!-- ========================================================================= -->
        <!-- 👑 DASHBOARD KHUSUS ADMINISTRATOR (SUPERADMIN & ADMIN)                    -->
        <!-- ========================================================================= -->

        <!-- 2. KPI METRIC STATS CARDS (ADMIN) -->
        <div class="row g-3 mb-4">
            <!-- Card 1: Total Pengguna -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Total Pengguna</span>
                            <div class="kpi-icon-box bg-primary-subtle text-primary">
                                <i class="ti ti-users"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ number_format($userStats['total']) }}</h2>
                        <div class="d-flex align-items-center gap-2 fs-12 text-muted">
                            <span class="badge bg-success-subtle text-success"><i class="ti ti-check me-1"></i>{{ $userStats['active'] }} Aktif</span>
                            @if ($userStats['pending'] > 0)
                                <span class="badge bg-warning-subtle text-warning"><i class="ti ti-clock me-1"></i>{{ $userStats['pending'] }} Menunggu</span>
                            @endif
                            @if ($userStats['inactive'] > 0)
                                <span class="badge bg-secondary-subtle text-secondary">{{ $userStats['inactive'] }} Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Spatie Role & Hak Akses -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Role &amp; Hak Akses</span>
                            <div class="kpi-icon-box bg-info-subtle text-info">
                                <i class="ti ti-shield-lock"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ $totalRoles }} <span class="fs-14 fw-normal text-muted">Peran</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            <i class="ti ti-key text-info"></i>
                            <span>Terdaftar <strong>{{ $totalPermissions }}</strong> Spatie Permissions</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Aktivitas Login Hari Ini -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Aktivitas Login</span>
                            <div class="kpi-icon-box bg-success-subtle text-success">
                                <i class="ti ti-activity"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ number_format($todayLogins) }} <span class="fs-14 fw-normal text-muted">Hari Ini</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            <span class="badge bg-success text-white rounded-pill px-2 py-0.5"><i class="ti ti-circle-filled fs-xxs me-1"></i>{{ $activeOnlineCount }} Online</span>
                            <span>Sesi saat ini</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Kesehatan Sistem & Backup DB -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Backup DB &amp; Sistem</span>
                            <div class="kpi-icon-box bg-warning-subtle text-warning">
                                <i class="ti ti-database"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ count($backupFiles) }} <span class="fs-14 fw-normal text-muted">Arsip</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            @if ($isMaintenance)
                                <span class="badge bg-danger-subtle text-danger"><i class="ti ti-tool me-1"></i>Maintenance On</span>
                            @else
                                <span class="badge bg-success-subtle text-success"><i class="ti ti-shield-check me-1"></i>Sistem Normal</span>
                            @endif
                            <span>{{ round($totalBackupSize / 1024 / 1024, 2) }} MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. GRAFIK ANALITIK APEXCHARTS (ADMIN) -->
        <div class="row g-3 mb-4">
            <!-- Grafik Tren Login 7 Hari -->
            <div class="col-xl-8">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-chart-area-line text-primary me-1.5"></i>Tren Aktivitas Login &amp; Pendaftaran (7 Hari Terakhir)
                        </h5>
                        <span class="badge bg-primary-subtle text-primary fs-xs font-monospace">Real-Time Sync</span>
                    </div>
                    <div class="card-body p-3">
                        <div id="chart-logins-trend"></div>
                    </div>
                </div>
            </div>

            <!-- Grafik Donut Distribusi Role -->
            <div class="col-xl-4">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-chart-pie text-primary me-1.5"></i>Distribusi Peran Pengguna
                        </h5>
                        <span class="badge bg-light text-dark border fs-xs">Spatie Roles</span>
                    </div>
                    <div class="card-body p-3">
                        <div id="chart-roles-donut"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. PUSAT AKSI TERTUNDA & PINTASAN CEPAT (ADMIN) -->
        <div class="row g-3 mb-4">
            <!-- Pusat Aksi Tertunda (Pending Approvals & Deactivations) -->
            <div class="col-xl-7">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-white mb-0 fw-bold">
                            <i class="ti ti-bell-ringing me-1.5"></i>Pusat Tindakan &amp; Permohonan Tertunda
                        </h5>
                        <span class="badge bg-white text-primary fw-bold font-monospace">
                            {{ $userStats['pending'] + $userStats['pending_deactivations'] }} Menunggu
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-bordered px-3 pt-2 bg-light-subtle" role="tablist">
                            <li class="nav-item">
                                <a href="#tab-pending-approvals" data-bs-toggle="tab" aria-expanded="true" class="nav-link active py-2 fs-13">
                                    <i class="ti ti-user-plus me-1.5"></i>Pendaftaran Baru ({{ $pendingApprovals->count() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-pending-deactivations" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2 fs-13">
                                    <i class="ti ti-user-x me-1.5"></i>Permohonan Nonaktif ({{ $pendingDeactivations->count() }})
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3">
                            <!-- Tab Pendaftaran Baru -->
                            <div class="tab-pane show active" id="tab-pending-approvals">
                                @if ($pendingApprovals->isEmpty())
                                    <div class="text-center py-4 text-muted">
                                        <i class="ti ti-circle-check fs-24 text-success d-block mb-1.5"></i>
                                        <p class="fs-13 mb-0">Tidak ada pendaftaran pengguna baru yang menunggu persetujuan.</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0 dashboard-mini-table">
                                            <thead class="align-middle text-center text-nowrap">
                                                <tr>
                                                    <th>Pengguna</th>
                                                    <th>Email</th>
                                                    <th>Waktu Daftar</th>
                                                    <th>Aksi Cepat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendingApprovals as $pUser)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img src="{{ $pUser->avatar_url }}" alt="{{ $pUser->name }}" class="dashboard-user-avatar">
                                                                <span class="fw-semibold text-dark">{{ $pUser->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-muted">{{ $pUser->email }}</td>
                                                        <td class="text-center text-muted fs-12">{{ $pUser->created_at->diffForHumans() }}</td>
                                                        <td class="text-center">
                                                            <form action="{{ route('admin.manajemenpengguna.users.approve', $pUser->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="button" class="btn btn-xs btn-success text-white px-2 py-1 rounded btn-quick-approve-user" data-user-name="{{ $pUser->name }}" title="Setujui &amp; Aktifkan Akun">
                                                                    <i class="ti ti-check me-1"></i>Setujui
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('admin.manajemenpengguna.users.index') }}" class="btn btn-xs btn-light border px-2 py-1 rounded" title="Lihat di Tabel Pengguna">
                                                                <i class="ti ti-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <!-- Tab Permohonan Nonaktif -->
                            <div class="tab-pane" id="tab-pending-deactivations">
                                @if ($pendingDeactivations->isEmpty())
                                    <div class="text-center py-4 text-muted">
                                        <i class="ti ti-circle-check fs-24 text-success d-block mb-1.5"></i>
                                        <p class="fs-13 mb-0">Tidak ada permohonan penonaktifan akun yang menunggu tindakan.</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0 dashboard-mini-table">
                                            <thead class="align-middle text-center text-nowrap">
                                                <tr>
                                                    <th>Pengguna</th>
                                                    <th>Alasan Permohonan</th>
                                                    <th>Diajukan</th>
                                                    <th>Aksi Cepat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendingDeactivations as $dUser)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <img src="{{ $dUser->avatar_url }}" alt="{{ $dUser->name }}" class="dashboard-user-avatar">
                                                                <span class="fw-semibold text-dark">{{ $dUser->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-muted fs-12 text-truncate" style="max-width: 180px;">
                                                            {{ $dUser->deactivation_reason ?? 'Tidak mencantumkan alasan' }}
                                                        </td>
                                                        <td class="text-center text-muted fs-12">{{ \Carbon\Carbon::parse($dUser->deactivation_requested_at)->diffForHumans() }}</td>
                                                        <td class="text-center">
                                                            <form action="{{ route('admin.manajemenpengguna.users.deactivate', $dUser->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="button" class="btn btn-xs btn-danger text-white px-2 py-1 rounded btn-quick-approve-deact" data-user-name="{{ $dUser->name }}" title="Setujui Penonaktifan">
                                                                    <i class="ti ti-check me-1"></i>Setujui
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('admin.manajemenpengguna.users.index') }}" class="btn btn-xs btn-light border px-2 py-1 rounded" title="Lihat di Tabel Pengguna">
                                                                <i class="ti ti-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pusat Pintasan Cepat Admin -->
            <div class="col-xl-5">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-bolt text-warning me-1.5"></i>Pusat Akses Pintas Admin
                        </h5>
                        <span class="badge bg-light text-dark border fs-xs">Shortcuts</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('admin.manajemenpengguna.users.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-primary-subtle text-primary">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Manajemen User</span>
                                    <span class="fs-xxs text-muted mt-0.5">Kelola data akun</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.manajemenpengguna.role.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-info-subtle text-info">
                                        <i class="ti ti-shield-lock"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Spatie Roles</span>
                                    <span class="fs-xxs text-muted mt-0.5">Matrix Hak Akses</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.dukunganaplikasi.fitur-aplikasi.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-danger-subtle text-danger">
                                        <i class="ti ti-settings-cog"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Pengaturan Fitur</span>
                                    <span class="fs-xxs text-muted mt-0.5">Maintenance &amp; Hub</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.dukunganaplikasi.backup-db.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-warning-subtle text-warning">
                                        <i class="ti ti-database"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Backup Database</span>
                                    <span class="fs-xxs text-muted mt-0.5">Cadangkan data SQL</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.manajemenpengguna.data-login.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-success-subtle text-success">
                                        <i class="ti ti-chart-bar"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Log Aktivitas</span>
                                    <span class="fs-xxs text-muted mt-0.5">Data Login Harian</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('template.documentation.changelog') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-secondary-subtle text-secondary">
                                        <i class="ti ti-git-branch"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Riwayat Rilis</span>
                                    <span class="fs-xxs text-muted mt-0.5">Changelog v{{ config('app.version', '2.6.0') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. FEED AKTIVITAS LOGIN TERKINI & PESAN (ADMIN) -->
        <div class="row g-3 mb-4">
            <!-- Tabel Aktivitas Login Terkini -->
            <div class="col-xl-8">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-history text-primary me-1.5"></i>Riwayat Aktivitas Login Pengguna Terkini
                        </h5>
                        <a href="{{ route('admin.manajemenpengguna.data-login.index') }}" class="btn btn-xs btn-light border px-2.5 py-1 rounded">
                            Lihat Semua Log <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 dashboard-mini-table">
                                <thead class="align-middle text-center text-nowrap">
                                    <tr>
                                        <th>Pengguna</th>
                                        <th>Peran</th>
                                        <th>Alamat IP</th>
                                        <th>Perangkat / Browser</th>
                                        <th>Waktu Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentLogins as $lLog)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $lLog->user?->avatar_url ?? asset('assets/images/users/default-avatar.svg') }}" alt="{{ $lLog->user->name ?? 'User' }}" class="dashboard-user-avatar">
                                                    <div>
                                                        <span class="fw-semibold text-dark d-block">{{ $lLog->user->name ?? 'User #' . $lLog->user_id }}</span>
                                                        <span class="text-muted fs-xxs">{{ $lLog->user->email ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($lLog->user && $lLog->user->roles->isNotEmpty())
                                                    @foreach ($lLog->user->roles as $r)
                                                        <span class="badge bg-secondary-subtle text-dark fs-xxs">{{ strtoupper($r->name) }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="badge bg-light text-muted fs-xxs">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center font-monospace fs-12 text-muted">{{ $lLog->ip_address }}</td>
                                            <td class="text-center text-muted fs-12">
                                                <i class="ti ti-device-desktop me-1"></i>{{ $lLog->user_agent ? Str::limit($lLog->user_agent, 24) : 'Web Client' }}
                                            </td>
                                            <td class="text-center text-muted fs-12">
                                                {{ \Carbon\Carbon::parse($lLog->login_at)->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat aktivitas login tercatat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesan & Obrolan Terkini -->
            <div class="col-xl-4">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-messages text-primary me-1.5"></i>Pesan &amp; Obrolan Terkini
                        </h5>
                        <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-xs btn-primary bg-primary text-white px-2.5 py-1 rounded">
                            Buka Chat Hub
                        </a>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column">
                            @forelse ($recentMessages as $msg)
                                @php
                                    $isMe = $msg->sender_id === auth()->id();
                                    $partner = $isMe ? $msg->receiver : $msg->sender;
                                @endphp
                                <a href="{{ route('admin.profil-pengguna.messages.index', ['user_id' => $partner->id ?? '']) }}" class="chat-preview-item">
                                    <div class="chat-avatar-wrapper">
                                        <img src="{{ $partner?->avatar_url ?? asset('assets/images/users/default-avatar.svg') }}" alt="{{ $partner->name ?? 'User' }}" class="chat-preview-avatar">
                                    </div>
                                    <div class="chat-content-box">
                                        <div class="chat-preview-header">
                                            <span class="chat-preview-name">{{ $partner->name ?? 'Pengguna' }}</span>
                                            <span class="chat-preview-time"><i class="ti ti-clock me-1"></i>{{ $msg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="chat-preview-body mb-0">
                                            @if ($isMe)
                                                <span class="text-primary fw-semibold me-1">Anda:</span>
                                            @endif
                                            {{ $msg->body ?: ($msg->attachment_name ? 'Mengirim lampiran berkas' : ($msg->reason ? 'Alasan: ' . $msg->reason : 'Pesan')) }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="ti ti-message-off fs-24 text-muted d-block mb-1.5"></i>
                                    <p class="fs-13 mb-0">Belum ada obrolan terkini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- ========================================================================= -->
        <!-- 👤 DASHBOARD KHUSUS PENGGUNA UMUM (ROLE: USER)                            -->
        <!-- ========================================================================= -->

        <!-- 2. KPI METRIC STATS CARDS (USER) -->
        <div class="row g-3 mb-4">
            <!-- Card 1: Pesan Masuk -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Pesan &amp; Obrolan</span>
                            <div class="kpi-icon-box bg-primary-subtle text-primary">
                                <i class="ti ti-messages"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ $myRecentMessages->count() }} <span class="fs-14 fw-normal text-muted">Obrolan</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            @if ($unreadMessagesCount > 0)
                                <span class="badge bg-danger text-white">{{ $unreadMessagesCount }} Belum Dibaca</span>
                            @else
                                <span class="badge bg-success-subtle text-success"><i class="ti ti-check me-1"></i>Semua Terbaca</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Notifikasi Sistem -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Notifikasi Saya</span>
                            <div class="kpi-icon-box bg-info-subtle text-info">
                                <i class="ti ti-bell"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ $myNotifications->count() }} <span class="fs-14 fw-normal text-muted">Pemberitahuan</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            @if ($unreadNotificationsCount > 0)
                                <span class="badge bg-warning text-dark">{{ $unreadNotificationsCount }} Baru</span>
                            @else
                                <span class="badge bg-success-subtle text-success"><i class="ti ti-check me-1"></i>Terpantau</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Poin Aktivitas Login -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Poin Login Saya</span>
                            <div class="kpi-icon-box bg-warning-subtle text-warning">
                                <i class="ti ti-award"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ number_format($myPoints) }} <span class="fs-14 fw-normal text-muted">Poin</span></h2>
                        <div class="d-flex align-items-center gap-1.5 fs-12 text-muted">
                            <i class="ti ti-chart-line text-success"></i>
                            <span>Total <strong>{{ $totalMyLogins }}x</strong> sesi masuk aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Kelengkapan Profil -->
            <div class="col-sm-6 col-xl-3">
                <div class="card kpi-card shadow-sm h-100 mb-0">
                    <div class="card-body p-3.5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13 fw-semibold text-uppercase">Kelengkapan Profil</span>
                            <div class="kpi-icon-box bg-success-subtle text-success">
                                <i class="ti ti-user-check"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-1.5 text-dark">{{ $completenessPercent }}%</h2>
                        <div class="completeness-progress-container mb-1">
                            <div class="completeness-progress-bar bg-success" style="width: {{ $completenessPercent }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. PUSAT PINTASAN PENGGUNA & RINGKASAN PROFIL (USER) -->
        <div class="row g-3 mb-4">
            <!-- Pusat Pintasan Pengguna -->
            <div class="col-xl-7">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-bolt text-warning me-1.5"></i>Pusat Akses Pintas Pengguna
                        </h5>
                        <span class="badge bg-light text-dark border fs-xs">Shortcuts</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <a href="{{ route('admin.profil-pengguna.edit') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-primary-subtle text-primary">
                                        <i class="ti ti-user-edit"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Edit Profil &amp; Foto</span>
                                    <span class="fs-xxs text-muted mt-0.5">Perbarui biodata dan avatar</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-info-subtle text-info">
                                        <i class="ti ti-messages"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Pesan &amp; Obrolan</span>
                                    <span class="fs-xxs text-muted mt-0.5">Komunikasi dengan rekan</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('admin.profil-pengguna.index') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-success-subtle text-success">
                                        <i class="ti ti-id"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Kartu Profil Saya</span>
                                    <span class="fs-xxs text-muted mt-0.5">Lihat pratinjau publik</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('template.documentation.changelog') }}" class="quick-action-tile">
                                    <div class="quick-action-icon bg-secondary-subtle text-secondary">
                                        <i class="ti ti-git-branch"></i>
                                    </div>
                                    <span class="fw-semibold fs-13 text-center">Riwayat &amp; Rilis</span>
                                    <span class="fs-xxs text-muted mt-0.5">Changelog Sistem</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Status Profil & Akun -->
            <div class="col-xl-5">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-shield-check text-primary me-1.5"></i>Status Akun &amp; Keamanan
                        </h5>
                        <span class="badge bg-success-subtle text-success">Aktif &amp; Terverifikasi</span>
                    </div>
                    <div class="card-body p-3.5">
                        <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle border" style="width: 54px; height: 54px; object-fit: cover; object-position: top;">
                            <div>
                                <h6 class="fw-bold mb-0.5 text-dark">{{ $user->name }}</h6>
                                <span class="text-muted fs-12 d-block mb-1">{{ $user->email }}</span>
                                <span class="badge bg-primary-subtle text-primary fs-xxs">Pengguna Terdaftar</span>
                            </div>
                        </div>
                        <div class="fs-13 text-muted">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Bergabung Sejak:</span>
                                <strong class="text-dark">{{ $user->created_at->translatedFormat('d F Y') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Sesi Masuk:</span>
                                <strong class="text-dark">{{ $totalMyLogins }} Kali</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Status Keamanan:</span>
                                <span class="text-success fw-semibold"><i class="ti ti-lock me-1"></i>Terkonfigurasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. RIWAYAT LOGIN PRIBADI & OBROLAN SAYA (USER) -->
        <div class="row g-3 mb-4">
            <!-- Riwayat Login Akun Sendiri -->
            <div class="col-xl-7">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-history text-primary me-1.5"></i>Riwayat Aktivitas Masuk Akun Saya
                        </h5>
                        <span class="badge bg-light text-dark border fs-xs">Recent Logins</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 dashboard-mini-table">
                                <thead class="align-middle text-center text-nowrap">
                                    <tr>
                                        <th>Alamat IP</th>
                                        <th>Perangkat / Browser</th>
                                        <th>Waktu Masuk</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($myRecentLogins as $mLog)
                                        <tr>
                                            <td class="text-center font-monospace fs-12 text-dark fw-semibold">{{ $mLog->ip_address }}</td>
                                            <td class="text-center text-muted fs-12">
                                                <i class="ti ti-device-desktop me-1"></i>{{ $mLog->user_agent ? Str::limit($mLog->user_agent, 28) : 'Web Client' }}
                                            </td>
                                            <td class="text-center text-muted fs-12">
                                                {{ \Carbon\Carbon::parse($mLog->login_at)->translatedFormat('d M Y, H:i') }} WIB
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success-subtle text-success fs-xxs"><i class="ti ti-check me-1"></i>Berhasil</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada catatan aktivitas masuk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Percakapan Obrolan Terkini -->
            <div class="col-xl-5">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="ti ti-messages text-primary me-1.5"></i>Obrolan &amp; Pesan Saya
                        </h5>
                        <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-xs btn-primary bg-primary text-white px-2.5 py-1 rounded">
                            Buka Chat
                        </a>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column">
                            @forelse ($myRecentMessages as $msg)
                                @php
                                    $isMe = $msg->sender_id === auth()->id();
                                    $partner = $isMe ? $msg->receiver : $msg->sender;
                                @endphp
                                <a href="{{ route('admin.profil-pengguna.messages.index', ['user_id' => $partner->id ?? '']) }}" class="chat-preview-item">
                                    <div class="chat-avatar-wrapper">
                                        <img src="{{ $partner?->avatar_url ?? asset('assets/images/users/default-avatar.svg') }}" alt="{{ $partner->name ?? 'User' }}" class="chat-preview-avatar">
                                    </div>
                                    <div class="chat-content-box">
                                        <div class="chat-preview-header">
                                            <span class="chat-preview-name">{{ $partner->name ?? 'Pengguna' }}</span>
                                            <span class="chat-preview-time"><i class="ti ti-clock me-1"></i>{{ $msg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="chat-preview-body mb-0">
                                            @if ($isMe)
                                                <span class="text-primary fw-semibold me-1">Anda:</span>
                                            @endif
                                            {{ $msg->body ?: ($msg->attachment_name ? 'Mengirim lampiran berkas' : ($msg->reason ? 'Alasan: ' . $msg->reason : 'Pesan')) }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="ti ti-message-off fs-24 text-muted d-block mb-1.5"></i>
                                    <p class="fs-13 mb-0">Belum ada obrolan terkini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 6. WIDGET DIREKTORI DATA PENGGUNA & KONTAK (FULL WIDTH) -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-0">
                <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center">
                            <i class="ti ti-users text-primary me-2 fs-18"></i>Direktori Pengguna &amp; Jaringan Pertemanan
                        </h5>
                        <p class="text-muted fs-12 mb-0 mt-0.5">Temukan rekan kerja, kirim ajakan berteman, berikan apresiasi suka pada profil, dan mulai berkomunikasi.</p>
                    </div>

                    <!-- Filter Pertemanan Tabs & Search Input -->
                    <div class="d-flex flex-wrap align-items-center gap-2.5">
                        <div class="btn-group btn-group-sm friendship-filter-group" role="group" aria-label="Filter Pertemanan">
                            <button type="button" class="btn btn-outline-primary active btn-friend-filter" data-filter="all">
                                <i class="ti ti-users me-1"></i>Semua <span class="badge bg-primary text-white rounded-pill ms-1 fs-xxs">{{ $contactUsers->count() }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter" data-filter="friends">
                                <i class="ti ti-user-check me-1"></i>Teman Saya <span class="badge bg-success text-white rounded-pill ms-1 fs-xxs">{{ $totalFriendsCount }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter" data-filter="incoming">
                                <i class="ti ti-user-plus me-1"></i>Ajakan Masuk
                                @if ($incomingFriendRequestsCount > 0)
                                    <span class="badge bg-danger text-white rounded-pill ms-1 fs-xxs">{{ $incomingFriendRequestsCount }}</span>
                                @endif
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter" data-filter="outgoing">
                                <i class="ti ti-clock-pause me-1"></i>Ajakan Terkirim
                                @if ($outgoingFriendRequestsCount > 0)
                                    <span class="badge bg-warning text-dark rounded-pill ms-1 fs-xxs">{{ $outgoingFriendRequestsCount }}</span>
                                @endif
                            </button>
                        </div>

                        <div class="app-search" style="min-width: 250px;">
                            <input type="text" id="dashboard-contact-search" class="form-control" style="padding-left: 40px !important;" placeholder="Cari nama, email, no. telepon/WA...">
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3.5">
                    <div class="row g-3" id="dashboard-contacts-grid">
                        @forelse ($contactUsers as $cUser)
                            @php
                                $isMe = $cUser->id === auth()->id();
                                $fStatus = $cUser->friendship_status ?? 'none';
                                $fModel = $cUser->friendship_model;
                                $isLiked = $cUser->is_liked_by_me ?? false;
                                $likesTotal = $cUser->profile_likes_count ?? 0;
                            @endphp
                            <div class="col-sm-6 col-lg-4 col-xl-3 dashboard-contact-col"
                                data-search-name="{{ strtolower($cUser->name) }}"
                                data-search-email="{{ strtolower($cUser->email) }}"
                                data-search-phone="{{ strtolower($cUser->detail->telepon ?? '') }}"
                                data-search-city="{{ strtolower($cUser->detail->kabupaten_kota ?? '') }}"
                                data-search-job="{{ strtolower($cUser->detail->pekerjaan ?? '') }}"
                                data-friendship-status="{{ $fStatus }}"
                                data-user-id="{{ $cUser->id }}">
                                <div class="card card-h-100 border shadow-sm rounded-3 overflow-hidden mb-0 contact-grid-card">
                                    <!-- Cover Banner Background -->
                                    <div class="position-relative contact-grid-cover overflow-hidden"
                                        style="height: 115px; background-image: url('{{ $cUser->cover_bg_url }}'); background-position: center {{ $cUser->cover_position_y }}%;">
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 p-2 d-flex flex-column justify-content-between contact-grid-cover-overlay">
                                            <!-- Top Badges (Online + Like Action) -->
                                            <div class="d-flex justify-content-between align-items-start">
                                                <span class="badge {{ $cUser->is_online ? 'bg-success text-white' : 'bg-dark bg-opacity-75 text-white-50' }} fs-xxs py-0.5 px-1.5 rounded-pill shadow-sm"
                                                    title="{{ $cUser->is_online ? 'Online Sekarang' : $cUser->last_seen_human }}">
                                                    <i class="ti {{ $cUser->is_online ? 'ti-circle-filled text-white' : 'ti-clock' }} me-0.5"></i>
                                                    {{ $cUser->is_online ? 'Online' : 'Offline' }}
                                                </span>

                                                <!-- Like Button / Counter Float Badge -->
                                                @if ($isMe)
                                                    <span class="badge bg-dark bg-opacity-75 text-white fs-xxs py-1 px-2 rounded-pill shadow-sm" title="Total like profil Anda">
                                                        <i class="ti ti-heart-filled text-danger me-1"></i><span class="like-count">{{ $likesTotal }}</span> Suka
                                                    </span>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-xs rounded-pill contact-like-btn {{ $isLiked ? 'liked active' : '' }}"
                                                        data-user-id="{{ $cUser->id }}"
                                                        data-user-name="{{ $cUser->name }}"
                                                        title="{{ $isLiked ? 'Batal Suka Profil' : 'Sukai Profil Pengguna Ini' }}">
                                                        <i class="ti {{ $isLiked ? 'ti-heart-filled text-danger' : 'ti-heart text-white' }} fs-12 me-1"></i>
                                                        <span class="like-count fw-bold">{{ $likesTotal }}</span>
                                                    </button>
                                                @endif
                                            </div>

                                            @if (!empty($cUser->motto))
                                                <div class="text-center px-1 pb-3 mb-1">
                                                    <p class="text-white mb-0 fst-italic contact-cover-motto"
                                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                                                        title="{{ $cUser->motto }}">
                                                        "{{ $cUser->motto }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-3 text-center d-flex flex-column">
                                        <!-- Overlapping Avatar -->
                                        <div class="position-relative d-inline-block mx-auto mb-2" style="margin-top: -42px;">
                                            <img src="{{ $cUser->avatar_url }}" alt="{{ $cUser->name }}"
                                                class="rounded-circle border border-3 border-white shadow-sm contact-grid-avatar">
                                            <span class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle {{ $cUser->is_online ? 'bg-success' : 'bg-secondary opacity-50' }}"
                                                style="width: 12px; height: 12px; transform: translate(10%, 10%);"></span>
                                        </div>

                                        <h5 class="fw-bold text-dark fs-14 mb-0.5 text-truncate" title="{{ $cUser->name }}">
                                            {{ $cUser->name }}
                                            @if ($isMe)
                                                <span class="badge bg-primary text-white fs-xxs ms-1">Anda</span>
                                            @elseif ($fStatus === 'friends')
                                                <span class="badge bg-success-subtle text-success fs-xxs ms-1" title="Sudah Berteman"><i class="ti ti-user-check me-0.5"></i>Teman</span>
                                            @elseif ($fStatus === 'pending_sent')
                                                <span class="badge bg-warning-subtle text-warning fs-xxs ms-1" title="Menunggu Respon Ajakan"><i class="ti ti-clock me-0.5"></i>Terkirim</span>
                                            @elseif ($fStatus === 'pending_received')
                                                <span class="badge bg-info-subtle text-info fs-xxs ms-1" title="Mengajak Anda Berteman"><i class="ti ti-user-plus me-0.5"></i>Ajakan Masuk</span>
                                            @endif
                                        </h5>
                                        <p class="text-muted fs-12 mb-2 text-truncate" title="{{ $cUser->email }}">
                                            <i class="ti ti-mail me-1"></i>{{ $cUser->email }}
                                        </p>

                                        <!-- Meta Info List -->
                                        <ul class="list-unstyled text-muted fs-12 text-start mb-3 mt-auto pt-2 border-top">
                                            <li class="d-flex align-items-center justify-content-between mb-1.5">
                                                <span class="text-muted"><i class="ti ti-briefcase me-1 text-primary"></i>Pekerjaan:</span>
                                                <strong class="text-dark text-truncate ps-2" style="max-width: 140px;">
                                                    {{ $cUser->detail->pekerjaan ?? 'Belum diisi' }}
                                                </strong>
                                            </li>
                                            <li class="d-flex align-items-center justify-content-between mb-1.5">
                                                <span class="text-muted"><i class="ti ti-brand-whatsapp me-1 text-success"></i>Telepon / WA:</span>
                                                @if (!empty($cUser->detail?->telepon))
                                                    <a href="{{ $cUser->detail->telepon_wa_url }}" target="_blank"
                                                        class="text-success fw-semibold text-truncate ps-2 text-decoration-none d-inline-flex align-items-center"
                                                        style="max-width: 140px;" title="Hubungi via WhatsApp ({{ $cUser->detail->telepon }})">
                                                        {{ $cUser->detail->telepon }} <i class="ti ti-external-link fs-10 ms-1"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted fw-normal fst-italic ps-2">Belum diisi</span>
                                                @endif
                                            </li>
                                            <li class="d-flex align-items-center justify-content-between mb-1.5">
                                                <span class="text-muted"><i class="ti ti-map-pin me-1 text-danger"></i>Domisili:</span>
                                                <strong class="text-dark text-truncate ps-2" style="max-width: 140px;">
                                                    {{ $cUser->detail->kabupaten_kota ?? 'Belum diisi' }}
                                                </strong>
                                            </li>
                                            <li class="d-flex align-items-center justify-content-between mb-1.5">
                                                <span class="text-muted"><i class="ti ti-award me-1 text-warning"></i>Poin Login:</span>
                                                <strong class="text-dark">{{ number_format($cUser->login_count ?? 0) }} Poin</strong>
                                            </li>
                                            <li class="d-flex align-items-center justify-content-between">
                                                <span class="text-muted"><i class="ti ti-calendar me-1 text-info"></i>Bergabung:</span>
                                                <span class="text-dark">{{ $cUser->created_at->format('d M Y') }}</span>
                                            </li>
                                        </ul>

                                        <!-- Smart Friendship & Chat Action Buttons -->
                                        <div class="d-flex gap-1.5 justify-content-center contact-action-wrapper" data-user-id="{{ $cUser->id }}">
                                            @if ($isMe)
                                                <a href="{{ route('admin.profil-pengguna.index') }}"
                                                    class="btn btn-sm btn-light border text-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-1">
                                                    <i class="ti ti-user"></i> Profil Saya
                                                </a>
                                            @elseif ($fStatus === 'friends')
                                                <div class="d-flex gap-1.5 w-100">
                                                    <a href="{{ route('admin.profil-pengguna.messages.index', ['user_id' => $cUser->id]) }}"
                                                        class="btn btn-sm btn-primary bg-primary text-white flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1">
                                                        <i class="ti ti-messages"></i> Chat
                                                    </a>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm btn-success-subtle text-success border border-success-subtle dropdown-toggle fw-semibold px-2"
                                                            data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pertemanan">
                                                            <i class="ti ti-user-check me-0.5"></i> Teman
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger d-flex align-items-center gap-1.5 btn-unfriend-action"
                                                                    data-user-id="{{ $cUser->id }}" data-user-name="{{ $cUser->name }}">
                                                                    <i class="ti ti-user-x text-danger"></i> Hapus Pertemanan
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @elseif ($fStatus === 'pending_sent')
                                                <button type="button" class="btn btn-sm btn-warning-subtle text-warning border border-warning-subtle w-100 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-cancel-friend-action"
                                                    data-user-id="{{ $cUser->id }}" data-user-name="{{ $cUser->name }}">
                                                    <i class="ti ti-clock-pause"></i> Menunggu Respon <span class="badge bg-warning text-dark fs-xxs ms-1">Batal</span>
                                                </button>
                                            @elseif ($fStatus === 'pending_received')
                                                <div class="d-flex gap-1.5 w-100">
                                                    <button type="button" class="btn btn-sm btn-success text-white flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-accept-friend-action"
                                                        data-friendship-id="{{ $fModel->id ?? '' }}" data-user-name="{{ $cUser->name }}">
                                                        <i class="ti ti-check"></i> Terima
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 fw-semibold btn-reject-friend-action"
                                                        data-friendship-id="{{ $fModel->id ?? '' }}" data-user-name="{{ $cUser->name }}" title="Tolak Ajakan">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="d-flex gap-1.5 w-100">
                                                    <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-add-friend-action"
                                                        data-user-id="{{ $cUser->id }}" data-user-name="{{ $cUser->name }}">
                                                        <i class="ti ti-user-plus"></i> Tambah Teman
                                                    </button>
                                                    <a href="{{ route('admin.profil-pengguna.messages.index', ['user_id' => $cUser->id]) }}"
                                                        class="btn btn-sm btn-light border text-muted px-2" title="Kirim Pesan Langsung">
                                                        <i class="ti ti-messages"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i class="ti ti-users-minus fs-32 text-muted mb-2 d-block"></i>
                                <p class="fs-13 mb-0">Belum ada data pengguna aktif terdaftar.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="dashboard-contacts-empty" class="text-center py-5 text-muted d-none">
                        <i class="ti ti-search-off fs-32 text-muted mb-2 d-block"></i>
                        <p class="fs-13 mb-0">Tidak ada pengguna yang cocok dengan filter atau kriteria pencarian.</p>
                    </div>

                    <!-- Tombol Anak Panah Muat Lebih Banyak (Load More Down Arrow) -->
                    <div class="text-center pt-4 pb-2" id="dashboard-contacts-loadmore-container">
                        <button type="button" id="dashboard-contacts-loadmore-btn" class="btn btn-sm btn-outline-primary rounded-pill px-4 py-1.5 shadow-sm fw-semibold d-inline-flex align-items-center gap-1.5">
                            <span>Tampilkan 12 Pengguna Berikutnya</span>
                            <i class="ti ti-chevron-down fs-16 animated-bounce-down"></i>
                        </button>
                        <div class="text-muted fs-12 mt-3" id="dashboard-contacts-loadmore-info">
                            Menampilkan <span id="contacts-visible-count" class="fw-semibold text-dark">{{ min(12, $contactUsers->count()) }}</span> dari <span id="contacts-total-count" class="fw-semibold text-dark">{{ $contactUsers->count() }}</span> pengguna
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ApexCharts Plugin & Data Bridge (Rule 1 & Rule 15 Standard) -->
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        window.DashboardConfig = {
            userId: {{ auth()->id() }},
            routes: {
                toggleLike: "{{ url('admin/friendships/toggle-like') }}",
                sendFriend: "{{ url('admin/friendships/send') }}",
                acceptFriend: "{{ url('admin/friendships/accept') }}",
                rejectFriend: "{{ url('admin/friendships/reject') }}",
                cancelFriend: "{{ url('admin/friendships/cancel') }}",
                unfriend: "{{ url('admin/friendships/unfriend') }}",
                messagesIndex: "{{ route('admin.profil-pengguna.messages.index') }}",
                profileIndex: "{{ route('admin.profil-pengguna.index') }}"
            },
            @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
                chartDates: @json($chartDates ?? []),
                chartLogins: @json($chartLogins ?? []),
                chartRegistrations: @json($chartRegistrations ?? []),
                roleLabels: @json($rolesDistribution->pluck('name')->map(fn($n) => strtoupper($n))->values() ?? []),
                roleCounts: @json($rolesDistribution->pluck('users_count')->values() ?? [])
            @endif
        };
    </script>
    <script src="{{ asset('assets/js/admin/dashboard.js') }}"></script>
@endsection
