<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Daftar Akun Baru | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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
                        <h4 class="fw-bold mt-3">Daftar Akun Baru</h4>
                        <p class="text-muted w-lg-75 mx-auto">Mulai sekarang. Buat akun baru Anda dengan melengkapi data di bawah ini.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                            @csrf

                            <!-- Full Name Input -->
                            <div class="mb-3">
                                <label for="userName" class="form-label fw-semibold">
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-user fs-16 text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                                        id="userName" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama lengkap Anda" autocomplete="name" required />
                                </div>
                                <div id="nameFeedback" class="invalid-feedback-custom text-danger mt-2 @error('name') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="nameFeedbackText">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div class="mb-3">
                                <label for="userEmail" class="form-label fw-semibold">
                                    Alamat Email
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-mail fs-16 text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        id="userEmail" name="email" value="{{ old('email') }}"
                                        placeholder="contoh: nama@domain.com" autocomplete="email" required />
                                </div>
                                <div id="emailFeedback" class="invalid-feedback-custom text-danger mt-2 @error('email') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="emailFeedbackText">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <!-- Password Input with Strength Bar & Eye Toggle -->
                            <div class="mb-3" data-password="bar">
                                <label for="userPassword" class="form-label fw-semibold">
                                    Kata Sandi (Password)
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-lock fs-16 text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                        id="userPassword" placeholder="Minimal 8 karakter..." name="password" autocomplete="new-password" required />
                                    <button class="btn btn-light border border-start-0 text-muted" type="button" id="btnTogglePassword"
                                        title="Lihat / Sembunyikan Kata Sandi" tabindex="-1">
                                        <i class="ti ti-eye fs-16" id="passwordEyeIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordFeedback" class="invalid-feedback-custom text-danger mt-2 @error('password') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="passwordFeedbackText">{{ $errors->first('password') }}</span>
                                </div>
                                <div class="password-bar my-2"></div>
                                <p class="text-muted fs-xs mb-0">Gunakan minimal 8 karakter kombinasi huruf, angka &amp; simbol.</p>
                            </div>

                            <!-- Agree Terms Checkbox -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-light fs-14 @error('terms') is-invalid @enderror"
                                        type="checkbox" id="termAndPolicy" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="termAndPolicy">Saya menyetujui Syarat &amp; Kebijakan Layanan</label>
                                </div>
                                <div id="termsFeedback" class="invalid-feedback-custom text-danger mt-2 @error('terms') d-flex @else d-none @enderror align-items-center gap-1.5">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="termsFeedbackText">{{ $errors->first('terms') ?: 'Anda wajib menyetujui syarat & ketentuan.' }}</span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold py-2" id="btnSubmitRegister">Daftar Akun Baru</button>
                            </div>
                        </form>

                        <p class="text-muted text-center mt-4 mb-0">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                                class="text-decoration-underline link-offset-3 fw-semibold">Masuk (Login)</a>
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
    <!-- end auth-fluid-->

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Password Suggestion Js -->
    <script src="{{ asset('assets/js/pages/auth-password.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('registerForm');
        const nameInput = document.getElementById('userName');
        const nameFeedback = document.getElementById('nameFeedback');
        const nameFeedbackText = document.getElementById('nameFeedbackText');

        const emailInput = document.getElementById('userEmail');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFeedbackText = document.getElementById('emailFeedbackText');

        const passwordInput = document.getElementById('userPassword');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const passwordFeedbackText = document.getElementById('passwordFeedbackText');

        const termsCheckbox = document.getElementById('termAndPolicy');
        const termsFeedback = document.getElementById('termsFeedback');
        const termsFeedbackText = document.getElementById('termsFeedbackText');

        const btnTogglePassword = document.getElementById('btnTogglePassword');
        const passwordEyeIcon = document.getElementById('passwordEyeIcon');

        let isFormSubmitted = false;
        let hasServerNameError = {{ $errors->has('name') ? 'true' : 'false' }};
        let hasServerEmailError = {{ $errors->has('email') ? 'true' : 'false' }};
        let hasServerPasswordError = {{ $errors->has('password') ? 'true' : 'false' }};
        let hasServerTermsError = {{ $errors->has('terms') ? 'true' : 'false' }};

        // --- Helper Feedback Functions ---
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

        // Helper fungsi validasi format email (@ dan domain .)
        function checkEmailFormat(val) {
            if (!val.includes('@') || !val.includes('.')) {
                return false;
            }
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(val);
        }

        // --- Validasi Name ---
        function validateName(forceValidation) {
            const val = nameInput.value.trim();
            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(nameInput, nameFeedback, nameFeedbackText, 'Nama lengkap wajib diisi.');
                    return false;
                } else {
                    hideFeedback(nameInput, nameFeedback);
                    return false;
                }
            }
            hideFeedback(nameInput, nameFeedback);
            return true;
        }

        nameInput.addEventListener('input', function () {
            hasServerNameError = false;
            if (nameInput.value.trim() === '') {
                if (isFormSubmitted) {
                    showFeedback(nameInput, nameFeedback, nameFeedbackText, 'Nama lengkap wajib diisi.');
                } else {
                    hideFeedback(nameInput, nameFeedback);
                }
            } else {
                hideFeedback(nameInput, nameFeedback);
            }
        });

        // --- Validasi Email ---
        function validateEmail(forceValidation) {
            const val = emailInput.value.trim();

            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(emailInput, emailFeedback, emailFeedbackText, 'Email wajib diisi.');
                    return false;
                } else {
                    hideFeedback(emailInput, emailFeedback);
                    return false;
                }
            }

            if (!checkEmailFormat(val)) {
                showFeedback(emailInput, emailFeedback, emailFeedbackText, 'Format email tidak valid.');
                return false;
            }

            hideFeedback(emailInput, emailFeedback);
            return true;
        }

        emailInput.addEventListener('input', function () {
            hasServerEmailError = false;
            const val = emailInput.value.trim();
            if (val === '') {
                if (isFormSubmitted) {
                    showFeedback(emailInput, emailFeedback, emailFeedbackText, 'Email wajib diisi.');
                } else {
                    hideFeedback(emailInput, emailFeedback);
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

        // --- Validasi Password ---
        function validatePassword(forceValidation) {
            const val = passwordInput.value;
            if (!val) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(passwordInput, passwordFeedback, passwordFeedbackText, 'Password harus diisi.');
                    return false;
                } else {
                    hideFeedback(passwordInput, passwordFeedback);
                    return false;
                }
            }

            hideFeedback(passwordInput, passwordFeedback);
            return true;
        }

        passwordInput.addEventListener('focus', function () {
            if (hasServerPasswordError) return;
            if (!passwordInput.value) {
                showFeedback(passwordInput, passwordFeedback, passwordFeedbackText, 'Password harus diisi.');
            }
        });

        passwordInput.addEventListener('input', function () {
            hasServerPasswordError = false;
            const val = passwordInput.value;
            if (!val) {
                showFeedback(passwordInput, passwordFeedback, passwordFeedbackText, 'Password harus diisi.');
            } else {
                hideFeedback(passwordInput, passwordFeedback);
            }
        });

        passwordInput.addEventListener('blur', function () {
            if (hasServerPasswordError) return;
            if (!passwordInput.value && !isFormSubmitted) {
                hideFeedback(passwordInput, passwordFeedback);
            }
        });

        // --- Validasi Terms & Policy ---
        function validateTerms(forceValidation) {
            if (!termsCheckbox.checked) {
                if (forceValidation || isFormSubmitted) {
                    showFeedback(termsCheckbox, termsFeedback, termsFeedbackText, 'Anda wajib menyetujui syarat & ketentuan.');
                    return false;
                } else {
                    hideFeedback(termsCheckbox, termsFeedback);
                    return false;
                }
            }
            hideFeedback(termsCheckbox, termsFeedback);
            return true;
        }

        termsCheckbox.addEventListener('change', function () {
            hasServerTermsError = false;
            if (termsCheckbox.checked) {
                hideFeedback(termsCheckbox, termsFeedback);
            } else if (isFormSubmitted) {
                showFeedback(termsCheckbox, termsFeedback, termsFeedbackText, 'Anda wajib menyetujui syarat & ketentuan.');
            }
        });

        // --- Toggle Password Eye Feature ---
        if (btnTogglePassword && passwordInput && passwordEyeIcon) {
            btnTogglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                passwordEyeIcon.classList.toggle('ti-eye', !isPassword);
                passwordEyeIcon.classList.toggle('ti-eye-off', isPassword);
            });
        }

        // --- Form Submit Interceptor ---
        form.addEventListener('submit', function (e) {
            isFormSubmitted = true;

            const isNameValid = validateName(true);
            const isEmailValid = validateEmail(true);
            const isPasswordValid = validatePassword(true);
            const isTermsValid = validateTerms(true);

            if (!isNameValid || !isEmailValid || !isPasswordValid || !isTermsValid) {
                e.preventDefault();

                if (!isNameValid) {
                    nameInput.focus();
                } else if (!isEmailValid) {
                    emailInput.focus();
                } else if (!isPasswordValid) {
                    passwordInput.focus();
                } else if (!isTermsValid) {
                    termsCheckbox.focus();
                }
            }
        });

        // --- Autofocus Cerdas saat Terdapat Kesalahan Server ---
        @if ($errors->has('name'))
            isFormSubmitted = true;
            setTimeout(function() {
                nameInput.focus();
                nameInput.select();
            }, 150);
        @elseif ($errors->has('email'))
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
        @elseif ($errors->has('terms'))
            isFormSubmitted = true;
            setTimeout(function() {
                termsCheckbox.focus();
            }, 150);
        @endif
    });
    </script>
</body>

</html>
