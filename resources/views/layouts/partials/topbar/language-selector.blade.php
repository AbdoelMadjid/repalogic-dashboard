<div id="language-selector" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button" aria-haspopup="false"
            aria-expanded="false">
            <img src="{{ asset('assets/images/flags/us.svg') }}" alt="user-image" class="rounded me-2" height="18"
                id="selected-language-image" />
            <span id="selected-language-code">EN</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="id"
                data-lang-title="lang-indonesia" title="Indonesia">
                <img src="{{ asset('assets/images/flags/id.svg') }}" alt="Indonesia" class="me-1 rounded" height="18"
                    data-translator-image="" />
                <span class="align-middle" data-lang="lang-indonesia">Indonesia</span>
            </a>
            <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en" data-lang-title="lang-english"
                title="English">
                <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English" class="me-1 rounded" height="18"
                    data-translator-image="" />
                <span class="align-middle" data-lang="lang-english">English</span>
            </a>
        </div>
        <!-- end dropdown-menu-->
    </div>
    <!-- end dropdown-->
</div>
