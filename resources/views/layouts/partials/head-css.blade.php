<script>
    const html = document.documentElement
    const storageKey = "__THEME_CONFIG__"
    const savedConfig = sessionStorage.getItem(storageKey)

    // Default config
    const defaultConfig = {
        "dir": "ltr",
        "skin": "default",
        "theme": "light",
        "width": "fluid",
        "position": "fixed",
        "orientation": "vertical",
        "sidenav-size": "default",
        "sidenav-user": true,
        "topbar-color": "light",
        "sidenav-color": "dark",
    }

    window.initialDefaultConfig = structuredClone(defaultConfig)
    window.defaultConfig = structuredClone(defaultConfig)

    function getSystemTheme() {
        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"
    }

    // Build config from HTML attributes
    const htmlConfig = {
        dir: html.getAttribute("dir") || defaultConfig["dir"],
        skin: html.getAttribute("data-skin") || defaultConfig["skin"],
        theme: html.getAttribute("data-bs-theme") === "system" ? getSystemTheme() : html.getAttribute(
            "data-bs-theme") || (defaultConfig["theme"] === "system" ? getSystemTheme() : defaultConfig[
            "theme"]),
        width: html.getAttribute("data-layout-width") || defaultConfig["width"],
        position: html.getAttribute("data-layout-position") || defaultConfig["position"],
        "topbar-color": html.getAttribute("data-topbar-color") || defaultConfig["topbar-color"],
        "sidenav-color": html.getAttribute("data-menu-color") || defaultConfig["sidenav-color"],
        "sidenav-size": html.getAttribute("data-sidenav-size") || defaultConfig["sidenav-size"],
        "sidenav-user": html.hasAttribute("data-sidenav-user") ? (html.getAttribute("data-sidenav-user") !== "false") : defaultConfig["sidenav-user"],
    }

    // Load from session if exists
    let config = savedConfig ? JSON.parse(savedConfig) : htmlConfig
    window.config = config

    // Apply layout attributes immediately
    html.setAttribute("dir", config["dir"] || defaultConfig["dir"])
    html.setAttribute("data-skin", config["skin"] || defaultConfig["skin"])
    html.setAttribute("data-bs-theme", (config["theme"] === "system" ? getSystemTheme() : config["theme"]) || defaultConfig["theme"])
    html.setAttribute("data-menu-color", config["sidenav-color"] || defaultConfig["sidenav-color"])
    html.setAttribute("data-topbar-color", config["topbar-color"] || defaultConfig["topbar-color"])
    html.setAttribute("data-layout-width", config["width"] || defaultConfig["width"])
    html.setAttribute("data-layout-position", config["position"] || defaultConfig["position"])

    if (config["sidenav-size"]) {
        let size = config["sidenav-size"]

        if (window.innerWidth <= 767) {
            size = "offcanvas"
        } else if (window.innerWidth <= 1140 && !["offcanvas"].includes(size)) {
            size = "condensed"
        }

        html.setAttribute("data-sidenav-size", size)

        if (config["sidenav-user"] === true || config["sidenav-user"] === "true") {
            html.setAttribute("data-sidenav-user", "true")
        } else {
            html.removeAttribute("data-sidenav-user")
        }
    }

    // Sync language preference cookie immediately
    try {
        const savedLang = sessionStorage.getItem("__THEME_LANG__")
        if (savedLang) {
            document.cookie = `__THEME_LANG__=${savedLang};path=/;max-age=31536000;SameSite=Lax`
        }
    } catch (e) {}
</script>
<!-- Theme Config Js -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Vendor css -->
<link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link id="app-style" href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Global Custom DataTables & Switch Table CSS -->
<link href="{{ asset('assets/css/custom-datatables.css') }}" rel="stylesheet" type="text/css" />

<!-- Global Custom Auth & Form Input Styling -->
<link href="{{ asset('assets/css/custom-auth.css') }}" rel="stylesheet" type="text/css" />
