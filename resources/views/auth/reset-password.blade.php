<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Atur Ulang Kata Sandi | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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
                        <h4 class="fw-bold mt-3">Buat Kata Sandi Baru</h4>
                        <p class="text-muted w-lg-75 mx-auto">Silakan masukkan kata sandi baru Anda untuk memperbarui akses akun.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" novalidate>
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Input Field -->
                            <div class="mb-3">
                                <label for="userEmail" class="form-label fw-semibold">
                                    Alamat Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-mail fs-16 text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        id="userEmail" name="email" value="{{ old('email', $request->email) }}"
                                        placeholder="contoh: nama@domain.com" autocomplete="email" required readonly />
                                </div>
                                <div id="emailFeedback" class="invalid-feedback-custom text-danger mt-2 @error('email') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="emailFeedbackText">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <!-- Password Baru -->
                            <div class="mb-3">
                                <label for="userPassword" class="form-label fw-semibold">
                                    Kata Sandi Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-lock fs-16 text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                        id="userPassword" name="password" placeholder="Masukkan kata sandi baru" required autocomplete="new-password" />
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

                            <!-- Konfirmasi Password Baru -->
                            <div class="mb-3">
                                <label for="userPasswordConfirmation" class="form-label fw-semibold">
                                    Konfirmasi Kata Sandi Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-lock-check fs-16 text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 @error('password_confirmation') is-invalid @enderror"
                                        id="userPasswordConfirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru" required autocomplete="new-password" />
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" id="btnTogglePasswordConfirm"
                                        title="Lihat / Sembunyikan Konfirmasi Kata Sandi" tabindex="-1">
                                        <i class="ti ti-eye fs-16" id="passwordConfirmEyeIcon"></i>
                                    </button>
                                </div>
                                <div id="confirmFeedback" class="invalid-feedback-custom text-danger mt-2 @error('password_confirmation') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="confirmFeedbackText">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary fw-semibold py-2 d-inline-flex align-items-center justify-content-center" id="btnSubmitReset">
                                    <i class="ti ti-key me-1.5" id="btnSubmitResetIcon"></i>
                                    <span id="btnSubmitResetText">Perbarui Kata Sandi</span>
                                </button>
                            </div>
                        </form>

                        <p class="text-muted text-center mb-0">
                            Sudah ingat kata sandi Anda?
                            <a href="{{ route('login') }}"
                                class="text-decoration-underline link-offset-3 fw-semibold">Kembali ke Login</a>
                        </p>
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
        const form = document.getElementById('resetPasswordForm');
        const passwordInput = document.getElementById('userPassword');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const passwordFeedbackText = document.getElementById('passwordFeedbackText');

        const confirmInput = document.getElementById('userPasswordConfirmation');
        const confirmFeedback = document.getElementById('confirmFeedback');
        const confirmFeedbackText = document.getElementById('confirmFeedbackText');

        const btnTogglePassword = document.getElementById('btnTogglePassword');
        const passwordEyeIcon = document.getElementById('passwordEyeIcon');
        const btnTogglePasswordConfirm = document.getElementById('btnTogglePasswordConfirm');
        const passwordConfirmEyeIcon = document.getElementById('passwordConfirmEyeIcon');

        let isFormSubmitted = false;

        function showFeedback(inputEl, containerEl, textEl, msg) {
            textEl.textContent = msg;
            if (inputEl) inputEl.classList.add('is-invalid');
            containerEl.classList.remove('d-none');
            containerEl.classList.add('d-flex');
        }

        function hideFeedback(inputEl, containerEl) {
            if (inputEl) inputEl.classList.remove('is-invalid');
            containerEl.classList.add('d-none');
            containerEl.classList.remove('d-flex');
        }

        function validatePassword(forceValidation) {
            const val = passwordInput.value;
            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(passwordInput, passwordFeedback, passwordFeedbackText, 'Kata sandi baru wajib diisi.');
                    return false;
                } else {
                    hideFeedback(passwordInput, passwordFeedback);
                    return false;
                }
            }
            if (val.length < 8) {
                showFeedback(passwordInput, passwordFeedback, passwordFeedbackText, 'Kata sandi minimal 8 karakter.');
                return false;
            }
            hideFeedback(passwordInput, passwordFeedback);
            return true;
        }

        function validateConfirm(forceValidation) {
            const val = confirmInput.value;
            const passVal = passwordInput.value;
            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(confirmInput, confirmFeedback, confirmFeedbackText, 'Konfirmasi kata sandi wajib diisi.');
                    return false;
                } else {
                    hideFeedback(confirmInput, confirmFeedback);
                    return false;
                }
            }
            if (val !== passVal) {
                showFeedback(confirmInput, confirmFeedback, confirmFeedbackText, 'Konfirmasi kata sandi tidak cocok.');
                return false;
            }
            hideFeedback(confirmInput, confirmFeedback);
            return true;
        }

        passwordInput.addEventListener('input', function () {
            if (isFormSubmitted) {
                validatePassword(false);
                if (confirmInput.value) validateConfirm(false);
            }
        });

        confirmInput.addEventListener('input', function () {
            if (isFormSubmitted) {
                validateConfirm(false);
            }
        });

        if (btnTogglePassword && passwordInput && passwordEyeIcon) {
            btnTogglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordEyeIcon.classList.toggle('ti-eye', !isPassword);
                passwordEyeIcon.classList.toggle('ti-eye-off', isPassword);
            });
        }

        if (btnTogglePasswordConfirm && confirmInput && passwordConfirmEyeIcon) {
            btnTogglePasswordConfirm.addEventListener('click', function () {
                const isPassword = confirmInput.getAttribute('type') === 'password';
                confirmInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordConfirmEyeIcon.classList.toggle('ti-eye', !isPassword);
                passwordConfirmEyeIcon.classList.toggle('ti-eye-off', isPassword);
            });
        }

        form.addEventListener('submit', function (e) {
            isFormSubmitted = true;
            const isPassValid = validatePassword(true);
            const isConfValid = validateConfirm(true);

            if (!isPassValid || !isConfValid) {
                e.preventDefault();
                if (!isPassValid) {
                    passwordInput.focus();
                } else {
                    confirmInput.focus();
                }
                return false;
            }

            const btnSubmit = document.getElementById('btnSubmitReset');
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span> Memperbarui Kata Sandi...';
            }
        });
    });
    </script>
</body>

</html>
