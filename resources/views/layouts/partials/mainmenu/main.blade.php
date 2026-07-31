<li class="side-nav-title mt-2" data-lang="main">Main</li>
<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#dashboards" aria-expanded="false" aria-controls="dashboards" class="side-nav-link">
        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
        <span class="menu-text" data-lang="dashboards">Dashboards</span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="dashboards">
        <ul class="sub-menu">
            <li class="side-nav-item">
                <a href="{{ asset('dashboard-ecommerce.html') }}" class="side-nav-link">
                    <span class="menu-text" data-lang="dashboard-ecommerce">Ecommerce</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ asset('dashboard-analytics.html') }}" class="side-nav-link">
                    <span class="menu-text" data-lang="dashboard-analytics">Analytics</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ asset('index.html') }}" class="side-nav-link">
                    <span class="menu-text" data-lang="dashboard-projects">Projects</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="side-nav-item">
    <a href="{{ asset('landing.html') }}" class="side-nav-link">
        <span class="menu-icon"><i class="ti ti-rocket"></i></span>
        <span class="menu-text" data-lang="landing">Landing</span>
    </a>
</li>
