@extends('layouts.vertical')

@section('styles')
    <!-- App favicon -->
    <!-- Theme Config Js -->
    <!-- Vendor css -->
    <!-- App css -->
@endsection

@section('content')
    @include('layouts.partials.page-title')


    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Polar Area Chart</h4>
                </div>
                <div class="card-body">
                    <div dir="ltr">
                        <div id="basic-polar-area" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Monochrome Polar Area</h4>
                </div>
                <div class="card-body">
                    <div dir="ltr">
                        <div id="monochrome-polar-area" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->
    </div>
    <!-- container -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-apex-polar-area.js') }}"></script>
@endsection
