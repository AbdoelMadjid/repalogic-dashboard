@php
    $appProfil = $appProfil ?? (class_exists(\App\Models\Admin\DukunganAplikasi\ProfilAplikasi::class) ? \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::getSettings() : null);
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Sesi Telah Berakhir (419) | {{ $appProfil->app_name ?? config('app.name', 'REPALOGIC Dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- App favicon -->
    @if (isset($appProfil) && !empty($appProfil->favicon) && \Illuminate\Support\Facades\Storage::disk('public')->exists($appProfil->favicon))
        <link rel="shortcut icon" href="{{ asset('storage/' . $appProfil->favicon) }}" />
    @else
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    @endif

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="bg-light">
    <div class="auth-box d-flex align-items-center min-vh-100 py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5 text-center">
                            <div class="auth-brand mb-4">
                                <a href="/" class="d-inline-block">
                                    @if (isset($appProfil) && !empty($appProfil->logo_lg) && \Illuminate\Support\Facades\Storage::disk('public')->exists($appProfil->logo_lg))
                                        <img src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name ?? 'logo' }}" height="38" style="object-fit: contain; max-height: 48px;" />
                                    @else
                                        <img src="{{ asset('assets/images/logo-black.png') }}" alt="logo" height="38" />
                                    @endif
                                </a>
                            </div>

                            <div class="mb-4">
                                <div class="avatar-xl bg-warning-subtle text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 90px; height: 90px;">
                                    <i class="ti ti-hourglass-empty" style="font-size: 42px; line-height: 1;"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-2">Sesi Telah Kedaluwarsa</h3>
                                <div class="badge bg-danger-subtle text-danger fs-12 px-3 py-1.5 rounded-pill mb-3">
                                    <i class="ti ti-clock-pause me-1"></i> Kode Kesalahan: 419 (Page Expired)
                                </div>
                                <div class="p-3 bg-light rounded-3 border text-secondary fs-14 mb-4">
                                    Halaman atau sesi Anda telah berakhir karena tidak ada aktivitas dalam waktu yang cukup lama. Silakan masuk kembali untuk melanjutkan.
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                <a href="{{ route('login') }}" class="btn btn-primary px-4 fw-semibold">
                                    <i class="ti ti-login me-1"></i> Masuk Kembali
                                </a>
                                <button type="button" class="btn btn-outline-secondary px-3" onclick="window.location.reload();">
                                    <i class="ti ti-refresh me-1"></i> Muat Ulang Halaman
                                </button>
                            </div>

                            <div class="mt-4 pt-3 border-top text-muted fs-12">
                                &copy; {{ date('Y') }} {{ config('app.name', 'REPALOGIC') }}. Hak Cipta Dilindungi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
