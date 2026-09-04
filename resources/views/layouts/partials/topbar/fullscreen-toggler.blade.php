@php
    $showFullscreen = empty($appFeatures) || !empty($appFeatures->topbar_fullscreen);
@endphp
<div id="fullscreen-toggler" data-feature="topbar_fullscreen" class="topbar-item d-none d-md-flex" style="{{ $showFullscreen ? '' : 'display: none !important;' }}">
    <button class="topbar-link" type="button" data-toggle="fullscreen">
        <i class="ti ti-maximize topbar-link-icon"></i>
        <i class="ti ti-minimize topbar-link-icon d-none"></i>
    </button>
</div>
