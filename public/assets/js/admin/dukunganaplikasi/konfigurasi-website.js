/**
 * Dukungan Aplikasi - Konfigurasi Website Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/konfigurasi-website.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.KonfigurasiWebsiteConfig || {};
    const routes = config.routes || {};
    function getCsrfToken() {
        if (typeof window.getCsrfToken === 'function') {
            return window.getCsrfToken();
        }
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken || '';
    }

    let currentPreviewSectionId = null;

    // SortableJS Drag & Drop Reordering for Website Sections
    const sortableList = document.getElementById('sortable-sections-list');
    if (sortableList && typeof Sortable !== 'undefined') {
        Sortable.create(sortableList, {
            handle: '.drag-handle-section',
            draggable: '.section-row',
            animation: 200,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function() {
                const orderedIds = [];
                sortableList.querySelectorAll('.section-row').forEach((row, index) => {
                    const id = row.getAttribute('data-id');
                    if (id) orderedIds.push(id);

                    const badge = row.querySelector('.order-badge');
                    if (badge) badge.textContent = index + 1;

                    const input = row.querySelector('.order-input');
                    if (input) input.value = index + 1;
                });

                fetch(routes.reorderSections || '/admin/dukunganaplikasi/konfigurasi-website/reorder-sections', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        orders: orderedIds
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (typeof window.showToast === 'function') {
                        window.showToast(data.message || 'Urutan seksi halaman berhasil diperbarui.');
                    }
                })
                .catch(err => {
                    console.error('Error reordering sections:', err);
                    if (typeof window.showError === 'function') {
                        window.showError('Terjadi kesalahan saat menyimpan urutan seksi.');
                    }
                });
            }
        });
    }

    // Toggle Background Image Container Helper
    function toggleBgContainer(selectEl) {
        if (!selectEl) return;
        const containerId = selectEl.getAttribute('data-container-id');
        const bgContainer = document.getElementById(containerId);
        if (bgContainer) {
            if (selectEl.value === 'image') {
                bgContainer.classList.remove('d-none');
            } else {
                bgContainer.classList.add('d-none');
            }
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select-bg-type')) {
            toggleBgContainer(e.target);
        }

        // Live Preview saat memilih file gambar baru di Modal Tambah Seksi
        if (e.target.id === 'add_bg_image_file') {
            const file = e.target.files[0];
            const previewBox = document.getElementById('add_bg_image_preview_box');
            const previewImg = document.getElementById('add_bg_image_preview');
            if (file && previewBox && previewImg) {
                previewImg.src = URL.createObjectURL(file);
                previewBox.classList.remove('d-none');
            }
        }

        // Live Preview saat memilih file gambar baru di Modal Edit Seksi
        if (e.target.id === 'edit_bg_image_file') {
            const file = e.target.files[0];
            const previewBox = document.getElementById('edit_bg_image_preview_box');
            const previewImg = document.getElementById('edit_bg_image_preview');
            const previewLabel = document.getElementById('edit_bg_preview_label');
            if (file && previewBox && previewImg) {
                previewImg.src = URL.createObjectURL(file);
                if (previewLabel) previewLabel.textContent = 'Pratinjau Gambar Baru Terpilih:';
                previewBox.classList.remove('d-none');
            }
        }
    });

    // Real-time Background Position Slider & Preset Helper for Add/Edit Modals
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('bg-pos-range')) {
            const pos = e.target.value;
            const valBadgeId = e.target.getAttribute('data-val-id');
            const previewImgId = e.target.getAttribute('data-preview-id');

            if (valBadgeId) {
                const valBadge = document.getElementById(valBadgeId);
                if (valBadge) valBadge.textContent = pos + '%';
            }
            if (previewImgId) {
                const previewImg = document.getElementById(previewImgId);
                if (previewImg) previewImg.style.objectPosition = 'center ' + pos + '%';
            }
        }
    });

    // Modal Preview Slider Live Update Listener
    const modalPreviewRange = document.getElementById('modal_preview_bg_pos_range');
    if (modalPreviewRange) {
        modalPreviewRange.addEventListener('input', function(e) {
            const pos = e.target.value;
            const valBadge = document.getElementById('modal_preview_bg_pos_val');
            const targetImg = document.getElementById('modal-preview-img-target');
            if (valBadge) valBadge.textContent = pos + '%';
            if (targetImg) targetImg.style.objectPosition = 'center ' + pos + '%';
        });
    }

    // Event Delegation for Action Buttons (Rule 2 & Rule 7 Compliance)
    document.addEventListener('click', function(e) {
        const btnSimHeight = e.target.closest('.btn-sim-height');
        if (btnSimHeight) {
            document.querySelectorAll('.btn-sim-height').forEach(b => {
                b.classList.remove('active', 'btn-primary', 'fw-bold');
                b.classList.add('btn-outline-light', 'text-white', 'fw-semibold');
            });
            btnSimHeight.classList.remove('btn-outline-light');
            btnSimHeight.classList.add('active', 'btn-primary', 'text-white', 'fw-bold');
            const h = btnSimHeight.getAttribute('data-height');
            const simContainer = document.getElementById('sim-preview-container');
            if (simContainer) simContainer.style.height = h;
        }

        const presetBtn = e.target.closest('.btn-preset-bg-pos');
        if (presetBtn) {
            const rangeId = presetBtn.getAttribute('data-range-id');
            const pos = presetBtn.getAttribute('data-pos');
            const rangeInput = document.getElementById(rangeId);
            if (rangeInput) {
                rangeInput.value = pos;
                rangeInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        const presetModalBtn = e.target.closest('.btn-preset-modal-pos');
        if (presetModalBtn) {
            const pos = presetModalBtn.getAttribute('data-pos');
            if (modalPreviewRange) {
                modalPreviewRange.value = pos;
                modalPreviewRange.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }

        // 1. Modal Tambah Tema
        const btnTambahTema = e.target.closest('.btn-tambah-tema');
        if (btnTambahTema) {
            const formTheme = document.getElementById('form-theme');
            if (formTheme) formTheme.reset();
            const themeIdInput = document.getElementById('theme_id');
            if (themeIdInput) themeIdInput.value = '';
            const titleEl = document.getElementById('modal-tema-title');
            if (titleEl) titleEl.textContent = 'Tambah Tema Website Baru';
            const modalThemeEl = document.getElementById('modal-tambah-tema');
            if (modalThemeEl) {
                const modalTheme = new bootstrap.Modal(modalThemeEl);
                modalTheme.show();
            }
        }

        // 2. Modal Edit Tema
        const btnEditTema = e.target.closest('.btn-edit-tema');
        if (btnEditTema) {
            const themeIdInput = document.getElementById('theme_id');
            if (themeIdInput) themeIdInput.value = btnEditTema.getAttribute('data-theme-id') || '';
            const themeNameInput = document.getElementById('theme_name');
            if (themeNameInput) themeNameInput.value = btnEditTema.getAttribute('data-theme-name') || '';
            const themeFolderInput = document.getElementById('theme_folder');
            if (themeFolderInput) themeFolderInput.value = btnEditTema.getAttribute('data-theme-folder') || '';
            const themeDescInput = document.getElementById('theme_description');
            if (themeDescInput) themeDescInput.value = btnEditTema.getAttribute('data-theme-description') || '';
            const titleEl = document.getElementById('modal-tema-title');
            if (titleEl) titleEl.textContent = 'Edit Identitas Tema';
            const modalThemeEl = document.getElementById('modal-tambah-tema');
            if (modalThemeEl) {
                const modalTheme = new bootstrap.Modal(modalThemeEl);
                modalTheme.show();
            }
        }

        // 3. Modal Tambah Seksi
        const btnTambahSeksi = e.target.closest('.btn-tambah-seksi');
        if (btnTambahSeksi) {
            const selectBg = document.getElementById('add_bg_type');
            if (selectBg) {
                selectBg.value = 'default';
                toggleBgContainer(selectBg);
            }
            const addFileInput = document.getElementById('add_bg_image_file');
            const addPreviewBox = document.getElementById('add_bg_image_preview_box');
            if (addFileInput) addFileInput.value = '';
            if (addPreviewBox) addPreviewBox.classList.add('d-none');

            const modalSeksiEl = document.getElementById('modal-tambah-seksi');
            if (modalSeksiEl) {
                const modalSeksi = new bootstrap.Modal(modalSeksiEl);
                modalSeksi.show();
            }
        }

        // 4. Modal Panduan Seksi
        const btnPanduanSeksi = e.target.closest('.btn-panduan-seksi');
        if (btnPanduanSeksi) {
            const modalPanduanEl = document.getElementById('modal-panduan-seksi');
            if (modalPanduanEl) {
                const modalPanduan = new bootstrap.Modal(modalPanduanEl);
                modalPanduan.show();
            }
        }

        // 5. Salin Template Kode Seksi
        const btnCopy = e.target.closest('.btn-copy-template');
        if (btnCopy) {
            const textarea = document.getElementById('raw-code-input');
            if (textarea) {
                textarea.classList.remove('d-none');
                textarea.focus();
                textarea.select();
                textarea.setSelectionRange(0, 99999);

                let copySuccess = false;
                try {
                    copySuccess = document.execCommand('copy');
                } catch (err) {
                    copySuccess = false;
                }

                textarea.classList.add('d-none');

                function showFeedback() {
                    const originalHtml = btnCopy.innerHTML;
                    btnCopy.innerHTML = '<i class="ti ti-check me-1"></i> Tersalin!';
                    btnCopy.classList.remove('btn-outline-primary');
                    btnCopy.classList.add('btn-success');
                    setTimeout(function() {
                        btnCopy.innerHTML = originalHtml;
                        btnCopy.classList.remove('btn-success');
                        btnCopy.classList.add('btn-outline-primary');
                    }, 2000);
                }

                if (copySuccess) {
                    showFeedback();
                } else if (navigator.clipboard) {
                    navigator.clipboard.writeText(textarea.value).then(showFeedback).catch(function() {
                        if (typeof window.showWarning === 'function') {
                            window.showWarning('Salin manual: Ctrl+C pada teks.');
                        } else {
                            alert('Salin manual: Ctrl+C pada teks.');
                        }
                    });
                }
            }
        }

        // 6. Modal Edit Seksi
        const btnEditSeksi = e.target.closest('.btn-edit-seksi');
        if (btnEditSeksi) {
            const id = btnEditSeksi.getAttribute('data-section-id');
            const formEdit = document.getElementById('form-edit-seksi');
            const updateUrl = `${routes.updateSection || '/admin/dukunganaplikasi/konfigurasi-website/update-section'}/${id}`;
            if (formEdit) formEdit.action = updateUrl;

            const nameInput = document.getElementById('edit_section_name');
            if (nameInput) nameInput.value = btnEditSeksi.getAttribute('data-section-name') || '';
            const fileInput = document.getElementById('edit_section_file');
            if (fileInput) fileInput.value = btnEditSeksi.getAttribute('data-section-file') || '';
            const navTitleInput = document.getElementById('edit_nav_title');
            if (navTitleInput) navTitleInput.value = btnEditSeksi.getAttribute('data-nav-title') || '';
            const targetIdInput = document.getElementById('edit_target_id');
            if (targetIdInput) targetIdInput.value = btnEditSeksi.getAttribute('data-target-id') || '';
            const ordersInput = document.getElementById('edit_orders');
            if (ordersInput) ordersInput.value = btnEditSeksi.getAttribute('data-orders') || '0';

            const selectEditBg = document.getElementById('edit_bg_type');
            if (selectEditBg) {
                selectEditBg.value = btnEditSeksi.getAttribute('data-bg-type') || 'default';
                toggleBgContainer(selectEditBg);
            }

            const bgImageUrl = btnEditSeksi.getAttribute('data-bg-image');
            const previewBox = document.getElementById('edit_bg_image_preview_box');
            const previewImg = document.getElementById('edit_bg_image_preview');
            const previewLabel = document.getElementById('edit_bg_preview_label');
            const editFileInput = document.getElementById('edit_bg_image_file');

            if (editFileInput) editFileInput.value = '';
            if (previewLabel) previewLabel.textContent = 'Gambar Background Aktif Saat Ini:';

            if (bgImageUrl && previewBox && previewImg) {
                previewImg.src = bgImageUrl;
                previewBox.classList.remove('d-none');
            } else if (previewBox) {
                previewBox.classList.add('d-none');
            }
            
            const activeCheckbox = document.getElementById('edit_is_active');
            if (activeCheckbox) activeCheckbox.checked = btnEditSeksi.getAttribute('data-is-active') === '1';
            const showInNavCheckbox = document.getElementById('edit_show_in_nav');
            if (showInNavCheckbox) showInNavCheckbox.checked = btnEditSeksi.getAttribute('data-show-in-nav') === '1';

            const modalEditEl = document.getElementById('modal-edit-seksi');
            if (modalEditEl) {
                const modalEdit = new bootstrap.Modal(modalEditEl);
                modalEdit.show();
            }
        }

        // 7. Modal Preview Full Image & Interactive Crop Position
        const btnPreviewFullImg = e.target.closest('.btn-preview-full-img');
        if (btnPreviewFullImg) {
            currentPreviewSectionId = btnPreviewFullImg.getAttribute('data-section-id');
            const imgUrl = btnPreviewFullImg.getAttribute('data-img-url');
            const secName = btnPreviewFullImg.getAttribute('data-section-name');
            const posY = btnPreviewFullImg.getAttribute('data-pos-y') || '50';
            const bgSize = btnPreviewFullImg.getAttribute('data-bg-size') || 'cover';
            const bgAttach = btnPreviewFullImg.getAttribute('data-bg-attachment') || 'scroll';
            const imgW = btnPreviewFullImg.getAttribute('data-img-w');
            const imgH = btnPreviewFullImg.getAttribute('data-img-h');
            const imgOrient = btnPreviewFullImg.getAttribute('data-img-orient') || 'landscape';

            const targetImg = document.getElementById('modal-preview-img-target');
            const targetTitle = document.getElementById('preview-image-title');
            const valBadge = document.getElementById('modal_preview_bg_pos_val');
            const orientBadge = document.getElementById('preview-image-orient-badge');
            const portraitAlert = document.getElementById('preview-portrait-alert');
            const sizeSelect = document.getElementById('modal_preview_bg_size');
            const attachSelect = document.getElementById('modal_preview_bg_attachment');

            if (targetImg) {
                targetImg.src = imgUrl;
                targetImg.style.objectPosition = 'center ' + posY + '%';
                targetImg.style.objectFit = bgSize;
            }
            if (targetTitle) targetTitle.textContent = secName;
            if (modalPreviewRange) modalPreviewRange.value = posY;
            if (valBadge) valBadge.textContent = posY + '%';
            if (sizeSelect) sizeSelect.value = bgSize;
            if (attachSelect) attachSelect.value = bgAttach;

            if (orientBadge) {
                const icon = imgOrient === 'portrait' ? '📱' : (imgOrient === 'landscape' ? '🖼️' : '⏹️');
                const dimText = imgW && imgH ? ` (${imgW}x${imgH}px)` : '';
                orientBadge.textContent = `${icon} ${imgOrient.toUpperCase()}${dimText}`;
            }

            if (portraitAlert) {
                if (imgOrient === 'portrait') {
                    portraitAlert.classList.remove('d-none');
                } else {
                    portraitAlert.classList.add('d-none');
                }
            }

            const modalPreviewEl = document.getElementById('modal-preview-image');
            if (modalPreviewEl) {
                const modalPreview = new bootstrap.Modal(modalPreviewEl);
                modalPreview.show();
            }
        }

        // 8. Save Position & Background Options Button inside Preview Modal (AJAX Update)
        const btnSavePreviewPos = e.target.closest('#btn-save-preview-pos');
        if (btnSavePreviewPos && currentPreviewSectionId) {
            const newPos = modalPreviewRange ? modalPreviewRange.value : 50;
            const newSize = document.getElementById('modal_preview_bg_size')?.value || 'cover';
            const newAttach = document.getElementById('modal_preview_bg_attachment')?.value || 'scroll';

            const originalHtml = btnSavePreviewPos.innerHTML;
            btnSavePreviewPos.disabled = true;
            btnSavePreviewPos.innerHTML = '<i class="ti ti-spin ti-spinner me-1"></i> Menyimpan...';

            const updatePosUrl = `${routes.updateSectionPosition || '/admin/dukunganaplikasi/konfigurasi-website/update-section-position'}/${currentPreviewSectionId}`;
            fetch(updatePosUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    bg_position_y: newPos,
                    bg_size: newSize,
                    bg_attachment: newAttach
                })
            })
            .then(res => res.json())
            .then(data => {
                btnSavePreviewPos.disabled = false;
                btnSavePreviewPos.innerHTML = originalHtml;

                if (data.status === 'success') {
                    // Update table row trigger element attributes & DOM badges
                    const triggerBtn = document.querySelector(`.btn-preview-full-img[data-section-id="${currentPreviewSectionId}"]`);
                    if (triggerBtn) {
                        triggerBtn.setAttribute('data-pos-y', newPos);
                        triggerBtn.setAttribute('data-bg-size', newSize);
                        triggerBtn.setAttribute('data-bg-attachment', newAttach);

                        const thumbImg = triggerBtn.querySelector('img');
                        if (thumbImg) {
                            thumbImg.style.objectPosition = 'center ' + newPos + '%';
                            thumbImg.style.objectFit = newSize;
                        }

                        const editBtn = document.querySelector(`.btn-edit-seksi[data-section-id="${currentPreviewSectionId}"]`);
                        if (editBtn) editBtn.setAttribute('data-bg-position-y', newPos);

                        const parentTd = triggerBtn.closest('td');
                        if (parentTd) {
                            const posBadge = parentTd.querySelector('.badge.bg-primary-subtle');
                            if (posBadge) posBadge.textContent = 'Y: ' + newPos + '%';

                            let parallaxBadge = parentTd.querySelector('.badge.bg-warning-subtle');
                            if (newAttach === 'fixed') {
                                if (!parallaxBadge) {
                                    parallaxBadge = document.createElement('span');
                                    parallaxBadge.className = 'badge bg-warning-subtle text-warning fs-10 font-monospace py-0.5 px-1';
                                    parallaxBadge.title = 'Efek Paralaks Fixed';
                                    parallaxBadge.textContent = '✨ Paralaks';
                                    const badgeContainer = parentTd.querySelector('.d-flex');
                                    if (badgeContainer) badgeContainer.appendChild(parallaxBadge);
                                }
                            } else if (parallaxBadge) {
                                parallaxBadge.remove();
                            }
                        }
                    }

                    // Close Modal
                    const modalEl = document.getElementById('modal-preview-image');
                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                    if (bsModal) bsModal.hide();

                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || 'Posisi background berhasil disimpan!');
                    } else if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Disimpan!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || 'Gagal menyimpan posisi.');
                    } else {
                        alert(data.message || 'Gagal menyimpan posisi.');
                    }
                }
            })
            .catch(err => {
                btnSavePreviewPos.disabled = false;
                btnSavePreviewPos.innerHTML = originalHtml;
                if (typeof window.showError === 'function') {
                    window.showError('Terjadi kesalahan jaringan.');
                } else {
                    alert('Terjadi kesalahan jaringan.');
                }
            });
        }
    });
});
