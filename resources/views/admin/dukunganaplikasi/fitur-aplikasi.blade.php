@extends('layouts.vertical')

@section('title', 'Fitur Aplikasi')

@section('content')
    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Fitur Aplikasi', 'subtitle' => 'Dukungan Aplikasi'])

    <!-- WIDGET PANEL KONTROL & PENGATURAN FITUR APLIKASI -->
    <div class="row g-3 mb-4">
        <!-- WIDGET 1: VISIBILITAS & MANAJEMEN FITUR -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-adjustments-horizontal fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Visibilitas Fitur & Komponen</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Hub Kontrol</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted fs-12 fw-semibold">Status Fitur Sistem</span>
                            <span class="badge bg-success-subtle text-success fs-12 fw-bold" id="stat-active-badge">{{ $activeFeatures }} Aktif / {{ $totalFeatures }} Total</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            @php
                                $percentActive = $totalFeatures > 0 ? round(($activeFeatures / $totalFeatures) * 100) : 0;
                            @endphp
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $percentActive }}%;" aria-valuenow="{{ $percentActive }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-muted fs-12 mb-3">
                            Sembunyikan atau tampilkan komponen topbar, grup menu navigasi sidebar, dan modul fungsional aplikasi secara instan.
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="#features-management-section" class="btn btn-sm btn-primary w-100 fw-semibold">
                            <i class="ti ti-list-check me-1"></i> Buka Manajemen Fitur
                        </a>
                        @can('create dukunganaplikasi/fitur-aplikasi')
                            <button type="button" class="btn btn-sm btn-outline-primary btn-fitur-action flex-shrink-0" data-action="create" title="Tambah Fitur Baru">
                                <i class="ti ti-plus"></i>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGET 2: PENGATURAN WAKTU IDLE (AUTO LOCK SCREEN) -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-clock-pause fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Waktu Idle & Auto Lock</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Keamanan</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label for="widget_idle_timeout" class="form-label fs-12 fw-semibold text-dark mb-0">Batas Waktu Ketidakaktifan:</label>
                            <span class="badge bg-warning-subtle text-warning fs-11 fw-bold" id="badge-current-idle">Aktif: {{ $appSettings['idle_timeout_minutes'] > 0 ? $appSettings['idle_timeout_minutes'] . ' Menit' : 'Nonaktif' }}</span>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-light text-muted"><i class="ti ti-timer"></i></span>
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
                            Layar akan terkunci otomatis saat tidak ada interaksi mouse/keyboard selama durasi yang ditentukan.
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-idle-timeout">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Durasi Idle
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary flex-shrink-0" id="btn-test-lock-screen" title="Uji Kunci Layar Sekarang">
                            <i class="ti ti-lock me-1"></i> Uji Kunci
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGET 3: MODE PEMELIHARAAN (MAINTENANCE MODE) -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-tool fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Status Sistem & Maintenance</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Operasional</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold text-dark">Mode Pemeliharaan:</span>
                            <div class="form-check form-switch m-0 ps-4">
                                <input class="form-check-input" type="checkbox" role="switch" id="widget_maintenance_mode" {{ $appSettings['maintenance_mode'] ? 'checked' : '' }}>
                                <label class="form-check-label fs-12 fw-bold text-danger ms-2" for="widget_maintenance_mode" id="maintenance-status-label">{{ $appSettings['maintenance_mode'] ? 'Aktif' : 'Nonaktif' }}</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm" id="widget_maintenance_message" value="{{ $appSettings['maintenance_message'] }}" placeholder="Pesan untuk pengguna...">
                        </div>
                        <p class="text-muted fs-12 mb-3">
                            Saat aktif, pengguna biasa akan diarahkan ke laman pemeliharaan sementara administrator tetap memiliki akses.
                        </p>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-maintenance">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Status Pemeliharaan
                    </button>
                </div>
            </div>
        </div>

        <!-- WIDGET 4: KEAMANAN SESI & PROTEKSI LOGIN -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-shield-lock fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Keamanan & Proteksi Akun</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Proteksi</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label for="widget_rate_limit" class="fs-12 fw-semibold text-dark mb-0">Maks Gagal Login (Lockout):</label>
                            <select id="widget_rate_limit" class="form-select form-select-sm" style="width: 110px;">
                                <option value="3" {{ $appSettings['rate_limit_attempts'] == 3 ? 'selected' : '' }}>3 Kali</option>
                                <option value="5" {{ $appSettings['rate_limit_attempts'] == 5 ? 'selected' : '' }}>5 Kali</option>
                                <option value="10" {{ $appSettings['rate_limit_attempts'] == 10 ? 'selected' : '' }}>10 Kali</option>
                            </select>
                        </div>
                        <div class="form-check form-switch mb-2.5 ps-4">
                            <input class="form-check-input" type="checkbox" id="widget_auto_approval" {{ $appSettings['auto_user_approval'] ? 'checked' : '' }}>
                            <label class="form-check-label fs-12 text-dark ms-2" for="widget_auto_approval">Otomatis Setujui Pendaftaran Akun Baru</label>
                        </div>
                        <div class="form-check form-switch mb-2.5 ps-4">
                            <input class="form-check-input" type="checkbox" id="widget_new_device" {{ $appSettings['new_device_alert'] ? 'checked' : '' }}>
                            <label class="form-check-label fs-12 text-dark ms-2" for="widget_new_device">Notifikasi Login dari Perangkat Baru</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-security">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Kebijakan Keamanan
                    </button>
                </div>
            </div>
        </div>

        <!-- WIDGET 5: SINKRONISASI POLLING & NOTIFIKASI REAL-TIME -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-refresh fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Sinkronisasi Polling & Notifikasi</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Real-Time</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label for="widget_polling_interval" class="fs-12 fw-semibold text-dark mb-0">Interval Polling Latar Belakang:</label>
                            <select id="widget_polling_interval" class="form-select form-select-sm" style="width: 120px;">
                                <option value="10" {{ $appSettings['polling_interval'] == 10 ? 'selected' : '' }}>10 Detik</option>
                                <option value="20" {{ $appSettings['polling_interval'] == 20 ? 'selected' : '' }}>20 Detik (Standar)</option>
                                <option value="30" {{ $appSettings['polling_interval'] == 30 ? 'selected' : '' }}>30 Detik</option>
                                <option value="60" {{ $appSettings['polling_interval'] == 60 ? 'selected' : '' }}>60 Detik</option>
                            </select>
                        </div>
                        <div class="form-check form-switch mb-2.5 ps-4">
                            <input class="form-check-input" type="checkbox" id="widget_sound_notif" {{ $appSettings['sound_notification'] ? 'checked' : '' }}>
                            <label class="form-check-label fs-12 text-dark ms-2" for="widget_sound_notif">Audio Nada Suara Notifikasi Masuk</label>
                        </div>
                        <div class="form-check form-switch mb-2.5 ps-4">
                            <input class="form-check-input" type="checkbox" id="widget_toast_notif" {{ $appSettings['toast_notification'] ? 'checked' : '' }}>
                            <label class="form-check-label fs-12 text-dark ms-2" for="widget_toast_notif">Pop-up Toast Notifikasi Otomatis</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-save-polling">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Polling
                    </button>
                </div>
            </div>
        </div>

        <!-- WIDGET 6: MANAJEMEN CACHE & OPTIMASI KINERJA -->
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-cpu fs-20"></i>
                        <h6 class="card-title text-white mb-0 fw-bold">Cache & Optimasi Kinerja</h6>
                    </div>
                    <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">Server</span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <span class="badge bg-light text-dark border"><i class="ti ti-layout me-1 text-primary"></i> Views: Cached</span>
                            <span class="badge bg-light text-dark border"><i class="ti ti-route me-1 text-info"></i> Routes: Synced</span>
                            <span class="badge bg-light text-dark border"><i class="ti ti-settings me-1 text-warning"></i> Config: Loaded</span>
                            <span class="badge bg-light text-dark border"><i class="ti ti-database me-1 text-success"></i> Cache: Active</span>
                        </div>
                        <p class="text-muted fs-12 mb-3">
                            Bersihkan cache tampilan Blade, cache route URL, dan konfigurasi cache sistem untuk memperbarui perubahan seketika.
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-primary w-100 fw-semibold" id="btn-clear-all-cache">
                            <i class="ti ti-trash me-1"></i> Bersihkan Semua Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL MANAJEMEN FITUR -->
    <div class="row" id="features-management-section">
        <div class="col-12">
            <div class="card shadow-sm border-0">
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
                            <i class="ti ti-bolt text-warning me-1 fs-16"></i> Auto-Save Instant
                        </span>
                        @can('create dukunganaplikasi/fitur-aplikasi')
                            <button type="button" class="btn btn-light text-primary fw-semibold btn-fitur-action shadow-sm" data-action="create">
                                <i class="ti ti-plus me-1"></i> Tambah Fitur Baru
                            </button>
                        @endcan
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- FILTER CONTROLS & SEARCH BAR -->
                    <div class="row align-items-center mb-3 g-2">
                        <div class="col-md-4 d-flex align-items-center">
                            <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-filter me-1"></i> Kelompok:</label>
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
                                <div class="form-check m-0 d-flex align-items-center gap-2">
                                    <input class="form-check-input high-contrast-checkbox" type="checkbox" id="check-all-global" title="Centang Semua Fitur pada Kategori/Filter Ini">
                                    <label class="form-check-label fw-semibold fs-13 text-dark user-select-none cursor-pointer" for="check-all-global" id="check-all-label">
                                        Pilih Semua Fitur ({{ $totalFeatures }})
                                    </label>
                                </div>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 px-2.5 py-1 ms-2" id="selected-badge" style="display: none;">
                                    <i class="ti ti-check me-1"></i><span id="selected-count">0</span> terpilih
                                </span>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <!-- Tombol Aksi Massal untuk Item Terpilih -->
                                <button type="button" class="btn btn-sm btn-success btn-bulk-action" data-bulk="enable" id="btn-bulk-enable" disabled>
                                    <i class="ti ti-eye me-1"></i> Aktifkan Terpilih
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-dark btn-bulk-action" data-bulk="disable" id="btn-bulk-disable" disabled>
                                    <i class="ti ti-eye-off me-1"></i> Nonaktifkan Terpilih
                                </button>
                                @can('delete dukunganaplikasi/fitur-aplikasi')
                                    <button type="button" class="btn btn-sm btn-danger btn-bulk-action" data-bulk="delete" id="btn-bulk-delete" disabled>
                                        <i class="ti ti-trash me-1"></i> Hapus Terpilih
                                    </button>
                                @endcan
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-deselect-all" style="display: none;">
                                    <i class="ti ti-x me-1"></i> Batal Pilih
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
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <div class="form-check form-switch m-0">
                                                    <input class="form-check-input switch-large switch-fitur-toggle" 
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

    <!-- MODAL FORM PARTIAL -->
    @include('admin.dukunganaplikasi.partials.fitur_aplikasi_modal')

    <style>
        .form-check.form-switch {
            padding-left: 2.85em !important;
        }

        .form-check.form-switch .form-check-input {
            margin-left: -2.85em !important;
            cursor: pointer;
        }

        .form-check.form-switch .form-check-label {
            cursor: pointer;
            user-select: none;
            padding-left: 0.35rem;
        }

        .switch-large {
            width: 2.5em !important;
            height: 1.35em !important;
            cursor: pointer;
        }

        /* High-contrast, ultra-reliable SVG checkmark styling */
        .high-contrast-checkbox {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            border: 2px solid #475569 !important;
            background-color: #ffffff !important;
            width: 1.35em !important;
            height: 1.35em !important;
            cursor: pointer !important;
            border-radius: 4px !important;
            display: inline-block !important;
            position: relative !important;
            vertical-align: middle !important;
            transition: all 0.15s ease-in-out !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08) !important;
            margin: 0 !important;
        }

        .high-contrast-checkbox:hover {
            border-color: #0d6efd !important;
        }

        .high-contrast-checkbox:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3.5' d='m5 10 3.5 3.5L15 6'/%3e%3c/svg%3e") !important;
            background-position: center !important;
            background-size: 85% 85% !important;
            background-repeat: no-repeat !important;
            box-shadow: 0 2px 5px rgba(13, 110, 253, 0.35) !important;
        }

        .high-contrast-checkbox:indeterminate {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3.5' d='M5 10h10'/%3e%3c/svg%3e") !important;
            background-position: center !important;
            background-size: 85% 85% !important;
            background-repeat: no-repeat !important;
            box-shadow: 0 2px 5px rgba(13, 110, 253, 0.35) !important;
        }

        .bg-purple-subtle {
            background-color: rgba(114, 94, 195, 0.12) !important;
        }
        .text-purple {
            color: #725ec3 !important;
        }
        .border-purple-subtle {
            border-color: rgba(114, 94, 195, 0.25) !important;
        }
        .fitur-row.table-active {
            background-color: rgba(var(--bs-primary-rgb), 0.08) !important;
        }
        .cursor-pointer {
            cursor: pointer !important;
        }
    </style>

    {{-- Page JS (Rule 1 Compliance: Place scripts inside @section('content') before @endsection) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const table = document.getElementById('fitur-table');
            const tbody = table ? table.querySelector('tbody') : null;
            const categorySelect = document.getElementById('table-category-select');
            const lengthSelect = document.getElementById('table-length-select');
            const searchInput = document.getElementById('table-search-input');
            const btnClearSearch = document.getElementById('btn-clear-search');
            const paginationUl = document.getElementById('table-pagination');
            const infoBar = document.getElementById('table-info-bar');
            const statTotal = document.getElementById('stat-total');
            const statActive = document.getElementById('stat-active');
            const statInactive = document.getElementById('stat-inactive');

            // Bulk Action Elements
            const checkAllGlobal = document.getElementById('check-all-global');
            const checkAllLabel = document.getElementById('check-all-label');
            const checkAllPage = document.getElementById('check-all-page');
            const selectedBadge = document.getElementById('selected-badge');
            const selectedCountSpan = document.getElementById('selected-count');
            const btnBulkEnable = document.getElementById('btn-bulk-enable');
            const btnBulkDisable = document.getElementById('btn-bulk-disable');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const btnDeselectAll = document.getElementById('btn-deselect-all');

            // Modal Elements
            const modalEl = document.getElementById('fiturModal');
            const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
            const form = document.getElementById('fiturForm');
            const formMethod = document.getElementById('formMethod');
            const featureIdInput = document.getElementById('feature_id');
            const modalTitleText = document.getElementById('modalTitleText');
            const modalTitleIcon = document.getElementById('modalTitleIcon');
            const btnSubmitFitur = document.getElementById('btnSubmitFitur');
            const btnSubmitText = document.getElementById('btnSubmitText');
            const iconInput = document.getElementById('modal_icon');
            const iconPreview = document.getElementById('iconPreview');

            let currentPage = 1;
            let filteredRows = [];
            const selectedIds = new Set();

            // Live Icon Preview
            if (iconInput && iconPreview) {
                iconInput.addEventListener('input', function() {
                    const iconClass = this.value.trim() || 'ti ti-puzzle';
                    iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;
                });
            }

            // Update Selection UI
            function updateSelectionUI() {
                const count = selectedIds.size;
                if (selectedCountSpan) selectedCountSpan.textContent = count;

                const hasSelection = count > 0;
                if (selectedBadge) selectedBadge.style.display = hasSelection ? 'inline-block' : 'none';
                if (btnDeselectAll) btnDeselectAll.style.display = hasSelection ? 'inline-block' : 'none';

                if (btnBulkEnable) btnBulkEnable.disabled = !hasSelection;
                if (btnBulkDisable) btnBulkDisable.disabled = !hasSelection;
                if (btnBulkDelete) btnBulkDelete.disabled = !hasSelection;

                // Sync Row Highlights & Checkboxes across ALL rows in table
                const allRowCheckboxes = document.querySelectorAll('.check-row-item');
                allRowCheckboxes.forEach(cb => {
                    const row = cb.closest('tr');
                    const isChecked = selectedIds.has(String(cb.value));
                    cb.checked = isChecked;
                    if (row) {
                        if (isChecked) {
                            row.classList.add('table-active');
                        } else {
                            row.classList.remove('table-active');
                        }
                    }
                });

                // Check filtered rows match
                const filteredIds = filteredRows.map(row => {
                    const cb = row.querySelector('.check-row-item');
                    return cb ? String(cb.value) : null;
                }).filter(Boolean);

                const filteredSelectedCount = filteredIds.filter(id => selectedIds.has(id)).length;

                // Sync "Pilih Semua (Filtered)"
                if (checkAllGlobal) {
                    if (filteredIds.length > 0) {
                        checkAllGlobal.checked = (filteredSelectedCount === filteredIds.length);
                        checkAllGlobal.indeterminate = (filteredSelectedCount > 0 && filteredSelectedCount < filteredIds.length);
                    } else {
                        checkAllGlobal.checked = false;
                        checkAllGlobal.indeterminate = false;
                    }
                }

                // Sync Header "Check All Page"
                if (checkAllPage) {
                    const visibleRows = Array.from(document.querySelectorAll('.fitur-row:not([style*="display: none"])'));
                    const pageIds = visibleRows.map(row => {
                        const cb = row.querySelector('.check-row-item');
                        return cb ? String(cb.value) : null;
                    }).filter(Boolean);

                    const pageSelectedCount = pageIds.filter(id => selectedIds.has(id)).length;

                    if (pageIds.length > 0) {
                        checkAllPage.checked = (pageSelectedCount === pageIds.length);
                        checkAllPage.indeterminate = (pageSelectedCount > 0 && pageSelectedCount < pageIds.length);
                    } else {
                        checkAllPage.checked = false;
                        checkAllPage.indeterminate = false;
                    }
                }
            }

            // Client-side Filter, Search, & Pagination Logic
            function applyFilterAndPagination() {
                if (!tbody) return;
                const rows = Array.from(tbody.querySelectorAll('.fitur-row'));
                const selectedCat = categorySelect ? categorySelect.value : 'all';
                const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const pageSize = lengthSelect ? (lengthSelect.value === 'all' ? rows.length : parseInt(lengthSelect.value, 10)) : 25;

                filteredRows = rows.filter(row => {
                    const group = row.getAttribute('data-group');
                    const text = row.innerText.toLowerCase();

                    const matchCat = (selectedCat === 'all' || group === selectedCat);
                    const matchSearch = (!searchTerm || text.includes(searchTerm));

                    return matchCat && matchSearch;
                });

                // Hide all rows initially
                rows.forEach(r => r.style.display = 'none');

                const totalFiltered = filteredRows.length;
                const totalPages = Math.ceil(totalFiltered / pageSize) || 1;
                if (currentPage > totalPages) currentPage = 1;

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, totalFiltered);

                for (let i = startIndex; i < endIndex; i++) {
                    if (filteredRows[i]) {
                        filteredRows[i].style.display = '';
                    }
                }

                // Update Row Numbers
                filteredRows.forEach((row, idx) => {
                    const noCell = row.querySelector('.fitur-no');
                    if (noCell) noCell.textContent = idx + 1;
                });

                // Update Info Bar
                if (infoBar) {
                    infoBar.innerHTML = `Menampilkan <strong>${totalFiltered === 0 ? 0 : startIndex + 1} - ${endIndex}</strong> dari <strong>${totalFiltered}</strong> data fitur`;
                }

                // Update Check All Label
                if (checkAllLabel) {
                    if (selectedCat === 'all') {
                        checkAllLabel.textContent = `Pilih Semua (${totalFiltered} fitur)`;
                    } else {
                        const selectedOptionText = categorySelect.options[categorySelect.selectedIndex].text.split(' (')[0];
                        checkAllLabel.textContent = `Pilih Semua (${selectedOptionText}: ${totalFiltered} fitur)`;
                    }
                }

                // Render Pagination & Sync Checkboxes
                renderPagination(totalPages);
                updateSelectionUI();
            }

            function renderPagination(totalPages) {
                if (!paginationUl) return;
                paginationUl.innerHTML = '';
                if (totalPages <= 1) return;

                // Previous
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Previous"><i class="ti ti-chevron-left"></i></a>`;
                prevLi.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        applyFilterAndPagination();
                    }
                });
                paginationUl.appendChild(prevLi);

                // Page Numbers
                for (let p = 1; p <= totalPages; p++) {
                    if (totalPages > 7 && Math.abs(p - currentPage) > 2 && p !== 1 && p !== totalPages) {
                        if (p === 2 || p === totalPages - 1) {
                            const dotsLi = document.createElement('li');
                            dotsLi.className = 'page-item disabled';
                            dotsLi.innerHTML = `<span class="page-link">...</span>`;
                            paginationUl.appendChild(dotsLi);
                        }
                        continue;
                    }

                    const pageLi = document.createElement('li');
                    pageLi.className = `page-item ${p === currentPage ? 'active' : ''}`;
                    pageLi.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
                    pageLi.addEventListener('click', () => {
                        currentPage = p;
                        applyFilterAndPagination();
                    });
                    paginationUl.appendChild(pageLi);
                }

                // Next
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Next"><i class="ti ti-chevron-right"></i></a>`;
                nextLi.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        applyFilterAndPagination();
                    }
                });
                paginationUl.appendChild(nextLi);
            }

            // Recalculate Stats in UI
            function recalculateStats() {
                const switches = Array.from(document.querySelectorAll('.switch-fitur-toggle'));
                const activeCount = switches.filter(s => s.checked).length;
                const inactiveCount = switches.length - activeCount;

                if (statTotal) statTotal.textContent = switches.length;
                if (statActive) statActive.textContent = activeCount;
                if (statInactive) statInactive.textContent = inactiveCount;
            }

            // Event Listeners for Filters
            if (categorySelect) categorySelect.addEventListener('change', () => { currentPage = 1; applyFilterAndPagination(); });
            if (lengthSelect) lengthSelect.addEventListener('change', () => { currentPage = 1; applyFilterAndPagination(); });
            if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; applyFilterAndPagination(); });
            if (btnClearSearch) btnClearSearch.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                currentPage = 1;
                applyFilterAndPagination();
            });

            // Initial Table Render
            applyFilterAndPagination();

            // CHECKBOX SELECTION LOGIC (Rule 2 Compliance: Event Delegation)
            document.addEventListener('change', function(e) {
                const target = e.target;

                // 1. Single Row Checkbox
                if (target && target.classList.contains('check-row-item')) {
                    const idVal = String(target.value);
                    if (target.checked) {
                        selectedIds.add(idVal);
                    } else {
                        selectedIds.delete(idVal);
                    }
                    updateSelectionUI();
                }

                // 2. Check All on Current Visible Page
                if (target && target.id === 'check-all-page') {
                    const isChecked = target.checked;
                    const visibleRows = document.querySelectorAll('.fitur-row:not([style*="display: none"])');
                    visibleRows.forEach(row => {
                        const cb = row.querySelector('.check-row-item');
                        if (cb) {
                            const idVal = String(cb.value);
                            if (isChecked) {
                                selectedIds.add(idVal);
                            } else {
                                selectedIds.delete(idVal);
                            }
                        }
                    });
                    updateSelectionUI();
                }

                // 3. Check All in Current Filter Category
                if (target && target.id === 'check-all-global') {
                    const isChecked = target.checked;
                    filteredRows.forEach(row => {
                        const cb = row.querySelector('.check-row-item');
                        if (cb) {
                            const idVal = String(cb.value);
                            if (isChecked) {
                                selectedIds.add(idVal);
                            } else {
                                selectedIds.delete(idVal);
                            }
                        }
                    });
                    updateSelectionUI();
                }
            });

            // Clicking on cell toggles checkbox
            document.addEventListener('click', function(e) {
                const checkCell = e.target.closest('.check-cell');
                if (checkCell && e.target.tagName !== 'INPUT') {
                    const cb = checkCell.querySelector('.check-row-item');
                    if (cb) {
                        cb.checked = !cb.checked;
                        const idVal = String(cb.value);
                        if (cb.checked) {
                            selectedIds.add(idVal);
                        } else {
                            selectedIds.delete(idVal);
                        }
                        updateSelectionUI();
                    }
                }
            });

            // Deselect All Button
            if (btnDeselectAll) {
                btnDeselectAll.addEventListener('click', function() {
                    selectedIds.clear();
                    updateSelectionUI();
                });
            }

            function getCsrfToken() {
                return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            }

            // EVENT DELEGATION: Instant Switch Toggle via AJAX
            document.addEventListener('change', function(e) {
                const target = e.target;
                if (target && target.classList.contains('switch-fitur-toggle')) {
                    const featureId = target.getAttribute('data-id');
                    const featureCode = target.getAttribute('data-code');
                    const isChecked = target.checked ? 1 : 0;
                    const badgeStatus = document.getElementById(`badge_status_${featureId}`);

                    target.disabled = true;

                    fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            id: parseInt(featureId, 10),
                            feature: featureCode,
                            status: isChecked
                        })
                    })
                    .then(async res => {
                        let data;
                        try {
                            data = await res.json();
                        } catch (e) {
                            data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                        }
                        if (!res.ok) {
                            throw new Error(data.message || `Gagal menyimpan status (HTTP ${res.status}).`);
                        }
                        return data;
                    })
                    .then(data => {
                        target.disabled = false;
                        if (data.success) {
                            if (badgeStatus) {
                                badgeStatus.className = `status-indicator badge ${isChecked ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} fs-11`;
                                badgeStatus.textContent = isChecked ? 'Aktif' : 'Nonaktif';
                            }
                            recalculateStats();
                            window.showSuccess(data.message || 'Status fitur berhasil diperbarui.', { reload: true });
                        } else {
                            target.checked = !target.checked;
                            window.showError(data.message || 'Gagal mengubah status fitur.');
                        }
                    })
                    .catch(err => {
                        target.disabled = false;
                        target.checked = !target.checked;
                        console.error('Error toggling feature:', err);
                        window.showError(err.message || 'Terjadi kesalahan saat menyimpan status.');
                    });
                }
            });

            // EVENT DELEGATION: Bulk Action on Selected Rows (Aktifkan / Nonaktifkan / Hapus Terpilih)
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-bulk-action');
                if (btn) {
                    const action = btn.getAttribute('data-bulk');
                    const ids = Array.from(selectedIds).map(id => parseInt(id, 10)).filter(id => !isNaN(id));

                    if (ids.length === 0) {
                        window.showWarning('Silakan pilih minimal satu fitur terlebih dahulu.');
                        return;
                    }

                    const actionLabel = action === 'enable' ? 'mengaktifkan' : (action === 'disable' ? 'menonaktifkan' : 'menghapus');
                    const confirmTitle = action === 'delete' ? 'Konfirmasi Hapus Fitur' : 'Konfirmasi Ubah Status';
                    const confirmText = `Apakah Anda yakin ingin ${actionLabel} ${ids.length} fitur yang dipilih?`;

                    window.showConfirm({
                        title: confirmTitle,
                        text: confirmText,
                        isDanger: (action === 'delete'),
                        onConfirm: () => {
                            btn.disabled = true;

                            fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.bulk-action') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': getCsrfToken(),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    action: action,
                                    ids: ids
                                })
                            })
                            .then(async res => {
                                let data;
                                try {
                                    data = await res.json();
                                } catch (e) {
                                    data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                                }
                                if (!res.ok) {
                                    throw new Error(data.message || `Gagal memproses aksi massal (HTTP ${res.status}).`);
                                }
                                return data;
                            })
                            .then(data => {
                                btn.disabled = false;
                                if (data.success) {
                                    window.showSuccess(data.message, { reload: true });
                                } else {
                                    window.showError(data.message || 'Gagal memproses aksi massal.');
                                }
                            })
                            .catch(err => {
                                btn.disabled = false;
                                console.error('Error executing bulk action:', err);
                                window.showError(err.message || 'Terjadi kesalahan saat memproses aksi.');
                            });
                        }
                    });
                }
            });

            // WIDGET 2: IDLE TIMEOUT HANDLER
            const idleSelect = document.getElementById('widget_idle_timeout');
            const btnSaveIdle = document.getElementById('btn-save-idle-timeout');
            const btnTestLock = document.getElementById('btn-test-lock-screen');
            const badgeCurrentIdle = document.getElementById('badge-current-idle');

            const storedMins = localStorage.getItem('repalogic_idle_timeout_minutes');
            if (storedMins !== null && idleSelect) {
                idleSelect.value = storedMins;
                if (badgeCurrentIdle) {
                    badgeCurrentIdle.textContent = storedMins > 0 ? `Aktif: ${storedMins} Menit` : 'Nonaktif';
                }
            }

            if (btnSaveIdle && idleSelect) {
                btnSaveIdle.addEventListener('click', function() {
                    const mins = parseInt(idleSelect.value);
                    btnSaveIdle.disabled = true;
                    btnSaveIdle.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

                    fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            key: 'idle_timeout_minutes',
                            value: mins
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnSaveIdle.disabled = false;
                        btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Durasi Idle';

                        if (typeof window.setIdleTimeoutMinutes === 'function') {
                            window.setIdleTimeoutMinutes(mins);
                        } else {
                            localStorage.setItem('repalogic_idle_timeout_minutes', mins);
                        }

                        if (badgeCurrentIdle) {
                            badgeCurrentIdle.textContent = mins > 0 ? `Aktif: ${mins} Menit` : 'Nonaktif';
                        }

                        if (typeof window.showToast === 'function') {
                            window.showToast(mins > 0 ? `Waktu idle auto-lock diset ke ${mins} menit.` : 'Auto-lock dinonaktifkan.', 'success');
                        }
                    })
                    .catch(err => {
                        btnSaveIdle.disabled = false;
                        btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Durasi Idle';
                        window.showError(err.message || 'Gagal menyimpan pengaturan waktu idle.');
                    });
                });
            }

            if (btnTestLock) {
                btnTestLock.addEventListener('click', function() {
                    if (typeof window.lockScreen === 'function') {
                        window.lockScreen();
                    } else {
                        window.showWarning('Fungsi lock screen belum siap.');
                    }
                });
            }

            // WIDGET 3: MAINTENANCE MODE HANDLER
            const switchMaintenance = document.getElementById('widget_maintenance_mode');
            const labelMaintenance = document.getElementById('maintenance-status-label');
            const inputMaintenanceMsg = document.getElementById('widget_maintenance_message');
            const btnSaveMaintenance = document.getElementById('btn-save-maintenance');

            if (switchMaintenance && labelMaintenance) {
                switchMaintenance.addEventListener('change', function() {
                    labelMaintenance.textContent = this.checked ? 'Aktif' : 'Nonaktif';
                });
            }

            if (btnSaveMaintenance && switchMaintenance && inputMaintenanceMsg) {
                btnSaveMaintenance.addEventListener('click', function() {
                    btnSaveMaintenance.disabled = true;
                    btnSaveMaintenance.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

                    Promise.all([
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'maintenance_mode', value: switchMaintenance.checked ? 1 : 0 })
                        }),
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'maintenance_message', value: inputMaintenanceMsg.value })
                        })
                    ])
                    .then(() => {
                        btnSaveMaintenance.disabled = false;
                        btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Status Pemeliharaan';
                        window.showToast('Pengaturan mode pemeliharaan berhasil disimpan.', 'success');
                    })
                    .catch(err => {
                        btnSaveMaintenance.disabled = false;
                        btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Status Pemeliharaan';
                        window.showError(err.message || 'Gagal menyimpan status pemeliharaan.');
                    });
                });
            }

            // WIDGET 4: SECURITY POLICY HANDLER
            const selectRateLimit = document.getElementById('widget_rate_limit');
            const switchAutoApproval = document.getElementById('widget_auto_approval');
            const switchNewDevice = document.getElementById('widget_new_device');
            const btnSaveSecurity = document.getElementById('btn-save-security');

            if (btnSaveSecurity && selectRateLimit && switchAutoApproval && switchNewDevice) {
                btnSaveSecurity.addEventListener('click', function() {
                    btnSaveSecurity.disabled = true;
                    btnSaveSecurity.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

                    Promise.all([
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'rate_limit_attempts', value: selectRateLimit.value })
                        }),
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'auto_user_approval', value: switchAutoApproval.checked ? 1 : 0 })
                        }),
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'new_device_alert', value: switchNewDevice.checked ? 1 : 0 })
                        })
                    ])
                    .then(() => {
                        btnSaveSecurity.disabled = false;
                        btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Kebijakan Keamanan';
                        window.showToast('Kebijakan keamanan akun berhasil disimpan.', 'success');
                    })
                    .catch(err => {
                        btnSaveSecurity.disabled = false;
                        btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Kebijakan Keamanan';
                        window.showError(err.message || 'Gagal menyimpan kebijakan keamanan.');
                    });
                });
            }

            // WIDGET 5: POLLING & NOTIFICATION HANDLER
            const selectPollingInterval = document.getElementById('widget_polling_interval');
            const switchSoundNotif = document.getElementById('widget_sound_notif');
            const switchToastNotif = document.getElementById('widget_toast_notif');
            const btnSavePolling = document.getElementById('btn-save-polling');

            if (btnSavePolling && selectPollingInterval && switchSoundNotif && switchToastNotif) {
                btnSavePolling.addEventListener('click', function() {
                    btnSavePolling.disabled = true;
                    btnSavePolling.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

                    Promise.all([
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'polling_interval', value: selectPollingInterval.value })
                        }),
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'sound_notification', value: switchSoundNotif.checked ? 1 : 0 })
                        }),
                        fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.update-setting') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                            body: JSON.stringify({ key: 'toast_notification', value: switchToastNotif.checked ? 1 : 0 })
                        })
                    ])
                    .then(() => {
                        btnSavePolling.disabled = false;
                        btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Polling';
                        window.showToast('Konfigurasi sinkronisasi polling berhasil disimpan.', 'success');
                    })
                    .catch(err => {
                        btnSavePolling.disabled = false;
                        btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Polling';
                        window.showError(err.message || 'Gagal menyimpan konfigurasi polling.');
                    });
                });
            }

            // WIDGET 6: CLEAR SYSTEM CACHE HANDLER
            const btnClearCache = document.getElementById('btn-clear-all-cache');
            if (btnClearCache) {
                btnClearCache.addEventListener('click', function() {
                    window.showConfirm({
                        title: 'Bersihkan Cache Sistem?',
                        text: 'Tindakan ini akan mengosongkan cache Views Blade, Cache Route, Cache Konfigurasi, dan Cache Fitur secara menyeluruh.',
                        isDanger: false,
                        onConfirm: () => {
                            btnClearCache.disabled = true;
                            btnClearCache.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Membersihkan...';

                            fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.clear-cache') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': getCsrfToken(),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                btnClearCache.disabled = false;
                                btnClearCache.innerHTML = '<i class="ti ti-trash me-1"></i> Bersihkan Semua Cache';
                                if (data.success) {
                                    window.showSuccess(data.message, { reload: false });
                                } else {
                                    window.showError(data.message || 'Gagal membersihkan cache sistem.');
                                }
                            })
                            .catch(err => {
                                btnClearCache.disabled = false;
                                btnClearCache.innerHTML = '<i class="ti ti-trash me-1"></i> Bersihkan Semua Cache';
                                window.showError(err.message || 'Terjadi kesalahan saat membersihkan cache.');
                            });
                        }
                    });
                });
            }

            // EVENT DELEGATION: Action Buttons for Modal (Create, Edit, View) (Rule 2 Compliance)
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-fitur-action');
                if (btn) {
                    const action = btn.getAttribute('data-action');
                    const rowDataAttr = btn.getAttribute('data-row');
                    const rowData = rowDataAttr ? JSON.parse(rowDataAttr) : null;

                    if (!modal || !form) return;

                    form.reset();
                    // Reset inputs state
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(inp => inp.disabled = false);
                    btnSubmitFitur.style.display = '';

                    if (action === 'create') {
                        modalTitleText.textContent = 'Tambah Fitur Aplikasi Baru';
                        modalTitleIcon.className = 'ti ti-plus';
                        form.action = "{{ route('admin.dukunganaplikasi.fitur-aplikasi.store') }}";
                        formMethod.value = 'POST';
                        featureIdInput.value = '';
                        btnSubmitText.textContent = 'Simpan Fitur Baru';
                        document.getElementById('modal_status').checked = true;
                        if (iconPreview) iconPreview.innerHTML = `<i class="ti ti-puzzle fs-18 text-primary"></i>`;
                    } else if (action === 'edit' && rowData) {
                        modalTitleText.textContent = 'Edit Data Fitur Aplikasi';
                        modalTitleIcon.className = 'ti ti-edit';
                        form.action = `/admin/dukunganaplikasi/fitur-aplikasi/${rowData.id}`;
                        formMethod.value = 'PUT';
                        featureIdInput.value = rowData.id;
                        btnSubmitText.textContent = 'Perbarui Fitur';

                        document.getElementById('modal_kode_fitur').value = rowData.kode_fitur || '';
                        document.getElementById('modal_nama_fitur').value = rowData.nama_fitur || '';
                        document.getElementById('modal_kategori').value = rowData.kategori || 'topbar';
                        document.getElementById('modal_icon').value = rowData.icon || '';
                        document.getElementById('modal_urutan').value = rowData.urutan || 0;
                        document.getElementById('modal_deskripsi').value = rowData.deskripsi || '';
                        document.getElementById('modal_status').checked = Boolean(rowData.status);

                        const iconClass = (rowData.icon && rowData.icon.trim()) ? rowData.icon : 'ti ti-puzzle';
                        if (iconPreview) iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;
                    } else if (action === 'view' && rowData) {
                        modalTitleText.textContent = 'Detail Fitur Aplikasi';
                        modalTitleIcon.className = 'ti ti-eye';
                        formMethod.value = 'POST';
                        featureIdInput.value = rowData.id;

                        document.getElementById('modal_kode_fitur').value = rowData.kode_fitur || '';
                        document.getElementById('modal_nama_fitur').value = rowData.nama_fitur || '';
                        document.getElementById('modal_kategori').value = rowData.kategori || 'topbar';
                        document.getElementById('modal_icon').value = rowData.icon || '';
                        document.getElementById('modal_urutan').value = rowData.urutan || 0;
                        document.getElementById('modal_deskripsi').value = rowData.deskripsi || '';
                        document.getElementById('modal_status').checked = Boolean(rowData.status);

                        const iconClass = (rowData.icon && rowData.icon.trim()) ? rowData.icon : 'ti ti-puzzle';
                        if (iconPreview) iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;

                        // Disable all fields in view mode
                        inputs.forEach(inp => inp.disabled = true);
                        btnSubmitFitur.style.display = 'none';
                    }

                    modal.show();
                }
            });
        });
    </script>
@endsection
