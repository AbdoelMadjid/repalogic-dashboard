<!DOCTYPE html>

@php
    $htmlAttributeSection = trim($__env->yieldContent('html_attribute'));
    $htmlAttributes = str_contains($htmlAttributeSection, 'class=')
        ? $htmlAttributeSection
        : trim('class="sidebar-with-line" ' . $htmlAttributeSection);
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! $htmlAttributes !!}>

    <head>
        @include('layouts.partials/title-meta')

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

        @include('layouts.partials/footer-scripts')

    </body>

</html>
