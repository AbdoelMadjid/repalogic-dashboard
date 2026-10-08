<!-- Card Informasi Akun -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-user-circle me-1"></i> Informasi Akun</h5>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar-sm bg-primary-subtle text-primary d-flex align-items-center justify-content-center rounded">
                <i class="ti ti-user fs-18"></i>
            </div>
            <div>
                <span class="fs-12 text-muted d-block">Nama Lengkap</span>
                <span class="text-dark fw-semibold fs-14">{{ $user->name }}</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar-sm bg-info-subtle text-info d-flex align-items-center justify-content-center rounded">
                <i class="ti ti-mail fs-18"></i>
            </div>
            <div>
                <span class="fs-12 text-muted d-block">Alamat Email</span>
                <a href="mailto:{{ $user->email }}" class="text-primary fw-semibold fs-14">{{ $user->email }}</a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar-sm bg-success-subtle text-success d-flex align-items-center justify-content-center rounded">
                <i class="ti ti-brand-whatsapp fs-18"></i>
            </div>
            <div>
                <span class="fs-12 text-muted d-block">Nomor Telepon / WhatsApp</span>
                @if (!empty($user->detail?->telepon))
                    <a href="{{ $user->detail->telepon_wa_url }}" target="_blank" class="text-success fw-semibold fs-14 text-decoration-none d-inline-flex align-items-center">
                        {{ $user->detail->telepon }} <i class="ti ti-external-link fs-12 ms-1"></i>
                    </a>
                @else
                    <span class="text-muted fst-italic fs-13">Belum diisi</span>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar-sm bg-warning-subtle text-warning d-flex align-items-center justify-content-center rounded">
                <i class="ti ti-shield-lock fs-18"></i>
            </div>
            <div>
                <span class="fs-12 text-muted d-block">Peran & Akumulasi Poin</span>
                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="badge bg-primary-subtle text-primary fs-12 fw-semibold px-2 py-1">{{ $user->role_name }}</span>
                    <span class="badge bg-warning-subtle text-warning fs-12 fw-semibold px-2 py-1" title="Total Poin Login (Maks 1 Poin per 24 Jam)">
                        <i class="ti ti-award me-1"></i> {{ number_format($user->login_count ?? 0) }} Poin
                    </span>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="avatar-sm bg-success-subtle text-success d-flex align-items-center justify-content-center rounded">
                <i class="ti ti-calendar fs-18"></i>
            </div>
            <div>
                <span class="fs-12 text-muted d-block">Tanggal Terdaftar</span>
                <span class="text-dark fw-semibold fs-14">{{ $user->created_at ? $user->created_at->format('d F Y (H:i)') : '-' }}</span>
            </div>
        </div>
    </div>
</div>
