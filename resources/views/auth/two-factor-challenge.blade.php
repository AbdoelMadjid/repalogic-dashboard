@php
    $appProfil = \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::getSettings();
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Verifikasi Dua Langkah (2FA) | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Verifikasi Two-Factor Authentication akun Anda." />

    <!-- App favicon -->
    @if (isset($appProfil) && !empty($appProfil->favicon) && Storage::disk('public')->exists($appProfil->favicon))
        <link rel="shortcut icon" href="{{ asset('storage/' . $appProfil->favicon) }}" />
    @else
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    @endif

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom Auth & Form Input Styling -->
    <link href="{{ asset('assets/css/custom-auth.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .otp-input {
            letter-spacing: 0.45em;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            height: 56px;
            border-radius: 0.65rem;
            transition: all 0.2s ease-in-out;
        }
        .otp-input:focus {
            border-color: #3e60d5;
            box-shadow: 0 0 0 0.25rem rgba(62, 96, 213, 0.15);
        }
        .otp-input::placeholder {
            color: #cbd5e1;
            letter-spacing: 0.45em;
        }
    </style>
</head>

<body>
    <div class="auth-box overflow-hidden align-items-center d-flex min-vh-100 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-md-6 col-sm-8">
                    <div class="auth-brand text-center mb-3">
                        <a href="/" class="logo-dark">
                            @if (isset($appProfil) && !empty($appProfil->logo_lg) && Storage::disk('public')->exists($appProfil->logo_lg))
                                <img src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" height="38" style="object-fit: contain; max-height: 48px;" />
                            @else
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" height="38" />
                            @endif
                        </a>
                        <a href="/" class="logo-light">
                            @if (isset($appProfil) && !empty($appProfil->logo_lg) && Storage::disk('public')->exists($appProfil->logo_lg))
                                <img src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" height="38" style="object-fit: contain; max-height: 48px;" />
                            @else
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="38" />
                            @endif
                        </a>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-4">
                        <!-- Elegant User Identity Presentation Header -->
                        <div class="text-center mb-3">
                            <div class="d-inline-block position-relative mb-2">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                    class="rounded-circle shadow-sm"
                                    style="width: 76px; height: 76px; object-fit: cover; object-position: top; border: 3.5px solid #ffffff; box-shadow: 0 8px 24px -4px rgba(62, 96, 213, 0.25) !important;">
                                <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                    style="width: 26px; height: 26px; border: 2.5px solid #ffffff;" title="2FA Protected">
                                    <i class="ti ti-shield-check fs-14"></i>
                                </span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1 fs-17">{{ $user->name }}</h5>
                            <p class="text-muted fs-13 mb-0 d-inline-flex align-items-center justify-content-center">
                                <i class="ti ti-mail me-1.5 text-secondary"></i>{{ $user->email }}
                            </p>
                        </div>

                        <!-- 2FA Instruction Banner -->
                        <div class="p-3 bg-light rounded-3 border text-center mb-3">
                            <div class="d-inline-flex align-items-center gap-1.5 text-primary fw-semibold fs-13 mb-1">
                                <i class="ti ti-shield-lock fs-16"></i>
                                <span>Verifikasi Dua Langkah (2FA)</span>
                            </div>
                            <p class="text-muted fs-12 mb-0" id="challenge-subtitle">
                                Buka aplikasi <strong>Google Authenticator</strong> / <strong>Authy</strong> di ponsel Anda, lalu masukkan 6-digit kode verifikasi.
                            </p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-2 mb-3 py-2.5 px-3 rounded-3" role="alert">
                                <i class="ti ti-alert-circle fs-18 text-danger flex-shrink-0 mt-0.5"></i>
                                <div class="fs-12">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('two-factor.challenge') }}" id="form-two-factor">
                            @csrf

                            <!-- Form 1: TOTP 6-Digit Code Mode -->
                            <div id="section-totp-code">
                                <div class="mb-3">
                                    <label class="form-label fs-13 fw-semibold text-center d-block">Kode Autentikasi 6-Digit</label>
                                    <input type="text" name="code" id="input-totp-code" class="form-control form-control-lg otp-input" maxlength="6" inputmode="numeric" autocomplete="one-time-code" placeholder="000000" autofocus>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold d-flex align-items-center justify-content-center gap-1.5">
                                        <i class="ti ti-lock-check fs-18"></i>
                                        <span>Verifikasi & Masuk</span>
                                    </button>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-link btn-sm text-decoration-none text-muted" id="btn-switch-to-recovery">
                                        <i class="ti ti-key me-1"></i>Gunakan Kode Pemulihan Cadangan
                                    </button>
                                </div>
                            </div>

                            <!-- Form 2: Recovery Code Mode -->
                            <div id="section-recovery-code" class="d-none">
                                <div class="mb-3">
                                    <label class="form-label fs-13 fw-semibold">Kode Pemulihan Cadangan</label>
                                    <input type="text" name="recovery_code" id="input-recovery-code" class="form-control form-control-lg font-monospace fs-13" placeholder="Contoh: a1b2c3d4e5-f6g7h8i9j0" autocomplete="off" disabled>
                                    <span class="fs-11 text-muted mt-1 d-block">Gunakan salah satu dari 8 kode pemulihan darurat yang Anda simpan saat aktivasi 2FA.</span>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold d-flex align-items-center justify-content-center gap-1.5">
                                        <i class="ti ti-key fs-18"></i>
                                        <span>Verifikasi Kode Pemulihan</span>
                                    </button>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-link btn-sm text-decoration-none text-muted" id="btn-switch-to-totp">
                                        <i class="ti ti-device-mobile me-1"></i>Gunakan Kode Aplikasi Authenticator
                                    </button>
                                </div>
                            </div>
                        </form>

                        <hr class="my-3 text-muted opacity-25">

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-muted fs-12 text-decoration-none">
                                <i class="ti ti-arrow-left me-1"></i>Batal & Kembali ke Halaman Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sectionTotp = document.getElementById('section-totp-code');
            const sectionRecovery = document.getElementById('section-recovery-code');
            const inputTotp = document.getElementById('input-totp-code');
            const inputRecovery = document.getElementById('input-recovery-code');
            const subtitle = document.getElementById('challenge-subtitle');

            const btnSwitchToRecovery = document.getElementById('btn-switch-to-recovery');
            const btnSwitchToTotp = document.getElementById('btn-switch-to-totp');

            if (btnSwitchToRecovery) {
                btnSwitchToRecovery.addEventListener('click', function() {
                    sectionTotp.classList.add('d-none');
                    sectionRecovery.classList.remove('d-none');
                    inputTotp.disabled = true;
                    inputRecovery.disabled = false;
                    subtitle.innerText = 'Masukkan salah satu kode pemulihan cadangan darurat Anda untuk masuk.';
                    inputRecovery.focus();
                });
            }

            if (btnSwitchToTotp) {
                btnSwitchToTotp.addEventListener('click', function() {
                    sectionRecovery.classList.add('d-none');
                    sectionTotp.classList.remove('d-none');
                    inputRecovery.disabled = true;
                    inputTotp.disabled = false;
                    subtitle.innerHTML = 'Buka aplikasi <strong>Google Authenticator</strong> atau <strong>Authy</strong> di ponsel Anda, lalu masukkan 6-digit kode verifikasi.';
                    inputTotp.focus();
                });
            }

            // Auto-submit when 6 digits are typed
            if (inputTotp) {
                inputTotp.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length === 6) {
                        document.getElementById('form-two-factor').submit();
                    }
                });
            }

            // Prevent Stale Session/Token from BFCACHE
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>
