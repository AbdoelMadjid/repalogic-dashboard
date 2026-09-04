@php
    $showThemeToggler = empty($appFeatures) || !empty($appFeatures->topbar_theme_toggler);
@endphp
<div id="theme-toggler" data-feature="topbar_theme_toggler" class="topbar-item d-none d-sm-flex" style="{{ $showThemeToggler ? '' : 'display: none !important;' }}">
    <button class="topbar-link" id="light-dark-mode" type="button">
        <i class="ti ti-moon topbar-link-icon mode-light-moon"></i>
        <i class="ti ti-sun topbar-link-icon mode-light-sun"></i>
    </button>
</div>
