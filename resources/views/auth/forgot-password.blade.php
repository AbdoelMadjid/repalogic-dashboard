<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lupa Kata Sandi | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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
                        <h4 class="fw-bold mt-3">Lupa Kata Sandi?</h4>
                        <p class="text-muted w-lg-75 mx-auto">Masukkan alamat email Anda yang terdaftar untuk mengajukan permohonan reset password ke Administrator.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="userEmail" class="form-label fw-semibold">
                                    Alamat Email Terdaftar <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-mail fs-16 text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        id="userEmail" name="email" value="{{ old('email') }}"
                                        placeholder="contoh: you@example.com" autocomplete="email" required />
                                </div>
                                <div id="emailFeedback" class="invalid-feedback-custom text-danger mt-2 @error('email') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="emailFeedbackText">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary fw-semibold py-2" id="btnSubmitForgot">
                                    <i class="ti ti-send me-1"></i> Ajukan Reset Password
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

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('forgotPasswordForm');
        const emailInput = document.getElementById('userEmail');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFeedbackText = document.getElementById('emailFeedbackText');

        let isFormSubmitted = false;
        let hasServerError = {{ $errors->has('email') ? 'true' : 'false' }};

        function checkEmailFormat(val) {
            if (!val.includes('@') || !val.includes('.')) {
                return false;
            }
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(val);
        }

        function showEmailError(msg) {
            emailFeedbackText.textContent = msg;
            emailInput.classList.add('is-invalid');
            emailFeedback.classList.remove('d-none');
            emailFeedback.classList.add('d-flex');
        }

        function hideEmailError() {
            emailInput.classList.remove('is-invalid');
            emailFeedback.classList.add('d-none');
            emailFeedback.classList.remove('d-flex');
        }

        function validateEmail(forceValidation) {
            const val = emailInput.value.trim();
            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showEmailError('Email wajib diisi.');
                    return false;
                } else {
                    hideEmailError();
                    return false;
                }
            }
            if (!checkEmailFormat(val)) {
                showEmailError('Format email tidak valid.');
                return false;
            }
            hideEmailError();
            return true;
        }

        emailInput.addEventListener('input', function () {
            hasServerError = false;
            const val = emailInput.value.trim();
            if (val === '') {
                if (isFormSubmitted) {
                    showEmailError('Email wajib diisi.');
                } else {
                    hideEmailError();
                }
            } else {
                validateEmail(false);
            }
        });

        emailInput.addEventListener('blur', function () {
            if (hasServerError) return;
            if (emailInput.value.trim() !== '' || isFormSubmitted) {
                validateEmail(true);
            }
        });

        form.addEventListener('submit', function (e) {
            isFormSubmitted = true;
            const isEmailValid = validateEmail(true);
            if (!isEmailValid) {
                e.preventDefault();
                emailInput.focus();
            }
        });

        @if ($errors->has('email'))
            isFormSubmitted = true;
            setTimeout(function() {
                emailInput.focus();
                emailInput.select();
            }, 150);
        @endif
    });
    </script>
</body>

</html>
