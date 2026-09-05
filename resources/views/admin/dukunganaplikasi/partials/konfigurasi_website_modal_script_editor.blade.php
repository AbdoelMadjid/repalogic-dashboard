<!-- Modal Editor Script Blade Seksi Website -->
<div class="modal fade" id="modal-editor-script-blade" tabindex="-1" aria-labelledby="modalEditorScriptBladeLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                    <div class="avatar-sm bg-white text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm">
                        <i class="ti ti-code fs-18"></i>
                    </div>
                    <div class="ps-1">
                        <h5 class="modal-title text-white fw-bold mb-1" id="modalEditorScriptBladeLabel">
                            Editor Script Blade Seksi: <span id="modal-script-section-name" class="text-warning ms-1"></span>
                        </h5>
                        <div class="d-flex align-items-center gap-2.5 mt-0.5 flex-wrap fs-12">
                            <span class="badge bg-white text-dark font-monospace py-1 px-2.5 border-0 shadow-xs">
                                <i class="ti ti-file-code text-primary me-2"></i><span id="modal-script-file-path">resources/views/website/...</span>
                            </span>
                            <span class="badge bg-success bg-opacity-75 text-white font-monospace py-1 px-2.5" id="modal-script-status-badge">
                                <i class="ti ti-circle-check me-1.5"></i>File Siap Diedit
                            </span>
                            <span class="text-white-50 font-monospace" id="modal-script-modified-time">
                                <i class="ti ti-clock me-1.5"></i>-
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 ms-auto flex-shrink-0">
                    <button type="button" class="btn btn-sm btn-outline-light px-2.5 py-1" id="btn-editor-fullscreen" title="Toggle Layar Penuh">
                        <i class="ti ti-maximize fs-15 me-1.5"></i> <span class="fs-12 d-none d-sm-inline">Layar Penuh</span>
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-3 bg-light">
                <!-- Editor Toolbar -->
                <div class="card border-0 shadow-sm mb-2">
                    <div class="card-body p-2 d-flex flex-wrap align-items-center justify-content-between gap-2 bg-white rounded">
                        <!-- Left Toolbar: Snippet Insert & Tools -->
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <!-- Quick Snippet Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-semibold px-2.5 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-template me-1"></i> Sisipkan Komponen / Snippet
                                </button>
                                <ul class="dropdown-menu shadow-sm fs-13" style="min-width: 260px;">
                                    <li><h6 class="dropdown-header text-uppercase text-muted fs-11 fw-bold">Struktur Seksi Standar (Rule 13)</h6></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="section_wrapper"><i class="ti ti-layout-navbar me-2 text-primary"></i> Wrapper Section Dinamis</a></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="container_row"><i class="ti ti-columns me-2 text-info"></i> Container &amp; Row Bootstrap</a></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="section_header"><i class="ti ti-heading me-2 text-success"></i> Heading Judul &amp; Subtitle</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li><h6 class="dropdown-header text-uppercase text-muted fs-11 fw-bold">Komponen Konten</h6></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="card_grid"><i class="ti ti-cards me-2 text-warning"></i> Grid 3 Card Fitur / Layanan</a></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="cta_button"><i class="ti ti-click me-2 text-danger"></i> Tombol Call To Action (CTA)</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li><h6 class="dropdown-header text-uppercase text-muted fs-11 fw-bold">Tag Blade &amp; Bahasa</h6></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="blade_lang"><i class="ti ti-language me-2 text-secondary"></i> Locale Translate (__('...'))</a></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="blade_if"><i class="ti ti-code-dots me-2 text-dark"></i> Kondisional Blade (&#64;if...&#64;endif)</a></li>
                                    <li><a class="dropdown-item btn-insert-snippet" href="javascript:void(0);" data-snippet="blade_foreach"><i class="ti ti-repeat me-2 text-primary"></i> Perulangan Blade (&#64;foreach)</a></li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 py-1" id="btn-toggle-wrap" title="Toggle Bungkus Baris (Word Wrap)">
                                <i class="ti ti-text-wrap me-1"></i> <span class="fs-12">Word Wrap</span>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 py-1" id="btn-toggle-theme" title="Ubah Tema Editor Gelap / Terang">
                                <i class="ti ti-moon me-1" id="icon-editor-theme"></i> <span class="fs-12" id="label-editor-theme">Dark Mode</span>
                            </button>
                        </div>

                        <!-- Right Toolbar: Formatting & Copy -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-info px-2.5 py-1" id="btn-copy-script-code" title="Salin Seluruh Kode">
                                <i class="ti ti-copy me-1"></i> <span class="fs-12">Salin Kode</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning px-2.5 py-1" id="btn-reset-script-code" title="Kembalikan Kode Asli">
                                <i class="ti ti-reload me-1"></i> <span class="fs-12">Reset</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Editor Frame Container -->
                <div class="card border-0 shadow-sm overflow-hidden" id="blade-editor-card-container">
                    <div class="position-relative">
                        <!-- Loading Indicator Overlay -->
                        <div class="editor-loading-overlay d-flex flex-column align-items-center justify-content-center" id="editor-loading-overlay">
                            <div class="spinner-border text-primary mb-2" role="status"></div>
                            <span class="fs-13 fw-semibold text-muted">Memuat script template Blade...</span>
                        </div>

                        <!-- Ace Code Editor Target -->
                        <div id="blade-script-ace-editor" style="height: 520px; width: 100%; font-size: 14px; line-height: 1.5;"></div>

                        <!-- Raw Textarea Fallback -->
                        <textarea id="blade-script-raw-editor" class="form-control font-monospace d-none" style="height: 520px; font-size: 13px; tab-size: 4; border-radius: 0;" spellcheck="false" placeholder="Tuliskan kode script Blade di sini..."></textarea>
                    </div>

                    <!-- Editor Status Bar -->
                    <div class="card-footer bg-dark text-white-50 px-3 py-2 d-flex flex-wrap align-items-center justify-content-between gap-2 fs-12 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex align-items-center gap-1 font-monospace">
                                <i class="ti ti-cursor-text text-primary"></i> <span id="editor-cursor-pos">Baris 1, Kolom 1</span>
                            </span>
                            <span class="d-flex align-items-center gap-1 font-monospace">
                                <i class="ti ti-file-analytics text-info"></i> <span id="editor-total-lines">0 Baris</span> | <span id="editor-file-size">0 KB</span>
                            </span>
                            <span class="badge bg-secondary font-monospace" id="editor-dirty-indicator">
                                <i class="ti ti-check me-1"></i> Tidak Ada Perubahan
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2 font-monospace fs-11 text-white-50">
                            <span><kbd class="bg-secondary text-white py-0.5 px-1 rounded">Ctrl</kbd> + <kbd class="bg-secondary text-white py-0.5 px-1 rounded">S</kbd> Simpan Cepat</span>
                            <span>|</span>
                            <span><kbd class="bg-secondary text-white py-0.5 px-1 rounded">Ctrl</kbd> + <kbd class="bg-secondary text-white py-0.5 px-1 rounded">F</kbd> Cari Teks</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 fs-12 text-muted">
                    <i class="ti ti-shield-check text-success fs-16"></i>
                    <span>Sistem secara otomatis membuat cadangan (backup) dan membersihkan cache Blade saat disimpan.</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-secondary px-3 fw-semibold" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary px-4 fw-semibold" id="btn-save-blade-script">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Script Blade
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
