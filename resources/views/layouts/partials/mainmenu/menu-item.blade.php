@php
    $groupConfig = config('sidenav-template.menu-item');
@endphp

@if (!empty($groupConfig))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $groupConfig])
@endif
