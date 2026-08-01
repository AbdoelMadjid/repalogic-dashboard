@php
    $pageTitle = $title ?? null;
    $activeDataLang = $dataLang ?? null;

    if (!$pageTitle || !$activeDataLang) {
        $currentRoute = Route::currentRouteName();
        $currentPath = trim(request()->path(), '/');

        // Recursive search for active menu item in sidenav config
        $findActiveItem = function ($items) use (&$findActiveItem, $currentRoute, $currentPath) {
            if (!is_array($items)) return null;
            foreach ($items as $item) {
                if (is_array($item)) {
                    if (!empty($item['route']) && $currentRoute && ($item['route'] === $currentRoute || request()->routeIs($item['route']))) {
                        return $item;
                    }
                    if (!empty($item['url']) && ($item['url'] === $currentPath || $item['url'] === '/' . $currentPath)) {
                        return $item;
                    }
                    if (!empty($item['children']) && is_array($item['children'])) {
                        $found = $findActiveItem($item['children']);
                        if ($found) return $found;
                    }
                }
            }
            return null;
        };

        $sidenavConfigs = config('sidenav-template', []);
        foreach ($sidenavConfigs as $group) {
            if (!empty($group['items']) && is_array($group['items'])) {
                $foundItem = $findActiveItem($group['items']);
                if ($foundItem) {
                    if (!$pageTitle) $pageTitle = $foundItem['title'] ?? null;
                    if (!$activeDataLang) $activeDataLang = $foundItem['data_lang'] ?? null;
                    break;
                }
            }
        }

        // Fallback to route / path segment formatting if not found in menu config
        if (!$pageTitle) {
            if ($currentRoute && str_contains($currentRoute, '.')) {
                $segments = explode('.', $currentRoute);
                $last = end($segments);
            } else {
                $segments = array_filter(explode('/', $currentPath));
                $last = end($segments) ?: 'Dashboard';
            }

            $knownAcronyms = ['ui' => 'UI', 'faq' => 'FAQ', 'api' => 'API', 'pdf' => 'PDF', 'i18' => 'i18n', 'auth' => 'Auth'];
            $clean = str_replace(['-', '_'], ' ', $last);
            $lower = strtolower($clean);
            $pageTitle = $knownAcronyms[$lower] ?? Str::title($clean);
        }
    }
@endphp

<meta charset="utf-8" />
<title @if(!empty($activeDataLang)) data-lang="{{ $activeDataLang }}" @endif>{{ $pageTitle }} | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description"
    content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
<meta name="keywords"
    content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
<meta name="author" content="WebAppLayers" />

<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
