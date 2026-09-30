@extends('layouts.vertical')

@section('styles')
    <!-- App favicon -->
    <!-- Theme Config Js -->
    <!-- Vendor css -->
    <!-- App css -->
@endsection

@section('content')
    @include('layouts.partials.page-title')

    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <div class="card-header d-block">
                    <h4 class="card-title mb-1 d-flex align-items-center gap-2">
                        <i data-lucide="layout-dashboard" class="fs-xl"></i>
                        Overview
                    </h4>
                    <p class="mb-0 text-muted">Lucide is an open-source library of clean, scalable SVG icons for web and app
                        development, offering easy integration and customization.</p>
                </div>

                <div class="card-body">
                    <h4 class="mt-0 fs-base mb-1">Usage</h4>
                    <code>&lt;i data-lucide=&quot;xxx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i data-lucide="camera" class="fs-3"></i>
                        <i data-lucide="heart" class="fs-3"></i>
                        <i data-lucide="star" class="fs-3"></i>
                        <i data-lucide="check" class="fs-3"></i>
                        <i data-lucide="bell" class="fs-3"></i>
                        <i data-lucide="cloud" class="fs-3"></i>
                        <i data-lucide="user" class="fs-3"></i>
                    </div>
                </div>
                <!-- end card-body-->
                <div class="card-body border-top border-dashed">
                    <h4 class="mt-0 fs-base mb-1">Colors</h4>
                    <code>&lt;i data-lucide=&quot;xxx&quot; class=&quot;text-xx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i data-lucide="home" class="fs-3 text-primary"></i>
                        <i data-lucide="settings" class="fs-3 text-secondary"></i>
                        <i data-lucide="calendar" class="fs-3 text-success"></i>
                        <i data-lucide="message-circle" class="fs-3 text-info"></i>
                        <i data-lucide="flag" class="fs-3 text-warning"></i>
                        <i data-lucide="folder" class="fs-3 text-danger"></i>
                        <i data-lucide="globe" class="fs-3 text-light"></i>
                        <i data-lucide="key" class="fs-3 text-dark"></i>
                        <i data-lucide="layers" class="fs-3 text-purple"></i>
                    </div>
                </div>

                <div class="card-body border-top border-dashed">
                    <h4 class="mt-0 fs-base mb-1">Fill Colors</h4>
                    <code>&lt;i data-lucide=&quot;xxx&quot; class=&quot;text-xx fill-xx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i data-lucide="star" class="fs-3 text-primary fill-primary"></i>
                        <i data-lucide="user" class="fs-3 text-secondary fill-secondary"></i>
                        <i data-lucide="check-circle" class="fs-3 text-success fill-success"></i>
                        <i data-lucide="bell" class="fs-3 text-info fill-info"></i>
                        <i data-lucide="alert-triangle" class="fs-3 text-warning fill-warning"></i>
                        <i data-lucide="file-text" class="fs-3 text-danger fill-danger"></i>
                        <i data-lucide="airplay" class="fs-3 text-light fill-light"></i>
                        <i data-lucide="lock" class="fs-3 text-dark fill-dark"></i>
                        <i data-lucide="database" class="fs-3 text-purple fill-purple"></i>
                    </div>
                </div>

                <div class="card-body border-top border-dashed">
                    <h4 class="mt-0 fs-base mb-1">Sizes</h4>
                    <code>&lt;i class=&quot;ti ti-xxxx fs-xx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i data-lucide="phone" class="fs-1"></i>
                        <i data-lucide="badge-dollar-sign" class="fs-2"></i>
                        <i data-lucide="monitor" class="fs-3"></i>
                        <i data-lucide="tablet" class="fs-4"></i>
                        <i data-lucide="gamepad-2" class="fs-5"></i>
                        <i data-lucide="watch" class="fs-6"></i>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i data-lucide="watch"></i>
                        <i data-lucide="watch" class="fs-sm"></i>
                        <i data-lucide="watch" class="fs-lg"></i>
                        <i data-lucide="watch" class="fs-xl"></i>
                        <i data-lucide="watch" class="fs-xxl"></i>
                        <i data-lucide="watch" class="fs-24"></i>
                        <i data-lucide="watch" class="fs-32"></i>
                        <i data-lucide="watch" class="fs-36"></i>
                        <i data-lucide="watch" class="fs-42"></i>
                        <i data-lucide="watch" class="fs-60"></i>
                    </div>
                </div>
                <!-- end card-body-->

                @include('template.components.icons.partials._lucide_grid')
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->
@endsection
