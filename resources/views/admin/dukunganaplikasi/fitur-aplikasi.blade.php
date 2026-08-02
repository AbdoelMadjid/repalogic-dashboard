@extends('layouts.vertical')

@section('title', 'Fitur Aplikasi')

@section('content')
@php
    $topbarFields = [
        'topbar_search_box', 'topbar_megamenu_header', 'topbar_megamenu_apps',
        'topbar_theme_toggler', 'topbar_apps_dropdown', 'topbar_messages',
        'topbar_notifications', 'topbar_fullscreen', 'topbar_monochrome',
        'topbar_customizer', 'topbar_language', 'topbar_user_dropdown'
    ];
    $topbarActiveCount = 0;
    foreach ($topbarFields as $f) {
        if (!empty($fitur->$f)) $topbarActiveCount++;
    }
    $allTopbarActive = ($topbarActiveCount === count($topbarFields));
    $allTopbarInactive = ($topbarActiveCount === 0);

    $sidebarFields = [
        'menu_group_main', 'menu_group_apps', 'menu_group_custom_pages',
        'menu_group_layouts', 'menu_group_components', 'menu_group_documentation',
        'menu_group_menu_item', 'menu_special_menu'
    ];
    $sidebarActiveCount = 0;
    foreach ($sidebarFields as $f) {
        if (!empty($fitur->$f)) $sidebarActiveCount++;
    }
    $allSidebarActive = ($sidebarActiveCount === count($sidebarFields));
    $allSidebarInactive = ($sidebarActiveCount === 0);
