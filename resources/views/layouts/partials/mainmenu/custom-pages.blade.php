@php
    $groupConfig = config('sidenav-template.custom-pages');
@endphp

@if (!empty($groupConfig))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $groupConfig])
@endif
