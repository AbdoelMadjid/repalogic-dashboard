<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Konfirmasi Kata Sandi | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description"
        content="{{ $appProfil->meta_description ?? 'Inspinia Admin Dashboard & Management System' }}" />
    <meta name="keywords"
        content="{{ $appProfil->meta_keywords ?? 'admin, dashboard, repalogic, php, laravel' }}" />
    <meta name="author" content="{{ $appProfil->meta_author ?? 'WebAppLayers' }}" />

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
</head>

<body>
    <div class="auth-box overflow-hidden align-items-center d-flex">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-md-6 col-sm-8">
                    <div class="auth-brand text-center mb-4">
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
                        <h4 class="fw-bold mt-3">Area Aman</h4>
                        <p class="text-muted w-lg-75 mx-auto">Ini adalah area aman aplikasi. Harap konfirmasikan kata sandi Anda sebelum melanjutkan.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm" novalidate>
                            @csrf

                            <!-- Password Input Field -->
                            <div class="mb-3">
                                <label for="userPassword" class="form-label fw-semibold">
                                    Kata Sandi <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-lock fs-16 text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                        id="userPassword" placeholder="Masukkan kata sandi Anda" name="password"
                                        required autocomplete="current-password" autofocus />
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" id="btnTogglePassword"
                                        title="Lihat / Sembunyikan Kata Sandi" tabindex="-1">
                                        <i class="ti ti-eye fs-16" id="passwordEyeIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordFeedback" class="invalid-feedback-custom text-danger mt-2 @error('password') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="passwordFeedbackText">{{ $errors->first('password') }}</span>
                                </div>
                            </div>

                            <div class="d-grid mb-2">
                                <button type="submit" class="btn btn-primary fw-semibold py-2 d-inline-flex align-items-center justify-content-center" id="btnSubmitConfirm">
                                    <i class="ti ti-check me-1.5" id="btnSubmitConfirmIcon"></i>
                                    <span id="btnSubmitConfirmText">Konfirmasi Kata Sandi</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <p class="text-center text-muted mt-4 mb-0">
                        © {{ $appProfil->created_year ?? date('Y') }}
                        {{ $appProfil->footer_text ?? 'Inspinia By' }}
                        @if(!empty($appProfil->developer_url))
                            <a href="{{ $appProfil->developer_url }}" target="_blank" class="fw-semibold text-reset">{{ $appProfil->developer_name ?? 'WebAppLayers' }}</a>
                        @else
                            <span class="fw-semibold">{{ $appProfil->developer_name ?? 'WebAppLayers' }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('confirmPasswordForm');
        const passwordInput = document.getElementById('userPassword');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const passwordFeedbackText = document.getElementById('passwordFeedbackText');
        const btnTogglePassword = document.getElementById('btnTogglePassword');
        const passwordEyeIcon = document.getElementById('passwordEyeIcon');

        if (btnTogglePassword && passwordInput && passwordEyeIcon) {
            btnTogglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordEyeIcon.classList.toggle('ti-eye', !isPassword);
                passwordEyeIcon.classList.toggle('ti-eye-off', isPassword);
            });
        }

        form.addEventListener('submit', function (e) {
            const val = passwordInput.value.trim();
            if (!val) {
                e.preventDefault();
                passwordInput.classList.add('is-invalid');
                passwordFeedbackText.textContent = 'Kata sandi wajib diisi.';
                passwordFeedback.classList.remove('d-none');
                passwordFeedback.classList.add('d-flex');
                passwordInput.focus();
                return false;
            }

            const btnSubmit = document.getElementById('btnSubmitConfirm');
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span> Mengonfirmasi...';
            }
        });
    });
    </script>
</body>

</html>
