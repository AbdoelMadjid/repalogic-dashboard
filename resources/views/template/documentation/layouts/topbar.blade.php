@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-secondary bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-secondary fw-semibold px-3 py-1.5 rounded-pill mb-3">Header Navigation</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="topbar-option">Topbar Options & Color Themes</h2>
                    <p class="text-white-50 fs-16 mb-0">Customize topbar headers with dark, light, gray, or gradient themes.</p>
                </div>
            </div>
        </div>

        <!-- Topbar Color Variants -->
        <div class="col-12 mb-4">
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-1">Dark Topbar</h6>
                        <p class="text-muted fs-13 mb-3">Sleek dark topbar container with high-contrast text and icons.</p>
                        <code>data-topbar-color="dark"</code>
                        <a href="{{ route('template.layouts.topbar.dark') }}" target="_blank" class="btn btn-sm btn-dark w-100 mt-3"><i class="ti ti-external-link me-1"></i> Preview Dark Topbar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-1">Gray Topbar</h6>
                        <p class="text-muted fs-13 mb-3">Subtle cool gray background offering elegant separation from main body content.</p>
                        <code>data-topbar-color="gray"</code>
                        <a href="{{ route('template.layouts.topbar.gray') }}" target="_blank" class="btn btn-sm btn-secondary w-100 mt-3"><i class="ti ti-external-link me-1"></i> Preview Gray Topbar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card border h-100 p-3">
                        <h6 class="fw-bold mb-1">Gradient Topbar</h6>
                        <p class="text-muted fs-13 mb-3">Vibrant multi-color gradient header background.</p>
                        <code>data-topbar-color="gradient"</code>
                        <a href="{{ route('template.layouts.topbar.gradient') }}" target="_blank" class="btn btn-sm btn-primary w-100 mt-3"><i class="ti ti-external-link me-1"></i> Preview Gradient Topbar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
