@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-primary bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white text-primary fw-semibold px-3 py-1.5 rounded-pill mb-3">Version
                                Release History</span>
                            <h2 class="fw-bold text-white mb-2" data-lang="changelog">Changelog & Git Commit History</h2>
                            <p class="text-white-50 fs-16 mb-0">
                                Comprehensive timeline tracking of all architecture updates, menu refactoring, dynamic route
                                integrations, and fixes synced with GitHub commits.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <span
                                class="badge bg-white bg-opacity-20 text-white fs-14 px-3 py-2 border border-white border-opacity-20 rounded-3">
                                <i class="ti ti-git-commit me-1"></i> Current Build: <strong>v1.9.0</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Release Timeline -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-history me-2 text-primary"></i>Git Commit Release
                        Timeline</h5>
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1">12 Versions Logged</span>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-icon-bordered">

                        <!-- Version 1.9.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-star-filled fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.9.0</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest
                                            Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            1411044 &amp; 0ae88be</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-02</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">SweetAlert2 Universal Interceptor, Table Alignment Standard, Back to Top &amp; Sidenav Special Menu Fixes</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">SweetAlert2 Universal Interceptor:</strong> Integrated global form submit listener (<code>data-confirm="..."</code>) intercepting all delete/reset forms with modern SweetAlert2 popups, custom red action buttons, and 12px button gaps.</li>
                                    <li><strong class="text-dark">Standar Format Header Tabel (1-Baris &amp; Center):</strong> Enforced <code>align-middle text-center text-nowrap</code> across all admin DataTables, user management tables, and modal matrix tables for single-line centered presentation.</li>
                                    <li><strong class="text-dark">Fix Posisi Sidenav Special Menu:</strong> Positioned Special Menu at absolute bottom of sidenav screen (5px-6px gap matching menu row spacing) with button background container preservation.</li>
                                    <li><strong class="text-dark">Tombol Floating Back-to-Top:</strong> Added interactive smooth back-to-top floating scroll button partial (<code>layouts/partials/back-to-top.blade.php</code>).</li>
                                    <li><strong class="text-dark">Pembersihan Seeder &amp; Konfigurasi:</strong> Refactored <code>FiturAplikasiSeeder</code> and <code>MenuManajemenPenggunaSeeder</code> for streamlined default app features.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-user-check fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.2</h5>
                                        <span class="badge bg-info-subtle text-info fw-semibold fs-xs">Profile &amp; Identity</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: bbddc7b</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-02</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Management &amp; KTP Identity Details</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Profil Pengguna (`profil-pengguna.blade.php`):</strong> Implemented comprehensive user profile interface displaying detailed KTP card identity (NIK, Nama Lengkap, Tempat/Tgl Lahir, Jenis Kelamin, Alamat, RT/RW, Kelurahan, Kecamatan, Agama, Status Perkawinan, Pekerjaan, Kewarganegaraan).</li>
                                    <li><strong class="text-dark">Avatar Image Renderer:</strong> Updated avatar image rendering to prefer custom uploaded avatars with fallback to default avatar asset (<code>$user-&gt;avatar_url</code>).</li>
                                    <li><strong class="text-dark">Role &amp; Direct Access Overview:</strong> Integrated user roles badge list and direct permissions summary into profile view tabs.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-database fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.1</h5>
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">App Features &amp; Backup</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: d3c1827 &amp; 57c2d7f</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-02</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Application Features Switcher, Database Backup/Restore &amp; App Branding Profile</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Fitur Aplikasi (`fitur-aplikasi.blade.php`):</strong> Added real-time feature switches (Topbar elements, Sidenav menu groups, Special Menu) backed by <code>FiturAplikasi</code> model settings.</li>
                                    <li><strong class="text-dark">Modul Backup DB &amp; Restore (`backup-db.blade.php`):</strong> Implemented one-click automated SQL database backups, file size tracking, file download handler, restore functionality, and selective table backup options.</li>
                                    <li><strong class="text-dark">Profil Aplikasi (`profil-aplikasi.blade.php`):</strong> Built application branding manager for dynamic logo upload (Logo Large, Logo Small, Favicon, Application Name, Tagline, Copyright text).</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-users fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.0</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">User Management</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: 504d930 &amp; f12f6c2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-02</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Management, Spatie Roles, Permissions Catalog &amp; Access Matrix Tables</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Manajemen User (`users.blade.php`):</strong> Built full user management CRUD interface with user avatar rendering, status toggling, and role assignment.</li>
                                    <li><strong class="text-dark">Manajemen Role (`role.blade.php`):</strong> Added role creation, editing, and deletion with permission count badges and role access forms.</li>
                                    <li><strong class="text-dark">Permission Matrix Table Standard (`akses_role.blade.php` &amp; `akses_user.blade.php`):</strong> Implemented Spatie permission matrix table layout (Columns: <code>MODUL / FITUR</code>, <code>CREATE</code>, <code>READ</code>, <code>UPDATE</code>, <code>DELETE</code>, <code>LAINNYA</code>, <code>SEMUA</code>) with high-contrast checkboxes and per-row <code>SEMUA</code> check/uncheck toggles.</li>
                                    <li><strong class="text-dark">Katalog Permission (`permission.blade.php`):</strong> Implemented direct permissions catalog view grouped by application features with CRUD action badges.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.7.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-sitemap fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.7.0</h5>
                                        <span class="badge bg-primary-subtle text-primary fw-semibold fs-xs">Dynamic Menu Engine</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: 876177d &amp; 02ddb3a</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-01</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Database-Driven Dynamic Menu Engine &amp; 3-Level Menu Hierarchy</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Database Menu Engine (`menu.blade.php`):</strong> Converted static sidebar menus to database-driven <code>Menu</code> Eloquent models with full management CRUD.</li>
                                    <li><strong class="text-dark">Dukungan Menu 3 Level:</strong> Enabled 3-level nested sub-menu hierarchy (Menu Utama L1, Sub-Menu L2, Sub-Sub-Menu L3) with recursive collapse rendering, order sorting, and URL path resolution (<code>getRealUrl()</code>).</li>
                                    <li><strong class="text-dark">Kolom URL &amp; Status Centered:</strong> Added URL column after Menu Name displaying resolved URL endpoints, and centered status switch toggles across all 3 levels.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.6.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-language fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.6.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Bilingual
                                            i18n Engine</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-01</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Bilingual Internationalization Engine (ID &amp; EN),
                                    Topbar &amp; Customizer i18n</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Bilingual Language Scope (ID &amp; EN):</strong>
                                        Standardized language selection exclusively to Indonesian (<code>id</code>) and
                                        English (<code>en</code>), removing unused legacy locale files (<code>ar</code>,
                                        <code>de</code>, <code>es</code>, <code>hi</code>, <code>it</code>,
                                        <code>ru</code>). Added <code>id.json</code> matching complete translation
                                        dictionary.</li>
                                    <li><strong class="text-dark">Extended I18nManager Engine:</strong> Enhanced
                                        <code>I18nManager</code> in <code>app.js</code> with absolute translation path
                                        resolution (<code>/assets/data/translations/</code>), cache-busting query strings,
                                        dynamic document <code>&lt;title&gt;</code> updating, and support for
                                        <code>data-lang-placeholder</code>, <code>data-lang-title</code>, and
                                        <code>data-lang-alt</code>.</li>
                                    <li><strong class="text-dark">Topbar &amp; Search Inputs i18n:</strong> Applied
                                        bilingual translation to Topbar search input, search modal, Mega Menu, Apps
                                        dropdown, Notifications, Messages, and User Profile dropdown.</li>
                                    <li><strong class="text-dark">Admin Customizer &amp; Sidenav i18n:</strong> Fully
                                        internationalized <code>customizer.blade.php</code> (Theme Select, Color Scheme,
                                        Topbar Color, Sidenav Color, Sidebar Size, Layout Width, Direction, Position, User
                                        Info, Buttons) and Sidenav search placeholder.</li>
                                    <li><strong class="text-dark">Layout Flex Safety:</strong> Added
                                        <code>flex-shrink-0</code> to Topbar Apps avatar icon containers
                                        (<code>.avatar-md.flex-shrink-0</code>) to ensure icon boxes remain perfectly square
                                        across variable-length translations.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.5.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.5.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Full Icon
                                            Explorers</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-01</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Tabler & Lucide Full Icon Explorers & Recursive
                                    Sidenav Active Route Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tabler Icons Explorer (6,019 Icons):</strong> Implemented
                                        `tabler-full.blade.php` displaying full 6,019 Tabler vector icons with live search,
                                        size select (16-64px), color picker, interactive snippet board, smooth auto scroll
                                        on click, and click-to-copy HTML code.</li>
                                    <li><strong class="text-dark">Lucide Icons Explorer (309+ Icons):</strong> Implemented
                                        `lucide-full.blade.php` matching the exact Tabler pattern with SVG render, snippet
                                        preview, live search, and copy snippet action.</li>
                                    <li><strong class="text-dark">Icon Preview UI Enhancement:</strong> Updated
                                        `tabler-full.blade.php` and `lucide-full.blade.php` Preview Icon card layout to
                                        display the icon name centered directly below the icon while scaling the preview
                                        icon with the Icon Size selector.</li>
                                    <li><strong class="text-dark">Recursive Active Menu Engine:</strong> Updated
                                        `_item.blade.php` with recursive active checking
                                        (<code>str_starts_with($currentRoute, $item['route'] . '-')</code>) so parent
                                        dropdowns (`Icons`) auto-expand and child menu items (`Tabler`, `Lucide`) stay
                                        highlighted when navigating to `-full` sub-routes.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.4.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.4.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            e7c036f & 588b10a</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-08-01</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Documentation Module & Interactive Tree Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tambah Menu Documentation:</strong> Integrated dynamic
                                        `config/sidenav-template/documentation.php` schema for all documentation pages.</li>
                                    <li><strong class="text-dark">Persiapan & Refactor Dokumentasi:</strong> Refactored 10
                                        Documentation Blade templates (`introduction`, `getting-started`,
                                        `folder-structure`, `layouts`, `sidebar`, `topbar`, `theme-skin-setup`, `dark-mode`,
                                        `sources`, `changelog`) to
                                        <code>{{ '@' }}extends('layouts.vertical')</code>.</li>
                                    <li><strong class="text-dark">Interactive Directory Tree:</strong> Upgraded
                                        `folder-structure.blade.php` to use authentic INSPINIA jsTree
                                        (`plugins-treeview.js`) with `wholerow` full-width node highlights and custom file
                                        icons.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.3.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-layout-board fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.3.0</h5>
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">Layout & Custom
                                            Refactor</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            3a391e2 & 5858a50</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-07-31</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Layout Group Demo & Custom Pages Refactoring</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Refactor Template Layouts (18 Views):</strong> Converted
                                        all demo views under `template/layouts/` to
                                        <code>{{ '@' }}extends('layouts.vertical')</code> or
                                        <code>{{ '@' }}extends('layouts.horizontal')</code>.</li>
                                    <li><strong class="text-dark">Preservation of Layout Attributes:</strong> Passed
                                        layout-specific HTML attributes (`data-layout-width="boxed"`,
                                        `data-sidenav-size="compact"`, `data-topbar-color="dark"`,
                                        `class="sidebar-with-line"`) via
                                        <code>{{ '@' }}section('html_attribute')</code>.</li>
                                    <li><strong class="text-dark">Refactor Custom Group:</strong> Refactored auth basic,
                                        card, split, error pages, and custom plugin pages under `template/custom/`.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.2.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-arrows-vertical fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.2.0</h5>
                                        <span class="badge bg-info-subtle text-info fw-semibold fs-xs">Sidenav &
                                            Components</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            7cbf31c & 2f7585d</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-07-31</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Sidenav Auto-Scroll Centering & Component Menu Group
                                </h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Perbaikan Scroll Otomatis Sidenav:</strong> Implemented
                                        `centerActiveMenuItem` script in `sidenav.blade.php` to smoothly scroll active
                                        sub-menu items to 50% vertical center of the sidebar container.</li>
                                    <li><strong class="text-dark">Refactor Kelompok Menu Component & Apps:</strong>
                                        Converted UI elements, charts (Apex & ECharts), forms, tables, icons, and maps views
                                        under `template/components/` and `template/apps/`.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.1.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-route fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.1.0</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Dynamic Routes
                                            & Titles</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            8bea610 & b6d118e</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-07-31</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dynamic Navigation Config & Multi-Word Breadcrumb
                                    Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Perbaikan Page-Title & Breadcrumb:</strong> Updated
                                        `page-title.blade.php` and `title-meta.blade.php` to recursively search
                                        `config('sidenav-template')` for exact multi-word page titles.</li>
                                    <li><strong class="text-dark">Breadcrumb Root Label:</strong> Replaced root breadcrumb
                                        label `Inspinia` with `Template`, and omitted leaf page title from right-hand
                                        breadcrumb trail.</li>
                                    <li><strong class="text-dark">Routing dan Rekursif Menu:</strong> Implemented dynamic
                                        route resolver `routes/template.php` mapping Blade view hierarchy to dot-notation
                                        routes.</li>
                                </ul>
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.0.0</h5>
                                        <span class="badge bg-secondary-subtle text-secondary fw-semibold fs-xs">Initial
                                            Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            bbc6dc0 - e6f6c13</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-calendar me-1"></i> 2026-07-31</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Initial Project Release & Repository Setup</h6>
                                <ul class="text-muted fs-14 mb-0 ps-3">
                                    <li>Initial commit and repository initialization for Repalogic Dashboard template.</li>
                                    <li>Setup core Laravel 12 architecture, Vite asset bundler, and SCSS theme files.</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
