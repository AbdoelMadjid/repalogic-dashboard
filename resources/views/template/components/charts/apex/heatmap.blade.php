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
                                    <h4 class="card-title">Heatmap - Single Series</h4>
                                </div>

                                <div class="card-body">
                                    <div dir="ltr">
                                        <div id="basic-heatmap" class="apex-charts"></div>
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
                                    <h4 class="card-title">Multiple Series</h4>
                                </div>

                                <div class="card-body">
                                    <div dir="ltr">
                                        <div id="multiple-series-heatmap" class="apex-charts"></div>
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
                                    <h4 class="card-title">Heatmap - Color Range</h4>
                                </div>

                                <div class="card-body">
                                    <div dir="ltr">
                                        <div id="color-range-heatmap" class="apex-charts"></div>
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
                                    <h4 class="card-title">Heatmap - Range without Shades</h4>
                                </div>

                                <div class="card-body">
                                    <div dir="ltr">
                                        <div id="rounded-heatmap" class="apex-charts"></div>
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/chart-apex-heatmap.js') }}"></script>
@endsection
