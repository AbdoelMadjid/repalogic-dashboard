@php
    $groupConfig = config('sidenav-template.main');
@endphp

@if (!empty($groupConfig))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $groupConfig])
@endif
