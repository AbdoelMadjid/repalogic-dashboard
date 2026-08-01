@extends('layouts.vertical')

@section('styles')
    <link href="{{ asset('assets/plugins/jstree/style.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Overview Banner -->
        <div class="col-12 mb-4">
            <div class="card border-0 text-white bg-primary bg-gradient shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-white text-primary fw-semibold px-2.5 py-1">Laravel 12 Architecture</span>
                                <span class="badge bg-white bg-opacity-20 text-white fw-medium px-2.5 py-1">Bootstrap 5.3</span>
                                <span class="badge bg-white bg-opacity-20 text-white fw-medium px-2.5 py-1">Vite Built</span>
                            </div>
                            <h3 class="fw-bold text-white mb-2">Repalogic & INSPINIA Folder Structure</h3>
                            <p class="text-white-50 mb-0 fs-15">
                                Clean, modular, and enterprise-ready directory architecture designed for fast navigation, scalability, and easy maintenance.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Column: Interactive Tree Explorer -->
        <div class="col-xl-7 col-lg-6 mb-4">
            <div class="card h-100 border">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-sitemap fs-20 text-primary"></i>
                        <h5 class="card-title mb-0 fw-bold" data-lang="doc-interactive-tree">Interactive Directory Tree</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1">Project Root</span>
                </div>
                <div class="card-body p-4">
                    <!-- Tree Container -->
                    <div id="jstree-1">
                        <ul>
                            <!-- app -->
                            <li data-jstree='{ "opened" : true }'>
                                app
                                <ul>
                                    <li>Console</li>
                                    <li>Exceptions</li>
                                    <li data-jstree='{ "opened" : true }'>
                                        Http
                                        <ul>
                                            <li>Controllers</li>
                                            <li>Middleware</li>
                                            <li>Requests</li>
                                        </ul>
                                    </li>
                                    <li>Models</li>
                                    <li>Providers</li>
                                </ul>
                            </li>

                            <!-- bootstrap -->
                            <li>bootstrap</li>

                            <!-- config -->
                            <li data-jstree='{ "opened" : true }'>
                                config
                                <ul>
                                    <li data-jstree='{ "opened" : true, "selected" : true }'>
                                        <a href="javascript:;">sidenav-template</a>
                                        <ul>
                                            <li data-jstree='{ "type" : "file" }'>main.php</li>
                                            <li data-jstree='{ "type" : "file" }'>apps.php</li>
                                            <li data-jstree='{ "type" : "file" }'>custom-pages.php</li>
                                            <li data-jstree='{ "type" : "file" }'>layouts.php</li>
                                            <li data-jstree='{ "type" : "file" }'>components.php</li>
                                            <li data-jstree='{ "type" : "file" }'>documentation.php</li>
                                            <li data-jstree='{ "type" : "file" }'>menu-item.php</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{ "type" : "file" }'>app.php</li>
                                    <li data-jstree='{ "type" : "file" }'>database.php</li>
                                </ul>
                            </li>

                            <!-- public -->
                            <li data-jstree='{ "opened" : true }'>
                                public
                                <ul>
                                    <li data-jstree='{ "opened" : true }'>
                                        assets
                                        <ul>
                                            <li>css</li>
                                            <li>js</li>
                                            <li>images</li>
                                            <li>plugins</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{ "type" : "file" }'>index.php</li>
                                </ul>
                            </li>

                            <!-- resources -->
                            <li data-jstree='{ "opened" : true }'>
                                resources
                                <ul>
                                    <li>js</li>
                                    <li data-jstree='{ "opened" : true }'>
                                        scss
                                        <ul>
                                            <li data-jstree='{ "opened" : true }'>
                                                config
                                                <ul>
                                                    <li data-jstree='{ "type" : "file" }'>_themes-classic.scss</li>
                                                    <li data-jstree='{ "type" : "file" }'>_themes-material.scss</li>
                                                    <li data-jstree='{ "type" : "file" }'>_themes-modern.scss</li>
                                                    <li data-jstree='{ "type" : "file" }'>_themes-saas.scss</li>
                                                    <li data-jstree='{ "type" : "file" }'>_themes-minimal.scss</li>
                                                </ul>
                                            </li>
                                            <li>components</li>
                                            <li>pages</li>
                                            <li data-jstree='{ "type" : "file" }'>app.scss</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{ "opened" : true }'>
                                        views
                                        <ul>
                                            <li>layouts</li>
                                            <li data-jstree='{ "opened" : true }'>
                                                template
                                                <ul>
                                                    <li>main</li>
                                                    <li>apps</li>
                                                    <li>custom</li>
                                                    <li>layouts</li>
                                                    <li>components</li>
                                                    <li>documentation</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- routes -->
                            <li data-jstree='{ "opened" : true }'>
                                routes
                                <ul>
                                    <li data-jstree='{ "type" : "file" }'>web.php</li>
                                    <li data-jstree='{ "type" : "file" }'>template.php</li>
                                    <li data-jstree='{ "type" : "file" }'>auth.php</li>
                                </ul>
                            </li>

                            <!-- Root Files -->
                            <li data-jstree='{ "type" : "file" }'>.env.example</li>
                            <li data-jstree='{ "type" : "file" }'>composer.json</li>
                            <li data-jstree='{ "type" : "file" }'>package.json</li>
                            <li data-jstree='{ "type" : "file" }'>vite.config.js</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Key Directories Explained -->
        <div class="col-xl-5 col-lg-6 mb-4">
            <div class="d-flex flex-column gap-3">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-light-subtle">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fs-20">
                            <i class="ti ti-adjustments-horizontal"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">`config/sidenav-template/`</h6>
                            <p class="text-muted fs-13 mb-0">
                                Holds array schemas defining the dynamic sidebar and topbar navigation structure across all layout modes.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 p-3 bg-light-subtle">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-md bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fs-20">
                            <i class="ti ti-route"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">`routes/template.php`</h6>
                            <p class="text-muted fs-13 mb-0">
                                Automatically scans `views/template/` to register named dot-notation routes (`template.path.to.view`).
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 p-3 bg-light-subtle">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-md bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fs-20">
                            <i class="ti ti-layout"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">`resources/views/layouts/`</h6>
                            <p class="text-muted fs-13 mb-0">
                                Houses master layout templates (`vertical.blade.php`, `horizontal.blade.php`, `base.blade.php`) & partials.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 p-3 bg-light-subtle">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-md bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fs-20">
                            <i class="ti ti-folder-star"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">`resources/views/template/`</h6>
                            <p class="text-muted fs-13 mb-0">
                                Contains clean Blade views categorized into `main`, `apps`, `custom`, `layouts`, `components`, and `documentation`.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 p-3 bg-light-subtle">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-md bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fs-20">
                            <i class="ti ti-palette"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">`resources/scss/`</h6>
                            <p class="text-muted fs-13 mb-0">
                                Modular SCSS design system supporting 6 custom themes (`_themes-classic.scss`, `_themes-saas.scss`, etc.).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jstree/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins-treeview.js') }}"></script>
@endsection
