@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/plugins/cropperjs/cropper.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/admin/profil-pengguna.css') }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Profil Pengguna', 'subtitle' => 'Master Data'])

    <!-- Hero Profile Overview Banner -->
    @include('admin.profil-pengguna.partials.hero-overview')

    <div class="row">
        <!-- Sidebar Personal Info & Security Widgets -->
        <div class="col-xl-4 col-lg-5">
            @include('admin.profil-pengguna.partials.card-informasi-akun')
            @include('admin.profil-pengguna.partials.card-edit-profil-singkat')
            @include('admin.profil-pengguna.partials.card-motto-hidup')
            @include('admin.profil-pengguna.partials.card-keamanan-2fa')
            @include('admin.profil-pengguna.partials.card-penonaktifan-akun')
        </div>

        <!-- Detail Profil & Self-Service Settings Tabs -->
        <div class="col-xl-8 col-lg-7">
            @include('admin.profil-pengguna.partials.widget-kelengkapan-profil')
            @include('admin.profil-pengguna.partials.nav-tabs')

            <!-- Tab Content Panels -->
            <div class="tab-content" id="profileTabsContent">
                @include('admin.profil-pengguna.partials.tab-identitas-dan-ktp')
                @include('admin.profil-pengguna.partials.tab-sampul-dan-tema')
                @include('admin.profil-pengguna.partials.tab-pesan-dan-chat')
                @include('admin.profil-pengguna.partials.tab-notifikasi')
                @include('admin.profil-pengguna.partials.tab-privasi-dan-sesi')
                @include('admin.profil-pengguna.partials.tab-aktivitas-saya')
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.profil-pengguna.partials.modal-deactivation')
    @include('admin.profil-pengguna.partials.modal-preview-ktp')
    @include('admin.profil-pengguna.partials.modal-crop-avatar')
    @include('admin.profil-pengguna.partials.modal-2fa')

    {{-- Dynamic Backend Bridge & Page JS (Rule 1 & 15 Compliance) --}}
    <script>
        window.ProfilPenggunaConfig = {
            userId: {{ $user->id }},
            userEmail: @json($user->email),
            avatarOriginalUrl: @json($user->avatar_original_url),
            avatarCropData: @json($user->avatar_crop_data),
            avatarCurrentUrl: @json($user->avatar_url),
            twoFactorEnabled: {{ $user->hasEnabledTwoFactor() ? 'true' : 'false' }},
            settings: @json($settings),
            routes: {
                pollDashboard: "{{ route('admin.friendships.poll-dashboard') }}",
                twoFactorEnable: "{{ route('admin.profil-pengguna.two-factor.enable') }}",
                twoFactorConfirm: "{{ route('admin.profil-pengguna.two-factor.confirm') }}",
                twoFactorDisable: "{{ route('admin.profil-pengguna.two-factor.disable') }}",
                twoFactorRecoveryCodes: "{{ route('admin.profil-pengguna.two-factor.recovery-codes') }}",
                twoFactorRegenerateRecoveryCodes: "{{ route('admin.profil-pengguna.two-factor.regenerate-recovery-codes') }}",
                updateSettings: "{{ route('admin.profil-pengguna.update-settings') }}",
            },
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
    <script src="{{ asset('assets/plugins/cropperjs/cropper.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin/profil-pengguna.js') }}"></script>
@endsection
