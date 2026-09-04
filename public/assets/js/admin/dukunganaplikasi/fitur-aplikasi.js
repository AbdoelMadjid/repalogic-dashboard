/**
 * Fitur Aplikasi Module - Custom JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/fitur-aplikasi.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Route configuration from Blade bridge
    const configRoutes = window.FiturAplikasiConfig?.routes || {};
    const routes = {
        toggle: configRoutes.toggle || '/admin/dukunganaplikasi/fitur-aplikasi/toggle',
        bulkAction: configRoutes.bulkAction || '/admin/dukunganaplikasi/fitur-aplikasi/bulk-action',
        updateSetting: configRoutes.updateSetting || '/admin/dukunganaplikasi/fitur-aplikasi/update-setting',
        clearCache: configRoutes.clearCache || '/admin/dukunganaplikasi/fitur-aplikasi/clear-cache',
        scanImages: configRoutes.scanImages || '/admin/dukunganaplikasi/fitur-aplikasi/scan-images',
        deleteImages: configRoutes.deleteImages || '/admin/dukunganaplikasi/fitur-aplikasi/delete-images',
        resetDefaults: configRoutes.resetDefaults || '/admin/dukunganaplikasi/fitur-aplikasi/reset-defaults',
        store: configRoutes.store || '/admin/dukunganaplikasi/fitur-aplikasi',
        baseUrl: configRoutes.baseUrl || '/admin/dukunganaplikasi/fitur-aplikasi'
    };

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Elements
    const table = document.getElementById('fitur-table');
    const tbody = table ? table.querySelector('tbody') : null;
    const categorySelect = document.getElementById('table-category-select');
    const lengthSelect = document.getElementById('table-length-select');
    const searchInput = document.getElementById('table-search-input');
    const btnClearSearch = document.getElementById('btn-clear-search');
    const paginationUl = document.getElementById('table-pagination');
    const infoBar = document.getElementById('table-info-bar');

    // Stat Elements
    const statTotal = document.getElementById('stat-total');
    const statTotalBadge = document.getElementById('stat-total-badge');
    const statActive = document.getElementById('stat-active');
    const statInactive = document.getElementById('stat-inactive');
    const statProgressBar = document.getElementById('stat-progress-bar');
    const statPercentText = document.getElementById('stat-percent-text');
    const tabFeaturesCountBadge = document.getElementById('tab-features-count-badge');

    // Bulk Action Elements
    const checkAllGlobal = document.getElementById('check-all-global');
    const checkAllLabel = document.getElementById('check-all-label');
    const checkAllPage = document.getElementById('check-all-page');
    const selectedBadge = document.getElementById('selected-badge');
    const selectedCountSpan = document.getElementById('selected-count');
    const btnBulkEnable = document.getElementById('btn-bulk-enable');
    const btnBulkDisable = document.getElementById('btn-bulk-disable');
    const btnBulkDelete = document.getElementById('btn-bulk-delete');
    const btnDeselectAll = document.getElementById('btn-deselect-all');

    // Modal Elements
    const modalEl = document.getElementById('fiturModal');
    const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
    const form = document.getElementById('fiturForm');
    const formMethod = document.getElementById('formMethod');
    const featureIdInput = document.getElementById('feature_id');
    const modalTitleText = document.getElementById('modalTitleText');
    const modalTitleIcon = document.getElementById('modalTitleIcon');
    const btnSubmitFitur = document.getElementById('btnSubmitFitur');
    const btnSubmitText = document.getElementById('btnSubmitText');
    const iconInput = document.getElementById('modal_icon');
    const iconPreview = document.getElementById('iconPreview');

    // Tab Elements
    const tabVisibilityBtn = document.getElementById('tab-visibility-btn');
    const tabSettingsBtn = document.getElementById('tab-settings-btn');

    let currentPage = 1;
    let filteredRows = [];
    const selectedIds = new Set();

    // Live Icon Preview
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            const iconClass = this.value.trim() || 'ti ti-puzzle';
            iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;
        });
    }

    // Update Selection UI
    function updateSelectionUI() {
        const count = selectedIds.size;
        if (selectedCountSpan) selectedCountSpan.textContent = count;

        const hasSelection = count > 0;
        if (selectedBadge) selectedBadge.style.display = hasSelection ? 'inline-block' : 'none';
        if (btnDeselectAll) btnDeselectAll.style.display = hasSelection ? 'inline-block' : 'none';

        if (btnBulkEnable) btnBulkEnable.disabled = !hasSelection;
        if (btnBulkDisable) btnBulkDisable.disabled = !hasSelection;
        if (btnBulkDelete) btnBulkDelete.disabled = !hasSelection;

        // Sync Row Highlights & Checkboxes across ALL rows in table
        const allRowCheckboxes = document.querySelectorAll('.check-row-item');
        allRowCheckboxes.forEach(cb => {
            const row = cb.closest('tr');
            const isChecked = selectedIds.has(String(cb.value));
            cb.checked = isChecked;
            if (row) {
                if (isChecked) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            }
        });

        // Check filtered rows match
        const filteredIds = filteredRows.map(row => {
            const cb = row.querySelector('.check-row-item');
            return cb ? String(cb.value) : null;
        }).filter(Boolean);

        const filteredSelectedCount = filteredIds.filter(id => selectedIds.has(id)).length;

        // Sync "Pilih Semua (Filtered)"
        if (checkAllGlobal) {
            if (filteredIds.length > 0) {
                checkAllGlobal.checked = (filteredSelectedCount === filteredIds.length);
                checkAllGlobal.indeterminate = (filteredSelectedCount > 0 && filteredSelectedCount < filteredIds.length);
            } else {
                checkAllGlobal.checked = false;
                checkAllGlobal.indeterminate = false;
            }
        }

        // Sync Header "Check All Page"
        if (checkAllPage) {
            const visibleRows = Array.from(document.querySelectorAll('.fitur-row:not([style*="display: none"])'));
            const pageIds = visibleRows.map(row => {
                const cb = row.querySelector('.check-row-item');
                return cb ? String(cb.value) : null;
            }).filter(Boolean);

            const pageSelectedCount = pageIds.filter(id => selectedIds.has(id)).length;

            if (pageIds.length > 0) {
                checkAllPage.checked = (pageSelectedCount === pageIds.length);
                checkAllPage.indeterminate = (pageSelectedCount > 0 && pageSelectedCount < pageIds.length);
            } else {
                checkAllPage.checked = false;
                checkAllPage.indeterminate = false;
            }
        }
    }

    // Client-side Filter, Search, & Pagination Logic
    function applyFilterAndPagination() {
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('.fitur-row'));
        const selectedCat = categorySelect ? categorySelect.value : 'all';
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const pageSize = lengthSelect ? (lengthSelect.value === 'all' ? rows.length : parseInt(lengthSelect.value, 10)) : 25;

        filteredRows = rows.filter(row => {
            const group = row.getAttribute('data-group');
            const text = row.innerText.toLowerCase();

            const matchCat = (selectedCat === 'all' || group === selectedCat);
            const matchSearch = (!searchTerm || text.includes(searchTerm));

            return matchCat && matchSearch;
        });

        // Hide all rows initially
        rows.forEach(r => r.style.display = 'none');

        const totalFiltered = filteredRows.length;
        const totalPages = Math.ceil(totalFiltered / pageSize) || 1;
        if (currentPage > totalPages) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, totalFiltered);

        for (let i = startIndex; i < endIndex; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        // Update Row Numbers
        filteredRows.forEach((row, idx) => {
            const noCell = row.querySelector('.fitur-no');
            if (noCell) noCell.textContent = idx + 1;
        });

        // Update Info Bar
        if (infoBar) {
            infoBar.innerHTML = `Menampilkan <strong>${totalFiltered === 0 ? 0 : startIndex + 1} - ${endIndex}</strong> dari <strong>${totalFiltered}</strong> data fitur`;
        }

        // Update Check All Label
        if (checkAllLabel) {
            if (selectedCat === 'all') {
                checkAllLabel.textContent = `Pilih Semua (${totalFiltered} fitur)`;
            } else {
                const selectedOptionText = categorySelect.options[categorySelect.selectedIndex].text.split(' (')[0];
                checkAllLabel.textContent = `Pilih Semua (${selectedOptionText}: ${totalFiltered} fitur)`;
            }
        }

        // Render Pagination & Sync Checkboxes
        renderPagination(totalPages);
        updateSelectionUI();
    }

    function renderPagination(totalPages) {
        if (!paginationUl) return;
        paginationUl.innerHTML = '';
        if (totalPages <= 1) return;

        // Previous
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Previous"><i class="ti ti-chevron-left"></i></a>`;
        prevLi.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                applyFilterAndPagination();
            }
        });
        paginationUl.appendChild(prevLi);

        // Page Numbers
        for (let p = 1; p <= totalPages; p++) {
            if (totalPages > 7 && Math.abs(p - currentPage) > 2 && p !== 1 && p !== totalPages) {
                if (p === 2 || p === totalPages - 1) {
                    const dotsLi = document.createElement('li');
                    dotsLi.className = 'page-item disabled';
                    dotsLi.innerHTML = `<span class="page-link">...</span>`;
                    paginationUl.appendChild(dotsLi);
                }
                continue;
            }

            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${p === currentPage ? 'active' : ''}`;
            pageLi.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
            pageLi.addEventListener('click', () => {
                currentPage = p;
                applyFilterAndPagination();
            });
            paginationUl.appendChild(pageLi);
        }

        // Next
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Next"><i class="ti ti-chevron-right"></i></a>`;
        nextLi.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                applyFilterAndPagination();
            }
        });
        paginationUl.appendChild(nextLi);
    }

    // Recalculate Stats in UI
    function recalculateStats() {
        const switches = Array.from(document.querySelectorAll('.switch-fitur-toggle'));
        const totalCount = switches.length;
        const activeCount = switches.filter(s => s.checked).length;
        const inactiveCount = totalCount - activeCount;
        const percent = totalCount > 0 ? Math.round((activeCount / totalCount) * 100) : 0;

        if (statTotal) statTotal.textContent = totalCount;
        if (statTotalBadge) statTotalBadge.textContent = totalCount;
        if (statActive) statActive.textContent = activeCount;
        if (statInactive) statInactive.textContent = inactiveCount;
        if (statProgressBar) {
            statProgressBar.style.width = `${percent}%`;
            statProgressBar.setAttribute('aria-valuenow', percent);
        }
        if (statPercentText) statPercentText.textContent = `${percent}%`;
        if (tabFeaturesCountBadge) tabFeaturesCountBadge.textContent = `${totalCount} Fitur`;
    }

    // Event Listeners for Filters
    if (categorySelect) categorySelect.addEventListener('change', () => { currentPage = 1; applyFilterAndPagination(); });
    if (lengthSelect) lengthSelect.addEventListener('change', () => { currentPage = 1; applyFilterAndPagination(); });
    if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; applyFilterAndPagination(); });
    if (btnClearSearch) btnClearSearch.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        currentPage = 1;
        applyFilterAndPagination();
    });

    // Tab Switching Handlers & Persistence Across Reloads/Actions
    const navTabs = document.querySelectorAll('#fiturNavTabs a[data-bs-toggle="tab"]');
    const savedTab = window.location.hash || localStorage.getItem('active_fitur_tab');

    if (savedTab) {
        const tabTriggerEl = document.querySelector(`#fiturNavTabs a[href="${savedTab}"]`);
        if (tabTriggerEl) {
            const tabInstance = bootstrap.Tab.getOrCreateInstance(tabTriggerEl);
            tabInstance.show();
        }
    }

    navTabs.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function(e) {
            const targetHash = e.target.getAttribute('href');
            if (targetHash) {
                localStorage.setItem('active_fitur_tab', targetHash);
                if (window.location.hash !== targetHash) {
                    history.replaceState(null, null, targetHash);
                }
            }
            if (targetHash === '#tab-visibility') {
                applyFilterAndPagination();
            }
        });
    });

    // Initial Table Render
    applyFilterAndPagination();

    // CHECKBOX SELECTION LOGIC (Rule 2 Compliance: Event Delegation)
    document.addEventListener('change', function(e) {
        const target = e.target;

        // 1. Single Row Checkbox
        if (target && target.classList.contains('check-row-item')) {
            const idVal = String(target.value);
            if (target.checked) {
                selectedIds.add(idVal);
            } else {
                selectedIds.delete(idVal);
            }
            updateSelectionUI();
        }

        // 2. Check All on Current Visible Page
        if (target && target.id === 'check-all-page') {
            const isChecked = target.checked;
            const visibleRows = document.querySelectorAll('.fitur-row:not([style*="display: none"])');
            visibleRows.forEach(row => {
                const cb = row.querySelector('.check-row-item');
                if (cb) {
                    const idVal = String(cb.value);
                    if (isChecked) {
                        selectedIds.add(idVal);
                    } else {
                        selectedIds.delete(idVal);
                    }
                }
            });
            updateSelectionUI();
        }

        // 3. Check All in Current Filter Category
        if (target && target.id === 'check-all-global') {
            const isChecked = target.checked;
            filteredRows.forEach(row => {
                const cb = row.querySelector('.check-row-item');
                if (cb) {
                    const idVal = String(cb.value);
                    if (isChecked) {
                        selectedIds.add(idVal);
                    } else {
                        selectedIds.delete(idVal);
                    }
                }
            });
            updateSelectionUI();
        }
    });

    // Clicking on cell toggles checkbox
    document.addEventListener('click', function(e) {
        const checkCell = e.target.closest('.check-cell');
        if (checkCell && e.target.tagName !== 'INPUT') {
            const cb = checkCell.querySelector('.check-row-item');
            if (cb) {
                cb.checked = !cb.checked;
                const idVal = String(cb.value);
                if (cb.checked) {
                    selectedIds.add(idVal);
                } else {
                    selectedIds.delete(idVal);
                }
                updateSelectionUI();
            }
        }
    });

    // Deselect All Button
    if (btnDeselectAll) {
        btnDeselectAll.addEventListener('click', function() {
            selectedIds.clear();
            updateSelectionUI();
        });
    }

    // EVENT DELEGATION: Instant Switch Toggle via AJAX
    document.addEventListener('change', function(e) {
        const target = e.target;
        if (target && target.classList.contains('switch-fitur-toggle')) {
            const featureId = target.getAttribute('data-id');
            const featureCode = target.getAttribute('data-code');
            const isChecked = target.checked ? 1 : 0;
            const badgeStatus = document.getElementById(`badge_status_${featureId}`);

            target.disabled = true;

            fetch(routes.toggle, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: parseInt(featureId, 10),
                    feature: featureCode,
                    status: isChecked
                })
            })
            .then(async res => {
                let data;
                try {
                    data = await res.json();
                } catch (e) {
                    data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                }
                if (!res.ok) {
                    throw new Error(data.message || `Gagal menyimpan status (HTTP ${res.status}).`);
                }
                return data;
            })
            .then(data => {
                target.disabled = false;
                if (data.success) {
                    if (badgeStatus) {
                        badgeStatus.className = `status-indicator badge ${isChecked ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} fs-11`;
                        badgeStatus.textContent = isChecked ? 'Aktif' : 'Nonaktif';
                    }
                    recalculateStats();

                    // Realtime DOM Toggle for Topbar & Sidebar features
                    toggleFeatureElementInDOM(featureCode, isChecked);

                    if (typeof window.showToast === 'function') {
                        window.showToast(data.message || 'Status fitur berhasil diperbarui.', 'success');
                    } else if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || 'Status fitur berhasil diperbarui.', { reload: false });
                    }
                } else {
                    target.checked = !target.checked;
                    window.showError(data.message || 'Gagal mengubah status fitur.');
                }
            })
            .catch(err => {
                target.disabled = false;
                target.checked = !target.checked;
                console.error('Error toggling feature:', err);
                window.showError(err.message || 'Terjadi kesalahan saat menyimpan status.');
            });
        }
    });

    /**
     * Realtime DOM Toggle helper for Topbar header items and Sidebar menu elements
     */
    function toggleFeatureElementInDOM(featureCode, isChecked) {
        if (!featureCode) return;

        // 1. Target all elements matching data-feature attribute
        const directElements = document.querySelectorAll(`[data-feature="${featureCode}"]`);
        if (directElements.length > 0) {
            directElements.forEach(el => {
                if (isChecked) {
                    el.style.removeProperty('display');
                    el.classList.remove('feature-hidden');
                } else {
                    el.style.setProperty('display', 'none', 'important');
                    el.classList.add('feature-hidden');
                }
            });
        }

        // 2. Target elements by specific ID mappings (for Topbar & Special Sidebar elements)
        const idMap = {
            'topbar_search_box': '#search-box',
            'topbar_megamenu_header': '#megamenu-header',
            'topbar_megamenu_apps': '#megamenu-apps',
            'topbar_theme_toggler': '#theme-toggler',
            'topbar_apps_dropdown': '#apps-dropdown-rounded',
            'topbar_messages': '#simple-messages-dropdown',
            'topbar_notifications': '#notification-dropdown-alert',
            'topbar_fullscreen': '#fullscreen-toggler',
            'topbar_monochrome': '#monochrome-toggler',
            'topbar_customizer': '#theme-settings-toggler',
            'topbar_language': '#language-selector',
            'menu_special_menu': '.sidenav-special-bottom'
        };

        if (idMap[featureCode]) {
            const selector = idMap[featureCode];
            const mappedElements = document.querySelectorAll(selector);
            mappedElements.forEach(el => {
                if (isChecked) {
                    el.style.removeProperty('display');
                    el.classList.remove('feature-hidden');
                } else {
                    el.style.setProperty('display', 'none', 'important');
                    el.classList.add('feature-hidden');
                }
            });
        }
    }

    // EVENT DELEGATION: Bulk Action on Selected Rows (Aktifkan / Nonaktifkan / Hapus Terpilih)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-bulk-action');
        if (btn) {
            const action = btn.getAttribute('data-bulk');
            const ids = Array.from(selectedIds).map(id => parseInt(id, 10)).filter(id => !isNaN(id));

            if (ids.length === 0) {
                window.showWarning('Silakan pilih minimal satu fitur terlebih dahulu.');
                return;
            }

            const actionLabel = action === 'enable' ? 'mengaktifkan' : (action === 'disable' ? 'menonaktifkan' : 'menghapus');
            const confirmTitle = action === 'delete' ? 'Konfirmasi Hapus Fitur' : 'Konfirmasi Ubah Status';
            const confirmText = `Apakah Anda yakin ingin ${actionLabel} ${ids.length} fitur yang dipilih?`;

            window.showConfirm({
                title: confirmTitle,
                text: confirmText,
                isDanger: (action === 'delete'),
                onConfirm: () => {
                    btn.disabled = true;

                    fetch(routes.bulkAction, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            action: action,
                            ids: ids
                        })
                    })
                    .then(async res => {
                        let data;
                        try {
                            data = await res.json();
                        } catch (e) {
                            data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                        }
                        if (!res.ok) {
                            throw new Error(data.message || `Gagal memproses aksi massal (HTTP ${res.status}).`);
                        }
                        return data;
                    })
                    .then(data => {
                        btn.disabled = false;
                        if (data.success) {
                            if (action === 'enable' || action === 'disable') {
                                const isChecked = (action === 'enable');
                                ids.forEach(id => {
                                    const switchEl = document.querySelector(`.switch-fitur-toggle[data-id="${id}"]`);
                                    if (switchEl) {
                                        switchEl.checked = isChecked;
                                        const featureCode = switchEl.getAttribute('data-code');
                                        toggleFeatureElementInDOM(featureCode, isChecked ? 1 : 0);
                                    }
                                    const badgeStatus = document.getElementById(`badge_status_${id}`);
                                    if (badgeStatus) {
                                        badgeStatus.className = `status-indicator badge ${isChecked ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} fs-11`;
                                        badgeStatus.textContent = isChecked ? 'Aktif' : 'Nonaktif';
                                    }
                                });
                            } else if (action === 'delete') {
                                ids.forEach(id => {
                                    const row = document.getElementById(`row_fitur_${id}`) || document.querySelector(`tr[data-id="${id}"]`);
                                    if (row) {
                                        const switchEl = row.querySelector('.switch-fitur-toggle');
                                        if (switchEl) {
                                            const featureCode = switchEl.getAttribute('data-code');
                                            toggleFeatureElementInDOM(featureCode, 0);
                                        }
                                        row.remove();
                                    }
                                });
                            }

                            selectedIds.clear();
                            applyFilterAndPagination();
                            recalculateStats();
                            updateSelectionUI();

                            // Show notification while staying on the active tab without page reload
                            window.showSuccess(data.message, { reload: false });
                        } else {
                            window.showError(data.message || 'Gagal memproses aksi massal.');
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        console.error('Error executing bulk action:', err);
                        window.showError(err.message || 'Terjadi kesalahan saat memproses aksi.');
                    });
                }
            });
        }
    });

    // WIDGET 1: IDLE TIMEOUT HANDLER
    const idleSelect = document.getElementById('widget_idle_timeout');
    const btnSaveIdle = document.getElementById('btn-save-idle-timeout');
    const btnTestLock = document.getElementById('btn-test-lock-screen');
    const badgeCurrentIdle = document.getElementById('badge-current-idle');

    if (btnSaveIdle && idleSelect) {
        btnSaveIdle.addEventListener('click', function() {
            const mins = parseInt(idleSelect.value, 10);
            btnSaveIdle.disabled = true;
            btnSaveIdle.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch(routes.updateSetting, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    key: 'idle_timeout_minutes',
                    value: mins
                })
            })
            .then(res => res.json())
            .then(data => {
                btnSaveIdle.disabled = false;
                btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Durasi';

                if (typeof window.setIdleTimeoutMinutes === 'function') {
                    window.setIdleTimeoutMinutes(mins);
                }

                if (badgeCurrentIdle) {
                    badgeCurrentIdle.textContent = mins > 0 ? `Aktif: ${mins} Menit` : 'Nonaktif';
                }

                if (typeof window.showToast === 'function') {
                    window.showToast(mins > 0 ? `Waktu idle auto-lock diset ke ${mins} menit.` : 'Auto-lock dinonaktifkan.', 'success');
                } else if (typeof window.showSuccess === 'function') {
                    window.showSuccess(mins > 0 ? `Waktu idle auto-lock diset ke ${mins} menit.` : 'Auto-lock dinonaktifkan.', { reload: false });
                }
            })
            .catch(err => {
                btnSaveIdle.disabled = false;
                btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Durasi';
                window.showError(err.message || 'Gagal menyimpan pengaturan waktu idle.');
            });
        });
    }

    if (btnTestLock) {
        btnTestLock.addEventListener('click', function() {
            if (typeof window.lockScreen === 'function') {
                window.lockScreen();
            } else {
                window.showWarning('Fungsi lock screen belum siap.');
            }
        });
    }

    // WIDGET 2: MAINTENANCE MODE HANDLER
    const switchMaintenance = document.getElementById('widget_maintenance_mode');
    const labelMaintenance = document.getElementById('maintenance-status-label');
    const inputMaintenanceMsg = document.getElementById('widget_maintenance_message');
    const btnSaveMaintenance = document.getElementById('btn-save-maintenance');

    if (switchMaintenance && labelMaintenance) {
        switchMaintenance.addEventListener('change', function() {
            labelMaintenance.textContent = this.checked ? 'Aktif' : 'Nonaktif';
        });
    }

    if (btnSaveMaintenance && switchMaintenance && inputMaintenanceMsg) {
        btnSaveMaintenance.addEventListener('click', function() {
            btnSaveMaintenance.disabled = true;
            btnSaveMaintenance.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            Promise.all([
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'maintenance_mode', value: switchMaintenance.checked ? 1 : 0 })
                }),
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'maintenance_message', value: inputMaintenanceMsg.value })
                })
            ])
            .then(() => {
                btnSaveMaintenance.disabled = false;
                btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Mode Maintenance';
                if (typeof window.showToast === 'function') {
                    window.showToast('Pengaturan mode pemeliharaan berhasil disimpan.', 'success');
                } else if (typeof window.showSuccess === 'function') {
                    window.showSuccess('Pengaturan mode pemeliharaan berhasil disimpan.', { reload: false });
                }
            })
            .catch(err => {
                btnSaveMaintenance.disabled = false;
                btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Mode Maintenance';
                window.showError(err.message || 'Gagal menyimpan status pemeliharaan.');
            });
        });
    }

    // WIDGET 3: SECURITY POLICY HANDLER
    const selectRateLimit = document.getElementById('widget_rate_limit');
    const switchAutoApproval = document.getElementById('widget_auto_approval');
    const switchNewDevice = document.getElementById('widget_new_device');
    const btnSaveSecurity = document.getElementById('btn-save-security');

    if (btnSaveSecurity && selectRateLimit && switchAutoApproval && switchNewDevice) {
        btnSaveSecurity.addEventListener('click', function() {
            btnSaveSecurity.disabled = true;
            btnSaveSecurity.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            Promise.all([
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'rate_limit_attempts', value: selectRateLimit.value })
                }),
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'auto_user_approval', value: switchAutoApproval.checked ? 1 : 0 })
                }),
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'new_device_alert', value: switchNewDevice.checked ? 1 : 0 })
                })
            ])
            .then(() => {
                btnSaveSecurity.disabled = false;
                btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Kebijakan Keamanan';
                if (typeof window.showToast === 'function') {
                    window.showToast('Kebijakan keamanan akun berhasil disimpan.', 'success');
                } else if (typeof window.showSuccess === 'function') {
                    window.showSuccess('Kebijakan keamanan akun berhasil disimpan.', { reload: false });
                }
            })
            .catch(err => {
                btnSaveSecurity.disabled = false;
                btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Kebijakan Keamanan';
                window.showError(err.message || 'Gagal menyimpan kebijakan keamanan.');
            });
        });
    }

    // WIDGET 4: POLLING & NOTIFICATION HANDLER
    const selectPollingInterval = document.getElementById('widget_polling_interval');
    const switchSoundNotif = document.getElementById('widget_sound_notif');
    const switchToastNotif = document.getElementById('widget_toast_notif');
    const btnSavePolling = document.getElementById('btn-save-polling');

    if (btnSavePolling && selectPollingInterval && switchSoundNotif && switchToastNotif) {
        btnSavePolling.addEventListener('click', function() {
            btnSavePolling.disabled = true;
            btnSavePolling.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            Promise.all([
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'polling_interval', value: selectPollingInterval.value })
                }),
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'sound_notification', value: switchSoundNotif.checked ? 1 : 0 })
                }),
                fetch(routes.updateSetting, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken(), 'Accept': 'application/json' },
                    body: JSON.stringify({ key: 'toast_notification', value: switchToastNotif.checked ? 1 : 0 })
                })
            ])
            .then(() => {
                btnSavePolling.disabled = false;
                btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Konfigurasi Polling';
                if (typeof window.showToast === 'function') {
                    window.showToast('Konfigurasi sinkronisasi polling berhasil disimpan.', 'success');
                } else if (typeof window.showSuccess === 'function') {
                    window.showSuccess('Konfigurasi sinkronisasi polling berhasil disimpan.', { reload: false });
                }
            })
            .catch(err => {
                btnSavePolling.disabled = false;
                btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Konfigurasi Polling';
                window.showError(err.message || 'Gagal menyimpan konfigurasi polling.');
            });
        });
    }

    // WIDGET 5: CLEAR SYSTEM CACHE HANDLER
    const btnClearCache = document.getElementById('btn-clear-all-cache');
    if (btnClearCache) {
        btnClearCache.addEventListener('click', function() {
            window.showConfirm({
                title: 'Bersihkan Cache Sistem?',
                text: 'Tindakan ini akan mengosongkan cache Views Blade, Cache Route, Cache Konfigurasi, dan Cache Fitur secara menyeluruh.',
                isDanger: false,
                onConfirm: () => {
                    btnClearCache.disabled = true;
                    btnClearCache.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Membersihkan...';

                    fetch(routes.clearCache, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnClearCache.disabled = false;
                        btnClearCache.innerHTML = '<i class="ti ti-trash me-1.5"></i> Bersihkan Semua Cache Sistem';
                        if (data.success) {
                            window.showSuccess(data.message, { reload: false });
                        } else {
                            window.showError(data.message || 'Gagal membersihkan cache sistem.');
                        }
                    })
                    .catch(err => {
                        btnClearCache.disabled = false;
                        btnClearCache.innerHTML = '<i class="ti ti-trash me-1.5"></i> Bersihkan Semua Cache Sistem';
                        window.showError(err.message || 'Terjadi kesalahan saat membersihkan cache.');
                    });
                }
            });
        });
    }

    // RESET KE PENGATURAN DEFAULT (SEEDER) HANDLER
    const btnResetDefault = document.getElementById('btn-reset-default');
    if (btnResetDefault) {
        btnResetDefault.addEventListener('click', function() {
            window.showConfirm({
                title: 'Kembalikan ke Pengaturan Default?',
                text: 'Tindakan ini akan mengembalikan seluruh Pengaturan Sistem (Idle Timeout, Maintenance, Keamanan, Polling) serta status Visibilitas Fitur Topbar & Sidebar ke konfigurasi awal bawaan seeder.',
                isDanger: true,
                onConfirm: () => {
                    btnResetDefault.disabled = true;
                    btnResetDefault.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mereset...';

                    fetch(routes.resetDefaults, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(async res => {
                        let data;
                        try {
                            data = await res.json();
                        } catch (e) {
                            data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                        }
                        if (!res.ok) {
                            throw new Error(data.message || `Gagal mereset ke default (HTTP ${res.status}).`);
                        }
                        return data;
                    })
                    .then(data => {
                        btnResetDefault.disabled = false;
                        btnResetDefault.innerHTML = '<i class="ti ti-rotate-clockwise me-1 fs-14"></i><span class="fs-12">Kembalikan Default</span>';
                        if (data.success) {
                            window.showSuccess(data.message, { reload: true });
                        } else {
                            window.showError(data.message || 'Gagal mengembalikan ke pengaturan default.');
                        }
                    })
                    .catch(err => {
                        btnResetDefault.disabled = false;
                        btnResetDefault.innerHTML = '<i class="ti ti-rotate-clockwise me-1 fs-14"></i><span class="fs-12">Kembalikan Default</span>';
                        console.error('Error resetting defaults:', err);
                        window.showError(err.message || 'Terjadi kesalahan saat mereset pengaturan.');
                    });
                }
            });
        });
    }

    // EVENT DELEGATION: Action Buttons for Modal (Create, Edit, View) (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-fitur-action');
        if (btn) {
            const action = btn.getAttribute('data-action');
            const rowDataAttr = btn.getAttribute('data-row');
            const rowData = rowDataAttr ? JSON.parse(rowDataAttr) : null;

            if (!modal || !form) return;

            form.reset();
            // Reset inputs state
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(inp => inp.disabled = false);
            btnSubmitFitur.style.display = '';

            if (action === 'create') {
                modalTitleText.textContent = 'Tambah Fitur Aplikasi Baru';
                modalTitleIcon.className = 'ti ti-plus';
                form.action = routes.store;
                formMethod.value = 'POST';
                featureIdInput.value = '';
                btnSubmitText.textContent = 'Simpan Fitur Baru';
                document.getElementById('modal_status').checked = true;
                if (iconPreview) iconPreview.innerHTML = `<i class="ti ti-puzzle fs-18 text-primary"></i>`;
            } else if (action === 'edit' && rowData) {
                modalTitleText.textContent = 'Edit Data Fitur Aplikasi';
                modalTitleIcon.className = 'ti ti-edit';
                form.action = `${routes.baseUrl}/${rowData.id}`;
                formMethod.value = 'PUT';
                featureIdInput.value = rowData.id;
                btnSubmitText.textContent = 'Perbarui Fitur';

                document.getElementById('modal_kode_fitur').value = rowData.kode_fitur || '';
                document.getElementById('modal_nama_fitur').value = rowData.nama_fitur || '';
                document.getElementById('modal_kategori').value = rowData.kategori || 'topbar';
                document.getElementById('modal_icon').value = rowData.icon || '';
                document.getElementById('modal_urutan').value = rowData.urutan || 0;
                document.getElementById('modal_deskripsi').value = rowData.deskripsi || '';
                document.getElementById('modal_status').checked = Boolean(rowData.status);

                const iconClass = (rowData.icon && rowData.icon.trim()) ? rowData.icon : 'ti ti-puzzle';
                if (iconPreview) iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;
            } else if (action === 'view' && rowData) {
                modalTitleText.textContent = 'Detail Fitur Aplikasi';
                modalTitleIcon.className = 'ti ti-eye';
                formMethod.value = 'POST';
                featureIdInput.value = rowData.id;

                document.getElementById('modal_kode_fitur').value = rowData.kode_fitur || '';
                document.getElementById('modal_nama_fitur').value = rowData.nama_fitur || '';
                document.getElementById('modal_kategori').value = rowData.kategori || 'topbar';
                document.getElementById('modal_icon').value = rowData.icon || '';
                document.getElementById('modal_urutan').value = rowData.urutan || 0;
                document.getElementById('modal_deskripsi').value = rowData.deskripsi || '';
                document.getElementById('modal_status').checked = Boolean(rowData.status);

                const iconClass = (rowData.icon && rowData.icon.trim()) ? rowData.icon : 'ti ti-puzzle';
                if (iconPreview) iconPreview.innerHTML = `<i class="${iconClass} fs-18 text-primary"></i>`;

                // Disable all fields in view mode
                inputs.forEach(inp => inp.disabled = true);
                btnSubmitFitur.style.display = 'none';
            }

            modal.show();
        }
    });

    // Form Modal Submit via AJAX (Preserve Active Tab)
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (btnSubmitFitur) {
                btnSubmitFitur.disabled = true;
                btnSubmitFitur.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
            }

            const formData = new FormData(form);
            const actionUrl = form.action;

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                let data;
                try {
                    data = await res.json();
                } catch (err) {
                    data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                }
                if (!res.ok) {
                    const errorMsg = data.errors ? Object.values(data.errors).flat().join('<br>') : (data.message || 'Gagal menyimpan fitur.');
                    throw new Error(errorMsg);
                }
                return data;
            })
            .then(data => {
                if (btnSubmitFitur) {
                    btnSubmitFitur.disabled = false;
                    btnSubmitFitur.innerHTML = '<i class="ti ti-device-floppy me-1"></i> <span id="btnSubmitText">Simpan Fitur</span>';
                }
                if (data.success) {
                    if (modal) modal.hide();
                    localStorage.setItem('active_fitur_tab', '#tab-visibility');
                    history.replaceState(null, null, '#tab-visibility');
                    window.showSuccess(data.message, { reload: true });
                } else {
                    window.showError(data.message || 'Gagal menyimpan fitur.');
                }
            })
            .catch(err => {
                if (btnSubmitFitur) {
                    btnSubmitFitur.disabled = false;
                    btnSubmitFitur.innerHTML = '<i class="ti ti-device-floppy me-1"></i> <span id="btnSubmitText">Simpan Fitur</span>';
                }
                window.showError(err.message || 'Terjadi kesalahan saat menyimpan data.');
            });
        });
    }

    // =========================================================================
    // WIDGET 6: SINKRONISASI & PEMBERSIHAN MEDIA STORAGE HANDLER
    // =========================================================================
    const btnOpenSyncModal = document.getElementById('btn-open-sync-modal');
    const syncModalEl = document.getElementById('storageSyncModal');
    const syncModal = syncModalEl ? new bootstrap.Modal(syncModalEl) : null;
    const previewModalEl = document.getElementById('storageImagePreviewModal');
    const previewModal = previewModalEl ? new bootstrap.Modal(previewModalEl) : null;

    const syncLoadingState = document.getElementById('sync-loading-state');
    const syncMainContainer = document.getElementById('sync-main-container');
    const syncEmptyState = document.getElementById('sync-empty-state');
    const syncTableSection = document.getElementById('sync-table-section');

    const kpiTotalStorage = document.getElementById('kpi-total-storage');
    const kpiTotalSize = document.getElementById('kpi-total-size');
    const kpiValidDb = document.getElementById('kpi-valid-db');
    const kpiOrphanCount = document.getElementById('kpi-orphan-count');
    const kpiOrphanSize = document.getElementById('kpi-orphan-size');
    const badgeSyncStatus = document.getElementById('badge-sync-status');

    const orphanFolderSelect = document.getElementById('orphan-folder-select');
    const orphanSearchInput = document.getElementById('orphan-search-input');
    const btnClearOrphanSearch = document.getElementById('btn-clear-orphan-search');
    const btnReScan = document.getElementById('btn-re-scan');
    const btnReScanEmpty = document.getElementById('btn-re-scan-empty');
    const btnDeleteAllOrphans = document.getElementById('btn-delete-all-orphans');
    const btnDeleteSelectedOrphans = document.getElementById('btn-delete-selected-orphans');

    const checkAllOrphans = document.getElementById('check-all-orphans');
    const checkAllOrphansLabel = document.getElementById('check-all-orphans-label');
    const checkAllOrphanPage = document.getElementById('check-all-orphan-page');
    const orphanSelectedBadge = document.getElementById('orphan-selected-badge');
    const orphanSelectedCountSpan = document.getElementById('orphan-selected-count');
    const btnOrphanDeselectAll = document.getElementById('btn-orphan-deselect-all');

    const orphanTbody = document.getElementById('orphan-tbody');
    const orphanTableInfo = document.getElementById('orphan-table-info');
    const orphanPagination = document.getElementById('orphan-pagination');

    let allOrphanFiles = [];
    let filteredOrphanFiles = [];
    const selectedOrphanPaths = new Set();
    let currentOrphanPage = 1;
    const orphanPageSize = 10;

    /**
     * Memindai media storage via AJAX
     */
    function triggerStorageScan(showModal = true) {
        if (showModal && syncModal) {
            syncModal.show();
        }

        if (syncLoadingState) syncLoadingState.classList.remove('d-none');
        if (syncMainContainer) syncMainContainer.classList.add('d-none');

        if (btnOpenSyncModal) {
            btnOpenSyncModal.disabled = true;
            btnOpenSyncModal.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5"></span> Memindai Media...';
        }

        fetch(routes.scanImages, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            let data;
            try {
                data = await res.json();
            } catch (e) {
                data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
            }
            if (!res.ok) {
                throw new Error(data.message || `Gagal memindai media (HTTP ${res.status}).`);
            }
            return data;
        })
        .then(data => {
            if (btnOpenSyncModal) {
                btnOpenSyncModal.disabled = false;
                btnOpenSyncModal.innerHTML = '<i class="ti ti-refresh me-1.5"></i> Pindai &amp; Sinkronkan Gambar';
            }
            if (syncLoadingState) syncLoadingState.classList.add('d-none');
            if (syncMainContainer) syncMainContainer.classList.remove('d-none');

            if (data.success) {
                const summary = data.summary || {};
                allOrphanFiles = data.orphaned_files || [];
                selectedOrphanPaths.clear();
                currentOrphanPage = 1;

                // Update KPIs
                if (kpiTotalStorage) kpiTotalStorage.textContent = summary.total_storage_images || 0;
                if (kpiTotalSize) kpiTotalSize.textContent = summary.total_storage_size || '0 B';
                if (kpiValidDb) kpiValidDb.textContent = summary.total_valid_images || 0;
                if (kpiOrphanCount) kpiOrphanCount.textContent = summary.total_orphaned_images || 0;
                if (kpiOrphanSize) kpiOrphanSize.textContent = summary.orphaned_size_formatted || '0 B';

                // Update Card Status in Tab
                if (badgeSyncStatus) {
                    if (summary.total_orphaned_images > 0) {
                        badgeSyncStatus.className = 'badge bg-danger-subtle text-danger fs-11 fw-bold';
                        badgeSyncStatus.innerHTML = `<i class="ti ti-alert-circle me-1"></i> ${summary.total_orphaned_images} Gambar Sampah`;
                    } else {
                        badgeSyncStatus.className = 'badge bg-success-subtle text-success fs-11 fw-bold';
                        badgeSyncStatus.innerHTML = '<i class="ti ti-check me-1"></i> Terorganisir &amp; Sinkron';
                    }
                }

                // Populate Folder Filter Dropdown
                if (orphanFolderSelect) {
                    const currentVal = orphanFolderSelect.value;
                    orphanFolderSelect.innerHTML = '<option value="all">-- Semua Folder (' + allOrphanFiles.length + ') --</option>';
                    const folders = summary.folders || {};
                    Object.keys(folders).sort().forEach(folder => {
                        const opt = document.createElement('option');
                        opt.value = folder;
                        opt.textContent = `${folder} (${folders[folder]} gambar)`;
                        orphanFolderSelect.appendChild(opt);
                    });
                    if (folders[currentVal]) {
                        orphanFolderSelect.value = currentVal;
                    }
                }

                // Toggle Empty State vs Table
                if (allOrphanFiles.length === 0) {
                    if (syncEmptyState) syncEmptyState.classList.remove('d-none');
                    if (syncTableSection) syncTableSection.classList.add('d-none');
                } else {
                    if (syncEmptyState) syncEmptyState.classList.add('d-none');
                    if (syncTableSection) syncTableSection.classList.remove('d-none');
                    applyOrphanFilterAndPagination();
                }
            } else {
                window.showError(data.message || 'Gagal memindai media storage.');
            }
        })
        .catch(err => {
            if (btnOpenSyncModal) {
                btnOpenSyncModal.disabled = false;
                btnOpenSyncModal.innerHTML = '<i class="ti ti-refresh me-1.5"></i> Pindai &amp; Sinkronkan Gambar';
            }
            if (syncLoadingState) syncLoadingState.classList.add('d-none');
            if (syncMainContainer) syncMainContainer.classList.remove('d-none');
            console.error('Error scanning storage media:', err);
            window.showError(err.message || 'Terjadi kesalahan saat memindai penyimpanan media.');
        });
    }

    /**
     * Filter and render orphan files in table
     */
    function applyOrphanFilterAndPagination() {
        if (!orphanTbody) return;

        const selectedFolder = orphanFolderSelect ? orphanFolderSelect.value : 'all';
        const searchTerm = orphanSearchInput ? orphanSearchInput.value.toLowerCase().trim() : '';

        filteredOrphanFiles = allOrphanFiles.filter(item => {
            const matchFolder = (selectedFolder === 'all' || item.folder === selectedFolder);
            const matchSearch = (!searchTerm ||
                item.filename.toLowerCase().includes(searchTerm) ||
                item.path.toLowerCase().includes(searchTerm) ||
                item.folder.toLowerCase().includes(searchTerm)
            );
            return matchFolder && matchSearch;
        });

        const totalFiltered = filteredOrphanFiles.length;
        const totalPages = Math.ceil(totalFiltered / orphanPageSize) || 1;
        if (currentOrphanPage > totalPages) currentOrphanPage = 1;

        const startIndex = (currentOrphanPage - 1) * orphanPageSize;
        const endIndex = Math.min(startIndex + orphanPageSize, totalFiltered);
        const pageItems = filteredOrphanFiles.slice(startIndex, endIndex);

        // Render Table Rows
        orphanTbody.innerHTML = '';
        if (pageItems.length === 0) {
            orphanTbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4"><i class="ti ti-info-circle me-1.5"></i> Tidak ada gambar yang sesuai dengan filter pencarian.</td></tr>`;
        } else {
            pageItems.forEach((item, index) => {
                const globalNo = startIndex + index + 1;
                const tr = document.createElement('tr');
                tr.className = 'orphan-row';
                tr.setAttribute('data-path', item.path);
                if (selectedOrphanPaths.has(item.path)) {
                    tr.classList.add('table-active');
                }

                // Folder badge color styling
                let folderBadgeClass = 'bg-secondary-subtle text-secondary';
                if (item.folder === 'avatars') folderBadgeClass = 'bg-primary-subtle text-primary border-primary-subtle';
                else if (item.folder === 'covers') folderBadgeClass = 'bg-info-subtle text-info border-info-subtle';
                else if (item.folder === 'chat_attachments') folderBadgeClass = 'bg-purple-subtle text-purple border-purple-subtle';
                else if (item.folder === 'sections') folderBadgeClass = 'bg-success-subtle text-success border-success-subtle';
                else if (item.folder === 'ktp') folderBadgeClass = 'bg-warning-subtle text-warning border-warning-subtle';

                const isChecked = selectedOrphanPaths.has(item.path);
                const directImgUrl = `${window.location.origin}/storage/${item.path}`;

                tr.innerHTML = `
                    <td class="text-center orphan-check-cell cursor-pointer">
                        <input type="checkbox" class="form-check-input high-contrast-checkbox check-orphan-item" value="${item.path}" ${isChecked ? 'checked' : ''}>
                    </td>
                    <td class="text-center fw-semibold text-muted">${globalNo}</td>
                    <td class="text-center">
                        <div class="orphan-thumb-container mx-auto btn-preview-media" data-item='${JSON.stringify(item)}' title="Klik untuk Pratinjau Resolusi Penuh">
                            <img src="${directImgUrl}" class="orphan-thumb-img" alt="${item.filename}" loading="lazy" onerror="if(!this.dataset.fallback){this.dataset.fallback='1'; this.src='${item.url}';}else{this.onerror=null; this.parentElement.innerHTML='<i class=\\'ti ti-photo-off text-muted fs-20\\'></i>';}">
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark fs-13 mb-1 text-break">${item.filename}</span>
                            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                <code class="bg-light text-muted border px-1.5 py-0.5 rounded fs-11 font-monospace text-break">${item.storage_location}</code>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge ${folderBadgeClass} border fs-11 px-2 py-1 font-monospace">
                            <i class="ti ti-folder me-1"></i>${item.folder}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border fs-12">${item.size_formatted}</span>
                    </td>
                    <td class="text-center">
                        <span class="text-muted fs-12 text-nowrap"><i class="ti ti-calendar me-1"></i>${item.last_modified_formatted}</span>
                    </td>
                    <td class="text-center text-nowrap">
                        <button type="button" class="btn btn-xs btn-outline-info me-1 btn-preview-media" data-item='${JSON.stringify(item)}' title="Pratinjau Gambar">
                            <i class="ti ti-eye"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-danger btn-delete-single-orphan" data-path="${item.path}" data-name="${item.filename}" title="Hapus Berkas Ini">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                `;
                orphanTbody.appendChild(tr);
            });
        }

        // Update Info Bar
        if (orphanTableInfo) {
            orphanTableInfo.innerHTML = `Menampilkan <strong>${totalFiltered === 0 ? 0 : startIndex + 1} - ${endIndex}</strong> dari <strong>${totalFiltered}</strong> gambar sampah`;
        }

        // Update Check All Label
        if (checkAllOrphansLabel) {
            checkAllOrphansLabel.textContent = `Pilih Semua (${totalFiltered} gambar)`;
        }

        renderOrphanPagination(totalPages);
        updateOrphanSelectionUI();
    }

    /**
     * Render Orphan Table Pagination
     */
    function renderOrphanPagination(totalPages) {
        if (!orphanPagination) return;
        orphanPagination.innerHTML = '';
        if (totalPages <= 1) return;

        // Previous
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentOrphanPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Previous"><i class="ti ti-chevron-left"></i></a>`;
        prevLi.addEventListener('click', () => {
            if (currentOrphanPage > 1) {
                currentOrphanPage--;
                applyOrphanFilterAndPagination();
            }
        });
        orphanPagination.appendChild(prevLi);

        // Page Numbers
        for (let p = 1; p <= totalPages; p++) {
            if (totalPages > 7 && Math.abs(p - currentOrphanPage) > 2 && p !== 1 && p !== totalPages) {
                if (p === 2 || p === totalPages - 1) {
                    const dotsLi = document.createElement('li');
                    dotsLi.className = 'page-item disabled';
                    dotsLi.innerHTML = `<span class="page-link">...</span>`;
                    orphanPagination.appendChild(dotsLi);
                }
                continue;
            }

            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${p === currentOrphanPage ? 'active' : ''}`;
            pageLi.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
            pageLi.addEventListener('click', () => {
                currentOrphanPage = p;
                applyOrphanFilterAndPagination();
            });
            orphanPagination.appendChild(pageLi);
        }

        // Next
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentOrphanPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Next"><i class="ti ti-chevron-right"></i></a>`;
        nextLi.addEventListener('click', () => {
            if (currentOrphanPage < totalPages) {
                currentOrphanPage++;
                applyOrphanFilterAndPagination();
            }
        });
        orphanPagination.appendChild(nextLi);
    }

    /**
     * Update selection state UI for Orphan items
     */
    function updateOrphanSelectionUI() {
        const count = selectedOrphanPaths.size;
        if (orphanSelectedCountSpan) orphanSelectedCountSpan.textContent = count;

        const hasSelection = count > 0;
        if (orphanSelectedBadge) orphanSelectedBadge.style.display = hasSelection ? 'inline-block' : 'none';
        if (btnOrphanDeselectAll) btnOrphanDeselectAll.style.display = hasSelection ? 'inline-block' : 'none';
        if (btnDeleteSelectedOrphans) btnDeleteSelectedOrphans.disabled = !hasSelection;

        // Sync table row check states
        const allRowCheckboxes = document.querySelectorAll('.check-orphan-item');
        allRowCheckboxes.forEach(cb => {
            const row = cb.closest('tr');
            const isChecked = selectedOrphanPaths.has(cb.value);
            cb.checked = isChecked;
            if (row) {
                if (isChecked) {
                    row.classList.add('table-active');
                } else {
                    row.classList.remove('table-active');
                }
            }
        });

        // Filtered items selection status
        const filteredPaths = filteredOrphanFiles.map(item => item.path);
        const filteredSelectedCount = filteredPaths.filter(p => selectedOrphanPaths.has(p)).length;

        if (checkAllOrphans) {
            if (filteredPaths.length > 0) {
                checkAllOrphans.checked = (filteredSelectedCount === filteredPaths.length);
                checkAllOrphans.indeterminate = (filteredSelectedCount > 0 && filteredSelectedCount < filteredPaths.length);
            } else {
                checkAllOrphans.checked = false;
                checkAllOrphans.indeterminate = false;
            }
        }

        // Visible Page items selection status
        if (checkAllOrphanPage) {
            const pageRows = Array.from(document.querySelectorAll('.orphan-row'));
            const pagePaths = pageRows.map(row => row.getAttribute('data-path')).filter(Boolean);
            const pageSelectedCount = pagePaths.filter(p => selectedOrphanPaths.has(p)).length;

            if (pagePaths.length > 0) {
                checkAllOrphanPage.checked = (pageSelectedCount === pagePaths.length);
                checkAllOrphanPage.indeterminate = (pageSelectedCount > 0 && pageSelectedCount < pagePaths.length);
            } else {
                checkAllOrphanPage.checked = false;
                checkAllOrphanPage.indeterminate = false;
            }
        }
    }

    /**
     * Tampilkan Lightbox Pratinjau Gambar
     */
    function showImagePreview(item) {
        if (!item || !previewModal) return;

        const imgEl = document.getElementById('storage-preview-img');
        const filenameBadge = document.getElementById('preview-filename-badge');
        const fileNameEl = document.getElementById('preview-file-name');
        const fileFolderEl = document.getElementById('preview-file-folder');
        const storagePathEl = document.getElementById('preview-storage-path');
        const fileSizeEl = document.getElementById('preview-file-size');
        const fileExtEl = document.getElementById('preview-file-ext');
        const fileDateEl = document.getElementById('preview-file-date');
        const openExternalLink = document.getElementById('preview-open-external');

        const directImgUrl = `${window.location.origin}/storage/${item.path}`;

        if (imgEl) {
            imgEl.removeAttribute('data-fallback');
            imgEl.src = directImgUrl;
            imgEl.onerror = function() {
                if (!this.dataset.fallback && item.url && this.src !== item.url) {
                    this.dataset.fallback = '1';
                    this.src = item.url;
                }
            };
        }
        if (filenameBadge) filenameBadge.textContent = item.filename;
        if (fileNameEl) fileNameEl.textContent = item.filename;
        if (fileFolderEl) fileFolderEl.textContent = item.folder;
        if (storagePathEl) storagePathEl.textContent = item.storage_location;
        if (fileSizeEl) fileSizeEl.textContent = item.size_formatted;
        if (fileExtEl) fileExtEl.textContent = item.extension;
        if (fileDateEl) fileDateEl.textContent = item.last_modified_formatted;
        if (openExternalLink) openExternalLink.href = directImgUrl;

        previewModal.show();
    }

    /**
     * Eksekusi penghapusan gambar orphan via AJAX (Satuan, Terpilih, atau Semua)
     */
    function executeDeleteOrphans({ paths = [], deleteAll = false }) {
        const count = deleteAll ? allOrphanFiles.length : paths.length;
        if (count === 0) {
            window.showWarning('Tidak ada berkas yang dipilih untuk dihapus.');
            return;
        }

        const confirmTitle = deleteAll ? 'Hapus Seluruh Gambar Sampah?' : 'Hapus Gambar Terpilih?';
        const confirmText = deleteAll
            ? `Apakah Anda yakin ingin menghapus SELURUH (${count}) gambar sampah dari penyimpanan server? Tindakan ini permanen dan tidak dapat dibatalkan.`
            : `Apakah Anda yakin ingin menghapus ${count} gambar terpilih dari penyimpanan server? Tindakan ini permanen.`;

        window.showConfirm({
            title: confirmTitle,
            text: confirmText,
            isDanger: true,
            onConfirm: () => {
                if (btnDeleteAllOrphans) btnDeleteAllOrphans.disabled = true;
                if (btnDeleteSelectedOrphans) btnDeleteSelectedOrphans.disabled = true;

                fetch(routes.deleteImages, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        paths: paths,
                        delete_all: deleteAll ? 1 : 0
                    })
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch (e) {
                        data = { success: false, message: `Respon server tidak valid (${res.status} ${res.statusText})` };
                    }
                    if (!res.ok) {
                        throw new Error(data.message || `Gagal menghapus media (HTTP ${res.status}).`);
                    }
                    return data;
                })
                .then(data => {
                    if (btnDeleteAllOrphans) btnDeleteAllOrphans.disabled = false;
                    if (btnDeleteSelectedOrphans) btnDeleteSelectedOrphans.disabled = false;

                    if (data.success) {
                        window.showSuccess(data.message, { reload: false });
                        // Re-scan storage seamlessly to reflect fresh state
                        triggerStorageScan(false);
                    } else {
                        window.showError(data.message || 'Gagal menghapus berkas media.');
                    }
                })
                .catch(err => {
                    if (btnDeleteAllOrphans) btnDeleteAllOrphans.disabled = false;
                    if (btnDeleteSelectedOrphans) btnDeleteSelectedOrphans.disabled = false;
                    console.error('Error deleting storage media:', err);
                    window.showError(err.message || 'Terjadi kesalahan saat menghapus media.');
                });
            }
        });
    }

    // Event Listeners for Storage Sync Controls
    if (btnOpenSyncModal) {
        btnOpenSyncModal.addEventListener('click', function() {
            triggerStorageScan(true);
        });
    }

    if (btnReScan) {
        btnReScan.addEventListener('click', function() {
            triggerStorageScan(false);
        });
    }

    if (btnReScanEmpty) {
        btnReScanEmpty.addEventListener('click', function() {
            triggerStorageScan(false);
        });
    }

    if (orphanFolderSelect) {
        orphanFolderSelect.addEventListener('change', function() {
            currentOrphanPage = 1;
            applyOrphanFilterAndPagination();
        });
    }

    if (orphanSearchInput) {
        orphanSearchInput.addEventListener('input', function() {
            currentOrphanPage = 1;
            applyOrphanFilterAndPagination();
        });
    }

    if (btnClearOrphanSearch) {
        btnClearOrphanSearch.addEventListener('click', function() {
            if (orphanSearchInput) orphanSearchInput.value = '';
            currentOrphanPage = 1;
            applyOrphanFilterAndPagination();
        });
    }

    if (btnDeleteAllOrphans) {
        btnDeleteAllOrphans.addEventListener('click', function() {
            executeDeleteOrphans({ deleteAll: true });
        });
    }

    if (btnDeleteSelectedOrphans) {
        btnDeleteSelectedOrphans.addEventListener('click', function() {
            const paths = Array.from(selectedOrphanPaths);
            executeDeleteOrphans({ paths: paths, deleteAll: false });
        });
    }

    if (btnOrphanDeselectAll) {
        btnOrphanDeselectAll.addEventListener('click', function() {
            selectedOrphanPaths.clear();
            updateOrphanSelectionUI();
        });
    }

    // EVENT DELEGATION: Orphan Checkboxes & Table Actions
    document.addEventListener('change', function(e) {
        const target = e.target;

        // 1. Single Orphan Checkbox
        if (target && target.classList.contains('check-orphan-item')) {
            const pathVal = target.value;
            if (target.checked) {
                selectedOrphanPaths.add(pathVal);
            } else {
                selectedOrphanPaths.delete(pathVal);
            }
            updateOrphanSelectionUI();
        }

        // 2. Check All Page Items
        if (target && target.id === 'check-all-orphan-page') {
            const isChecked = target.checked;
            const pageRows = document.querySelectorAll('.orphan-row');
            pageRows.forEach(row => {
                const cb = row.querySelector('.check-orphan-item');
                if (cb) {
                    if (isChecked) {
                        selectedOrphanPaths.add(cb.value);
                    } else {
                        selectedOrphanPaths.delete(cb.value);
                    }
                }
            });
            updateOrphanSelectionUI();
        }

        // 3. Check All Filtered Items
        if (target && target.id === 'check-all-orphans') {
            const isChecked = target.checked;
            filteredOrphanFiles.forEach(item => {
                if (isChecked) {
                    selectedOrphanPaths.add(item.path);
                } else {
                    selectedOrphanPaths.delete(item.path);
                }
            });
            updateOrphanSelectionUI();
        }
    });

    // Event Delegation: Cell Click Checkbox, Preview Button, Delete Single Button
    document.addEventListener('click', function(e) {
        // Toggle checkbox on cell click
        const checkCell = e.target.closest('.orphan-check-cell');
        if (checkCell && e.target.tagName !== 'INPUT') {
            const cb = checkCell.querySelector('.check-orphan-item');
            if (cb) {
                cb.checked = !cb.checked;
                if (cb.checked) {
                    selectedOrphanPaths.add(cb.value);
                } else {
                    selectedOrphanPaths.delete(cb.value);
                }
                updateOrphanSelectionUI();
            }
            return;
        }

        // Preview Media Modal Trigger
        const btnPreview = e.target.closest('.btn-preview-media');
        if (btnPreview) {
            const rawData = btnPreview.getAttribute('data-item');
            if (rawData) {
                try {
                    const item = JSON.parse(rawData);
                    showImagePreview(item);
                } catch (err) {
                    console.error('Error parsing media preview data:', err);
                }
            }
            return;
        }

        // Delete Single Orphan Trigger
        const btnDeleteSingle = e.target.closest('.btn-delete-single-orphan');
        if (btnDeleteSingle) {
            const path = btnDeleteSingle.getAttribute('data-path');
            const name = btnDeleteSingle.getAttribute('data-name') || path;
            if (path) {
                window.showConfirm({
                    title: 'Hapus Berkas Gambar?',
                    text: `Apakah Anda yakin ingin menghapus berkas "${name}" dari storage server? Tindakan ini permanen.`,
                    isDanger: true,
                    onConfirm: () => {
                        executeDeleteOrphans({ paths: [path], deleteAll: false });
                    }
                });
            }
            return;
        }
    });
});

