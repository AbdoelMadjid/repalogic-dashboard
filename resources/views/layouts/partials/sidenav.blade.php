<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <span class="btn-on-hover-icon"></span>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ti ti-menu-4 align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar="">
        <div id="user-profile-settings" class="sidenav-user"
            style="background: url({{ asset('assets/images/user-bg-pattern.svg)') }}">
            <div class="text-center">
                <div>
                    <a href="#!" class="link-reset">
                        <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="user-image"
                            class="rounded-circle mb-2 avatar-md"
                            style="width: 84px; height: 84px; object-fit: cover;" />
                        <span class="sidenav-user-name fw-bold">Damian D.</span>
                        <span class="fs-12 fw-semibold" data-lang="user-role">Art Director</span>
                    </a>
                </div>
                {{-- <div>
                    <a class="dropdown-toggle drop-arrow-none link-reset sidenav-user-set-icon"
                        data-bs-toggle="dropdown" data-bs-offset="0,12" href="#!" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-settings fs-24 align-middle ms-1"></i>
                    </a>

                    <div class="dropdown-menu">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome back!</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Profile</span>
                        </a>

                        <!-- Settings -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Account Settings</span>
                        </a>

                        <!-- Lock -->
                        <a href="{{ asset('auth-lock-screen.html') }}" class="dropdown-item">
                            <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Lock Screen</span>
                        </a>

                        <!-- Logout -->
                        <a href="javascript:void(0);" class="dropdown-item text-danger fw-semibold">
                            <i class="ti ti-logout me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="px-3 mb-3 mt-2">
            <div class="position-relative sidenav-search-wrap">
                <i
                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y ms-3 sidenav-search-icon"></i>
                <input type="text" id="sidenav-menu-search"
                    class="form-control form-control-sm ps-5 sidenav-search-input"
                    placeholder="{{ App::getLocale() === 'id' ? 'Cari menu...' : 'Search menu...' }}"
                    data-lang="sidenav-search-placeholder">
            </div>
            <div id="sidenav-search-empty" class="sidenav-search-empty mt-2 d-none" data-lang="sidenav-search-empty">
                Menu tidak ditemukan.
            </div>
        </div>
        <!--- Sidenav Menu -->
        <div id="sidenav-menu">
            <ul class="side-nav">
                <li class="side-nav-item mt-2">
                    <a href="{{ asset('dashboard') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-building-warehouse"></i></span>
                        <span class="menu-text" data-lang="dashboards">Dashboard</span>
                    </a>
                </li>
                @include('layouts.partials.mainmenu.main')
                @include('layouts.partials.mainmenu.apps')
                @include('layouts.partials.mainmenu.custom-pages')
                @include('layouts.partials.mainmenu.layouts')
                @include('layouts.partials.mainmenu.components')
                @include('layouts.partials.mainmenu.menu-item')

                <li class="side-nav-item">
                    <a href="#" class="side-nav-link disabled">
                        <span class="menu-icon"><i class="ti ti-ban"></i></span>
                        <span class="menu-text" data-lang="disabled-menu">Disabled Menu</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link special-menu">
                        <span class="menu-icon"><i class="ti ti-star"></i></span>
                        <span class="menu-text" data-lang="special-menu">Special Menu</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidenav Menu End -->

<style>
    .sidenav-search-icon {
        color: rgba(255, 255, 255, 0.55);
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.25);
        pointer-events: none;
    }

    .sidenav-search-input {
        background: transparent;
        border: 1px dashed rgba(255, 255, 255, 0.28);
        color: inherit;
        transition: all 0.2s ease;
        box-shadow: 0 0 12px rgba(255, 255, 255, 0.12);
    }

    .sidenav-search-input::placeholder {
        color: rgba(255, 255, 255, 0.48);
    }

    .sidenav-search-input:focus {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 14px rgba(255, 255, 255, 0.18);
        color: inherit;
    }

    [data-bs-theme="light"] .sidenav-search-input {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.32);
    }

    [data-bs-theme="light"] .sidenav-search-input::placeholder {
        color: rgba(255, 255, 255, 0.75);
    }

    [data-bs-theme="light"] .sidenav-search-input:focus {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.45);
        box-shadow: 0 0 14px rgba(255, 255, 255, 0.22);
    }

    .sidenav-search-empty {
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
        line-height: 1.2;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('sidenav-menu-search');
        const emptyState = document.getElementById('sidenav-search-empty');
        const sideNav = document.querySelector('.side-nav');

        if (!searchInput || !sideNav) {
            return;
        }

        const collapses = Array.from(sideNav.querySelectorAll('.collapse'));
        const collapseToggles = Array.from(sideNav.querySelectorAll('[data-bs-toggle="collapse"]'));
        const initialOpenCollapseIds = new Set(
            collapses.filter((collapse) => collapse.classList.contains('show')).map((collapse) => collapse
                .id)
        );

        const syncSectionTitles = () => {
            const navChildren = Array.from(sideNav.children);
            navChildren.forEach((child, index) => {
                if (!child.classList.contains('side-nav-title')) {
                    return;
                }

                let hasVisibleItem = false;
                for (let i = index + 1; i < navChildren.length; i++) {
                    const nextChild = navChildren[i];
                    if (nextChild.classList.contains('side-nav-title')) {
                        break;
                    }
                    if (nextChild.classList.contains('side-nav-item') && nextChild.style.display !==
                        'none') {
                        hasVisibleItem = true;
                        break;
                    }
                }

                child.style.display = hasVisibleItem ? '' : 'none';
            });
        };

        const restoreCollapseState = () => {
            collapses.forEach((collapse) => {
                if (initialOpenCollapseIds.has(collapse.id)) {
                    collapse.classList.add('show');
                } else {
                    collapse.classList.remove('show');
                }
            });

            collapseToggles.forEach((toggle) => {
                const target = toggle.getAttribute('href');
                if (!target || !target.startsWith('#')) {
                    return;
                }
                const targetId = target.slice(1);
                toggle.setAttribute('aria-expanded', initialOpenCollapseIds.has(targetId) ? 'true' :
                    'false');
            });
        };

        searchInput.addEventListener('input', function(event) {
            const keyword = event.target.value.trim().toLowerCase();
            const allNavItems = sideNav.querySelectorAll('.side-nav-item');

            if (!keyword) {
                allNavItems.forEach((item) => {
                    item.style.display = '';
                });
                sideNav.querySelectorAll('.side-nav-title').forEach((title) => {
                    title.style.display = '';
                });
                restoreCollapseState();
                if (emptyState) {
                    emptyState.classList.add('d-none');
                }
                return;
            }

            allNavItems.forEach((item) => {
                const label = item.textContent.toLowerCase().replace(/\s+/g, ' ').trim();
                item.style.display = label.includes(keyword) ? '' : 'none';
            });

            collapses.forEach((collapse) => {
                collapse.classList.add('show');
            });
            collapseToggles.forEach((toggle) => {
                toggle.setAttribute('aria-expanded', 'true');
            });

            syncSectionTitles();

            if (emptyState) {
                const hasVisibleItem = Array.from(allNavItems).some((item) => item.style.display !==
                    'none');
                emptyState.classList.toggle('d-none', hasVisibleItem);
            }
        });
    });
</script>
