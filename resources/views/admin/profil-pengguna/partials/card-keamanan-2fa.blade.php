<!-- Card Keamanan Akun & Two-Factor Authentication (2FA) -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
        <h5 class="card-title text-white mb-0 fw-bold fs-13 d-flex align-items-center gap-1.5">
            <i class="ti ti-shield-lock me-1"></i> Keamanan Akun (2FA TOTP)
        </h5>
        @if ($user->hasEnabledTwoFactor())
            <span class="badge bg-success text-white font-monospace fs-11 px-2 py-1"><i class="ti ti-check me-1"></i>Aktif</span>
        @else
            <span class="badge bg-warning text-dark font-monospace fs-11 px-2 py-1"><i class="ti ti-alert-triangle me-1"></i>Nonaktif</span>
        @endif
    </div>
    <div class="card-body">
        <div class="d-flex align-items-start gap-2.5 mb-3">
            <div class="avatar-sm {{ $user->hasEnabledTwoFactor() ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} d-flex align-items-center justify-content-center rounded-circle flex-shrink-0">
                <i class="ti {{ $user->hasEnabledTwoFactor() ? 'ti-shield-check' : 'ti-shield-lock' }} fs-20"></i>
            </div>
            <div>
                <span class="fs-13 fw-bold text-dark d-block mb-0.5">Two-Factor Authentication</span>
                <p class="fs-12 text-muted mb-0">
                    Melindungi akun Anda dari akses ilegal dengan mewajibkan verifikasi 6 digit dari aplikasi Google Authenticator atau Authy saat masuk.
                </p>
            </div>
        </div>

        @if ($user->hasEnabledTwoFactor())
            <div class="alert alert-success-subtle text-success border border-success-subtle py-2 px-3 rounded-3 fs-12 mb-3 d-flex align-items-center gap-2">
                <i class="ti ti-circle-check-filled fs-16"></i>
                <div>Akun Anda telah diamankan dengan autentikasi dua langkah (2FA).</div>
            </div>

            <div class="d-flex flex-column gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-1" id="btn-view-recovery-codes">
                    <i class="ti ti-key fs-15"></i>
                    <span>Lihat Kode Pemulihan Cadangan</span>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#modal-disable-2fa">
                    <i class="ti ti-shield-off fs-15"></i>
                    <span>Nonaktifkan 2FA</span>
                </button>
            </div>
        @else
            <button type="button" class="btn btn-primary btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-1.5" id="btn-start-setup-2fa">
                <i class="ti ti-shield-plus fs-16"></i>
                <span>Aktifkan 2FA Sekarang</span>
            </button>
        @endif
    </div>
</div>
