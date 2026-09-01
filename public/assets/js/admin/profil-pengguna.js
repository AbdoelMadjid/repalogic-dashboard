/**
 * Profil Pengguna Module JavaScript
 * Path: public/assets/js/admin/profil-pengguna.js
 */

function initProfilPengguna() {
    'use strict';

    // =========================================================================
    // 1. Live Image Preview for Avatar & Foto KTP Upload
    // =========================================================================
    const modalAvatarInput = document.getElementById('modal-avatar-input');
    const modalAvatarPreview = document.getElementById('modal-avatar-preview');

    if (modalAvatarInput && modalAvatarPreview) {
        modalAvatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    modalAvatarPreview.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    const fotoKtpInput = document.getElementById('foto_ktp_input');
    const ktpPreview = document.getElementById('ktp-preview-img');
    const ktpWrapper = document.getElementById('ktp-preview-wrapper');

    if (fotoKtpInput && ktpPreview) {
        fotoKtpInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    ktpPreview.src = evt.target.result;
                    if (ktpWrapper) ktpWrapper.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // =========================================================================
    // 2. Live Image Preview, Color, Opacity, Blur, Vertical Position & Height for Cover Header
    // =========================================================================
    const coverInput = document.getElementById('cover_bg_input');
    const coverPreview = document.getElementById('cover-preview-img');
    const coverPreviewContainer = document.getElementById('cover-preview-container');
    const coverPreviewOverlay = document.getElementById('cover-preview-overlay');
    const mainHeaderBanner = document.getElementById('main-header-banner');
    const mainHeaderOverlay = document.getElementById('main-header-overlay');

    const coverColorInput = document.getElementById('cover-color-input');
    const coverColorVal = document.getElementById('cover-color-val');
    const coverOpacityRange = document.getElementById('cover-opacity-range');
    const coverOpacityVal = document.getElementById('cover-opacity-val');
    const coverBlurRange = document.getElementById('cover-blur-range');
    const coverBlurVal = document.getElementById('cover-blur-val');

    const coverPosRange = document.getElementById('cover-position-range');
    const coverPosVal = document.getElementById('cover-pos-val');
    const coverHeightRange = document.getElementById('cover-height-range');
    const coverHeightVal = document.getElementById('cover-height-val');

    let currentCoverColor = coverColorInput ? coverColorInput.value : '#313a46';
    let currentCoverOpacity = coverOpacityRange ? parseInt(coverOpacityRange.value, 10) : 60;
    let currentCoverBlur = coverBlurRange ? parseInt(coverBlurRange.value, 10) : 0;

    function hexToRgba(hex, alpha) {
        if (!hex || !hex.startsWith('#')) return hex || 'rgba(49, 58, 70, 0.6)';
        let c = hex.replace('#', '');
        if (c.length === 3) {
            c = c.split('').map(x => x + x).join('');
        }
        const num = parseInt(c, 16);
        const r = (num >> 16) & 255;
        const g = (num >> 8) & 255;
        const b = num & 255;
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    function applyCoverStyling() {
        const alpha = currentCoverOpacity / 100;
        const rgbaBottom = hexToRgba(currentCoverColor, alpha);
        const rgbaTop = hexToRgba(currentCoverColor, Math.max(0, alpha - 0.25));
        const gradientBg = `linear-gradient(to top, ${rgbaBottom}, ${rgbaTop})`;
        const blurVal = currentCoverBlur > 0 ? `blur(${currentCoverBlur}px)` : 'none';

        // 1. Update Main Header Banner Overlay
        if (mainHeaderOverlay) {
            mainHeaderOverlay.style.background = gradientBg;
            mainHeaderOverlay.style.backdropFilter = blurVal;
            mainHeaderOverlay.style.webkitBackdropFilter = blurVal;
        }

        // 2. Update Sidebar Preview Overlay
        if (coverPreviewOverlay) {
            coverPreviewOverlay.style.background = gradientBg;
            coverPreviewOverlay.style.backdropFilter = blurVal;
            coverPreviewOverlay.style.webkitBackdropFilter = blurVal;
        }

        // 3. Update Inputs and Labels
        if (coverColorVal) coverColorVal.textContent = currentCoverColor;
        if (coverColorInput) coverColorInput.value = currentCoverColor;
        if (coverOpacityVal) coverOpacityVal.textContent = currentCoverOpacity + '%';
        if (coverOpacityRange) coverOpacityRange.value = currentCoverOpacity;
        if (coverBlurVal) coverBlurVal.textContent = currentCoverBlur + 'px';
        if (coverBlurRange) coverBlurRange.value = currentCoverBlur;

        // 4. Update Swatch Active State
        document.querySelectorAll('.btn-color-swatch').forEach(function(swatch) {
            const swColor = swatch.getAttribute('data-color');
            if (swColor && swColor.toLowerCase() === currentCoverColor.toLowerCase()) {
                swatch.classList.add('active');
            } else {
                swatch.classList.remove('active');
            }
        });
    }

    function syncCoverPreviewRatio() {
        if (mainHeaderBanner && coverPreviewContainer && coverHeightRange) {
            const bannerWidth = mainHeaderBanner.offsetWidth || 1140;
            const currentHeight = parseInt(coverHeightRange.value, 10) || 320;
            coverPreviewContainer.style.aspectRatio = `${bannerWidth} / ${currentHeight}`;
        }
    }

    function updateCoverPosition(pos) {
        const posPercent = pos + '%';
        if (coverPosVal) coverPosVal.textContent = posPercent;
        if (coverPosRange) coverPosRange.value = pos;
        if (coverPreview) coverPreview.style.objectPosition = 'center ' + posPercent;
        if (mainHeaderBanner) mainHeaderBanner.style.backgroundPosition = 'center ' + posPercent;
    }

    function updateCoverHeight(height) {
        const heightPx = height + 'px';
        if (coverHeightVal) coverHeightVal.textContent = heightPx;
        if (coverHeightRange) coverHeightRange.value = height;
        if (mainHeaderBanner) mainHeaderBanner.style.height = heightPx;
        syncCoverPreviewRatio();
    }

    // Color Input
    if (coverColorInput) {
        coverColorInput.addEventListener('input', function(e) {
            currentCoverColor = e.target.value;
            applyCoverStyling();
        });
    }

    // Opacity Range
    if (coverOpacityRange) {
        coverOpacityRange.addEventListener('input', function(e) {
            currentCoverOpacity = parseInt(e.target.value, 10) || 0;
            applyCoverStyling();
        });
    }

    // Blur Range
    if (coverBlurRange) {
        coverBlurRange.addEventListener('input', function(e) {
            currentCoverBlur = parseInt(e.target.value, 10) || 0;
            applyCoverStyling();
        });
    }

    // Position Range
    if (coverPosRange) {
        coverPosRange.addEventListener('input', function(e) {
            updateCoverPosition(e.target.value);
        });
    }

    // Height Range
    if (coverHeightRange) {
        coverHeightRange.addEventListener('input', function(e) {
            updateCoverHeight(e.target.value);
        });
    }

    // Event Delegation for Swatches & Preset Buttons (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const swatch = e.target.closest('.btn-color-swatch');
        if (swatch) {
            const color = swatch.getAttribute('data-color');
            if (color) {
                currentCoverColor = color;
                applyCoverStyling();
            }
            return;
        }

        const opacityBtn = e.target.closest('.btn-preset-opacity');
        if (opacityBtn) {
            const op = opacityBtn.getAttribute('data-opacity');
            if (op !== null) {
                currentCoverOpacity = parseInt(op, 10);
                applyCoverStyling();
            }
            return;
        }

        const blurBtn = e.target.closest('.btn-preset-blur');
        if (blurBtn) {
            const bl = blurBtn.getAttribute('data-blur');
            if (bl !== null) {
                currentCoverBlur = parseInt(bl, 10);
                applyCoverStyling();
            }
            return;
        }

        const heightBtn = e.target.closest('.btn-preset-height');
        if (heightBtn) {
            const h = heightBtn.getAttribute('data-height');
            if (h !== null) updateCoverHeight(h);
            return;
        }

        const posBtn = e.target.closest('.btn-preset-pos');
        if (posBtn) {
            const p = posBtn.getAttribute('data-pos');
            if (p !== null) updateCoverPosition(p);
            return;
        }
    });

    // File Input
    if (coverInput) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    if (coverPreview) coverPreview.src = evt.target.result;
                    if (mainHeaderBanner) mainHeaderBanner.style.backgroundImage = 'url("' + evt.target.result + '")';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Initial sync
    syncCoverPreviewRatio();
    window.addEventListener('resize', syncCoverPreviewRatio);

    // =========================================================================
    // 3. Real-time Motto Typing Preview
    // =========================================================================
    const mottoInput = document.getElementById('motto_input');
    const mottoDisplay = document.getElementById('main-motto-display');
    if (mottoInput && mottoDisplay) {
        mottoInput.addEventListener('input', function() {
            mottoDisplay.textContent = '"' + (this.value || 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.') + '"';
        });
    }

    // =========================================================================
    // 4. Toggle Show/Hide Password Eye Icons (Rule 2 Compliance: Event Delegation)
    // =========================================================================
    document.addEventListener('click', function(e) {
        const toggleBtn = e.target.closest('.toggle-password');
        if (toggleBtn) {
            const targetId = toggleBtn.getAttribute('data-input-id');
            const inputField = document.getElementById(targetId);
            const icon = toggleBtn.querySelector('i');

            if (inputField) {
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    if (icon) {
                        icon.classList.remove('ti-eye');
                        icon.classList.add('ti-eye-off');
                    }
                } else {
                    inputField.type = 'password';
                    if (icon) {
                        icon.classList.remove('ti-eye-off');
                        icon.classList.add('ti-eye');
                    }
                }
            }
        }
    });

    // =========================================================================
    // 5. Listener Tombol Pesan / Chat pada Header Profil Pengguna
    // =========================================================================
    const btnUserMessages = document.getElementById('btn-user-messages');
    if (btnUserMessages) {
        btnUserMessages.addEventListener('click', function() {
            const topbarMsgBtn = document.getElementById('topbar-messages-toggle-btn');
            if (topbarMsgBtn && window.bootstrap && window.bootstrap.Dropdown) {
                const bsDropdown = window.bootstrap.Dropdown.getOrCreateInstance(topbarMsgBtn);
                bsDropdown.toggle();
            } else if (typeof window.showToast === 'function') {
                window.showToast('Fitur Pesan Siap Digunakan!', 'success');
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProfilPengguna);
} else {
    initProfilPengguna();
}
