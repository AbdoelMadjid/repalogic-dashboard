@php
    $breadcrumbItems = [];
    $pageMainTitle = $title ?? null;
    $activeDataLang = null;

    $routeName = Route::currentRouteName();
    $currentPath = trim(request()->path(), '/');
    $isAdmin = request()->is('admin*') || ($routeName && str_starts_with($routeName, 'admin.'));

    if (isset($breadcrumbs) && is_array($breadcrumbs)) {
        $breadcrumbItems = $breadcrumbs;
        $pageMainTitle = $pageMainTitle ?? 'Dashboard';

    } elseif ($isAdmin) {
        // =========================================================================
        // ADMIN MODE: BREADCRUMBS SHOW PARENT LOCATION (WITHOUT REPEATING LEAF TITLE)
        // =========================================================================
        $dbMenu = null;
        try {
            if (class_exists(\App\Models\Admin\DukunganAplikasi\Menu::class)) {
                $query = \App\Models\Admin\DukunganAplikasi\Menu::with('parent.parent');

                $matched = (clone $query)->where(function($q) use ($routeName, $currentPath) {
                    if ($routeName) {
                        $baseRoute = str_replace('.index', '', $routeName);
                        $q->where('route', $routeName)->orWhere('route', $baseRoute);
                    }
                    $q->orWhere('url', $currentPath)
                      ->orWhere('url', '/' . $currentPath);
                })->first();

                if (!$matched && $currentPath) {
                    $pathParts = explode('/', $currentPath);
                    while (count($pathParts) > 1 && !$matched) {
                        $checkPath = implode('/', $pathParts);
                        $matched = (clone $query)->where('url', $checkPath)
                            ->orWhere('url', '/' . $checkPath)
                            ->orWhere('route', str_replace('/', '.', $checkPath))
                            ->first();
                        array_pop($pathParts);
                    }
                }

                $dbMenu = $matched;
            }
        } catch (\Throwable $e) {
            $dbMenu = null;
        }

        if ($dbMenu) {
            if (!$pageMainTitle) {
                $pageMainTitle = $dbMenu->name;
            }

            $breadcrumbItems[] = [
                'title' => 'Admin',
                'url' => url('/admin'),
            ];

            if (!empty($dbMenu->category)) {
                $breadcrumbItems[] = [
                    'title' => Str::title(str_replace(['-', '_'], ' ', $dbMenu->category)),
                    'url' => 'javascript:void(0);',
                ];
            }

            if ($dbMenu->parent) {
                if ($dbMenu->parent->parent && !empty($dbMenu->parent->parent->name)) {
                    $breadcrumbItems[] = [
                        'title' => $dbMenu->parent->parent->name,
                        'url' => !empty($dbMenu->parent->parent->url) ? url($dbMenu->parent->parent->url) : 'javascript:void(0);',
                    ];
                }
                $breadcrumbItems[] = [
                    'title' => $dbMenu->parent->name,
                    'url' => !empty($dbMenu->parent->url) ? url($dbMenu->parent->url) : 'javascript:void(0);',
                ];
            }

        } else {
            // Fallback for non-db admin pages: omit the active leaf title from breadcrumbs
            $rawSegments = $routeName && str_contains($routeName, '.')
                ? explode('.', $routeName)
                : array_filter(explode('/', $currentPath));

            if (count($rawSegments) > 0 && strtolower($rawSegments[0]) === 'admin') {
                array_shift($rawSegments);
            }
            if (count($rawSegments) > 0 && strtolower(end($rawSegments)) === 'index') {
                array_pop($rawSegments);
            }

            $segments = [];
            $accumulated = ['admin'];
            foreach ($rawSegments as $seg) {
                $accumulated[] = $seg;
                $cleanSeg = str_replace(['-', '_'], ' ', $seg);
                $formatted = Str::title($cleanSeg);

                $accRoute = implode('.', $accumulated);
                $url = Route::has($accRoute) ? route($accRoute) : 'javascript:void(0);';

                $segments[] = [
                    'title' => $formatted,
                    'url' => $url,
                ];
            }

            $lastSegment = end($segments);
            if (!$pageMainTitle) {
                $pageMainTitle = is_array($lastSegment) ? $lastSegment['title'] ?? 'Dashboard' : 'Dashboard';
            }

            $ancestorSegments = count($segments) > 1 ? array_slice($segments, 0, -1) : $segments;

            $breadcrumbItems = array_merge(
                [['title' => 'Admin', 'url' => url('/admin')]],
                $ancestorSegments
            );
        }

    } else {
        // =========================================================================
        // TEMPLATE MODE: SIDENAV-TEMPLATE CONFIG DRIVEN
        // =========================================================================
        $findHierarchy = function ($items, $ancestors) use (&$findHierarchy, $routeName, $currentPath) {
            if (!is_array($items)) {
                return null;
            }
            foreach ($items as $item) {
                if (!is_array($item)) {
                    continue;
                }
                $currentAncestors = array_merge($ancestors, [$item]);

                if (
                    !empty($item['route']) &&
                    $routeName &&
                    ($item['route'] === $routeName || request()->routeIs($item['route']))
                ) {
                    return $currentAncestors;
                }
                if (!empty($item['url']) && ($item['url'] === $currentPath || $item['url'] === '/' . $currentPath)) {
                    return $currentAncestors;
                }
                if (!empty($item['children']) && is_array($item['children'])) {
                    $found = $findHierarchy($item['children'], $currentAncestors);
                    if ($found) {
                        return $found;
                    }
                }
            }
            return null;
        };

        $sidenavConfigs = config('sidenav-template', []);
        $hierarchy = null;
        foreach ($sidenavConfigs as $groupKey => $group) {
            if (!empty($group['items']) && is_array($group['items'])) {
                $groupTitle = $group['title'] ?? Str::title(str_replace(['-', '_'], ' ', $groupKey));
                $groupDataLang = $group['data_lang'] ?? null;
                $found = $findHierarchy($group['items'], [
                    ['title' => $groupTitle, 'data_lang' => $groupDataLang, 'is_group' => true],
                ]);
                if ($found) {
                    $hierarchy = $found;
                    break;
                }
            }
        }

        if ($hierarchy && count($hierarchy) > 0) {
            $activeLeaf = end($hierarchy);
            $activeDataLang = $activeLeaf['data_lang'] ?? null;
            if (!$pageMainTitle) {
                $pageMainTitle = $activeLeaf['title'] ?? 'Dashboard';
            }

            $ancestors = count($hierarchy) > 1 ? array_slice($hierarchy, 0, -1) : $hierarchy;

            $breadcrumbItems = [];
            $breadcrumbItems[] = [
                'title' => 'Template',
                'data_lang' => 'template',
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
                    'data_lang' => $node['data_lang'] ?? null,
                    'url' => $nodeUrl,
                ];
            }
        } else {
            $rawSegments = $routeName && str_contains($routeName, '.')
                ? explode('.', $routeName)
                : array_filter(explode('/', $currentPath));

            if (count($rawSegments) > 0 && strtolower($rawSegments[0]) === 'template') {
                array_shift($rawSegments);
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
            $accumulated = ['template'];
            foreach ($rawSegments as $seg) {
                $accumulated[] = $seg;
                $cleanSeg = str_replace(['-', '_'], ' ', $seg);
                $lowerSeg = strtolower($cleanSeg);
                $formatted = $knownAcronyms[$lowerSeg] ?? Str::title($cleanSeg);

                $accRoute = implode('.', $accumulated);
                $url = Route::has($accRoute) ? route($accRoute) : 'javascript:void(0);';

                $segments[] = [
                    'title' => $formatted,
                    'url' => $url,
                ];
            }

            $lastSegment = end($segments);
            if (!$pageMainTitle) {
                $pageMainTitle = is_array($lastSegment) ? $lastSegment['title'] ?? 'Dashboard' : 'Dashboard';
            }

            $ancestorSegments = count($segments) > 1 ? array_slice($segments, 0, -1) : $segments;

            $breadcrumbItems = array_merge(
                [['title' => 'Template', 'url' => Route::has('dashboard') ? route('dashboard') : url('/')]],
                $ancestorSegments
            );
        }
    }

    if (isset($title) && !empty($title)) {
        $pageMainTitle = $title;
    }
@endphp

<div class="page-title-head d-flex align-items-center">
    <div class="flex-grow-1">
        <h4 class="page-main-title m-0" style="text-transform: none !important;"
            @if (!empty($activeDataLang)) data-lang="{{ $activeDataLang }}" @endif>{{ $pageMainTitle }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0" style="text-transform: none !important;">
            @foreach ($breadcrumbItems as $item)
                @php
                    $itemTitle = is_array($item) ? $item['title'] : $item;
                    $itemUrl = is_array($item) ? $item['url'] ?? 'javascript:void(0);' : 'javascript:void(0);';
                    $itemDataLang = is_array($item) ? $item['data_lang'] ?? null : null;
                @endphp
                @if ($loop->last)
                    <li class="breadcrumb-item active" aria-current="page"
                        @if (!empty($itemDataLang)) data-lang="{{ $itemDataLang }}" @endif>{{ $itemTitle }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $itemUrl }}"
                            @if (!empty($itemDataLang)) data-lang="{{ $itemDataLang }}" @endif>{{ $itemTitle }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</div>
