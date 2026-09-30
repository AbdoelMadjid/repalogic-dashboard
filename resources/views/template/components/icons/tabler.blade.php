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
                    <h4 class="card-title mb-1">Overview</h4>
                    <p class="mb-0 text-muted">Free and open source icons designed to make your website or app attractive,
                        visually consistent and simply beautiful.</p>
                </div>
                <!-- end card-header-->

                <div class="card-body">
                    <h4 class="mt-0 fs-base mb-1">Usage</h4>
                    <code>&lt;i class=&quot;ti ti-xxxx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i class="ti ti-phone fs-2"></i>
                        <i class="ti ti-ad-2 fs-2"></i>
                        <i class="ti ti-device-desktop fs-2"></i>
                        <i class="ti ti-device-tablet fs-2"></i>
                        <i class="ti ti-device-gamepad fs-2"></i>
                        <i class="ti ti-device-watch fs-2"></i>
                    </div>
                </div>
                <!-- end card-body-->
                <div class="card-body border-top border-dashed">
                    <h4 class="mt-0 fs-base mb-1">Colors</h4>
                    <code>&lt;i class=&quot;ti ti-xxxx text-xxxx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i class="ti ti-camera fs-2 text-primary"></i>
                        <i class="ti ti-chart-pie-2 fs-2 text-secondary"></i>
                        <i class="ti ti-bell fs-2 text-success"></i>
                        <i class="ti ti-credit-card fs-2 text-info"></i>
                        <i class="ti ti-cloud fs-2 text-warning"></i>
                        <i class="ti ti-mail fs-2 text-danger"></i>
                        <i class="ti ti-lock fs-2 text-dark"></i>
                        <i class="ti ti-user fs-2 text-purple"></i>
                        <i class="ti ti-star fs-2 text-light"></i>
                    </div>
                </div>

                <div class="card-body border-top border-dashed">
                    <h4 class="mt-0 fs-base mb-1">Sizes</h4>
                    <code>&lt;i data-lucide=&quot;xxx&quot; class=&quot;fs-xx&quot;&gt;&lt;/i&gt;</code>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i class="ti ti-phone fs-1"></i>
                        <i class="ti ti-ad-2 fs-2"></i>
                        <i class="ti ti-device-desktop fs-3"></i>
                        <i class="ti ti-device-tablet fs-4"></i>
                        <i class="ti ti-device-gamepad fs-5"></i>
                        <i class="ti ti-device-watch fs-6"></i>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <i class="ti ti-device-watch"></i>
                        <i class="ti ti-device-watch fs-sm"></i>
                        <i class="ti ti-device-watch fs-lg"></i>
                        <i class="ti ti-device-watch fs-xl"></i>
                        <i class="ti ti-device-watch fs-xxl"></i>
                        <i class="ti ti-device-watch fs-24"></i>
                        <i class="ti ti-device-watch fs-32"></i>
                        <i class="ti ti-device-watch fs-36"></i>
                        <i class="ti ti-device-watch fs-42"></i>
                        <i class="ti ti-device-watch fs-60"></i>
                    </div>
                </div>
                <!-- end card-body-->

                @include('template.components.icons.partials._tabler_grid')
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->
@endsection
