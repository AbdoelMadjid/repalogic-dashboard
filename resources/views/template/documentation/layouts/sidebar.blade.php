@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-info bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-info fw-semibold px-3 py-1.5 rounded-pill mb-3">Sidebar
                        Customization</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="sidebars-option">Sidebar Options & Modes</h2>
                    <p class="text-white-50 fs-16 mb-0">Explore the full range of sidebar themes, sizes, hover modes, and
                        line styles available in INSPINIA.</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Modes Grid -->
        <div class="col-12 mb-4">
            <h4 class="fw-bold mb-3">Available Sidebar Variants</h4>
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-layout-sidebar font-weight-bold"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Light Sidebar</h6>
                                <code>class="sidebar-light"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Clean white sidebar background with high-contrast menu items.</p>
                        <a href="{{ route('template.layouts.sidebars.light') }}" target="_blank"
                            class="btn btn-sm btn-soft-primary w-100 mt-auto"><i class="ti ti-external-link me-1"></i>
                            Preview Light Sidebar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-color-filter"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Gradient Sidebar</h6>
                                <code>class="sidebar-gradient"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Vibrant gradient background accentuating menu headers and active
                            links.</p>
                        <a href="{{ route('template.layouts.sidebars.gradient') }}" target="_blank"
                            class="btn btn-sm btn-soft-warning w-100 mt-auto"><i class="ti ti-external-link me-1"></i>
                            Preview Gradient Sidebar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-secondary-subtle text-secondary rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-layout-sidebar-left-collapse"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Compact / Icon Only</h6>
                                <code>data-sidenav-size="compact"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Narrow sidebar displaying icon links that expand on hover.</p>
                        <a href="{{ route('template.layouts.sidebars.compact') }}" target="_blank"
                            class="btn btn-sm btn-soft-secondary w-100 mt-auto"><i class="ti ti-external-link me-1"></i>
                            Preview Compact Sidebar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-click"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">On-Hover Expand</h6>
                                <code>data-sidenav-size="on-hover"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Automatically expands sidebar from collapsed icon state when cursor
                            hovers.</p>
                        <a href="{{ route('template.layouts.sidebars.on-hover') }}" target="_blank"
                            class="btn btn-sm btn-soft-success w-100 mt-auto"><i class="ti ti-external-link me-1"></i>
                            Preview On-Hover Sidebar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-layout-offcanvas"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Offcanvas Drawer</h6>
                                <code>data-sidenav-size="offcanvas"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Hides sidebar completely offscreen, toggled via hamburger topbar
                            button.</p>
                        <a href="{{ route('template.layouts.sidebars.offcanvas') }}" target="_blank"
                            class="btn btn-sm btn-soft-danger w-100 mt-auto"><i class="ti ti-external-link me-1"></i>
                            Preview Offcanvas Sidebar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div
                                class="avatar-md bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center fs-20">
                                <i class="ti ti-line"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">With Lines Divider</h6>
                                <code>class="sidebar-with-line"</code>
                            </div>
                        </div>
                        <p class="text-muted fs-13 mb-3">Adds crisp vertical guide lines connecting nested sub-menu items.
                        </p>
                        <a href="{{ route('template.layouts.sidebars.with-lines') }}" target="_blank"
                            class="btn btn-sm btn-soft-info w-100 mt-auto"><i class="ti ti-external-link me-1"></i> Preview
                            With Lines</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
