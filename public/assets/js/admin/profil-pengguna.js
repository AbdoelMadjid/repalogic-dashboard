/**
 * Profil Pengguna Module JavaScript
 * Path: public/assets/js/admin/profil-pengguna.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // =========================================================================
    // 1. Live Image Preview for Modal Avatar Upload
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

    // =========================================================================
    // 2. Live Image Preview, Vertical Position Slider & Height Adjustment for Cover Header
    // =========================================================================
    const coverInput = document.getElementById('cover_bg_input');
    const coverPreview = document.getElementById('cover-preview-img');
    const coverPreviewContainer = document.getElementById('cover-preview-container');
    const mainHeaderBanner = document.getElementById('main-header-banner');
    const coverPosRange = document.getElementById('cover-position-range');
    const coverPosVal = document.getElementById('cover-pos-val');
    const presetButtons = document.querySelectorAll('.btn-preset-pos');

    const coverHeightRange = document.getElementById('cover-height-range');
    const coverHeightVal = document.getElementById('cover-height-val');
    const presetHeightButtons = document.querySelectorAll('.btn-preset-height');

    function syncCoverPreviewRatio() {
        if (mainHeaderBanner && coverPreviewContainer && coverHeightRange) {
            const bannerWidth = mainHeaderBanner.offsetWidth || 1140;
            const currentHeight = parseInt(coverHeightRange.value, 10) || 320;
            coverPreviewContainer.style.aspectRatio = `${bannerWidth} / ${currentHeight}`;
        }
    }

    function updateCoverPosition(pos) {
        const posPercent = pos + '%';
        if (coverPosVal) {
            coverPosVal.textContent = posPercent;
        }
        if (coverPosRange) {
            coverPosRange.value = pos;
        }
        if (coverPreview) {
            coverPreview.style.objectPosition = 'center ' + posPercent;
        }
        if (mainHeaderBanner) {
            mainHeaderBanner.style.backgroundPosition = 'center ' + posPercent;
        }
    }

    function updateCoverHeight(height) {
        const heightPx = height + 'px';

        if (coverHeightVal) {
            coverHeightVal.textContent = heightPx;
        }
        if (coverHeightRange) {
            coverHeightRange.value = height;
        }
        if (mainHeaderBanner) {
            mainHeaderBanner.style.height = heightPx;
        }
        syncCoverPreviewRatio();
    }

    // Sync initial aspect ratio and on window resize
    syncCoverPreviewRatio();
    window.addEventListener('resize', syncCoverPreviewRatio);

    if (coverPosRange) {
        coverPosRange.addEventListener('input', function(e) {
            updateCoverPosition(e.target.value);
        });
    }

    presetButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const pos = this.getAttribute('data-pos');
            if (pos !== null) {
                updateCoverPosition(pos);
            }
        });
    });

    if (coverHeightRange) {
        coverHeightRange.addEventListener('input', function(e) {
            updateCoverHeight(e.target.value);
        });
    }

    presetHeightButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const h = this.getAttribute('data-height');
            if (h !== null) {
                updateCoverHeight(h);
            }
        });
    });

    if (coverInput) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    if (coverPreview) {
                        coverPreview.src = evt.target.result;
                    }
                    if (mainHeaderBanner) {
                        mainHeaderBanner.style.backgroundImage = 'url("' + evt.target.result + '")';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

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

    // =========================================================================
    // 6. Live KTP Image Preview (for edit.blade.php if loaded)
    // =========================================================================
    const ktpInput = document.getElementById('foto_ktp_input');
    const ktpPreview = document.getElementById('ktp-preview-img');

    if (ktpInput && ktpPreview) {
        ktpInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    ktpPreview.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
