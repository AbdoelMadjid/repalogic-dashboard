@extends('layouts.vertical')

@section('styles')
    <!-- App favicon -->
    <!-- Theme Config Js -->
    <!-- Vendor css -->
    <!-- App css -->
@endsection

@section('content')
    <div class="container-fluid">
        @include('layouts.partials.page-title')


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Basic Gauge Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-basic-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Speed Stage Gauge Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-speed-stage-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Ring Gauge Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-ring-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Temperature Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-temperature-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Multi Ring Gauge Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-multiring-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Multi Gauge Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-multi-gauge" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- container -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-echart-gauge.js') }}"></script>
@endsection
