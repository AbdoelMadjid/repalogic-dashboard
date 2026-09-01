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
    const statTotal = document.getElementById('stat-total');
    const statActive = document.getElementById('stat-active');
    const statInactive = document.getElementById('stat-inactive');

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
        const activeCount = switches.filter(s => s.checked).length;
        const inactiveCount = switches.length - activeCount;

        if (statTotal) statTotal.textContent = switches.length;
        if (statActive) statActive.textContent = activeCount;
        if (statInactive) statInactive.textContent = inactiveCount;
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
                    window.showSuccess(data.message || 'Status fitur berhasil diperbarui.', { reload: true });
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
                            window.showSuccess(data.message, { reload: true });
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

    // WIDGET 2: IDLE TIMEOUT HANDLER
    const idleSelect = document.getElementById('widget_idle_timeout');
    const btnSaveIdle = document.getElementById('btn-save-idle-timeout');
    const btnTestLock = document.getElementById('btn-test-lock-screen');
    const badgeCurrentIdle = document.getElementById('badge-current-idle');

    const storedMins = localStorage.getItem('repalogic_idle_timeout_minutes');
    if (storedMins !== null && idleSelect) {
        idleSelect.value = storedMins;
        if (badgeCurrentIdle) {
            badgeCurrentIdle.textContent = storedMins > 0 ? `Aktif: ${storedMins} Menit` : 'Nonaktif';
        }
    }

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
                btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Durasi Idle';

                if (typeof window.setIdleTimeoutMinutes === 'function') {
                    window.setIdleTimeoutMinutes(mins);
                } else {
                    localStorage.setItem('repalogic_idle_timeout_minutes', mins);
                }

                if (badgeCurrentIdle) {
                    badgeCurrentIdle.textContent = mins > 0 ? `Aktif: ${mins} Menit` : 'Nonaktif';
                }

                if (typeof window.showToast === 'function') {
                    window.showToast(mins > 0 ? `Waktu idle auto-lock diset ke ${mins} menit.` : 'Auto-lock dinonaktifkan.', 'success');
                }
            })
            .catch(err => {
                btnSaveIdle.disabled = false;
                btnSaveIdle.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Durasi Idle';
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

    // WIDGET 3: MAINTENANCE MODE HANDLER
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
                btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Status Pemeliharaan';
                window.showToast('Pengaturan mode pemeliharaan berhasil disimpan.', 'success');
            })
            .catch(err => {
                btnSaveMaintenance.disabled = false;
                btnSaveMaintenance.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Status Pemeliharaan';
                window.showError(err.message || 'Gagal menyimpan status pemeliharaan.');
            });
        });
    }

    // WIDGET 4: SECURITY POLICY HANDLER
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
                btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Kebijakan Keamanan';
                window.showToast('Kebijakan keamanan akun berhasil disimpan.', 'success');
            })
            .catch(err => {
                btnSaveSecurity.disabled = false;
                btnSaveSecurity.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Kebijakan Keamanan';
                window.showError(err.message || 'Gagal menyimpan kebijakan keamanan.');
            });
        });
    }

    // WIDGET 5: POLLING & NOTIFICATION HANDLER
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
                btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Polling';
                window.showToast('Konfigurasi sinkronisasi polling berhasil disimpan.', 'success');
            })
            .catch(err => {
                btnSavePolling.disabled = false;
                btnSavePolling.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Konfigurasi Polling';
                window.showError(err.message || 'Gagal menyimpan konfigurasi polling.');
            });
        });
    }

    // WIDGET 6: CLEAR SYSTEM CACHE HANDLER
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
                        btnClearCache.innerHTML = '<i class="ti ti-trash me-1"></i> Bersihkan Semua Cache';
                        if (data.success) {
                            window.showSuccess(data.message, { reload: false });
                        } else {
                            window.showError(data.message || 'Gagal membersihkan cache sistem.');
                        }
                    })
                    .catch(err => {
                        btnClearCache.disabled = false;
                        btnClearCache.innerHTML = '<i class="ti ti-trash me-1"></i> Bersihkan Semua Cache';
                        window.showError(err.message || 'Terjadi kesalahan saat membersihkan cache.');
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
});
