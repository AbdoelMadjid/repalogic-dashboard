<div class="modal fade" id="aboutSystemModal" tabindex="-1" aria-labelledby="aboutSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 940px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header Badges & Close -->
            <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 fs-12 fw-semibold rounded-pill">
                        <i class="ti ti-info-circle me-1"></i><span data-lang="about-badge-template">{{ !empty($appProfil->app_name) ? $appProfil->app_name : 'REPALOGIC Platform' }}</span>
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 fs-12 fw-semibold rounded-pill">
                        <span>{{ (str_starts_with(config('app.version', 'v3.5.2'), 'v') || str_starts_with(config('app.version', 'v3.5.2'), 'V')) ? config('app.version') : 'v' . config('app.version') }} - Laravel {{ app()->version() }}</span>
                    </span>
                    <span class="badge px-2.5 py-1.5 fs-12 fw-semibold rounded-pill" style="background-color: rgba(114, 57, 234, 0.1) !important; color: #7239ea !important; border: 1px solid rgba(114, 57, 234, 0.2) !important;">
                        <i class="ti ti-shield-check me-1"></i><span data-lang="about-badge-ready">Enterprise Ready</span>
                    </span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body px-4 py-4">
                <!-- Hero Icon & Title -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2.5 shadow-sm" style="width: 72px; height: 72px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.25);">
                        <i class="ti ti-cube text-primary" style="font-size: 38px;"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-1 fs-24">
                        <span data-lang="about-title-prefix">About</span> <span class="text-primary">{{ !empty($appProfil->app_short_name) ? $appProfil->app_short_name : (!empty($appProfil->app_name) ? $appProfil->app_name : 'REPALOGIC') }}</span>
                    </h2>
                    <p class="text-muted fs-13 mb-3" data-lang="about-subtitle">Platform Fondasi Aplikasi Bisnis Enterprise Laravel 11 & Inspinia</p>

                    <!-- Tech Stack Badges -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-brand-laravel me-1"></i>Laravel {{ explode('.', app()->version())[0] ?? '11' }}
                        </span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-brand-php me-1"></i>PHP {{ PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION }}+
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-layout-grid me-1"></i>Inspinia Theme
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-brand-bootstrap me-1"></i>Bootstrap 5.3
                        </span>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-refresh me-1"></i>Vite & Realtime AJAX
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded-pill fs-11 fw-semibold">
                            <i class="ti ti-shield-lock me-1"></i>Spatie Security
                        </span>
                    </div>
                </div>

                <!-- Subtle Description Box (Generous Padding) -->
                <div class="rounded-3 mb-4 border text-secondary fs-13 lh-base text-center" style="background-color: var(--bs-tertiary-bg, rgba(248, 249, 250, 0.85)); padding: 1.25rem 1.5rem !important;">
                    <span data-lang="about-desc">REPALOGIC Dashboard adalah platform fondasi aplikasi bisnis berbasis enterprise yang modern dan tangguh, dibangun di atas Laravel 11, PHP 8.2+, Spatie RBAC, dan template Inspinia Admin Bootstrap 5. Dilengkapi dengan sistem otentikasi bertingkat, matriks hak akses cerdas, profil pengguna sosial & chat instan, keamanan 2FA TOTP, log aktivitas komprehensif, mesin multibahasa modular (EN/ID), serta utilitas perawatan sistem terpadu.</span>
                </div>

                <!-- Creator / Developer Profile Box (Generous Padding) -->
                <div class="card border rounded-3 mb-4 shadow-none bg-body" style="padding: 1.25rem 1.5rem !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-16 flex-shrink-0 shadow-sm" style="width: 52px; height: 52px;">
                            AM
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <h6 class="fw-bold mb-0 text-dark fs-15" data-lang="about-creator-name">Abdoel Madjid</h6>
                                <span class="badge rounded-pill fs-xs px-2.5 py-1" style="background-color: rgba(114, 57, 234, 0.1) !important; color: #7239ea !important; border: 1px solid rgba(114, 57, 234, 0.2) !important;" data-lang="about-creator-role">Creator & Developer</span>
                            </div>
                            <div class="text-primary fw-semibold fs-12 mb-1" data-lang="about-creator-title">Full-Stack Developer & Software Architect</div>
                            <p class="text-muted fs-12 mb-0 lh-base" data-lang="about-creator-bio">Passionate software engineer focused on building clean, maintainable, and scalable enterprise web solutions with modern PHP, Laravel, and frontend technologies.</p>
                        </div>
                    </div>
                </div>

                <!-- Key Features & System Architecture Section Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 mt-1">
                    <h5 class="fw-bold text-dark mb-0 fs-14" data-lang="about-features-title">Fitur Utama & Arsitektur Sistem</h5>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill fs-xs px-2.5 py-1" data-lang="about-modules-count">10 Core Modules</span>
                </div>

                <!-- 10 Core Modules Grid (REPALOGIC Tailored Modules) -->
                <div class="row g-3">
                    <!-- 1. Auth Lifecycle & Approval -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                                <i class="ti ti-shield-lock fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod1-title">Sistem Otentikasi & Alur Persetujuan (Auth Lifecycle)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod1-desc">Alur pendaftaran terkontrol (approval admin), banding aktivasi akun, auto lock-screen saat idle, dan penanganan token CSRF 419.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Spatie RBAC & Permission Matrix -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(114, 57, 234, 0.12); color: #7239ea;">
                                <i class="ti ti-lock-access fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod2-title">Matriks Hak Akses & Spatie RBAC (Access Control)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod2-desc">Tabel matriks izin peran & pengguna bertingkat, proteksi superadmin, deduplikasi izin otomatis, dan forget cache instan.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Adaptive Dashboard -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="ti ti-layout-dashboard fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod3-title">Dasbor Adaptif Berbasis Peran (Adaptive Dashboard)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod3-desc">Tampilan adaptif admin vs user, metrik status akun, pemantauan backup DB & server health, serta grafik tren aktivitas 7 hari.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. User Profile & WYSIWYG Cover -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(249, 115, 22, 0.12); color: #f97316;">
                                <i class="ti ti-user-circle fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod4-title">Pusat Profil Pengguna & Sampul WYSIWYG (User Profile Hub)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod4-desc">Kelola data KTP lengkap, crop avatar 1:1 (Cropper.js), reposisi drag vertikal cover banner, blur efek, serta overlay tint warna.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Social & Messaging Hub -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                                <i class="ti ti-messages fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod5-title">Ekosistem Jejaring Sosial, Pertemanan & Pesan (Chat Hub)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod5-desc">Permintaan pertemanan, suka profil (likes), obrolan pesan instan dengan voice note, lampiran dokumen/foto, pin pesan, dan unsend.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Two-Factor Authentication (2FA) -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(239, 68, 68, 0.12); color: #ef4444;">
                                <i class="ti ti-shield-check fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod6-title">Keamanan 2FA & Otentikasi Dua Faktor (Two-Factor TOTP)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod6-desc">Otentikasi dua faktor berbasis TOTP (Google Authenticator/Authy), rendering QR code SVG offline, dan 8 kode pemulihan terenkripsi.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Activity Audit & Forensic Login Logs -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(236, 72, 153, 0.12); color: #ec4899;">
                                <i class="ti ti-history fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod7-title">Pusat Log Aktivitas & Jejak Forensik Login (Activity Audit)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod7-desc">Pencatatan log aktivitas model (diff side-by-side), audit trail forensik login (IP, OS, peramban, perangkat), dan auto-pruning.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 8. 6-Domain Bilingual i18n -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(99, 102, 241, 0.12); color: #6366f1;">
                                <i class="ti ti-world fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod8-title">Mesin Terjemahan Multibahasa Modular (6-Domain i18n)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod8-desc">Alih bahasa instan ID/EN tanpa reload halaman (< 5ms) melalui 6 domain kamus JSON modular dan pre-hydration anti-flicker.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. 3-Tier Menu Hierarchy -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(217, 119, 6, 0.12); color: #d97706;">
                                <i class="ti ti-sitemap fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod9-title">Manajemen Menu Dinamis 3-Tingkat (Menu Hierarchy)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod9-desc">Hierarki Menu Utama, Sub-Menu, dan Child Sub-Menu 3-tingkat dengan pemilihan ikon Tabler, generator rute, dan binding Spatie.</div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Self-Maintenance & DB Backup -->
                    <div class="col-md-6">
                        <div class="rounded-3 border h-100 d-flex align-items-start gap-3 bg-body-tertiary bg-opacity-50" style="padding: 1rem 1.15rem !important;">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(100, 116, 139, 0.12); color: #64748b;">
                                <i class="ti ti-tools fs-20"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-dark fs-13 mb-1" data-lang="about-mod10-title">Utilitas Perawatan Mandiri & Pencadangan DB (Maintenance Hub)</div>
                                <div class="text-muted fs-12 lh-base" data-lang="about-mod10-desc">Sistem feature flag dinamis, backup database (.sql/.gz), pembersih gambar yatim (orphan cleaner), fix symlink, dan flush cache.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer Buttons (All buttons side-by-side inline on desktop) -->
            <div class="modal-footer border-0 pt-2 px-4 pb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <a href="{{ !empty($appProfil->developer_url) ? $appProfil->developer_url : 'https://github.com/AbdoelMadjid/repalogic-dashboard' }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-2 d-inline-flex align-items-center text-nowrap">
                        <i class="ti ti-brand-github me-1.5 fs-15"></i>
                        <span data-lang="about-btn-repo">Visit Repository</span>
                    </a>
                    <a href="{{ Route::has('template.documentation.menu.introduction') ? route('template.documentation.menu.introduction') : url('template/documentation/menu/introduction') }}" class="btn btn-sm rounded-2 d-inline-flex align-items-center text-nowrap" style="background-color: rgba(114, 57, 234, 0.1); color: #7239ea; border: 1px solid rgba(114, 57, 234, 0.25);">
                        <i class="ti ti-book me-1.5 fs-15"></i>
                        <span data-lang="about-btn-docs">Documentation & Blueprint Portal</span>
                    </a>
                    <a href="{{ Route::has('template.documentation.changelog') ? route('template.documentation.changelog') : url('template/documentation/changelog') }}" class="btn btn-outline-success btn-sm rounded-2 d-inline-flex align-items-center text-nowrap">
                        <i class="ti ti-notes me-1.5 fs-15"></i>
                        <span data-lang="about-btn-changelog">Release Notes & Changelog</span>
                    </a>
                </div>
                <button type="button" class="btn btn-light btn-sm rounded-2 px-3 text-nowrap ms-auto" data-bs-dismiss="modal">
                    <span data-lang="about-btn-close">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
