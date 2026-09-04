(()=>{
    var e = document.documentElement,
        i = sessionStorage.getItem("__THEME_CONFIG__");
    const t = "ltr", a = "default", d = "light", r = "fluid", s = "fixed", o = "default", n = !0, u = "light", b = "dark";
    
    function l() {
        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }

    const baseDefault = {
        "dir": t,
        "skin": a,
        "theme": d,
        "width": r,
        "position": s,
        "orientation": "vertical",
        "sidenav-size": o,
        "sidenav-user": n,
        "topbar-color": u,
        "sidenav-color": b
    };

    window.initialDefaultConfig = structuredClone(baseDefault);
    window.defaultConfig = structuredClone(baseDefault);

    var c = {
        skin: e.getAttribute("data-skin") || a,
        theme: "system" === e.getAttribute("data-bs-theme") ? l() : e.getAttribute("data-bs-theme") || ("system" === d ? l() : d),
        "topbar-color": e.getAttribute("data-topbar-color") || u,
        "sidenav-color": e.getAttribute("data-menu-color") || b,
        "sidenav-size": e.getAttribute("data-sidenav-size") || o,
        "sidenav-user": e.hasAttribute("data-sidenav-user") ? e.getAttribute("data-sidenav-user") !== "false" : n,
        position: e.getAttribute("data-layout-position") || s,
        width: e.getAttribute("data-layout-width") || r,
        dir: e.getAttribute("dir") || t
    };

    i = i ? JSON.parse(i) : c;
    window.config = i;

    e.setAttribute("data-skin", i.skin || a);
    e.setAttribute("data-bs-theme", "system" === i.theme ? l() : (i.theme || d));
    e.setAttribute("data-menu-color", i["sidenav-color"] || b);
    e.setAttribute("data-topbar-color", i["topbar-color"] || u);
    e.setAttribute("data-layout-width", i.width || r);
    e.setAttribute("data-layout-position", i.position || s);
    e.setAttribute("dir", i.dir || t);

    if (i["sidenav-size"]) {
        let size = i["sidenav-size"];
        window.innerWidth <= 767 ? size = "offcanvas" : window.innerWidth <= 1140 && !["offcanvas"].includes(size) && (size = "condensed");
        e.setAttribute("data-sidenav-size", size);
    }
    
    if (!0 === i["sidenav-user"] || "true" === i["sidenav-user"]) {
        e.setAttribute("data-sidenav-user", "true");
    } else {
        e.removeAttribute("data-sidenav-user");
    }
})();