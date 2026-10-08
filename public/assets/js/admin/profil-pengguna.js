/**
 * Profil Pengguna Module JavaScript
 * Path: public/assets/js/admin/profil-pengguna.js
 */

function initProfilPengguna() {
    'use strict';

    // =========================================================================
    // 1. Interactive Cropper.js for Avatar Upload (2-File Architecture: 1:1 Cropped Avatar + Original Master)
    // =========================================================================
    const modalAvatarInput = document.getElementById('modal-avatar-input');
    const modalAvatarOriginalInput = document.getElementById('modal-avatar-original-input');
    const modalAvatarCropData = document.getElementById('modal-avatar-crop-data');
    const modalAvatarPreview = document.getElementById('modal-avatar-preview');
    const cropModalEl = document.getElementById('modal-crop-avatar');
    const cropSourceImage = document.getElementById('crop-source-image');
    const btnApplyCrop = document.getElementById('btn-apply-crop');

    let cropperInstance = null;
    let cropScaleX = 1;
    let cropScaleY = 1;
    let selectedRawFile = null;
    let currentMasterDataUrl = null;
    let savedCropData = window.ProfilPenggunaConfig?.avatarCropData || null;

    if (modalAvatarInput && cropModalEl && cropSourceImage) {
        const cropModal = bootstrap.Modal.getOrCreateInstance(cropModalEl);

        // Handle new file selection from device
        modalAvatarInput.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                if (window.showError) {
                    window.showError('Berkas yang dipilih harus berupa file gambar (JPG, PNG, WEBP, SVG).', 'Format Tidak Didukung');
                }
                modalAvatarInput.value = '';
                return;
            }

            selectedRawFile = file;

            const reader = new FileReader();
            reader.onload = function(evt) {
                currentMasterDataUrl = evt.target.result;
                savedCropData = null; // Reset crop data for brand new photo
                cropSourceImage.src = currentMasterDataUrl;
                cropModal.show();
            };
            reader.readAsDataURL(file);
        });

        // Handle re-crop / adjust position on current photo
        const btnReCropCurrent = document.getElementById('btn-re-crop-current');
        if (btnReCropCurrent) {
            btnReCropCurrent.addEventListener('click', function() {
                const isDefaultAvatar = (src) => !src || src.includes('user-default.jpg') || src.includes('default-avatar.svg');
                const sourceToUse = currentMasterDataUrl ||
                                    window.ProfilPenggunaConfig?.avatarOriginalUrl ||
                                    (modalAvatarPreview && modalAvatarPreview.src && !isDefaultAvatar(modalAvatarPreview.src) ? modalAvatarPreview.src : null);

                if (sourceToUse && !isDefaultAvatar(sourceToUse)) {
                    cropSourceImage.src = sourceToUse;
                    cropModal.show();
                } else {
                    modalAvatarInput.click();
                }
            });
        }

        cropModalEl.addEventListener('shown.bs.modal', function() {
            if (cropperInstance) {
                cropperInstance.destroy();
            }

            cropScaleX = 1;
            cropScaleY = 1;

            if (typeof Cropper !== 'undefined') {
                cropperInstance = new Cropper(cropSourceImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.9,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    preview: '.avatar-crop-preview, .avatar-crop-preview-square',
                    ready: function() {
                        // Jika ada data koordinat crop sebelumnya, terapkan kembali
                        if (savedCropData && typeof savedCropData === 'object' && savedCropData.width) {
                            try {
                                cropperInstance.setData(savedCropData);
                            } catch (e) {
                                console.warn('Could not restore crop data', e);
                            }
                        }
                    }
                });
            }
        });

        cropModalEl.addEventListener('hidden.bs.modal', function() {
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        });

        // Toolbar Buttons Integration
        document.getElementById('btn-crop-zoom-in')?.addEventListener('click', function() {
            cropperInstance?.zoom(0.1);
        });
        document.getElementById('btn-crop-zoom-out')?.addEventListener('click', function() {
            cropperInstance?.zoom(-0.1);
        });
        document.getElementById('btn-crop-move-left')?.addEventListener('click', function() {
            cropperInstance?.move(-15, 0);
        });
        document.getElementById('btn-crop-move-right')?.addEventListener('click', function() {
            cropperInstance?.move(15, 0);
        });
        document.getElementById('btn-crop-move-up')?.addEventListener('click', function() {
            cropperInstance?.move(0, -15);
        });
        document.getElementById('btn-crop-move-down')?.addEventListener('click', function() {
            cropperInstance?.move(0, 15);
        });
        document.getElementById('btn-crop-rotate-left')?.addEventListener('click', function() {
            cropperInstance?.rotate(-90);
        });
        document.getElementById('btn-crop-rotate-right')?.addEventListener('click', function() {
            cropperInstance?.rotate(90);
        });
        document.getElementById('btn-crop-flip-x')?.addEventListener('click', function() {
            cropScaleX = -cropScaleX;
            cropperInstance?.scaleX(cropScaleX);
        });
        document.getElementById('btn-crop-reset')?.addEventListener('click', function() {
            cropperInstance?.reset();
            cropScaleX = 1;
            cropScaleY = 1;
        });

        // Apply Cropped Image (Pixel-Perfect 400x400 Cropped Avatar + Master Photo Retention)
        btnApplyCrop?.addEventListener('click', function() {
            if (!cropperInstance) return;

            // 1. Dapatkan koordinat & skala crop saat ini
            const cropData = cropperInstance.getData(true);
            savedCropData = cropData;

            if (modalAvatarCropData) {
                modalAvatarCropData.value = JSON.stringify(cropData);
            }

            // 2. Export hasil potongan 1:1 persegi beresolusi 400x400 px
            const croppedCanvas = cropperInstance.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!croppedCanvas) return;

            croppedCanvas.toBlob(function(croppedBlob) {
                if (!croppedBlob) return;

                // A. Set file hasil crop murni ke input 'avatar'
                try {
                    const croppedFile = new File([croppedBlob], 'avatar-cropped.jpg', { type: 'image/jpeg' });
                    const dt = new DataTransfer();
                    dt.items.add(croppedFile);
                    modalAvatarInput.files = dt.files;
                } catch (err) {
                    console.warn('DataTransfer cropped avatar error', err);
                }

                // B. Jika user memilih file baru dari disk, kirimkan juga master foto utuh
                if (selectedRawFile && modalAvatarOriginalInput) {
                    try {
                        const origDt = new DataTransfer();
                        origDt.items.add(selectedRawFile);
                        modalAvatarOriginalInput.files = origDt.files;
                    } catch (err) {
                        console.warn('DataTransfer master original error', err);
                    }
                }

                // C. Update pratinjau avatar di halaman profil (100% presisi dan tajam)
                const croppedDataUrl = croppedCanvas.toDataURL('image/jpeg', 0.92);
                if (modalAvatarPreview) {
                    modalAvatarPreview.src = croppedDataUrl;
                }

                const mainHeaderAvatar = document.querySelector('.card-body img.rounded-circle.img-thumbnail');
                if (mainHeaderAvatar) {
                    mainHeaderAvatar.src = croppedDataUrl;
                }

                // D. Tutup Modal & Beri Notifikasi
                cropModal.hide();

                if (window.showToast) {
                    window.showToast('Foto avatar berhasil dipotong presisi! Klik "Simpan Perubahan Profil" untuk menyimpan.', 'success', 4000);
                }
            }, 'image/jpeg', 0.92);
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
    const mottoPreviewContainer = document.getElementById('motto-preview-container');
    const mottoPreviewOverlay = document.getElementById('motto-preview-overlay');

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
        const rgbaStart = hexToRgba(currentCoverColor, alpha);
        const rgbaEnd = hexToRgba(currentCoverColor, Math.max(0, alpha - 0.25));
        const gradientBg = `linear-gradient(135deg, ${rgbaStart}, ${rgbaEnd})`;
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

        // 3. Update Motto Card Preview Overlay
        if (mottoPreviewOverlay) {
            mottoPreviewOverlay.style.background = gradientBg;
            mottoPreviewOverlay.style.backdropFilter = blurVal;
            mottoPreviewOverlay.style.webkitBackdropFilter = blurVal;
        }

        // 4. Update Inputs and Labels
        if (coverColorVal) coverColorVal.textContent = currentCoverColor;
        if (coverColorInput) coverColorInput.value = currentCoverColor;
        if (coverOpacityVal) coverOpacityVal.textContent = currentCoverOpacity + '%';
        if (coverOpacityRange) coverOpacityRange.value = currentCoverOpacity;
        if (coverBlurVal) coverBlurVal.textContent = currentCoverBlur + 'px';
        if (coverBlurRange) coverBlurRange.value = currentCoverBlur;

        // 5. Update Swatch Active State
        document.querySelectorAll('.btn-cover-color-swatch').forEach(function(swatch) {
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
        if (mottoPreviewContainer) mottoPreviewContainer.style.backgroundPosition = 'center ' + posPercent;
    }

    function updateCoverHeight(height) {
        const heightPx = height + 'px';
        if (coverHeightVal) coverHeightVal.textContent = heightPx;
        if (coverHeightRange) coverHeightRange.value = height;
        if (mainHeaderBanner) {
            mainHeaderBanner.style.minHeight = heightPx;
        }
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

    // Event Delegation for Cover Swatches & Preset Buttons (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const coverSwatch = e.target.closest('.btn-cover-color-swatch');
        if (coverSwatch) {
            const color = coverSwatch.getAttribute('data-color');
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
                    if (mottoPreviewContainer) mottoPreviewContainer.style.backgroundImage = 'url("' + evt.target.result + '")';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Initial sync
    syncCoverPreviewRatio();
    window.addEventListener('resize', syncCoverPreviewRatio);

    // =========================================================================
    // 3. Real-time Motto Typing & Text Color Preview
    // =========================================================================
    const mottoInput = document.getElementById('motto_input');
    const mottoDisplay = document.getElementById('main-motto-display');
    const mottoMiniPreviewText = document.getElementById('motto-mini-preview-text');
    const mottoColorInput = document.getElementById('motto_color_input');
    const mottoColorVal = document.getElementById('motto-color-val');

    function applyMottoColor(color) {
        if (!color) return;
        const darkColors = ['#000000', '#111827', '#1f2937', '#0f172a', 'black'];
        const isDark = darkColors.includes(color.toLowerCase());
        
        if (mottoDisplay) {
            mottoDisplay.style.color = color;
            mottoDisplay.style.textShadow = isDark ? '0 2px 8px rgba(255, 255, 255, 0.7)' : '0 2px 8px rgba(0, 0, 0, 0.75)';
        }
        if (mottoMiniPreviewText) {
            mottoMiniPreviewText.style.color = color;
            mottoMiniPreviewText.style.textShadow = isDark ? '0 1px 4px rgba(255, 255, 255, 0.8)' : '0 1px 4px rgba(0, 0, 0, 0.8)';
        }
        if (mottoColorInput) mottoColorInput.value = color;
        if (mottoColorVal) mottoColorVal.textContent = color;

        document.querySelectorAll('.btn-motto-color-swatch').forEach(function(swatch) {
            const swColor = swatch.getAttribute('data-color');
            if (swColor && swColor.toLowerCase() === color.toLowerCase()) {
                swatch.classList.add('active');
            } else {
                swatch.classList.remove('active');
            }
        });
    }

    // Curated list of inspiring default mottos for quick randomization
    const presetMottos = [
        'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.',
        'Jadikan setiap langkah sebagai jejak kebaikan dan inspirasi.',
        'Kerja keras mengalahkan bakat ketika bakat tidak bekerja keras.',
        'Kesuksesan berawal dari keberanian untuk memulai hal kecil dengan konsisten.',
        'Fokus pada proses, nikmati setiap pembelajaran dalam perjalanan hidup.',
        'Disiplin adalah jembatan antara impian dan pencapaian nyata.',
        'Berpikir positif, bertindak bijak, dan selalu bersyukur atas setiap proses.',
        'Inovasi membedakan antara seorang pemimpin dan pengikut sejati.',
        'Kebaikan kecil yang konsisten lebih berharga dari rencana besar tanpa aksi.',
        'Bekerja dengan integritas, berkarya dengan dedikasi dan ketulusan hati.',
        'Jangan takut gagal, takutlah jika kesempatan berlalu tanpa pernah mencoba.',
        'Waktu terbaik untuk memulai langkah besar adalah hari ini.',
        'Bekerja cerdas, bersikap rendah hati, dan terus melangkah maju.',
        'Tantangan hari ini adalah kekuatan untuk meraih kesuksesan esok hari.',
        'Jadilah agen perubahan positif di mana pun Anda berada.',
        'Kunci kesuksesan sejati adalah mencintai apa yang sedang Anda kerjakan.',
        'Selalu ada jalan terbuka bagi mereka yang memiliki tekad pantang menyerah.',
        'Kesabaran dan ketekunan mampu meluluhkan segala rintangan besar.',
        'Mimpi besar tidak akan pernah terwujud tanpa tindakan nyata dan konsisten.',
        'Hidup adalah perjalanan belajar dan bertumbuh yang tidak pernah berhenti.'
    ];

    if (mottoInput) {
        mottoInput.addEventListener('input', function() {
            const text = '"' + (this.value || 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.') + '"';
            if (mottoDisplay) mottoDisplay.textContent = text;
            if (mottoMiniPreviewText) mottoMiniPreviewText.textContent = text;
        });
    }

    if (mottoColorInput) {
        mottoColorInput.addEventListener('input', function(e) {
            applyMottoColor(e.target.value);
        });
    }

    // Event delegation for Motto Color Swatches & Random Motto Generator (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        // Random Motto Generator button
        const randomBtn = e.target.closest('#btn-random-motto');
        if (randomBtn && mottoInput) {
            const currentVal = mottoInput.value.trim();
            const availableMottos = presetMottos.filter(m => m !== currentVal);
            const randomMotto = availableMottos[Math.floor(Math.random() * availableMottos.length)] || presetMottos[0];
            
            mottoInput.value = randomMotto;
            mottoInput.dispatchEvent(new Event('input', { bubbles: true }));
            
            // Subtle button animation feedback
            const icon = randomBtn.querySelector('i');
            if (icon) {
                icon.style.transition = 'transform 0.35s ease';
                icon.style.transform = 'rotate(180deg)';
                setTimeout(() => { icon.style.transform = 'none'; }, 350);
            }
            if (typeof window.showToast === 'function') {
                window.showToast('Motto inspiratif dipilih secara acak!', 'info', 1500);
            }
            return;
        }

        const mottoSwatch = e.target.closest('.btn-motto-color-swatch');
        if (mottoSwatch) {
            const color = mottoSwatch.getAttribute('data-color');
            if (color) {
                applyMottoColor(color);
            }
        }
    });

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
    // 6. Realtime Polling for Profile Likes & Friends Count
    // =========================================================================
    function initRealtimeProfileStats() {
        const pollUrl = window.ProfilPenggunaConfig?.routes?.pollDashboard;
        if (!pollUrl) return;

        let previousLikes = null;

        function fetchProfileStats() {
            fetch(pollUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data || !data.success) return;

                // 1. Update Friends Count
                const friendsCountEl = document.getElementById('header-profile-friends-count');
                if (friendsCountEl && data.friendsCount !== undefined) {
                    friendsCountEl.textContent = `${Number(data.friendsCount).toLocaleString('id-ID')} Teman`;
                }

                // 2. Update Likes Count & Heart Animation
                const likesCountEl = document.getElementById('header-profile-likes-count');
                const likesIconEl = document.getElementById('header-profile-likes-icon');
                if (likesCountEl && data.profileLikesCount !== undefined) {
                    const currentLikes = Number(data.profileLikesCount);
                    likesCountEl.textContent = `${currentLikes.toLocaleString('id-ID')} Suka`;

                    if (previousLikes !== null && currentLikes > previousLikes) {
                        if (likesIconEl) {
                            likesIconEl.classList.remove('heart-pulsing');
                            void likesIconEl.offsetWidth; // Trigger reflow
                            likesIconEl.classList.add('heart-pulsing');
                        }
                    }
                    previousLikes = currentLikes;
                }
            })
            .catch(() => {});
        }

        // Initial poll after 5s, then every 8s
        setTimeout(fetchProfileStats, 5000);
        setInterval(fetchProfileStats, 8000);
    }

    initRealtimeProfileStats();

    // =========================================================================
    // 7. Two-Factor Authentication (2FA TOTP) Management
    // =========================================================================
    function initTwoFactorAuth() {
        const config = window.ProfilPenggunaConfig || {};
        const routes = config.routes || {};
        const csrfToken = config.csrfToken;

        let latestRecoveryCodes = [];

        // --- A. Setup 2FA ---
        const btnStartSetup = document.getElementById('btn-start-setup-2fa');
        const setupModalEl = document.getElementById('modal-setup-2fa');
        const qrContainer = document.getElementById('setup-2fa-qr-container');
        const secretKeyInput = document.getElementById('setup-2fa-secret-key');
        const btnCopySecretKey = document.getElementById('btn-copy-secret-key');
        const confirmCodeInput = document.getElementById('setup-2fa-confirm-code');
        const btnSubmitConfirm = document.getElementById('btn-submit-confirm-2fa');
        const setupErrorAlert = document.getElementById('setup-2fa-error-alert');

        const stepVerify = document.getElementById('setup-2fa-step-verify');
        const stepRecovery = document.getElementById('setup-2fa-step-recovery');
        const recoveryCodesList = document.getElementById('setup-2fa-recovery-codes-list');
        const btnDoneSetup = document.getElementById('btn-done-setup-2fa');
        const btnCancelSetup = document.getElementById('btn-cancel-setup-2fa');

        if (btnStartSetup && setupModalEl) {
            const setupModal = bootstrap.Modal.getOrCreateInstance(setupModalEl);

            btnStartSetup.addEventListener('click', function() {
                // Reset UI to step 1
                stepVerify.classList.remove('d-none');
                stepRecovery.classList.add('d-none');
                btnSubmitConfirm.classList.remove('d-none');
                btnCancelSetup.classList.remove('d-none');
                btnDoneSetup.classList.add('d-none');
                if (confirmCodeInput) confirmCodeInput.value = '';
                if (setupErrorAlert) {
                    setupErrorAlert.classList.add('d-none');
                    setupErrorAlert.innerText = '';
                }
                if (qrContainer) {
                    qrContainer.innerHTML = '<div class="spinner-border text-primary my-4" role="status"></div>';
                }

                setupModal.show();

                // Fetch SVG QR Code and Secret Key
                fetch(routes.twoFactorEnable, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (qrContainer) qrContainer.innerHTML = data.svg;
                        if (secretKeyInput) secretKeyInput.value = data.secret;
                    } else {
                        if (setupErrorAlert) {
                            setupErrorAlert.classList.remove('d-none');
                            setupErrorAlert.innerText = data.message || 'Gagal membuat QR Code 2FA.';
                        }
                    }
                })
                .catch(() => {
                    if (setupErrorAlert) {
                        setupErrorAlert.classList.remove('d-none');
                        setupErrorAlert.innerText = 'Terjadi kesalahan koneksi saat menyiapkan 2FA.';
                    }
                });
            });
        }

        // Copy Secret Key Button
        if (btnCopySecretKey && secretKeyInput) {
            btnCopySecretKey.addEventListener('click', function() {
                const key = secretKeyInput.value.replace(/\s+/g, '');
                navigator.clipboard.writeText(key).then(() => {
                    if (window.showToast) window.showToast('Kunci rahasia 2FA berhasil disalin!', 'success');
                });
            });
        }

        // Confirm 2FA Code Button
        if (btnSubmitConfirm && confirmCodeInput) {
            btnSubmitConfirm.addEventListener('click', function() {
                const code = confirmCodeInput.value.trim();
                if (!code || code.length !== 6) {
                    if (setupErrorAlert) {
                        setupErrorAlert.classList.remove('d-none');
                        setupErrorAlert.innerText = 'Masukkan 6-digit kode verifikasi dari aplikasi Authenticator.';
                    }
                    confirmCodeInput.focus();
                    return;
                }

                btnSubmitConfirm.disabled = true;
                btnSubmitConfirm.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengonfirmasi...';
                if (setupErrorAlert) setupErrorAlert.classList.add('d-none');

                fetch(routes.twoFactorConfirm, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(res => res.json())
                .then(data => {
                    btnSubmitConfirm.disabled = false;
                    btnSubmitConfirm.innerHTML = '<i class="ti ti-check me-1.5"></i> Konfirmasi & Aktifkan';

                    if (data.success) {
                        latestRecoveryCodes = data.recovery_codes || [];

                        // Populate recovery codes
                        if (recoveryCodesList) {
                            recoveryCodesList.innerHTML = latestRecoveryCodes.map(c => `
                                <div class="recovery-code-item">${c}</div>
                            `).join('');
                        }

                        // Switch to Step 3 (Success)
                        stepVerify.classList.add('d-none');
                        stepRecovery.classList.remove('d-none');
                        btnSubmitConfirm.classList.add('d-none');
                        btnCancelSetup.classList.add('d-none');
                        btnDoneSetup.classList.remove('d-none');
                    } else {
                        if (setupErrorAlert) {
                            setupErrorAlert.classList.remove('d-none');
                            setupErrorAlert.innerText = data.message || 'Kode verifikasi salah.';
                        }
                    }
                })
                .catch(() => {
                    btnSubmitConfirm.disabled = false;
                    btnSubmitConfirm.innerHTML = '<i class="ti ti-check me-1.5"></i> Konfirmasi & Aktifkan';
                    if (setupErrorAlert) {
                        setupErrorAlert.classList.remove('d-none');
                        setupErrorAlert.innerText = 'Terjadi kesalahan saat memverifikasi kode 2FA.';
                    }
                });
            });

            // Reload page on setup modal done to update UI status
            if (btnDoneSetup) {
                btnDoneSetup.addEventListener('click', function() {
                    window.location.reload();
                });
            }
        }

        // Copy / Download Recovery Codes from Setup Modal
        const btnCopyRecoveryCodes = document.getElementById('btn-copy-recovery-codes');
        const btnDownloadRecoveryCodes = document.getElementById('btn-download-recovery-codes');

        if (btnCopyRecoveryCodes) {
            btnCopyRecoveryCodes.addEventListener('click', function() {
                if (latestRecoveryCodes.length === 0) return;
                const text = latestRecoveryCodes.join('\n');
                navigator.clipboard.writeText(text).then(() => {
                    if (window.showToast) window.showToast('8 Kode pemulihan cadangan berhasil disalin!', 'success');
                });
            });
        }

        if (btnDownloadRecoveryCodes) {
            btnDownloadRecoveryCodes.addEventListener('click', function() {
                if (latestRecoveryCodes.length === 0) return;
                downloadRecoveryFile(latestRecoveryCodes);
            });
        }

        // --- B. View / Regenerate Recovery Codes Modal ---
        const btnViewRecovery = document.getElementById('btn-view-recovery-codes');
        const modalRecoveryEl = document.getElementById('modal-recovery-codes-2fa');
        const activeRecoveryList = document.getElementById('active-recovery-codes-list');

        if (btnViewRecovery && modalRecoveryEl) {
            const modalRecovery = bootstrap.Modal.getOrCreateInstance(modalRecoveryEl);

            btnViewRecovery.addEventListener('click', function() {
                modalRecovery.show();
                if (activeRecoveryList) {
                    activeRecoveryList.innerHTML = '<div class="text-center py-3 text-muted w-100"><span class="spinner-border spinner-border-sm me-1"></span> Memuat kode pemulihan...</div>';
                }

                fetch(routes.twoFactorRecoveryCodes, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && Array.isArray(data.recovery_codes)) {
                        latestRecoveryCodes = data.recovery_codes;
                        if (activeRecoveryList) {
                            if (latestRecoveryCodes.length > 0) {
                                activeRecoveryList.innerHTML = latestRecoveryCodes.map(c => `
                                    <div class="recovery-code-item">${c}</div>
                                `).join('');
                            } else {
                                activeRecoveryList.innerHTML = '<div class="text-center py-2 text-danger w-100">Semua kode pemulihan telah terpakai. Silakan buat ulang di bawah ini.</div>';
                            }
                        }
                    }
                })
                .catch(() => {
                    if (activeRecoveryList) {
                        activeRecoveryList.innerHTML = '<div class="text-center py-2 text-danger w-100">Gagal memuat kode pemulihan.</div>';
                    }
                });
            });
        }

        // Copy & Download Existing Recovery Codes
        const btnCopyExistingRecovery = document.getElementById('btn-copy-existing-recovery');
        const btnDownloadExistingRecovery = document.getElementById('btn-download-existing-recovery');

        if (btnCopyExistingRecovery) {
            btnCopyExistingRecovery.addEventListener('click', function() {
                if (latestRecoveryCodes.length === 0) return;
                navigator.clipboard.writeText(latestRecoveryCodes.join('\n')).then(() => {
                    if (window.showToast) window.showToast('Kode pemulihan cadangan berhasil disalin!', 'success');
                });
            });
        }

        if (btnDownloadExistingRecovery) {
            btnDownloadExistingRecovery.addEventListener('click', function() {
                if (latestRecoveryCodes.length === 0) return;
                downloadRecoveryFile(latestRecoveryCodes);
            });
        }

        // Regenerate Recovery Codes Submit
        const btnSubmitRegenerate = document.getElementById('btn-submit-regenerate-2fa');
        const inputRegeneratePassword = document.getElementById('regenerate-2fa-password');
        const regenerateErrorAlert = document.getElementById('regenerate-2fa-error-alert');

        if (btnSubmitRegenerate && inputRegeneratePassword) {
            btnSubmitRegenerate.addEventListener('click', function() {
                const password = inputRegeneratePassword.value.trim();
                if (!password) {
                    if (regenerateErrorAlert) {
                        regenerateErrorAlert.classList.remove('d-none');
                        regenerateErrorAlert.innerText = 'Masukkan kata sandi akun untuk konfirmasi.';
                    }
                    inputRegeneratePassword.focus();
                    return;
                }

                btnSubmitRegenerate.disabled = true;
                if (regenerateErrorAlert) regenerateErrorAlert.classList.add('d-none');

                fetch(routes.twoFactorRegenerateRecoveryCodes, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ password: password })
                })
                .then(res => res.json())
                .then(data => {
                    btnSubmitRegenerate.disabled = false;
                    if (data.success && Array.isArray(data.recovery_codes)) {
                        latestRecoveryCodes = data.recovery_codes;
                        inputRegeneratePassword.value = '';
                        if (activeRecoveryList) {
                            activeRecoveryList.innerHTML = latestRecoveryCodes.map(c => `
                                <div class="recovery-code-item">${c}</div>
                            `).join('');
                        }
                        if (window.showToast) window.showToast('8 Kode pemulihan baru berhasil dibuat!', 'success');
                    } else {
                        if (regenerateErrorAlert) {
                            regenerateErrorAlert.classList.remove('d-none');
                            regenerateErrorAlert.innerText = data.message || 'Kata sandi salah.';
                        }
                    }
                })
                .catch(() => {
                    btnSubmitRegenerate.disabled = false;
                    if (regenerateErrorAlert) {
                        regenerateErrorAlert.classList.remove('d-none');
                        regenerateErrorAlert.innerText = 'Terjadi kesalahan saat membuat ulang kode.';
                    }
                });
            });
        }

        // --- C. Disable 2FA ---
        const btnSubmitDisable = document.getElementById('btn-submit-disable-2fa');
        const inputDisablePassword = document.getElementById('disable-2fa-password');
        const disableErrorAlert = document.getElementById('disable-2fa-error-alert');

        if (btnSubmitDisable && inputDisablePassword) {
            btnSubmitDisable.addEventListener('click', function() {
                const password = inputDisablePassword.value.trim();
                if (!password) {
                    if (disableErrorAlert) {
                        disableErrorAlert.classList.remove('d-none');
                        disableErrorAlert.innerText = 'Masukkan kata sandi Anda untuk konfirmasi.';
                    }
                    inputDisablePassword.focus();
                    return;
                }

                btnSubmitDisable.disabled = true;
                btnSubmitDisable.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menonaktifkan...';
                if (disableErrorAlert) disableErrorAlert.classList.add('d-none');

                fetch(routes.twoFactorDisable, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ password: password })
                })
                .then(res => res.json())
                .then(data => {
                    btnSubmitDisable.disabled = false;
                    btnSubmitDisable.innerHTML = '<i class="ti ti-shield-off me-1.5"></i> Nonaktifkan 2FA';

                    if (data.success) {
                        if (window.showSuccess) {
                            window.showSuccess('Two-Factor Authentication berhasil dinonaktifkan.', { reload: true });
                        } else {
                            window.location.reload();
                        }
                    } else {
                        if (disableErrorAlert) {
                            disableErrorAlert.classList.remove('d-none');
                            disableErrorAlert.innerText = data.message || 'Kata sandi salah.';
                        }
                    }
                })
                .catch(() => {
                    btnSubmitDisable.disabled = false;
                    btnSubmitDisable.innerHTML = '<i class="ti ti-shield-off me-1.5"></i> Nonaktifkan 2FA';
                    if (disableErrorAlert) {
                        disableErrorAlert.classList.remove('d-none');
                        disableErrorAlert.innerText = 'Terjadi kesalahan saat menonaktifkan 2FA.';
                    }
                });
            });
        }

        // Helper: Download text file
        function downloadRecoveryFile(codes) {
            const content = `REPALOGIC DASHBOARD - TWO-FACTOR AUTHENTICATION RECOVERY CODES\n` +
                            `Akun: ${window.ProfilPenggunaConfig?.userEmail || 'Pengguna'}\n` +
                            `Tanggal: ${new Date().toLocaleString('id-ID')}\n\n` +
                            `PERINGATAN: Simpan kode ini di tempat yang aman. Setiap kode hanya dapat digunakan 1 kali.\n\n` +
                            codes.map((c, i) => `${i + 1}. ${c}`).join('\n') + `\n`;

            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `repalogic-2fa-recovery-codes-${new Date().toISOString().slice(0, 10)}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            if (window.showToast) window.showToast('File kode pemulihan berhasil diunduh!', 'success');
        }
    }

    // =========================================================================
    // 6. Self-Service Settings Tabs & Interactive Helpers (Rule 17, 18 & 22)
    // =========================================================================
    function initSelfServiceSettings() {
        // Tab persistence via localStorage (Rule 17: hashtag-free)
        const profileTabButtons = document.querySelectorAll('#profileTabs button[data-bs-toggle="tab"]');
        const activeTabKey = 'repalogic_active_profile_tab';

        if (profileTabButtons.length > 0) {
            const savedTab = localStorage.getItem(activeTabKey);
            if (savedTab) {
                const targetBtn = document.querySelector(`#profileTabs button[data-bs-target="${savedTab}"]`);
                if (targetBtn) {
                    const tabInstance = bootstrap.Tab.getOrCreateInstance(targetBtn);
                    tabInstance.show();
                }
            }

            profileTabButtons.forEach(btn => {
                btn.addEventListener('shown.bs.tab', function(e) {
                    const target = e.target.getAttribute('data-bs-target');
                    if (target) {
                        localStorage.setItem(activeTabKey, target);
                    }
                });
            });
        }

        // Test Chat Sound Alert Helper (Synthesizer audio tone using Web Audio API)
        function playChatAlertTone(soundType) {
            if (!soundType || soundType === 'mute') {
                if (window.showToast) window.showToast('Mode hening aktif (tidak ada suara).', 'info');
                return;
            }

            try {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextClass) {
                    if (window.showWarning) window.showWarning('Browser tidak mendukung Web Audio API.', 'Audio Error');
                    return;
                }

                const ctx = new AudioContextClass();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }

                const now = ctx.currentTime;

                if (soundType === 'pop') {
                    // Bubble Pop
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(400, now);
                    osc.frequency.exponentialRampToValueAtTime(1000, now + 0.06);
                    osc.frequency.exponentialRampToValueAtTime(250, now + 0.14);
                    
                    gain.gain.setValueAtTime(0.7, now);
                    gain.gain.linearRampToValueAtTime(0.01, now + 0.14);
                    gain.gain.linearRampToValueAtTime(0, now + 0.15);

                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(now);
                    osc.stop(now + 0.16);
                } else if (soundType === 'ding') {
                    // Soft Bell Ding
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(1200, now);
                    osc.frequency.exponentialRampToValueAtTime(850, now + 0.5);

                    gain.gain.setValueAtTime(0.75, now);
                    gain.gain.linearRampToValueAtTime(0.01, now + 0.5);
                    gain.gain.linearRampToValueAtTime(0, now + 0.52);

                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(now);
                    osc.stop(now + 0.53);
                } else {
                    // Default Chime (3-tone ascending arpeggio C5, E5, G5)
                    const notes = [523.25, 659.25, 783.99];
                    notes.forEach((freq, idx) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        const startT = now + (idx * 0.11);
                        const dur = 0.4;

                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, startT);

                        gain.gain.setValueAtTime(0.6, startT);
                        gain.gain.linearRampToValueAtTime(0.01, startT + dur);
                        gain.gain.linearRampToValueAtTime(0, startT + dur + 0.02);

                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start(startT);
                        osc.stop(startT + dur + 0.03);
                    });
                }

                if (window.showToast) {
                    const chatSoundSelect = document.getElementById('chat_sound_alert_select');
                    const selectedLabel = chatSoundSelect?.options[chatSoundSelect.selectedIndex]?.text || 'Suara Notifikasi';
                    window.showToast('Memutar contoh nada: ' + selectedLabel, 'success', 2000);
                }
            } catch (err) {
                console.warn('Audio playback error', err);
            }
        }

        // Event Delegation for Test Chat Sound (Rule 2 Compliance)
        document.addEventListener('click', function(e) {
            const testSoundBtn = e.target.closest('#btn-test-chat-sound');
            if (testSoundBtn) {
                e.preventDefault();
                const chatSoundSelect = document.getElementById('chat_sound_alert_select');
                const soundType = chatSoundSelect ? chatSoundSelect.value : 'pop';
                playChatAlertTone(soundType);
            }
        });

        // Test Web Push Browser Notification Helper
        const btnTestBrowserPush = document.getElementById('btn-test-browser-push');
        const switchBrowserPush = document.getElementById('notifications_browser_push');

        if (btnTestBrowserPush) {
            btnTestBrowserPush.addEventListener('click', function() {
                if (!('Notification' in window)) {
                    if (window.showWarning) window.showWarning('Browser ini tidak mendukung notifikasi desktop.', 'Pemberitahuan');
                    return;
                }

                if (Notification.permission === 'granted') {
                    new Notification('REPALOGIC Dashboard', {
                        body: 'Ini adalah contoh notifikasi desktop browser yang berhasil diaktifkan!',
                        icon: window.ProfilPenggunaConfig?.avatarCurrentUrl || '/favicon.ico'
                    });
                    if (window.showToast) window.showToast('Notifikasi desktop browser berhasil ditampilkan!', 'success');
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            new Notification('REPALOGIC Dashboard', {
                                body: 'Izin notifikasi desktop berhasil diberikan!',
                                icon: window.ProfilPenggunaConfig?.avatarCurrentUrl || '/favicon.ico'
                            });
                            if (switchBrowserPush) switchBrowserPush.checked = true;
                            if (window.showSuccess) window.showSuccess('Izin notifikasi desktop browser berhasil diaktifkan.', 'Berhasil!');
                        } else {
                            if (window.showWarning) window.showWarning('Izin notifikasi browser belum diberikan.', 'Pemberitahuan');
                        }
                    });
                } else {
                    if (window.showWarning) window.showWarning('Notifikasi browser diblokir. Harap aktifkan izin di pengaturan browser Anda.', 'Izin Ditolak');
                }
            });
        }
    }

    initTwoFactorAuth();
    initSelfServiceSettings();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProfilPengguna);
} else {
    initProfilPengguna();
}
