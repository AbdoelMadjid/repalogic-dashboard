<footer class="section-custom section-footer pb-2">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-3">
                @if ($appProfil && !empty($appProfil->logo_lg) && Storage::disk('public')->exists($appProfil->logo_lg))
                    <img src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" height="32" style="object-fit: contain;" />
                @else
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="30" />
                @endif
                <p class="mt-3 fs-sm text-opacity-75">
                    {{ $appProfil->meta_description ?? 'Inspinia Admin Dashboard & Management System' }}
                </p>

                <div class="d-flex gap-2 mt-4 mb-2">
                    <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Facebook">
                        <i data-lucide="facebook" class="fs-sm"></i>
                    </a>
                    <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Twitter-x">
                        <i class="ti ti-brand-x fs-sm"></i>
                    </a>
                    <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="Instagram">
                        <i data-lucide="instagram" class="fs-sm"></i>
                    </a>
                    <a href="#!" class="btn btn-sm btn-icon rounded-circle btn-dark" title="WhatsApp">
                        <i data-lucide="dribbble" class="fs-sm"></i>
                    </a>
                </div>
            </div>
            <!-- end col-->

            <div class="col-lg-8 col-xxl-7">
                <div class="row g-4">
                    <div class="col-6 col-md-4">
                        <h5 class="text-white mb-4 ps-2">Company</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link pt-0" href="#!">Our Story</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Leadership Team</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="#!">Careers <span
                                        class="badge text-bg-warning ms-2">We're Hiring</span></a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#!">Press & Media</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Investor Relations</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#!">Sustainability</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-4">
                        <h5 class="text-white mb-4 ps-2">Community</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link pt-0" href="#!">Community Forum</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#!">Events & Meetups</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Ambassadors</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Customer Stories</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Open Source</a></li>
                            <li class="nav-item"><a class="nav-link" href="#!">Code of Conduct</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-4">
                        <h5 class="text-white mb-4 ps-2">Admin</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link pt-0" href="{{ route('login') }}">Log In / Sign In</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.profil-pengguna.index') }}">Profil Pengguna</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dukunganaplikasi.profil-aplikasi.index') }}">Pengaturan Aplikasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dukunganaplikasi.fitur-aplikasi.index') }}">Katalog Fitur</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dukunganaplikasi.backup-db.index') }}">Backup Database</a></li>
                        </ul>
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
            $appVersion = $appProfil->app_version ?? config('app.version', 'v1.9.3');
        @endphp
        <div class="row mt-5">
            <div class="col-12 text-center">
                <p class="mb-4 text-opacity-75 fs-sm">
                    © {{ $yearDisplay }} <strong class="text-white">{{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }}</strong> — {{ $footerText }} 
                    <a href="{{ $devUrl }}" target="_blank" class="fw-semibold text-white text-decoration-none">{{ $devName }}</a>.
                    <span class="badge bg-primary text-white ms-2 font-monospace fs-xs">{{ $appVersion }}</span>
                </p>
            </div>
        </div>
        <!-- end row-->
    </div>
    <!-- end container-->
</footer>
