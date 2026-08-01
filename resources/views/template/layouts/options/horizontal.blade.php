@extends('layouts.horizontal')

@section('html_attribute')
    data-layout="topnav" data-topbar-color="dark" data-menu-color="light"
@endsection

@section('content')
    @include('layouts.partials.page-title')



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
