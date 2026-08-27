<footer class="section-custom section-footer pt-5 pb-3 position-relative overflow-hidden" style="background: linear-gradient(180deg, #0f172a 0%, #020617 100%); border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <!-- Top Ambient Accent Glow Line -->
    <div class="position-absolute top-0 start-50 translate-middle-x w-75" style="height: 1px; background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.6), rgba(168, 85, 247, 0.4), transparent);"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-4 justify-content-between">
            <!-- 1. Left Brand & Profile Column -->
            <div class="col-lg-4 col-xl-3">
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if ($appProfil && !empty($appProfil->logo_lg) && Storage::disk('public')->exists($appProfil->logo_lg))
                        <img src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" height="34" style="object-fit: contain;" />
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="32" />
                    @endif
                </div>

                <p class="fs-13 text-white text-opacity-70 leading-relaxed mb-4" style="max-width: 320px;">
                    {{ $appProfil->meta_description ?? 'Sistem Manajemen Dashboard Admin terintegrasi berbasis Laravel & Inspinia Theme yang modern, aman, dan fleksibel.' }}
                </p>

                <!-- Social Icons with Glassmorphic Circular Glow -->
                <div class="d-flex gap-2 mb-2">
                    <a href="#!" class="footer-social-btn" title="Facebook">
                        <i class="ti ti-brand-facebook fs-16"></i>
                    </a>
                    <a href="#!" class="footer-social-btn" title="Twitter / X">
                        <i class="ti ti-brand-x fs-16"></i>
                    </a>
                    <a href="#!" class="footer-social-btn" title="Instagram">
                        <i class="ti ti-brand-instagram fs-16"></i>
                    </a>
                    <a href="#!" class="footer-social-btn" title="WhatsApp">
                        <i class="ti ti-brand-whatsapp fs-16"></i>
                    </a>
                    <a href="https://github.com/AbdoelMadjid/repalogic-dashboard" target="_blank" class="footer-social-btn" title="GitHub Repository">
                        <i class="ti ti-brand-github fs-16"></i>
                    </a>
                </div>
            </div>
            <!-- end col-->

            <!-- 2. Right Navigation Links (Company & Community in 2 Sub-Columns Each) -->
            <div class="col-lg-8 col-xl-8">
                <div class="row g-4 g-lg-5">
                    <!-- Company Group -->
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom border-white border-opacity-10">
                            <span class="rounded-pill bg-primary" style="width: 4px; height: 16px;"></span>
                            <h6 class="text-uppercase text-white fw-bold fs-12 letter-spacing-1 mb-0">Company</h6>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Our Story</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Leadership</a></li>
                                    <li class="nav-item mb-1.5">
                                        <a class="footer-link d-inline-flex align-items-center" href="#!">
                                            <i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Careers 
                                            <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5 fs-10 ms-2 fw-bold">Hiring</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Press &amp; Media</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Investor Relations</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Sustainability</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Community Group -->
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom border-white border-opacity-10">
                            <span class="rounded-pill bg-info" style="width: 4px; height: 16px;"></span>
                            <h6 class="text-uppercase text-white fw-bold fs-12 letter-spacing-1 mb-0">Community</h6>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Forum Diskusi</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Events &amp; Meetups</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Ambassadors</a></li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Cerita Pengguna</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Open Source</a></li>
                                    <li class="nav-item mb-1.5"><a class="footer-link" href="#!"><i class="ti ti-chevron-right fs-12 opacity-50 me-1"></i> Panduan Komunitas</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

        @php
            $createdYear = $appProfil->created_year ?? '2024';
            $currentYear = date('Y');
            $yearDisplay = ($createdYear != $currentYear) ? "{$createdYear} - {$currentYear}" : $currentYear;
            $footerText = $appProfil->footer_text ?? 'Inspinia By';
            $devName = $appProfil->developer_name ?? 'WebAppLayers';
            $devUrl = $appProfil->developer_url ?? '#!';
            $appVersion = $appProfil->app_version ?? config('app.version', 'v2.1.3');
        @endphp

        <!-- Bottom Copyright Strip -->
        <div class="border-top border-white border-opacity-10 mt-4 pt-3">
            <div class="row align-items-center gy-2">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white text-opacity-70 fs-13">
                        © {{ $yearDisplay }} <strong class="text-white">{{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</strong>. Seluruh hak cipta dilindungi.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2 flex-wrap">
                        <span class="text-white text-opacity-60 fs-12">
                            {{ $footerText }} <a href="{{ $devUrl }}" target="_blank" class="fw-semibold text-white text-decoration-none hover-underline">{{ $devName }}</a>
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace fs-11 px-2 py-0.5 rounded-pill">
                            {{ $appVersion }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end bottom strip -->
    </div>
    <!-- end container-->
</footer>

<!-- Scoped Elegant Footer CSS -->
<style>
    .footer-link {
        color: rgba(255, 255, 255, 0.7) !important;
        text-decoration: none !important;
        font-size: 13px !important;
        padding: 3px 0 !important;
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .footer-link:hover {
        color: #ffffff !important;
        transform: translateX(4px) !important;
    }
    .footer-link:hover .ti-chevron-right {
        opacity: 1 !important;
        color: var(--bs-primary) !important;
    }
    .footer-social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .footer-social-btn:hover {
        background: var(--bs-primary);
        border-color: var(--bs-primary);
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(var(--bs-primary-rgb), 0.4);
    }
    .hover-underline:hover {
        text-decoration: underline !important;
    }
</style>
