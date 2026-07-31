@if ($menuGroup = config('sidenav-template.documentation'))
    @include('layouts.partials.mainmenu._render', ['menuGroup' => $menuGroup])
@endif
