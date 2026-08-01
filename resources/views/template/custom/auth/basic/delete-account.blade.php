@extends('layouts.base')

@section('content')
    <div class="auth-box overflow-hidden align-items-center d-flex">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-md-6 col-sm-8">
                    <div class="auth-brand text-center mb-4">
                        <a href="{{ asset('index.html') }}" class="logo-dark">
                            <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                        </a>
                        <a href="{{ asset('index.html') }}" class="logo-light">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                        </a>
                    </div>

                    <div class="card p-4">
                        <div class="mb-4">
                            <div class="avatar-xxl mx-auto mt-2">
                                <div class="avatar-title bg-light-subtle border border-light border-dashed rounded-circle">
                                    <img src="{{ asset('assets/images/delete.png') }}" alt="dark logo" height="64" />
                                </div>
                            </div>
                        </div>

                        <h4 class="fw-bold text-center mb-3">Account Deactivated</h4>
                        <p class="text-muted text-center mb-4">Your account is currently inactive. Reactivate now to regain
                            access to all features and opportunities.</p>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">Reactivate Now</button>
                        </div>
                    </div>

                    <p class="text-center text-muted mt-4 mb-0">
                        ©
                        <span data-current-year></span>
                        Inspinia — by
                        <span class="fw-bold">WebAppLayers</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- end auth-fluid-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
