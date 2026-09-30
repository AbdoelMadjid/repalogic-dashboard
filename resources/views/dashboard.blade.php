@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/css/admin/dashboard.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />

@php
    $hex = ltrim($user->cover_color ?: '#313a46', '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $alpha = ($user->cover_opacity ?? 60) / 100;
    $rgbaCover = "rgba({$r}, {$g}, {$b}, {$alpha})";
    $rgbaTop = "rgba({$r}, {$g}, {$b}, " . max(0, $alpha - 0.25) . ")";
    $blurPx = (int) ($user->cover_blur ?? 0);
@endphp

    <!-- 1. HERO GREETING & PROFILE OVERVIEW CARD WITH USER CUSTOM COVER PHOTO -->
    <div class="row mt-3 mb-4">
        <div class="col-12">
            <div class="card dashboard-hero-card border-0 shadow-sm position-relative overflow-hidden" id="dashboard-hero-banner"
                style="min-height: {{ $user->cover_height }}px; background-image: url('{{ $user->cover_bg_url }}'); background-position: center {{ $user->cover_position_y }}%;">
                <!-- Dynamic Overlay Layer (Color, Opacity & Blur Synchronization) -->
                <div class="position-absolute top-0 start-0 end-0 bottom-0 hero-overlay-layer" id="dashboard-hero-overlay"
                    style="background: linear-gradient(135deg, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none; z-index: 1;"></div>
                <div class="card-body p-3.5 p-sm-4 p-lg-4.5 d-flex align-items-center position-relative" style="z-index: 2;">
                    <div class="row align-items-center g-3 w-100 mx-0">
                        <div class="col-md-8 px-0">
                            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                                <!-- 1. Avatar Pengguna -->
                                <div class="hero-avatar-wrapper flex-shrink-0 text-center">
                                    <img src="{{ $user->avatar_url }}"
                                        alt="{{ $user->name }}" class="rounded-3 hero-avatar-img shadow">
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

                                <div class="text-center text-md-start w-100">
                                    <!-- 2 & 3. Selamat Sore, Nama Pengguna -->
                                    <h3 class="fw-bold text-white mb-1.5 fs-20 fs-md-22">
                                        {{ $greeting }}, {{ $user->name }}!
                                    </h3>

                                    <!-- 4. Login Terakhir -->
                                    @if ($lastLoginRecord)
                                        <p class="text-white-50 fs-13 mb-2.5">
                                            Login terakhir Anda tercatat pada <span class="text-white fw-semibold">{{ \Carbon\Carbon::parse($lastLoginRecord->login_at)->translatedFormat('d M Y, H:i') }} WIB</span>
                                            dari IP <span class="badge bg-white bg-opacity-20 text-white font-monospace">{{ $lastLoginRecord->ip_address }}</span>.
                                        </p>
                                    @endif

                                    <!-- 5, 6, 7, 8. Email, Role, Teman & Suka, Poin Login -->
                                    <div class="d-flex flex-column flex-md-row flex-md-wrap align-items-center justify-content-center justify-content-md-start gap-2 gap-md-2.5 text-white-50 fs-13 mb-2">
                                        <!-- 5. Email -->
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-mail text-white-50 me-1.5"></i>
                                            <span class="text-white fw-medium">{{ $user->email }}</span>
                                        </div>

                                        <span class="text-white-50 opacity-25 d-none d-md-inline">•</span>

                                        <!-- 6. Role -->
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-shield-check text-white-50 me-1.5"></i>
                                            <span class="text-white fw-medium">{{ $primaryRoleName }}</span>
                                        </div>

                                        <span class="text-white-50 opacity-25 d-none d-md-inline">•</span>

                                        <!-- 7. Teman & Suka -->
                                        <div class="d-flex align-items-center gap-2.5">
                                            <div class="d-flex align-items-center" title="Total Teman Terhubung">
                                                <i class="ti ti-friends text-info me-1.5"></i>
                                                <span class="text-white fw-medium" id="hero-friends-count">{{ number_format($totalFriendsCount) }} Teman</span>
                                            </div>
                                            <span class="text-white-50 opacity-25">•</span>
                                            <div class="d-flex align-items-center" title="Total Suka Profil yang Diterima">
                                                <i class="ti ti-heart-filled text-danger me-1.5" id="hero-likes-icon"></i>
                                                <span class="text-white fw-medium" id="hero-likes-count">{{ number_format($totalProfileLikesCount) }} Suka</span>
                                            </div>
                                        </div>

                                        <span class="text-white-50 opacity-25 d-none d-md-inline">•</span>

                                        <!-- 8. Point Login -->
                                        <div class="d-flex align-items-center" title="Total Poin Login yang Dikumpulkan">
                                            <i class="ti ti-award text-warning me-1.5"></i>
                                            <span class="text-white fw-medium">{{ number_format($user->login_count ?? 0) }} Poin Login</span>
                                        </div>
                                    </div>

                                    <!-- 9. Moto Hidup -->
                                    @if (!empty($user->motto))
                                        @php
                                            $heroMottoColor = $user->motto_color ?: '#ffffff';
                                            $isDarkHeroMotto = in_array(strtolower($heroMottoColor), ['#000000', '#111827', '#1f2937', '#0f172a', 'black']);
                                            $heroMottoShadow = $isDarkHeroMotto ? '0 1px 6px rgba(255, 255, 255, 0.85)' : '0 1px 6px rgba(0, 0, 0, 0.85)';
                                        @endphp
                                        <div class="pt-2 d-flex align-items-center justify-content-center justify-content-md-start gap-1.5 fs-12 fst-italic hero-user-motto"
                                            id="dashboard-hero-motto"
                                            style="color: {{ $heroMottoColor }}; text-shadow: {{ $heroMottoShadow }};"
                                            title="Motto Hidup: {{ $user->motto }}">
                                            <i class="ti ti-quote me-1"></i><span id="dashboard-hero-motto-text">"{{ $user->motto }}"</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- 10. Tombol Profil Saya & Buka Chat -->
                        <div class="col-md-4 text-center text-md-end px-0 mt-3 mt-md-0">
                            <div class="d-inline-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                                <a href="{{ route('admin.profil-pengguna.index') }}" class="btn btn-sm btn-light text-dark fw-semibold px-3.5 py-1.5 rounded-pill shadow-sm">
                                    <i class="ti ti-user me-1.5"></i>Profil Saya
                                </a>
                                <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-sm btn-primary bg-primary text-white fw-semibold px-3.5 py-1.5 rounded-pill shadow-sm">
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-chart-area-line text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Tren Aktivitas Login &amp; Pendaftaran (7 Hari Terakhir)</span>
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-chart-pie text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Distribusi Peran Pengguna</span>
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
            <div class="col-xl-6">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title text-white mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-bell-ringing me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Pusat Tindakan &amp; Permohonan Tertunda</span>
                        </h5>
                        <span class="badge bg-white text-primary fw-bold font-monospace">
                            {{ $userStats['pending'] + $userStats['pending_deactivations'] }} Menunggu
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-bordered px-3 pt-2 bg-light-subtle" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active py-2 fs-13" id="tab-pending-approvals-btn" data-bs-toggle="tab" data-bs-target="#tab-pending-approvals" role="tab" aria-controls="tab-pending-approvals" aria-selected="true" title="Pendaftaran Baru ({{ $pendingApprovals->count() }})">
                                    <i class="ti ti-user-plus me-0 me-md-1.5"></i>
                                    <span class="d-none d-md-inline">Pendaftaran Baru</span>
                                    <span class="badge bg-primary-subtle text-primary ms-1 font-monospace">{{ $pendingApprovals->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link py-2 fs-13" id="tab-pending-deactivations-btn" data-bs-toggle="tab" data-bs-target="#tab-pending-deactivations" role="tab" aria-controls="tab-pending-deactivations" aria-selected="false" title="Permohonan Nonaktif ({{ $pendingDeactivations->count() }})">
                                    <i class="ti ti-user-x me-0 me-md-1.5"></i>
                                    <span class="d-none d-md-inline">Permohonan Nonaktif</span>
                                    <span class="badge bg-danger-subtle text-danger ms-1 font-monospace">{{ $pendingDeactivations->count() }}</span>
                                </button>
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

            <!-- Pusat Pintasan Cepat Admin (Manajemen Pengguna & Dukungan Aplikasi) -->
            <div class="col-xl-6">
                <div class="card shadow-sm border-0 h-100 mb-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-bolt text-warning me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Pusat Akses Pintas Modul</span>
                        </h5>
                        <span class="badge bg-primary-subtle text-primary font-monospace">12 Modul Utama</span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-bordered px-3 pt-2 bg-light-subtle" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active py-2 fs-13" id="tab-shortcut-users-btn" data-bs-toggle="tab" data-bs-target="#tab-shortcut-users" role="tab" aria-controls="tab-shortcut-users" aria-selected="true" title="Manajemen Pengguna (6 Modul)">
                                    <i class="ti ti-users me-0 me-md-1.5 text-primary"></i>
                                    <span class="d-none d-md-inline">Manajemen Pengguna</span>
                                    <span class="badge bg-primary-subtle text-primary ms-1 font-monospace">6</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link py-2 fs-13" id="tab-shortcut-app-btn" data-bs-toggle="tab" data-bs-target="#tab-shortcut-app" role="tab" aria-controls="tab-shortcut-app" aria-selected="false" title="Dukungan Aplikasi (6 Modul)">
                                    <i class="ti ti-settings-cog me-0 me-md-1.5 text-info"></i>
                                    <span class="d-none d-md-inline">Dukungan Aplikasi</span>
                                    <span class="badge bg-info-subtle text-info ms-1 font-monospace">6</span>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content p-3">
                            <!-- Tab 1: Manajemen Pengguna (6 Menu) -->
                            <div class="tab-pane show active" id="tab-shortcut-users">
                                <div class="row g-2">
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.users.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-primary-subtle text-primary">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Data Pengguna</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Kelola akun user</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.data-login.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-success-subtle text-success">
                                                <i class="ti ti-history"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Data Login</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Log aktivitas harian</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.role.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-info-subtle text-info">
                                                <i class="ti ti-shield-lock"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Role Pengguna</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Peran &amp; hirarki</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.permission.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-warning-subtle text-warning">
                                                <i class="ti ti-key"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Permission</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Master hak izin</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.akses-role.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-purple-subtle text-purple">
                                                <i class="ti ti-lock-access"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Akses Role</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Matriks izin peran</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.manajemenpengguna.akses-user.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-danger-subtle text-danger">
                                                <i class="ti ti-user-shield"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Akses User</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Izin langsung user</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Dukungan Aplikasi (6 Menu) -->
                            <div class="tab-pane" id="tab-shortcut-app">
                                <div class="row g-2">
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.profil-aplikasi.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-primary-subtle text-primary">
                                                <i class="ti ti-id"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Profil Aplikasi</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Identitas &amp; meta</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.fitur-aplikasi.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-danger-subtle text-danger">
                                                <i class="ti ti-settings-cog"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Fitur Aplikasi</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Pusat kontrol sistem</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.menu.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-info-subtle text-info">
                                                <i class="ti ti-layout-sidebar"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Manajemen Menu</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Navigasi sidebar</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.translation.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-success-subtle text-success">
                                                <i class="ti ti-language"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Kamus Bahasa</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Bilingual i18n</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.backup-db.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-warning-subtle text-warning">
                                                <i class="ti ti-database"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Backup Database</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Cadangan SQL server</span>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <a href="{{ route('admin.dukunganaplikasi.konfigurasi-website.index') }}" class="quick-action-tile">
                                            <div class="quick-action-icon bg-purple-subtle text-purple">
                                                <i class="ti ti-world-www"></i>
                                            </div>
                                            <span class="fw-semibold fs-13 text-center text-truncate w-100">Konfigurasi Web</span>
                                            <span class="fs-xxs text-muted mt-0.5 text-truncate w-100 text-center">Tema &amp; landing page</span>
                                        </a>
                                    </div>
                                </div>
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2.5 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-history text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Riwayat Aktivitas Login Pengguna Terkini</span>
                        </h5>
                        <a href="{{ route('admin.manajemenpengguna.data-login.index') }}" class="btn btn-xs btn-light border px-2.5 py-1.5 rounded" title="Lihat Semua Log">
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
                                                    <img src="{{ $lLog->user?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $lLog->user->name ?? 'User' }}" class="dashboard-user-avatar">
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2.5 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-messages text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Pesan &amp; Obrolan Terkini</span>
                        </h5>
                        <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-xs btn-primary bg-primary text-white px-2.5 py-1.5 rounded" title="Buka Chat Hub">
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
                                        <img src="{{ $partner?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $partner->name ?? 'User' }}" class="chat-preview-avatar">
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-bolt text-warning me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Pusat Akses Pintas Pengguna</span>
                        </h5>
                        <span class="badge bg-light text-dark border fs-xs">Shortcuts</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <a href="{{ route('admin.profil-pengguna.index') }}" class="quick-action-tile">
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-shield-check text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Status Akun &amp; Keamanan</span>
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-history text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Riwayat Aktivitas Masuk Akun Saya</span>
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
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2.5 gap-md-0">
                        <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-messages text-primary me-0 me-md-1.5 fs-20 fs-md-16 mb-1 mb-md-0"></i>
                            <span>Obrolan &amp; Pesan Saya</span>
                        </h5>
                        <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-xs btn-primary bg-primary text-white px-2.5 py-1.5 rounded" title="Buka Chat">
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
                                        <img src="{{ $partner?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $partner->name ?? 'User' }}" class="chat-preview-avatar">
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
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3">
                    <div class="d-flex flex-column align-items-center align-items-md-start">
                        <h5 class="card-title mb-0 fw-bold text-dark d-flex flex-column flex-md-row align-items-center">
                            <i class="ti ti-users text-primary me-0 me-md-2 fs-22 fs-md-18 mb-1 mb-md-0"></i>
                            <span>Direktori Pengguna &amp; Jaringan Pertemanan</span>
                        </h5>
                        <p class="text-muted fs-12 mb-0 mt-1 mt-md-0.5 text-center text-md-start">Temukan rekan kerja, kirim ajakan berteman, berikan apresiasi suka pada profil, dan mulai berkomunikasi.</p>
                    </div>

                    <!-- Search Input -->
                    <div class="app-search" style="min-width: 250px;">
                        <input type="text" id="dashboard-contact-search" class="form-control" style="padding-left: 40px !important;" placeholder="Cari nama, email, no. telepon/WA...">
                        <i class="ti ti-search app-search-icon text-muted"></i>
                    </div>
                </div>

                <div class="card-body p-3.5">
                    <!-- Nav Tabs Navigasi Linimasa & Direktori (Rule 17, 18 & 19 Standard) -->
                    <ul class="nav nav-pills custom-nav-pills p-1 bg-light rounded-3 mb-4 flex-nowrap overflow-x-auto" id="directoryTab" role="tablist">
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <button class="nav-link active d-flex align-items-center gap-1.5" id="tab-contacts-btn" data-bs-toggle="pill" data-bs-target="#tab-directory-contacts" type="button" role="tab" aria-controls="tab-directory-contacts" aria-selected="true" title="Direktori Kontak ({{ $contactUsers->count() }})">
                                <i class="ti ti-users"></i>
                                <span class="d-none d-md-inline">Direktori Kontak</span>
                                <span class="badge bg-primary text-white rounded-pill fs-xxs ms-1">{{ $contactUsers->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-1.5" id="tab-friendships-btn" data-bs-toggle="pill" data-bs-target="#tab-directory-friendships" type="button" role="tab" aria-controls="tab-directory-friendships" aria-selected="false" title="Riwayat Pertemanan ({{ $friendshipHistories->count() }})">
                                <i class="ti ti-user-check"></i>
                                <span class="d-none d-md-inline">Riwayat Pertemanan</span>
                                <span class="badge bg-success text-white rounded-pill fs-xxs ms-1">{{ $friendshipHistories->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-1.5" id="tab-likes-btn" data-bs-toggle="pill" data-bs-target="#tab-directory-likes" type="button" role="tab" aria-controls="tab-directory-likes" aria-selected="false" title="Riwayat Suka Profil ({{ $profileLikeHistories->count() }})">
                                <i class="ti ti-heart-filled text-danger"></i>
                                <span class="d-none d-md-inline">Riwayat Suka</span>
                                <span class="badge bg-danger text-white rounded-pill fs-xxs ms-1">{{ $profileLikeHistories->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-1.5" id="tab-chats-btn" data-bs-toggle="pill" data-bs-target="#tab-directory-chats" type="button" role="tab" aria-controls="tab-directory-chats" aria-selected="false" title="Riwayat Obrolan Chat ({{ $chatHistories->count() }})">
                                <i class="ti ti-messages"></i>
                                <span class="d-none d-md-inline">Riwayat Chat</span>
                                <span class="badge bg-info text-white rounded-pill fs-xxs ms-1">{{ $chatHistories->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-1.5" id="tab-media-btn" data-bs-toggle="pill" data-bs-target="#tab-directory-media" type="button" role="tab" aria-controls="tab-directory-media" aria-selected="false" title="Riwayat Avatar & Sampul ({{ $mediaHistories->count() }})">
                                <i class="ti ti-photo-edit"></i>
                                <span class="d-none d-md-inline">Riwayat Avatar &amp; Sampul</span>
                                <span class="badge bg-secondary text-white rounded-pill fs-xxs ms-1">{{ $mediaHistories->count() }}</span>
                            </button>
                        </li>
                    </ul>

                    <!-- TAB CONTENT AREA -->
                    <div class="tab-content pt-2" id="directoryTabContent">
                        <!-- TAB 1: DIREKTORI KONTAK & GRID PENGGUNA -->
                        <div class="tab-pane fade show active" id="tab-directory-contacts" role="tabpanel" aria-labelledby="tab-contacts-btn">
                            <!-- Filter Kategori Pertemanan (Content Widget - Right Aligned & Responsive Mobile) -->
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3.5 pb-3 border-bottom">
                        <div class="btn-group btn-group-sm friendship-filter-group" role="group" aria-label="Filter Pertemanan">
                            <button type="button" class="btn btn-outline-primary active btn-friend-filter d-inline-flex align-items-center gap-1.5" data-filter="all" title="Semua Pengguna ({{ $contactUsers->count() }})">
                                <i class="ti ti-users"></i>
                                <span class="d-none d-sm-inline">Semua</span>
                                <span class="badge bg-primary text-white rounded-pill fs-xxs" id="filter-badge-all">{{ $contactUsers->count() }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter d-inline-flex align-items-center gap-1.5" data-filter="friends" title="Teman Saya ({{ $totalFriendsCount }})">
                                <i class="ti ti-user-check"></i>
                                <span class="d-none d-sm-inline">Teman Saya</span>
                                <span class="badge bg-success text-white rounded-pill fs-xxs" id="filter-badge-friends">{{ $totalFriendsCount }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter d-inline-flex align-items-center gap-1.5" data-filter="incoming" title="Ajakan Masuk ({{ $incomingFriendRequestsCount }})">
                                <i class="ti ti-user-plus"></i>
                                <span class="d-none d-sm-inline">Ajakan Masuk</span>
                                <span class="badge {{ $incomingFriendRequestsCount > 0 ? 'bg-danger text-white' : 'bg-secondary-subtle text-secondary' }} rounded-pill fs-xxs" id="filter-badge-incoming">{{ $incomingFriendRequestsCount }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-friend-filter d-inline-flex align-items-center gap-1.5" data-filter="outgoing" title="Ajakan Terkirim ({{ $outgoingFriendRequestsCount }})">
                                <i class="ti ti-clock-pause"></i>
                                <span class="d-none d-sm-inline">Ajakan Terkirim</span>
                                <span class="badge {{ $outgoingFriendRequestsCount > 0 ? 'bg-warning text-dark' : 'bg-secondary-subtle text-secondary' }} rounded-pill fs-xxs" id="filter-badge-outgoing">{{ $outgoingFriendRequestsCount }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="row g-3" id="dashboard-contacts-grid">
                        @forelse ($contactUsers as $cUser)
                            @php
                                $isMe = $cUser->id === auth()->id();
                                $fStatus = $cUser->friendship_status ?? 'none';
                                $fModel = $cUser->friendship_model;
                                $isLiked = $cUser->is_liked_by_me ?? false;
                                $likesTotal = $cUser->profile_likes_count ?? 0;

                                $cHex = ltrim($cUser->cover_color ?: '#313a46', '#');
                                if (strlen($cHex) == 3) {
                                    $cHex = $cHex[0].$cHex[0].$cHex[1].$cHex[1].$cHex[2].$cHex[2];
                                }
                                $cR = hexdec(substr($cHex, 0, 2));
                                $cG = hexdec(substr($cHex, 2, 2));
                                $cB = hexdec(substr($cHex, 4, 2));
                                $cAlpha = ($cUser->cover_opacity ?? 60) / 100;
                                $cRgbaCover = "rgba({$cR}, {$cG}, {$cB}, {$cAlpha})";
                                $cRgbaTop = "rgba({$cR}, {$cG}, {$cB}, " . max(0, $cAlpha - 0.25) . ")";
                                $cBlurPx = (int) ($cUser->cover_blur ?? 0);
                            @endphp
                            <div class="col-sm-6 col-lg-4 col-xl-3 dashboard-contact-col"
                                data-search-name="{{ strtolower($cUser->name) }}"
                                data-search-email="{{ strtolower($cUser->email) }}"
                                data-search-phone="{{ strtolower($cUser->detail->telepon ?? '') }}"
                                data-search-city="{{ strtolower($cUser->detail->kabupaten_kota ?? '') }}"
                                data-search-job="{{ strtolower($cUser->detail->pekerjaan ?? '') }}"
                                data-friendship-status="{{ $fStatus }}"
                                data-is-online="{{ $cUser->is_online ? '1' : '0' }}"
                                data-is-me="{{ $isMe ? '1' : '0' }}"
                                data-user-id="{{ $cUser->id }}">
                                <div class="card card-h-100 border shadow-sm rounded-3 overflow-hidden mb-0 contact-grid-card">
                                    <!-- Cover Banner Background -->
                                    <div class="position-relative contact-grid-cover overflow-hidden"
                                        style="height: 115px; background-image: url('{{ $cUser->cover_bg_url }}'); background-position: center {{ $cUser->cover_position_y }}%;">
                                        <!-- Dynamic User-Configured Overlay Layer (Color, Opacity & Blur) -->
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 contact-grid-overlay-layer"
                                            style="background: linear-gradient(180deg, {{ $cRgbaCover }} 0%, {{ $cRgbaTop }} 100%); backdrop-filter: {{ $cBlurPx > 0 ? 'blur('.$cBlurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $cBlurPx > 0 ? 'blur('.$cBlurPx.'px)' : 'none' }}; pointer-events: none; z-index: 1;"></div>
                                        
                                        <div class="position-absolute top-0 start-0 end-0 bottom-0 p-2 d-flex flex-column justify-content-between contact-grid-cover-overlay position-relative" style="z-index: 2; background: transparent;">
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
                                                @php
                                                    $cMottoColor = $cUser->motto_color ?: '#ffffff';
                                                    $isDarkCMotto = in_array(strtolower($cMottoColor), ['#000000', '#111827', '#1f2937', '#0f172a', 'black']);
                                                    $cMottoShadow = $isDarkCMotto ? '0 1px 5px rgba(255, 255, 255, 0.85)' : '0 1px 5px rgba(0, 0, 0, 0.85)';
                                                @endphp
                                                <div class="text-center px-1 pb-3 mb-1">
                                                    <p class="mb-0 fst-italic contact-cover-motto"
                                                        style="color: {{ $cMottoColor }}; text-shadow: {{ $cMottoShadow }}; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                                                        title="{{ $cUser->motto }}">
                                                        "{{ $cUser->motto }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-3 text-center d-flex flex-column position-relative" style="z-index: 3;">
                                        <!-- Overlapping Avatar -->
                                        <div class="position-relative d-inline-block mx-auto mb-2 contact-grid-avatar-wrapper" style="margin-top: -42px; z-index: 4;">
                                            <img src="{{ $cUser->avatar_url }}" alt="{{ $cUser->name }}"
                                                class="rounded-circle border border-3 border-white shadow-sm contact-grid-avatar position-relative" style="z-index: 4;">
                                            <span class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle {{ $cUser->is_online ? 'bg-success' : 'bg-secondary opacity-50' }}"
                                                style="width: 12px; height: 12px; transform: translate(10%, 10%); z-index: 5;"></span>
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
                                                    <button type="button" class="btn btn-sm btn-light border text-primary px-2 btn-view-user-history" data-user-id="{{ $cUser->id }}" title="Lihat Riwayat Interaksi">
                                                        <i class="ti ti-history"></i>
                                                    </button>
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

                <!-- TAB 2: RIWAYAT PERTEMANAN -->
                <div class="tab-pane fade" id="tab-directory-friendships" role="tabpanel" aria-labelledby="tab-friendships-btn">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success fs-12 px-2.5 py-1.5 rounded-pill fw-semibold">
                                <i class="ti ti-user-check me-1"></i> Linimasa Interaksi Pertemanan
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="filter-friendship-history-search" class="form-control form-control-sm" placeholder="Cari pengirim / penerima..." style="max-width: 250px;">
                        </div>
                    </div>

                    <div class="table-responsive rounded border">
                        <table class="table table-hover align-middle mb-0" id="table-friendship-history">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th class="align-middle text-center text-nowrap" style="width: 50px;">#</th>
                                    <th class="align-middle text-center text-nowrap">Pengirim Ajakan</th>
                                    <th class="align-middle text-center text-nowrap">Penerima Ajakan</th>
                                    <th class="align-middle text-center text-nowrap">Status Hubungan</th>
                                    <th class="align-middle text-center text-nowrap">Waktu Permintaan (WIB)</th>
                                    <th class="align-middle text-center text-nowrap">Pembaruan Terakhir</th>
                                    <th class="align-middle text-center text-nowrap" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($friendshipHistories as $idx => $fHistory)
                                    @php
                                        $sUser = $fHistory->sender;
                                        $rUser = $fHistory->receiver;
                                    @endphp
                                    <tr class="friendship-history-row" data-search-text="{{ strtolower(($sUser->name ?? '') . ' ' . ($rUser->name ?? '')) }}">
                                        <td class="text-center fw-medium text-muted">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $sUser?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $sUser?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $sUser?->name ?? 'User Terhapus' }}</div>
                                                    <div class="text-muted fs-11">{{ $sUser?->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $rUser?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $rUser?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $rUser?->name ?? 'User Terhapus' }}</div>
                                                    <div class="text-muted fs-11">{{ $rUser?->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($fHistory->status === 'accepted')
                                                <span class="badge bg-success-subtle text-success px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="ti ti-check me-1"></i> Berteman
                                                </span>
                                            @elseif ($fHistory->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="ti ti-clock me-1"></i> Menunggu Respon
                                                </span>
                                            @elseif ($fHistory->status === 'rejected')
                                                <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="ti ti-x me-1"></i> Ditolak
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fw-semibold">
                                                    {{ ucfirst($fHistory->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap fs-12 text-muted">
                                            <div>{{ $fHistory->created_at ? $fHistory->created_at->format('d M Y H:i') . ' WIB' : '-' }}</div>
                                            <small class="text-muted opacity-75">{{ $fHistory->created_at ? $fHistory->created_at->diffForHumans() : '' }}</small>
                                        </td>
                                        <td class="text-center text-nowrap fs-12 text-muted">
                                            <div>{{ $fHistory->updated_at ? $fHistory->updated_at->format('d M Y H:i') . ' WIB' : '-' }}</div>
                                            <small class="text-muted opacity-75">{{ $fHistory->updated_at ? $fHistory->updated_at->diffForHumans() : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-xs btn-outline-primary rounded-pill btn-view-user-history d-inline-flex align-items-center gap-1" data-user-id="{{ $sUser?->id === auth()->id() ? $rUser?->id : $sUser?->id }}" title="Lihat Riwayat Lengkap">
                                                <i class="ti ti-history"></i>
                                                <span>Riwayat</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="ti ti-user-x fs-28 text-muted d-block mb-1"></i>
                                            <span>Belum ada catatan riwayat pertemanan.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: RIWAYAT SUKA PROFIL -->
                <div class="tab-pane fade" id="tab-directory-likes" role="tabpanel" aria-labelledby="tab-likes-btn">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger-subtle text-danger fs-12 px-2.5 py-1.5 rounded-pill fw-semibold">
                                <i class="ti ti-heart-filled me-1"></i> Log Apresiasi &amp; Suka Profil
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="filter-likes-history-search" class="form-control form-control-sm" placeholder="Cari nama pemberi/penerima suka..." style="max-width: 250px;">
                        </div>
                    </div>

                    <div class="table-responsive rounded border">
                        <table class="table table-hover align-middle mb-0" id="table-likes-history">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th class="align-middle text-center text-nowrap" style="width: 50px;">#</th>
                                    <th class="align-middle text-center text-nowrap">Pemberi Suka</th>
                                    <th class="align-middle text-center text-nowrap">Target Profil yang Disukai</th>
                                    <th class="align-middle text-center text-nowrap">Jenis Interaksi</th>
                                    <th class="align-middle text-center text-nowrap">Waktu Diberikan (WIB)</th>
                                    <th class="align-middle text-center text-nowrap" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profileLikeHistories as $idx => $like)
                                    @php
                                        $lUser = $like->user;
                                        $tUser = $like->targetUser;
                                    @endphp
                                    <tr class="likes-history-row" data-search-text="{{ strtolower(($lUser->name ?? '') . ' ' . ($tUser->name ?? '')) }}">
                                        <td class="text-center fw-medium text-muted">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $lUser?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $lUser?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $lUser?->name ?? 'User' }}</div>
                                                    <div class="text-muted fs-11">{{ $lUser?->role_name ?? 'User' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $tUser?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $tUser?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $tUser?->name ?? 'User' }}</div>
                                                    <div class="text-muted fs-11">{{ $tUser?->role_name ?? 'User' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold d-inline-flex align-items-center gap-1">
                                                <i class="ti ti-heart-filled"></i> Menyukai Profil
                                            </span>
                                        </td>
                                        <td class="text-center text-nowrap fs-12 text-muted">
                                            <div>{{ $like->created_at ? $like->created_at->format('d M Y H:i') . ' WIB' : '-' }}</div>
                                            <small class="text-muted opacity-75">{{ $like->created_at ? $like->created_at->diffForHumans() : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-xs btn-outline-danger rounded-pill btn-view-user-history d-inline-flex align-items-center gap-1" data-user-id="{{ $tUser?->id ?? $lUser?->id }}" title="Lihat Riwayat Interaksi">
                                                <i class="ti ti-history"></i>
                                                <span>Riwayat</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="ti ti-heart-off fs-28 text-muted d-block mb-1"></i>
                                            <span>Belum ada catatan aktivitas suka profil.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: RIWAYAT PESAN CHAT -->
                <div class="tab-pane fade" id="tab-directory-chats" role="tabpanel" aria-labelledby="tab-chats-btn">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info-subtle text-info fs-12 px-2.5 py-1.5 rounded-pill fw-semibold">
                                <i class="ti ti-messages me-1"></i> Log Aktivitas Kirim &amp; Terima Obrolan
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="filter-chats-history-search" class="form-control form-control-sm" placeholder="Cari nama / teks pesan..." style="max-width: 250px;">
                        </div>
                    </div>

                    <div class="table-responsive rounded border">
                        <table class="table table-hover align-middle mb-0" id="table-chats-history">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th class="align-middle text-center text-nowrap" style="width: 50px;">#</th>
                                    <th class="align-middle text-center text-nowrap">Pengirim Pesan</th>
                                    <th class="align-middle text-center text-nowrap">Penerima Pesan</th>
                                    <th class="align-middle text-center text-nowrap">Isi Pesan / Lampiran</th>
                                    <th class="align-middle text-center text-nowrap">Status Baca</th>
                                    <th class="align-middle text-center text-nowrap">Waktu Kirim (WIB)</th>
                                    <th class="align-middle text-center text-nowrap" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($chatHistories as $idx => $msg)
                                    @php
                                        $sender = $msg->sender;
                                        $receiver = $msg->receiver;
                                    @endphp
                                    <tr class="chats-history-row" data-search-text="{{ strtolower(($sender->name ?? '') . ' ' . ($receiver->name ?? '') . ' ' . $msg->message) }}">
                                        <td class="text-center fw-medium text-muted">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $sender?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $sender?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $sender?->name ?? 'User' }}</div>
                                                    <div class="text-muted fs-11">{{ $sender?->role_name ?? 'User' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $receiver?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $receiver?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $receiver?->name ?? 'User' }}</div>
                                                    <div class="text-muted fs-11">{{ $receiver?->role_name ?? 'User' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate fs-13 text-dark" style="max-width: 280px;" title="{{ $msg->message }}">
                                                @if ($msg->attachment_path)
                                                    <span class="badge bg-light text-primary border me-1"><i class="ti ti-paperclip"></i> Lampiran</span>
                                                @endif
                                                {{ $msg->message ?: '[Lampiran Berkas]' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($msg->is_read)
                                                <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill fs-xxs fw-semibold">
                                                    <i class="ti ti-checks me-0.5"></i> Dibaca
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning px-2 py-0.5 rounded-pill fs-xxs fw-semibold">
                                                    <i class="ti ti-check me-0.5"></i> Terkirim
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap fs-12 text-muted">
                                            <div>{{ $msg->created_at ? $msg->created_at->format('d M Y H:i') . ' WIB' : '-' }}</div>
                                            <small class="text-muted opacity-75">{{ $msg->created_at ? $msg->created_at->diffForHumans() : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <a href="{{ route('admin.profil-pengguna.messages.index', ['user_id' => $sender?->id === auth()->id() ? $receiver?->id : $sender?->id]) }}" class="btn btn-xs btn-primary text-white rounded-pill d-inline-flex align-items-center gap-1" title="Buka Percakapan Chat">
                                                    <i class="ti ti-messages"></i>
                                                    <span>Chat</span>
                                                </a>
                                                <button type="button" class="btn btn-xs btn-light border text-muted rounded-pill btn-view-user-history" data-user-id="{{ $sender?->id === auth()->id() ? $receiver?->id : $sender?->id }}" title="Lihat Riwayat Interaksi">
                                                    <i class="ti ti-history"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="ti ti-message-off fs-28 text-muted d-block mb-1"></i>
                                            <span>Belum ada catatan riwayat pesan obrolan.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 5: RIWAYAT AVATAR & SAMPUL -->
                <div class="tab-pane fade" id="tab-directory-media" role="tabpanel" aria-labelledby="tab-media-btn">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary-subtle text-secondary fs-12 px-2.5 py-1.5 rounded-pill fw-semibold">
                                <i class="ti ti-photo-edit me-1"></i> Log Perubahan Foto Profil &amp; Foto Sampul
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="filter-media-history-search" class="form-control form-control-sm" placeholder="Cari jenis media / deskripsi..." style="max-width: 250px;">
                        </div>
                    </div>

                    <div class="table-responsive rounded border">
                        <table class="table table-hover align-middle mb-0" id="table-media-history">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th class="align-middle text-center text-nowrap" style="width: 50px;">#</th>
                                    <th class="align-middle text-center text-nowrap">Pengguna</th>
                                    <th class="align-middle text-center text-nowrap">Jenis Media</th>
                                    <th class="align-middle text-center text-nowrap">Preview Visual</th>
                                    <th class="align-middle text-center text-nowrap">Deskripsi Pembaruan</th>
                                    <th class="align-middle text-center text-nowrap">Waktu Pembaruan (WIB)</th>
                                    <th class="align-middle text-center text-nowrap" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mediaHistories as $idx => $mh)
                                    @php
                                        $mhUser = $mh->user;
                                    @endphp
                                    <tr class="media-history-row" data-search-text="{{ strtolower(($mhUser->name ?? '') . ' ' . $mh->media_type . ' ' . $mh->description) }}">
                                        <td class="text-center fw-medium text-muted">{{ $idx + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $mhUser?->avatar_url ?? asset('assets/images/users/user-default.jpg') }}" alt="{{ $mhUser?->name ?? 'User' }}" class="rounded-circle border" style="width: 34px; height: 34px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold text-dark fs-13">{{ $mhUser?->name ?? 'User' }}</div>
                                                    <div class="text-muted fs-11">{{ $mhUser?->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($mh->media_type === 'avatar')
                                                <span class="badge bg-primary-subtle text-primary px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="ti ti-user me-1"></i> Avatar Profil
                                                </span>
                                            @else
                                                <span class="badge bg-info-subtle text-info px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="ti ti-photo me-1"></i> Foto Sampul
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($mh->media_type === 'avatar')
                                                <img src="{{ $mh->url }}" alt="Preview" class="rounded-circle border shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">
                                            @else
                                                <img src="{{ $mh->url }}" alt="Preview" class="rounded border shadow-sm" style="width: 80px; height: 44px; object-fit: cover;">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark fs-13">{{ $mh->description ?? 'Pembaruan Media' }}</div>
                                            @if (!empty($mh->meta_data) && is_array($mh->meta_data))
                                                <div class="text-muted fs-11">
                                                    @if (isset($mh->meta_data['position_y']))
                                                        Posisi Y: {{ $mh->meta_data['position_y'] }}% &bull;
                                                    @endif
                                                    @if (isset($mh->meta_data['source']))
                                                        Sumber: {{ $mh->meta_data['source'] }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap fs-12 text-muted">
                                            <div>{{ $mh->created_at ? $mh->created_at->format('d M Y H:i') . ' WIB' : '-' }}</div>
                                            <small class="text-muted opacity-75">{{ $mh->created_at ? $mh->created_at->diffForHumans() : '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-xs btn-outline-primary rounded-pill btn-view-user-history d-inline-flex align-items-center gap-1" data-user-id="{{ $mhUser?->id }}" title="Lihat Riwayat Interaksi">
                                                <i class="ti ti-history"></i>
                                                <span>Riwayat</span>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="ti ti-photo-off fs-28 text-muted d-block mb-1"></i>
                                            <span>Belum ada catatan riwayat pembaruan foto profil atau sampul Anda.</span>
                                        </td>
                                    </tr>
                                @endforelse
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>

<!-- MODAL DETAIL RIWAYAT INTERAKSI PENGGUNA (Rule 4 & Rule 20 Standard) -->
<div class="modal fade" id="modalUserActivityHistory" tabindex="-1" aria-labelledby="modalUserActivityHistoryLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-centered">
     <div class="modal-content border-0 shadow-lg overflow-hidden">
         <!-- User Cover Header Banner -->
         <div class="position-relative overflow-hidden" id="user-history-cover-banner" style="height: 120px; background-size: cover; background-position: center 50%;">
             <div class="position-absolute top-0 start-0 end-0 bottom-0 bg-dark bg-opacity-50"></div>
             <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-sm z-3" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body p-3.5 pt-0">
             <!-- User Profile Header Summary -->
             <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end gap-3 mb-3 position-relative" style="margin-top: -45px; z-index: 4;">
                 <img src="{{ asset('assets/images/users/user-default.jpg') }}" id="user-history-avatar" alt="Avatar" class="rounded-circle border border-3 border-white shadow object-fit-cover" style="width: 86px; height: 86px; background: #fff;">
                 <div class="text-center text-sm-start flex-grow-1">
                     <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-2 mb-0.5">
                         <h5 class="modal-title fw-bold text-dark mb-0" id="user-history-name">Nama Pengguna</h5>
                         <span class="badge bg-primary-subtle text-primary fs-xxs rounded-pill" id="user-history-role">Role</span>
                         <span class="badge bg-success text-white fs-xxs rounded-pill d-none" id="user-history-online-badge"><i class="ti ti-circle-filled fs-8 me-1"></i>Online</span>
                     </div>
                     <p class="text-muted fs-12 mb-0" id="user-history-email">email@example.com</p>
                 </div>
             </div>

             <!-- Motto Box if available -->
             <div class="alert alert-light border py-2 px-3 mb-3 text-center fst-italic fs-12 text-muted rounded-3" id="user-history-motto-box">
                 <i class="ti ti-quote me-1 text-primary"></i> <span id="user-history-motto">"Motto Hidup..."</span>
             </div>

             <!-- Sub-Nav Pills within Modal (Rule 17 Button Tabs) -->
             <ul class="nav nav-pills custom-nav-pills p-1 bg-light rounded-3 mb-3" id="userHistoryModalTabs" role="tablist">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link active d-flex align-items-center gap-1.5 fs-12 py-1 px-2.5" id="user-m-tab-friendship-btn" data-bs-toggle="pill" data-bs-target="#user-m-tab-friendship" type="button" role="tab" aria-controls="user-m-tab-friendship" aria-selected="true">
                         <i class="ti ti-user-check"></i> <span>Pertemanan</span>
                     </button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link d-flex align-items-center gap-1.5 fs-12 py-1 px-2.5" id="user-m-tab-likes-btn" data-bs-toggle="pill" data-bs-target="#user-m-tab-likes" type="button" role="tab" aria-controls="user-m-tab-likes" aria-selected="false">
                         <i class="ti ti-heart-filled text-danger"></i> <span>Suka Profil</span>
                     </button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link d-flex align-items-center gap-1.5 fs-12 py-1 px-2.5" id="user-m-tab-chats-btn" data-bs-toggle="pill" data-bs-target="#user-m-tab-chats" type="button" role="tab" aria-controls="user-m-tab-chats" aria-selected="false">
                         <i class="ti ti-messages"></i> <span>Obrolan Chat</span>
                     </button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link d-flex align-items-center gap-1.5 fs-12 py-1 px-2.5" id="user-m-tab-media-btn" data-bs-toggle="pill" data-bs-target="#user-m-tab-media" type="button" role="tab" aria-controls="user-m-tab-media" aria-selected="false">
                         <i class="ti ti-photo-edit"></i> <span>Avatar &amp; Sampul</span>
                     </button>
                 </li>
             </ul>

             <!-- Sub-Tab Content -->
             <div class="tab-content" id="userHistoryModalTabContent">
                 <!-- 1. Pertemanan -->
                 <div class="tab-pane fade show active" id="user-m-tab-friendship" role="tabpanel">
                     <div class="p-3 border rounded-3 bg-light-subtle mb-3 text-center" id="user-modal-friendship-status-box">
                         <div class="fs-13 fw-semibold text-dark mb-1" id="user-modal-friendship-status-text">Status: Memuat...</div>
                         <div class="fs-11 text-muted" id="user-modal-friendship-time-text">Sedang mengambil riwayat pertemanan.</div>
                     </div>
                     <h6 class="fs-12 fw-bold text-muted text-uppercase mb-2"><i class="ti ti-timeline me-1"></i> Linimasa Status Hubungan</h6>
                     <div class="list-group list-group-flush border rounded-3" id="user-modal-friendship-timeline">
                         <div class="text-center py-3 text-muted fs-12">Memuat linimasa...</div>
                     </div>
                 </div>

                 <!-- 2. Suka Profil -->
                 <div class="tab-pane fade" id="user-m-tab-likes" role="tabpanel">
                     <div class="row g-2 mb-3">
                         <div class="col-sm-6">
                             <div class="p-3 border rounded-3 text-center bg-light-subtle">
                                 <div class="text-muted fs-11 mb-1">Apresiasi Anda</div>
                                 <div class="fw-bold fs-13" id="user-modal-my-like-status"><i class="ti ti-heart-off text-muted me-1"></i> Belum Disukai</div>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="p-3 border rounded-3 text-center bg-light-subtle">
                                 <div class="text-muted fs-11 mb-1">Apresiasi dari Pengguna</div>
                                 <div class="fw-bold fs-13" id="user-modal-target-like-status"><i class="ti ti-heart-off text-muted me-1"></i> Belum Menyukai Anda</div>
                             </div>
                         </div>
                     </div>
                     <div class="alert alert-info py-2 px-3 fs-12 mb-0 d-flex align-items-center gap-2">
                         <i class="ti ti-info-circle fs-16"></i>
                         <span>Pengguna ini telah menerima total <strong id="user-modal-total-likes-count">0</strong> suka profil dari seluruh pengguna.</span>
                     </div>
                 </div>

                 <!-- 3. Obrolan Chat -->
                 <div class="tab-pane fade" id="user-m-tab-chats" role="tabpanel">
                     <div class="border rounded-3 p-3 bg-light-subtle mb-3" style="max-height: 280px; overflow-y: auto;" id="user-modal-chat-list">
                         <div class="text-center py-3 text-muted fs-12">Memuat riwayat chat...</div>
                     </div>
                     <div class="text-center">
                         <a href="#" id="user-modal-btn-open-full-chat" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1.5">
                             <i class="ti ti-messages"></i> <span>Buka Ruang Obrolan Penuh</span>
                         </a>
                     </div>
                 </div>

                 <!-- 4. Avatar & Sampul -->
                 <div class="tab-pane fade" id="user-m-tab-media" role="tabpanel">
                     <div class="list-group list-group-flush border rounded-3" id="user-modal-media-list" style="max-height: 280px; overflow-y: auto;">
                         <div class="text-center py-3 text-muted fs-12">Memuat riwayat foto profil &amp; sampul...</div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Modal Footer with Responsive Action Buttons (Rule 20) -->
         <div class="modal-footer d-flex flex-column-reverse flex-sm-row justify-content-end gap-2 bg-light py-2.5 px-3.5">
             <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Tutup</button>
             <a href="#" id="user-modal-action-chat-btn" class="btn btn-sm btn-primary">
                 <i class="ti ti-messages me-1"></i> Kirim Pesan
             </a>
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
         pollDashboard: "{{ route('admin.friendships.poll-dashboard') }}",
         userHistory: "{{ url('admin/friendships/user-history') }}",
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
