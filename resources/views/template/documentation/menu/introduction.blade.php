@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card border-0 text-white bg-primary bg-gradient shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white text-primary fw-semibold px-3 py-1.5 rounded-pill mb-3">v4.0.0 Release Candidate</span>
                            <h2 class="fw-bold text-white mb-2" data-lang="doc-welcome-title">Welcome to Repalogic & INSPINIA Documentation</h2>
                            <p class="text-white-50 fs-16 mb-4" data-lang="doc-welcome-desc">
                                Comprehensive guides and technical documentation for building high-performance web applications with Repalogic Dashboard.
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('template.documentation.menu.getting-started') }}" class="btn btn-light fw-semibold px-3.5 py-2 shadow-sm">
                                    <i class="ti ti-rocket me-1"></i> <span data-lang="getting-started">Getting Started</span>
                                </a>
                                <a href="{{ route('template.documentation.menu.folder-structure') }}" class="btn btn-outline-light fw-semibold px-3.5 py-2">
                                    <i class="ti ti-sitemap me-1"></i> <span data-lang="folder-structure">Folder Structure</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center mt-4 mt-lg-0">
                            <div class="p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-20 backdrop-blur">
                                <i class="ti ti-brand-bootstrap display-3 text-white"></i>
                                <div class="mt-2 fw-semibold text-white">Bootstrap 5.3 + Laravel 12</div>
                                <span class="fs-12 text-white-50">Fully Responsive & Modular</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Features Grid -->
        <div class="col-12 mb-4">
            <h4 class="fw-bold mb-3" data-lang="doc-key-features">Key Features & Capabilities</h4>
            <div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <div class="card h-100 border shadow-none p-3 rounded-3">
                        <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center mb-3 fs-24">
                            <i class="ti ti-palette"></i>
                        </div>
                        <h5 class="fw-bold mb-1">6 Theme Skins</h5>
                        <p class="text-muted fs-13 mb-0">Pre-built SCSS theme skins including Classic, SaaS, Minimal, Material, and Modern.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border shadow-none p-3 rounded-3">
                        <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center mb-3 fs-24">
                            <i class="ti ti-layout-dashboard"></i>
                        </div>
                        <h5 class="fw-bold mb-1">Layout Flexibility</h5>
                        <p class="text-muted fs-13 mb-0">Support for Vertical, Horizontal, Boxed, Scrollable, and Compact sidebar layouts.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border shadow-none p-3 rounded-3">
                        <div class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center mb-3 fs-24">
                            <i class="ti ti-moon-stars"></i>
                        </div>
                        <h5 class="fw-bold mb-1">Dark Mode Ready</h5>
                        <p class="text-muted fs-13 mb-0">Native Bootstrap 5 dark theme switcher with custom CSS variables and auto-persistence.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border shadow-none p-3 rounded-3">
                        <div class="avatar-md bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center mb-3 fs-24">
                            <i class="ti ti-route"></i>
                        </div>
                        <h5 class="fw-bold mb-1">Dynamic Sidenav</h5>
                        <p class="text-muted fs-13 mb-0">Config-driven sidebar navigation system (`config/sidenav-template/*.php`) with auto route lookup.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support & Links Section -->
        <div class="col-lg-8 mb-4">
            <div class="card border h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-headset me-2 text-primary"></i>Customer Support & Help</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted fs-14 mb-3">
                        We are committed to providing top-notch support. If you run into any issues, need customization advice, or have feature requests, reach out via our support channel:
                    </p>
                    <div class="alert alert-info border-0 d-flex align-items-center gap-3">
                        <i class="ti ti-help-hexagon fs-28 flex-shrink-0"></i>
                        <div>
                            <strong class="d-block">Need Support?</strong>
                            Submit a message directly at <a href="https://wrapbootstrap.com/user/WebAppLayers/message" target="_blank" class="alert-link">WrapBootstrap Support</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border h-100">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-link me-2 text-primary"></i>Quick Navigation</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('template.documentation.menu.getting-started') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3">
                            <span class="fw-medium"><i class="ti ti-bolt text-warning me-2"></i> Getting Started Guide</span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                        <a href="{{ route('template.documentation.menu.folder-structure') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3">
                            <span class="fw-medium"><i class="ti ti-folder text-info me-2"></i> Project Directory Map</span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                        <a href="{{ route('template.documentation.layouts.layouts') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3">
                            <span class="fw-medium"><i class="ti ti-layout-board text-primary me-2"></i> Layout Options</span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                        <a href="{{ route('template.documentation.layouts.sources') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-3">
                            <span class="fw-medium"><i class="ti ti-code text-success me-2"></i> Plugin Sources & Credits</span>
                            <i class="ti ti-chevron-right text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
