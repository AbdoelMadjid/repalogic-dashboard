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

    // Active route checking
    $isActive = false;
    if (!empty($item['route']) && Route::has($item['route'])) {
        $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*');
    }

    $linkClasses = 'side-nav-link';
    if (!empty($item['disabled'])) {
        $linkClasses .= ' disabled';
    }
    if (!empty($item['special'])) {
        $linkClasses .= ' special-menu';
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
