@php
    $showCustomizer = empty($appFeatures) || !empty($appFeatures->topbar_customizer);
@endphp
<div id="theme-settings-toggler" data-feature="topbar_customizer" class="topbar-item d-none d-sm-flex" style="{{ $showCustomizer ? '' : 'display: none !important;' }}">
    <button class="topbar-link btn-theme-setting" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas"
        type="button">
        <i class="ti ti-settings topbar-link-icon"></i>
    </button>
</div>
