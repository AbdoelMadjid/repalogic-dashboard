<!-- MODAL IMPORT / UPLOAD USERS EXCEL -->
<div class="modal fade" id="modal-import-users" tabindex="-1" aria-labelledby="modalImportUsersTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white mb-0" id="modalImportUsersTitle">
                    <i class="ti ti-file-upload me-1.5"></i> Upload Data Pengguna (Excel)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="btn-close-import-modal"></button>
            </div>
            <form id="form-import-users" action="{{ route('admin.manajemenpengguna.users.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <!-- Format Excel Quick Download Alert -->
                    <div class="alert alert-info border-info-subtle bg-info-subtle d-flex flex-column flex-sm-row align-items-sm-center justify-content-between p-3 mb-3 gap-2">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-info-circle fs-22 me-2 text-info flex-shrink-0"></i>
                            <div class="fs-12 text-dark">
                                <strong class="d-block text-info-emphasis">Gunakan Format Excel Standar</strong>
                                Unduh template minimal untuk memastikan struktur kolom sesuai sistem.
                            </div>
                        </div>
                        <a href="{{ route('admin.manajemenpengguna.users.template-excel') }}" class="btn btn-sm btn-info text-white text-nowrap flex-shrink-0" title="Unduh Format Template Excel Minimal">
                            <i class="ti ti-file-download me-1"></i> Download Format Excel
                        </a>
                    </div>

                    <!-- File Input -->
                    <div class="mb-3">
                        <label for="excel_file" class="form-label fw-semibold text-dark">
                            Pilih Berkas Excel / CSV <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text fs-12 text-muted">
                            Maksimal ukuran berkas <strong>5 MB</strong>. Format yang didukung: <code>.xlsx</code>, <code>.xls</code>, <code>.csv</code>.
                        </div>
                    </div>

                    <!-- Duplicate Action Options -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark mb-2">Penanganan Email Duplikat (Sudah Ada di Database):</label>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="form-check p-3 border rounded-3 bg-light-subtle h-100 cursor-pointer">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="duplicate_action" id="dup_action_skip" value="skip" checked>
                                    <label class="form-check-label fw-semibold text-dark cursor-pointer d-block" for="dup_action_skip">
                                        <i class="ti ti-player-skip-forward me-1 text-warning"></i> Lewati (Skip)
                                        <span class="d-block text-muted fw-normal fs-12 mt-1">
                                            Abaikan baris dan jangan ubah data jika alamat email sudah terdaftar.
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-check p-3 border rounded-3 bg-light-subtle h-100 cursor-pointer">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="duplicate_action" id="dup_action_update" value="update">
                                    <label class="form-check-label fw-semibold text-dark cursor-pointer d-block" for="dup_action_update">
                                        <i class="ti ti-refresh me-1 text-primary"></i> Perbarui (Update)
                                        <span class="d-block text-muted fw-normal fs-12 mt-1">
                                            Perbarui nama, status, role, dan password (jika diisi) untuk email yang cocok.
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar Container (Active during upload/import) -->
                    <div id="import-progress-wrapper" class="mb-3 p-3 bg-light rounded-3 border" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-13 fw-semibold text-dark d-flex align-items-center" id="import-progress-status">
                                <span class="spinner-border spinner-border-sm text-primary me-2" role="status" id="import-progress-spinner"></span>
                                <span id="import-progress-status-text">Mengunggah berkas...</span>
                            </span>
                            <span class="fs-13 fw-bold text-primary" id="import-progress-percentage">0%</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px; background-color: #e2e8f0;">
                            <div id="import-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%; transition: width 0.3s ease;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="fs-12 text-muted mt-2 d-flex align-items-center justify-content-between">
                            <span id="import-progress-detail">Mohon tunggu, berkas sedang dikirim ke server...</span>
                            <span id="import-file-size-info" class="font-monospace text-secondary"></span>
                        </div>
                    </div>

                    <!-- Column Structure Guide -->
                    <div class="p-3 bg-light rounded-3 border fs-12 text-secondary">
                        <h6 class="fs-13 fw-semibold text-dark mb-2">
                            <i class="ti ti-help-circle me-1 text-primary"></i> Panduan Kolom Excel Minimal:
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li class="mb-1"><strong>Kolom A (Nama Lengkap)</strong>: Wajib diisi (contoh: <code>Ahmad Fadillah</code>).</li>
                            <li class="mb-1"><strong>Kolom B (Email)</strong>: Wajib diisi dengan format email valid (contoh: <code>ahmad.fadillah@example.com</code>).</li>
                            <li class="mb-1"><strong>Kolom C (Password)</strong>: Opsional. Jika kosong, default kata sandi otomatis <code>password*</code>.</li>
                            <li class="mb-1"><strong>Kolom D (Role)</strong>: Opsional. Default jika kosong adalah <code>user</code>. Role terdaftar: <code>{{ $roles->pluck('name')->implode(', ') }}</code>.</li>
                            <li><strong>Kolom E (Status)</strong>: Opsional. Pilihan: <code>active</code>, <code>pending</code>, <code>inactive</code>. Default jika kosong adalah <code>active</code>.</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer bg-light py-3 d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" id="btn-cancel-import">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold" id="btnSubmitImport">
                        <i class="ti ti-upload me-1.5"></i> Mulai Unggah & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
