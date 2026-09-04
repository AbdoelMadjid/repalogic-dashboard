@php
    $currentLang = request()->cookie('__THEME_LANG__', 'id');
    $isEn = $currentLang === 'en';
    $currentFlag = $isEn ? asset('assets/images/flags/us.svg') : asset('assets/images/flags/id.svg');
    $currentCode = $isEn ? 'EN' : 'ID';
@endphp
<div id="language-selector" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button" aria-haspopup="false"
            aria-expanded="false">
            <img src="{{ $currentFlag }}" alt="user-image" class="rounded me-2" height="18"
                id="selected-language-image" />
            <span id="selected-language-code">{{ $currentCode }}</span>
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
<script>
    (function() {
        try {
            var lang = sessionStorage.getItem('__THEME_LANG__') || '{{ $currentLang }}';
            var isEn = lang === 'en';
            var img = document.getElementById('selected-language-image');
            var code = document.getElementById('selected-language-code');
            if (img) img.src = isEn ? '{{ asset('assets/images/flags/us.svg') }}' : '{{ asset('assets/images/flags/id.svg') }}';
            if (code) code.textContent = isEn ? 'EN' : 'ID';
        } catch(e) {}
    })();
</script>
