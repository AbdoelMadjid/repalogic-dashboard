<!-- Modal Sinkronisasi & Pembersihan Media Storage (Rule 4, 8, 12, 14 Compliance) -->
<div class="modal fade" id="storageSyncModal" tabindex="-1" aria-labelledby="storageSyncModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header (Rule 12 Compliance: bg-primary text-white py-3) -->
            <div class="modal-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-sm bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0">
                        <i class="ti ti-photo-search fs-20"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0" id="storageSyncModalLabel">Sinkronisasi & Pembersihan Media Storage</h5>
                        <small class="text-white text-opacity-75 fs-12">Pemeriksaan dan eliminasi berkas gambar orphan (tidak terhubung dengan database)</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <!-- Loading State Container -->
                <div id="sync-loading-state" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary avatar-md mb-3" role="status">
                        <span class="visually-hidden">Memindai...</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Sedang Memindai Penyimpanan Media...</h5>
                    <p class="text-muted fs-13 mb-0">Mencocokkan seluruh berkas gambar di disk storage dengan entitas database (Pengguna, Profil, Pesan, Seksi Website).</p>
                </div>

                <!-- Main Content Container -->
                <div id="sync-main-container">
                    <!-- KPI SUMMARY CARDS -->
                    <div class="row g-3 mb-4">
                        <!-- KPI 1: Total Gambar Storage -->
                        <div class="col-6 col-md-3">
                            <div class="card bg-light-subtle border shadow-none rounded-3 mb-0 h-100">
                                <div class="card-body p-3 text-center">
                                    <span class="text-muted fs-11 fw-bold text-uppercase d-block mb-1">Total di Storage</span>
                                    <h3 class="fw-bold text-dark mb-0" id="kpi-total-storage">0</h3>
                                    <small class="text-muted fs-11" id="kpi-total-size">0 KB</small>
                                </div>
                            </div>
                        </div>

                        <!-- KPI 2: Gambar Valid Database -->
                        <div class="col-6 col-md-3">
                            <div class="card bg-success-subtle border-success-subtle shadow-none rounded-3 mb-0 h-100">
                                <div class="card-body p-3 text-center">
                                    <span class="text-success fs-11 fw-bold text-uppercase d-block mb-1">Valid di Database</span>
                                    <h3 class="fw-bold text-success mb-0" id="kpi-valid-db">0</h3>
                                    <small class="text-success fs-11"><i class="ti ti-check me-1"></i>Terhubung Aktif</small>
                                </div>
                            </div>
                        </div>

                        <!-- KPI 3: Gambar Orphan / Sampah -->
                        <div class="col-6 col-md-3">
                            <div class="card bg-danger-subtle border-danger-subtle shadow-none rounded-3 mb-0 h-100">
                                <div class="card-body p-3 text-center">
                                    <span class="text-danger fs-11 fw-bold text-uppercase d-block mb-1">Gambar Sampah / Orphan</span>
                                    <h3 class="fw-bold text-danger mb-0" id="kpi-orphan-count">0</h3>
                                    <small class="text-danger fs-11"><i class="ti ti-alert-triangle me-1"></i>Tidak Ada di DB</small>
                                </div>
                            </div>
                        </div>

                        <!-- KPI 4: Ruang yang Dapat Dibersihkan -->
                        <div class="col-6 col-md-3">
                            <div class="card bg-warning-subtle border-warning-subtle shadow-none rounded-3 mb-0 h-100">
                                <div class="card-body p-3 text-center">
                                    <span class="text-warning fs-11 fw-bold text-uppercase d-block mb-1">Ruang Hemat</span>
                                    <h3 class="fw-bold text-warning mb-0" id="kpi-orphan-size">0 KB</h3>
                                    <small class="text-muted fs-11">Potensi Pembersihan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMPTY STATE: All Synchronized -->
                    <div id="sync-empty-state" class="text-center py-5 d-none">
                        <div class="avatar-lg bg-success-subtle text-success rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3">
                            <i class="ti ti-circle-check fs-36"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Semua Media Penyimpanan Telah Sinkron!</h5>
                        <p class="text-muted fs-13 mb-4">
                            Tidak ditemukan gambar orphan di disk storage. Seluruh berkas media yang tersimpan memiliki referensi aktif di database.
                        </p>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-re-scan-empty">
                            <i class="ti ti-refresh me-1.5"></i> Pindai Ulang Sekarang
                        </button>
                    </div>

                    <!-- ORPHAN FILES SECTION -->
                    <div id="sync-table-section">
                        <!-- FILTER CONTROLS & SEARCH BAR (ROW 1) -->
                        <div class="row align-items-center mb-3 g-2">
                            <!-- Folder Filter -->
                            <div class="col-12 col-md-4 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-folder me-1.5 text-primary"></i> Folder:</label>
                                <select id="orphan-folder-select" class="form-select form-select-sm">
                                    <option value="all">-- Semua Folder --</option>
                                </select>
                            </div>

                            <!-- Search Filter -->
                            <div class="col-12 col-md-4">
                                <div class="d-flex align-items-center">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Berkas:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="orphan-search-input" class="form-control" placeholder="Ketik nama atau lokasi berkas...">
                                        <button class="btn btn-outline-secondary" type="button" id="btn-clear-orphan-search" title="Bersihkan Pencarian">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 col-md-4 d-flex justify-content-md-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-dark" id="btn-re-scan" title="Pindai Ulang">
                                    <i class="ti ti-refresh me-1"></i> Pindai Ulang
                                </button>
                                @can('delete dukunganaplikasi/fitur-aplikasi')
                                    <button type="button" class="btn btn-sm btn-danger fw-semibold" id="btn-delete-all-orphans">
                                        <i class="ti ti-trash-x me-1.5"></i> Hapus Semua Sampah
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <!-- BULK ACTION TOOLBAR (ROW 2 - SELECTION & ACTIONS) -->
                        @can('delete dukunganaplikasi/fitur-aplikasi')
                            <div class="p-3 bg-light-subtle rounded-3 mb-3 border d-flex flex-wrap align-items-center justify-content-between gap-3" id="orphan-bulk-bar">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check m-0">
                                        <input class="form-check-input high-contrast-checkbox" type="checkbox" id="check-all-orphans" title="Centang Semua Gambar pada Filter Ini">
                                        <label class="form-check-label fw-semibold fs-13 text-dark user-select-none cursor-pointer" for="check-all-orphans" id="check-all-orphans-label">
                                            Pilih Semua (0 gambar)
                                        </label>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 px-2.5 py-1 ms-2" id="orphan-selected-badge" style="display: none;">
                                        <i class="ti ti-check me-1.5"></i><span id="orphan-selected-count">0</span> terpilih
                                    </span>
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-danger fw-semibold" id="btn-delete-selected-orphans" disabled>
                                        <i class="ti ti-trash me-1.5"></i> Hapus Gambar Terpilih
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-orphan-deselect-all" style="display: none;">
                                        <i class="ti ti-x me-1.5"></i> Batal Pilih
                                    </button>
                                </div>
                            </div>
                        @endcan

                        <!-- ORPHAN FILES TABLE (Rule 8 Compliance: align-middle text-center text-nowrap on thead) -->
                        <div class="table-responsive border rounded-3">
                            <table id="orphan-table" class="table table-hover table-bordered align-middle w-100 mb-0">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr>
                                        <th style="width: 45px;">
                                            <input type="checkbox" class="form-check-input high-contrast-checkbox" id="check-all-orphan-page" title="Pilih Semua di Halaman Ini">
                                        </th>
                                        <th style="width: 50px;">NO</th>
                                        <th style="width: 80px;">GAMBAR</th>
                                        <th>NAMA BERKAS & LOKASI STORAGE</th>
                                        <th style="width: 130px;">FOLDER</th>
                                        <th style="width: 100px;">UKURAN</th>
                                        <th style="width: 150px;">TERAKHIR DIUBAH</th>
                                        <th style="width: 120px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody id="orphan-tbody">
                                    <!-- Rendered dynamically via JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer & Pagination -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="orphan-table-info">
                                Menampilkan data gambar sampah
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <ul class="pagination pagination-sm m-0" id="orphan-pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light py-2.5 px-4 d-flex justify-content-between align-items-center">
                <span class="text-muted fs-12 d-flex align-items-center gap-1.5">
                    <i class="ti ti-info-circle text-info fs-16"></i>
                    <span>Gambar yang dihapus dari disk storage tidak dapat dipulihkan. Pastikan memeriksa pratinjau sebelum menghapus.</span>
                </span>
                <button type="button" class="btn btn-sm btn-secondary fw-semibold px-3" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1.5"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL LIGHTBOX / PRATINJAU GAMBAR FULL RESOLUSI -->
