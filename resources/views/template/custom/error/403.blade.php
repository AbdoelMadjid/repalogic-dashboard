@extends('layouts.base')

@section('content')
    <div class="auth-box p-0 w-100">
        <div class="row w-100 g-0">
            <div class="col">
                <div class="h-100 position-relative card-side-img rounded-0 overflow-hidden"
                    style="background-image: url('{{ asset('assets/images/auth.jpg') }}')">
                    <div class="p-4 card-img-overlay auth-overlay d-flex align-items-end justify-content-center"></div>
                </div>
            </div>
            <div class="col-xl-auto">
                <!--Auth Box content -->
                <div class="card auth-box-form border-0 mb-0">
                    <div class="card-body min-vh-100 d-flex flex-column justify-content-center">
                        <div class="auth-brand text-center">
                            <a href="{{ asset('index.html') }}" class="logo-dark">
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo">
                            </a>
                            <a href="{{ asset('index.html') }}" class="logo-light">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                            </a>
                        </div>

                        <div class="p-2 text-center mt-auto">
                            <div class="error-glitch" data-text="403">403</div>
                            <h3 class="fw-bold text-uppercase">Forbidden</h3>
                            <p class="text-muted">You don't have permission to access this resource.</p>

                            <button class="btn btn-primary mt-3 rounded-pill"
                                onclick="window.location.href = 'index.html'">Go Home</button>
                        </div>

                        <p class="text-center text-muted mt-auto mb-0">
                            ©
                            <span data-current-year=""></span>
                            Inspinia — by
                            <span class="fw-bold">WebAppLayers</span>
                        </p>
                    </div>
                </div>
                <!-- End Auth Box Content -->
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>


    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
