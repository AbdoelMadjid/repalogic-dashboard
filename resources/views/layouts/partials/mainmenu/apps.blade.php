@php
    $groupConfig = config('sidenav-template.apps');
@endphp

@if (!empty($groupConfig))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $groupConfig])
@endif
