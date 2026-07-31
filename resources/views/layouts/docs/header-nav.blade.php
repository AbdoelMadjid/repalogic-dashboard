<!-- Sidenav Menu Start -->
<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="docs/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="docs/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="docs/images/logo-black.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="docs/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">Menu</li>

            <!-- Introduction -->
            <li class="side-nav-item">
                <a href="{{ url('docs/index') }}"
                    class="side-nav-link {{ request()->is('docs/index') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-shield-check"></i></span>
                    <span class="menu-text" data-lang="introduction">Introduction</span>
                </a>
            </li>

            <!-- Folder Structure -->
            <li class="side-nav-item">
                <a href="{{ url('docs/folder-structure') }}"
                    class="side-nav-link {{ request()->is('docs/folder-structure') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-folders"></i></span>
                    <span class="menu-text">Folder Structure</span>
                </a>
            </li>

            <!-- Getting Started -->
            <li class="side-nav-item">
                <a href="{{ url('docs/getting-started') }}"
                    class="side-nav-link {{ request()->is('docs/getting-started') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-rocket"></i></span>
                    <span class="menu-text">Getting Started</span>
                </a>
            </li>

            <li class="side-nav-title mt-2">
                Layouts
            </li>

            <li class="side-nav-item">
                <a href="{{ url('docs/layouts') }}"
                    class="side-nav-link {{ request()->is('docs/layouts') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-layout"></i></span>
                    <span class="menu-text" data-translator-key="sidebars"> Layouts Option </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('docs/sidebar') }}"
                    class="side-nav-link {{ request()->is('docs/sidebar') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-layout-sidebar"></i></span>
                    <span class="menu-text" data-translator-key="sidebars"> Sidebars Option </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('docs/topbar') }}"
                    class="side-nav-link {{ request()->is('docs/topbar') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-layout-bottombar"></i></span>
                    <span class="menu-text" data-translator-key="sidebars"> Topbar Option</span>
                </a>
            </li>



            <!-- Theme Setup -->
            <li class="side-nav-item">
                <a href="{{ url('docs/theme-skin-setup') }}"
                    class="side-nav-link {{ request()->is('docs/theme-skin-setup') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-diamond"></i></span>
                    <span class="menu-text">Theme Skin Setup</span>
                </a>
            </li>

            <!-- Dark Mode -->
            <li class="side-nav-item">
                <a href="{{ url('docs/dark-mode') }}"
                    class="side-nav-link {{ request()->is('docs/dark-mode') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-moon"></i></span>
                    <span class="menu-text">Dark Mode</span>
                </a>
            </li>



            <!-- Sources & Credits -->
            <li class="side-nav-item">
                <a href="{{ url('docs/sources') }}"
                    class="side-nav-link {{ request()->is('docs/sources') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-alert-circle"></i></span>
                    <span class="menu-text">Sources & Credits</span>
                </a>
            </li>

            <!-- Changelog -->
            <li class="side-nav-item">
                <a href="{{ url('docs/changelog') }}"
                    class="side-nav-link {{ request()->is('docs/changelog') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-book"></i></span>
                    <span class="menu-text">Changelog</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Sidenav Menu End -->

<!-- Topbar Start -->
<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="javascript:void(0)" class="logo-light">
                    <span class="logo-lg">
                        <img src="docs/images/logo.png" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="docs/images/logo-sm.png" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="javascript:void(0)" class="logo-dark">
                    <span class="logo-lg">
                        <img src="docs/images/logo-black.png" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="docs/images/logo-sm.png" alt="small logo">
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button btn btn-primary btn-icon d-flex mt-2">
                <i class="ti ti-menu-4 fs-22"></i>
            </button>
        </div> <!-- .d-flex-->
    </div>
</header>
<!-- Topbar End -->
