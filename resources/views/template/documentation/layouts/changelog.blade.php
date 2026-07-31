@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-primary bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-primary fw-semibold px-3 py-1.5 rounded-pill mb-3">Version Release History</span>
                    <h2 class="fw-bold text-white mb-2">Changelog & Update History</h2>
                    <p class="text-white-50 fs-16 mb-0">Track all major features, layout updates, bug fixes, and library upgrades across releases.</p>
                </div>
            </div>
        </div>

        <!-- Release Timeline -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-body p-4">
                    <div class="timeline timeline-icon-bordered">
                        <!-- Release v4.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-star-filled fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 w-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-0">v4.0.0 <span class="badge bg-success-subtle text-success fs-xs ms-2">Latest Release</span></h5>
                                    <span class="text-muted fs-12">July 2026</span>
                                </div>
                                <ul class="text-muted fs-14 mb-0 ps-3">
                                    <li>Upgraded core framework to <strong>Laravel 12</strong> & <strong>Bootstrap 5.3.8</strong>.</li>
                                    <li>Implemented dynamic menu configuration schema (`config/sidenav-template/*.php`).</li>
                                    <li>Added auto-scroll centering script for active sidebar sub-menu items.</li>
                                    <li>Refactored documentation pages into modern responsive layouts.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Release v3.5.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3 w-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-0">v3.5.0</h5>
                                    <span class="text-muted fs-12">March 2026</span>
                                </div>
                                <ul class="text-muted fs-14 mb-0 ps-3">
                                    <li>Added ApexCharts & ECharts interactive dashboard widgets.</li>
                                    <li>Introduced 6 built-in SCSS theme skins (`_themes-classic.scss`, `_themes-saas.scss`, etc.).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
