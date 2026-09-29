<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Verifikasi Alamat Email | {{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</title>
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
                        <h4 class="fw-bold mt-3">Verifikasi Email Anda</h4>
                        <p class="text-muted w-lg-75 mx-auto">Terima kasih telah mendaftar! Sebelum memulai, silakan periksa kotak masuk email Anda dan klik tautan verifikasi yang kami kirimkan.</p>
                    </div>

                    <div class="card p-4 shadow-sm border-0 rounded-3">
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success border-0 shadow-sm d-flex align-items-start gap-2 mb-3.5 py-3 px-3.5 rounded-3" role="alert" style="background-color: #f0fdf4; color: #166534; border-left: 4px solid #22c55e !important;">
                                <i class="ti ti-circle-check fs-18 text-success flex-shrink-0 mt-0.5"></i>
                                <div class="fs-13 lh-base">
                                    <strong class="d-block mb-0.5">Tautan Terkirim!</strong>
                                    Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}" id="resendVerificationForm">
                            @csrf
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary fw-semibold py-2 d-inline-flex align-items-center justify-content-center" id="btnSubmitResend">
                                    <i class="ti ti-mail-forward me-1.5" id="btnSubmitResendIcon"></i>
                                    <span id="btnSubmitResendText">Kirim Ulang Email Verifikasi</span>
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <div class="text-center">
                                <button type="submit" class="btn btn-link text-decoration-underline link-offset-3 text-muted p-0 fs-13">
                                    <i class="ti ti-logout me-1"></i> Keluar (Log Out)
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
        const form = document.getElementById('resendVerificationForm');
        if (form) {
            form.addEventListener('submit', function () {
                const btnSubmit = document.getElementById('btnSubmitResend');
                if (btnSubmit) {
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span> Mengirim Ulang...';
                }
            });
        }
    });
    </script>
</body>

</html>
