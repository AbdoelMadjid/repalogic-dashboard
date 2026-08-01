@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Banner -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-warning bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-warning fw-semibold px-3 py-1.5 rounded-pill mb-3">SCSS Theme
                        Engine</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="theme-skin-setup">Theme Skin Setup & SCSS Customization
                    </h2>
                    <p class="text-white-50 fs-16 mb-0">INSPINIA features 6 built-in theme skins powered by modular SCSS
                        variables (`resources/scss/config/`).</p>
                </div>
            </div>
        </div>

        <!-- Available Theme Skins Grid -->
        <div class="col-12 mb-4">
            <h4 class="fw-bold mb-3">6 Built-in Theme Skins</h4>
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success-subtle text-success fw-semibold">Default</span>
                            <h6 class="fw-bold mb-0">Classic Theme</h6>
                        </div>
                        <p class="text-muted fs-13 mb-2">The signature INSPINIA theme featuring rich teal/emerald accents
                            and high-contrast typography.</p>
                        <code>resources/scss/config/_themes-classic.scss</code>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-2">SaaS Theme</h6>
                        <p class="text-muted fs-13 mb-2">Tailored for SaaS products with soft indigo primary hues and modern
                            border radiuses.</p>
                        <code>resources/scss/config/_themes-saas.scss</code>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-2">Minimal Theme</h6>
                        <p class="text-muted fs-13 mb-2">Clean monochrome palette designed for data-heavy applications.</p>
                        <code>resources/scss/config/_themes-minimal.scss</code>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-2">Material Theme</h6>
                        <p class="text-muted fs-13 mb-2">Inspired by Material Design principles with vibrant primary colors
                            and floating shadows.</p>
                        <code>resources/scss/config/_themes-material.scss</code>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-2">Modern Theme</h6>
                        <p class="text-muted fs-13 mb-2">Contemporary layout styling with rounded cards and sleek borders.
                        </p>
                        <code>resources/scss/config/_themes-modern.scss</code>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">Upcoming</span>
                            <h6 class="fw-bold mb-0">Galaxy Theme</h6>
                        </div>
                        <p class="text-muted fs-13 mb-2">Futuristic dark gradient theme designed for AI & analytics
                            applications.</p>
                        <code>resources/scss/config/_themes-galaxy.scss</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
