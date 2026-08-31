@php
    $appProfil = $appProfil ?? (class_exists(\App\Models\Admin\DukunganAplikasi\ProfilAplikasi::class) ? \App\Models\Admin\DukunganAplikasi\ProfilAplikasi::getSettings() : null);
    $appName = !empty($appProfil?->app_name) ? $appProfil->app_name : config('app.name', 'REPALOGIC Dashboard');

    $pageTitle = $title ?? null;
    $activeDataLang = $dataLang ?? null;

    if (!$pageTitle || !$activeDataLang) {
        $currentRoute = Route::currentRouteName();
        $currentPath = trim(request()->path(), '/');
        $isAdmin = request()->is('admin*') || ($currentRoute && str_starts_with($currentRoute, 'admin.'));

        // 1. Try matching Database Menu for Admin pages
        if ($isAdmin) {
            try {
                if (class_exists(\App\Models\Admin\DukunganAplikasi\Menu::class)) {
                    $matchedMenu = \App\Models\Admin\DukunganAplikasi\Menu::where(function ($q) use ($currentRoute, $currentPath) {
                        if ($currentRoute) {
                            $baseRoute = str_replace('.index', '', $currentRoute);
                            $q->where('route', $currentRoute)->orWhere('route', $baseRoute);
                        }
                        $q->orWhere('url', $currentPath)->orWhere('url', '/' . $currentPath);
                    })->first();

                    if (!$matchedMenu && $currentPath) {
                        $pathParts = explode('/', $currentPath);
                        while (count($pathParts) > 1 && !$matchedMenu) {
                            $checkPath = implode('/', $pathParts);
                            $matchedMenu = \App\Models\Admin\DukunganAplikasi\Menu::where('url', $checkPath)
                                ->orWhere('url', '/' . $checkPath)
                                ->orWhere('route', str_replace('/', '.', $checkPath))
                                ->first();
                            array_pop($pathParts);
                        }
                    }

                    if ($matchedMenu) {
                        if (!$pageTitle) {
                            $pageTitle = $matchedMenu->name;
                        }
                        if (!$activeDataLang) {
                            $activeDataLang = $matchedMenu->data_lang ?: \Illuminate\Support\Str::slug($matchedMenu->name);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore DB error fallback
            }
        }

        // 2. Recursive search for active menu item in sidenav config (Template Mode or fallback)
        if (!$pageTitle || !$activeDataLang) {
            $findActiveItem = function ($items) use (&$findActiveItem, $currentRoute, $currentPath) {
                if (!is_array($items)) {
                    return null;
                }
                foreach ($items as $item) {
                    if (is_array($item)) {
                        if (
                            !empty($item['route']) &&
                            $currentRoute &&
                            ($item['route'] === $currentRoute || request()->routeIs($item['route']))
                        ) {
                            return $item;
                        }
                        if (
                            !empty($item['url']) &&
                            ($item['url'] === $currentPath || $item['url'] === '/' . $currentPath)
                        ) {
                            return $item;
                        }
                        if (!empty($item['children']) && is_array($item['children'])) {
                            $found = $findActiveItem($item['children']);
                            if ($found) {
                                return $found;
                            }
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
                        if (!$pageTitle) {
                            $pageTitle = $foundItem['title'] ?? null;
                        }
                        if (!$activeDataLang) {
                            $activeDataLang = $foundItem['data_lang'] ?? null;
                        }
                        break;
                    }
                }
            }
        }

        // 3. Fallback to route / path segment formatting if not found in Database or Template Config
        if (!$pageTitle) {
            $rawSegments = $currentRoute && str_contains($currentRoute, '.')
                ? explode('.', $currentRoute)
                : array_filter(explode('/', $currentPath));

            // Strip prefix 'admin' if present
            if (count($rawSegments) > 0 && strtolower($rawSegments[0]) === 'admin') {
                array_shift($rawSegments);
            }

            // Strip action verbs like 'index', 'create', 'edit', 'show' from end of route segments
            $actionVerbs = ['index', 'create', 'edit', 'show', 'store', 'update', 'destroy'];
            while (count($rawSegments) > 0 && in_array(strtolower(end($rawSegments)), $actionVerbs)) {
                array_pop($rawSegments);
            }

            $last = end($rawSegments) ?: 'Dashboard';

            $knownAcronyms = [
                'ui' => 'UI',
                'faq' => 'FAQ',
                'api' => 'API',
                'pdf' => 'PDF',
                'i18' => 'i18n',
                'auth' => 'Auth',
                'db' => 'DB',
            ];
            $clean = str_replace(['-', '_'], ' ', $last);
            $lower = strtolower($clean);
            $pageTitle = $knownAcronyms[$lower] ?? Str::title($clean);
        }
    }
@endphp

<meta charset="utf-8" />
<title>{{ $pageTitle }} | {{ $appName }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description"
    content="{{ $appProfil->meta_description ?? 'REPALOGIC Dashboard Management System' }}" />
<meta name="keywords"
    content="{{ $appProfil->meta_keywords ?? 'admin, dashboard, repalogic, bootstrap 5' }}" />
<meta name="author" content="{{ $appProfil->meta_author ?? 'Repalogic' }}" />

<!-- App favicon -->
<link rel="shortcut icon" href="{{ !empty($appProfil?->favicon) ? asset('storage/' . $appProfil->favicon) : asset('assets/images/favicon.ico') }}" />
