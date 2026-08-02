@extends('layouts.vertical')

@section('title', 'Backup Database')

@section('content')
    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Backup Database', 'subtitle' => 'Dukungan Aplikasi'])

    <!-- Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-13 fw-semibold text-uppercase">Database Aktif</span>
                        <h4 class="mb-0 fw-bold text-dark mt-1">{{ $dbName }}</h4>
                        <span class="fs-12 text-primary fw-medium"><i class="ti ti-table me-1"></i>{{ $totalTables }} Tabel Terdaftar</span>
                    </div>
                    <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-database fs-26"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-13 fw-semibold text-uppercase">Total Ukuran Data</span>
                        <h4 class="mb-0 fw-bold text-dark mt-1">{{ $totalSizeMb }} MB</h4>
                        <span class="fs-12 text-success fw-medium"><i class="ti ti-chart-pie me-1"></i>Kapasitas Terpakai</span>
                    </div>
                    <div class="avatar-md bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-server fs-26"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between p-3">
                    <div>
                        <span class="text-muted fs-13 fw-semibold text-uppercase">Riwayat Berkas Backup</span>
                        <h4 class="mb-0 fw-bold text-dark mt-1">{{ count($backupFiles) }} File</h4>
                        <span class="fs-12 text-info fw-medium"><i class="ti ti-file-text me-1"></i>Tersimpan di Storage</span>
                    </div>
                    <div class="avatar-md bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ti ti-files fs-26"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Backup Form Card -->
    <div class="row">
        <div class="col-12 mb-4">
            <form action="{{ route('admin.dukunganaplikasi.backup-db.process') }}" method="POST" id="form-process-backup">
                @csrf

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-database-export fs-22"></i>
                            <h5 class="card-title text-white mb-0">Konfigurasi Backup Database</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Mode Backup & Opsi Utama -->
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
                                                <span class="fs-12 text-muted">Download ke komputer</span>
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
                                                <span class="fs-12 text-muted">Simpan di server</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox Opsi Tambahan DROP & CREATE DATABASE -->
                        <div class="p-3 bg-light rounded border mb-4">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input switch-large" type="checkbox" name="include_create_db" id="include_create_db" value="1">
                                <label class="form-check-label fw-bold text-dark fs-14 ms-2" for="include_create_db">
                                    Sertakan Perintah DROP & CREATE DATABASE
                                </label>
                                <p class="fs-12 text-muted mb-0 ms-2 mt-1">
                                    Jika diaktifkan, berkas .SQL akan diawali dengan perintah <code>DROP DATABASE IF EXISTS `{{ $dbName }}`; CREATE DATABASE `{{ $dbName }}`; USE `{{ $dbName }}`;</code> untuk kemudahan restore utuh dari nol.
                                </p>
                            </div>
                        </div>

                        <!-- Panel Pemilihan Tabel (Tersembunyi jika Backup Full) -->
                        <div id="panel-selective-tables" style="display: none;">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
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
                                                <td>
                                                    <span class="badge bg-secondary-subtle text-dark fs-12">{{ number_format($t['rows']) }} Baris</span>
                                                </td>
                                                <td>
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

                    <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-between">
                        <span class="text-muted fs-13 d-flex align-items-center gap-2">
                            <i class="ti ti-shield-check text-success fs-18"></i>
                            <span>Proses ekspor menggunakan perintah SQL standar yang kompatibel untuk restore di phpMyAdmin / MySQL CLI.</span>
                        </span>
                        @can('create dukunganaplikasi/backup-db')
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="ti ti-download me-1 fs-18"></i> Proses & Ekspor Backup
                            </button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <!-- Riwayat Berkas Backup -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-history text-primary fs-20"></i>
                        <h5 class="card-title text-dark mb-0 fw-bold">Riwayat Berkas Backup Tersimpan</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fs-12">{{ count($backupFiles) }} Berkas</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr class="align-middle text-center text-nowrap">
                                    <th style="width: 50px;" class="text-center align-middle text-nowrap">#</th>
                                    <th class="text-center align-middle text-nowrap">Nama Berkas .SQL</th>
                                    <th class="text-center align-middle text-nowrap">Ukuran Berkas</th>
                                    <th class="text-center align-middle text-nowrap">Waktu Dibuat</th>
                                    <th class="text-center align-middle text-nowrap" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($backupFiles as $key => $file)
                                    <tr>
                                        <td class="text-center text-muted fs-13">{{ $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-xs bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-file-code fs-16"></i>
                                                </div>
                                                <span class="fw-semibold text-dark fs-13"><code>{{ $file['name'] }}</code></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border fs-12">
                                                {{ $file['size_mb'] > 0 ? $file['size_mb'] . ' MB' : $file['size_kb'] . ' KB' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i>{{ $file['created_at'] }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                @can('read dukunganaplikasi/backup-db')
                                                    <a href="{{ route('admin.dukunganaplikasi.backup-db.download', $file['name']) }}" class="btn btn-xs btn-outline-primary" title="Unduh Berkas">
                                                        <i class="ti ti-download me-1"></i> Unduh
                                                    </a>
                                                @endcan

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
                                        <td colspan="5" class="text-center py-4 text-muted fs-13">
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

    <style>
        .switch-large {
            width: 2.75em !important;
            height: 1.5em !important;
            cursor: pointer;
        }
        .card-option, .card-output {
            transition: all 0.2s ease-in-out;
        }
        .card-option.active, .card-output.active {
            border-color: var(--bs-primary) !important;
            background-color: rgba(var(--bs-primary-rgb), 0.04) !important;
        }
        .hover-border-primary:hover {
            border-color: var(--bs-primary) !important;
        }
    </style>

    {{-- Page JS (Rule 1 Compliance: Place script inside @section('content') before @endsection) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioFull = document.getElementById('type_full');
            const radioSelective = document.getElementById('type_selective');
            const panelSelective = document.getElementById('panel-selective-tables');
            const cardFull = document.getElementById('card-option-full');
            const cardSelective = document.getElementById('card-option-selective');

            const radioDownload = document.getElementById('target_download');
            const radioSave = document.getElementById('target_save');
            const cardDownload = document.getElementById('card-output-download');
            const cardSave = document.getElementById('card-output-save');

            function toggleBackupType() {
                if (radioSelective && radioSelective.checked) {
                    panelSelective.style.display = 'block';
                    cardSelective.classList.add('active');
                    cardFull.classList.remove('active');
                } else {
                    panelSelective.style.display = 'none';
                    cardFull.classList.add('active');
                    cardSelective.classList.remove('active');
                }
            }

            function toggleOutputTarget() {
                if (radioSave && radioSave.checked) {
                    cardSave.classList.add('active');
                    cardDownload.classList.remove('active');
                } else {
                    cardDownload.classList.add('active');
                    cardSave.classList.remove('active');
                }
            }

            if (radioFull && radioSelective) {
                radioFull.addEventListener('change', toggleBackupType);
                radioSelective.addEventListener('change', toggleBackupType);
            }

            if (radioDownload && radioSave) {
                radioDownload.addEventListener('change', toggleOutputTarget);
                radioSave.addEventListener('change', toggleOutputTarget);
            }

            // Interactive Card Clicking
            if (cardFull) cardFull.addEventListener('click', function() { radioFull.checked = true; toggleBackupType(); });
            if (cardSelective) cardSelective.addEventListener('click', function() { radioSelective.checked = true; toggleBackupType(); });
            if (cardDownload) cardDownload.addEventListener('click', function() { radioDownload.checked = true; toggleOutputTarget(); });
            if (cardSave) cardSave.addEventListener('click', function() { radioSave.checked = true; toggleOutputTarget(); });

            // Table Live Search Filtering
            const searchInput = document.getElementById('table-search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('#table-selective-list tbody tr');

                    rows.forEach(row => {
                        const tableName = row.getAttribute('data-table-name') || '';
                        if (tableName.toLowerCase().includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Check All / Uncheck All Tables
            const checkAll = document.getElementById('check-all-tables');
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.checkbox-table-item');
                    checkboxes.forEach(cb => {
                        const row = cb.closest('tr');
                        if (row && row.style.display !== 'none') {
                            cb.checked = this.checked;
                        }
                    });
                });
            }

            // Relational Table Alert Notice when checking a table
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('checkbox-table-item')) {
                    if (e.target.checked) {
                        const parents = JSON.parse(e.target.getAttribute('data-parents') || '[]');
                        const children = JSON.parse(e.target.getAttribute('data-children') || '[]');

                        if (parents.length > 0 || children.length > 0) {
                            const relAlert = document.getElementById('relational-info-alert');
                            const relText = document.getElementById('relational-info-text');
                            
                            let infoMsg = `<strong>Tabel ${e.target.value}</strong> memiliki relasi: `;
                            if (parents.length > 0) {
                                infoMsg += `memerlukan data dari <code>${parents.join(', ')}</code>. `;
                            }
                            if (children.length > 0) {
                                infoMsg += `direferensikan oleh <code>${children.join(', ')}</code>. `;
                            }
                            infoMsg += `Disarankan menyertakan tabel relasi tersebut agar integritas data terjaga.`;

                            if (relAlert && relText) {
                                relText.innerHTML = infoMsg;
                                relAlert.style.display = 'flex';
                            }
                        }
                    }
                }
            });

            // Event Delegation for Delete Backup File Confirmation (Rule 2 Compliance)
            document.addEventListener('submit', function(e) {
                const form = e.target.closest('.form-delete-backup');
                if (form) {
                    e.preventDefault();
                    const btn = form.querySelector('.btn-delete-backup');
                    const fileName = btn ? btn.getAttribute('data-filename') : 'berkas backup';

                    if (window.Swal) {
                        Swal.fire({
                            title: 'Hapus Berkas Backup?',
                            html: `Apakah Anda yakin ingin menghapus berkas <strong>"${fileName}"</strong>?<br>Tindakan ini tidak dapat dibatalkan.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'btn btn-danger me-2',
                                cancelButton: 'btn btn-secondary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection
