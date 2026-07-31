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

            <div id="search-box" class="app-search d-none d-xl-flex">
                <input type="search" class="form-control topbar-search" name="search"
                    placeholder="Search for something..." />
                <i class="ti ti-search app-search-icon text-muted"></i>
            </div>

            @include('layouts.partials.topbar.megamenu-header')
            @include('layouts.partials.topbar.megamenu-apps')


        </div>

        <div class="d-flex align-items-center gap-2">
            @include('layouts.partials.topbar.theme-toggler')

            @include('layouts.partials.topbar.apps-dropdown-rounded')

            @include('layouts.partials.topbar.simple-messages-dropdown')

            @include('layouts.partials.topbar.notification-dropdown-alert')

            @include('layouts.partials.topbar.fullscreen-toggler')

            @include('layouts.partials.topbar.monochrome-toggler')

            @include('layouts.partials.topbar.theme-settings-offcanvas')

            @include('layouts.partials.topbar.language-selector')

            @include('layouts.partials.topbar.simple-user-dropdown')
        </div>
    </div>
</header>
<!-- Topbar End -->
