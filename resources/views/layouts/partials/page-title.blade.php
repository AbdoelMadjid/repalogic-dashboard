@php
    $breadcrumbItems = [];
    $pageMainTitle = $title ?? null;

    if (isset($breadcrumbs) && is_array($breadcrumbs)) {
        $breadcrumbItems = $breadcrumbs;
        $pageMainTitle = $pageMainTitle ?? 'Dashboard';
    } else {
        $routeName = Route::currentRouteName();
        $currentPath = trim(request()->path(), '/');

        // Search config/sidenav-template for matching route/URL hierarchy
        $findHierarchy = function ($items, $ancestors) use (&$findHierarchy, $routeName, $currentPath) {
            if (!is_array($items)) return null;
            foreach ($items as $item) {
                if (!is_array($item)) continue;
                $currentAncestors = array_merge($ancestors, [$item]);

                if (!empty($item['route']) && $routeName && ($item['route'] === $routeName || request()->routeIs($item['route']))) {
                    return $currentAncestors;
                }
                if (!empty($item['url']) && ($item['url'] === $currentPath || $item['url'] === '/' . $currentPath)) {
                    return $currentAncestors;
                }
                if (!empty($item['children']) && is_array($item['children'])) {
                    $found = $findHierarchy($item['children'], $currentAncestors);
                    if ($found) return $found;
                }
            }
            return null;
        };

        $sidenavConfigs = config('sidenav-template', []);
        $hierarchy = null;
        foreach ($sidenavConfigs as $groupKey => $group) {
            if (!empty($group['items']) && is_array($group['items'])) {
                $groupTitle = $group['title'] ?? Str::title(str_replace(['-', '_'], ' ', $groupKey));
                $found = $findHierarchy($group['items'], [['title' => $groupTitle, 'is_group' => true]]);
                if ($found) {
                    $hierarchy = $found;
                    break;
                }
            }
        }

        if ($hierarchy && count($hierarchy) > 0) {
            $activeLeaf = end($hierarchy);
            if (!$pageMainTitle) {
                $pageMainTitle = $activeLeaf['title'] ?? 'Dashboard';
            }

            // Omit active leaf node from breadcrumb items, since active title is rendered as Main Title on the left
            $ancestors = (count($hierarchy) > 1) ? array_slice($hierarchy, 0, -1) : $hierarchy;

            $breadcrumbItems = [];
            $breadcrumbItems[] = [
                'title' => 'Template',
                'url' => Route::has('dashboard') ? route('dashboard') : url('/'),
            ];
            foreach ($ancestors as $node) {
                $nodeTitle = $node['title'] ?? '';
                $nodeUrl = 'javascript:void(0);';
                if (!empty($node['route']) && Route::has($node['route'])) {
                    $nodeUrl = route($node['route']);
                } elseif (!empty($node['url'])) {
                    $nodeUrl = url($node['url']);
                }
                $breadcrumbItems[] = [
                    'title' => $nodeTitle,
                    'url' => $nodeUrl,
                ];
            }
        } else {
            // Fallback: format route/path segments
            $rawSegments = $routeName && str_contains($routeName, '.')
                ? explode('.', $routeName)
                : array_filter(explode('/', $currentPath));

            if (count($rawSegments) > 0 && strtolower($rawSegments[0]) === 'template') {
                array_shift($rawSegments);
            }

            $knownAcronyms = ['ui' => 'UI', 'faq' => 'FAQ', 'api' => 'API', 'pdf' => 'PDF', 'i18' => 'i18n', 'auth' => 'Auth'];

            $segments = [];
            $accumulated = ['template'];
            foreach ($rawSegments as $seg) {
                $accumulated[] = $seg;
                $cleanSeg = str_replace(['-', '_'], ' ', $seg);
                $lowerSeg = strtolower($cleanSeg);
                $formatted = $knownAcronyms[$lowerSeg] ?? Str::title($cleanSeg);

                $accRoute = implode('.', $accumulated);
                $url = 'javascript:void(0);';
                if (Route::has($accRoute)) {
                    $url = route($accRoute);
                }

                $segments[] = [
                    'title' => $formatted,
                    'url' => $url,
                ];
            }

            $lastSegment = end($segments);
            if (!$pageMainTitle) {
                $pageMainTitle = is_array($lastSegment) ? ($lastSegment['title'] ?? 'Dashboard') : 'Dashboard';
            }

            $ancestorSegments = (count($segments) > 1) ? array_slice($segments, 0, -1) : $segments;

            $breadcrumbItems = array_merge([
                ['title' => 'Template', 'url' => Route::has('dashboard') ? route('dashboard') : url('/')]
            ], $ancestorSegments);
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
