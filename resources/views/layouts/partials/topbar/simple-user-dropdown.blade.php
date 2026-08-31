<div id="simple-user-dropdown" class="topbar-item nav-user">
    @auth
        <div class="dropdown">
            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#!"
                aria-haspopup="false" aria-expanded="false">
                <img src="{{ auth()->user()->avatar_url }}" width="32" height="32" class="rounded-circle me-lg-2 d-flex object-fit-cover {{ session()->has('impersonator_id') ? 'border border-2 border-warning' : '' }}"
                    style="object-fit: cover; object-position: top;"
                    alt="{{ auth()->user()->name }}" />
                <div class="d-lg-flex align-items-center gap-1 d-none">
                    <h5 class="my-0">{{ auth()->user()->name }}</h5>
                    @if (session()->has('impersonator_id'))
                        <span class="badge bg-warning text-dark fs-10 px-1 py-0.5 ms-1" title="Mode Switch Akun Aktif">Switch</span>
                    @endif
                    <i class="ti ti-chevron-down align-middle"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- Header -->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0" data-lang="topbar-user-welcome">Welcome back!</h6>
                </div>

                <!-- My Profile -->
                <a href="{{ route('admin.profil-pengguna.index') }}" class="dropdown-item">
                    <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                    <span class="align-middle" data-lang="topbar-user-profile">Profile</span>
                </a>

                <!-- Notifications -->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="ti ti-bell-ringing me-1 fs-lg align-middle"></i>
                    <span class="align-middle" data-lang="topbar-user-notifications">Notifications</span>
                </a>

                <!-- Wallet -->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="ti ti-credit-card me-1 fs-lg align-middle"></i>
                    <span class="align-middle">
                        <span data-lang="topbar-user-balance">Balance:</span>
                        <span class="fw-semibold">$985.25</span>
                    </span>
                </a>

                <!-- Settings -->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                    <span class="align-middle" data-lang="topbar-user-settings">Account Settings</span>
                </a>

                <!-- Support -->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="ti ti-headset me-1 fs-lg align-middle"></i>
                    <span class="align-middle" data-lang="topbar-user-support">Support Center</span>
                </a>

                <!-- Divider -->
                <div class="dropdown-divider"></div>

                <!-- Lock Screen -->
                <a href="javascript:void(0);" class="dropdown-item" data-action="trigger-lock-screen">
                    <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                    <span class="align-middle" data-lang="topbar-user-lock-screen">Lock Screen</span>
                </a>

                @if (session()->has('impersonator_id'))
                    <!-- Switch Back to Main Account -->
                    <a href="javascript:void(0);" class="dropdown-item bg-warning-subtle text-dark fw-bold"
                        onclick="event.preventDefault(); document.getElementById('switch-back-dropdown-form').submit();">
                        <i class="ti ti-arrow-back-up me-2 fs-17 align-middle text-warning-emphasis"></i>
                        <span class="align-middle">Kembali ke Akun Utama</span>
                    </a>
                    <form id="switch-back-dropdown-form" action="{{ route('admin.switch-back') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif

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
    @endauth
</div>
