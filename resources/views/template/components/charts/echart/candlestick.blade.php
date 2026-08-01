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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Basic Candlestick Chart</h4>
                </div>
                <div class="card-body">
                    <div id="chart-basic-candlestick" style="min-height: 400px"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Mixed Candlestick Chart</h4>
                </div>
                <div class="card-body">
                    <div id="chart-mixed-candlestick" style="min-height: 400px"></div>
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
    <script src="{{ asset('assets/js/pages/chart-echart-candlestick.js') }}"></script>
@endsection
