@extends('layouts.vertical')

@section('html_attribute')
    data-sidenav-size="compact"
@endsection

@section('content')
    @include('layouts.partials.page-title')



    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-bordered border-start border-info d-flex align-items-start gap-2">
                <i class="ti ti-info-circle fs-xxl"></i>
                <div>
                    To enable the medium-sized (compact) sidebar, add
                    <code>data-sidenav-size="compact"</code>
                    to the
                    <code>&lt;html&gt;</code>
                    tag.
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="m-0">Your custom content here</h4>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->
@endsection
