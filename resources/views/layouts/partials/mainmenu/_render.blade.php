@if (!empty($menuGroup))
    @if (!empty($menuGroup['title']))
        <li class="side-nav-title mt-2" @if (!empty($menuGroup['data_lang'])) data-lang="{{ $menuGroup['data_lang'] }}" @endif>
            {{ $menuGroup['title'] }}
        </li>
    @endif

    @if (!empty($menuGroup['items']) && is_array($menuGroup['items']))
        @foreach ($menuGroup['items'] as $item)
            @include('layouts.partials.mainmenu._item', ['item' => $item])
        @endforeach
    @endif
@endif
