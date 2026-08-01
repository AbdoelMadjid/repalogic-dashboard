<div id="notification-dropdown-alert" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button"
            data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-bell topbar-link-icon"></i>
            <span class="badge badge-square text-bg-warning topbar-badge">12</span>
        </button>

        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
            <div class="px-3 py-2 border-bottom">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-md fw-semibold" data-lang="topbar-notifications-title">Notifications</h6>
                    </div>
                    <div class="col text-end">
                        <a href="#!" class="badge text-bg-light badge-label py-1" data-lang="topbar-notifications-alerts-badge">12 Alerts</a>
                    </div>
                </div>
            </div>

            <div style="max-height: 300px" data-simplebar="">
                <!-- item 1 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-1">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-danger-subtle text-danger rounded">
                                <i class="ti ti-server-bolt notification-item-icon fill-danger"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Critical alert: Server crash
                                detected</span>
                            <br />
                            <span class="fs-xs">30 minutes ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-1">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 2 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-2">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded">
                                <i class="ti ti-alert-triangle notification-item-icon fill-warning"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">High memory usage on Node
                                A</span>
                            <br />
                            <span class="fs-xs">10 minutes ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-2">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 3 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded">
                                <i class="ti ti-circle-check notification-item-icon fill-success"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Backup completed
                                successfully</span>
                            <br />
                            <span class="fs-xs">1 hour ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-3">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 4 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-4">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded">
                                <i class="ti ti-user-plus notification-item-icon fill-primary"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">New user registration: Sarah
                                Miles</span>
                            <br />
                            <span class="fs-xs">Just now</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-4">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 5 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-5">
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
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-5">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 6 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-6">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded">
                                <i class="ti ti-message-circle notification-item-icon fill-info"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">New comment on Task #142</span>
                            <br />
                            <span class="fs-xs">15 minutes ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-6">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 7 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-7">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle text-warning rounded">
                                <i class="ti ti-battery-charging notification-item-icon fill-warning"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Low battery on Device X</span>
                            <br />
                            <span class="fs-xs">45 minutes ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-7">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 8 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-8">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-success-subtle text-success rounded">
                                <i class="ti ti-cloud-upload notification-item-icon fill-success"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">File upload completed</span>
                            <br />
                            <span class="fs-xs">1 hour ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-8">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 9 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-9">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded">
                                <i class="ti ti-calendar notification-item-icon fill-primary"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Team meeting scheduled at 3
                                PM</span>
                            <br />
                            <span class="fs-xs">2 hours ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-9">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 10 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-10">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-secondary-subtle text-secondary rounded">
                                <i class="ti ti-download notification-item-icon fill-secondary"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Report ready for download</span>
                            <br />
                            <span class="fs-xs">3 hours ago</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-10">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 11 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-11">
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
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-11">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>

                <!-- item 12 -->
                <div class="dropdown-item notification-item py-2 text-wrap" id="notification-12">
                    <span class="d-flex gap-2">
                        <span class="avatar-md flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded">
                                <i class="ti ti-bell-ringing notification-item-icon fill-info"></i>
                            </span>
                        </span>
                        <span class="flex-grow-1 text-muted">
                            <span class="fw-medium text-body">Reminder: Submit your
                                timesheet</span>
                            <br />
                            <span class="fs-xs">Today, 9:00 AM</span>
                        </span>
                        <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0"
                            data-dismissible="#notification-12">
                            <i class="ti ti-square-rounded-x fs-xxl"></i>
                        </button>
                    </span>
                </div>
            </div>
            <!-- end dropdown-->

            <!-- All-->
            <a href="javascript:void(0);"
                class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2" data-lang="topbar-notifications-view-all">View All Alerts</a>
        </div>
    </div>
</div>
