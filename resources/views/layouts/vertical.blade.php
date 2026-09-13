<!DOCTYPE html>

@php
    $htmlAttributeSection = trim($__env->yieldContent('html_attribute'));
    $htmlAttributes = $htmlAttributeSection;
    if (!str_contains($htmlAttributes, 'class=')) {
        $htmlAttributes = trim('class="sidebar-with-line" ' . $htmlAttributes);
    }
    if (!str_contains($htmlAttributes, 'data-menu-color=')) {
        $htmlAttributes = trim('data-menu-color="gradient" ' . $htmlAttributes);
    }
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! $htmlAttributes !!}>

<head>
    @include('layouts.partials/title-meta')

    @yield('css')
    @yield('styles')

    @include('layouts.partials/head-css')
</head>

<body>
    <div class="wrapper">

        @include('layouts.partials/topbar')

        @include('layouts.partials/sidenav')

        <div class="content-page">
            <div class="container-fluid">

                @yield('content')

            </div>

            @include('layouts.partials/footer')

        </div>

        @include('layouts.partials/customizer')

    </div>

    @include('layouts.partials/notifications')
    @include('layouts.partials/footer-scripts')
    @include('layouts.partials.lock-screen-modal')
    @include('layouts.partials/back-to-top')

</body>

</html>
