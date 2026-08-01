@extends('layouts.vertical')

@section('styles')
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @include('layouts.partials.page-title')


    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4 class="card-title">Example</h4>
                    <a href="https://datatables.net/examples/basic_init/data_rendering.html" target="_blank"
                        class="icon-link icon-link-hover link-primary fw-semibold">
                        View Docs
                        <i class="ti ti-arrow-right bi align-middle fs-lg"></i>
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                        <strong>Note:</strong>
                        This is a jQuery-based plugin, so you need to include jQuery for it to work.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <table id="datatable-rendering" class="table table-striped dt-responsive align-middle mb-0">
                        <thead class="thead-sm text-uppercase fs-xxs">
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Progress</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
    </div>
    </div>
    <!-- container -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables-rendering.js') }}"></script>
@endsection
