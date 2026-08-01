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
                        <p class="text-muted w-lg-75 mt-3 mx-auto">Awesome! You’ve read the important message like a pro.
                        </p>
                    </div>

                    <div class="card p-4">
                        <form>
                            <div class="mb-4">
                                <div class="avatar-xxl mx-auto mt-2">
                                    <div
                                        class="avatar-title bg-light-subtle border border-light border-dashed rounded-circle">
                                        <img src="{{ asset('assets/images/checkmark.png') }}" alt="dark logo"
                                            height="64" />
                                    </div>
                                </div>
                            </div>

                            <h4 class="fw-bold text-center mb-4">Well Done! Email verified Successfully</h4>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold py-2">Back to Dashboard</button>
                            </div>
                        </form>
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
