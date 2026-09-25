<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>{{ $appProfil->app_name ?? 'REPALOGIC Dashboard' }} - Landing Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description"
            content="{{ $appProfil->meta_description ?? 'Inspinia Admin Dashboard & Management System' }}" />
        <meta name="keywords" content="{{ $appProfil->meta_keywords ?? 'admin, dashboard, repalogic, php, laravel' }}" />
        <meta name="author" content="{{ $appProfil->meta_author ?? 'WebAppLayers' }}" />

        <!-- App Favicon -->
        @if ($appProfil && !empty($appProfil->favicon) && Storage::disk('public')->exists($appProfil->favicon))
            <link rel="shortcut icon" href="{{ asset('storage/' . $appProfil->favicon) }}" />
        @else
            <link rel="shortcut icon" href="{{ asset('assets_default/images/favicon.ico') }}" />
        @endif

        @php
            $themeFolder = $activeWebsiteTheme->folder ?? 'default';
        @endphp

        @if (view()->exists("website.{$themeFolder}.partials._css"))
            @include("website.{$themeFolder}.partials._css")
        @else
            @include('website.default.partials._css')
        @endif
    </head>

    <body class="bg-body-secondary" data-bs-spy="scroll" data-bs-target="#navbar-example">
        <!-- Top Alert -->
        <!-- @if (view()->exists("website.{$themeFolder}.partials._top-alert"))
            @include("website.{$themeFolder}.partials._top-alert")
        @else
            @include('website.default.partials._top-alert')
        @endif -->

        <!-- Header START -->
        @if (view()->exists("website.{$themeFolder}.partials._header"))
            @include("website.{$themeFolder}.partials._header")
        @else
            @include('website.default.partials._header')
        @endif
        <!-- Header END -->

        <!-- ======================= DYNAMIC LANDING SECTIONS ======================= -->
        @if ($activeWebsiteTheme && $activeWebsiteSections->isNotEmpty())
            @foreach ($activeWebsiteSections as $sec)
                @php
                    $folder = $activeWebsiteTheme->folder;
                    $cleanFile = str_replace('.blade.php', '', $sec->section_file);
                    $viewPath = "website.{$folder}.{$cleanFile}";

                    $bgType = $sec->bg_type ?? 'default';
                    $bgClass = $sec->bg_color_class ?? '';
                    $bgStyle = '';

                    if ($bgType === 'image' && !empty($sec->bg_image) && Storage::disk('public')->exists($sec->bg_image)) {
                        $posY = $sec->bg_position_y ?? 50;
                        $bgSize = $sec->bg_size ?? 'cover';
                        $bgAttach = $sec->bg_attachment ?? 'scroll';

                        $bgStyle = 'background-image: url("' . asset('storage/' . $sec->bg_image) . '"); '
                                 . 'background-position: center ' . $posY . '% !important; '
                                 . 'background-size: ' . $bgSize . ' !important; '
                                 . 'background-attachment: ' . $bgAttach . ' !important;';
                        if (empty($bgClass)) {
                            $bgClass = 'website-section-bg-image text-white';
                        }
                    }
                @endphp
                @if (view()->exists($viewPath))
                    <!-- Section: {{ $sec->section_name }} -->
                    @if (!empty($bgClass) || !empty($bgStyle))
                        <div class="website-section-bg-wrapper {{ $bgClass }}" style="{{ $bgStyle }}">
                            @include($viewPath)
                        </div>
                    @else
                        @include($viewPath)
                    @endif
                @endif
            @endforeach
        @else
            <!-- Fallback Static Includes -->
            @include('website.default.section-hero')
            @include('website.default.section-service')
            @include('website.default.section-features')
            @include('website.default.section-plans')
            @include('website.default.section-cta')
            @include('website.default.section-reviews')
            @include('website.default.section-blog')
            @include('website.default.section-contact')
        @endif
        <!-- ======================= DYNAMIC LANDING SECTIONS END ======================= -->

        <!-- ======================= FOOTER SECTION ======================= -->
        @if (view()->exists("website.{$themeFolder}.partials._footer"))
            @include("website.{$themeFolder}.partials._footer")
        @else
            @include('website.default.partials._footer')
        @endif
        <!-- ======================= FOOTER SECTION END ======================= -->


        @if (view()->exists("website.{$themeFolder}.partials._js"))
            @include("website.{$themeFolder}.partials._js")
        @else
            @include('website.default.partials._js')
        @endif

        @if (view()->exists("website.{$themeFolder}.partials._back-to-top"))
            @include("website.{$themeFolder}.partials._back-to-top")
        @else
            @include('website.default.partials._back-to-top')
        @endif
    </body>

</html>
