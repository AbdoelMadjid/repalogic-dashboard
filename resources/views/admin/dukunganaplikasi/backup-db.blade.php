@extends('layouts.vertical')

@section('title', 'Backup Database & Cloud Sync')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/backup-db.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Backup Database & Cloud Sync', 'subtitle' => 'Dukungan Aplikasi'])

    <!-- Metrics Cards -->
    <div class="row g-3 mb-4">
        <!-- Database Metric -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-12 fw-semibold text-uppercase">Database Aktif</span>
                        <h5 class="mb-0 fw-bold text-dark mt-1 text-truncate" style="max-width: 150px;" title="{{ $dbName }}">{{ $dbName }}</h5>
                        <span class="fs-11 text-primary fw-medium"><i class="ti ti-table me-1"></i>{{ $totalTables }} Tabel ({{ $totalSizeMb }} MB)</span>
                    </div>
                    <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-database fs-24"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Status Metric -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-12 fw-semibold text-uppercase">Backup Otomatis</span>
                        <h5 class="mb-0 fw-bold mt-1">
                            @if ($scheduleConfig['enabled'])
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-12">
                                    <i class="ti ti-check me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill fs-12">
                                    <i class="ti ti-x me-1"></i>Nonaktif
                                </span>
                            @endif
                        </h5>
                        <span class="fs-11 text-muted fw-medium">
                            @if ($scheduleConfig['enabled'])
                                <i class="ti ti-clock me-1 text-primary"></i>{{ ucfirst($scheduleConfig['frequency']) }} pukul {{ $scheduleConfig['time'] }}
                            @else
                                Belum dijadwalkan
                            @endif
                        </span>
                    </div>
                    <div class="avatar-md bg-{{ $scheduleConfig['enabled'] ? 'success' : 'secondary' }}-subtle text-{{ $scheduleConfig['enabled'] ? 'success' : 'secondary' }} rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar-time fs-24"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cloud Storage Metric -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-12 fw-semibold text-uppercase">Cloud Storage Sync</span>
                        <h5 class="mb-0 fw-bold mt-1">
                            @if ($cloudConfig['driver'] === 's3')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fs-12">
                                    <i class="ti ti-brand-amazon me-1"></i>AWS S3
                                </span>
                            @elseif ($cloudConfig['driver'] === 'gdrive')
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill fs-12">
                                    <i class="ti ti-brand-google-drive me-1"></i>Google Drive
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill fs-12">
                                    <i class="ti ti-cloud-off me-1"></i>Hanya Lokal
                                </span>
                            @endif
                        </h5>
                        <span class="fs-11 text-muted fw-medium">
                            @if ($cloudConfig['last_sync_at'])
                                <i class="ti ti-clock me-1"></i>{{ \Carbon\Carbon::parse($cloudConfig['last_sync_at'])->diffForHumans() }}
                            @else
                                Belum pernah sync
                            @endif
                        </span>
                    </div>
                    <div class="avatar-md bg-{{ $cloudConfig['driver'] !== 'none' ? 'info' : 'secondary' }}-subtle text-{{ $cloudConfig['driver'] !== 'none' ? 'info' : 'secondary' }} rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-cloud-upload fs-24"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Files History Metric -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-12 fw-semibold text-uppercase">Berkas Tersimpan</span>
                        <h5 class="mb-0 fw-bold text-dark mt-1">{{ count($backupFiles) }} File</h5>
                        <span class="fs-11 text-info fw-medium">
                            <i class="ti ti-folder me-1"></i>storage/app/backups
                        </span>
                    </div>
                    <div class="avatar-md bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-files fs-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation (Rule 17 & 18 Compliant: Button elements with data-bs-target, mobile responsive icon-only) -->
    <ul class="nav nav-tabs nav-bordered mb-4" id="backupTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active py-2.5 px-3 fw-semibold d-flex align-items-center justify-content-center"
                id="tab-manual-btn" data-bs-toggle="tab" data-bs-target="#tab-manual-pane" type="button"
                role="tab" aria-controls="tab-manual-pane" aria-selected="true" title="Backup Manual">
                <i class="ti ti-database-export me-0 me-md-1.5 fs-18 align-middle"></i>
                <span class="d-none d-md-inline">Backup Manual</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-2.5 px-3 fw-semibold d-flex align-items-center justify-content-center position-relative"
                id="tab-scheduled-btn" data-bs-toggle="tab" data-bs-target="#tab-scheduled-pane" type="button"
                role="tab" aria-controls="tab-scheduled-pane" aria-selected="false" title="Jadwal Backup Otomatis">
                <i class="ti ti-clock-cog me-0 me-md-1.5 fs-18 align-middle"></i>
                <span class="d-none d-md-inline">Jadwal Backup Otomatis</span>
                @if ($scheduleConfig['enabled'])
                    <span class="badge bg-success-subtle text-success rounded-pill ms-1.5 font-monospace fs-10 d-none d-md-inline-block">Aktif</span>
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-2.5 px-3 fw-semibold d-flex align-items-center justify-content-center"
                id="tab-cloud-btn" data-bs-toggle="tab" data-bs-target="#tab-cloud-pane" type="button"
                role="tab" aria-controls="tab-cloud-pane" aria-selected="false" title="Sinkronisasi Cloud Storage">
                <i class="ti ti-cloud-upload me-0 me-md-1.5 fs-18 align-middle"></i>
                <span class="d-none d-md-inline">Sinkronisasi Cloud Storage</span>
                @if ($cloudConfig['driver'] !== 'none')
                    <span class="badge bg-info-subtle text-info rounded-pill ms-1.5 font-monospace fs-10 d-none d-md-inline-block">{{ strtoupper($cloudConfig['driver']) }}</span>
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-2.5 px-3 fw-semibold d-flex align-items-center justify-content-center"
                id="tab-history-btn" data-bs-toggle="tab" data-bs-target="#tab-history-pane" type="button"
                role="tab" aria-controls="tab-history-pane" aria-selected="false" title="Riwayat Berkas ({{ count($backupFiles) }})">
                <i class="ti ti-history me-0 me-md-1.5 fs-18 align-middle"></i>
                <span class="d-none d-md-inline">Riwayat Berkas</span>
                <span class="badge bg-primary-subtle text-primary rounded-pill ms-1.5 font-monospace fs-11">{{ count($backupFiles) }}</span>
            </button>
        </li>
    </ul>

    <!-- Tab Content Panes -->
    <div class="tab-content" id="backupTabContent">
        <!-- ===================================================================
             TAB 1: BACKUP MANUAL
             =================================================================== -->
        <div class="tab-pane fade show active" id="tab-manual-pane" role="tabpanel" aria-labelledby="tab-manual-btn" tabindex="0">
            <form action="{{ route('admin.dukunganaplikasi.backup-db.process') }}" method="POST" id="form-process-backup">
                @csrf
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start gap-1 gap-md-2">
                        <i class="ti ti-database-export fs-22 flex-shrink-0"></i>
                        <h5 class="card-title text-white mb-0">Konfigurasi Backup Manual</h5>
                    </div>

                    <div class="card-body">
                        <!-- Mode Backup & Opsi Target Output -->
                        <div class="row g-4 mb-4">
                            <!-- Opsi Jenis Backup -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark fs-14 mb-2">Pilih Jenis Backup <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="card border mb-0 cursor-pointer card-option active hover-border-primary" id="card-option-full">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="backup_type" id="type_full" value="full" checked>
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="type_full">
                                                    Backup Seluruh DB
                                                </label>
                                                <span class="fs-12 text-muted">Eksport {{ $totalTables }} tabel sekaligus</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="card border mb-0 cursor-pointer card-option hover-border-primary" id="card-option-selective">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="backup_type" id="type_selective" value="selective">
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="type_selective">
                                                    Pilih Tabel Tertentu
                                                </label>
                                                <span class="fs-12 text-muted">Pilih tabel spesifik</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Opsi Target Output -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark fs-14 mb-2">Target Output Backup <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="card border mb-0 cursor-pointer card-output active hover-border-primary" id="card-output-download">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="output_target" id="target_download" value="download" checked>
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="target_download">
                                                    Unduh Berkas .SQL
                                                </label>
                                                <span class="fs-12 text-muted">Download langsung ke komputer</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="card border mb-0 cursor-pointer card-output hover-border-primary" id="card-output-save">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="output_target" id="target_save" value="save">
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="target_save">
                                                    Simpan ke Storage
                                                </label>
                                                <span class="fs-12 text-muted">Simpan di server lokal</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Opsi Tambahan DROP & CREATE DATABASE -->
                        <div class="p-3 bg-light rounded border mb-4 option-db-statement-box">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input option-db-switch" type="checkbox" name="include_create_db" id="include_create_db" value="1" role="switch">
                                <label class="form-check-label fw-bold text-dark fs-14" for="include_create_db">
                                    Sertakan Perintah DROP & CREATE DATABASE
                                </label>
                                <p class="fs-12 text-muted mb-0 mt-1">
                                    Jika diaktifkan, berkas .SQL akan diawali dengan perintah <code>DROP DATABASE IF EXISTS `{{ $dbName }}`; CREATE DATABASE `{{ $dbName }}`; USE `{{ $dbName }}`;</code> untuk kemudahan restore utuh dari nol.
                                </p>
                            </div>
                        </div>

                        <!-- Panel Pemilihan Tabel (Tersembunyi jika Backup Full) -->
                        <div id="panel-selective-tables" style="display: none;">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between pb-2 mb-3 border-bottom gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-list-check text-primary fs-20"></i>
                                    <h5 class="mb-0 text-dark fw-bold">Daftar Tabel Database & Informasi Relasi</h5>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Cari nama tabel..." style="width: 220px;">
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="checkbox" id="check-all-tables">
                                        <label class="form-check-label fw-semibold text-dark fs-13" for="check-all-tables">Pilih Semua</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert Informasi Relasi Dinamis -->
                            <div id="relational-info-alert" class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-2 mb-3 py-2 px-3" style="display: none;">
                                <i class="ti ti-info-circle fs-20 text-info"></i>
                                <span class="fs-13 text-dark" id="relational-info-text">Tabel yang memiliki relasi foreign key ditandai dengan badge khusus di sampingnya.</span>
                            </div>

                            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                                <table class="table table-hover align-middle border mb-0" id="table-selective-list">
                                    <thead class="table-light sticky-top align-middle text-center text-nowrap">
                                        <tr class="align-middle text-center text-nowrap">
                                            <th style="width: 40px;" class="text-center align-middle text-nowrap">#</th>
                                            <th class="text-center align-middle text-nowrap">Nama Tabel</th>
                                            <th class="text-center align-middle text-nowrap">Jumlah Baris</th>
                                            <th class="text-center align-middle text-nowrap">Ukuran</th>
                                            <th class="text-center align-middle text-nowrap">Informasi Relasi (Foreign Keys)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tables as $index => $t)
                                            <tr class="table-row-item" data-table-name="{{ $t['name'] }}">
                                                <td class="text-center">
                                                    <input class="form-check-input checkbox-table-item" type="checkbox" name="tables[]" value="{{ $t['name'] }}" id="table_check_{{ $index }}" data-parents="{{ json_encode($t['parents']) }}" data-children="{{ json_encode($t['children']) }}">
                                                </td>
                                                <td>
                                                    <label for="table_check_{{ $index }}" class="fw-semibold text-dark mb-0 cursor-pointer">
                                                        <code>{{ $t['name'] }}</code>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary-subtle text-dark fs-12">{{ number_format($t['rows']) }} Baris</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border fs-12">{{ $t['size_mb'] }} MB</span>
                                                </td>
                                                <td>
                                                    @if (!$t['has_relations'])
                                                        <span class="text-muted fs-12"><i class="ti ti-minus me-1"></i>Tidak ada relasi</span>
                                                    @else
                                                        <div class="d-flex flex-wrap align-items-center gap-1">
                                                            @foreach ($t['parents'] as $parent)
                                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-11" title="Tabel ini memiliki Foreign Key ke {{ $parent }}">
                                                                    <i class="ti ti-arrow-up-right me-1"></i>Relasi Ke: <strong>{{ $parent }}</strong>
                                                                </span>
                                                            @endforeach

                                                            @foreach ($t['children'] as $child)
                                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-11" title="Tabel {{ $child }} memiliki Foreign Key ke tabel ini">
                                                                    <i class="ti ti-arrow-down-left me-1"></i>Direferensikan Oleh: <strong>{{ $child }}</strong>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2 backup-form-footer">
                        <span class="text-muted fs-13 d-flex flex-column flex-md-row align-items-center gap-1.5 gap-md-2">
                            <i class="ti ti-shield-check text-success fs-18 flex-shrink-0"></i>
                            <span>Proses ekspor menggunakan perintah SQL standar yang kompatibel untuk restore di phpMyAdmin / MySQL CLI.</span>
                        </span>
                        @can('create dukunganaplikasi/backup-db')
                            <button type="submit" class="btn btn-primary px-4 fw-semibold flex-shrink-0">
                                <i class="ti ti-download me-1 fs-18"></i> Proses & Ekspor Backup
                            </button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <!-- ===================================================================
             TAB 2: JADWAL BACKUP OTOMATIS (SCHEDULED CRON JOB)
             =================================================================== -->
        <div class="tab-pane fade" id="tab-scheduled-pane" role="tabpanel" aria-labelledby="tab-scheduled-btn" tabindex="0">
            <div class="row g-4">
                <!-- Form Pengaturan Jadwal -->
                <div class="col-lg-8">
                    <form action="{{ route('admin.dukunganaplikasi.backup-db.save-schedule') }}" method="POST" id="form-backup-schedule">
                        @csrf
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-clock-cog fs-22 flex-shrink-0"></i>
                                    <h5 class="card-title text-white mb-0">Konfigurasi Backup Otomatis Terjadwal</h5>
                                </div>
                                <span class="badge bg-white text-primary fw-semibold fs-12 px-2.5 py-1">
                                    Laravel Scheduler & Cron
                                </span>
                            </div>

                            <div class="card-body p-4">
                                <!-- Switch Utama: Status Aktif Jadwal -->
                                <div class="p-3 bg-light rounded border mb-4">
                                    <div class="form-check form-switch d-flex align-items-center justify-content-between p-0 mb-0">
                                        <div>
                                            <label class="form-check-label fw-bold text-dark fs-15 d-block cursor-pointer" for="backup_schedule_enabled">
                                                Aktifkan Backup Otomatis Terjadwal
                                            </label>
                                            <span class="fs-13 text-muted">
                                                Sistem akan membuat dump database secara otomatis pada interval waktu yang ditentukan.
                                            </span>
                                        </div>
                                        <input class="form-check-input fs-18 ms-3 cursor-pointer" type="checkbox" name="backup_schedule_enabled" id="backup_schedule_enabled" value="1" {{ $scheduleConfig['enabled'] ? 'checked' : '' }} role="switch">
                                    </div>
                                </div>

                                <div id="schedule-details-container" style="{{ $scheduleConfig['enabled'] ? '' : 'opacity: 0.6;' }}">
                                    <!-- Frekuensi & Waktu Eksekusi -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_schedule_frequency">
                                                <i class="ti ti-calendar me-1 text-primary"></i>Frekuensi Backup <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="backup_schedule_frequency" id="backup_schedule_frequency" required>
                                                <option value="daily" {{ $scheduleConfig['frequency'] === 'daily' ? 'selected' : '' }}>Harian (Setiap Hari)</option>
                                                <option value="weekly" {{ $scheduleConfig['frequency'] === 'weekly' ? 'selected' : '' }}>Mingguan (Setiap Minggu)</option>
                                                <option value="monthly" {{ $scheduleConfig['frequency'] === 'monthly' ? 'selected' : '' }}>Bulanan (Setiap Bulan)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_schedule_time">
                                                <i class="ti ti-clock me-1 text-primary"></i>Jam Pelaksanaan (WIB) <span class="text-danger">*</span>
                                            </label>
                                            <input type="time" class="form-control" name="backup_schedule_time" id="backup_schedule_time" value="{{ $scheduleConfig['time'] }}" required>
                                            <span class="fs-12 text-muted">Disarankan memilih waktu dini hari (misal <code>02:00</code>) saat traffic rendah.</span>
                                        </div>

                                        <!-- Opsi Hari (Mingguan / Bulanan) -->
                                        <div class="col-md-6" id="schedule-day-container" style="{{ in_array($scheduleConfig['frequency'], ['weekly', 'monthly']) ? '' : 'display: none;' }}">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_schedule_day" id="label-schedule-day">
                                                Hari Pelaksanaan
                                            </label>
                                            <select class="form-select" name="backup_schedule_day" id="backup_schedule_day">
                                                <option value="1" {{ (string)$scheduleConfig['day'] === '1' ? 'selected' : '' }}>Senin / Tanggal 1</option>
                                                <option value="2" {{ (string)$scheduleConfig['day'] === '2' ? 'selected' : '' }}>Selasa / Tanggal 2</option>
                                                <option value="3" {{ (string)$scheduleConfig['day'] === '3' ? 'selected' : '' }}>Rabu / Tanggal 3</option>
                                                <option value="4" {{ (string)$scheduleConfig['day'] === '4' ? 'selected' : '' }}>Kamis / Tanggal 4</option>
                                                <option value="5" {{ (string)$scheduleConfig['day'] === '5' ? 'selected' : '' }}>Jumat / Tanggal 5</option>
                                                <option value="6" {{ (string)$scheduleConfig['day'] === '6' ? 'selected' : '' }}>Sabtu / Tanggal 6</option>
                                                <option value="7" {{ (string)$scheduleConfig['day'] === '7' ? 'selected' : '' }}>Minggu / Tanggal 7</option>
                                            </select>
                                        </div>

                                        <!-- Tipe Backup Jadwal -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_schedule_type">
                                                <i class="ti ti-database me-1 text-primary"></i>Cakupan Backup <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" name="backup_schedule_type" id="backup_schedule_type" required>
                                                <option value="full" {{ $scheduleConfig['type'] === 'full' ? 'selected' : '' }}>Seluruh Database (Semua {{ $totalTables }} Tabel)</option>
                                                <option value="selective" {{ $scheduleConfig['type'] === 'selective' ? 'selected' : '' }}>Tabel Pilihan Tertentu</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retensi & Kompresi -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_retention_days">
                                                <i class="ti ti-trash-x me-1 text-danger"></i>Retensi Masa Simpan (Hari)
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="backup_retention_days" id="backup_retention_days" value="{{ $scheduleConfig['retention_days'] }}" min="0" max="365">
                                                <span class="input-group-text bg-light">Hari</span>
                                            </div>
                                            <span class="fs-12 text-muted">Hapus berkas lokal yang berusia lebih dari X hari (0 = simpan selamanya).</span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_max_files">
                                                <i class="ti ti-archive me-1 text-primary"></i>Batas Maksimal File Tersimpan
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="backup_max_files" id="backup_max_files" value="{{ $scheduleConfig['max_files'] }}" min="1" max="100">
                                                <span class="input-group-text bg-light">File</span>
                                            </div>
                                            <span class="fs-12 text-muted">Hanya simpan N berkas terbaru di storage untuk mencegah kehabisan disk.</span>
                                        </div>
                                    </div>

                                    <!-- Switch Opsi Tambahan -->
                                    <div class="border rounded p-3 mb-3 bg-light">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="backup_compression" id="backup_compression" value="1" {{ $scheduleConfig['compression'] ? 'checked' : '' }} role="switch">
                                            <label class="form-check-label fw-semibold text-dark fs-13" for="backup_compression">
                                                Aktifkan Kompresi Gzip (<code>.sql.gz</code>)
                                            </label>
                                            <span class="d-block fs-12 text-muted">Mengurangi ukuran berkas hingga 80-90% untuk menghemat kapasitas storage dan transfer cloud.</span>
                                        </div>

                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" name="backup_include_create_db" id="sched_include_create_db" value="1" {{ $scheduleConfig['include_create_db'] ? 'checked' : '' }} role="switch">
                                            <label class="form-check-label fw-semibold text-dark fs-13" for="sched_include_create_db">
                                                Sertakan Pernyataan DROP & CREATE DATABASE
                                            </label>
                                            <span class="d-block fs-12 text-muted">Menyertakan instruksi inisialisasi database lengkap pada awalan berkas dump.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2">
                                <span class="text-muted fs-12">
                                    <i class="ti ti-info-circle me-1 text-primary"></i>Jadwal otomatis dijalankan via cron command <code>php artisan schedule:run</code>.
                                </span>
                                @can('update dukunganaplikasi/backup-db')
                                    <button type="submit" class="btn btn-primary px-4 fw-semibold flex-shrink-0">
                                        <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Jadwal
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Info & Manual Trigger Scheduled Backup -->
                <div class="col-lg-4">
                    <!-- Card Status Eksekusi Terakhir -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-1.5">
                                <i class="ti ti-activity text-primary fs-18"></i>
                                <span>Status Eksekusi Terakhir</span>
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            @if ($scheduleConfig['last_run_at'])
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-13">Waktu Eksekusi:</span>
                                    <span class="fw-semibold text-dark fs-13 font-monospace">{{ $scheduleConfig['last_run_at'] }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-13">Status:</span>
                                    @if ($scheduleConfig['last_run_status'] === 'success')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-12">
                                            <i class="ti ti-check me-1"></i>Sukses
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fs-12">
                                            <i class="ti ti-alert-triangle me-1"></i>Gagal
                                        </span>
                                    @endif
                                </div>
                                <div class="p-2.5 bg-light rounded border fs-12 text-dark font-monospace text-break mb-3">
                                    {{ $scheduleConfig['last_run_message'] ?? 'Tidak ada catatan log.' }}
                                </div>
                            @else
                                <div class="text-center py-3 text-muted fs-13">
                                    <i class="ti ti-clock-cancel fs-24 d-block mb-1 text-secondary"></i>
                                    Belum ada catatan eksekusi backup otomatis.
                                </div>
                            @endif

                            @can('create dukunganaplikasi/backup-db')
                                <form action="{{ route('admin.dukunganaplikasi.backup-db.run-scheduled-now') }}" method="POST" id="form-run-scheduled-now">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-1.5" id="btn-trigger-scheduled">
                                        <i class="ti ti-player-play fs-16"></i>
                                        <span>Jalankan Backup Terjadwal Sekarang</span>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <!-- Card Panduan Cron Server -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-1.5">
                                <i class="ti ti-terminal-2 text-primary fs-18"></i>
                                <span>Panduan Konfigurasi Cron Server</span>
                            </h6>
                        </div>
                        <div class="card-body p-3 fs-13 text-muted">
                            <p class="mb-2">Agar jadwal backup otomatis berjalan tepat waktu, tambahkan perintah berikut ke dalam <strong>crontab</strong> server Anda:</p>
                            <div class="p-2.5 bg-dark text-light rounded font-monospace fs-11 text-break mb-2">
                                * * * * * cd {{ base_path() }} && php artisan schedule:run >> /dev/null 2>&1
                            </div>
                            <span class="fs-12 text-muted d-block">
                                <i class="ti ti-info-circle me-1 text-info"></i>Laravel Scheduler akan otomatis mengevaluasi jam eksekusi tanpa membebani resource server.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================================================================
             TAB 3: SINKRONISASI CLOUD STORAGE (AWS S3 / GOOGLE DRIVE)
             =================================================================== -->
        <div class="tab-pane fade" id="tab-cloud-pane" role="tabpanel" aria-labelledby="tab-cloud-btn" tabindex="0">
            <div class="row g-4">
                <div class="col-lg-8">
                    <form action="{{ route('admin.dukunganaplikasi.backup-db.save-cloud') }}" method="POST" id="form-cloud-storage">
                        @csrf
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-cloud-upload fs-22 flex-shrink-0"></i>
                                    <h5 class="card-title text-white mb-0">Integrasi Cloud Storage Backup</h5>
                                </div>
                                <span class="badge bg-white text-primary fw-semibold fs-12 px-2.5 py-1">
                                    Disaster Recovery Ready
                                </span>
                            </div>

                            <div class="card-body p-4">
                                <label class="form-label fw-bold text-dark fs-14 mb-3">Pilih Penyedia Cloud Storage <span class="text-danger">*</span></label>
                                
                                <!-- Cloud Provider Selection Cards -->
                                <div class="row g-3 mb-4">
                                    <!-- None / Local Only -->
                                    <div class="col-md-4">
                                        <div class="card border mb-0 cursor-pointer card-cloud-provider {{ $cloudConfig['driver'] === 'none' ? 'active' : '' }} hover-border-primary" id="card-cloud-none" data-provider="none">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="backup_cloud_driver" id="driver_none" value="none" {{ $cloudConfig['driver'] === 'none' ? 'checked' : '' }}>
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="driver_none">
                                                    Hanya Lokal
                                                </label>
                                                <span class="fs-12 text-muted">Simpan di storage server lokal saja</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- AWS S3 / Compatible -->
                                    <div class="col-md-4">
                                        <div class="card border mb-0 cursor-pointer card-cloud-provider {{ $cloudConfig['driver'] === 's3' ? 'active' : '' }} hover-border-primary" id="card-cloud-s3" data-provider="s3">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="backup_cloud_driver" id="driver_s3" value="s3" {{ $cloudConfig['driver'] === 's3' ? 'checked' : '' }}>
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="driver_s3">
                                                    Amazon S3 / S3-API
                                                </label>
                                                <span class="fs-12 text-muted">AWS S3, MinIO, Wasabi, Cloudflare R2</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Google Drive -->
                                    <div class="col-md-4">
                                        <div class="card border mb-0 cursor-pointer card-cloud-provider {{ $cloudConfig['driver'] === 'gdrive' ? 'active' : '' }} hover-border-primary" id="card-cloud-gdrive" data-provider="gdrive">
                                            <div class="card-body p-3 text-center">
                                                <input class="form-check-input mb-2" type="radio" name="backup_cloud_driver" id="driver_gdrive" value="gdrive" {{ $cloudConfig['driver'] === 'gdrive' ? 'checked' : '' }}>
                                                <label class="form-check-label d-block fw-semibold text-dark fs-14 cursor-pointer" for="driver_gdrive">
                                                    Google Drive
                                                </label>
                                                <span class="fs-12 text-muted">Google Drive API / Service Account</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel Konfigurasi AWS S3 -->
                                <div id="panel-config-s3" class="border rounded p-3 bg-light mb-3" style="{{ $cloudConfig['driver'] === 's3' ? '' : 'display: none;' }}">
                                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                        <i class="ti ti-brand-amazon text-warning fs-18"></i>
                                        <span>Kredensial Amazon S3 & S3-Compatible Storage</span>
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_s3_key">
                                                AWS Access Key ID <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="backup_cloud_s3_key" id="backup_cloud_s3_key" value="{{ $cloudConfig['s3_key'] }}" placeholder="e.g. AKIAIOSFODNN7EXAMPLE">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_s3_secret">
                                                AWS Secret Access Key <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" name="backup_cloud_s3_secret" id="backup_cloud_s3_secret" value="{{ $cloudConfig['s3_secret'] }}" placeholder="Masukkan secret key...">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_s3_bucket">
                                                S3 Bucket Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="backup_cloud_s3_bucket" id="backup_cloud_s3_bucket" value="{{ $cloudConfig['s3_bucket'] }}" placeholder="e.g. repalogic-db-backups">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_s3_region">
                                                AWS Region <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="backup_cloud_s3_region" id="backup_cloud_s3_region" value="{{ $cloudConfig['s3_region'] }}" placeholder="e.g. ap-southeast-1, us-east-1">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_s3_endpoint">
                                                Custom S3 Endpoint URL <span class="text-muted fw-normal">(Opsional untuk MinIO / Wasabi / Cloudflare R2)</span>
                                            </label>
                                            <input type="url" class="form-control" name="backup_cloud_s3_endpoint" id="backup_cloud_s3_endpoint" value="{{ $cloudConfig['s3_endpoint'] }}" placeholder="e.g. https://s3.ap-southeast-1.wasabisys.com atau http://127.0.0.1:9000">
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="backup_cloud_s3_use_path_style" id="backup_cloud_s3_use_path_style" value="1" {{ $cloudConfig['s3_use_path_style'] ? 'checked' : '' }} role="switch">
                                                <label class="form-check-label fw-semibold text-dark fs-13" for="backup_cloud_s3_use_path_style">
                                                    Gunakan Path-Style Endpoint (Diperlukan untuk MinIO / Custom S3)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel Konfigurasi Google Drive -->
                                <div id="panel-config-gdrive" class="border rounded p-3 bg-light mb-3" style="{{ $cloudConfig['driver'] === 'gdrive' ? '' : 'display: none;' }}">
                                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                        <i class="ti ti-brand-google-drive text-info fs-18"></i>
                                        <span>Kredensial Google Drive API</span>
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_gdrive_folder_id">
                                                Google Drive Target Folder ID <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="backup_cloud_gdrive_folder_id" id="backup_cloud_gdrive_folder_id" value="{{ $cloudConfig['gdrive_folder_id'] }}" placeholder="e.g. 1BxiMVs0XRA5nFMdKvBHK9... (ID folder dari URL Google Drive)">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold text-dark fs-13" for="backup_cloud_gdrive_service_account">
                                                Google Service Account JSON Key <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control font-monospace fs-12" name="backup_cloud_gdrive_service_account" id="backup_cloud_gdrive_service_account" rows="4" placeholder='Tempelkan isi berkas service_account.json di sini ({"type": "service_account", "project_id": ...})'></textarea>
                                            <span class="fs-12 text-muted">Pastikan Google Service Account email telah diberikan akses Edit/Viewer ke Folder target Google Drive.</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alert Hasil Uji Koneksi -->
                                <div id="cloud-test-result-alert" class="alert d-none align-items-center gap-2 mb-0 py-2.5 px-3 fs-13" role="alert">
                                    <i class="ti fs-18 flex-shrink-0" id="cloud-test-icon"></i>
                                    <div id="cloud-test-message"></div>
                                </div>
                            </div>

                            <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-2">
                                <button type="button" class="btn btn-outline-info px-3 fw-semibold flex-shrink-0" id="btn-test-cloud-conn">
                                    <i class="ti ti-plug-connected me-1"></i>
                                    <span id="btn-test-cloud-text">Uji Koneksi Cloud Storage</span>
                                    <span class="spinner-border spinner-border-sm d-none ms-1" id="btn-test-cloud-spinner"></span>
                                </button>

                                @can('update dukunganaplikasi/backup-db')
                                    <button type="submit" class="btn btn-primary px-4 fw-semibold flex-shrink-0">
                                        <i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Cloud
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Info Panduan Cloud Sync -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-1.5">
                                <i class="ti ti-shield-lock text-primary fs-18"></i>
                                <span>Keamanan & Disaster Recovery</span>
                            </h6>
                        </div>
                        <div class="card-body p-3 fs-13 text-muted">
                            <ul class="ps-3 mb-0">
                                <li class="mb-2"><strong>Otomatisasi Penuh:</strong> Setiap kali backup otomatis terjadwal dijalankan, berkas dump secara mulus dikirim ke storage cloud pilihan Anda.</li>
                                <li class="mb-2"><strong>Protokol Terenkripsi:</strong> Pengunggahan berkas menggunakan koneksi HTTPS terenkripsi dengan AWS Signature v4 / OAuth2 Google API.</li>
                                <li class="mb-0"><strong>Multi-Penyedia:</strong> Mendukung Amazon S3, MinIO lokal/on-premise, Wasabi, Cloudflare R2, dan Google Drive.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================================================================
             TAB 4: RIWAYAT BERKAS BACKUP
             =================================================================== -->
        <div class="tab-pane fade" id="tab-history-pane" role="tabpanel" aria-labelledby="tab-history-btn" tabindex="0">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-1 gap-md-2 border-bottom" id="history-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-history text-primary fs-22 fs-md-20 flex-shrink-0"></i>
                        <h5 class="card-title text-dark mb-0 fw-bold">Riwayat Berkas Backup Tersimpan di Storage</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fs-12 font-monospace">{{ count($backupFiles) }} Berkas</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr class="align-middle text-center text-nowrap">
                                    <th style="width: 50px;" class="text-center align-middle text-nowrap">#</th>
                                    <th class="text-center align-middle text-nowrap">Nama Berkas</th>
                                    <th class="text-center align-middle text-nowrap">Format & Kompresi</th>
                                    <th class="text-center align-middle text-nowrap">Ukuran Berkas</th>
                                    <th class="text-center align-middle text-nowrap">Waktu Dibuat</th>
                                    <th class="text-center align-middle text-nowrap" style="width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($backupFiles as $key => $file)
                                    <tr>
                                        <td class="text-center text-muted fs-13">{{ $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-xs bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                                    <i class="ti {{ !empty($file['is_compressed']) ? 'ti-file-zip' : 'ti-file-code' }} fs-16"></i>
                                                </div>
                                                <span class="fw-semibold text-dark fs-13"><code>{{ $file['name'] }}</code></span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($file['is_compressed']))
                                                <span class="badge bg-success-subtle text-success border border-success-subtle fs-11">
                                                    <i class="ti ti-file-zip me-1"></i>GZIP (.sql.gz)
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-11">
                                                    <i class="ti ti-file-code me-1"></i>SQL Dump (.sql)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border fs-12">
                                                {{ $file['size_mb'] > 0 ? $file['size_mb'] . ' MB' : $file['size_kb'] . ' KB' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i>{{ $file['created_at'] }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex align-items-center justify-content-end gap-1.5">
                                                @can('read dukunganaplikasi/backup-db')
                                                    <a href="{{ route('admin.dukunganaplikasi.backup-db.download', $file['name']) }}" class="btn btn-xs btn-outline-primary" title="Unduh Berkas ke Komputer">
                                                        <i class="ti ti-download me-1"></i> Unduh
                                                    </a>
                                                @endcan

                                                @if ($cloudConfig['driver'] !== 'none')
                                                    @can('create dukunganaplikasi/backup-db')
                                                        <form action="{{ route('admin.dukunganaplikasi.backup-db.sync-file', $file['name']) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-xs btn-outline-info" title="Sinkronkan Berkas Ini ke Cloud Storage">
                                                                <i class="ti ti-cloud-upload me-1"></i> Sync
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif

                                                @can('delete dukunganaplikasi/backup-db')
                                                    <form action="{{ route('admin.dukunganaplikasi.backup-db.destroy', $file['name']) }}" method="POST" class="d-inline form-delete-backup">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-outline-danger btn-delete-backup" data-filename="{{ $file['name'] }}" title="Hapus Berkas">
                                                            <i class="ti ti-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted fs-13">
                                            <i class="ti ti-folder-off fs-24 d-block mb-1 text-secondary"></i>
                                            Belum ada berkas backup yang tersimpan di storage server.
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

    <!-- Bridge Config for JS (Rule 15 Compliance) -->
    <script>
        window.BackupDbConfig = {
            routes: {
                testCloud: "{{ route('admin.dukunganaplikasi.backup-db.test-cloud') }}",
            },
            csrfToken: "{{ csrf_token() }}"
        };
    </script>

    <!-- Page JS (Rule 1 & 15 Compliance) -->
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/backup-db.js') }}?v={{ time() }}"></script>
@endsection
