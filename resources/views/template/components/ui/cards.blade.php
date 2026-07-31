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


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Examples</h4>
                        </div>

                        <div class="card-body">
                            <p class="text-muted mb-2">Bootstrap’s cards provide a flexible and extensible content container with multiple variants and options.</p>

                            <a class="btn btn-link p-0 fw-semibold" href="https://getbootstrap.com/docs/5.3/components/card/" target="_blank">
                                Cards on Bootstrap
                                <i class="ti ti-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <!-- Simple card -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up.</p>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-primary">Button</a>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-6 col-lg-3">
                            <!-- Simple card -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-2">Basic Card with Title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up.</p>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-primary">Button</a>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-6 col-lg-3">
                            <!-- Simple card -->
                            <div class="card text-bg-primary border-0">
                                <div class="card-body">
                                    <h5 class="card-title mb-2">Card with Background Color</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up.</p>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-light">Button</a>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-6 col-lg-3">
                            <!-- Simple card -->
                            <div class="card text-bg-purple bg-gradient">
                                <div class="card-body">
                                    <h5 class="card-title mb-2">Card with Background Gradient</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up.</p>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-light">Button</a>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <h5 class="card-header">Card with Header</h5>
                                <div class="card-body">
                                    <h5 class="card-title mb-2">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-primary">Go somewhere</a>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header d-block">
                                    <h5 class="card-title mb-1">Card with Sub Header</h5>

                                    <h6 class="card-subtitle text-body-secondary">Card subtitle</h6>
                                </div>

                                <div class="card-body">
                                    <blockquote class="card-bodyquote mb-0">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
    </div>
@endsection
