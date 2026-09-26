/**
 * Education Theme Bilingual & i18n Translation Engine
 * Fully compatible with REPALOGIC Dashboard modular translation architecture
 */
class EducationI18n {
    constructor({
        defaultLang = 'id',
        langPath = '/assets/data/translations/',
        flagPath = '/assets/images/flags/',
        langImageSelector = '#edu-selected-lang-img',
        langCodeSelector = '#edu-selected-lang-code',
        translationKeySelector = '[data-lang]',
        translationKeyAttribute = 'data-lang',
        languageSelector = '[data-translator-lang]'
    } = {}) {
        this.selectedLanguage = sessionStorage.getItem('__THEME_LANG__') || this.getCookie('__THEME_LANG__') || defaultLang;
        this.langPath = langPath;
        this.flagPath = flagPath;
        this.langImageSelector = langImageSelector;
        this.langCodeSelector = langCodeSelector;
        this.translationKeySelector = translationKeySelector;
        this.translationKeyAttribute = translationKeyAttribute;
        this.languageSelector = languageSelector;
    }

    getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    setCookie(name, value) {
        document.cookie = `${name}=${value};path=/;max-age=31536000;SameSite=Lax`;
    }

    async init() {
        this.setCookie('__THEME_LANG__', this.selectedLanguage);
        sessionStorage.setItem('__THEME_LANG__', this.selectedLanguage);
        this.updateHeaderUI();
        await this.applyTranslations();
        this.bindEvents();
    }

    async loadTranslations(forceRefresh = false) {
        try {
            const cacheKey = `__TRANS_CACHE_${this.selectedLanguage}__`;
            if (!forceRefresh) {
                const cached = sessionStorage.getItem(cacheKey);
                if (cached) {
                    try {
                        const parsed = JSON.parse(cached);
                        if (parsed && Object.keys(parsed).length > 0) return parsed;
                    } catch (e) {}
                }
            }

            let p = this.langPath.startsWith('/') || this.langPath.startsWith('http') ? this.langPath : '/' + this.langPath;
            if (!p.endsWith('/')) p += '/';

            const modules = ['frontpage', 'topbar', 'auth', 'sidebar_menu', 'customizer'];
            const results = await Promise.allSettled(
                modules.map(k => fetch(`${p}${this.selectedLanguage}/${k}.json?v=${Date.now()}`).then(res => res.ok ? res.json() : {}))
            );

            let merged = {};
            results.forEach(res => {
                if (res.status === 'fulfilled' && typeof res.value === 'object' && res.value !== null) {
                    Object.assign(merged, res.value);
                }
            });

            if (Object.keys(merged).length === 0) {
                try {
                    let fb = await fetch(`${p}${this.selectedLanguage}.json?v=${Date.now()}`);
                    if (fb.ok) merged = await fb.json();
                } catch (err) {}
            }

            if (Object.keys(merged).length > 0) {
                try {
                    sessionStorage.setItem(cacheKey, JSON.stringify(merged));
                } catch (e) {}
            }

            return merged;
        } catch (e) {
            console.error('Education translation load error:', e);
            return {};
        }
    }

    async applyTranslations(forceRefresh = false) {
        const dict = await this.loadTranslations(forceRefresh);
        if (!dict || Object.keys(dict).length === 0) return;

        // Apply text to elements with data-lang
        document.querySelectorAll(this.translationKeySelector).forEach(el => {
            const key = el.getAttribute(this.translationKeyAttribute);
            if (dict[key]) {
                el.innerHTML = dict[key];
            }
        });

        // Apply placeholders
        document.querySelectorAll('[data-lang-placeholder]').forEach(el => {
            const key = el.getAttribute('data-lang-placeholder');
            if (dict[key]) {
                el.setAttribute('placeholder', dict[key]);
            }
        });

        // Apply titles
        document.querySelectorAll('[data-lang-title]').forEach(el => {
            const key = el.getAttribute('data-lang-title');
            if (dict[key]) {
                el.setAttribute('title', dict[key]);
            }
        });

        // Apply alts
        document.querySelectorAll('[data-lang-alt]').forEach(el => {
            const key = el.getAttribute('data-lang-alt');
            if (dict[key]) {
                el.setAttribute('alt', dict[key]);
            }
        });
    }

    updateHeaderUI() {
        const isEn = this.selectedLanguage === 'en';
        const img = document.querySelector(this.langImageSelector);
        const code = document.querySelector(this.langCodeSelector);
        const flagSrc = isEn ? `${this.flagPath}us.svg` : `${this.flagPath}id.svg`;
        const label = isEn ? 'English' : 'Indonesia';

        if (img) {
            img.src = flagSrc;
            img.alt = label;
        }
        if (code) {
            code.textContent = label;
        }
    }

    async setLanguage(lang) {
        if (lang === this.selectedLanguage) return;
        this.selectedLanguage = lang;
        sessionStorage.setItem('__THEME_LANG__', lang);
        this.setCookie('__THEME_LANG__', lang);
        this.updateHeaderUI();
        await this.applyTranslations(true);
    }

    bindEvents() {
        document.querySelectorAll(this.languageSelector).forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const targetLang = btn.getAttribute('data-translator-lang');
                if (targetLang) {
                    this.setLanguage(targetLang);
                }
            });
        });
    }
}

// Auto-init on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.educationI18n = new EducationI18n();
    window.educationI18n.init();
});
