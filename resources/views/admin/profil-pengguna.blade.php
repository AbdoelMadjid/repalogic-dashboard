@extends('layouts.vertical')

@section('title', 'Profil Pengguna')

@section('content')
    <link href="{{ asset('assets/css/admin/profil-pengguna.css') }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Profil Pengguna', 'subtitle' => 'Master Data'])

@php
    $hex = ltrim($user->cover_color ?: '#313a46', '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $alpha = ($user->cover_opacity ?? 60) / 100;
    $rgbaCover = "rgba({$r}, {$g}, {$b}, {$alpha})";
    $rgbaTop = "rgba({$r}, {$g}, {$b}, " . max(0, $alpha - 0.25) . ")";
    $blurPx = (int) ($user->cover_blur ?? 0);
@endphp

    <div class="row">
        <div class="col-12">
            <article class="card card-out-of-container border-top-0 shadow-sm mb-4">
                <div id="main-header-banner" class="position-relative card-side-img overflow-hidden"
                    style="height: {{ $user->cover_height }}px; background-image: url('{{ $user->cover_bg_url }}'); background-size: cover; background-position: center {{ $user->cover_position_y }}%; transition: height 0.2s ease, background-position 0.2s ease;">
                    <div id="main-header-overlay" class="p-4 card-img-overlay rounded-start-0 d-flex align-items-center justify-content-center"
                        style="background: linear-gradient(to top, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }};">
                        <h3 class="mb-0 fst-italic text-center px-3" id="main-motto-display"
                            style="color: {{ $user->motto_color ?? '#ffffff' }}; text-shadow: {{ in_array(strtolower($user->motto_color ?? '#ffffff'), ['#000000', '#111827', '#1f2937', '#0f172a', 'black']) ? '0 2px 8px rgba(255,255,255,0.7)' : '0 2px 8px rgba(0,0,0,0.75)' }}; transition: color 0.2s ease, text-shadow 0.2s ease;">"{{ $user->motto }}"</h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <div style="width: 90px; height: 90px; flex-shrink: 0;">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                            </div>
                            <div>
                                <h4 class="text-nowrap fw-bold mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-1"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                                <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                    <span class="badge bg-primary-subtle text-primary fw-medium px-2 py-1 fs-xs">{{ $user->role_name }}</span>
                                    <span class="badge bg-info-subtle text-info fw-medium px-2 py-1 fs-xs" title="Total Teman Terhubung">
                                        <i class="ti ti-friends me-1"></i> {{ number_format($user->friends_count ?? 0) }} Teman
                                    </span>
                                    <span class="badge bg-danger-subtle text-danger fw-medium px-2 py-1 fs-xs" title="Total Suka Profil yang Diterima">
                                        <i class="ti ti-heart-filled me-1"></i> {{ number_format($user->profile_likes_count ?? 0) }} Suka
                                    </span>
                                    <span class="badge bg-warning-subtle text-warning fw-medium px-2 py-1 fs-xs" title="Total Poin Login yang Dikumpulkan">
                                        <i class="ti ti-award me-1"></i> {{ number_format($user->login_count ?? 0) }} Poin Login
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <!-- Tombol Pesan / Chat -->
                            <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-outline-success fw-semibold" id="btn-user-messages" title="Fitur Pesan / Obrolan">
                                <i class="ti ti-message me-1"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Personal Info -->
        <div class="col-xl-4 col-lg-5">
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

            <!-- Card Edit Profil Singkat -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-user-edit me-1"></i> Edit Profil Singkat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-pengguna.update-quick') }}" method="POST" enctype="multipart/form-data" id="form-quick-edit-profil">
                        @csrf
                        <div class="mb-3 text-center">
                            <div class="d-inline-block position-relative mb-2">
                                <img src="{{ $user->avatar_url }}" id="modal-avatar-preview" alt="avatar"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                            </div>
                            <div>
                                <label for="modal-avatar-input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-0">
                                    <i class="ti ti-camera me-1"></i> Pilih Foto Avatar
                                </label>
                                <input type="file" name="avatar" id="modal-avatar-input" class="d-none" accept="image/*">
                            </div>
                            <span class="fs-12 text-muted d-block mt-1">Format: JPG, PNG, WEBP, SVG (Maks 2MB)</span>
                        </div>

                        <div class="mb-3">
                            <label for="modal_name" class="form-label fw-semibold text-dark fs-13">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal_name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="modal_email" class="form-label fw-semibold text-dark fs-13">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="modal_email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="modal_password" class="form-label fw-semibold text-dark fs-13">Kata Sandi Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="modal_password" name="password" placeholder="Kosongkan jika tidak diganti">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password" title="Lihat/Sembunyikan Kata Sandi">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="modal_password_confirmation" class="form-label fw-semibold text-dark fs-13">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="modal_password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password_confirmation" title="Lihat/Sembunyikan Kata Sandi">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Motto Hidup / Kutipan Profil -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-quote me-1"></i> Motto Hidup / Kutipan Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-pengguna.update-motto') }}" method="POST" id="form-update-motto">
                        @csrf
                        <div class="mb-3">
                            <label for="motto_input" class="form-label fs-13 fw-semibold text-dark mb-1">Motto / Kata-Kata Bijak:</label>
                            <textarea name="motto" id="motto_input" rows="3" class="form-control" placeholder="Tuliskan motto hidup Anda..." maxlength="255" required>{{ old('motto', $user->motto) }}</textarea>
                            <span class="fs-12 text-muted d-block mt-1">Motto ini akan ditampilkan di atas banner foto sampul Anda.</span>
                        </div>

                        <!-- Pratinjau Visual Motto (di atas Foto Sampul) -->
                        <div class="mb-3">
                            <label class="form-label fs-12 fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                                <i class="ti ti-eye text-primary fs-15"></i> Pratinjau Visual Motto:
                            </label>
                            <div id="motto-preview-container" class="position-relative overflow-hidden rounded border shadow-sm p-3 d-flex align-items-center justify-content-center text-center"
                                style="min-height: 80px; background-image: url('{{ $user->cover_bg_url }}'); background-size: cover; background-position: center {{ $user->cover_position_y }}%;">
                                <div id="motto-preview-overlay" class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: linear-gradient(to top, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none;"></div>
                                <div id="motto-mini-preview-text" class="position-relative z-1 fst-italic fw-medium px-2"
                                    style="color: {{ old('motto_color', $user->motto_color) }}; font-size: 0.95rem; text-shadow: {{ in_array(strtolower(old('motto_color', $user->motto_color)), ['#000000', '#111827', '#1f2937', '#0f172a']) ? '0 1px 4px rgba(255, 255, 255, 0.8)' : '0 1px 4px rgba(0, 0, 0, 0.8)' }};">
                                    "{{ old('motto', $user->motto ?? 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.') }}"
                                </div>
                            </div>
                            <span class="fs-11 text-muted d-block mt-1">Pratinjau langsung warna teks motto di atas foto sampul profil Anda.</span>
                        </div>

                        <!-- Pilihan Warna Teks Motto -->
                        <div class="mb-3 p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <label for="motto_color_input" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                        <i class="ti ti-palette text-primary fs-15"></i> Warna Teks Motto:
                                    </label>
                                    <input type="color" class="form-control form-control-color border-0 p-0 rounded-circle cursor-pointer flex-shrink-0" id="motto_color_input" name="motto_color" value="{{ old('motto_color', $user->motto_color) }}" title="Pilih warna kustom" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px;">
                                    <div class="d-flex flex-wrap align-items-center gap-1.5">
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#ffffff' ? 'active' : '' }}" data-color="#ffffff" style="background-color: #ffffff; border: 2px solid #cbd5e1 !important;" title="Putih (#ffffff)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ in_array(strtolower(old('motto_color', $user->motto_color)), ['#000000', '#111827']) ? 'active' : '' }}" data-color="#111827" style="background-color: #111827;" title="Hitam (#111827)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f59e0b' ? 'active' : '' }}" data-color="#f59e0b" style="background-color: #f59e0b;" title="Kuning Emas (#f59e0b)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#06b6d4' ? 'active' : '' }}" data-color="#06b6d4" style="background-color: #06b6d4;" title="Cyan (#06b6d4)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#10b981' ? 'active' : '' }}" data-color="#10b981" style="background-color: #10b981;" title="Hijau Neon (#10b981)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f43f5e' ? 'active' : '' }}" data-color="#f43f5e" style="background-color: #f43f5e;" title="Merah Rose (#f43f5e)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f97316' ? 'active' : '' }}" data-color="#f97316" style="background-color: #f97316;" title="Oranye (#f97316)"></span>
                                        <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#8b5cf6' ? 'active' : '' }}" data-color="#8b5cf6" style="background-color: #8b5cf6;" title="Ungu (#8b5cf6)"></span>
                                    </div>
                                </div>
                                <span id="motto-color-val" class="badge bg-primary-subtle text-primary font-monospace fs-11 fw-bold">{{ old('motto_color', $user->motto_color) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Motto Hidup
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Permohonan Penonaktifan Akun (Danger Zone) -->
            <div class="card shadow-sm border border-danger-subtle mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold fs-13 d-flex align-items-center gap-1.5">
                        <i class="ti ti-user-x me-1"></i>
                        <span>Permohonan Penonaktifan Akun</span>
                        <span class="badge bg-white bg-opacity-25 text-white font-monospace fs-10">Danger Zone</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if ($user->isDeactivationRequested())
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-0 rounded-3" style="background-color: #fffbeb; color: #92400e;">
                            <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1">
                                <i class="ti ti-hourglass-low fs-20"></i>
                            </div>
                            <div class="w-100">
                                <h6 class="fw-bold mb-1 text-dark">Permohonan Penonaktifan Sedang Diproses</h6>
                                <p class="fs-13 mb-2 text-muted">
                                    Anda telah mengajukan permohonan penonaktifan akun pada <strong class="text-dark">{{ $user->deactivation_requested_at->format('d F Y (H:i)') }} WIB</strong>. Permintaan ini sedang menunggu tinjauan dan konfirmasi dari Administrator sistem.
                                </p>
                                @if(!empty($user->deactivation_reason))
                                    <div class="p-3 bg-white border border-warning-subtle rounded-2 fs-13 mb-2">
                                        <strong class="text-dark d-block mb-1"><i class="ti ti-notes me-1"></i>Alasan Pengajuan:</strong>
                                        <span class="text-secondary fst-italic">"{{ $user->deactivation_reason }}"</span>
                                    </div>
                                @endif
                                <form action="{{ route('admin.profil-pengguna.cancel-deactivation') }}" method="POST" data-confirm="Apakah Anda yakin ingin membatalkan permohonan penonaktifan akun Anda?">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning fw-semibold">
                                        <i class="ti ti-x me-1"></i> Batalkan Permohonan Penonaktifan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mb-3">
                            <h5 class="fw-bold text-dark fs-15 mb-1.5">Ingin menonaktifkan akun Anda?</h5>
                            <p class="text-muted fs-13 mb-0">
                                Jika Anda ingin berhenti menggunakan layanan untuk sementara atau permanen, Anda dapat mengajukan permohonan penonaktifan akun kepada Administrator. Setelah disetujui, akun Anda tidak akan dapat digunakan untuk masuk ke dalam sistem.
                            </p>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-request-deactivation">
                            <i class="ti ti-user-off me-1"></i> Minta Nonaktifkan Akun
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Data KTP & Alamat Lengkap -->
        <div class="col-xl-8 col-lg-7">
            <!-- Widget Progress Kelengkapan Profil -->
            @php
                $completion = $user->profile_completion_percentage;
                $progressBg = $completion >= 80 ? 'bg-success' : ($completion >= 50 ? 'bg-warning' : 'bg-danger');
                $badgeBg = $completion >= 80 ? 'bg-success-subtle text-success' : ($completion >= 50 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger');
            @endphp
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-chart-pie fs-20 text-primary"></i>
                            <h6 class="mb-0 fw-bold text-dark">Status Kelengkapan Data Profil</h6>
                        </div>
                        <span class="badge {{ $badgeBg }} fs-12 fw-bold font-monospace px-2 py-1">{{ $completion }}% Terlengkap</span>
                    </div>
                    <div class="progress progress-sm rounded-pill mb-2" style="height: 10px;">
                        <div class="progress-bar {{ $progressBg }} progress-bar-striped progress-bar-animated rounded-pill" role="progressbar" style="width: {{ $completion }}%;" aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="fs-12 text-muted d-flex align-items-center justify-content-between">
                        <span>
                            @if ($completion >= 100)
                                <i class="ti ti-circle-check-filled text-success me-1"></i> Data profil Anda sudah <strong>100% Lengkap!</strong>
                            @else
                                <i class="ti ti-info-circle text-warning me-1"></i> Lengkapi formulir identitas KTP & rincian alamat di bawah untuk mencapai 100%.
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Formulir Kelengkapan Data KTP & Alamat Langsung -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-id me-1"></i> Detail Kelengkapan Data KTP & Alamat</h5>
                </div>
                <div class="card-body">
                    @php
                        $detail = $user->detail ?? new \App\Models\UserDetail();
                    @endphp

                    <form action="{{ route('admin.profil-pengguna.update-detail') }}" method="POST" enctype="multipart/form-data" id="form-user-detail">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-hover align-middle border mb-0">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th class="text-center align-middle text-nowrap" style="width: 32%;">Rincian Identitas KTP</th>
                                        <th class="text-center align-middle text-nowrap">Nilai / Input Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-credit-card me-1 text-muted"></i> NIK (Nomor Induk Kependudukan)
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="nik" name="nik" value="{{ old('nik', $detail->nik) }}" placeholder="16 Digit NIK KTP" maxlength="20">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-brand-whatsapp me-1 text-success"></i> Nomor Telepon / WhatsApp
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light text-muted"><i class="ti ti-phone"></i></span>
                                                <input type="text" class="form-control form-control-sm" id="telepon" name="telepon" value="{{ old('telepon', $detail->telepon) }}" placeholder="Contoh: 081234567890" maxlength="30">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-user me-1 text-muted"></i> Nama Lengkap (Sesuai KTP)
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="nama_ktp" name="nama_ktp" value="{{ old('nama_ktp', $detail->nama_ktp ?? $user->name) }}" placeholder="Nama lengkap sesuai KTP">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-map-pin me-1 text-muted"></i> Tempat & Tanggal Lahir
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $detail->tempat_lahir) }}" placeholder="Kota / Tempat Lahir">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="date" class="form-control form-control-sm" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $detail->tanggal_lahir ? $detail->tanggal_lahir->format('Y-m-d') : '') }}">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-gender-bigender me-1 text-muted"></i> Jenis Kelamin
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-Laki" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-droplet me-1 text-muted"></i> Golongan Darah
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" id="golongan_darah" name="golongan_darah">
                                                <option value="">-- Pilih Golongan Darah --</option>
                                                <option value="A" {{ old('golongan_darah', $detail->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ old('golongan_darah', $detail->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="AB" {{ old('golongan_darah', $detail->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                                <option value="O" {{ old('golongan_darah', $detail->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-building-church me-1 text-muted"></i> Agama
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" id="agama" name="agama">
                                                <option value="">-- Pilih Agama --</option>
                                                <option value="Islam" {{ old('agama', $detail->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Kristen" {{ old('agama', $detail->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                <option value="Katholik" {{ old('agama', $detail->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                                <option value="Hindu" {{ old('agama', $detail->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('agama', $detail->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Khonghucu" {{ old('agama', $detail->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-heart me-1 text-muted"></i> Status Perkawinan
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" id="status_perkawinan" name="status_perkawinan">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="Belum Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                <option value="Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                                <option value="Cerai Hidup" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                <option value="Cerai Mati" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-briefcase me-1 text-muted"></i> Pekerjaan
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $detail->pekerjaan) }}" placeholder="e.g. Karyawan Swasta, PNS, Pengusaha">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-world me-1 text-muted"></i> Kewarganegaraan
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan', $detail->kewarganegaraan ?? 'WNI') }}" placeholder="WNI / WNA">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-home me-1 text-muted"></i> Alamat Jalan / Rumah
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm" id="alamat_jalan" name="alamat_jalan" rows="2" placeholder="Nama Jalan, Nomor Rumah, Dusun / Komplek">{{ old('alamat_jalan', $detail->alamat_jalan) }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-map me-1 text-muted"></i> RT / RW / Blok
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-sm-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">RT</span>
                                                        <input type="text" class="form-control form-control-sm" id="rt" name="rt" value="{{ old('rt', $detail->rt) }}" placeholder="001">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">RW</span>
                                                        <input type="text" class="form-control form-control-sm" id="rw" name="rw" value="{{ old('rw', $detail->rw) }}" placeholder="005">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Blok</span>
                                                        <input type="text" class="form-control form-control-sm" id="blok" name="blok" value="{{ old('blok', $detail->blok) }}" placeholder="Blok A3">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-building-community me-1 text-muted"></i> Desa / Kelurahan & Kecamatan
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $detail->desa_kelurahan) }}" placeholder="Desa / Kelurahan">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $detail->kecamatan) }}" placeholder="Kecamatan">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark text-nowrap align-middle">
                                            <i class="ti ti-map-2 me-1 text-muted"></i> Kabupaten/Kota, Provinsi & Kode Pos
                                        </td>
                                        <td>
                                            <div class="row g-2">
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control form-control-sm" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $detail->kabupaten_kota) }}" placeholder="Kabupaten / Kota">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control form-control-sm" id="provinsi" name="provinsi" value="{{ old('provinsi', $detail->provinsi) }}" placeholder="Provinsi">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control form-control-sm" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $detail->kode_pos) }}" placeholder="Kode Pos" maxlength="10">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-dark align-top">
                                            <div class="d-flex align-items-center gap-1.5 mb-2">
                                                <i class="ti ti-photo text-muted fs-15"></i>
                                                <span class="text-nowrap">Foto Dokumen KTP</span>
                                            </div>
                                            <div id="ktp-preview-wrapper" class="{{ !empty($detail?->foto_ktp_url) ? '' : 'd-none' }} mt-2 pe-1">
                                                <div class="position-relative border rounded p-1.5 shadow-sm bg-light mb-2 w-100 text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-preview-ktp" title="Klik untuk memperbesar Foto KTP">
                                                    <img src="{{ !empty($detail?->foto_ktp) && \Illuminate\Support\Facades\Storage::disk('public')->exists($detail->foto_ktp) ? asset('storage/' . $detail->foto_ktp) : asset('assets/images/stock/small-1.jpg') }}" id="ktp-preview-img" alt="Foto KTP" class="img-fluid rounded w-100" style="max-height: 180px; object-fit: contain; background: #ffffff;" />
                                                </div>
                                                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                                    <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-preview-ktp">
                                                        <i class="ti ti-zoom-in me-1"></i> Preview
                                                    </button>
                                                    @if (!empty($detail?->foto_ktp_url))
                                                        <a href="{{ $detail->foto_ktp_url }}" download="KTP-{{ \Illuminate\Support\Str::slug($user->name) }}" class="btn btn-xs btn-outline-secondary" id="btn-download-ktp">
                                                            <i class="ti ti-download me-1"></i> Unduh
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div>
                                                <label for="foto_ktp_input" class="form-label fs-12 text-muted mb-1 fw-semibold">
                                                    {{ !empty($detail?->foto_ktp_url) ? 'Ganti / Unggah Berkas KTP Baru:' : 'Unggah Berkas KTP:' }}
                                                </label>
                                                <input class="form-control form-control-sm" type="file" id="foto_ktp_input" name="foto_ktp" accept="image/*" />
                                                <span class="fs-11 text-muted mt-1 d-block">Format berkas: JPG, PNG, WEBP (Maksimal 2MB).</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end pt-3">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Kelengkapan Data KTP
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Foto Sampul / Background Header -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-photo me-1"></i> Foto Sampul Background Header</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-pengguna.update-cover') }}" method="POST" enctype="multipart/form-data" id="form-update-cover">
                        @csrf
                        <div class="mb-2 text-center">
                            <div id="cover-preview-container" class="position-relative mb-2 overflow-hidden rounded border shadow-sm w-100"
                                style="min-height: 70px; max-height: 280px; transition: aspect-ratio 0.2s ease, height 0.2s ease;">
                                <img src="{{ $user->cover_bg_url }}" id="cover-preview-img" alt="Background Header" class="w-100 h-100 object-fit-cover" style="object-fit: cover; object-position: center {{ $user->cover_position_y }}%;" />
                                <div id="cover-preview-overlay" class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: linear-gradient(to top, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none;"></div>
                            </div>
                            <label for="cover_bg_input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-0">
                                <i class="ti ti-camera me-1"></i> Pilih / Ganti Foto Sampul
                            </label>
                            <input type="file" name="cover_image" id="cover_bg_input" class="d-none" accept="image/*">
                        </div>

                        <!-- Warna Lapisan Overlay -->
                        <div class="mb-3 p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <label for="cover-color-input" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                        <i class="ti ti-palette text-primary fs-15"></i> Warna Lapisan:
                                    </label>
                                    <input type="color" class="form-control form-control-color border-0 p-0 rounded-circle cursor-pointer flex-shrink-0" id="cover-color-input" name="cover_color" value="{{ $user->cover_color }}" title="Pilih warna kustom" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px;">
                                    <div class="d-flex flex-wrap align-items-center gap-1.5">
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#313a46' ? 'active' : '' }}" data-color="#313a46" style="background-color: #313a46;" title="Dark Slate (#313a46)"></span>
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#000000' ? 'active' : '' }}" data-color="#000000" style="background-color: #000000;" title="Hitam (#000000)"></span>
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#1e3a8a' ? 'active' : '' }}" data-color="#1e3a8a" style="background-color: #1e3a8a;" title="Navy (#1e3a8a)"></span>
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#4338ca' ? 'active' : '' }}" data-color="#4338ca" style="background-color: #4338ca;" title="Indigo (#4338ca)"></span>
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#065f46' ? 'active' : '' }}" data-color="#065f46" style="background-color: #065f46;" title="Emerald (#065f46)"></span>
                                        <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#701a75' ? 'active' : '' }}" data-color="#701a75" style="background-color: #701a75;" title="Fuchsia (#701a75)"></span>
                                    </div>
                                </div>
                                <span id="cover-color-val" class="badge bg-primary-subtle text-primary font-monospace fs-11 fw-bold">{{ $user->cover_color }}</span>
                            </div>
                        </div>

                        <!-- Row Slider Ketebalan & Tingkat Blur -->
                        <div class="row g-3 mb-3">
                            <!-- Slider Ketebalan Warna Overlay -->
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded border h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="cover-opacity-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                            <i class="ti ti-adjustments-horizontal text-primary fs-15"></i> Ketebalan Warna:
                                        </label>
                                        <span id="cover-opacity-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_opacity }}%</span>
                                    </div>
                                    <input type="range" class="form-range mb-2" id="cover-opacity-range" name="cover_opacity" min="0" max="100" step="5" value="{{ $user->cover_opacity }}">
                                    <div class="d-flex justify-content-between gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="0">0% (Asli)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="60">60% (Standar)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="85">85% (Pekat)</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider Tingkat Blur Lapisan -->
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded border h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="cover-blur-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                            <i class="ti ti-blur text-primary fs-15"></i> Tingkat Blur Lapisan:
                                        </label>
                                        <span id="cover-blur-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_blur }}px</span>
                                    </div>
                                    <input type="range" class="form-range mb-2" id="cover-blur-range" name="cover_blur" min="0" max="20" step="1" value="{{ $user->cover_blur }}">
                                    <div class="d-flex justify-content-between gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="0">0px (Tanpa Blur)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="6">6px (Sedang)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="14">14px (Kuat)</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row Slider Tinggi Banner & Posisi Vertikal -->
                        <div class="row g-3 mb-3">
                            <!-- Slider Pengatur Tinggi Banner Sampul -->
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded border h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="cover-height-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                            <i class="ti ti-arrows-maximize text-primary fs-15"></i> Tinggi Banner Sampul:
                                        </label>
                                        <span id="cover-height-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_height }}px</span>
                                    </div>
                                    <input type="range" class="form-range mb-2" id="cover-height-range" name="cover_height" min="180" max="600" step="10" value="{{ $user->cover_height }}">
                                    <div class="d-flex justify-content-between gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="220">Ringkas (220px)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="320">Standar (320px)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="450">Tinggi (450px)</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider Pengatur Posisi Vertikal -->
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded border h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="cover-position-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                            <i class="ti ti-arrows-vertical text-primary fs-15"></i> Posisi Atas - Bawah:
                                        </label>
                                        <span id="cover-pos-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_position_y }}%</span>
                                    </div>
                                    <input type="range" class="form-range mb-2" id="cover-position-range" name="cover_position_y" min="0" max="100" value="{{ $user->cover_position_y }}">
                                    <div class="d-flex justify-content-between gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="0">Atas (0%)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="50">Tengah (50%)</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="100">Bawah (100%)</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Pengaturan Foto Sampul
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL PERMINTAAN NONAKTIFKAN AKUN (RULE 4 COMPLIANCE) -->
    <div class="modal fade" id="modal-request-deactivation" tabindex="-1" aria-labelledby="modalRequestDeactivationLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-alert-triangle fs-22"></i>
                        <h5 class="modal-title text-white mb-0" id="modalRequestDeactivationLabel">Ajukan Penonaktifan Akun</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.profil-pengguna.request-deactivation') }}" method="POST" id="form-request-deactivation">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-danger border-0 d-flex align-items-start gap-2 mb-3 py-2 px-3 rounded-3" style="background-color: #fef2f2; color: #991b1b;">
                            <i class="ti ti-alert-circle fs-20 flex-shrink-0 mt-1"></i>
                            <div class="fs-13">
                                <strong>Perhatian:</strong> Permintaan penonaktifan akun akan dikirimkan langsung ke Administrator. Setelah disetujui, Anda tidak akan dapat masuk kembali hingga diaktifkan oleh admin.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deactivation_reason" class="form-label fw-semibold text-dark">Alasan Penonaktifan (Opsional):</label>
                            <textarea name="reason" id="deactivation_reason" rows="3" class="form-control" placeholder="Tuliskan alasan mengapa Anda ingin menonaktifkan akun ini..." maxlength="500"></textarea>
                            <span class="fs-12 text-muted d-block mt-1">Alasan ini akan ditinjau oleh administrator sebelum akun dinonaktifkan.</span>
                        </div>
                    </div>

                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 fw-semibold">
                            <i class="ti ti-send me-1"></i> Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW FOTO KTP (RULE 4 COMPLIANCE: Clean modal-lg layout) -->
    @if (!empty($detail?->foto_ktp_url))
        <div class="modal fade" id="modal-preview-ktp" tabindex="-1" aria-labelledby="modalPreviewKtpLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white py-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-id fs-22"></i>
                            <h5 class="modal-title text-white mb-0" id="modalPreviewKtpLabel">Preview Berkas Foto KTP</h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center bg-light">
                        <div class="bg-white p-2 rounded border shadow-sm d-inline-block w-100 mb-3">
                            <img src="{{ $detail->foto_ktp_url }}" alt="Foto KTP {{ $user->name }}" class="img-fluid rounded" style="max-height: 520px; width: 100%; object-fit: contain;">
                        </div>
                        <div class="text-start bg-white p-3 rounded border">
                            <div class="row g-2 fs-13">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block"><i class="ti ti-credit-card me-1"></i> NIK:</span>
                                    <strong class="text-dark">{{ $detail->nik ?? '-' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block"><i class="ti ti-user me-1"></i> Nama Lengkap (KTP):</span>
                                    <strong class="text-dark">{{ $detail->nama_ktp ?? $user->name }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                        <a href="{{ $detail->foto_ktp_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-external-link me-1"></i> Buka di Tab Baru
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ $detail->foto_ktp_url }}" download="KTP-{{ \Illuminate\Support\Str::slug($user->name) }}" class="btn btn-sm btn-primary">
                                <i class="ti ti-download me-1"></i> Unduh Berkas
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Page JS (Rule 1 Compliance: Place scripts inside @section('content') before @endsection) --}}
    <script src="{{ asset('assets/js/admin/profil-pengguna.js') }}"></script>
@endsection
