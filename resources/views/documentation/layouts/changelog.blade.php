@extends('layouts.vertical', ['title' => 'Changelog'])

@section('css')
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Changelog'])

    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title fs-20">Changelog</h3>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <h4>
                        <span class="text-primary">4.2.0</span>
                        <span class="sub-header"> - 5 June 2025</span>
                    </h4>

                    <ul class="changlog-list mb-0">
                        <li>
                            Seed Project Issue Fix
                        </li>
                    </ul>
                </div>


                <div class="mb-3">
                    <h4>
                        <span class="text-primary">4.1.0</span>
                        <span class="sub-header"> - 25 May 2025</span>
                    </h4>

                    <ul class="changlog-list mb-0">
                        <li>
                            Laravel version added
                        </li>
                    </ul>
                </div>

                <h4>
                    <span class="text-primary">1.0.0</span>
                    <span class="sub-header"> - 21 May 2014</span>
                </h4>

                <ul class="changlog-list mb-0">
                    <li>
                        Initial released
                    </li>
                </ul>
            </div>
        </div>
        <!--end card-->

    </div>
@endsection

@section('scripts')
@endsection
