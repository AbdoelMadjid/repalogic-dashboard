<!DOCTYPE html>

<html @yield('html_attribute') lang="en">

<head>
    @include('layouts.partials/title-meta')

    @yield('styles')

    @include('layouts.partials/head-css')

</head>

<body @yield('body_attribute')>

    @yield('content')

    @yield('scripts')
    @include('layouts.partials/back-to-top')

</body>

</html>
