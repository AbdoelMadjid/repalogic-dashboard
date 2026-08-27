<!-- Theme Config Js -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Vendor css -->
<link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Sticky Navbar Scroll Offset & Section Dynamic Background Styling -->
<style>
    html {
        scroll-behavior: smooth;
        scroll-padding-top: 85px;
    }
    section[id], [id] {
        scroll-margin-top: 85px;
    }
    .website-section-bg-image {
        position: relative !important;
        background-size: cover !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
        overflow: hidden !important;
    }
    .website-section-bg-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.72) 0%, rgba(15, 23, 42, 0.62) 100%);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 1;
    }
    .website-section-bg-image > * {
        position: relative;
        z-index: 2;
    }
    /* Auto text contrast on dark, primary & image backgrounds for direct section titles */
    .bg-dark, .bg-primary, .website-section-bg-image {
        color: #ffffff;
    }

    .bg-dark > section h1, .bg-dark > section h2, .bg-dark > section h3, .bg-dark > section h4, .bg-dark > section h5, .bg-dark > section h6,
    .bg-primary > section h1, .bg-primary > section h2, .bg-primary > section h3, .bg-primary > section h4, .bg-primary > section h5, .bg-primary > section h6,
    .website-section-bg-image > section h1, .website-section-bg-image > section h2, .website-section-bg-image > section h3, .website-section-bg-image > section h4, .website-section-bg-image > section h5, .website-section-bg-image > section h6,
    .bg-dark > section > .container > .row > div > h1, .bg-dark > section > .container > .row > div > h2, .bg-dark > section > .container > .row > div > h3,
    .bg-primary > section > .container > .row > div > h1, .bg-primary > section > .container > .row > div > h2, .bg-primary > section > .container > .row > div > h3,
    .website-section-bg-image > section > .container > .row > div > h1, .website-section-bg-image > section > .container > .row > div > h2, .website-section-bg-image > section > .container > .row > div > h3 {
        color: #ffffff !important;
    }

    .bg-dark > section .text-muted, .bg-primary > section .text-muted, .website-section-bg-image > section .text-muted {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    /* Preserve card white background & dark readable text inside cards */
    .bg-dark .card, .bg-primary .card, .website-section-bg-image .card,
    .bg-dark .bg-white, .bg-primary .bg-white, .website-section-bg-image .bg-white {
        color: #334155 !important;
    }

    .bg-dark .card h1, .bg-dark .card h2, .bg-dark .card h3, .bg-dark .card h4, .bg-dark .card h5, .bg-dark .card h6,
    .bg-primary .card h1, .bg-primary .card h2, .bg-primary .card h3, .bg-primary .card h4, .bg-primary .card h5, .bg-primary .card h6,
    .website-section-bg-image .card h1, .website-section-bg-image .card h2, .website-section-bg-image .card h3, .website-section-bg-image .card h4, .website-section-bg-image .card h5, .website-section-bg-image .card h6 {
        color: #0f172a !important;
    }

    .bg-dark .card p, .bg-dark .card .text-muted,
    .bg-primary .card p, .bg-primary .card .text-muted,
    .website-section-bg-image .card p, .website-section-bg-image .card .text-muted {
        color: #64748b !important;
    }

    .bg-dark mark, .bg-primary mark, .website-section-bg-image mark {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.25) !important;
        padding: 0.1em 0.35em !important;
        border-radius: 0.25rem !important;
    }
</style>
