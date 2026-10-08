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

<!-- HERO PROFILE OVERVIEW CARD (MATCHING DASHBOARD HERO CARD) -->
<div class="row mt-1 mb-4">
    <div class="col-12">
        <div class="card dashboard-hero-card border-0 shadow-sm position-relative overflow-hidden" id="main-header-banner"
            style="min-height: {{ $user->cover_height }}px; background-image: url('{{ $user->cover_bg_url }}'); background-position: center {{ $user->cover_position_y }}%;">
            <!-- Dynamic Overlay Layer (Rule 15 - Live Color, Opacity & Blur Synchronization) -->
            <div class="position-absolute top-0 start-0 end-0 bottom-0 hero-overlay-layer" id="main-header-overlay"
                style="background: linear-gradient(135deg, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none; z-index: 1;"></div>
            <div class="card-body p-3.5 p-sm-4 p-lg-4.5 d-flex align-items-center position-relative" style="z-index: 2;">
                <div class="row align-items-center g-3 w-100 mx-0">
                    <div class="col-md-8 px-0">
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                            <!-- 1. Avatar Pengguna -->
                            <div class="hero-avatar-wrapper flex-shrink-0 text-center">
                                <img src="{{ $user->avatar_url }}"
                                    alt="{{ $user->name }}" class="rounded-3 hero-avatar-img shadow">
                            </div>

                            <div class="text-center text-md-start w-100">
                                <h3 class="fw-bold text-white mb-1.5 fs-20 fs-md-22">
                                    {{ $user->name }}
                                </h3>

                                <div class="d-flex flex-column flex-md-row flex-md-wrap align-items-center justify-content-center justify-content-md-start gap-2 gap-md-2.5 text-white-50 fs-13 mb-2">
                                    <!-- Email -->
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-mail text-white-50 me-1.5"></i>
                                        <span class="text-white fw-medium">{{ $user->email }}</span>
                                    </div>

                                    <span class="text-white-50 opacity-25 d-none d-md-inline">•</span>

                                    <!-- Role -->
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-shield-check text-white-50 me-1.5"></i>
                                        <span class="text-white fw-medium">{{ $user->role_name }}</span>
                                    </div>

                                    <span class="text-white-50 opacity-25 d-none d-md-inline">•</span>

                                    <!-- Teman & Suka -->
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="d-flex align-items-center" title="Total Teman Terhubung">
                                            <i class="ti ti-friends text-info me-1.5"></i>
                                            <span class="text-white fw-medium" id="header-profile-friends-count">{{ number_format($user->friends_count ?? 0) }} Teman</span>
                                        </div>
                                        <span class="text-white-50 opacity-25" id="header-profile-likes-separator">•</span>
                                        <div class="d-flex align-items-center" id="header-profile-likes-wrapper" title="Total Suka Profil yang Diterima {{ empty($settings['privacy']['allow_likes']) ? '(Dinonaktifkan untuk Publik)' : '' }}">
                                            <i class="ti ti-heart-filled text-danger me-1.5" id="header-profile-likes-icon"></i>
                                            <span class="text-white fw-medium" id="header-profile-likes-count">{{ number_format($user->profile_likes_count ?? 0) }} Suka</span>
                                            @if (empty($settings['privacy']['allow_likes']))
                                                <span class="badge bg-dark bg-opacity-50 text-white-50 fs-xxs ms-1 py-0.5 px-1" title="Tombol suka dinonaktifkan dari pengguna lain"><i class="ti ti-eye-off"></i></span>
                                            @endif
                                        </div>
                                    </div>

                                    <span class="text-white-50 opacity-25 d-none d-md-inline" id="header-profile-login-points-separator">•</span>

                                    <!-- Poin Login -->
                                    <div class="d-flex align-items-center" id="header-profile-login-points-wrapper" title="Total Poin Login yang Dikumpulkan {{ empty($settings['privacy']['show_points']) ? '(Disembunyikan dari Publik)' : '' }}">
                                        <i class="ti ti-award text-warning me-1.5"></i>
                                        <span class="text-white fw-medium" id="header-profile-login-points">{{ number_format($user->login_count ?? 0) }} Poin Login</span>
                                        @if (empty($settings['privacy']['show_points']))
                                            <span class="badge bg-dark bg-opacity-50 text-white-50 fs-xxs ms-1 py-0.5 px-1" title="Disembunyikan dari pengguna lain di direktori publik"><i class="ti ti-eye-off"></i></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Motto Hidup -->
                                <p class="text-white-50 fst-italic fs-13 mb-0" id="main-motto-display"
                                    style="color: {{ $user->motto_color ?? '#ffffff' }} !important; text-shadow: 0 1px 4px rgba(0,0,0,0.5);">
                                    "{{ $user->motto }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Action Buttons -->
                    <div class="col-md-4 px-0 text-center text-md-end mt-3 mt-md-0">
                        <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-2">
                            <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-sm btn-light fw-semibold shadow-sm" id="btn-user-messages" title="Fitur Pesan / Obrolan">
                                <i class="ti ti-message me-1 text-success"></i> Pesan Masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
