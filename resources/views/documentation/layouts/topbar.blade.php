@extends('layouts.vertical', ['title' => 'Topbar Option'])

@section('css')
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Topbar Option'])

    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Topbar Option</h4>
            </div>

            <div class="card-body">
                <!-- Dark Topbar -->
                <div class="alert alert-purple alert-bordered border-start border-purple d-flex align-items-center gap-2">
                    <i class="ti ti-info-circle fs-xxl"></i>
                    <div>
                        To enable the dark topbar, add
                        <code>data-topbar-color="dark"</code> to the
                        <code>&lt;html&gt;</code> tag in your layout.
                    </div>
                    <a href="https://webapplayers.com/inspinia/classic/topbar-dark.html" target="_blank"
                        class="btn btn-dark ms-auto">
                        Preview <i class="ti ti-external-link fs-14 ms-2"></i>
                    </a>
                </div>

                <!-- Gray Topbar -->
                <div class="alert alert-purple alert-bordered border-start border-purple d-flex align-items-center gap-2">
                    <i class="ti ti-info-circle fs-xxl"></i>
                    <div>
                        To enable the gray topbar, add
                        <code>data-topbar-color="gray"</code> to the
                        <code>&lt;html&gt;</code> tag in your layout.
                    </div>
                    <a href="https://webapplayers.com/inspinia/classic/topbar-gray.html" target="_blank"
                        class="btn btn-dark ms-auto">
                        Preview <i class="ti ti-external-link fs-14 ms-2"></i>
                    </a>
                </div>

                <!-- Gradient Topbar -->
                <div
                    class="alert alert-purple alert-bordered border-start border-purple d-flex align-items-center gap-2 mb-0">
                    <i class="ti ti-info-circle fs-xxl"></i>
                    <div>
                        To enable the gradient topbar, add
                        <code>data-topbar-color="gradient"</code> to the
                        <code>&lt;html&gt;</code> tag in your layout.
                    </div>
                    <a href="https://webapplayers.com/inspinia/classic/topbar-gradient.html" target="_blank"
                        class="btn btn-dark ms-auto">
                        Preview <i class="ti ti-external-link fs-14 ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