@endphp

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Fitur Aplikasi', 'subtitle' => 'Dukungan Aplikasi'])

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-adjustments-alt fs-22"></i>
                        <h5 class="card-title text-white mb-0">Manajemen Visibilitas Fitur & Layout Template</h5>
                    </div>
                    <div>
                        <span class="badge bg-light text-primary fw-semibold px-3 py-2">
                            <i class="ti ti-bolt me-1"></i> Auto Save Instant
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <!-- SECTION 1: TOPBAR HEADER FEATURES -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                            <i class="ti ti-layout-navbar text-primary fs-20"></i>
                            <h5 class="mb-0 text-dark fw-bold">Fitur Topbar Header</h5>
                            <span class="badge bg-primary-subtle text-primary fs-12">12 Komponen</span>
                            @can('update dukunganaplikasi/fitur-aplikasi')
                                <div class="ms-auto d-flex align-items-center gap-1">
                                    <button type="button" class="btn btn-xs btn-outline-success btn-toggle-group" data-group="topbar" data-status="1" {{ $allTopbarActive ? 'disabled' : '' }}>
                                        <i class="ti ti-eye me-1"></i> Tampilkan Semua
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-danger btn-toggle-group" data-group="topbar" data-status="0" {{ $allTopbarInactive ? 'disabled' : '' }}>
                                        <i class="ti ti-eye-off me-1"></i> Sembunyikan Semua
                                    </button>
                                </div>
                            @endcan
                        </div>

                        <div class="row g-3">
                            <!-- Search Box -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-info-subtle text-info rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-search fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Pencarian (Search Box)</h6>
                                                <span class="fs-12 text-muted">Fitur pencarian di topbar</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_search_box" id="topbar_search_box" value="1" {{ $fitur->topbar_search_box ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mega Menu Header -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-layout-grid me-0 fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Mega Menu Header</h6>
                                                <span class="fs-12 text-muted">Dropdown navigasi mega menu</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_megamenu_header" id="topbar_megamenu_header" value="1" {{ $fitur->topbar_megamenu_header ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mega Menu Apps -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-success-subtle text-success rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-apps fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Mega Menu Apps</h6>
                                                <span class="fs-12 text-muted">Shortcut aplikasi mega menu</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_megamenu_apps" id="topbar_megamenu_apps" value="1" {{ $fitur->topbar_megamenu_apps ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme Toggler -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-warning-subtle text-warning rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-sun-moon fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Theme Light/Dark Switcher</h6>
                                                <span class="fs-12 text-muted">Tombol ganti mode terang/gelap</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_theme_toggler" id="topbar_theme_toggler" value="1" {{ $fitur->topbar_theme_toggler ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Apps Grid Dropdown -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-purple-subtle text-purple rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-grid-dots fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Apps Grid Shortcut</h6>
                                                <span class="fs-12 text-muted">Dropdown grid aplikasi pintas</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_apps_dropdown" id="topbar_apps_dropdown" value="1" {{ $fitur->topbar_apps_dropdown ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Dropdown -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-info-subtle text-info rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-messages fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Pesan / Messages</h6>
                                                <span class="fs-12 text-muted">Dropdown notifikasi pesan</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_messages" id="topbar_messages" value="1" {{ $fitur->topbar_messages ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Dropdown -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-danger-subtle text-danger rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-bell fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Notifikasi Alert</h6>
                                                <span class="fs-12 text-muted">Dropdown pengumuman & pemberitahuan</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_notifications" id="topbar_notifications" value="1" {{ $fitur->topbar_notifications ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fullscreen Toggler -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-secondary-subtle text-dark rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-maximize fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Mode Fullscreen</h6>
                                                <span class="fs-12 text-muted">Tombol layar penuh</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_fullscreen" id="topbar_fullscreen" value="1" {{ $fitur->topbar_fullscreen ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Monochrome Toggler -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-dark-subtle text-dark rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-contrast fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Mode Monochrome</h6>
                                                <span class="fs-12 text-muted">Tombol mode hitam putih</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_monochrome" id="topbar_monochrome" value="1" {{ $fitur->topbar_monochrome ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Customizer Offcanvas -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-settings-2 fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Customizer / Theme Settings</h6>
                                                <span class="fs-12 text-muted">Panel Pengaturan Tema Sidebar & Topbar</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_customizer" id="topbar_customizer" value="1" {{ $fitur->topbar_customizer ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Language Selector -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-success-subtle text-success rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-language fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Pemilih Bahasa (Language)</h6>
                                                <span class="fs-12 text-muted">Dropdown bahasa i18n</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_language" id="topbar_language" value="1" {{ $fitur->topbar_language ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Dropdown -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-warning-subtle text-warning rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-user-circle fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">User Profile Dropdown</h6>
                                                <span class="fs-12 text-muted">Dropdown foto profil & menu pengguna</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="topbar_user_dropdown" id="topbar_user_dropdown" value="1" {{ $fitur->topbar_user_dropdown ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: TEMPLATE SIDENAV MENU GROUPS -->
                    <div class="mt-4 pt-2">
                        <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                            <i class="ti ti-layout-sidebar text-primary fs-20"></i>
                            <h5 class="mb-0 text-dark fw-bold">Kelompok Group Menu Template Sidebar</h5>
                            <span class="badge bg-secondary-subtle text-dark fs-12">8 Group & Menu</span>
                            @can('update dukunganaplikasi/fitur-aplikasi')
                                <div class="ms-auto d-flex align-items-center gap-1">
                                    <button type="button" class="btn btn-xs btn-outline-success btn-toggle-group" data-group="menu_group" data-status="1" {{ $allSidebarActive ? 'disabled' : '' }}>
                                        <i class="ti ti-eye me-1"></i> Tampilkan Semua
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-danger btn-toggle-group" data-group="menu_group" data-status="0" {{ $allSidebarInactive ? 'disabled' : '' }}>
                                        <i class="ti ti-eye-off me-1"></i> Sembunyikan Semua
                                    </button>
                                </div>
                            @endcan
                        </div>

                        <div class="row g-3">
                            <!-- Main Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-home fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: MAIN</h6>
                                                <span class="fs-12 text-muted">Menu Dashboards (Analytics, CRM, E-commerce, dll)</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_main" id="menu_group_main" value="1" {{ $fitur->menu_group_main ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Apps Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-success-subtle text-success rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-brand-hipchat fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: APPS</h6>
                                                <span class="fs-12 text-muted">Calendar, Chat, Email, E-Commerce, Projects</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_apps" id="menu_group_apps" value="1" {{ $fitur->menu_group_apps ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Pages Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-warning-subtle text-warning rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-file-description fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: PAGES</h6>
                                                <span class="fs-12 text-muted">Auth, Account Settings, Profile, Error Pages</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_custom_pages" id="menu_group_custom_pages" value="1" {{ $fitur->menu_group_custom_pages ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Layouts Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-info-subtle text-info rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-layout-grid-add fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: LAYOUTS</h6>
                                                <span class="fs-12 text-muted">Horizontal, Detached, Full, Compact Layouts</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_layouts" id="menu_group_layouts" value="1" {{ $fitur->menu_group_layouts ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Components Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-purple-subtle text-purple rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-components fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: COMPONENTS</h6>
                                                <span class="fs-12 text-muted">UI Kit, Extended UI, Forms, Tables, Charts, Icons</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_components" id="menu_group_components" value="1" {{ $fitur->menu_group_components ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentation Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-danger-subtle text-danger rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-books fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: DOCUMENTATION</h6>
                                                <span class="fs-12 text-muted">Dokumentasi template & log perubahan</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_documentation" id="menu_group_documentation" value="1" {{ $fitur->menu_group_documentation ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items Group -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-dark-subtle text-dark rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-list-details fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Group: OTHER MENU ITEMS</h6>
                                                <span class="fs-12 text-muted">Menu multi-level & disabled menu</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_group_menu_item" id="menu_group_menu_item" value="1" {{ $fitur->menu_group_menu_item ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Menu Item -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card border mb-0 h-100 shadow-none hover-border-primary transition-all">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-sm bg-warning-subtle text-warning rounded d-flex align-items-center justify-content-center">
                                                <i class="ti ti-star fs-20"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Menu Spesial (Special Menu)</h6>
                                                <span class="fs-12 text-muted">Tombol menu spesial ber-highlight di sidebar</span>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-large switch-fitur-toggle" type="checkbox" name="menu_special_menu" id="menu_special_menu" value="1" {{ $fitur->menu_special_menu ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light py-3">
                    <span class="text-muted fs-13 d-flex align-items-center gap-2">
                        <i class="ti ti-circle-check text-success fs-18"></i> 
                        <span>Setiap perubahan status sakelar akan langsung tersimpan secara instan di sistem.</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .switch-large {
            width: 2.75em !important;
            height: 1.5em !important;
            cursor: pointer;
        }
        .hover-border-primary:hover {
            border-color: var(--bs-primary) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        }
        .transition-all {
            transition: all 0.2s ease-in-out;
        }
    </style>

    {{-- Page JS (Rule 1 Compliance: Place scripts inside @section('content') before @endsection) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateGroupButtonStates() {
                // Section 1: Topbar
                const topbarSwitches = Array.from(document.querySelectorAll('input[name^="topbar_"]'));
                if (topbarSwitches.length > 0) {
                    const checkedCount = topbarSwitches.filter(sw => sw.checked).length;
                    const btnShowAll = document.querySelector('.btn-toggle-group[data-group="topbar"][data-status="1"]');
                    const btnHideAll = document.querySelector('.btn-toggle-group[data-group="topbar"][data-status="0"]');

                    if (btnShowAll) btnShowAll.disabled = (checkedCount === topbarSwitches.length);
                    if (btnHideAll) btnHideAll.disabled = (checkedCount === 0);
                }

                // Section 2: Sidebar (menu_group_ & menu_special_menu)
                const sidebarSwitches = Array.from(document.querySelectorAll('input[name^="menu_group_"], input[name="menu_special_menu"]'));
                if (sidebarSwitches.length > 0) {
                    const checkedCount = sidebarSwitches.filter(sw => sw.checked).length;
                    const btnShowAll = document.querySelector('.btn-toggle-group[data-group="menu_group"][data-status="1"]');
                    const btnHideAll = document.querySelector('.btn-toggle-group[data-group="menu_group"][data-status="0"]');

                    if (btnShowAll) btnShowAll.disabled = (checkedCount === sidebarSwitches.length);
                    if (btnHideAll) btnHideAll.disabled = (checkedCount === 0);
                }
            }

            // Run initial check on page load
            updateGroupButtonStates();

            // Event Delegation for Instant AJAX Toggle
            document.addEventListener('change', function(e) {
                const target = e.target;
                if (target && target.classList.contains('switch-fitur-toggle')) {
                    updateGroupButtonStates();
                    const featureName = target.getAttribute('name');
                    const isChecked = target.checked ? 1 : 0;
                    
                    target.disabled = true;

                    fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            feature: featureName,
                            status: isChecked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        target.disabled = false;
                        if (data.success) {
                            if (window.Swal) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3500,
                                    timerProgressBar: true,
                                    backdrop: false,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer);
                                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message || 'Status fitur berhasil diperbarui'
                                });
                            }
                            setTimeout(function() {
                                window.location.reload();
                            }, 3500);
                        } else {
                            target.checked = !target.checked; // Revert switch if failed
                            if (window.Swal) {
                                Swal.fire('Gagal', data.message || 'Gagal menyimpan status fitur.', 'error');
                            } else {
                                alert(data.message || 'Gagal menyimpan status fitur.');
                            }
                        }
                    })
                    .catch(error => {
                        target.disabled = false;
                        target.checked = !target.checked; // Revert switch if error
                        console.error('Error toggling feature:', error);
                        if (window.Swal) {
                            Swal.fire('Error', 'Terjadi kesalahan koneksi saat menyimpan fitur.', 'error');
                        } else {
                            alert('Terjadi kesalahan koneksi saat menyimpan fitur.');
                        }
                    });
                }
            });

            // Event Delegation for Group Toggle (Tampilkan Semua / Sembunyikan Semua)
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-toggle-group');
                if (btn) {
                    const groupName = btn.getAttribute('data-group');
                    const statusVal = parseInt(btn.getAttribute('data-status'), 10);
                    
                    btn.disabled = true;

                    fetch("{{ route('admin.dukunganaplikasi.fitur-aplikasi.toggle-group') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            group: groupName,
                            status: statusVal
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        btn.disabled = false;
                        if (data.success) {
                            if (data.fields && Array.isArray(data.fields)) {
                                data.fields.forEach(fieldName => {
                                    const switchInput = document.querySelector(`input[name="${fieldName}"]`);
                                    if (switchInput) {
                                        switchInput.checked = (statusVal === 1);
                                    }
                                });
                            }
                            if (window.Swal) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3500,
                                    timerProgressBar: true,
                                    backdrop: false,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer);
                                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message || 'Status kelompok fitur berhasil diperbarui'
                                });
                            }
                            setTimeout(function() {
                                window.location.reload();
                            }, 3500);
                        } else {
                            if (window.Swal) {
                                Swal.fire('Gagal', data.message || 'Gagal mengubah status kelompok fitur.', 'error');
                            } else {
                                alert(data.message || 'Gagal mengubah status kelompok fitur.');
                            }
                        }
                    })
                    .catch(error => {
                        btn.disabled = false;
                        console.error('Error toggling group:', error);
                        if (window.Swal) {
                            Swal.fire('Error', 'Terjadi kesalahan koneksi saat mengubah status fitur.', 'error');
                        } else {
                            alert('Terjadi kesalahan koneksi saat mengubah status fitur.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
