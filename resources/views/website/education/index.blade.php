<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>@yield('title', ($appProfil->app_name ?? 'REPALOGIC') . ' - Education Portal')</title>

    @include('website.education.partials._css')
    @yield('styles')
</head>

<body>
    <main>
        <!-- Header -->
        @include('website.education.partials._header')

        <!-- Main Content Section -->
        @hasSection('content')
            @yield('content')
        @else
            <div class="container py-5">
                <p class="text-muted text-center">Silakan pilih konten halaman pendidikan.</p>
            </div>
        @endif

        <!-- Footer -->
        @include('website.education.partials._footer')
    </main>

    <!-- JS Scripts -->
    @include('website.education.partials._js')
    @yield('scripts')
</body>

</html>
