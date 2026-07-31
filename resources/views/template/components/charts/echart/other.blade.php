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
                                <div class="card-header border-0">
                                    <h4 class="card-title mb-0">Pictorialbar Dotted Chart</h4>
                                </div>
                                <div class="card-body p-2 pt-0">
                                    <div id="echart-pictorialbar-dotted" class="rounded-3 overflow-hidden" style="min-height: 400px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Basic Sunburst Chart</h4>
                                </div>
                                <div class="card-body p-2 pt-0">
                                    <div id="echar-basic-sunburst" style="min-height: 399px"></div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Nested Pie Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-pie-nest" style="min-height: 600px"></div>
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
    <script src="{{ asset('assets/js/pages/chart-echart-other.js') }}"></script>
@endsection
