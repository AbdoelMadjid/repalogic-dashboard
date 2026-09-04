@php
    $showMonochrome = empty($appFeatures) || !empty($appFeatures->topbar_monochrome);
@endphp
<div id="monochrome-toggler" data-feature="topbar_monochrome" class="topbar-item d-none d-xl-flex" style="{{ $showMonochrome ? '' : 'display: none !important;' }}">
    <button id="monochrome-mode" class="topbar-link" type="button" data-toggle="monochrome">
        <i class="ti ti-palette topbar-link-icon"></i>
    </button>
</div>
