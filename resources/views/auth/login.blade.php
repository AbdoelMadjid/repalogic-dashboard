<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Masuk ke Akun | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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

    <style>
        .input-group-merge .form-control:focus {
            z-index: 1;
        }
        .invalid-feedback-custom {
            font-size: 0.8125rem;
            line-height: 1.4;
            margin-top: 0.5rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.375rem;
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #dc2626 !important;
            transition: all 0.2s ease-in-out;
        }
    </style>
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
                        <h4 class="fw-bold mt-3">Selamat Datang</h4>
                        <p class="text-muted w-lg-75 mx-auto">Silakan masuk ke akun Anda. Masukkan alamat email dan kata sandi untuk melanjutkan.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        @if (session('registered_pending'))
                            <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #eff6ff; color: #1e40af;">
                                <i class="ti ti-info-circle-filled fs-18 text-primary flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    <strong class="d-block mb-0.5">Pendaftaran Berhasil!</strong>
                                    {{ session('registered_pending') }}
                                </div>
                            </div>
                        @endif

                        @if (session('reset_requested'))
                            <div class="alert alert-success border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #f0fdf4; color: #166534; border-left: 4px solid #22c55e !important;">
                                <i class="ti ti-key fs-18 text-success flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    <strong class="d-block mb-0.5">Permintaan Reset Terkirim!</strong>
                                    {{ session('reset_requested') }}
                                </div>
                            </div>
                        @endif

                        @if (session('reactivation_success'))
                            <div class="alert alert-success border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #f0fdf4; color: #166534; border-left: 4px solid #22c55e !important;">
                                <i class="ti ti-user-check fs-18 text-success flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    <strong class="d-block mb-0.5">Permohonan Aktivasi Terkirim!</strong>
                                    {{ session('reactivation_success') }}
                                </div>
                            </div>
                        @endif

                        @if (session('info_message'))
                            <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #eff6ff; color: #1e40af;">
                                <i class="ti ti-info-circle-filled fs-18 text-primary flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    {{ session('info_message') }}
                                </div>
                            </div>
                        @endif

                        @if ($errors->has('unapproved'))
                            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #fffbeb; color: #92400e; border-left: 4px solid #f59e0b !important;">
                                <i class="ti ti-clock-pause fs-18 text-warning flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    <strong class="d-block mb-0.5">Menunggu Persetujuan Admin</strong>
                                    {{ $errors->first('unapproved') }}
                                </div>
                            </div>
                        @endif

                        @if ($errors->has('rejected'))
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-2 mb-3 py-3 px-3 rounded-3" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
                                <i class="ti ti-user-x fs-18 text-danger flex-shrink-0 mt-1"></i>
                                <div class="fs-13 lh-base w-100">
                                    <strong class="d-block mb-1">Pengajuan Pendaftaran Ditolak</strong>
                                    {{ $errors->first('rejected') }}
                                    <div class="mt-2 pt-1 border-top border-danger-subtle">
                                        <a href="{{ route('register') }}" class="btn btn-sm btn-danger text-white fw-semibold py-1 px-3">
                                            <i class="ti ti-user-plus me-1"></i> Daftar Ulang Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($errors->has('inactive'))
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
                                <i class="ti ti-ban fs-18 text-danger flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base w-100">
                                    <strong class="d-block mb-0.5">Akun Dinonaktifkan</strong>
                                    {{ $errors->first('inactive') }}
                                    <div class="mt-2 pt-1 border-top border-danger-subtle">
                                        <a href="{{ route('activation.request') }}" class="btn btn-sm btn-danger text-white fw-semibold py-1 px-2.5">
                                            <i class="ti ti-user-check me-1"></i>Ajukan Permohonan Aktivasi Akun
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($errors->has('maintenance'))
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
                                <i class="ti ti-tool fs-18 text-danger flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base w-100">
                                    <strong class="d-block mb-0.5">Mode Pemeliharaan Aktif</strong>
                                    {{ $errors->first('maintenance') }}
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                            @csrf
                            <input type="hidden" name="latitude" id="loginLatitude" value="">
                            <input type="hidden" name="longitude" id="loginLongitude" value="">
                            <!-- Email Input Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Alamat Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-mail fs-16 text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Masukkan Email Anda (contoh: nama@domain.com)" autocomplete="email" />
                                </div>
                                <div id="emailFeedback" class="invalid-feedback-custom text-danger mt-2 @error('email') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="emailFeedbackText">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <!-- Password Input Field -->
                            <div class="mb-3">
                                <label for="userPassword" class="form-label fw-semibold">
                                    Kata Sandi (Password)
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-lock fs-16 text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                        id="userPassword" placeholder="Masukkan Kata Sandi Anda" name="password"
                                        value="{{ old('password') }}" autocomplete="current-password" />
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

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-light fs-14" type="checkbox"
                                        id="rememberMe" name="remember" />
                                    <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-decoration-underline link-offset-3 text-muted">Lupa Kata Sandi?</a>
                                @endif
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold py-2" id="btnSubmitLogin">Masuk ke Akun</button>
                            </div>
                        </form>

                        <p class="text-muted text-center mt-4 mb-0">
                            Belum memiliki akun?
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-decoration-underline link-offset-3 fw-semibold">Daftar Akun Baru</a>
                            @endif
                        </p>
                        <p class="text-muted text-center mt-2 mb-0 fs-12">
                            Akun dinonaktifkan?
                            <a href="{{ route('activation.request') }}"
                                class="text-decoration-underline link-offset-3 fw-semibold text-danger">Ajukan Aktivasi</a>
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
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFeedbackText = document.getElementById('emailFeedbackText');

        const passwordInput = document.getElementById('userPassword');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const passwordFeedbackText = document.getElementById('passwordFeedbackText');

        const btnTogglePassword = document.getElementById('btnTogglePassword');
        const passwordEyeIcon = document.getElementById('passwordEyeIcon');

        let isFormSubmitted = false;
        let hasServerEmailError = {{ $errors->has('email') ? 'true' : 'false' }};
        let hasServerPasswordError = {{ $errors->has('password') ? 'true' : 'false' }};

        // --- Toggle Password Eye Feature ---
        if (btnTogglePassword && passwordInput && passwordEyeIcon) {
            btnTogglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordEyeIcon.classList.toggle('ti-eye', !isPassword);
                passwordEyeIcon.classList.toggle('ti-eye-off', isPassword);
            });
        }

        // --- Helper Validasi Format Email ---
        function checkEmailFormat(val) {
            if (!val.includes('@') || !val.includes('.')) {
                return false;
            }
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(val);
        }

        // --- Email Feedback Functions ---
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

        // --- Password Feedback Functions ---
        function showPasswordError(msg) {
            passwordFeedbackText.textContent = msg;
            passwordInput.classList.add('is-invalid');
            passwordFeedback.classList.remove('d-none');
            passwordFeedback.classList.add('d-flex');
        }

        function hidePasswordError() {
            passwordInput.classList.remove('is-invalid');
            passwordFeedback.classList.add('d-none');
            passwordFeedback.classList.remove('d-flex');
        }

        function validatePassword(forceValidation) {
            const val = passwordInput.value;

            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showPasswordError('Password harus diisi.');
                    return false;
                } else {
                    hidePasswordError();
                    return false;
                }
            }

            hidePasswordError();
            return true;
        }

        // --- Event Listeners Email ---
        emailInput.addEventListener('input', function () {
            hasServerEmailError = false;
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
            if (hasServerEmailError) return;
            if (emailInput.value.trim() !== '' || isFormSubmitted) {
                validateEmail(true);
            }
        });

        // --- Event Listeners Password ---
        passwordInput.addEventListener('focus', function () {
            if (hasServerPasswordError) return;
            if (!passwordInput.value) {
                showPasswordError('Password harus diisi.');
            }
        });

        passwordInput.addEventListener('input', function () {
            hasServerPasswordError = false;
            const val = passwordInput.value;
            if (!val) {
                showPasswordError('Password harus diisi.');
            } else {
                hidePasswordError();
            }
        });

        passwordInput.addEventListener('blur', function () {
            if (hasServerPasswordError) return;
            if (!passwordInput.value && !isFormSubmitted) {
                hidePasswordError();
            }
        });

        // --- Form Submit Interceptor ---
        form.addEventListener('submit', function (e) {
            isFormSubmitted = true;

            const isEmailValid = validateEmail(true);
            const isPasswordValid = validatePassword(true);

            if (!isEmailValid || !isPasswordValid) {
                e.preventDefault();

                if (!isEmailValid) {
                    emailInput.focus();
                } else if (!isPasswordValid) {
                    passwordInput.focus();
                }
            }
        });

        // --- Autofocus Cerdas saat Terdapat Kesalahan dari Server ---
        @if ($errors->has('email'))
            isFormSubmitted = true;
            setTimeout(function() {
                emailInput.focus();
                emailInput.select();
            }, 150);
        @elseif ($errors->has('password'))
            isFormSubmitted = true;
            setTimeout(function() {
                passwordInput.focus();
                passwordInput.select();
            }, 150);
        @endif

        // --- Geolocation Coordinates Capture (Non-blocking) ---
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latEl = document.getElementById('loginLatitude');
                    const lngEl = document.getElementById('loginLongitude');
                    if (latEl && lngEl) {
                        latEl.value = position.coords.latitude;
                        lngEl.value = position.coords.longitude;
                    }
                },
                function (error) {
                    // Silently ignore if user denies or location is disabled
                    console.debug('Geolocation info:', error.message);
                },
                { timeout: 6000, enableHighAccuracy: false, maximumAge: 60000 }
            );
        }
    });
    </script>
</body>

</html>
