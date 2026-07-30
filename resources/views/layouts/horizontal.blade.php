<!DOCTYPE html>

<html @yield('html_attribute') data-layout="topnav">

<head>
    @include('layouts.partials/title-meta')

    @yield('styles')

    @include('layouts.partials/head-css')
</head>

<body>
    <div class="wrapper">

        @include('layouts.partials/topbar')

        @include('layouts.partials/horizontal-nav')

        <div class="content-page">
            <div class="container-fluid">

                @yield('content')

            </div>

            @include('layouts.partials/footer')

        </div>

        @include('layouts.partials/customizer')

    </div>

    @yield('scripts')

</body>

</html>
