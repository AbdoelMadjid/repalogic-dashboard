class App{init(){try{this.initComponents(),this.initPreloader(),this.initPortletCard(),this.initMultiDropdown(),this.initFormValidation(),this.initCounter(),this.initCodePreview(),this.initToggle(),this.initDismissible(),this.initSidenavMenu(),this.initHorizontalMenu(),this.initTopbar(),this.initFullScreenListener()}catch(e){console.warn("Error initializing app:",e)}}initComponents(){try{"undefined"!=typeof lucide&&"function"==typeof lucide.createIcons&&lucide.createIcons(),document.querySelectorAll('[data-bs-toggle="popover"]').forEach(e=>{new bootstrap.Popover(e)}),document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(e=>{new bootstrap.Tooltip(e)}),document.querySelectorAll(".offcanvas").forEach(e=>{new bootstrap.Offcanvas(e)}),document.querySelectorAll(".toast").forEach(e=>{new bootstrap.Toast(e)})}catch(e){console.warn("Error initializing bootstrap components:",e)}}initPreloader(){window.addEventListener("load",()=>{var e=document.getElementById("status");let t=document.getElementById("preloader");e&&(e.style.display="none"),t&&setTimeout(()=>t.style.display="none",350)})}initPortletCard(){document.querySelectorAll('[data-action="card-close"]').forEach(i=>{i.addEventListener("click",e=>{e.preventDefault();let t=i.closest(".card");t&&(t.style.transition="opacity 0.3s ease",t.style.opacity="0",setTimeout(()=>t.remove(),300))})}),document.querySelectorAll('[data-action="card-toggle"]').forEach(i=>{i.addEventListener("click",e=>{e.preventDefault();e=i.closest(".card");let t=e?e.querySelector(".card-body"):null;e&&t&&(t.style.transition="height 0.35s ease-in-out, margin 0.35s ease-in-out",e.classList.contains("card-collapsed")?(e.classList.remove("card-collapsed"),t.style.height=t.scrollHeight+"px",t.style.overflow="hidden",t.addEventListener("transitionend",()=>{t.style.height="auto",t.style.overflow="visible"},{once:!0})):(t.style.height=t.scrollHeight+"px",t.style.overflow="hidden",t.offsetHeight,t.style.height="0",e.classList.add("card-collapsed")))})}),document.querySelectorAll('[data-action="card-refresh"]').forEach(e=>{e.addEventListener("click",t=>{t.preventDefault();var i,t=e.closest(".card");if(t){let e=t.querySelector(".card-overlay");e||((e=document.createElement("div")).className="card-overlay",(i=document.createElement("div")).className="spinner-border text-primary",e.appendChild(i),t.appendChild(e)),e.style.display="flex",setTimeout(()=>{e.style.display="none"},1500)}})}),document.querySelectorAll('[data-action="code-collapse"]').forEach(i=>{i.addEventListener("click",e=>{e.preventDefault();var e=i.closest(".card");let t=e?e.querySelector(".code-body"):null;e&&t&&(t.style.transition="height 0.35s ease-in-out","none"===window.getComputedStyle(t).display?(t.style.display="block",t.style.height="0",t.style.overflow="hidden",e=t.scrollHeight,t.offsetHeight,t.style.height=e+"px",t.addEventListener("transitionend",()=>{t.style.height="auto",t.style.overflow="visible"},{once:!0})):(t.style.height=t.scrollHeight+"px",t.style.overflow="hidden",t.offsetHeight,t.style.height="0",t.addEventListener("transitionend",()=>{t.style.display="none",t.style.height=null},{once:!0})))})})}initMultiDropdown(){document.querySelectorAll(".dropdown-menu a.dropdown-toggle").forEach(i=>{i.addEventListener("click",function(e){e.preventDefault(),e.stopPropagation();e=i.closest(".dropdown-menu");let t=i.nextElementSibling;e&&(e.querySelectorAll(".dropdown-menu").forEach(e=>{e!==t&&e.classList.remove("show")}),e.querySelectorAll("a.dropdown-toggle").forEach(e=>{e!==i&&e.classList.remove("show")}))})})}initFormValidation(){document.querySelectorAll(".needs-validation").forEach(t=>{t.addEventListener("submit",e=>{t.checkValidity()||(e.preventDefault(),e.stopPropagation()),t.classList.add("was-validated")},!1)})}initCounter(){var e=document.querySelectorAll("[data-target]");let t=new IntersectionObserver((e,r)=>{e.forEach(s=>{if(s.isIntersecting){let o=s.target;s=o.getAttribute("data-target");if(s){let e=s.replace(/,/g,""),t=(e=parseFloat(e),0),i,a=(i=Number.isInteger(e)?Math.floor(e/25):e/25,()=>{t<e?((t+=i)>e&&(t=e),o.innerText=n(t),requestAnimationFrame(a)):o.innerText=n(e)});function n(e){return e%1==0?e.toLocaleString():e.toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2})}a(),r.unobserve(o)}}})},{threshold:1});e.forEach(e=>t.observe(e))}initCodePreview(){"undefined"!=typeof Prism&&Prism.plugins&&Prism.plugins.NormalizeWhitespace&&Prism.plugins.NormalizeWhitespace.setDefaults({"remove-trailing":!0,"remove-indent":!0,"left-trim":!0,"right-trim":!0,"tabs-to-spaces":4,"spaces-to-tabs":4})}initToggle(){document.querySelectorAll("[data-toggler]").forEach(e=>{let t=e.querySelector("[data-toggler-on]"),i=e.querySelector("[data-toggler-off]"),a="on"===e.getAttribute("data-toggler"),o=()=>{a?(t?.classList.remove("d-none"),i?.classList.add("d-none")):(t?.classList.add("d-none"),i?.classList.remove("d-none"))};t?.addEventListener("click",()=>{a=!1,o()}),i?.addEventListener("click",()=>{a=!0,o()}),o()})}initDismissible(){document.querySelectorAll("[data-dismissible]").forEach(t=>{t.addEventListener("click",()=>{var e=t.getAttribute("data-dismissible"),e=document.querySelector(e);e&&e.remove()})})}initSidenavMenu(){let s=document.querySelector(".side-nav");if(s){s.querySelectorAll("li [data-bs-toggle='collapse']").forEach(e=>{e.addEventListener("click",e=>e.preventDefault())});let o=s.querySelectorAll("li .collapse"),e=(o.forEach(e=>{e.addEventListener("show.bs.collapse",e=>{let t=e.target,i=[],a=t.parentElement;for(;a&&a!==s;)a.classList.contains("collapse")&&i.push(a),a=a.parentElement;o.forEach(e=>{e===t||i.includes(e)||new bootstrap.Collapse(e,{toggle:!1}).hide()})})}),window.location.href.split(/[?#]/)[0]);s.querySelectorAll("a").forEach(t=>{if(t.href===e){s.querySelectorAll("a.active, li.active, .collapse.show").forEach(e=>{e.classList.remove("active"),e.classList.remove("show")}),t.classList.add("active");let e=t.closest("li");for(;e&&e!==s;){e.classList.add("active");var i=e.closest(".collapse");e=i?(new bootstrap.Collapse(i,{toggle:!1}).show(),(i=i.closest("li"))&&i.classList.add("active"),i):e.parentElement}}}),setTimeout(()=>{let e=s.querySelector("li.active"),t=document.querySelector(".sidenav-menu .simplebar-content-wrapper")||document.querySelector(".sidenav-menu");if(e&&t){let r=e,i=e;for(;i&&i!==s;){if(i.parentElement&&i.parentElement.classList.contains("side-nav")){r=i;break}i=i.parentElement?i.parentElement.closest("li"):null}let a=t.getBoundingClientRect(),o=(r||e).getBoundingClientRect();let l=a.top+a.height/2;if(o.top>l){let e=o.top-a.top+t.scrollTop-120;0<e&&t.scrollTo({top:e,behavior:"smooth"})}}},300)}}initHorizontalMenu(){var a=document.querySelector(".navbar-nav");if(a){let t=window.location.href.split(/[?#]/)[0];a.querySelectorAll("li a").forEach(e=>{if(e.href===t){e.classList.add("active");let t=e.parentElement;for(let e=0;e<6&&t&&t!==document.body;e++)"LI"!==t.tagName&&!t.classList.contains("dropdown")||t.classList.add("active"),t=t.parentElement}});let e=document.querySelector(".navbar-toggle"),i=document.getElementById("navigation");e&&i&&e.addEventListener("click",()=>{e.classList.toggle("open"),"block"===i.style.display?i.style.display="none":i.style.display="block"})}}initTopbar(){let e=document.querySelector(".app-topbar");e&&window.addEventListener("scroll",()=>{50<window.scrollY?e.classList.add("topbar-active"):e.classList.remove("topbar-active")})}initFullScreenListener(){var e=document.querySelector('[data-toggle="fullscreen"]');e&&e.addEventListener("click",function(e){e.preventDefault(),document.body.classList.toggle("fullscreen-enable"),document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullscreen?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)})}}class LayoutCustomizer {
    constructor() {
        this.html = document.documentElement;
        this.config = {};
    }

    init() {
        this.initConfig();
        this.monochromeMode();
        this.initSwitchListener();
        this.initWindowSize();
        this._adjustLayout();
        this.setSwitchFromConfig();
        this.activeThemeDropdownItem();
        this.openCustomizer();
    }

    isFirstVisit() {
        return !localStorage.getItem('__user_has_visited__') && (localStorage.setItem('__user_has_visited__', 'true'), true);
    }

    openCustomizer() {}

    initConfig() {
        const baseDefault = window.initialDefaultConfig || window.defaultConfig || {
            'dir': 'ltr',
            'skin': 'default',
            'theme': 'light',
            'width': 'fluid',
            'position': 'fixed',
            'orientation': 'vertical',
            'sidenav-size': 'default',
            'sidenav-user': true,
            'topbar-color': 'light',
            'sidenav-color': 'dark'
        };
        this.defaultConfig = JSON.parse(JSON.stringify(baseDefault));
        this.config = JSON.parse(JSON.stringify(window.config || baseDefault));
        this.setSwitchFromConfig();
    }

    monochromeMode() {
        const e = document.getElementById('monochrome-mode');
        if (e) {
            e.addEventListener('click', () => {
                this.config.monochrome = !this.config.monochrome;
                if (this.config.monochrome) {
                    this.html.classList.add('monochrome');
                } else {
                    this.html.classList.remove('monochrome');
                }
                this.setSwitchFromConfig();
            });
        }
    }

    changeSkin(e) {
        if (!e) return;
        this.config.skin = e;
        this.html.setAttribute('data-skin', e);
        this.setSwitchFromConfig();
    }

    changeMenuColor(e) {
        if (!e) return;
        this.config['sidenav-color'] = e;
        this.html.setAttribute('data-menu-color', e);
        this.setSwitchFromConfig();
    }

    changeSidenavSize(e, t = true) {
        if (!e) return;
        this.html.setAttribute('data-sidenav-size', e);
        if (t) {
            this.config['sidenav-size'] = e;
            this.setSwitchFromConfig();
        }
    }

    changeLayoutPosition(e) {
        if (!e) return;
        this.config.position = e;
        this.html.setAttribute('data-layout-position', e);
        this.setSwitchFromConfig();
    }

    changeTheme(e) {
        if (!e) return;
        this.config.theme = e;
        this.html.setAttribute('data-bs-theme', 'system' === e ? this.getSystemTheme() : e);
        this.setSwitchFromConfig();
        this.activeThemeDropdownItem();
    }

    changeTopbarColor(e) {
        if (!e) return;
        this.config['topbar-color'] = e;
        this.html.setAttribute('data-topbar-color', e);
        this.setSwitchFromConfig();
    }

    changeLayoutWidth(e) {
        if (!e) return;
        this.config.width = e;
        this.html.setAttribute('data-layout-width', e);
        this.setSwitchFromConfig();
    }

    changeLayoutDirection(e) {
        if (!e) return;
        this.config.dir = e;
        this.html.setAttribute('dir', e);
        this.setSwitchFromConfig();
    }

    changeSidebarUser(e) {
        this.config['sidenav-user'] = Boolean(e);
        if (this.config['sidenav-user']) {
            this.html.setAttribute('data-sidenav-user', 'true');
        } else {
            this.html.removeAttribute('data-sidenav-user');
        }
        this.setSwitchFromConfig();
    }

    resetTheme() {
        const defaults = window.initialDefaultConfig || {
            'dir': 'ltr',
            'skin': 'default',
            'theme': 'light',
            'width': 'fluid',
            'position': 'fixed',
            'orientation': 'vertical',
            'sidenav-size': 'default',
            'sidenav-user': true,
            'topbar-color': 'light',
            'sidenav-color': 'dark'
        };

        try {
            sessionStorage.removeItem('__THEME_CONFIG__');
            sessionStorage.setItem('__THEME_CONFIG__', JSON.stringify(defaults));
        } catch (err) {}

        this.config = JSON.parse(JSON.stringify(defaults));
        this.config.monochrome = false;
        this.html.classList.remove('monochrome');

        this.changeSkin(this.config.skin);
        this.changeMenuColor(this.config['sidenav-color']);
        this.changeSidenavSize(this.config['sidenav-size']);
        this.changeTheme(this.config.theme);
        this.changeLayoutPosition(this.config.position);
        this.changeTopbarColor(this.config['topbar-color']);
        this.changeLayoutWidth(this.config.width);
        this.changeLayoutDirection(this.config.dir);
        this.changeSidebarUser(this.config['sidenav-user']);
        this._adjustLayout();
        this.setSwitchFromConfig();
        this.activeThemeDropdownItem();
    }

    getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    setSwitchFromConfig() {
        const e = this.config;
        try {
            sessionStorage.setItem('__THEME_CONFIG__', JSON.stringify(e));
        } catch (err) {}

        const customizer = document.getElementById('theme-settings-offcanvas');
        if (customizer) {
            customizer.querySelectorAll('input[type="radio"]').forEach(inp => inp.checked = false);
            const userCheck = customizer.querySelector('input[name="sidebar-user"]');
            if (userCheck) {
                userCheck.checked = Boolean(e['sidenav-user']);
            }
        } else {
            const userCheck = document.querySelector('input[name="sidebar-user"]');
            if (userCheck) {
                userCheck.checked = Boolean(e['sidenav-user']);
            }
        }

        [
            ['data-skin', e.skin],
            ['data-bs-theme', e.theme],
            ['data-menu-color', e['sidenav-color']],
            ['data-sidenav-size', e['sidenav-size']],
            ['data-topbar-color', e['topbar-color']],
            ['data-layout-position', e.position],
            ['data-layout-width', e.width],
            ['dir', e.dir]
        ].forEach(([attr, val]) => {
            if (val !== undefined && val !== null) {
                const radio = document.querySelector('input[name="' + attr + '"][value="' + val + '"]');
                if (radio) radio.checked = true;
            }
        });
    }

    initSwitchListener() {
        const bindChange = (selector, callback) => {
            document.querySelectorAll(selector).forEach(el => {
                el.addEventListener('change', () => callback(el));
            });
        };

        bindChange('input[name="data-skin"]', el => this.changeSkin(el.value));
        bindChange('input[name="data-bs-theme"]', el => this.changeTheme(el.value));
        bindChange('input[name="data-menu-color"]', el => this.changeMenuColor(el.value));
        bindChange('input[name="data-sidenav-size"]', el => this.changeSidenavSize(el.value));
        bindChange('input[name="data-topbar-color"]', el => this.changeTopbarColor(el.value));
        bindChange('input[name="data-layout-position"]', el => this.changeLayoutPosition(el.value));
        bindChange('input[name="data-layout-width"]', el => this.changeLayoutWidth(el.value));
        bindChange('input[name="dir"]', el => this.changeLayoutDirection(el.value));
        bindChange('input[name="sidebar-user"]', el => this.changeSidebarUser(el.checked));

        const lightDarkModeBtn = document.getElementById('light-dark-mode');
        if (lightDarkModeBtn) {
            lightDarkModeBtn.addEventListener('click', () => {
                const newTheme = this.config.theme === 'light' ? 'dark' : 'light';
                this.changeTheme(newTheme);
            });
        }

        // Global Event Delegation for Reset Button
        document.addEventListener('click', (e) => {
            const resetBtn = e.target.closest('#reset-layout');
            if (resetBtn) {
                e.preventDefault();
                this.resetTheme();
            }
        });

        // Global Event Delegation for Optimize Clear Button
        document.addEventListener('click', (e) => {
            const optBtn = e.target.closest('#btn-optimize-clear');
            if (optBtn) {
                e.preventDefault();
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                const executeClear = () => {
                    const originalHtml = optBtn.innerHTML;
                    optBtn.disabled = true;
                    optBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Memproses...';

                    fetch('/admin/optimize-clear', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        optBtn.disabled = false;
                        optBtn.innerHTML = originalHtml;
                        if (data.success) {
                            if (window.showSuccess) {
                                window.showSuccess(data.message, { reload: true, timer: 2000 });
                            } else {
                                alert(data.message);
                                window.location.reload();
                            }
                        } else {
                            if (window.showError) {
                                window.showError(data.message || 'Gagal membersihkan cache.');
                            } else {
                                alert(data.message);
                            }
                        }
                    })
                    .catch(err => {
                        optBtn.disabled = false;
                        optBtn.innerHTML = originalHtml;
                        if (window.showError) {
                            window.showError('Terjadi kesalahan jaringan: ' + err.message);
                        } else {
                            alert('Terjadi kesalahan: ' + err.message);
                        }
                    });
                };

                if (window.showConfirm) {
                    window.showConfirm({
                        title: 'Jalankan Optimize Clear?',
                        text: 'Perintah "php artisan optimize:clear" akan membersihkan seluruh cache (config, view, route, events, compiled). Lanjutkan?',
                        isDanger: false,
                        onConfirm: executeClear
                    });
                } else {
                    executeClear();
                }
            }
        });

        const sidenavToggleBtn = document.querySelector('.sidenav-toggle-button');
        if (sidenavToggleBtn) {
            sidenavToggleBtn.addEventListener('click', () => this._toggleSidebar());
        }

        const closeOffcanvasBtn = document.querySelector('.button-close-offcanvas');
        if (closeOffcanvasBtn) {
            closeOffcanvasBtn.addEventListener('click', () => {
                this.html.classList.remove('sidebar-enable');
                this.hideBackdrop();
            });
        }

        document.querySelectorAll('.button-on-hover').forEach(el => {
            el.addEventListener('click', () => {
                const size = this.html.getAttribute('data-sidenav-size');
                this.changeSidenavSize('on-hover-active' === size ? 'on-hover' : 'on-hover-active', true);
            });
        });
    }

    _toggleSidebar() {
        const size = this.html.getAttribute('data-sidenav-size');
        const configSize = this.config['sidenav-size'];
        if ('offcanvas' === size) {
            this.showBackdrop();
        } else if ('compact' === configSize) {
            this.changeSidenavSize('condensed' === size ? 'compact' : 'condensed', false);
        } else {
            this.changeSidenavSize('condensed' === size ? 'default' : 'condensed', true);
        }
        this.html.classList.toggle('sidebar-enable');
    }

    showBackdrop() {
        const backdrop = document.createElement('div');
        backdrop.id = 'custom-backdrop';
        backdrop.className = 'offcanvas-backdrop fade show';
        document.body.appendChild(backdrop);
        document.body.style.overflow = 'hidden';
        if (window.innerWidth > 767) {
            document.body.style.paddingRight = '15px';
        }
        backdrop.addEventListener('click', () => {
            this.html.classList.remove('sidebar-enable');
            this.hideBackdrop();
        });
    }

    hideBackdrop() {
        const backdrop = document.getElementById('custom-backdrop');
        if (backdrop) {
            document.body.removeChild(backdrop);
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
    }

    _adjustLayout() {
        const width = window.innerWidth;
        const size = this.config['sidenav-size'];
        if (width <= 767.98) {
            this.changeSidenavSize('offcanvas', false);
        } else if (width <= 1140 && !['offcanvas'].includes(size)) {
            this.changeSidenavSize('condensed', false);
        } else {
            this.changeSidenavSize(size);
        }
    }

    initWindowSize() {
        window.addEventListener('resize', () => this._adjustLayout());
    }

    activeThemeDropdownItem() {
        const items = document.querySelectorAll('.dropdown-item [name="data-bs-theme"]');
        const currentTheme = this.config.theme;
        if (items && items.length > 0) {
            items.forEach(el => {
                const isActive = el.value === currentTheme;
                if (el.parentElement) {
                    el.parentElement.classList.toggle('active', isActive);
                }
                if (isActive) {
                    const iconLight = document.getElementById('theme-icon-light');
                    const iconDark = document.getElementById('theme-icon-dark');
                    const iconSystem = document.getElementById('theme-icon-system');
                    if (iconLight) iconLight.classList.toggle('d-none', currentTheme !== 'light');
                    if (iconDark) iconDark.classList.toggle('d-none', currentTheme !== 'dark');
                    if (iconSystem) iconSystem.classList.toggle('d-none', currentTheme !== 'system');
                }
            });
        }
    }
}
class Plugins{init(){this.initFlatPicker(),this.initTouchSpin()}initFlatPicker(){document.querySelectorAll("[data-provider]").forEach(e=>{var t=e.getAttribute("data-provider"),i=e.attributes,a={disableMobile:!0,defaultDate:new Date};"flatpickr"===t?(i["data-date-format"]&&(a.dateFormat=i["data-date-format"].value),i["data-enable-time"]&&(a.enableTime=!0,a.dateFormat+=" H:i"),i["data-altFormat"]&&(a.altInput=!0,a.altFormat=i["data-altFormat"].value),i["data-minDate"]&&(a.minDate=i["data-minDate"].value),i["data-maxDate"]&&(a.maxDate=i["data-maxDate"].value),i["data-default-date"]&&(a.defaultDate=i["data-default-date"].value),i["data-multiple-date"]&&(a.mode="multiple"),i["data-range-date"]&&(a.mode="range"),i["data-inline-date"]&&(a.inline=!0,a.defaultDate=i["data-default-date"].value),i["data-disable-date"]&&(a.disable=i["data-disable-date"].value.split(",")),i["data-week-number"]&&(a.weekNumbers=!0),flatpickr(e,a)):"timepickr"===t&&(a={enableTime:!0,noCalendar:!0,dateFormat:"H:i",defaultDate:new Date},i["data-time-hrs"]&&(a.time_24hr=!0),i["data-min-time"]&&(a.minTime=i["data-min-time"].value),i["data-max-time"]&&(a.maxTime=i["data-max-time"].value),i["data-default-time"]&&(a.defaultDate=i["data-default-time"].value),i["data-time-inline"]&&(a.inline=!0,a.defaultDate=i["data-time-inline"].value),flatpickr(e,a))})}initTouchSpin(){document.querySelectorAll("[data-touchspin]").forEach(e=>{var n=e.querySelector("[data-minus]"),r=e.querySelector("[data-plus]");let l=e.querySelector("input");if(l){let t=Number(l.min),i=Number(l.max??0),a=Number.isFinite(t),o=Number.isFinite(i),s=()=>Number.parseInt(l.value)||0;l.hasAttribute("readonly")||(n&&n.addEventListener("click",()=>{var e=s()-1;(!a||e>=t)&&(l.value=e.toString())}),r&&r.addEventListener("click",()=>{var e=s()+1;(!o||e<=i)&&(l.value=e.toString())}))}})}}class I18nManager{constructor({defaultLang:e="id",langPath:t="/assets/data/translations/",langImageSelector:i="#selected-language-image",langCodeSelector:a="#selected-language-code",translationKeySelector:o="[data-lang]",translationKeyAttribute:s="data-lang",languageSelector:n="[data-translator-lang]"}={}){this.selectedLanguage=sessionStorage.getItem("__THEME_LANG__")||e,this.langPath=t,this.langImageSelector=i,this.langCodeSelector=a,this.translationKeySelector=o,this.translationKeyAttribute=s,this.languageSelector=n,this.selectedLanguageImage=document.querySelector(this.langImageSelector),this.selectedLanguageCode=document.querySelector(this.langCodeSelector),this.languageButtons=document.querySelectorAll(this.languageSelector),this.updateSelectedImage(),this.updateSelectedCode()}async init(e){this.updateSelectedImage(),this.updateSelectedCode();try{document.cookie="__THEME_LANG__="+this.selectedLanguage+";path=/;max-age=31536000;SameSite=Lax"}catch(t){}"ar"===this.selectedLanguage&&e.changeLayoutDirection("rtl"),await this.applyTranslations(),this.updateSelectedImage(),this.updateSelectedCode(),this.bindLanguageSwitchers(e)}async loadTranslations(forceRefresh=!1){try{const cacheKey=`__TRANS_CACHE_${this.selectedLanguage}__`;if(!forceRefresh){const cached=sessionStorage.getItem(cacheKey);if(cached){try{const parsed=JSON.parse(cached);if(parsed&&Object.keys(parsed).length>0)return parsed}catch(e){}}}let p=this.langPath.startsWith("/")||this.langPath.startsWith("http")?this.langPath:"/"+this.langPath;if(!p.endsWith("/"))p+="/";const m=["sidebar_template","sidebar_menu","topbar","auth","customizer","frontpage"];const r=await Promise.allSettled(m.map(k=>fetch(`${p}${this.selectedLanguage}/${k}.json?v=${Date.now()}`).then(res=>res.ok?res.json():{})));let merged={};r.forEach(res=>{if(res.status==="fulfilled"&&typeof res.value==="object"&&res.value!==null){Object.assign(merged,res.value)}});if(Object.keys(merged).length===0){try{let fb=await fetch(`${p}${this.selectedLanguage}.json?v=${Date.now()}`);if(fb.ok)merged=await fb.json()}catch(err){}}if(Object.keys(merged).length>0){try{sessionStorage.setItem(cacheKey,JSON.stringify(merged))}catch(e){}}return merged}catch(e){return console.error("Translation load error:",e),{}}}async applyTranslations(forceRefresh=!1){let a=await this.loadTranslations(forceRefresh);document.querySelectorAll(this.translationKeySelector).forEach(e=>{var t=e.getAttribute(this.translationKeyAttribute),i=t.split(".").reduce((e,t)=>e?.[t]??null,a);i?e.innerHTML=i:console.warn("Missing translation for key: "+t)});document.querySelectorAll("[data-lang-placeholder]").forEach(e=>{var t=e.getAttribute("data-lang-placeholder"),i=t.split(".").reduce((e,t)=>e?.[t]??null,a);i&&e.setAttribute("placeholder",i)});document.querySelectorAll("[data-lang-title]").forEach(e=>{var t=e.getAttribute("data-lang-title"),i=t.split(".").reduce((e,t)=>e?.[t]??null,a);i&&e.setAttribute("title",i)});document.querySelectorAll("[data-lang-alt]").forEach(e=>{var t=e.getAttribute("data-lang-alt"),i=t.split(".").reduce((e,t)=>e?.[t]??null,a);i&&e.setAttribute("alt",i)});let e=document.querySelector("title[data-lang]");if(e){let t=e.getAttribute("data-lang"),i=t.split(".").reduce((e,t)=>e?.[t]??null,a);if(i){let s=document.title.split("|")[1]||"";document.title=i+(s?" |"+s:"")}}}setLanguage(e){this.selectedLanguage=e,sessionStorage.setItem("__THEME_LANG__",e);try{document.cookie="__THEME_LANG__="+e+";path=/;max-age=31536000;SameSite=Lax"}catch(t){}this.updateSelectedImage(),this.updateSelectedCode(),this.applyTranslations(!0)}updateSelectedImage(){var e=document.querySelector(`[data-translator-lang="${this.selectedLanguage}"] [data-translator-image]`);e&&this.selectedLanguageImage&&(this.selectedLanguageImage.src=e.src)}updateSelectedCode(){this.selectedLanguageCode&&(this.selectedLanguageCode.textContent=this.selectedLanguage.toUpperCase())}bindLanguageSwitchers(i){this.languageButtons.forEach(t=>{t.addEventListener("click",()=>{var e=t.dataset.translatorLang;e&&e!==this.selectedLanguage&&(this.setLanguage(e),i)&&i.changeLayoutDirection("ar"===e?"rtl":"ltr")})})}}document.addEventListener("DOMContentLoaded",function(e){(new App).init(),(new Plugins).init();var t=new LayoutCustomizer;t.init(),(new I18nManager).init(t)});let theme=(e,t=1)=>{var i=getComputedStyle(document.documentElement).getPropertyValue("--theme-"+e).trim();return e.includes("-rgb")?`rgba(${i}, ${t})`:i};function debounce(e,t){let i;return function(){clearTimeout(i),i=setTimeout(e,t)}}class CustomApexChart{constructor({selector:e,series:t=[],options:i={},colors:a=[]}){if(e){this.selector=e,this.series=t,this.getOptions=i,this.colors=a,this.selector instanceof HTMLElement?this.element=this.selector:this.element=document.querySelector(this.selector),this.chart=null;try{this.render(),CustomApexChart.instances.push(this)}catch(e){console.error("CustomApexChart: Error during chart initialization:",e)}}else console.warn("CustomApexChart: 'selector' is required.")}getColors(){var e=this.getOptions();if(e?.colors?.length)return e.colors;if(this.element){e=this.element.getAttribute("data-colors");if(e){e=e.split(",").map(e=>e.trim()).map(e=>e.startsWith("#")||e.includes("rgb")?e:theme(e));if(e.length)return e}}return[theme("chart-primary"),theme("chart-secondary"),theme("chart-beta")]}render(){if(this.chart&&this.chart.destroy(),this.element){let e=JSON.parse(JSON.stringify(this.getOptions()));e.colors=this.getColors(),(e=this.injectDynamicColors(e,e.colors)).series||(e.series=this.series),this.chart=new ApexCharts(this.element,e),this.chart.render()}else console.warn(`CustomApexChart: No element found for selector '${this.selector}'.`)}injectDynamicColors(e,i){var t;return"boxplot"===e.chart?.type?.toLowerCase()&&(e.plotOptions=e.plotOptions||{},e.plotOptions.boxPlot=e.plotOptions.boxPlot||{},e.plotOptions.boxPlot.colors=e.plotOptions.boxPlot.colors||{},e.plotOptions.boxPlot.colors.upper=e.plotOptions.boxPlot.colors.upper||i[0],e.plotOptions.boxPlot.colors.lower=e.plotOptions.boxPlot.colors.lower||i[1]),Array.isArray(e.yaxis)&&e.yaxis.forEach((e,t)=>{t=i[t]||this.colors[t]||"#999";e.axisBorder=e.axisBorder||{},e.axisBorder.color=e.axisBorder.color||t,e.labels=e.labels||{},e.labels.style=e.labels.style||{},e.labels.style.color=e.labels.style.color||t}),e.markers&&!e.markers.strokeColor&&(e.markers.strokeColor=i),"gradient"===e.fill?.type&&e.fill.gradient&&(e.fill.gradient.gradientToColors=e.fill.gradient.gradientToColors||i),e.plotOptions?.treemap?.colorScale?.ranges&&(0<(t=e.plotOptions.treemap.colorScale.ranges).length&&!t[0].color&&(t[0].color=i[0]),1<t.length)&&!t[1].color&&(t[1].color=i[1]),e}static rerenderAll(){if(0<CustomApexChart.instances.length)for(var e of CustomApexChart.instances)e.render()}}class CustomEChart{constructor({selector:e,options:t={},theme:i=null,initOptions:a={}}){if(e){this.selector=e,this.element=null,this.getOptions=t,this.theme=i,this.initOptions=a,this.chart=null;try{this.render(),CustomEChart.instances.push(this)}catch(e){console.error("CustomEChart: Initialization error",e)}}else console.warn("CustomEChart: 'selector' is required.")}render(){try{var e;this.selector instanceof HTMLElement?this.element=this.selector:this.element=document.querySelector(this.selector),this.chart&&this.chart.dispose(),this.element?(e=this.getOptions(),this.chart=echarts.init(this.element,this.theme,this.initOptions),this.chart.setOption(e),window.addEventListener("resize",debounce(()=>{this.chart.resize()},200))):console.warn(`CustomEChart: No element found for selector '${this.selector}'.`)}catch(e){console.error(`CustomEChart: Render error for '${this.selector}'`,e)}}static reSizeAll(){if(0<CustomEChart.instances.length)for(let e of CustomEChart.instances)e.element&&null!==e.element.offsetParent&&requestAnimationFrame(()=>{e.chart.on("finished",()=>{requestAnimationFrame(()=>{e.chart.resize()})})})}static rerenderAll(){if(0<CustomEChart.instances.length)for(var e of CustomEChart.instances)e.render()}}class CustomChartJs{static instances=[];constructor({selector:e,options:t=()=>({})}){if(e){this.selector=e,this.getOptions="function"==typeof t?t:()=>t,this.element=null,this.chart=null;try{this.render(),CustomChartJs.instances.push(this)}catch(e){console.error("CustomChartJs: Initialization error",e)}}else console.warn("CustomChartJs: 'selector' is required.")}static getDefaultOptions(){var e=getComputedStyle(document.body).fontFamily.trim();return{responsive:!0,maintainAspectRatio:!1,layout:{padding:{top:-10}},scales:{x:{ticks:{font:{family:e},color:theme("secondary-color"),display:!0,drawTicks:!0},grid:{display:!1,drawBorder:!1},border:{display:!1}},y:{ticks:{font:{family:e},color:theme("secondary-color")},grid:{display:!0,drawBorder:!1,color:theme("chart-border-color"),lineWidth:1},border:{display:!1,dash:[5,5]}}},plugins:{legend:{display:!0,position:"top",labels:{font:{family:e},color:theme("secondary-color"),usePointStyle:!0,pointStyle:"circle",boxWidth:8,boxHeight:8,padding:15}},tooltip:{enabled:!0,titleFont:{family:e},bodyFont:{family:e}}}}}render(){try{var e,t,i,a;this.element=this.selector instanceof HTMLElement?this.selector:document.querySelector(this.selector),this.element?(this.chart&&this.chart.destroy(),{type:e,data:t,options:i,plugins:a}=this.getOptions(),this.chart=new Chart(this.element,{type:e||"bar",data:t,options:{...structuredClone(CustomChartJs.getDefaultOptions()),...i||{}},plugins:a||[]}),window.addEventListener("resize",debounce(()=>{this.chart&&this.chart.resize()},200))):console.warn(`CustomChartJs: No element found for selector '${this.selector}'`)}catch(e){console.error(`CustomChartJs: Render error for '${this.selector}'`,e)}}static rerenderAll(){for(var e of CustomChartJs.instances)e.render()}static reSizeAll(){for(var e of CustomChartJs.instances)e.chart&&e.chart.resize()}static destroyAll(){for(var e of CustomChartJs.instances)e.chart&&e.chart.destroy();CustomChartJs.instances=[]}}CustomApexChart.instances=[],CustomEChart.instances=[],CustomChartJs.instances=[];let themeObserver=new MutationObserver(()=>{CustomApexChart.rerenderAll(),CustomEChart.rerenderAll(),CustomChartJs.rerenderAll()}),menuObserver=(themeObserver.observe(document.documentElement,{attributes:!0,attributeFilter:["data-skin","data-bs-theme"]}),new MutationObserver(()=>{requestAnimationFrame(()=>{CustomEChart.reSizeAll()})}));menuObserver.observe(document.documentElement,{attributes:!0,attributeFilter:["data-sidenav-size"]});