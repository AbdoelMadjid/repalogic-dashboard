<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>404 Error | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
        <meta name="keywords" content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
        <meta name="author" content="WebAppLayers" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
 <!-- Theme Config Js -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Vendor css -->
<link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <div class="auth-box overflow-hidden align-items-center d-flex">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-md-6 col-sm-8">
                        <div class="auth-brand text-center mb-3">
                            <a href="{{ asset('index.html') }}" class="logo-dark">
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                            </a>
                            <a href="{{ asset('index.html') }}" class="logo-light">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </a>
                        </div>

                        <div class="p-2 text-center">
                            <img src="{{ asset('assets/images/svg/404.svg') }}" alt="404" class="img-fluid" />
                            <h3 class="fw-bold text-uppercase">Page Not Found</h3>
                            <p class="text-muted">The page you’re looking for doesn’t exist or has been moved.</p>

                            <button class="btn btn-primary mt-3 rounded-pill" onclick="window.location.href = 'index.html'">Go Home</button>
                        </div>

                        <p class="text-center text-muted mt-5 mb-0">
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
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

    </body>
</html>