<div class="modal fade" id="storageImagePreviewModal" tabindex="-1" aria-labelledby="storageImagePreviewModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white py-2.5 px-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-photo me-1 text-info fs-18"></i>
                    <h6 class="modal-title text-white fw-bold mb-0" id="storageImagePreviewModalLabel">
                        Pratinjau Media: <span id="preview-filename-badge" class="text-info font-monospace fs-13"></span>
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 bg-dark text-center overflow-hidden">
                <!-- Image Container with Checkerboard / Dark background -->
                <div class="media-preview-box rounded p-2 mb-3 d-flex align-items-center justify-content-center" style="min-height: 280px; max-height: 480px; background-color: #1a1e24;">
                    <img src="" id="storage-preview-img" class="img-fluid rounded shadow-sm" style="max-height: 440px; object-fit: contain;" alt="Pratinjau Media">
                </div>

                <!-- Media Details Card -->
                <div class="bg-secondary bg-opacity-25 rounded p-3 text-start border border-secondary border-opacity-50">
                    <div class="row g-2 fs-12 text-white-50">
                        <div class="col-md-6">
                            <span class="d-block text-white mb-0.5 fw-semibold"><i class="ti ti-file-text me-1 text-info"></i> Nama Berkas:</span>
                            <span id="preview-file-name" class="font-monospace text-white text-break"></span>
                        </div>
                        <div class="col-md-6">
                            <span class="d-block text-white mb-0.5 fw-semibold"><i class="ti ti-folder me-1 text-warning"></i> Direktori / Folder:</span>
                            <span id="preview-file-folder" class="badge bg-light text-dark font-monospace"></span>
                        </div>
                        <div class="col-md-6">
                            <span class="d-block text-white mb-0.5 fw-semibold"><i class="ti ti-database me-1 text-primary"></i> Lokasi Storage:</span>
                            <code id="preview-storage-path" class="text-info text-break fs-11"></code>
                        </div>
                        <div class="col-md-6">
                            <span class="d-block text-white mb-0.5 fw-semibold"><i class="ti ti-weight me-1 text-success"></i> Ukuran & Format:</span>
                            <span id="preview-file-size" class="text-white"></span> (<span id="preview-file-ext" class="fw-bold text-uppercase"></span>)
                        </div>
                        <div class="col-12 pt-1 border-top border-secondary border-opacity-25 mt-1">
                            <span class="d-block text-white mb-0.5 fw-semibold"><i class="ti ti-calendar-time me-1 text-info"></i> Terakhir Diubah:</span>
                            <span id="preview-file-date" class="text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark border-top border-secondary py-2 px-3 d-flex justify-content-between align-items-center">
                <a href="#" id="preview-open-external" target="_blank" class="btn btn-xs btn-outline-light text-white">
                    <i class="ti ti-external-link me-1"></i> Buka di Tab Baru
                </a>
                <button type="button" class="btn btn-sm btn-light text-dark fw-bold px-3" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Tutup Pratinjau
                </button>
            </div>
        </div>
    </div>
</div>
