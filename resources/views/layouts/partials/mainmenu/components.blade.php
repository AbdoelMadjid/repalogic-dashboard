@php
    $groupConfig = config('sidenav-template.components');
@endphp

@if (!empty($groupConfig))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $groupConfig])
@endif
