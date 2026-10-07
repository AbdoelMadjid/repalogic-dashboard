@extends('layouts.vertical', ['title' => 'Audit Trail & Log Aktivitas'])

@section('content')
    <link href="{{ asset('assets/css/admin/manajemenpengguna/activity_log.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Log Aktivitas (Audit Trail)'])

    <div class="container-fluid mt-2">
        <!-- 1. KARTU STATISTIK AKTIVITAS SISTEM -->
        <div class="row g-2 g-sm-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0 metric-card">
                    <div class="card-body p-2.5 p-sm-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-11 fs-sm-12 fw-medium text-uppercase">Total Riwayat Log</span>
                                <h3 class="fw-bold my-1 text-primary fs-18 fs-sm-22">{{ number_format($totalLogs) }}</h3>
                                <span class="fs-11 fs-sm-12 text-muted d-none d-sm-inline">Seluruh rekaman audit</span>
                            </div>
                            <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="ti ti-history fs-20 fs-sm-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0 metric-card">
                    <div class="card-body p-2.5 p-sm-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-11 fs-sm-12 fw-medium text-uppercase">Log Hari Ini</span>
                                <h3 class="fw-bold my-1 text-success d-flex align-items-center gap-1.5 fs-18 fs-sm-22">
                                    <span class="badge-pulse-dot bg-success"></span>
                                    {{ number_format($todayLogs) }}
                                </h3>
                                <span class="fs-11 fs-sm-12 text-muted d-none d-sm-inline">Aktivitas 24 jam terakhir</span>
                            </div>
                            <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="ti ti-activity fs-20 fs-sm-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0 metric-card">
                    <div class="card-body p-2.5 p-sm-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-11 fs-sm-12 fw-medium text-uppercase">Perubahan Data</span>
                                <h3 class="fw-bold my-1 text-warning fs-18 fs-sm-22">{{ number_format($updateLogs) }}</h3>
                                <span class="fs-11 fs-sm-12 text-muted d-none d-sm-inline">Update record model</span>
                            </div>
                            <div class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="ti ti-edit fs-20 fs-sm-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100 mb-0 metric-card">
                    <div class="card-body p-2.5 p-sm-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted fs-11 fs-sm-12 fw-medium text-uppercase">Penghapusan</span>
                                <h3 class="fw-bold my-1 text-danger fs-18 fs-sm-22">{{ number_format($deleteLogs) }}</h3>
                                <span class="fs-11 fs-sm-12 text-muted d-none d-sm-inline">Delete record model</span>
                            </div>
                            <div class="avatar-md bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="ti ti-trash fs-20 fs-sm-24"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. FILTER & PENCARIAN WIDGET -->
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <form action="{{ route('admin.manajemenpengguna.activity-log.index') }}" method="GET" id="form-filter-activity">
                <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-1 gap-md-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-filter fs-20 text-primary me-0 me-md-1.5"></i>
                        <h5 class="card-title mb-0 fw-semibold">Filter & Pencarian Log Audit</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a href="{{ route('admin.manajemenpengguna.activity-log.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Semua Filter">
                            <i class="ti ti-refresh me-1.5"></i>
                            <span>Reset Filter</span>
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" title="Terapkan Filter">
                            <i class="ti ti-search me-1.5"></i>
                            <span>Terapkan</span>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fs-12 fw-semibold text-muted mb-1">
                                <i class="ti ti-search me-1 text-primary"></i>Kata Kunci Pencarian
                            </label>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari aktivitas, nama, IP..." value="{{ $searchKeyword }}">
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <label class="form-label fs-12 fw-semibold text-muted mb-1">
                                <i class="ti ti-category me-1 text-primary"></i>Modul
                            </label>
                            <select name="log_name" class="form-select form-select-sm">
                                <option value="">Semua Modul</option>
                                @foreach ($modules as $mod)
                                    <option value="{{ $mod }}" {{ $filterLogName === $mod ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $mod)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <label class="form-label fs-12 fw-semibold text-muted mb-1">
                                <i class="ti ti-bolt me-1 text-warning"></i>Tipe Aksi
                            </label>
                            <select name="event" class="form-select form-select-sm">
                                <option value="">Semua Aksi</option>
                                @foreach ($events as $ev)
                                    <option value="{{ $ev }}" {{ $filterEvent === $ev ? 'selected' : '' }}>{{ ucfirst($ev) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <label class="form-label fs-12 fw-semibold text-muted mb-1">
                                <i class="ti ti-user me-1 text-info"></i>Aktor / Pengguna
                            </label>
                            <select name="causer_id" class="form-select form-select-sm">
                                <option value="">Semua Pengguna</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" {{ (string)$filterCauserId === (string)$u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                            <label class="form-label fs-12 fw-semibold text-muted mb-1">
                                <i class="ti ti-calendar me-1 text-success"></i>Rentang Waktu
                            </label>
                            <select name="date_range" class="form-select form-select-sm" id="filter-date-range">
                                <option value="" {{ $filterDateRange === '' ? 'selected' : '' }}>Semua Waktu</option>
                                <option value="today" {{ $filterDateRange === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="7_days" {{ $filterDateRange === '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                                <option value="30_days" {{ $filterDateRange === '30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                                <option value="custom" {{ $filterDateRange === 'custom' ? 'selected' : '' }}>Kustom</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 {{ $filterDateRange === 'custom' ? '' : 'd-none' }}" id="custom-date-container">
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label fs-12 fw-semibold text-muted mb-1">Dari Tanggal</label>
                                    <input type="date" name="date_start" class="form-control form-control-sm" value="{{ $filterDateStart }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fs-12 fw-semibold text-muted mb-1">Sampai Tanggal</label>
                                    <input type="date" name="date_end" class="form-control form-control-sm" value="{{ $filterDateEnd }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 3. TABEL DATA LOG AKTIVITAS -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start gap-1 gap-md-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-list-details fs-20 text-primary me-0 me-md-1.5"></i>
                    <h5 class="card-title mb-0 fw-semibold">Daftar Rekaman Log & Audit Trail</h5>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 ms-2 font-monospace">{{ $logs->total() }} Log</span>
                </div>
                <div class="d-flex align-items-center gap-2 ms-auto flex-shrink-0 text-nowrap">
                    @can('delete manajemenpengguna/activity-log')
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-clear-logs" title="Bersihkan Catatan Log">
                            <i class="ti ti-trash me-0 me-md-1.5"></i>
                            <span class="d-none d-md-inline">Bersihkan Log</span>
                        </button>
                    @endcan
                    <a href="{{ route('admin.manajemenpengguna.activity-log.index') }}" class="btn btn-sm btn-outline-primary" title="Muat Ulang Data">
                        <i class="ti ti-refresh me-0 me-md-1.5"></i>
                        <span class="d-none d-md-inline">Refresh</span>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 w-100" id="table-activity-logs">
                        <thead class="table-light align-middle text-center text-nowrap">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 170px;">Waktu & Tanggal</th>
                                <th style="width: 220px;">Pelaku / Aktor</th>
                                <th style="width: 140px;">Modul</th>
                                <th style="width: 110px;">Aksi</th>
                                <th>Deskripsi Aktivitas</th>
                                <th style="width: 110px;">Perubahan</th>
                                <th style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $index => $log)
                                <tr>
                                    <td class="text-center align-middle font-monospace fs-12">
                                        {{ $logs->firstItem() + $index }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark fs-12">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                                            <span class="text-muted fs-11">{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if ($log->causer)
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $log->causer->avatar_url }}" class="rounded-circle border flex-shrink-0" width="32" height="32" alt="Avatar">
                                                <div class="d-flex flex-column overflow-hidden">
                                                    <span class="fw-semibold text-dark fs-12 text-truncate">{{ $log->causer->name }}</span>
                                                    <span class="text-muted fs-11 text-truncate">{{ $log->causer->email }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('assets/images/users/user-default.jpg') }}" class="rounded-circle border flex-shrink-0" width="32" height="32" alt="Avatar">
                                                <div class="d-flex flex-column overflow-hidden">
                                                    <span class="fw-semibold text-dark fs-12 text-truncate">Sistem / Tamu</span>
                                                    <span class="text-muted fs-11 text-truncate">{{ $log->ip_address ?: '127.0.0.1' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-light text-dark border fs-11">{{ $log->log_name_label }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge {{ $log->event_badge_class }} fs-11 d-inline-flex align-items-center gap-1">
                                            <i class="{{ $log->event_icon }}"></i>{{ ucfirst($log->event) }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="fs-12 text-dark">{{ $log->description ?: '-' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if (!empty($log->properties))
                                            <span class="badge bg-info-subtle text-info border border-info-subtle fs-11">
                                                <i class="ti ti-diff me-1"></i>Ada Diff
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border fs-11">Polos</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-subtle-primary btn-view-detail" data-id="{{ $log->id }}" title="Lihat Detail Diff Perubahan">
                                                <i class="ti ti-eye"></i>
                                            </button>

                                            @can('delete manajemenpengguna/activity-log')
                                                <form action="{{ route('admin.manajemenpengguna.activity-log.destroy', $log->id) }}" method="POST" class="d-inline" data-confirm="Hapus catatan riwayat log ini?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-subtle-danger" title="Hapus Catatan Log">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="ti ti-database-off fs-36 text-secondary d-block mb-2"></i>
                                        <p class="fs-13 mb-0">Belum ada rekaman riwayat log aktivitas yang ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted fs-12">
                            Menampilkan <span class="fw-semibold">{{ $logs->firstItem() ?? 0 }}</span> sampai <span class="fw-semibold">{{ $logs->lastItem() ?? 0 }}</span> dari <span class="fw-semibold">{{ $logs->total() }}</span> total entri
                        </div>
                        <div>
                            {{ $logs->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL AUDIT DIFF (RULE 4: MODAL-XL, NATURAL SCROLLING) -->
    <div class="modal fade" id="modal-detail-log" tabindex="-1" aria-labelledby="modalDetailLogLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalDetailLogLabel">
                        <i class="ti ti-eye fs-20"></i>
                        <span>Detail Riwayat Aktivitas & Perubahan Data (Audit Trail)</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <!-- Ringkasan Info Pelaku & Waktu -->
                    <div class="card border bg-light-subtle rounded-3 mb-3">
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <img src="" id="detail-causer-avatar" class="rounded-circle border" width="44" height="44" alt="Avatar">
                                        <div>
                                            <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Pelaku / Aktor</span>
                                            <span class="fw-bold fs-13 text-dark d-block" id="detail-causer-name">-</span>
                                            <span class="text-muted fs-11" id="detail-causer-email">-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Modul & Aksi</span>
                                    <div class="d-flex align-items-center gap-1.5 mt-1">
                                        <span class="badge bg-secondary-subtle text-secondary border fs-12" id="detail-log-module">-</span>
                                        <span class="badge fs-12" id="detail-event-badge">-</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Waktu Eksekusi</span>
                                    <span class="fw-semibold fs-13 text-dark d-block mt-1" id="detail-created-at">-</span>
                                    <span class="text-muted fs-11" id="detail-time-ago">-</span>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <span class="text-muted fs-11 text-uppercase fw-semibold d-block">Jaringan & Klien</span>
                                    <span class="badge bg-light text-dark border font-monospace fs-11 mt-1 d-inline-block" id="detail-ip-address">-</span>
                                    <span class="text-muted fs-11 d-block text-truncate mt-0.5" id="detail-user-agent" title="">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Lengkap -->
                    <div class="mb-3">
                        <label class="form-label fs-12 fw-bold text-uppercase text-muted mb-1">Deskripsi Lengkap Aktivitas</label>
                        <div class="p-2.5 bg-white border rounded-3 fs-13 fw-medium text-dark" id="detail-description">
                            -
                        </div>
                    </div>

                    <!-- Tabs Pilihan Visual Diff vs Raw JSON (RULE 17 & 18) -->
                    <div class="card border rounded-3 mb-0">
                        <div class="card-header bg-white py-2 px-3 border-bottom">
                            <ul class="nav nav-tabs nav-bordered card-header-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link active" id="tab-visual-diff-btn" data-bs-toggle="tab" data-bs-target="#tab-visual-diff" role="tab" aria-controls="tab-visual-diff" aria-selected="true" title="Tabel Perbandingan Visual">
                                        <i class="ti ti-table-alias me-0 me-md-1.5"></i>
                                        <span class="d-none d-md-inline">Tabel Perbandingan Diff</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link" id="tab-raw-json-btn" data-bs-toggle="tab" data-bs-target="#tab-raw-json" role="tab" aria-controls="tab-raw-json" aria-selected="false" title="Data Mentah JSON">
                                        <i class="ti ti-code me-0 me-md-1.5"></i>
                                        <span class="d-none d-md-inline">Raw JSON Format</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-3">
                            <div class="tab-content">
                                <!-- Tab 1: Visual Diff -->
                                <div class="tab-pane fade show active" id="tab-visual-diff" role="tabpanel" aria-labelledby="tab-visual-diff-btn">
                                    <div id="diff-empty-state" class="text-center py-4 text-muted d-none">
                                        <i class="ti ti-info-circle fs-36 text-secondary d-block mb-2"></i>
                                        <p class="mb-0 fs-13">Tidak ada perubahan payload atribut data yang dicatat untuk aktivitas ini.</p>
                                    </div>
                                    <div class="table-responsive" id="diff-table-container">
                                        <table class="table table-bordered diff-table mb-0">
                                            <thead class="table-light align-middle text-center text-nowrap">
                                                <tr>
                                                    <th style="width: 25%;">Nama Kolom / Bidang</th>
                                                    <th style="width: 37.5%;" class="text-danger">
                                                        <i class="ti ti-history me-1"></i>Nilai Lama (Sebelumnya)
                                                    </th>
                                                    <th style="width: 37.5%;" class="text-success">
                                                        <i class="ti ti-check me-1"></i>Nilai Baru (Sesudahnya)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="diff-table-body">
                                                <!-- Populated via JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tab 2: Raw JSON Viewer -->
                                <div class="tab-pane fade" id="tab-raw-json" role="tabpanel" aria-labelledby="tab-raw-json-btn">
                                    <pre class="json-viewer-container mb-0" id="json-viewer-content"><code>{}</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex flex-column-reverse flex-sm-row justify-content-end gap-2 bg-light py-2.5 px-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1.5"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BERSIHKAN / PURGE LOGS (RULE 20: RESPONSIVE MODAL FOOTER) -->
    @can('delete manajemenpengguna/activity-log')
        <div class="modal fade" id="modal-clear-logs" tabindex="-1" aria-labelledby="modalClearLogsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form action="{{ route('admin.manajemenpengguna.activity-log.clear') }}" method="POST" data-confirm="Apakah Anda yakin ingin membersihkan riwayat log aktivitas sesuai kriteria yang dipilih? Tindakan ini tidak dapat dibatalkan.">
                        @csrf
                        <div class="modal-header bg-danger text-white py-3">
                            <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalClearLogsLabel">
                                <i class="ti ti-trash fs-20"></i>
                                <span>Pembersihan Riwayat Log Aktivitas</span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3 p-md-4">
                            <div class="alert alert-warning d-flex align-items-start gap-2 mb-3">
                                <i class="ti ti-alert-triangle fs-20 flex-shrink-0 mt-0.5"></i>
                                <div class="fs-12">
                                    Pembersihan log berguna untuk menjaga performa dan kapasitas penyimpanan basis data. Data log yang sudah dibersihkan tidak dapat dipulihkan kembali.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold fs-13">Pilih Kriteria Retensi Pembersihan</label>
                                <select name="days" class="form-select" required>
                                    <option value="30">Hapus log yang berusia lebih dari 30 hari</option>
                                    <option value="60">Hapus log yang berusia lebih dari 60 hari</option>
                                    <option value="90">Hapus log yang berusia lebih dari 90 hari</option>
                                    <option value="180">Hapus log yang berusia lebih dari 6 bulan (180 hari)</option>
                                    <option value="0" class="text-danger fw-bold">Hapus SEMUA riwayat log (Kosongkan Database Log)</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex flex-column-reverse flex-sm-row justify-content-end gap-2 bg-light py-2.5 px-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ti ti-x me-1.5"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-trash me-1.5"></i>Bersihkan Log Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    <!-- DYNAMIC BACKEND DATA BRIDGE (RULE 15) -->
    <script>
        window.ActivityLogConfig = {
            routes: {
                showDetail: "{{ url('admin/manajemenpengguna/activity-log') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/activity_log.js') }}"></script>
@endsection
