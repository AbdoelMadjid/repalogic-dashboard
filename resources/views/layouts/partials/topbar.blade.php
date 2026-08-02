<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="{{ route('dashboard') }}" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="{{ route('dashboard') }}" class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button btn btn-default btn-icon">
                <i class="ti ti-menu-4"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu">
                <i class="ti ti-menu-4"></i>
            </button>

            @if(empty($appFeatures) || $appFeatures->topbar_search_box)
            <div id="search-box" class="app-search d-none d-xl-flex">
                <input type="search" class="form-control topbar-search" name="search"
                    placeholder="Search for something..." data-lang-placeholder="topbar-search-placeholder" />
                <i class="ti ti-search app-search-icon text-muted"></i>
            </div>
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_megamenu_header)
                @include('layouts.partials.topbar.megamenu-header')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_megamenu_apps)
                @include('layouts.partials.topbar.megamenu-apps')
            @endif
        </div>

        <div class="d-flex align-items-center gap-2">
            @if(empty($appFeatures) || $appFeatures->topbar_theme_toggler)
                @include('layouts.partials.topbar.theme-toggler')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_apps_dropdown)
                @include('layouts.partials.topbar.apps-dropdown-rounded')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_messages)
                @include('layouts.partials.topbar.simple-messages-dropdown')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_notifications)
                @include('layouts.partials.topbar.notification-dropdown-alert')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_fullscreen)
                @include('layouts.partials.topbar.fullscreen-toggler')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_monochrome)
                @include('layouts.partials.topbar.monochrome-toggler')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_customizer)
                @include('layouts.partials.topbar.theme-settings-offcanvas')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_language)
                @include('layouts.partials.topbar.language-selector')
            @endif

            @if(empty($appFeatures) || $appFeatures->topbar_user_dropdown)
                @include('layouts.partials.topbar.simple-user-dropdown')
            @endif
        </div>
    </div>
</header>
<!-- Topbar End -->
