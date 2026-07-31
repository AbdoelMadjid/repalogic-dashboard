<div id="simple-user-dropdown" class="topbar-item nav-user">
    <div class="dropdown">
        <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#!"
            aria-haspopup="false" aria-expanded="false">
            <img src="{{ asset('assets/images/users/user-1.jpg') }}" width="32" class="rounded-circle me-lg-2 d-flex"
                alt="user-image" />
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
