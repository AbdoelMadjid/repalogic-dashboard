<header>
    <!-- Nav START -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top" id="landing-navbar">
        <div class="container">
            <div class="auth-brand mb-0">
                <a href="/" class="logo-dark">
                    <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" height="32" />
                </a>
                <a href="/" class="logo-light">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="32" />
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav fw-medium gap-2 fs-sm mx-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#plans">Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reviews">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>

                <div>
                    <button class="btn btn-link btn-icon fw-semibold text-body" type="button" id="theme-toggle"><i
                            class="ti ti-contrast fs-22"></i></button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-link fw-semibold text-body ps-2">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link fw-semibold text-body ps-2">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-sm btn-primary">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                    {{-- <a href="{{ asset('auth-sign-in.html') }}" class="btn btn-link fw-semibold text-body ps-2">SIGN IN</a>
                        <a href="{{ asset('auth-sign-up.html') }}" class="btn btn-sm btn-primary">Sign Up</a> --}}
                </div>
            </div>
            <!-- end .navbar-collapse-->
        </div>
        <!-- end container-->
    </nav>
    <!-- Nav END -->
</header>
