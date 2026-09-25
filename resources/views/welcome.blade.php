@php
    $themeFolder = $activeWebsiteTheme->folder ?? 'default';

    if ($themeFolder === 'education') {
        $themeView = view()->exists("website.education.home-page-1")
            ? "website.education.home-page-1"
            : "website.education.index";
    } elseif (view()->exists("website.{$themeFolder}.index")) {
        $themeView = "website.{$themeFolder}.index";
    } else {
        $themeView = "website.default.index";
    }
@endphp

@include($themeView)

