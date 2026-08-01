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
                    <h4 class="card-title mb-0">Basic Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-pie-basic" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Doughnut Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-doughnut-pie-basic" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Doughnut Rounded Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-doughnut-rounded-pie-basic" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Multiple Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-pie-multiple-chart" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pie Label Align Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-pie-label-align-chart" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Nightingale Map</h4>
                </div>
                <div class="card-body">
                    <div id="echart-pie-nightingale-chart" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pie Edge Align Chart</h4>
                </div>
                <div class="card-body">
                    <div id="echart-pie-edge-align-chart" style="min-height: 300px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    </div>
    <!-- container -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-echart-pie.js') }}"></script>
@endsection
