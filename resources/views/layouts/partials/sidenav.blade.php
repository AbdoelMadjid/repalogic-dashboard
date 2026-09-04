<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img
                    src="{{ !empty($appProfil->logo_lg) ? asset('storage/' . $appProfil->logo_lg) : asset('assets/images/logo.png') }}"
                    alt="logo" /></span>
            <span class="logo-sm"><img
                    src="{{ !empty($appProfil->logo_sm) ? asset('storage/' . $appProfil->logo_sm) : asset('assets/images/logo-sm.png') }}"
                    alt="small logo" /></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img
                    src="{{ !empty($appProfil->logo_lg) ? asset('storage/' . $appProfil->logo_lg) : asset('assets/images/logo-black.png') }}"
                    alt="dark logo" /></span>
            <span class="logo-sm"><img
                    src="{{ !empty($appProfil->logo_sm) ? asset('storage/' . $appProfil->logo_sm) : asset('assets/images/logo-sm.png') }}"
                    alt="small logo" /></span>
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
        @auth
            <div id="user-profile-settings" class="sidenav-user"
                style="background: url({{ asset('assets/images/user-bg-pattern.svg') }})">
                <div class="text-center">
                    <div>
                        <a href="#!" class="link-reset">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                class="rounded-circle mb-2 avatar-md object-fit-cover"
                                style="width: 84px; height: 84px; object-fit: cover; object-position: top;" />
                            <span class="sidenav-user-name fw-bold d-block text-truncate">{{ auth()->user()->name }}</span>
                            <span class="fs-12 text-muted d-block text-truncate mt-1">{{ auth()->user()->email }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endauth

        <div class="px-3 mb-3 mt-2">
            <div class="position-relative sidenav-search-wrap">
                <i
                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y ms-2 sidenav-search-icon"></i>
                <input type="text" id="sidenav-menu-search"
                    class="form-control form-control-sm sidenav-search-input text-white" style="padding-left: 28px;"
                    placeholder="Search menu..." data-lang-placeholder="sidenav-search-placeholder">
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
                @if (!empty($dbMenuGroups))
                    @foreach ($dbMenuGroups as $dbGroup)
                        @include('layouts.partials.mainmenu._render', ['menuGroup' => $dbGroup])
                    @endforeach
                @endif

                {{-- Menu Template (Bawaan Template Inspinia): Hanya untuk Role Superadmin & Admin --}}
                @if (auth()->check() &&
                        auth()->user()->hasAnyRole(['superadmin', 'admin']))
                    @foreach (['main', 'apps', 'custom-pages', 'layouts', 'components', 'documentation', 'menu-item'] as $groupKey)
                        @php
                            $featureKey = 'menu_group_' . str_replace('-', '_', $groupKey);
                            $isGroupVisible = empty($appFeatures) || !empty($appFeatures->$featureKey);
                            $groupConfig = config("sidenav-template.$groupKey");
                        @endphp
                        @if ($groupConfig)
                            @include('layouts.partials.mainmenu._render', [
                                'menuGroup' => $groupConfig,
                                'featureKey' => $featureKey,
                                'isGroupVisible' => $isGroupVisible,
                            ])
                        @endif
                    @endforeach

                    @php
                        $isMenuItemVisible = empty($appFeatures) || !empty($appFeatures->menu_group_menu_item);
                    @endphp
                    <li class="side-nav-item" data-feature="menu_group_menu_item" style="{{ $isMenuItemVisible ? '' : 'display: none !important;' }}">
                        <a href="#" class="side-nav-link disabled">
                            <span class="menu-icon"><i class="ti ti-ban"></i></span>
                            <span class="menu-text" data-lang="disabled-menu">Disabled Menu</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    @php
        $isSpecialMenuVisible = empty($appFeatures) || !empty($appFeatures->menu_special_menu);
    @endphp
    <div class="sidenav-special-bottom" data-feature="menu_special_menu" style="{{ $isSpecialMenuVisible ? '' : 'display: none !important;' }}">
        <ul class="side-nav mb-0">
            <li class="side-nav-item mb-0">
                <a href="{{ Route::has('template.documentation.changelog') ? route('template.documentation.changelog') : url('template/documentation/changelog') }}" class="side-nav-link special-menu">
                    <span class="menu-icon"><i class="ti ti-star"></i></span>
                    <span class="menu-text" data-lang="special-menu">Special Menu</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Sidenav Menu End -->

<style>
    /* Pin Special Menu to Absolute Bottom of Sidenav Screen */
    .sidenav-menu {
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        height: 100vh !important;
    }

    .sidenav-menu [data-simplebar] {
        height: calc(100vh - var(--theme-topbar-height) - 55px) !important;
        max-height: calc(100vh - var(--theme-topbar-height) - 55px) !important;
    }

    .sidenav-special-bottom {
        position: absolute !important;
        bottom: 6px !important;
        /* Spasi 6px persis dari tepi paling bawah layar sidebar */
        left: 0 !important;
        right: 0 !important;
        z-index: 1050 !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    .sidenav-special-bottom .side-nav,
    .sidenav-special-bottom .side-nav-item {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    html[data-sidenav-size=condensed] .sidenav-special-bottom {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

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

    .side-nav-item .side-nav-link {
        position: relative;
    }

    .side-nav-item .side-nav-link .menu-badge-has-arrow,
    .side-nav-item .side-nav-link .menu-badge-single,
    .side-nav-item .side-nav-link .badge {
        position: absolute;
        right: 36px;
        top: 50%;
        transform: translateY(-50%);
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

        const centerActiveMenuItem = () => {
            const activeLinks = Array.from(sideNav.querySelectorAll('a.active, a.side-nav-link.active'));
            if (activeLinks.length === 0) return;

            const targetActiveLink = activeLinks[activeLinks.length - 1];
            const scrollContainer = document.querySelector('.sidenav-menu .simplebar-content-wrapper') ||
                document.querySelector('.sidenav-menu .scrollbar') ||
                document.querySelector('.sidenav-menu');

            if (!targetActiveLink || !scrollContainer) return;

            const containerRect = scrollContainer.getBoundingClientRect();
            const itemRect = targetActiveLink.getBoundingClientRect();

            const relativeItemTop = itemRect.top - containerRect.top + scrollContainer.scrollTop;
            const targetScrollTop = relativeItemTop - (containerRect.height / 2) + (itemRect.height / 2);

            scrollContainer.scrollTo({
                top: Math.max(0, targetScrollTop),
                behavior: 'smooth'
            });
        };

        setTimeout(centerActiveMenuItem, 350);
        setTimeout(centerActiveMenuItem, 700);

        window.addEventListener('resize', () => {
            setTimeout(centerActiveMenuItem, 150);
        });
    });
</script>
