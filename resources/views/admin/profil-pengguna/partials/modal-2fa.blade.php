<!-- MODAL 1: SETUP AKTIVASI TWO-FACTOR AUTHENTICATION (2FA) -->
<div class="modal fade" id="modal-setup-2fa" tabindex="-1" aria-labelledby="modalSetup2faLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalSetup2faLabel">
                    <i class="ti ti-shield-lock fs-20"></i>
                    <span>Aktivasi Two-Factor Authentication (2FA)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="btn-close-setup-2fa"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <!-- Step 1 & 2: QR Code & Verification Input -->
                <div id="setup-2fa-step-verify">
                    <div class="text-center mb-3">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fs-12 mb-2">Langkah 1 dari 2</span>
                        <h6 class="fw-bold text-dark fs-14 mb-1">Pindai QR Code Menggunakan Ponsel Anda</h6>
                        <p class="text-muted fs-12 mb-0">
                            Buka aplikasi <strong>Google Authenticator</strong> atau <strong>Authy</strong> di HP Anda, pilih <em>Scan a QR Code</em> atau masukkan kunci manual di bawah ini.
                        </p>
                    </div>

                    <!-- Offline SVG QR Code Container -->
                    <div class="text-center mb-3">
                        <div class="qr-code-box mx-auto" id="setup-2fa-qr-container">
                            <div class="spinner-border text-primary my-4" role="status">
                                <span class="visually-hidden">Membuat QR Code...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Manual Setup Key -->
                    <div class="mb-3">
                        <label class="form-label fs-12 fw-semibold text-muted mb-1">Kunci Rahasia Manual (*Setup Key*):</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control font-monospace fw-bold text-dark bg-light" id="setup-2fa-secret-key" readonly value="...">
                            <button type="button" class="btn btn-outline-secondary" id="btn-copy-secret-key" title="Salin Kunci">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>

                    <hr class="my-3 text-muted opacity-25">

                    <!-- Step 2: Confirmation Code -->
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-bold text-dark mb-1">Langkah 2: Masukkan 6-Digit Kode Verifikasi</label>
                        <input type="text" class="form-control form-control-lg text-center font-monospace fw-bold fs-20" id="setup-2fa-confirm-code" placeholder="000000" maxlength="6" inputmode="numeric" autocomplete="one-time-code">
                        <span class="fs-11 text-muted mt-1 d-block">Masukkan 6 digit angka yang muncul pada aplikasi Authenticator Anda.</span>
                    </div>

                    <div id="setup-2fa-error-alert" class="alert alert-danger border-0 py-2 px-3 fs-12 d-none mb-0"></div>
                </div>

                <!-- Step 3: Success & Recovery Codes -->
                <div id="setup-2fa-step-recovery" class="d-none">
                    <div class="text-center mb-3">
                        <div class="avatar-md bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2">
                            <i class="ti ti-check fs-24"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">2FA Berhasil Diaktifkan!</h5>
                        <p class="text-muted fs-12 mb-0">
                            Simpan kode pemulihan darurat ini di tempat yang aman. Kode ini berguna untuk masuk ke akun jika Anda kehilangan akses ke ponsel/aplikasi authenticator.
                        </p>
                    </div>

                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fs-12 fw-bold text-dark text-uppercase"><i class="ti ti-key me-1"></i>8 Kode Pemulihan Cadangan:</span>
                            <span class="badge bg-warning-subtle text-warning fs-11">Satu Kali Pakai</span>
                        </div>
                        <div class="recovery-code-grid" id="setup-2fa-recovery-codes-list">
                            <!-- Populated via JS -->
                        </div>
                    </div>

                    <div class="d-flex gap-2 mb-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary w-50" id="btn-copy-recovery-codes">
                            <i class="ti ti-copy me-1"></i> Salin Semua Kode
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary w-50" id="btn-download-recovery-codes">
                            <i class="ti ti-download me-1"></i> Unduh File .txt
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2.5 px-3 d-flex justify-content-between" id="setup-2fa-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" id="btn-cancel-setup-2fa">
                    <i class="ti ti-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-sm btn-primary px-4 fw-semibold" id="btn-submit-confirm-2fa">
                    <i class="ti ti-check me-1.5"></i> Konfirmasi & Aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-success px-4 fw-semibold d-none" id="btn-done-setup-2fa" data-bs-dismiss="modal">
                    <i class="ti ti-check me-1.5"></i> Selesai
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: NONAKTIFKAN 2FA -->
<div class="modal fade" id="modal-disable-2fa" tabindex="-1" aria-labelledby="modalDisable2faLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalDisable2faLabel">
                    <i class="ti ti-shield-off fs-20"></i>
                    <span>Nonaktifkan Two-Factor Authentication</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="alert alert-warning border-0 py-2.5 px-3 fs-12 mb-3 d-flex align-items-start gap-2">
                    <i class="ti ti-alert-triangle fs-18 flex-shrink-0 mt-0.5"></i>
                    <div>
                        Menonaktifkan 2FA akan menurunkan tingkat keamanan akun Anda. Anda hanya akan memerlukan alamat email dan kata sandi saat masuk ke sistem.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold text-dark">Masukkan Kata Sandi Saat Ini</label>
                    <input type="password" class="form-control" id="disable-2fa-password" placeholder="Kata sandi akun Anda" autocomplete="current-password">
                </div>

                <div id="disable-2fa-error-alert" class="alert alert-danger border-0 py-2 px-3 fs-12 d-none mb-0"></div>
            </div>
            <div class="modal-footer bg-light py-2.5 px-3 d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-sm btn-danger px-4 fw-semibold" id="btn-submit-disable-2fa">
                    <i class="ti ti-shield-off me-1.5"></i> Nonaktifkan 2FA
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 3: LIHAT / BUAT ULANG KODE PEMULIHAN CADANGAN 2FA -->
<div class="modal fade" id="modal-recovery-codes-2fa" tabindex="-1" aria-labelledby="modalRecoveryCodes2faLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalRecoveryCodes2faLabel">
                    <i class="ti ti-key fs-20"></i>
                    <span>Kode Pemulihan Cadangan 2FA</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <p class="fs-12 text-muted mb-3">
                    Berikut adalah daftar kode pemulihan cadangan darurat Anda. Setiap kode hanya dapat digunakan <strong>1 kali</strong> saat Anda tidak dapat mengakses aplikasi authenticator.
                </p>

                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="recovery-code-grid" id="active-recovery-codes-list">
                        <div class="text-center py-3 text-muted w-100">Memuat kode pemulihan...</div>
                    </div>
                </div>

                <div class="d-flex gap-2 mb-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary w-50" id="btn-copy-existing-recovery">
                        <i class="ti ti-copy me-1"></i> Salin Semua
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary w-50" id="btn-download-existing-recovery">
                        <i class="ti ti-download me-1"></i> Unduh File .txt
                    </button>
                </div>

                <hr class="my-3 text-muted opacity-25">

                <!-- Section Regenerate -->
                <div>
                    <h6 class="fw-bold text-dark fs-13 mb-1">Buat Ulang Kode Baru (Regenerate)</h6>
                    <p class="fs-11 text-muted mb-2">Membuat kode pemulihan baru akan membatalkan seluruh kode lama yang tersimpan.</p>
                    <div class="input-group input-group-sm mb-2">
                        <input type="password" class="form-control" id="regenerate-2fa-password" placeholder="Masukkan kata sandi akun">
                        <button type="button" class="btn btn-warning fw-semibold" id="btn-submit-regenerate-2fa">
                            <i class="ti ti-refresh me-1"></i> Buat Ulang
                        </button>
                    </div>
                    <div id="regenerate-2fa-error-alert" class="alert alert-danger border-0 py-2 px-3 fs-11 d-none mb-0"></div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2.5 px-3 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
