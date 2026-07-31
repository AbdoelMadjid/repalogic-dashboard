<!doctype html>
<html lang="en" class="sidebar-with-line">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description"
            content="Inspinia is the #1 best-selling admin dashboard template on Wrapmarket. Perfect for building CRM, CMS, project management tools, and custom web apps with clean UI, responsive design, and powerful features." />
        <meta name="keywords"
            content="Inspinia, admin dashboard, Wrapmarket, Wrapbootstrap, HTML template, Bootstrap admin, CRM template, CMS template, responsive admin, web app UI, admin theme, best admin template" />
        <meta name="author" content="WebAppLayers" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
        <!-- Theme Config Js -->
        <script src="{{ asset('assets/js/config.js') }}"></script>

        <!-- Vendor css -->
        <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">
            <header class="app-topbar">
                <div class="container-fluid topbar-menu">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Topbar Brand Logo -->
                        <div class="logo-topbar">
                            <!-- Logo light -->
                            <a href="{{ asset('index.html') }}" class="logo-light">
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                                </span>
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                                </span>
                            </a>

                            <!-- Logo Dark -->
                            <a href="{{ asset('index.html') }}" class="logo-dark">
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
                        <button class="topnav-toggle-button px-2" data-bs-toggle="collapse"
                            data-bs-target="#topnav-menu">
                            <i class="ti ti-menu-4"></i>
                        </button>

                        <div id="search-box" class="app-search d-none d-xl-flex">
                            <input type="search" class="form-control topbar-search" name="search"
                                placeholder="Search for something..." />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>

                        <div id="megamenu-header" class="topbar-item d-none d-md-flex">
                            <div class="dropdown">
                                <button class="topbar-link btn fw-medium btn-link dropdown-toggle drop-arrow-none px-2"
                                    data-bs-toggle="dropdown" type="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    Mega Menu
                                    <i class="ti ti-chevron-down ms-1"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-xxl p-0">
                                    <div class="h-100" style="max-height: 380px" data-simplebar="">
                                        <div class="row g-0">
                                            <div class="col-12">
                                                <div class="px-3 py-2 text-center bg-light bg-opacity-50">
                                                    <h4 class="mb-0 fs-lg fw-semibold">
                                                        Welcome to
                                                        <span class="text-primary">Inspinia</span>
                                                        Admin Theme.
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <div class="p-3">
                                                    <h5 class="mb-2 fw-semibold fs-sm dropdown-header">Dashboard &amp;
                                                        Analytics</h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Sales
                                                                Dashboard</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                                class="dropdown-item">Marketing
                                                                Dashboard</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Finance
                                                                Overview</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">User
                                                                Analytics</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Traffic
                                                                Insights</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="p-3">
                                                    <h5 class="mb-2 fw-semibold fs-sm dropdown-header">Project
                                                        Management
                                                    </h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Task
                                                                Overview</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Kanban
                                                                Board</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Gantt
                                                                Chart</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Team
                                                                Collaboration</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Project
                                                                Milestones</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="p-3">
                                                    <h5 class="mb-2 fw-semibold fs-sm dropdown-header">User Management
                                                    </h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">User
                                                                Profiles</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Access
                                                                Control</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item">Role
                                                                Permissions</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                                class="dropdown-item">Activity
                                                                Logs</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                                class="dropdown-item">Security
                                                                Settings</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="megamenu-apps" class="topbar-item d-none d-md-flex">
                            <div class="dropdown">
                                <button class="topbar-link btn fw-medium btn-link dropdown-toggle drop-arrow-none px-2"
                                    data-bs-toggle="dropdown" type="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    Apps
                                    <i class="ti ti-chevron-down ms-1"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-xxl p-0">
                                    <div class="h-100" style="max-height: 380px" data-simplebar="">
                                        <div class="row g-0">
                                            <div class="col-sm-8">
                                                <div class="row g-0">
                                                    <div class="col-sm-6">
                                                        <div class="p-2">
                                                            <a href="#!" class="dropdown-item">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-primary border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-basket fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">eCommerce</h5>
                                                                        <span class="text-muted fs-12">Products, orders
                                                                            &amp; etc.</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item my-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-success border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-message fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Chat</h5>
                                                                        <span class="text-muted fs-12">Team
                                                                            conversations</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item my-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-danger border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-list-check fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Task</h5>
                                                                        <span class="text-muted fs-12">Plan and track
                                                                            work</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item mt-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-info border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-mailbox fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Email</h5>
                                                                        <span class="text-muted fs-12">Messages and
                                                                            inbox</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="p-2">
                                                            <a href="#!" class="dropdown-item">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-secondary border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-building fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Companies</h5>
                                                                        <span class="text-muted fs-12">Business
                                                                            profiles</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item my-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-dark border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-id fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Contacts Diary
                                                                        </h5>
                                                                        <span class="text-muted fs-12">People and
                                                                            connections</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item my-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-warning border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-calendar fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Calendar</h5>
                                                                        <span class="text-muted fs-12">Events and
                                                                            reminders</span>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <a href="#!" class="dropdown-item mt-2">
                                                                <span class="d-flex align-items-center">
                                                                    <span class="avatar-md me-2">
                                                                        <span
                                                                            class="avatar-title text-success border border-light bg-light bg-opacity-50 rounded">
                                                                            <i class="ti ti-lifebuoy fs-22"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <h5 class="fs-base mb-0 lh-base">Support</h5>
                                                                        <span class="text-muted fs-12">Help and
                                                                            assistance</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row-->

                                                <div class="row g-0 border-top border-light border-dashed text-center">
                                                    <div class="col">
                                                        <div class="p-3">
                                                            <p
                                                                class="fw-medium text-muted mb-2 fs-11 text-uppercase lh-1">
                                                                -: &nbsp; Support &nbsp;:-</p>
                                                            <h5 class="fs-15 mb-0">help@mydomain.com</h5>
                                                        </div>
                                                    </div>
                                                    <!-- end col-->
                                                    <div class="col">
                                                        <div class="p-3">
                                                            <p
                                                                class="fw-medium text-muted mb-2 fs-11 text-uppercase lh-1">
                                                                -: &nbsp; Help: &nbsp;:-</p>
                                                            <h5 class="fs-15 mb-0">+(12) 3456 7890</h5>
                                                        </div>
                                                    </div>
                                                    <!-- end col-->
                                                </div>
                                                <!-- end row-->
                                            </div>
                                            <!-- end col-->

                                            <div class="col-sm-4">
                                                <div class="h-100 position-relative rounded-end rounded-0 overflow-hidden"
                                                    style="background: url(assets/images/stock/small-8.jpg); background-size: cover">
                                                    <div
                                                        class="p-3 card-img-overlay bg-gradient bg-secondary bg-opacity-90 d-flex align-items-center justify-content-center">
                                                        <div class="text-center text-white">
                                                            <i class="ti ti-atom fs-36"></i>

                                                            <p class="text-white text-opacity-75 mb-3 text-uppercase">
                                                                Limited Offer</p>

                                                            <h3 class="fw-semibold text-white mb-2 fs-20">Unlock
                                                                Exclusive
                                                                Savings</h3>

                                                            <h4 class="fw-medium fs-16 mb-1">
                                                                <del class="text-white text-opacity-75">$49.00</del>
                                                                /
                                                                <span class="fw-bold text-white">$25 USD</span>
                                                            </h4>

                                                            <button type="button" class="btn btn-danger btn-sm mt-3">
                                                                <i class="ti ti-shopping-cart me-1"></i>
                                                                Grab Deal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end .bg-light-->
                                            </div>
                                            <!-- end col-->
                                        </div>
                                        <!-- end row-->
                                    </div>
                                    <!-- end .h-100-->
                                </div>
                                <!-- .dropdown-menu-->
                            </div>
                            <!-- .dropdown-->
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div id="theme-toggler" class="topbar-item d-none d-sm-flex">
                            <button class="topbar-link" id="light-dark-mode" type="button">
                                <i class="ti ti-moon topbar-link-icon mode-light-moon"></i>
                                <i class="ti ti-sun topbar-link-icon mode-light-sun"></i>
                            </button>
                        </div>

                        <div id="apps-dropdown-rounded" class="topbar-item">
                            <div class="dropdown">
                                <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    type="button" data-bs-auto-close="outside" aria-haspopup="false"
                                    aria-expanded="false">
                                    <i class="ti ti-apps topbar-link-icon"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-lg p-2 dropdown-menu-end">
                                    <div class="row align-items-center g-1">
                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span class="avatar-title text-bg-light rounded-circle">
                                                        <img src="{{ asset('assets/images/logos/google.svg') }}"
                                                            alt="Google Logo" height="18" />
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Google</span>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span class="avatar-title text-bg-light rounded-circle">
                                                        <img src="{{ asset('assets/images/logos/figma.svg') }}"
                                                            alt="Figma Logo" height="18" />
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Figma</span>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span class="avatar-title text-bg-light rounded-circle">
                                                        <img src="{{ asset('assets/images/logos/slack.svg') }}"
                                                            alt="Slack Logo" height="18" />
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Slack</span>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span class="avatar-title text-bg-light rounded-circle">
                                                        <img src="{{ asset('assets/images/logos/dropbox.svg') }}"
                                                            alt="Dropbox Logo" height="18" />
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Dropbox</span>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span
                                                        class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                        <i class="ti ti-calendar fs-18"></i>
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Calendar</span>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <a href="javascript:void(0);"
                                                class="dropdown-item rounded text-center py-2">
                                                <span class="avatar-sm d-block mx-auto mb-1">
                                                    <span
                                                        class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                        <i class="ti ti-folder fs-18"></i>
                                                    </span>
                                                </span>
                                                <span class="align-middle fw-medium">Files</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End dropdown-menu -->
                            </div>
                            <!-- end dropdown-->
                        </div>

                        <div id="simple-messages-dropdown" class="topbar-item">
                            <div class="dropdown">
                                <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    type="button" data-bs-auto-close="outside" aria-haspopup="false"
                                    aria-expanded="false">
                                    <i class="ti ti-mail topbar-link-icon"></i>
                                    <span class="badge text-bg-success badge-circle topbar-badge">7</span>
                                </button>

                                <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                    <div class="px-3 py-2 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-md fw-semibold">Messages</h6>
                                            </div>
                                            <div class="col text-end">
                                                <a href="#!" class="badge badge-soft-success badge-label py-1">09
                                                    Notifications</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="max-height: 300px" data-simplebar="">
                                        <!-- item 1 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap active"
                                            id="message-1">
                                            <span class="d-flex gap-3">
                                                <span class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-1.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="User Avatar" />
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Liam Carter</span>
                                                    uploaded a new document to
                                                    <span class="fw-medium text-body">Project Phoenix</span>
                                                    <br />
                                                    <span class="fs-xs">5 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-1">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 2 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap" id="message-2">
                                            <span class="d-flex gap-3">
                                                <span class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-2.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="User Avatar" />
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Ava Mitchell</span>
                                                    commented on
                                                    <span class="fw-medium text-body">Marketing Campaign Q3</span>
                                                    <br />
                                                    <span class="fs-xs">12 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-2">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 3 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap" id="message-3">
                                            <span class="d-flex gap-3">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title text-bg-info rounded-circle fs-22">
                                                        <i class="ti ti-user-hexagon fs-22"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Noah Blake</span>
                                                    updated the status of
                                                    <span class="fw-medium text-body">Client Onboarding</span>
                                                    <br />
                                                    <span class="fs-xs">30 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-3">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 4 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap" id="message-4">
                                            <span class="d-flex gap-3">
                                                <span class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-4.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="User Avatar" />
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Sophia Taylor</span>
                                                    sent an invoice for
                                                    <span class="fw-medium text-body">Service Renewal</span>
                                                    <br />
                                                    <span class="fs-xs">1 hour ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-4">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 5 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap" id="message-5">
                                            <span class="d-flex gap-3">
                                                <span class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-5.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="User Avatar" />
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Ethan Moore</span>
                                                    completed the task
                                                    <span class="fw-medium text-body">UI Review</span>
                                                    <br />
                                                    <span class="fs-xs">2 hours ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-5">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 6 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap" id="message-6">
                                            <span class="d-flex gap-3">
                                                <span class="flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-6.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="User Avatar" />
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Olivia White</span>
                                                    assigned you a task in
                                                    <span class="fw-medium text-body">Sales Pipeline</span>
                                                    <br />
                                                    <span class="fs-xs">Yesterday</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#message-6">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">Read
                                        All Messages</a>
                                </div>
                                <!-- End dropdown-menu -->
                            </div>
                            <!-- end dropdown-->
                        </div>

                        <div id="notification-dropdown-alert" class="topbar-item">
                            <div class="dropdown">
                                <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                    type="button" data-bs-auto-close="outside" aria-haspopup="false"
                                    aria-expanded="false">
                                    <i class="ti ti-bell topbar-link-icon"></i>
                                    <span class="badge badge-square text-bg-warning topbar-badge">12</span>
                                </button>

                                <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                    <div class="px-3 py-2 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-md fw-semibold">Notifications</h6>
                                            </div>
                                            <div class="col text-end">
                                                <a href="#!" class="badge text-bg-light badge-label py-1">12
                                                    Alerts</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="max-height: 300px" data-simplebar="">
                                        <!-- item 1 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-1">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle text-danger rounded">
                                                        <i
                                                            class="ti ti-server-bolt notification-item-icon fill-danger"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Critical alert: Server crash
                                                        detected</span>
                                                    <br />
                                                    <span class="fs-xs">30 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-1">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 2 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-2">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-warning-subtle text-warning rounded">
                                                        <i
                                                            class="ti ti-alert-triangle notification-item-icon fill-warning"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">High memory usage on Node
                                                        A</span>
                                                    <br />
                                                    <span class="fs-xs">10 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-2">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 3 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-3">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle text-success rounded">
                                                        <i
                                                            class="ti ti-circle-check notification-item-icon fill-success"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Backup completed
                                                        successfully</span>
                                                    <br />
                                                    <span class="fs-xs">1 hour ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-3">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 4 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-4">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle text-primary rounded">
                                                        <i
                                                            class="ti ti-user-plus notification-item-icon fill-primary"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">New user registration: Sarah
                                                        Miles</span>
                                                    <br />
                                                    <span class="fs-xs">Just now</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-4">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 5 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-5">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle text-danger rounded">
                                                        <i class="ti ti-bug notification-item-icon fill-danger"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Bug reported in payment
                                                        module</span>
                                                    <br />
                                                    <span class="fs-xs">20 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-5">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 6 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-6">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle text-info rounded">
                                                        <i
                                                            class="ti ti-message-circle notification-item-icon fill-info"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">New comment on Task #142</span>
                                                    <br />
                                                    <span class="fs-xs">15 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-6">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 7 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-7">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-warning-subtle text-warning rounded">
                                                        <i
                                                            class="ti ti-battery-charging notification-item-icon fill-warning"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Low battery on Device X</span>
                                                    <br />
                                                    <span class="fs-xs">45 minutes ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-7">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 8 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-8">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle text-success rounded">
                                                        <i
                                                            class="ti ti-cloud-upload notification-item-icon fill-success"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">File upload completed</span>
                                                    <br />
                                                    <span class="fs-xs">1 hour ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-8">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 9 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-9">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle text-primary rounded">
                                                        <i
                                                            class="ti ti-calendar notification-item-icon fill-primary"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Team meeting scheduled at 3
                                                        PM</span>
                                                    <br />
                                                    <span class="fs-xs">2 hours ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-9">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 10 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-10">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span
                                                        class="avatar-title bg-secondary-subtle text-secondary rounded">
                                                        <i
                                                            class="ti ti-download notification-item-icon fill-secondary"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Report ready for download</span>
                                                    <br />
                                                    <span class="fs-xs">3 hours ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-10">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 11 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-11">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle text-danger rounded">
                                                        <i class="ti ti-lock notification-item-icon fill-danger"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Multiple failed login
                                                        attempts</span>
                                                    <br />
                                                    <span class="fs-xs">5 hours ago</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-11">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <!-- item 12 -->
                                        <div class="dropdown-item notification-item py-2 text-wrap"
                                            id="notification-12">
                                            <span class="d-flex gap-2">
                                                <span class="avatar-md flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle text-info rounded">
                                                        <i
                                                            class="ti ti-bell-ringing notification-item-icon fill-info"></i>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1 text-muted">
                                                    <span class="fw-medium text-body">Reminder: Submit your
                                                        timesheet</span>
                                                    <br />
                                                    <span class="fs-xs">Today, 9:00 AM</span>
                                                </span>
                                                <button type="button"
                                                    class="flex-shrink-0 text-muted btn btn-link p-0"
                                                    data-dismissible="#notification-12">
                                                    <i class="ti ti-square-rounded-x fs-xxl"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- end dropdown-->

                                    <!-- All-->
                                    <a href="javascript:void(0);"
                                        class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">View
                                        All Alerts</a>
                                </div>
                            </div>
                        </div>

                        <div id="fullscreen-toggler" class="topbar-item d-none d-md-flex">
                            <button class="topbar-link" type="button" data-toggle="fullscreen">
                                <i class="ti ti-maximize topbar-link-icon"></i>
                                <i class="ti ti-minimize topbar-link-icon d-none"></i>
                            </button>
                        </div>

                        <div id="monochrome-toggler" class="topbar-item d-none d-xl-flex">
                            <button id="monochrome-mode" class="topbar-link" type="button"
                                data-toggle="monochrome">
                                <i class="ti ti-palette topbar-link-icon"></i>
                            </button>
                        </div>

                        <div class="topbar-item d-none d-sm-flex">
                            <button class="topbar-link btn-theme-setting" data-bs-toggle="offcanvas"
                                data-bs-target="#theme-settings-offcanvas" type="button">
                                <i class="ti ti-settings topbar-link-icon"></i>
                            </button>
                        </div>

                        <div id="language-selector" class="topbar-item">
                            <div class="dropdown">
                                <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button"
                                    aria-haspopup="false" aria-expanded="false">
                                    <img src="{{ asset('assets/images/flags/us.svg') }}" alt="user-image"
                                        class="rounded me-2" height="18" id="selected-language-image" />
                                    <span id="selected-language-code">EN</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en"
                                        title="English">
                                        <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">English</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="de"
                                        title="German">
                                        <img src="{{ asset('assets/images/flags/de.svg') }}" alt="German"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">Deutsch</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="it"
                                        title="Italian">
                                        <img src="{{ asset('assets/images/flags/it.svg') }}" alt="Italian"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">Italiano</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="es"
                                        title="Spanish">
                                        <img src="{{ asset('assets/images/flags/es.svg') }}" alt="Spanish"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">Español</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="ru"
                                        title="Russian">
                                        <img src="{{ asset('assets/images/flags/ru.svg') }}" alt="Russian"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">Русский</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="hi"
                                        title="Hindi">
                                        <img src="{{ asset('assets/images/flags/in.svg') }}" alt="Hindi"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">हिन्दी</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="ar"
                                        title="Arabic">
                                        <img src="{{ asset('assets/images/flags/sa.svg') }}" alt="Arabic"
                                            class="me-1 rounded" height="18" data-translator-image="" />
                                        <span class="align-middle">عربي</span>
                                    </a>
                                </div>
                                <!-- end dropdown-menu-->
                            </div>
                            <!-- end dropdown-->
                        </div>

                        <div id="simple-user-dropdown" class="topbar-item nav-user">
                            <div class="dropdown">
                                <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                                    href="#!" aria-haspopup="false" aria-expanded="false">
                                    <img src="{{ asset('assets/images/users/user-1.jpg') }}" width="32"
                                        class="rounded-circle me-lg-2 d-flex" alt="user-image" />
                                    <div class="d-lg-flex align-items-center gap-1 d-none">
                                        <h5 class="my-0">Damian D.</h5>
                                        <i class="ti ti-chevron-down align-middle"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- Header -->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome back!</h6>
                                    </div>

                                    <!-- My Profile -->
                                    <a href="#!" class="dropdown-item">
                                        <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">Profile</span>
                                    </a>

                                    <!-- Notifications -->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-bell-ringing me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">Notifications</span>
                                    </a>

                                    <!-- Wallet -->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-credit-card me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">
                                            Balance:
                                            <span class="fw-semibold">$985.25</span>
                                        </span>
                                    </a>

                                    <!-- Settings -->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">Account Settings</span>
                                    </a>

                                    <!-- Support -->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="ti ti-headset me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">Support Center</span>
                                    </a>

                                    <!-- Divider -->
                                    <div class="dropdown-divider"></div>

                                    <!-- Lock -->
                                    <a href="{{ asset('auth-lock-screen.html') }}" class="dropdown-item">
                                        <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                                        <span class="align-middle">Lock Screen</span>
                                    </a>

                                    <!-- Logout -->
                                    <a href="javascript:void(0);" class="dropdown-item text-danger fw-semibold"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti ti-logout-2 me-2 fs-17 align-middle"></i>
                                        <span class="align-middle" data-lang="topbar-user-log-out">Log Out</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-transparent">
                        <form>
                            <div class="card mb-1">
                                <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                                    <i class="ti ti-search fs-22"></i>
                                    <input type="search" class="form-control border-0" id="search-modal-input"
                                        placeholder="Search for actions, people," />
                                    <button type="submit" class="btn p-0" data-bs-dismiss="modal"
                                        aria-label="Close">[esc]</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.partials.sidenav')
            <!-- Sidenav Menu End -->


            <!-- ============================================================== -->
            <!-- Start Main Content -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-xxl-3 col-xl-6 order-xl-1 order-xxl-0">
                                            <div class="p-4 border-end border-dashed">
                                                <h4 class="fs-lg mb-1">Welcome to INSPINIA+ Admin Theme.</h4>
                                                <span class="text-muted">You have <span
                                                        class="text-primary fw-semibold">42</span> messages and 6
                                                    notifications.</span>
                                                <ul class="list-group list-group-flush mt-3">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                        <div>
                                                            <span class="badge text-bg-primary avatar-xs me-2"><span
                                                                    class="avatar-title fw-medium fs-sm">1</span></span>
                                                            Reviewed project proposal
                                                        </div>
                                                        <span class="text-muted">09:30 AM</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                        <div>
                                                            <span class="badge text-bg-info avatar-xs me-2"><span
                                                                    class="avatar-title fw-medium fs-sm">2</span></span>
                                                            Team stand-up meeting
                                                        </div>
                                                        <span class="text-muted">11:00 AM</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                        <div>
                                                            <span class="badge text-bg-secondary avatar-xs me-2"><span
                                                                    class="avatar-title fw-medium fs-sm">3</span></span>
                                                            Sent client invoice
                                                        </div>
                                                        <span class="text-muted">01:15 PM</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                        <div>
                                                            <span class="badge text-bg-light avatar-xs me-2"><span
                                                                    class="avatar-title fw-medium fs-sm">4</span></span>
                                                            Responded to support tickets
                                                        </div>
                                                        <span class="text-muted">03:40 PM</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                        <div>
                                                            <span class="badge text-bg-warning avatar-xs me-2"><span
                                                                    class="avatar-title fw-medium fs-sm">5</span></span>
                                                            Finalized design mockups
                                                        </div>
                                                        <span class="text-muted">05:10 PM</span>
                                                    </li>
                                                </ul>

                                                <div class="text-center mt-2">
                                                    <a href="#!" class="btn btn-secondary rounded-pill">View
                                                        Messages</a>
                                                </div>
                                            </div>
                                            <!-- end .p-4-->
                                            <hr class="d-xxl-none border-light m-0" />
                                        </div>
                                        <!-- end col-->
                                        <div class="col-xxl-6 order-xl-3 order-xxl-1">
                                            <div class="px-4 py-3 border-end border-dashed">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <h4 class="card-title">Revenue</h4>
                                                    <a href="#!"
                                                        class="link-reset text-decoration-underline fw-semibold link-offset-3">View
                                                        Reports <i class="ti ti-arrow-right"></i></a>
                                                </div>

                                                <div class="row text-center mb-3">
                                                    <div class="col">
                                                        <div class="bg-light bg-opacity-50 p-2">
                                                            <h5 class="m-0"><span class="text-muted">Total
                                                                    Revenue:</span>$ <span data-target="40">0</span>M
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="bg-light bg-opacity-50 p-2">
                                                            <h5 class="m-0"><span class="text-muted">Total
                                                                    Orders:</span> <span data-target="50.9">0</span>k
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div dir="ltr" class="position-relative">
                                                    <div class="py-2 px-3 rounded-3 bg-light-subtle border text-primary z-1 position-absolute"
                                                        style="top: 4.5%; left: 12%">
                                                        <p class="mb-2 text-uppercase fs-xxs fw-semibold">Growth Rate
                                                        </p>
                                                        <h4 class="mb-0 fw-bold text-primary">89.24% <i
                                                                class="ti ti-trending-up"></i></h4>
                                                    </div>
                                                    <div id="revenue-chart" style="min-height: 252px"></div>
                                                </div>
                                            </div>
                                            <!-- end .px-4-->
                                        </div>
                                        <!-- end col-->
                                        <div class="col-xxl-3 col-xl-6 order-xl-2 order-xxl-2">
                                            <div class="p-3">
                                                <h4 class="card-title mb-1">Project Progress</h4>
                                                <p class="text-muted fs-xs">You have 21 projects with not completed
                                                    task.
                                                </p>
                                                <div class="row mt-4">
                                                    <div class="col-lg-12">
                                                        <div dir="ltr">
                                                            <div id="project-progress-chart"
                                                                style="min-height: 278px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="d-xxl-none border-light m-0" />
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row-->

                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 align-items-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="#!" class="text-muted float-end mt-n1 fs-xl"><i
                                            class="ti ti-external-link"></i></a>
                                    <h5 title="Number of Tasks">My Tasks</h5>
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <div class="avatar-md flex-shrink-0">
                                            <span class="avatar-title text-bg-light rounded-circle fs-22">
                                                <i class="ti ti-checklist"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0"><span data-target="124">0</span></h3>
                                        <span class="badge badge-soft-primary fw-medium ms-2 fs-xs ms-auto">+3
                                            New</span>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-primary"><i class="ti ti-point-filled"></i></span>
                                        <span class="text-nowrap text-muted">Total Tasks</span>
                                        <span class="float-end"><b>12,450</b></span>
                                    </p>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="#!" class="text-muted float-end mt-n1 fs-xl"><i
                                            class="ti ti-external-link"></i></a>
                                    <h5 title="Number of Messages">Messages</h5>
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <div class="avatar-md flex-shrink-0">
                                            <span class="avatar-title text-bg-light rounded-circle fs-22">
                                                <i class="ti ti-message-circle"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0"><span data-target="69.5">0</span>k</h3>
                                        <span class="badge badge-soft-secondary fw-medium ms-2 fs-xs ms-auto">+5
                                            New</span>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-secondary"><i class="ti ti-point-filled"></i></span>
                                        <span class="text-nowrap text-muted">Total Messages</span>
                                        <span class="float-end"><b>32.1M</b></span>
                                    </p>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="#!" class="text-muted float-end mt-n1 fs-xl"><i
                                            class="ti ti-external-link"></i></a>
                                    <h5 title="Pending Approvals">Approvals</h5>
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <div class="avatar-md flex-shrink-0">
                                            <span class="avatar-title text-bg-light rounded-circle fs-22">
                                                <i class="ti ti-file-check"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0"><span data-target="32">0</span></h3>
                                        <span class="badge text-bg-light fw-medium ms-2 fs-xs ms-auto">+2 New</span>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-primary"><i class="ti ti-point-filled"></i></span>
                                        <span class="text-nowrap text-muted">Total Approvals</span>
                                        <span class="float-end"><b>1,024</b></span>
                                    </p>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <a href="#!" class="text-muted float-end mt-n1 fs-xl"><i
                                            class="ti ti-external-link"></i></a>
                                    <h5 title="Total Clients">Clients</h5>
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <div class="avatar-md flex-shrink-0">
                                            <span class="avatar-title text-bg-light rounded-circle fs-22">
                                                <i class="ti ti-users"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0"><span data-target="184">0</span></h3>
                                        <span class="badge badge-soft-secondary fw-medium ms-2 fs-xs ms-auto">+4
                                            New</span>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-secondary"><i class="ti ti-point-filled"></i></span>
                                        <span class="text-nowrap text-muted">Total Clients</span>
                                        <span class="float-end"><b>9,835</b></span>
                                    </p>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-lg col-md-auto">
                            <div class="card">
                                <div class="card-body">
                                    <a href="#!" class="text-muted float-end mt-n1 fs-xl"><i
                                            class="ti ti-external-link"></i></a>
                                    <h5 title="Revenue Generated">Revenue</h5>
                                    <div class="d-flex align-items-center gap-2 my-3">
                                        <div class="avatar-md flex-shrink-0">
                                            <span class="avatar-title text-bg-light rounded-circle fs-22">
                                                <i class="ti ti-credit-card"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0">$<span data-target="125.5">0</span>k</h3>
                                        <span
                                            class="badge badge-soft-primary fw-medium ms-2 fs-xs ms-auto">+1.5%</span>
                                    </div>
                                    <p class="mb-0">
                                        <span class="text-primary"><i class="ti ti-point-filled"></i></span>
                                        <span class="text-nowrap text-muted">Total Revenue</span>
                                        <span class="float-end"><b>$12.5M</b></span>
                                    </p>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-header justify-content-between align-items-center">
                                    <h5 class="card-title">Quarterly Reports <span
                                            class="badge text-bg-primary">IN+</span></h5>
                                    <div class="card-action">
                                        <a href="#!" class="card-action-item" data-action="card-toggle"><i
                                                class="ti ti-chevron-up"></i></a>
                                        <a href="#!" class="card-action-item" data-action="card-refresh"><i
                                                class="ti ti-refresh"></i></a>
                                        <a href="#!" class="card-action-item" data-action="card-close"><i
                                                class="ti ti-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-custom table-nowrap table-hover table-centered mb-0">
                                            <thead class="bg-light bg-opacity-25 thead-sm">
                                                <tr class="text-uppercase fs-xxs">
                                                    <th class="text-muted">Quarter</th>
                                                    <th class="text-muted">Revenue</th>
                                                    <th class="text-muted">Expense</th>
                                                    <th class="text-muted">Margin</th>
                                                    <th class="text-muted">•••</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h5 class="fs-sm mb-1 fw-normal">Quarter 1</h5>
                                                        <span class="text-muted fs-xs">January - March 2024</span>
                                                    </td>
                                                    <td>$210k</td>
                                                    <td>$165k</td>
                                                    <td>$45k</td>
                                                    <td style="width: 60px">
                                                        <div dir="ltr">
                                                            <div class="donut-chart" data-chart="donut"
                                                                style="min-height: 30px"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="fs-sm mb-1 fw-normal">Quarter 2</h5>
                                                        <span class="text-muted fs-xs">April - June 2024</span>
                                                    </td>
                                                    <td>$225k</td>
                                                    <td>$175k</td>
                                                    <td>$50k</td>
                                                    <td style="width: 60px">
                                                        <div dir="ltr">
                                                            <div class="donut-chart" data-chart="donut"
                                                                style="min-height: 30px"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="fs-sm mb-1 fw-normal">Quarter 3</h5>
                                                        <span class="text-muted fs-xs">July - September 2024</span>
                                                    </td>
                                                    <td>$240k</td>
                                                    <td>$190k</td>
                                                    <td>$50k</td>
                                                    <td style="width: 60px">
                                                        <div dir="ltr">
                                                            <div class="donut-chart" data-chart="donut"
                                                                style="min-height: 30px"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5 class="fs-sm mb-1 fw-normal">Quarter 4</h5>
                                                        <span class="text-muted fs-xs">October - December 2024</span>
                                                    </td>
                                                    <td>$260k</td>
                                                    <td>$200k</td>
                                                    <td>$60k</td>
                                                    <td style="width: 60px">
                                                        <div dir="ltr">
                                                            <div class="donut-chart" data-chart="donut"
                                                                style="min-height: 30px"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive-->
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->

                            <div class="card">
                                <div class="card-header justify-content-between align-items-center">
                                    <h5 class="card-title">Project Performance</h5>
                                    <div class="card-action">
                                        <a href="#!" class="card-action-item" data-action="card-toggle"><i
                                                class="ti ti-chevron-up"></i></a>
                                        <a href="#!" class="card-action-item" data-action="card-refresh"><i
                                                class="ti ti-refresh"></i></a>
                                        <a href="#!" class="card-action-item" data-action="card-close"><i
                                                class="ti ti-x"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="fs-base mb-2">Completed Projects</h5>
                                            <div>
                                                <span>+ 180</span>
                                                <span><i class="ti ti-circle-filled text-light mx-3 fs-10"></i>
                                                    54.20%</span>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: 54.2%" aria-valuenow="54.20" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="fs-base mb-2">Ongoing Projects</h5>
                                            <div>
                                                <span>+ 120</span>
                                                <span><i class="ti ti-circle-filled text-light mx-3 fs-10"></i>
                                                    36.15%</span>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 36.15%" aria-valuenow="36.15" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="fs-base mb-2">Pending Approvals</h5>
                                            <div>
                                                <span>+ 32</span>
                                                <span><i class="ti ti-circle-filled text-light mx-3 fs-10"></i>
                                                    9.65%</span>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm mb-1">
                                            <div class="progress-bar bg-secondary" role="progressbar"
                                                style="width: 9.65%" aria-valuenow="9.65" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-xxl-4 col-xl-6">
                            <div class="card">
                                <div class="card-header justify-content-between align-items-center">
                                    <h5 class="card-title">Latest Project Updates</h5>
                                    <span class="badge text-bg-warning fs-xxs p-1"> 8 Notifications</span>
                                </div>
                                <div class="card-body">
                                    <div class="timeline timeline-icon-bordered">
                                        <!-- Event 1 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-rocket fs-xl text-primary"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">New Feature Released <span
                                                            class="badge badge-label badge-soft-info ms-2">Deploy</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 3:45 PM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Launched the real-time chat feature across
                                                    all
                                                    user accounts.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-6.jpg') }}"
                                                        alt="Natalie Brooks" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Natalie Brooks</a>
                                                </div>

                                                <hr class="border-dashed" />
                                            </div>
                                        </div>

                                        <!-- Event 2 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-calendar-event fs-xl text-warning"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">Team Sync-Up <span
                                                            class="badge badge-label badge-soft-secondary ms-2">Meeting</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 2:00 PM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Reviewed sprint progress and discussed
                                                    remaining tasks with the dev team.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-4.jpg') }}"
                                                        alt="Oliver Grant" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Oliver Grant</a>
                                                </div>

                                                <hr class="border-dashed" />
                                            </div>
                                        </div>

                                        <!-- Event 3 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-palette fs-xl text-success"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">UI Design Review <span
                                                            class="badge badge-label badge-soft-success ms-2">Design</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 1:15 PM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Updated component spacing and colors for
                                                    improved accessibility.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-9.jpg') }}"
                                                        alt="Clara Jensen" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Clara Jensen</a>
                                                </div>

                                                <hr class="border-dashed" />
                                            </div>
                                        </div>

                                        <!-- Event 4 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-database fs-xl text-danger"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">Database Optimization <span
                                                            class="badge badge-label badge-soft-danger ms-2">Backend</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 12:30 PM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Improved DB query performance, reducing
                                                    load
                                                    time by 35%.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-10.jpg') }}"
                                                        alt="Leo Armstrong" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Leo Armstrong</a>
                                                </div>

                                                <hr class="border-dashed" />
                                            </div>
                                        </div>

                                        <!-- Event 5 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-shield-check fs-xl text-info"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">Security Audit Completed <span
                                                            class="badge badge-label badge-soft-warning ms-2">Audit</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 11:00 AM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Completed internal security audit with no
                                                    critical issues found.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-8.jpg') }}"
                                                        alt="Liam Carter" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Liam Carter</a>
                                                </div>

                                                <hr class="border-dashed" />
                                            </div>
                                        </div>

                                        <!-- Event 6 -->
                                        <div class="timeline-item d-flex align-items-stretch">
                                            <div class="timeline-dot">
                                                <i class="ti ti-user-plus fs-xl text-success"></i>
                                            </div>
                                            <div class="timeline-content ps-3">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1 fs-base">New Team Member Joined <span
                                                            class="badge badge-label badge-soft-primary ms-2">Onboarding</span>
                                                    </h5>
                                                    <span class="text-muted fs-xxs">Today at 10:15 AM</span>
                                                </div>
                                                <p class="mb-1 text-muted">Michael Lee has joined the development team
                                                    as
                                                    a Frontend Engineer.</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('assets/images/users/user-7.jpg') }}"
                                                        alt="Emma Davis" class="rounded-circle avatar-xxs" />
                                                    <a href="{{ asset('pages-profile.html') }}"
                                                        class="fw-medium link-reset text-muted">Emma Davis</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end timeline-->
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->

                        <div class="col-xxl-4 col-xl-6">
                            <div class="card">
                                <div class="card-header justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        Discussions
                                        <span class="badge bg-primary-subtle text-primary">Pro+</span>
                                    </h5>
                                    <a href="#!" class="badge text-bg-light fs-xs fw-semibold p-1">Mark all as
                                        read</a>
                                </div>

                                <div class="card-body bg-light-subtle border-bottom border-dashed">
                                    <div class="d-flex gap-2">
                                        <div class="me-2 flex-shrink-0">
                                            <img src="{{ asset('assets/images/message-mail.png') }}" height="36"
                                                alt="message img" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="fs-sm mb-1">New messages</h4>
                                            <p class="fs-xs mb-0 text-body-secondary">You have <span
                                                    class="text-body fw-semibold">22</span> new messages and <span
                                                    class="text-body fw-semibold">16</span> waiting in draft folder.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body-->

                                <div class="card-body pt-1">
                                    <ul class="list-group list-group-flush mb-3">
                                        <!-- User 1 -->
                                        <li class="list-group-item px-0 border-light">
                                            <div class="d-flex gap-2">
                                                <div class="me-2 flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-8.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="user-8" />
                                                </div>
                                                <div class="flex-grow-1 text-muted">
                                                    <h6 class="text-body mb-1 fs-base d-flex justify-content-between">
                                                        Alex Johnson
                                                        <small class="fs-xs text-body-secondary">10m ago</small>
                                                    </h6>
                                                    <p class="mb-1">Excited to share our latest project update with
                                                        everyone!</p>
                                                    <a href="{{ asset('chat.html') }}"
                                                        class="badge badge-soft-primary p-1">Reply</a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- User 2 -->
                                        <li class="list-group-item px-0 border-light">
                                            <div class="d-flex gap-2">
                                                <div class="me-2 flex-shrink-0">
                                                    <div class="avatar avatar-md">
                                                        <span
                                                            class="avatar-title bg-purple-subtle text-purple rounded-circle fw-bold">DN</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-muted">
                                                    <h6 class="text-body mb-1 fs-base d-flex justify-content-between">
                                                        Den Nowdya
                                                        <small class="fs-xs text-body-secondary">1h ago</small>
                                                    </h6>
                                                    <p class="mb-1">Looking forward to the upcoming team meeting.
                                                    </p>
                                                    <a href="{{ asset('chat.html') }}"
                                                        class="badge badge-soft-primary p-1">Reply</a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- User 3 -->
                                        <li class="list-group-item px-0 border-light">
                                            <div class="d-flex gap-2">
                                                <div class="me-2 flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-10.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="user-10" />
                                                </div>
                                                <div class="flex-grow-1 text-muted">
                                                    <h6 class="text-body mb-1 fs-base d-flex justify-content-between">
                                                        Michael Brown
                                                        <small class="fs-xs text-body-secondary">16h ago</small>
                                                    </h6>
                                                    <p class="mb-1">Great insights shared in today's brainstorming
                                                        session!</p>
                                                    <a href="{{ asset('chat.html') }}"
                                                        class="badge badge-soft-primary p-1">Reply</a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- User 4 -->
                                        <li class="list-group-item px-0 border-light">
                                            <div class="d-flex gap-2">
                                                <div class="me-2 flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-1.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="user-1" />
                                                </div>
                                                <div class="flex-grow-1 text-muted">
                                                    <h6 class="text-body mb-1 fs-base d-flex justify-content-between">
                                                        Emily Watson
                                                        <small class="fs-xs text-body-secondary">20h ago</small>
                                                    </h6>
                                                    <p class="mb-1">Wrapping up an amazing design concept for the
                                                        client.</p>
                                                    <a href="{{ asset('chat.html') }}"
                                                        class="badge badge-soft-primary p-1">Reply</a>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- User 5 -->
                                        <li class="list-group-item px-0 border-light">
                                            <div class="d-flex gap-2">
                                                <div class="me-2 flex-shrink-0">
                                                    <img src="{{ asset('assets/images/users/user-6.jpg') }}"
                                                        class="avatar-md rounded-circle" alt="user-6" />
                                                </div>
                                                <div class="flex-grow-1 text-muted">
                                                    <h6 class="text-body mb-1 fs-base d-flex justify-content-between">
                                                        Monica Smith
                                                        <small class="fs-xs text-body-secondary">2 days ago</small>
                                                    </h6>
                                                    <p class="mb-1">Testing some new UI enhancements—excited for
                                                        feedback!</p>
                                                    <a href="{{ asset('chat.html') }}"
                                                        class="badge badge-soft-primary p-1">Reply</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="text-center mt-3">
                                        <a href="{{ asset('chat.html') }}"
                                            class="link-reset text-decoration-underline fw-semibold link-offset-3"> Go
                                            to
                                            Chat Room <i class="ti ti-send-2"></i> </a>
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row-->
                </div>
                <!-- container -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start">
                                ©
                                <span data-current-year></span>
                                Inspinia By
                                <span class="fw-semibold">WebAppLayers</span>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end d-none d-md-block">
                                    10GB of
                                    <span class="fw-bold">250GB</span>
                                    Free.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End of Main Content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <div class="offcanvas offcanvas-end overflow-hidden" tabindex="-1" id="theme-settings-offcanvas">
            <div class="d-flex justify-content-between text-bg-primary gap-2 p-3"
                style="background-image: url(assets/images/settings-bg.png)">
                <div>
                    <h5 class="mb-1 fw-bold text-white text-uppercase">Admin Customizer</h5>
                    <p class="text-white text-opacity-75 fst-italic fw-medium mb-0">Easily configure layout, styles,
                        and
                        preferences for your admin interface.</p>
                </div>

                <div class="flex-grow-0">
                    <button type="button"
                        class="d-block btn btn-sm bg-white bg-opacity-25 text-white rounded-circle btn-icon"
                        data-bs-dismiss="offcanvas">
                        <i class="ti ti-x fs-lg"></i>
                    </button>
                </div>
            </div>

            <div class="offcanvas-body theme-customizer-bar p-0 h-100" data-simplebar="">
                <div id="skin" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Select Theme</h5>
                    <div class="row g-3">
                        <div class="col-6" id="skin-default">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-default" value="default" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-default">
                                    <img src="{{ asset('assets/images/layouts/skin-default.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Default</h5>
                        </div>

                        <div class="col-6" id="skin-luxe">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-luxe" value="luxe" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-luxe">
                                    <img src="{{ asset('assets/images/layouts/skin-luxe.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Luxe</h5>
                        </div>

                        <div class="col-6" id="skin-neon">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-neon" value="neon" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-neon">
                                    <img src="{{ asset('assets/images/layouts/skin-neon.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Neon</h5>
                        </div>

                        <div class="col-6" id="skin-retro">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-retro" value="retro" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-retro">
                                    <img src="{{ asset('assets/images/layouts/skin-retro.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Retro</h5>
                        </div>

                        <div class="col-6" id="skin-pixel">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-pixel" value="pixel" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-pixel">
                                    <img src="{{ asset('assets/images/layouts/skin-pixel.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Pixel</h5>
                        </div>

                        <div class="col-6" id="skin-galaxy">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-galaxy" value="galaxy" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-galaxy">
                                    <img src="{{ asset('assets/images/layouts/skin-galaxy.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Galaxy</h5>
                        </div>

                        <div class="col-6" id="skin-material">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-material" value="material" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-material">
                                    <img src="{{ asset('assets/images/layouts/skin-material.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Material</h5>
                        </div>

                        <div class="col-6" id="skin-minimal">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-minimal" value="minimal" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-minimal">
                                    <img src="{{ asset('assets/images/layouts/skin-minimal.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Minimal</h5>
                        </div>

                        <div class="col-6" id="skin-modern">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-modern" value="modern" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-modern">
                                    <img src="{{ asset('assets/images/layouts/skin-modern.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Modern</h5>
                        </div>

                        <div class="col-6" id="skin-saas">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-saas" value="saas" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-saas">
                                    <img src="{{ asset('assets/images/layouts/skin-saas.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Saas</h5>
                        </div>

                        <div class="col-6" id="skin-flat">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-skin"
                                    id="demo-skin-flat" value="flat" />
                                <label class="form-check-label p-0 w-100" for="demo-skin-flat">
                                    <img src="{{ asset('assets/images/layouts/skin-flat.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Flat</h5>
                        </div>
                    </div>
                </div>

                <div id="theme" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Color Scheme</h5>
                    <div class="row">
                        <div class="col-4" id="theme-light">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-bs-theme"
                                    id="layout-color-light" value="light" />
                                <label class="form-check-label p-0 w-100" for="layout-color-light">
                                    <img src="{{ asset('assets/images/layouts/theme-light.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Light</h5>
                        </div>

                        <div class="col-4" id="theme-dark">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-bs-theme"
                                    id="layout-color-dark" value="dark" />
                                <label class="form-check-label p-0 w-100" for="layout-color-dark">
                                    <img src="{{ asset('assets/images/layouts/theme-dark.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Dark</h5>
                        </div>

                        <div class="col-4" id="theme-system">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-bs-theme"
                                    id="layout-color-system" value="system" />
                                <label class="form-check-label p-0 w-100" for="layout-color-system">
                                    <img src="{{ asset('assets/images/layouts/theme-system.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">System</h5>
                        </div>
                    </div>
                </div>

                <div id="topbar-color" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Topbar Color</h5>

                    <div class="row g-3">
                        <div class="col-4" id="topbar-color-light">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color"
                                    id="layout-topbar-color-light" value="light" />
                                <label class="form-check-label p-0 w-100" for="layout-topbar-color-light">
                                    <img src="{{ asset('assets/images/layouts/topbar-color-light.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="text-center text-muted mt-2 mb-0">Light</h5>
                        </div>

                        <div class="col-4" id="topbar-color-dark">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color"
                                    id="layout-topbar-color-dark" value="dark" />
                                <label class="form-check-label p-0 w-100" for="layout-topbar-color-dark">
                                    <img src="{{ asset('assets/images/layouts/topbar-color-dark.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Dark</h5>
                        </div>

                        <div class="col-4" id="topbar-color-gray">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color"
                                    id="layout-topbar-color-gray" value="gray" />
                                <label class="form-check-label p-0 w-100" for="layout-topbar-color-gray">
                                    <img src="{{ asset('assets/images/layouts/topbar-color-gray.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Gray</h5>
                        </div>

                        <div class="col-4" id="topbar-color-gradient">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color"
                                    id="layout-topbar-color-gradient" value="gradient" />
                                <label class="form-check-label p-0 w-100" for="layout-topbar-color-gradient">
                                    <img src="{{ asset('assets/images/layouts/topbar-color-gradient.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Gradient</h5>
                        </div>
                    </div>
                </div>

                <div id="sidenav-color" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Sidenav Color</h5>

                    <div class="row g-3">
                        <div class="col-4" id="sidenav-color-light">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color"
                                    id="layout-sidenav-color-light" value="light" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-color-light">
                                    <img src="{{ asset('assets/images/layouts/sidenav-color-light.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Light</h5>
                        </div>

                        <div class="col-4" id="sidenav-color-dark">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color"
                                    id="layout-sidenav-color-dark" value="dark" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-color-dark">
                                    <img src="{{ asset('assets/images/layouts/sidenav-color-dark.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Dark</h5>
                        </div>

                        <div class="col-4" id="sidenav-color-gray">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color"
                                    id="layout-sidenav-color-gray" value="gray" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-color-gray">
                                    <img src="{{ asset('assets/images/layouts/sidenav-color-gray.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Gray</h5>
                        </div>

                        <div class="col-4" id="sidenav-color-gradient">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color"
                                    id="layout-sidenav-color-gradient" value="gradient" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-color-gradient">
                                    <img src="{{ asset('assets/images/layouts/sidenav-color-gradient.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Gradient</h5>
                        </div>
                        <div class="col-4" id="sidenav-color-image">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color"
                                    id="layout-sidenav-color-image" value="image" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-color-image">
                                    <img src="{{ asset('assets/images/layouts/sidenav-color-image.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="fs-sm text-center text-muted mt-2 mb-0">Image</h5>
                        </div>
                    </div>
                </div>

                <div id="sidenav-size" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Sidebar Size</h5>

                    <div class="row g-3">
                        <div class="col-4" id="sidenav-size-default">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-default" value="default" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-size-default">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-default.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Default</h5>
                        </div>

                        <div class="col-4" id="sidenav-size-compact">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-compact" value="compact" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-size-compact">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-compact.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Compact</h5>
                        </div>

                        <div class="col-4" id="sidenav-size-condensed">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-condensed" value="condensed" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-size-condensed">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-condensed.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Condensed</h5>
                        </div>

                        <div class="col-4" id="sidenav-size-on-hover">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-small-hover" value="on-hover" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-size-small-hover">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-on-hover.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">On Hover</h5>
                        </div>

                        <div class="col-4" id="sidenav-size-on-hover-active">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-small-hover-active" value="on-hover-active" />
                                <label class="form-check-label p-0 w-100"
                                    for="layout-sidenav-size-small-hover-active">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-on-hover-active.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 fs-base text-center text-muted mt-2">On Hover - Show</h5>
                        </div>

                        <div class="col-4" id="sidenav-size-offcanvas">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="layout-sidenav-size-offcanvas" value="offcanvas" />
                                <label class="form-check-label p-0 w-100" for="layout-sidenav-size-offcanvas">
                                    <img src="{{ asset('assets/images/layouts/sidenav-size-offcanvas.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Offcanvas</h5>
                        </div>
                    </div>
                </div>

                <div id="width" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Layout Width</h5>

                    <div class="row g-3">
                        <div class="col-4" id="width-fluid">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-layout-width"
                                    id="layout-width-fluid" value="fluid" />
                                <label class="form-check-label p-0 w-100" for="layout-width-fluid">
                                    <img src="{{ asset('assets/images/layouts/width-fluid.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Fluid</h5>
                        </div>

                        <div class="col-4" id="width-boxed">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-layout-width"
                                    id="layout-width-boxed" value="boxed" />
                                <label class="form-check-label p-0 w-100" for="layout-width-boxed">
                                    <img src="{{ asset('assets/images/layouts/width-boxed.png') }}"
                                        alt="layout-img" class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">Boxed</h5>
                        </div>
                    </div>
                </div>

                <div id="dir" class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fw-bold">Layout Direction</h5>

                    <div class="row g-3">
                        <div class="col-4" id="dir-ltr">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="dir"
                                    id="layout-dir-ltr" value="ltr" />
                                <label class="form-check-label p-0 w-100" for="layout-dir-ltr">
                                    <img src="{{ asset('assets/images/layouts/dir-ltr.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">LTR</h5>
                        </div>

                        <div class="col-4" id="dir-rtl">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="dir"
                                    id="layout-dir-rtl" value="rtl" />
                                <label class="form-check-label p-0 w-100" for="layout-dir-rtl">
                                    <img src="{{ asset('assets/images/layouts/dir-rtl.png') }}" alt="layout-img"
                                        class="img-fluid" />
                                </label>
                            </div>
                            <h5 class="mb-0 text-center text-muted mt-2">RTL</h5>
                        </div>
                    </div>
                </div>

                <div id="position" class="p-3 border-bottom border-dashed">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Layout Position</h5>

                        <div class="d-flex gap-1">
                            <div id="position-fixed">
                                <input type="radio" class="btn-check" name="data-layout-position"
                                    id="layout-position-fixed" value="fixed" />
                                <label class="btn btn-sm btn-soft-warning w-sm"
                                    for="layout-position-fixed">Fixed</label>
                            </div>
                            <div id="position-scrollable">
                                <input type="radio" class="btn-check" name="data-layout-position"
                                    id="layout-position-scrollable" value="scrollable" />
                                <label class="btn btn-sm btn-soft-warning w-sm ms-0"
                                    for="layout-position-scrollable">Scrollable</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sidenav-user" class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <label class="fw-bold m-0" for="sidebaruser-check">Sidebar User Info</label>
                        </h5>
                        <div class="form-check form-switch fs-lg">
                            <input type="checkbox" class="form-check-input" name="sidebar-user"
                                id="sidebaruser-check" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer border-top p-3 text-center">
                <div class="row justify-content-end">
                    <div class="col-6">
                        <a href="https://wrapmarket.com/item/inspinia-multipurpose-admin-dashboard-template-WB0R5L90S?via=webapp"
                            class="btn btn-success fw-semibold py-2 w-100" target="_blank"><i
                                class="ti ti-basket me-2 fs-md"></i> Buy Now</a>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-danger fw-semibold py-2 w-100" id="reset-layout"><i
                                class="ti ti-refresh me-2 fs-md"></i> Reset</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end offcanvas-->
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>


        <!-- E Charts js -->
        <script src="{{ asset('assets/plugins/echarts/echarts.min.js') }}"></script>

        <!-- Dashboard js -->
        <script src="{{ asset('assets/js/pages/dashboard-projects.js') }}"></script>
    </body>

</html>
