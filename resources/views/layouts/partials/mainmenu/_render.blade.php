@if (!empty($menuGroup))
    @if (!empty($menuGroup['title']))
        <li class="side-nav-title mt-2 {{ !empty($featureKey) ? 'feature-group-' . $featureKey : '' }}"
            @if (!empty($featureKey)) data-feature="{{ $featureKey }}" @endif
            @if (isset($isGroupVisible) && !$isGroupVisible) style="display: none !important;" @endif
            @if (!empty($menuGroup['data_lang'])) data-lang="{{ $menuGroup['data_lang'] }}" @endif>
            {{ $menuGroup['title'] }}
        </li>
    @endif

    @if (!empty($menuGroup['items']) && is_array($menuGroup['items']))
        @foreach ($menuGroup['items'] as $item)
            @include('layouts.partials.mainmenu._item', [
                'item' => $item,
                'featureKey' => $featureKey ?? null,
                'isGroupVisible' => $isGroupVisible ?? true,
            ])
        @endforeach
    @endif
@endif
