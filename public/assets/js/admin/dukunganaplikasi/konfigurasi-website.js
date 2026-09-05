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

        // ==========================================================================
        // 9. Modal GUI Script Blade Editor
        // ==========================================================================
        const btnEditorScriptBlade = e.target.closest('.btn-editor-script-blade');
        if (btnEditorScriptBlade) {
            const sectionId = btnEditorScriptBlade.getAttribute('data-section-id');
            const sectionName = btnEditorScriptBlade.getAttribute('data-section-name') || '';
            const sectionFile = btnEditorScriptBlade.getAttribute('data-section-file') || '';
            const themeFolder = btnEditorScriptBlade.getAttribute('data-theme-folder') || 'default';

            openBladeScriptEditor(sectionId, sectionName, sectionFile, themeFolder);
        }

        // 10. Snippet Inserter in Script Editor
        const btnSnippet = e.target.closest('.btn-insert-snippet');
        if (btnSnippet) {
            const snippetKey = btnSnippet.getAttribute('data-snippet');
            insertBladeSnippet(snippetKey);
        }

        // 11. Toggle Fullscreen Mode
        const btnFullscreen = e.target.closest('#btn-editor-fullscreen');
        if (btnFullscreen) {
            toggleEditorFullscreen();
        }

        // 12. Toggle Word Wrap
        const btnToggleWrap = e.target.closest('#btn-toggle-wrap');
        if (btnToggleWrap) {
            toggleEditorWordWrap(btnToggleWrap);
        }

        // 13. Toggle Theme (Dark / Light)
        const btnToggleTheme = e.target.closest('#btn-toggle-theme');
        if (btnToggleTheme) {
            toggleEditorTheme(btnToggleTheme);
        }

        // 14. Copy Code
        const btnCopyScript = e.target.closest('#btn-copy-script-code');
        if (btnCopyScript) {
            copyBladeScriptCode(btnCopyScript);
        }

        // 15. Reset Code
        const btnResetScript = e.target.closest('#btn-reset-script-code');
        if (btnResetScript) {
            resetBladeScriptCode();
        }

        // 16. Save Blade Script Button
        const btnSaveScript = e.target.closest('#btn-save-blade-script');
        if (btnSaveScript) {
            saveBladeScript();
        }
    });

    // ==========================================================================
    // Script Blade Editor Logic & Helper Functions
    // ==========================================================================
    let currentScriptSectionId = null;
    let originalScriptContent = '';
    let aceEditor = null;
    let isEditorDarkMode = true;
    let isEditorWordWrap = true;

    function initAceEditorIfNeeded() {
        const aceContainer = document.getElementById('blade-script-ace-editor');
        const rawTextarea = document.getElementById('blade-script-raw-editor');

        if (!aceContainer) return;

        if (typeof ace !== 'undefined') {
            if (!aceEditor) {
                aceEditor = ace.edit('blade-script-ace-editor');
                aceEditor.setTheme('ace/theme/monokai');
                aceEditor.session.setMode('ace/mode/php');
                aceEditor.setShowPrintMargin(false);
                aceEditor.setFontSize(14);
                aceEditor.session.setUseWrapMode(true);
                aceEditor.session.setTabSize(4);
                aceEditor.session.setUseSoftTabs(true);

                // Cursor position change listener
                aceEditor.selection.on('changeCursor', function() {
                    const pos = aceEditor.getCursorPosition();
                    updateCursorDisplay(pos.row + 1, pos.column + 1);
                });

                // Content change listener
                aceEditor.on('change', function() {
                    checkDirtyStatus();
                    updateLinesCount();
                });

                // Keyboard command for Ctrl+S / Cmd+S
                aceEditor.commands.addCommand({
                    name: 'saveBladeScript',
                    bindKey: { win: 'Ctrl-S', mac: 'Command-S' },
                    exec: function() {
                        saveBladeScript();
                    }
                });
            }
            if (rawTextarea) rawTextarea.classList.add('d-none');
            aceContainer.classList.remove('d-none');
        } else {
            // Fallback to Raw Textarea
            if (rawTextarea) {
                rawTextarea.classList.remove('d-none');
                aceContainer.classList.add('d-none');

                rawTextarea.addEventListener('input', function() {
                    checkDirtyStatus();
                    updateLinesCount();
                });

                rawTextarea.addEventListener('keyup', function() {
                    const text = rawTextarea.value.substr(0, rawTextarea.selectionStart);
                    const lines = text.split('\n');
                    updateCursorDisplay(lines.length, lines[lines.length - 1].length + 1);
                });

                // Tab key handler for textarea
                rawTextarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Tab') {
                        e.preventDefault();
                        const start = this.selectionStart;
                        const end = this.selectionEnd;
                        this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                        this.selectionStart = this.selectionEnd = start + 4;
                        this.dispatchEvent(new Event('input'));
                    }
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                        e.preventDefault();
                        saveBladeScript();
                    }
                });
            }
        }
    }

    function getScriptEditorContent() {
        if (aceEditor) {
            return aceEditor.getValue();
        }
        const rawTextarea = document.getElementById('blade-script-raw-editor');
        return rawTextarea ? rawTextarea.value : '';
    }

    function setScriptEditorContent(content) {
        initAceEditorIfNeeded();
        if (aceEditor) {
            aceEditor.setValue(content, -1);
            aceEditor.clearSelection();
            aceEditor.focus();
        }
        const rawTextarea = document.getElementById('blade-script-raw-editor');
        if (rawTextarea) {
            rawTextarea.value = content;
        }
        updateLinesCount();
    }

    function updateCursorDisplay(row, col) {
        const el = document.getElementById('editor-cursor-pos');
        if (el) el.textContent = `Baris ${row}, Kolom ${col}`;
    }

    function updateLinesCount() {
        const content = getScriptEditorContent();
        const lines = content.split('\n').length;
        const bytes = new Blob([content]).size;
        const kb = (bytes / 1024).toFixed(2);

        const linesEl = document.getElementById('editor-total-lines');
        const sizeEl = document.getElementById('editor-file-size');
        if (linesEl) linesEl.textContent = `${lines} Baris`;
        if (sizeEl) sizeEl.textContent = `${kb} KB (${bytes} bytes)`;
    }

    function checkDirtyStatus() {
        const currentContent = getScriptEditorContent();
        const indicator = document.getElementById('editor-dirty-indicator');
        if (!indicator) return;

        if (currentContent !== originalScriptContent) {
            indicator.className = 'badge bg-warning text-dark font-monospace';
            indicator.innerHTML = '<i class="ti ti-alert-triangle me-1.5"></i> Ada Perubahan Belum Disimpan';
        } else {
            indicator.className = 'badge bg-secondary font-monospace';
            indicator.innerHTML = '<i class="ti ti-check me-1.5"></i> Tidak Ada Perubahan';
        }
    }

    function openBladeScriptEditor(sectionId, sectionName, sectionFile, themeFolder) {
        currentScriptSectionId = sectionId;

        const titleEl = document.getElementById('modal-script-section-name');
        const pathEl = document.getElementById('modal-script-file-path');
        const modEl = document.getElementById('modal-script-modified-time');
        const statusBadge = document.getElementById('modal-script-status-badge');
        const loadingOverlay = document.getElementById('editor-loading-overlay');

        if (titleEl) titleEl.textContent = sectionName;
        if (pathEl) pathEl.textContent = `resources/views/website/${themeFolder}/${sectionFile}`;
        if (modEl) modEl.innerHTML = '<i class="ti ti-clock me-1.5"></i> Memeriksa...';
        if (statusBadge) {
            statusBadge.className = 'badge bg-info text-white font-monospace py-1 px-2.5';
            statusBadge.innerHTML = '<i class="ti ti-loader-2 ti-spin me-1.5"></i> Memuat File...';
        }
        if (loadingOverlay) loadingOverlay.classList.remove('hidden');

        // Show Bootstrap Modal
        const modalEl = document.getElementById('modal-editor-script-blade');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }

        // Initialize Ace Editor
        initAceEditorIfNeeded();

        // Fetch Script Content from Server
        const getUrl = `${routes.getSectionScript || '/admin/dukunganaplikasi/konfigurasi-website/get-section-script'}/${sectionId}`;
        fetch(getUrl, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');

            if (data.status === 'success') {
                originalScriptContent = data.content || '';
                setScriptEditorContent(originalScriptContent);

                if (pathEl) pathEl.textContent = data.relative_path || `resources/views/website/${themeFolder}/${sectionFile}`;
                if (modEl) modEl.innerHTML = `<i class="ti ti-clock me-1.5"></i> Terakhir Diubah: ${data.last_modified || 'Baru'}`;

                if (statusBadge) {
                    if (data.file_exists) {
                        statusBadge.className = 'badge bg-success bg-opacity-75 text-white font-monospace py-1 px-2.5';
                        statusBadge.innerHTML = '<i class="ti ti-circle-check me-1.5"></i> File Siap Diedit';
                    } else {
                        statusBadge.className = 'badge bg-warning bg-opacity-75 text-dark font-monospace py-1 px-2.5';
                        statusBadge.innerHTML = '<i class="ti ti-sparkles me-1.5"></i> File Baru (Akan Dibuat Otomatis)';
                    }
                }

                checkDirtyStatus();
            } else {
                if (typeof window.showError === 'function') {
                    window.showError(data.message || 'Gagal memuat script blade.');
                }
            }
        })
        .catch(err => {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
            console.error('Error loading script:', err);
            if (typeof window.showError === 'function') {
                window.showError('Terjadi kesalahan saat memuat isi script.');
            }
        });
    }

    function saveBladeScript() {
        if (!currentScriptSectionId) return;

        const btnSave = document.getElementById('btn-save-blade-script');
        const content = getScriptEditorContent();
        const originalHtml = btnSave ? btnSave.innerHTML : '';

        if (btnSave) {
            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="ti ti-spin ti-spinner me-1.5"></i> Menyimpan Script...';
        }

        const saveUrl = `${routes.saveSectionScript || '/admin/dukunganaplikasi/konfigurasi-website/save-section-script'}/${currentScriptSectionId}`;
        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ content: content })
        })
        .then(res => res.json())
        .then(data => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = originalHtml;
            }

            if (data.status === 'success') {
                originalScriptContent = content;
                checkDirtyStatus();

                const modEl = document.getElementById('modal-script-modified-time');
                if (modEl && data.last_modified) {
                    modEl.innerHTML = `<i class="ti ti-clock me-1"></i> Terakhir Diubah: ${data.last_modified}`;
                }

                const statusBadge = document.getElementById('modal-script-status-badge');
                if (statusBadge) {
                    statusBadge.className = 'badge bg-success bg-opacity-75 text-white font-monospace py-1 px-2';
                    statusBadge.innerHTML = '<i class="ti ti-circle-check me-1"></i> File Siap Diedit';
                }

                if (typeof window.showSuccess === 'function') {
                    window.showSuccess(data.message || 'Script Blade berhasil disimpan!');
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
                    window.showError(data.message || 'Gagal menyimpan script blade.');
                }
            }
        })
        .catch(err => {
            if (btnSave) {
                btnSave.disabled = false;
                btnSave.innerHTML = originalHtml;
            }
            console.error('Error saving script:', err);
            if (typeof window.showError === 'function') {
                window.showError('Terjadi kesalahan jaringan saat menyimpan script.');
            }
        });
    }

    function toggleEditorFullscreen() {
        const modalEl = document.getElementById('modal-editor-script-blade');
        const btn = document.getElementById('btn-editor-fullscreen');
        if (!modalEl || !btn) return;

        modalEl.classList.toggle('is-fullscreen');
        const isFull = modalEl.classList.contains('is-fullscreen');

        if (isFull) {
            btn.innerHTML = '<i class="ti ti-minimize fs-15 me-1"></i> <span class="fs-12 d-none d-sm-inline">Kecilkan</span>';
        } else {
            btn.innerHTML = '<i class="ti ti-maximize fs-15 me-1"></i> <span class="fs-12 d-none d-sm-inline">Layar Penuh</span>';
        }

        if (aceEditor) {
            setTimeout(() => aceEditor.resize(), 150);
        }
    }

    function toggleEditorWordWrap(btn) {
        isEditorWordWrap = !isEditorWordWrap;
        if (aceEditor) {
            aceEditor.session.setUseWrapMode(isEditorWordWrap);
        }
        if (btn) {
            if (isEditorWordWrap) {
                btn.classList.add('btn-secondary');
                btn.classList.remove('btn-outline-secondary');
            } else {
                btn.classList.add('btn-outline-secondary');
                btn.classList.remove('btn-secondary');
            }
        }
    }

    function toggleEditorTheme(btn) {
        isEditorDarkMode = !isEditorDarkMode;
        const icon = document.getElementById('icon-editor-theme');
        const label = document.getElementById('label-editor-theme');

        if (aceEditor) {
            aceEditor.setTheme(isEditorDarkMode ? 'ace/theme/monokai' : 'ace/theme/chrome');
        }

        if (icon && label) {
            if (isEditorDarkMode) {
                icon.className = 'ti ti-moon me-1';
                label.textContent = 'Dark Mode';
            } else {
                icon.className = 'ti ti-sun me-1 text-warning';
                label.textContent = 'Light Mode';
            }
        }
    }

    function copyBladeScriptCode(btn) {
        const content = getScriptEditorContent();
        if (!content) {
            if (typeof window.showWarning === 'function') {
                window.showWarning('Script masih kosong.');
            }
            return;
        }

        navigator.clipboard.writeText(content).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="ti ti-check me-1"></i> <span class="fs-12">Tersalin!</span>';
            btn.classList.remove('btn-outline-info');
            btn.classList.add('btn-success');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-info');
            }, 2000);
        }).catch(() => {
            if (typeof window.showWarning === 'function') {
                window.showWarning('Gunakan Ctrl+C untuk menyalin.');
            }
        });
    }

    function resetBladeScriptCode() {
        if (typeof window.showConfirm === 'function') {
            window.showConfirm({
                title: 'Reset Perubahan Script?',
                text: 'Semua perubahan yang belum disimpan akan dikembalikan ke versi terakhir dari server.',
                isDanger: true,
                onConfirm: () => {
                    setScriptEditorContent(originalScriptContent);
                    checkDirtyStatus();
                    if (typeof window.showToast === 'function') {
                        window.showToast('Script berhasil dikembalikan ke kondisi awal.');
                    }
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin membatalkan semua perubahan script?')) {
                setScriptEditorContent(originalScriptContent);
                checkDirtyStatus();
            }
        }
    }

    function insertBladeSnippet(key) {
        const snippets = {
            section_wrapper: `<section class="section-custom" id="nama-seksi">\n    <div class="container">\n        <div class="row align-items-center">\n            <div class="col-lg-6">\n                <h2 class="fw-bold mb-3">Judul Seksi Halaman</h2>\n                <p class="text-muted mb-4">Deskripsi singkat penjelasan fitur atau layanan di seksi ini.</p>\n                <a href="#kontak" class="btn btn-primary px-4 py-2 fw-semibold">\n                    <i class="ti ti-arrow-right me-1"></i> Pelajari Lebih Lanjut\n                </a>\n            </div>\n            <div class="col-lg-6 text-center">\n                <img src="{{ asset('assets/images/placeholder.png') }}" class="img-fluid rounded-3 shadow-sm" alt="Ilustrasi Seksi">\n            </div>\n        </div>\n    </div>\n</section>\n`,
            container_row: `<div class="container py-4">\n    <div class="row g-4">\n        <div class="col-md-6">\n            <!-- Konten Kolom Kiri -->\n        </div>\n        <div class="col-md-6">\n            <!-- Konten Kolom Kanan -->\n        </div>\n    </div>\n</div>\n`,
            section_header: `<div class="row justify-content-center text-center mb-5">\n    <div class="col-lg-8">\n        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1.5 mb-2 rounded-pill fs-12">SUBTITLE SEKSI</span>\n        <h2 class="fw-bold text-dark display-6 mb-3">Judul Utama Seksi Halaman</h2>\n        <p class="text-muted fs-15 mb-0">Penjelasan singkat dan menarik mengenai konten yang disajikan pada bagian ini.</p>\n    </div>\n</div>\n`,
            card_grid: `<div class="row g-4">\n    <div class="col-md-4">\n        <div class="card border-0 shadow-sm h-100 p-4">\n            <div class="avatar-md bg-primary text-white rounded-3 d-flex align-items-center justify-content-center mb-3">\n                <i class="ti ti-bolt fs-24"></i>\n            </div>\n            <h5 class="fw-bold text-dark mb-2">Fitur Unggulan 1</h5>\n            <p class="text-muted fs-14 mb-0">Deskripsi keunggulan dan kemudahan yang didapatkan oleh pengguna.</p>\n        </div>\n    </div>\n    <div class="col-md-4">\n        <div class="card border-0 shadow-sm h-100 p-4">\n            <div class="avatar-md bg-info text-white rounded-3 d-flex align-items-center justify-content-center mb-3">\n                <i class="ti ti-shield-check fs-24"></i>\n            </div>\n            <h5 class="fw-bold text-dark mb-2">Fitur Unggulan 2</h5>\n            <p class="text-muted fs-14 mb-0">Keamanan terjamin dengan enkripsi modern dan perlindungan menyeluruh.</p>\n        </div>\n    </div>\n    <div class="col-md-4">\n        <div class="card border-0 shadow-sm h-100 p-4">\n            <div class="avatar-md bg-success text-white rounded-3 d-flex align-items-center justify-content-center mb-3">\n                <i class="ti ti-heart-handshake fs-24"></i>\n            </div>\n            <h5 class="fw-bold text-dark mb-2">Fitur Unggulan 3</h5>\n            <p class="text-muted fs-14 mb-0">Layanan bantuan dan integrasi cepat siap mendampingi kebutuhan Anda.</p>\n        </div>\n    </div>\n</div>\n`,
            cta_button: `<a href="{{ url('/register') }}" class="btn btn-primary btn-lg fw-semibold px-4 py-2.5 shadow-sm">\n    <i class="ti ti-rocket me-1.5"></i> Mulai Sekarang Gratis\n</a>\n`,
            blade_lang: `{{ __('website.title') }}`,
            blade_if: `@if (isset($items) && count($items) > 0)\n    <!-- Tampilkan jika ada data -->\n@else\n    <!-- Tampilkan jika kosong -->\n@endif\n`,
            blade_foreach: `@foreach ($items as $item)\n    <div class="col-md-4 mb-3">\n        <h6>{{ $item->title }}</h6>\n    </div>\n@endforeach\n`
        };

        const snippetCode = snippets[key];
        if (!snippetCode) return;

        if (aceEditor) {
            aceEditor.insert(snippetCode);
            aceEditor.focus();
        } else {
            const rawTextarea = document.getElementById('blade-script-raw-editor');
            if (rawTextarea) {
                const start = rawTextarea.selectionStart;
                const end = rawTextarea.selectionEnd;
                rawTextarea.value = rawTextarea.value.substring(0, start) + snippetCode + rawTextarea.value.substring(end);
                rawTextarea.selectionStart = rawTextarea.selectionEnd = start + snippetCode.length;
                rawTextarea.focus();
                rawTextarea.dispatchEvent(new Event('input'));
            }
        }

        if (typeof window.showToast === 'function') {
            window.showToast('Snippet berhasil disisipkan ke editor.');
        }
    }
});

