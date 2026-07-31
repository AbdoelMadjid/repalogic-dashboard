@php
    $hasChildren = !empty($item['children']) && is_array($item['children']);
    $collapseId = $item['id'] ?? (isset($item['title']) ? Str::slug($item['title']) : 'menu-' . uniqid());

    // Resolve route or URL
    $routeUrl = '#';
    if (!empty($item['route'])) {
        $routeUrl = Route::has($item['route']) ? route($item['route']) : '#';
    } elseif (isset($item['url'])) {
        $routeUrl = str_starts_with($item['url'], 'http') || str_starts_with($item['url'], '#') || str_starts_with($item['url'], '/')
            ? $item['url']
            : asset($item['url']);
    }

    // Active route checking (supports recursive children & sub-route matching)
    $checkIsActive = function ($menuItem) use (&$checkIsActive) {
        if (!is_array($menuItem)) return false;

        if (!empty($menuItem['route']) && Route::has($menuItem['route'])) {
            $currentRoute = Route::currentRouteName();
            if (request()->routeIs($menuItem['route']) ||
                request()->routeIs($menuItem['route'] . '.*') ||
                ($currentRoute && str_starts_with($currentRoute, $menuItem['route'] . '-'))) {
                return true;
            }
        }

        if (!empty($menuItem['url'])) {
            $currentPath = trim(request()->path(), '/');
            $itemUrl = trim($menuItem['url'], '/');
            if ($itemUrl && ($itemUrl === $currentPath || str_starts_with($currentPath, $itemUrl . '-'))) {
                return true;
            }
        }

        if (!empty($menuItem['children']) && is_array($menuItem['children'])) {
            foreach ($menuItem['children'] as $childItem) {
                if ($checkIsActive($childItem)) {
                    return true;
                }
            }
        }

        return false;
    };

    $isActive = $checkIsActive($item);

    $linkClasses = 'side-nav-link';
    if (!empty($item['disabled'])) {
        $linkClasses .= ' disabled';
    }
    if (!empty($item['special'])) {
        $linkClasses .= ' special-menu';
    }
    if ($isActive) {
        $linkClasses .= ' active';
    }

    // Compute badge class positioning
    $badgeClass = 'badge bg-primary';
    if (!empty($item['badge']['class'])) {
        $badgeClass = str_replace(['float-end', 'ms-auto', 'me-3', 'me-2'], '', $item['badge']['class']);
    }
    $badgeClass .= $hasChildren ? ' menu-badge-has-arrow' : ' menu-badge-single';
    $badgeClass = trim(preg_replace('/\s+/', ' ', $badgeClass));
@endphp

<li class="side-nav-item{{ $isActive ? ' active' : '' }}">
    @if ($hasChildren)
        <a data-bs-toggle="collapse"
           href="#{{ $collapseId }}"
           aria-expanded="{{ $isActive ? 'true' : 'false' }}"
           aria-controls="{{ $collapseId }}"
           class="{{ $linkClasses }}">
            @if (!empty($item['icon']))
                <span class="menu-icon"><i class="{{ $item['icon'] }}"></i></span>
            @endif
            <span class="menu-text" @if (!empty($item['data_lang'])) data-lang="{{ $item['data_lang'] }}" @endif>
                {{ $item['title'] }}
            </span>
            @if (!empty($item['badge']))
                <span class="{{ $badgeClass }}">
                    {{ $item['badge']['text'] }}
                </span>
            @endif
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse{{ $isActive ? ' show' : '' }}" id="{{ $collapseId }}">
            <ul class="sub-menu">
                @foreach ($item['children'] as $child)
                    @include('layouts.partials.mainmenu._item', ['item' => $child])
                @endforeach
            </ul>
        </div>
    @else
        <a href="{{ $routeUrl }}"
           class="{{ $linkClasses }}"
           @if (!empty($item['target'])) target="{{ $item['target'] }}" @endif>
            @if (!empty($item['icon']))
                <span class="menu-icon"><i class="{{ $item['icon'] }}"></i></span>
            @endif
            <span class="menu-text" @if (!empty($item['data_lang'])) data-lang="{{ $item['data_lang'] }}" @endif>
                {{ $item['title'] }}
            </span>
            @if (!empty($item['badge']))
                <span class="{{ $badgeClass }}">
                    {{ $item['badge']['text'] }}
                </span>
            @endif
        </a>
    @endif
</li>
