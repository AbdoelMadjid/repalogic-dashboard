<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Ajukan Aktivasi Akun | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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
            line-height: 1.35;
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
                        <h4 class="fw-bold mt-3">Aktivasi Akun Kembali</h4>
                        <p class="text-muted w-lg-75 mx-auto">Akun Anda dinonaktifkan? Ajukan permohonan ke Administrator untuk mengaktifkan kembali akun Anda.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        <form method="POST" action="{{ route('activation.send') }}" id="activationForm" novalidate>
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
                                        placeholder="contoh: nama@domain.com" autocomplete="email" required />
                                </div>
                                <div id="emailFeedback" class="invalid-feedback-custom text-danger mt-1.5 @error('email') d-flex @else d-none @enderror align-items-center gap-1">
                                    <i class="ti ti-alert-circle fs-15 flex-shrink-0"></i>
                                    <span id="emailFeedbackText">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label fw-semibold">
                                    Alasan / Catatan Permohonan (Opsional)
                                </label>
                                <textarea name="reason" id="reason" rows="3" class="form-control"
                                    placeholder="Jelaskan secara singkat alasan pengaktifan kembali akun Anda..." maxlength="500">{{ old('reason') }}</textarea>
                                <span class="fs-12 text-muted d-block mt-1">Catatan ini akan diteruskan ke administrator untuk verifikasi akun.</span>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary fw-semibold py-2" id="btnSubmitActivation">
                                    <i class="ti ti-user-check me-1"></i> Ajukan Aktivasi Akun
                                </button>
                            </div>
                        </form>

                        <p class="text-muted text-center mb-0">
                            Ingin kembali ke halaman login?
                            <a href="{{ route('login') }}"
                                class="text-decoration-underline link-offset-3 fw-semibold">Masuk ke Akun</a>
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
        const form = document.getElementById('activationForm');
        const emailInput = document.getElementById('userEmail');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFeedbackText = document.getElementById('emailFeedbackText');
        const btnSubmit = document.getElementById('btnSubmitActivation');

        function validateEmail(email) {
            return String(email)
                .toLowerCase()
                .match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
        }

        function checkEmailField() {
            const val = emailInput.value.trim();
            if (!val) {
                showFeedback(emailInput, emailFeedback, emailFeedbackText, 'Alamat email wajib diisi.');
                return false;
            } else if (!validateEmail(val)) {
                showFeedback(emailInput, emailFeedback, emailFeedbackText, 'Format alamat email tidak valid (contoh: nama@domain.com).');
                return false;
            } else {
                hideFeedback(emailInput, emailFeedback);
                return true;
            }
        }

        function showFeedback(inputEl, feedbackEl, textEl, message) {
            inputEl.classList.add('is-invalid');
            inputEl.classList.remove('is-valid');
            textEl.textContent = message;
            feedbackEl.classList.remove('d-none');
            feedbackEl.classList.add('d-flex');
        }

        function hideFeedback(inputEl, feedbackEl) {
            inputEl.classList.remove('is-invalid');
            feedbackEl.classList.remove('d-flex');
            feedbackEl.classList.add('d-none');
        }

        emailInput.addEventListener('input', function() {
            if (emailInput.classList.contains('is-invalid')) {
                checkEmailField();
            }
        });

        emailInput.addEventListener('blur', function() {
            checkEmailField();
        });

        form.addEventListener('submit', function (e) {
            const isEmailValid = checkEmailField();

            if (!isEmailValid) {
                e.preventDefault();
                return false;
            }

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim Permohonan...';
        });
    });
    </script>
</body>

</html>
