@php
    $breadcrumbItems = [];

    if (isset($breadcrumbs) && is_array($breadcrumbs)) {
        $breadcrumbItems = $breadcrumbs;
        $pageMainTitle = $title ?? 'Dashboard';
    } else {
        $routeName = Route::currentRouteName();
        if ($routeName && str_contains($routeName, '.')) {
            $rawSegments = explode('.', $routeName);
        } else {
            $path = trim(request()->path(), '/');
            $rawSegments = array_filter(explode('/', $path));
        }

        $knownAcronyms = [
            'ui' => 'UI',
            'faq' => 'FAQ',
            'api' => 'API',
            'pdf' => 'PDF',
            'i18' => 'i18n',
            'auth' => 'Auth',
        ];

        $segments = [];
        $accumulated = [];
        foreach ($rawSegments as $seg) {
            $accumulated[] = $seg;
            $cleanSeg = str_replace(['-', '_'], ' ', $seg);
            $lowerSeg = strtolower($cleanSeg);
            $formatted = $knownAcronyms[$lowerSeg] ?? Str::title($cleanSeg);

            $accRoute = implode('.', $accumulated);
            $url = 'javascript:void(0);';
            if (Route::has($accRoute)) {
                $url = route($accRoute);
            } elseif (Route::has($accRoute . '.index')) {
                $url = route($accRoute . '.index');
            }

            $segments[] = [
                'title' => $formatted,
                'url' => $url,
            ];
        }

        // Determine Page Main Title (last segment or passed $title)
        $lastSegment = end($segments);
        $pageMainTitle = $title ?? (is_array($lastSegment) ? ($lastSegment['title'] ?? 'Dashboard') : ($lastSegment ?: 'Dashboard'));

        // Breadcrumbs: omit the last item if multiple segments exist, since the last item is rendered as the Main Title
        if (count($segments) > 1) {
            $breadcrumbItems = array_slice($segments, 0, -1);
        } else {
            $breadcrumbItems = $segments;
        }
    }

    if (isset($title) && !empty($title)) {
        $pageMainTitle = $title;
    }
@endphp

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0">{{ $pageMainTitle }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            @foreach ($breadcrumbItems as $item)
                @php
                    $itemTitle = is_array($item) ? $item['title'] : $item;
                    $itemUrl = is_array($item) ? ($item['url'] ?? 'javascript:void(0);') : 'javascript:void(0);';
                @endphp
                @if ($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $itemTitle }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $itemUrl }}">{{ $itemTitle }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</div>
