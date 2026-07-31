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
                                    <h4 class="card-title mb-0">Basic Radar Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-basic-radar" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Proportion of Browsers</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-radar1" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Customized Radar Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-radar2" style="min-height: 300px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Multiple Radar Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-radar3" style="min-height: 300px"></div>
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
    <script src="{{ asset('assets/js/pages/chart-echart-radar.js') }}"></script>
@endsection
