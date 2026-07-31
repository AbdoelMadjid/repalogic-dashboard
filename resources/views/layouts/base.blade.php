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

</body>

</html>
