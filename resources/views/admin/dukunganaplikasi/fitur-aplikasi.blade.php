@extends('layouts.vertical')

@section('title', 'Fitur Aplikasi')

@section('content')
    <!-- Module Custom CSS (Rule 15 Compliance) -->
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/fitur-aplikasi.css') }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Fitur Aplikasi', 'subtitle' => 'Dukungan Aplikasi'])

    <!-- MAIN CONTAINER: CARD WITH TABS (Exact match to /template/components/ui/tabs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- CARD HEADER WITH TABS & RESET BUTTON -->
                <div class="card-header card-tabs d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="card-title mb-0">Pusat Kontrol & Fitur Aplikasi</h4>
                        <button type="button" class="btn btn-xs btn-outline-danger d-inline-flex align-items-center px-2 py-1" id="btn-reset-default" title="Kembalikan semua pengaturan sistem dan visibilitas fitur ke setelan bawaan sistem (Seeder)">
                            <i class="ti ti-rotate-clockwise me-1 fs-14"></i>
                            <span class="fs-12">Kembalikan Default</span>
                        </button>
                    </div>
                    <ul class="nav nav-tabs card-header-tabs nav-bordered" id="fiturNavTabs" role="tablist">
                        <!-- TAB 1: PENGATURAN SISTEM (DEFAULT ACTIVE) -->
                        <li class="nav-item">
                            <a href="#tab-settings" data-bs-toggle="tab" aria-expanded="true" class="nav-link active" id="tab-settings-btn">
                                <i class="ti ti-settings me-1.5 fs-18 align-middle"></i>
                                <span>Pengaturan Sistem</span>
                            </a>
                        </li>

                        <!-- TAB 2: VISIBILITAS FITUR & KOMPONEN -->
                        <li class="nav-item">
                            <a href="#tab-visibility" data-bs-toggle="tab" aria-expanded="false" class="nav-link" id="tab-visibility-btn">
                                <i class="ti ti-adjustments-horizontal me-1.5 fs-18 align-middle"></i>
                                <span>Visibilitas Fitur & Komponen</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CARD BODY WITH TAB CONTENT -->
                <div class="card-body">
                    <div class="tab-content" id="fiturNavTabsContent">

                        <!-- ========================================================================= -->
                        <!-- TAB 1: PENGATURAN SISTEM (DEFAULT ACTIVE) -->
                        <!-- ========================================================================= -->
                        <div class="tab-pane show active" id="tab-settings" role="tabpanel" aria-labelledby="tab-settings-btn">
                            
                            <!-- Quick Intro Banner -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card bg-primary-subtle border-primary-subtle shadow-none rounded-3 mb-0">
                                        <div class="card-body p-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-sm bg-primary text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                                    <i class="ti ti-settings-cog fs-22"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-primary">Panel Konfigurasi & Kebijakan Sistem</h6>
                                                    <p class="text-muted fs-12 mb-0">
                                                        Atur batas sesi ketidakaktifan, mode pemeliharaan, keamanan akun pengguna, sinkronisasi polling data, serta pembersihan cache aplikasi.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-white text-primary border border-primary-subtle px-3 py-2 fs-12 fw-semibold">
                                                    <i class="ti ti-shield-check text-success me-1.5"></i> 5 Konfigurasi Terintegrasi
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- GRID WIDGET PENGATURAN SISTEM (5 KARTU) -->
                            <div class="row g-3 g-xl-4">
                                
                                <!-- WIDGET 1: PENGATURAN WAKTU IDLE (AUTO LOCK SCREEN) -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 setting-card">
                                        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-clock-pause fs-20"></i>
                                                <h6 class="card-title text-white mb-0 fw-bold">Waktu Idle & Auto Lock</h6>
                                            </div>
                                            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Keamanan</span>
                                        </div>
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <label for="widget_idle_timeout" class="form-label fs-12 fw-semibold text-dark mb-0">Batas Waktu Ketidakaktifan:</label>
                                                    <span class="badge bg-warning-subtle text-warning fs-11 fw-bold" id="badge-current-idle">Aktif: {{ $appSettings['idle_timeout_minutes'] > 0 ? $appSettings['idle_timeout_minutes'] . ' Menit' : 'Nonaktif' }}</span>
                                                </div>
                                                <div class="input-group input-group-sm mb-2.5">
                                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-clock"></i></span>
                                                    <select id="widget_idle_timeout" class="form-select form-select-sm">
                                                        <option value="1" {{ $appSettings['idle_timeout_minutes'] == 1 ? 'selected' : '' }}>1 Menit (Mode Pengujian)</option>
                                                        <option value="3" {{ $appSettings['idle_timeout_minutes'] == 3 ? 'selected' : '' }}>3 Menit (Cepat)</option>
                                                        <option value="5" {{ $appSettings['idle_timeout_minutes'] == 5 ? 'selected' : '' }}>5 Menit (Standar Rekomendasi)</option>
                                                        <option value="10" {{ $appSettings['idle_timeout_minutes'] == 10 ? 'selected' : '' }}>10 Menit</option>
                                                        <option value="15" {{ $appSettings['idle_timeout_minutes'] == 15 ? 'selected' : '' }}>15 Menit</option>
                                                        <option value="30" {{ $appSettings['idle_timeout_minutes'] == 30 ? 'selected' : '' }}>30 Menit</option>
                                                        <option value="60" {{ $appSettings['idle_timeout_minutes'] == 60 ? 'selected' : '' }}>60 Menit (1 Jam)</option>
                                                        <option value="0" {{ $appSettings['idle_timeout_minutes'] == 0 ? 'selected' : '' }}>Nonaktifkan Auto-Lock</option>
                                                    </select>
                                                </div>
                                                <p class="text-muted fs-12 mb-3">
                                                    Layar aplikasi akan terkunci otomatis saat tidak ada aktivitas mouse/keyboard selama durasi yang ditentukan.
                                                </p>
                                            </div>
                                            <div class="d-flex gap-2 pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-idle-timeout">
                                                    <i class="ti ti-device-floppy me-1.5"></i> Simpan Durasi
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary flex-shrink-0" id="btn-test-lock-screen" title="Uji Kunci Layar Sekarang">
                                                    <i class="ti ti-lock me-1"></i> Uji
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WIDGET 2: MODE PEMELIHARAAN (MAINTENANCE MODE) -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 setting-card">
                                        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-tool fs-20"></i>
                                                <h6 class="card-title text-white mb-0 fw-bold">Status Sistem & Maintenance</h6>
                                            </div>
                                            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Operasional</span>
                                        </div>
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="fs-12 fw-semibold text-dark">Mode Pemeliharaan:</span>
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="widget_maintenance_mode" {{ $appSettings['maintenance_mode'] ? 'checked' : '' }}>
                                                        <label class="form-check-label fs-12 fw-bold text-danger" for="widget_maintenance_mode" id="maintenance-status-label">{{ $appSettings['maintenance_mode'] ? 'Aktif' : 'Nonaktif' }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2.5">
                                                    <input type="text" class="form-control form-control-sm" id="widget_maintenance_message" value="{{ $appSettings['maintenance_message'] }}" placeholder="Pesan pemeliharaan untuk pengguna...">
                                                </div>
                                                <p class="text-muted fs-12 mb-3">
                                                    Saat aktif, pengguna umum akan dialihkan ke halaman maintenance sementara administrator tetap memiliki akses penuh.
                                                </p>
                                            </div>
                                            <div class="pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-maintenance">
                                                    <i class="ti ti-device-floppy me-1.5"></i> Simpan Mode Maintenance
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WIDGET 3: KEAMANAN SESI & PROTEKSI LOGIN -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 setting-card">
                                        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-shield-lock fs-20"></i>
                                                <h6 class="card-title text-white mb-0 fw-bold">Keamanan & Proteksi Akun</h6>
                                            </div>
                                            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Proteksi</span>
                                        </div>
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <label for="widget_rate_limit" class="fs-12 fw-semibold text-dark mb-0">Maks Gagal Login (Lockout):</label>
                                                    <select id="widget_rate_limit" class="form-select form-select-sm" style="width: 110px;">
                                                        <option value="3" {{ $appSettings['rate_limit_attempts'] == 3 ? 'selected' : '' }}>3 Kali</option>
                                                        <option value="5" {{ $appSettings['rate_limit_attempts'] == 5 ? 'selected' : '' }}>5 Kali</option>
                                                        <option value="10" {{ $appSettings['rate_limit_attempts'] == 10 ? 'selected' : '' }}>10 Kali</option>
                                                    </select>
                                                </div>
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input" type="checkbox" id="widget_auto_approval" {{ $appSettings['auto_user_approval'] ? 'checked' : '' }}>
                                                    <label class="form-check-label fs-12 text-dark" for="widget_auto_approval">Otomatis Setujui Pendaftaran Akun</label>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="widget_new_device" {{ $appSettings['new_device_alert'] ? 'checked' : '' }}>
                                                    <label class="form-check-label fs-12 text-dark" for="widget_new_device">Notifikasi Login Perangkat Baru</label>
                                                </div>
                                            </div>
                                            <div class="pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-security">
                                                    <i class="ti ti-device-floppy me-1.5"></i> Simpan Kebijakan Keamanan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WIDGET 4: SINKRONISASI POLLING & NOTIFIKASI REAL-TIME -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 setting-card">
                                        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-refresh fs-20"></i>
                                                <h6 class="card-title text-white mb-0 fw-bold">Sinkronisasi Polling & Notifikasi</h6>
                                            </div>
                                            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Real-Time</span>
                                        </div>
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <label for="widget_polling_interval" class="fs-12 fw-semibold text-dark mb-0">Interval Polling Latar Belakang:</label>
                                                    <select id="widget_polling_interval" class="form-select form-select-sm" style="width: 140px;">
                                                        <option value="10" {{ $appSettings['polling_interval'] == 10 ? 'selected' : '' }}>10 Detik</option>
                                                        <option value="20" {{ $appSettings['polling_interval'] == 20 ? 'selected' : '' }}>20 Detik (Standar)</option>
                                                        <option value="30" {{ $appSettings['polling_interval'] == 30 ? 'selected' : '' }}>30 Detik</option>
                                                        <option value="60" {{ $appSettings['polling_interval'] == 60 ? 'selected' : '' }}>60 Detik (1 Menit)</option>
                                                    </select>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="widget_sound_notif" {{ $appSettings['sound_notification'] ? 'checked' : '' }}>
                                                            <label class="form-check-label fs-12 text-dark" for="widget_sound_notif">Audio Suara Notifikasi</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="widget_toast_notif" {{ $appSettings['toast_notification'] ? 'checked' : '' }}>
                                                            <label class="form-check-label fs-12 text-dark" for="widget_toast_notif">Pop-up Toast Notifikasi</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted fs-12 mb-3">
                                                    Menentukan frekuensi pemeriksaan data pembaruan pesan & notifikasi secara otomatis di latar belakang browser.
                                                </p>
                                            </div>
                                            <div class="pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-polling">
                                                    <i class="ti ti-device-floppy me-1.5"></i> Simpan Konfigurasi Polling
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WIDGET 5: MANAJEMEN CACHE & OPTIMASI KINERJA -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 setting-card">
                                        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-cpu fs-20"></i>
                                                <h6 class="card-title text-white mb-0 fw-bold">Cache & Optimasi Kinerja</h6>
                                            </div>
                                            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Server Engine</span>
                                        </div>
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex flex-wrap gap-1.5 mb-2.5">
                                                    <span class="badge bg-light text-dark border"><i class="ti ti-layout me-1 text-primary"></i> Views: Cached</span>
                                                    <span class="badge bg-light text-dark border"><i class="ti ti-route me-1 text-info"></i> Routes: Synced</span>
                                                    <span class="badge bg-light text-dark border"><i class="ti ti-settings me-1 text-warning"></i> Config: Loaded</span>
                                                    <span class="badge bg-light text-dark border"><i class="ti ti-database me-1 text-success"></i> Cache: Active</span>
                                                </div>
                                                <p class="text-muted fs-12 mb-3">
                                                    Bersihkan cache tampilan Blade, cache route URL, dan cache konfigurasi aplikasi untuk memuat pembaruan terbaru secara instan.
                                                </p>
                                            </div>
                                            <div class="pt-2 border-top">
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-clear-all-cache">
                                                    <i class="ti ti-trash me-1.5"></i> Bersihkan Semua Cache Sistem
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- ========================================================================= -->
                        <!-- TAB 2: VISIBILITAS FITUR & KOMPONEN -->
                        <!-- ========================================================================= -->
                        <div class="tab-pane" id="tab-visibility" role="tabpanel" aria-labelledby="tab-visibility-btn">
                            
                            <!-- RINGKASAN METRIK & STATISTIK FITUR -->
                            <div class="row g-3 mb-4">
                                <!-- METRIC 1: TOTAL FITUR -->
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="card shadow-sm border-0 rounded-3 stat-widget-card h-100">
                                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                            <div>
                                                <span class="text-muted fs-12 fw-semibold text-uppercase d-block mb-1">Total Fitur Terdaftar</span>
                                                <h3 class="fw-bold text-dark mb-0" id="stat-total">{{ $totalFeatures }}</h3>
                                                <small class="text-muted fs-11">Komponen & modul sistem</small>
                                            </div>
                                            <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-apps fs-24"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- METRIC 2: FITUR AKTIF & PROGRESS -->
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="card shadow-sm border-0 rounded-3 stat-widget-card h-100">
                                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="text-muted fs-12 fw-semibold text-uppercase">Fitur Aktif</span>
                                                <span class="badge bg-success-subtle text-success fs-12 fw-bold" id="stat-active-badge">
                                                    <span id="stat-active">{{ $activeFeatures }}</span> / <span id="stat-total-badge">{{ $totalFeatures }}</span>
                                                </span>
                                            </div>
                                            @php
                                                $percentActive = $totalFeatures > 0 ? round(($activeFeatures / $totalFeatures) * 100) : 0;
                                            @endphp
                                            <div class="my-2">
                                                <div class="progress" style="height: 8px;">
                                                    <div id="stat-progress-bar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentActive }}%;" aria-valuenow="{{ $percentActive }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted fs-11">Persentase Aktif: <strong id="stat-percent-text">{{ $percentActive }}%</strong></small>
                                                <span class="badge bg-danger-subtle text-danger fs-11" id="stat-inactive-badge"><span id="stat-inactive">{{ $inactiveFeatures }}</span> Nonaktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- METRIC 3: KONTROL CEPAT & AKSI -->
                                <div class="col-12 col-xl-4">
                                    <div class="card shadow-sm border-0 rounded-3 stat-widget-card h-100 bg-light-subtle">
                                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fw-semibold text-dark fs-12">Aksi & Kontrol Cepat</span>
                                                <span class="badge bg-warning-subtle text-warning border fs-11"><i class="ti ti-bolt me-1"></i>Auto-Save</span>
                                            </div>
                                            <p class="text-muted fs-12 mb-2">
                                                Sembunyikan atau tampilkan komponen topbar, menu sidebar, dan modul secara seketika.
                                            </p>
                                            @can('create dukunganaplikasi/fitur-aplikasi')
                                                <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold btn-fitur-action" data-action="create">
                                                    <i class="ti ti-plus me-1.5"></i> Tambah Fitur Baru
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TABEL MANAJEMEN FITUR -->
                            <div class="row" id="features-management-section">
                                <div class="col-12">
                                    <div class="card shadow-sm border-0 rounded-3">
                                        <!-- CARD HEADER (Rule 12 Compliance: bg-primary text-white py-3) -->
                                        <div class="card-header bg-primary text-white d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-adjustments-alt fs-22"></i>
                                                <div>
                                                    <h5 class="card-title text-white mb-0">Daftar Fitur Aplikasi & Manajemen Visibilitas</h5>
                                                    <small class="text-white-50 fs-12">Kelola komponen topbar, menu template sidebar, dan fitur sistem secara dinamis.</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="text-white-70 fs-13 d-none d-sm-inline-flex align-items-center text-white text-opacity-75">
                                                    <i class="ti ti-bolt text-warning me-1.5 fs-16"></i> Auto-Save Instant
                                                </span>
                                                @can('create dukunganaplikasi/fitur-aplikasi')
                                                    <button type="button" class="btn btn-light text-primary fw-semibold btn-fitur-action shadow-sm" data-action="create">
                                                        <i class="ti ti-plus me-1.5"></i> Tambah Fitur Baru
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>

                                        <div class="card-body p-4">
                                            <!-- FILTER CONTROLS & SEARCH BAR -->
                                            <div class="row align-items-center mb-3 g-2">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-filter me-1.5"></i> Kelompok:</label>
                                                    <select id="table-category-select" class="form-select form-select-sm">
                                                        <option value="all">-- Semua Kelompok ({{ $totalFeatures }}) --</option>
                                                        @foreach ($categories as $cat)
                                                            @php
                                                                $catLabel = match($cat) {
                                                                    'topbar' => 'Topbar Header',
                                                                    'menu_group' => 'Sidebar Menu Group',
                                                                    'general' => 'Umum / General',
                                                                    default => ucfirst($cat)
                                                                };
                                                                $catCount = $features->where('kategori', $cat)->count();
                                                            @endphp
                                                            <option value="{{ $cat }}">{{ $catLabel }} ({{ $catCount }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3 d-flex align-items-center">
                                                    <label class="me-2 fs-13 text-muted mb-0">Tampilkan:</label>
                                                    <select id="table-length-select" class="form-select form-select-sm" style="width: 120px;">
                                                        <option value="10">10 baris</option>
                                                        <option value="25" selected>25 baris</option>
                                                        <option value="50">50 baris</option>
                                                        <option value="all">Semua Baris</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-5 d-flex justify-content-md-end">
                                                    <div class="d-flex align-items-center w-100 justify-content-md-end">
                                                        <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Fitur:</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" id="table-search-input" class="form-control" placeholder="Ketik kode, nama, atau deskripsi...">
                                                            <button class="btn btn-outline-secondary" type="button" id="btn-clear-search" title="Bersihkan Pencarian">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- BULK ACTION TOOLBAR (PILIHAN CENTANG CHECKBOX) -->
                                            @can('update dukunganaplikasi/fitur-aplikasi')
                                                <div class="p-3 bg-light-subtle rounded-3 mb-3 border d-flex flex-wrap align-items-center justify-content-between gap-3" id="bulk-action-bar">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="form-check m-0">
                                                            <input class="form-check-input high-contrast-checkbox" type="checkbox" id="check-all-global" title="Centang Semua Fitur pada Kategori/Filter Ini">
                                                            <label class="form-check-label fw-semibold fs-13 text-dark user-select-none cursor-pointer" for="check-all-global" id="check-all-label">
                                                                Pilih Semua Fitur ({{ $totalFeatures }})
                                                            </label>
                                                        </div>
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 px-2.5 py-1 ms-2" id="selected-badge" style="display: none;">
                                                            <i class="ti ti-check me-1.5"></i><span id="selected-count">0</span> terpilih
                                                        </span>
                                                    </div>

                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                        <!-- Tombol Aksi Massal untuk Item Terpilih -->
                                                        <button type="button" class="btn btn-sm btn-success btn-bulk-action" data-bulk="enable" id="btn-bulk-enable" disabled>
                                                            <i class="ti ti-eye me-1.5"></i> Aktifkan Terpilih
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning text-dark btn-bulk-action" data-bulk="disable" id="btn-bulk-disable" disabled>
                                                            <i class="ti ti-eye-off me-1.5"></i> Nonaktifkan Terpilih
                                                        </button>
                                                        @can('delete dukunganaplikasi/fitur-aplikasi')
                                                            <button type="button" class="btn btn-sm btn-danger btn-bulk-action" data-bulk="delete" id="btn-bulk-delete" disabled>
                                                                <i class="ti ti-trash me-1.5"></i> Hapus Terpilih
                                                            </button>
                                                        @endcan
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-deselect-all" style="display: none;">
                                                            <i class="ti ti-x me-1.5"></i> Batal Pilih
                                                        </button>
                                                    </div>
                                                </div>
                                            @endcan

                                            <!-- TABEL DATA (Rule 8 Compliance: align-middle text-center text-nowrap) -->
                                            <div class="table-responsive">
                                                <table id="fitur-table" class="table table-hover table-bordered align-middle w-100 mb-0">
                                                    <thead class="table-light align-middle text-center text-nowrap">
                                                        <tr>
                                                            <th style="width: 45px;">
                                                                <input type="checkbox" class="form-check-input high-contrast-checkbox" id="check-all-page" title="Pilih Semua Baris di Halaman Ini">
                                                            </th>
                                                            <th style="width: 50px;">NO</th>
                                                            <th>NAMA & IKON FITUR</th>
                                                            <th>KODE FITUR (IDENTIFIER)</th>
                                                            <th>KELOMPOK</th>
                                                            <th>DESKRIPSI</th>
                                                            <th style="width: 80px;">URUTAN</th>
                                                            <th style="width: 140px;">STATUS</th>
                                                            <th style="width: 130px;">AKSI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($features as $f)
                                                            @php
                                                                $catBadge = match($f->kategori) {
                                                                    'topbar' => 'bg-primary-subtle text-primary border-primary-subtle',
                                                                    'menu_group' => 'bg-purple-subtle text-purple border-purple-subtle',
                                                                    'general' => 'bg-info-subtle text-info border-info-subtle',
                                                                    default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                                                };
                                                                $catLabel = match($f->kategori) {
                                                                    'topbar' => 'Topbar Header',
                                                                    'menu_group' => 'Sidebar Menu',
                                                                    'general' => 'Umum',
                                                                    default => ucfirst($f->kategori)
                                                                };
                                                            @endphp
                                                            <tr class="fitur-row" data-group="{{ $f->kategori }}" data-id="{{ $f->id }}">
                                                                <td class="text-center check-cell cursor-pointer">
                                                                    <input type="checkbox" class="form-check-input high-contrast-checkbox check-row-item" value="{{ $f->id }}" data-id="{{ $f->id }}">
                                                                </td>
                                                                <td class="text-center fw-semibold text-muted fitur-no">{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <div class="avatar-xs bg-light text-primary rounded d-flex align-items-center justify-content-center border">
                                                                            <i class="{{ $f->icon ?: 'ti ti-adjustments' }} fs-16"></i>
                                                                        </div>
                                                                        <div>
                                                                            <span class="fw-semibold text-dark">{{ $f->nama_fitur }}</span>
                                                                            @if ($f->is_system)
                                                                                <span class="badge bg-secondary-subtle text-muted border fs-10 ms-1" title="Fitur bawaan sistem">Bawaan</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <code class="bg-light text-primary border px-2 py-1 rounded fs-12 fw-semibold">{{ $f->kode_fitur }}</code>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge {{ $catBadge }} border fs-11 px-2 py-1">
                                                                        {{ $catLabel }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted fs-13">{{ $f->deskripsi ?: '-' }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge bg-light text-dark border">{{ $f->urutan }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                                                        <div class="form-check form-switch m-0 p-0">
                                                                            <input class="form-check-input switch-fitur-toggle m-0" 
                                                                                   type="checkbox" 
                                                                                   role="switch" 
                                                                                   id="switch_{{ $f->id }}" 
                                                                                   data-id="{{ $f->id }}" 
                                                                                   data-code="{{ $f->kode_fitur }}" 
                                                                                   value="1" 
                                                                                   {{ $f->status ? 'checked' : '' }}
                                                                                   @cannot('update dukunganaplikasi/fitur-aplikasi') disabled @endcannot>
                                                                        </div>
                                                                        <span class="status-indicator badge {{ $f->status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-11" id="badge_status_{{ $f->id }}">
                                                                            {{ $f->status ? 'Aktif' : 'Nonaktif' }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center text-nowrap">
                                                                    <!-- DETAIL -->
                                                                    <button type="button" class="btn btn-sm btn-outline-info btn-fitur-action me-1" data-action="view" data-row='@json($f)' title="Lihat Detail">
                                                                        <i class="ti ti-eye"></i>
                                                                    </button>

                                                                    <!-- EDIT -->
                                                                    @can('update dukunganaplikasi/fitur-aplikasi')
                                                                        <button type="button" class="btn btn-sm btn-outline-warning btn-fitur-action me-1" data-action="edit" data-row='@json($f)' title="Edit Fitur">
                                                                            <i class="ti ti-edit"></i>
                                                                        </button>
                                                                    @endcan

                                                                    <!-- HAPUS (Rule 9 Compliance: data-confirm standard for SweetAlert2) -->
                                                                    @can('delete dukunganaplikasi/fitur-aplikasi')
                                                                        <form action="{{ route('admin.dukunganaplikasi.fitur-aplikasi.destroy', $f->id) }}" method="POST" class="d-inline" data-confirm="Apakah Anda yakin ingin menghapus fitur &quot;{{ $f->nama_fitur }}&quot; ini dari sistem?">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Fitur">
                                                                                <i class="ti ti-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="9" class="text-center text-muted py-4">Belum ada data fitur aplikasi yang terdaftar.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- FOOTER INFO & PAGINATION BAR -->
                                            <div class="row align-items-center mt-3">
                                                <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                                    Menampilkan <strong id="visible-count">{{ count($features) }}</strong> dari <strong>{{ count($features) }}</strong> fitur
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                                    <ul class="pagination pagination-sm m-0" id="table-pagination"></ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer bg-light py-3">
                                            <span class="text-muted fs-13 d-flex align-items-center gap-2">
                                                <i class="ti ti-circle-check text-success fs-18"></i> 
                                                <span>Pilih fitur yang ingin diubah menggunakan kotak centang di tabel untuk melakukan pengaktifan, penonaktifan, atau penghapusan massal secara instan.</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FORM PARTIAL -->
    @include('admin.dukunganaplikasi.partials.fitur_aplikasi_modal')

    {{-- Config & Route Bridge for Module JS (Rule 15 Compliance) --}}
    <script>
        window.FiturAplikasiConfig = {
            routes: {
                toggle: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.toggle') }}",
                bulkAction: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.bulk-action') }}",
                updateSetting: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}",
                clearCache: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.clear-cache') }}",
                resetDefaults: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.reset-defaults') }}",
                store: "{{ route('admin.dukunganaplikasi.fitur-aplikasi.store') }}",
                baseUrl: "{{ url('admin/dukunganaplikasi/fitur-aplikasi') }}"
            }
        };
    </script>

    {{-- Page JS (Rule 1 & 15 Compliance: Placed inside @section('content') before @endsection) --}}
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/fitur-aplikasi.js') }}"></script>
@endsection
