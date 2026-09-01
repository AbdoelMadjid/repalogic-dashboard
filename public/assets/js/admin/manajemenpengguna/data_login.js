/**
 * Manajemen Data Login Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/data_login.js
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const config = window.DataLoginConfig || {};
    const routes = config.routes || {};

    // 0. Switch Tampilan Tab 1 (Widget Kartu vs Tabel Baris)
    const btnToggleGridToday = document.getElementById('btnToggleGridToday');
    const btnToggleTableToday = document.getElementById('btnToggleTableToday');
    const todayViewGrid = document.getElementById('today-view-grid');
    const todayViewTable = document.getElementById('today-view-table');

    function setTodayViewMode(mode) {
        if (mode === 'table') {
            if (todayViewGrid) todayViewGrid.classList.add('d-none');
            if (todayViewTable) todayViewTable.classList.remove('d-none');
            if (btnToggleTableToday) {
                btnToggleTableToday.className = 'btn btn-primary btn-sm fw-medium d-flex align-items-center gap-1';
            }
            if (btnToggleGridToday) {
                btnToggleGridToday.className = 'btn btn-outline-secondary btn-sm fw-medium d-flex align-items-center gap-1';
            }
            try { localStorage.setItem('repalogic_today_view_mode', 'table'); } catch(e) {}
        } else {
            if (todayViewGrid) todayViewGrid.classList.remove('d-none');
            if (todayViewTable) todayViewTable.classList.add('d-none');
            if (btnToggleGridToday) {
                btnToggleGridToday.className = 'btn btn-primary btn-sm fw-medium d-flex align-items-center gap-1';
            }
            if (btnToggleTableToday) {
                btnToggleTableToday.className = 'btn btn-outline-secondary btn-sm fw-medium d-flex align-items-center gap-1';
            }
            try { localStorage.setItem('repalogic_today_view_mode', 'grid'); } catch(e) {}
        }
    }

    if (btnToggleGridToday) {
        btnToggleGridToday.addEventListener('click', function () {
            setTodayViewMode('grid');
        });
    }

    if (btnToggleTableToday) {
        btnToggleTableToday.addEventListener('click', function () {
            setTodayViewMode('table');
        });
    }

    // Restore saved preference if any
    try {
        const savedMode = localStorage.getItem('repalogic_today_view_mode');
        if (savedMode === 'table') {
            setTodayViewMode('table');
        }
    } catch(e) {}

    // 1. Toggle Tampilan Rentang Tanggal Kustom pada Filter
    const periodSelect = document.getElementById('filterPeriod');
    const customDateRangeCol = document.getElementById('customDateRangeCol');

    if (periodSelect && customDateRangeCol) {
        periodSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                customDateRangeCol.classList.remove('d-none');
            } else {
                customDateRangeCol.classList.add('d-none');
            }
        });
    }

    // 2. Modal Pembersihan Log
    const btnOpenClearLogsModal = document.getElementById('btnOpenClearLogsModal');
    const modalClearLogsEl = document.getElementById('modalClearLogs');
    let bsModalClearLogs = null;
    if (modalClearLogsEl) {
        bsModalClearLogs = new bootstrap.Modal(modalClearLogsEl);
    }

    if (btnOpenClearLogsModal && bsModalClearLogs) {
        btnOpenClearLogsModal.addEventListener('click', function () {
            bsModalClearLogs.show();
        });
    }

    // 3. Modal Detail Login Sesi & Map Geolocation
    const modalDetailLoginEl = document.getElementById('modalDetailLogin');
    let bsModalDetail = null;
    if (modalDetailLoginEl) {
        bsModalDetail = new bootstrap.Modal(modalDetailLoginEl);
    }

    const modalLoadingSpinner = document.getElementById('modalLoadingSpinner');
    const modalDetailContent = document.getElementById('modalDetailContent');
    const detailUserAvatar = document.getElementById('detailUserAvatar');
    const detailUserName = document.getElementById('detailUserName');
    const detailUserEmail = document.getElementById('detailUserEmail');
    const detailUserRole = document.getElementById('detailUserRole');
    const detailUserOnlineDot = document.getElementById('detailUserOnlineDot');
    const detailUserPresenceBadge = document.getElementById('detailUserPresenceBadge');
    const detailLoginAt = document.getElementById('detailLoginAt');
    const detailLoginHuman = document.getElementById('detailLoginHuman');
    const detailPointsAwarded = document.getElementById('detailPointsAwarded');
    const detailIpAddress = document.getElementById('detailIpAddress');
    const detailBrowser = document.getElementById('detailBrowser');
    const detailPlatform = document.getElementById('detailPlatform');
    const detailDeviceType = document.getElementById('detailDeviceType');
    const detailUserAgent = document.getElementById('detailUserAgent');
    const detailMapSection = document.getElementById('detailMapSection');
    const detailCoordinatesText = document.getElementById('detailCoordinatesText');
    const detailGoogleMapsBtn = document.getElementById('detailGoogleMapsBtn');
    const detailMapIframe = document.getElementById('detailMapIframe');

    // Event Delegation untuk Tombol Detail (Sesuai Rule 2)
    document.addEventListener('click', function (e) {
        const btnDetail = e.target.closest('.btn-view-detail');
        if (!btnDetail) return;

        const loginId = btnDetail.getAttribute('data-login-id');
        if (!loginId || !bsModalDetail) return;

        // Reset modal state
        if (modalLoadingSpinner) modalLoadingSpinner.classList.remove('d-none');
        if (modalDetailContent) modalDetailContent.classList.add('d-none');
        if (detailMapSection) detailMapSection.classList.add('d-none');
        if (detailMapIframe) detailMapIframe.src = '';
        bsModalDetail.show();

        // Fetch detail data via AJAX
        const fetchUrl = `${routes.base}/${loginId}`;
        fetch(fetchUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Gagal mengambil data detail login.');
            return res.json();
        })
        .then(res => {
            if (res.status === 'success' && res.data) {
                const d = res.data;
                if (detailUserAvatar) detailUserAvatar.src = d.user_avatar;
                if (detailUserName) detailUserName.textContent = d.user_name;
                if (detailUserEmail) detailUserEmail.textContent = d.user_email;
                if (detailUserRole) detailUserRole.textContent = d.user_role;

                // Update Online Presence
                if (d.is_online) {
                    if (detailUserOnlineDot) detailUserOnlineDot.classList.remove('d-none');
                    if (detailUserPresenceBadge) {
                        detailUserPresenceBadge.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 fs-12 d-inline-flex align-items-center gap-1.5 fw-semibold"><span class="badge-pulse-dot bg-success"></span> Sedang Online</span>';
                    }
                } else {
                    if (detailUserOnlineDot) detailUserOnlineDot.classList.add('d-none');
                    if (detailUserPresenceBadge) {
                        detailUserPresenceBadge.innerHTML = `<span class="badge bg-secondary-subtle text-muted border border-secondary-subtle px-3 py-1.5 fs-12 d-inline-flex align-items-center gap-1.5"><span class="badge-dot-gray"></span> ${d.last_seen_human}</span>`;
                    }
                }

                if (detailLoginAt) detailLoginAt.textContent = d.login_at;
                if (detailLoginHuman) detailLoginHuman.textContent = d.created_at_human;

                if (detailPointsAwarded) {
                    if (d.points_awarded) {
                        detailPointsAwarded.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="ti ti-check me-1"></i>+1 Poin Diberikan</span>';
                    } else {
                        detailPointsAwarded.innerHTML = '<span class="badge bg-secondary-subtle text-muted px-2 py-1">0 Poin (Maks 1 poin per 24 jam)</span>';
                    }
                }

                if (detailIpAddress) detailIpAddress.textContent = d.ip_address;
                if (detailBrowser) detailBrowser.textContent = d.browser;
                if (detailPlatform) detailPlatform.textContent = d.platform;
                if (detailDeviceType) detailDeviceType.textContent = d.device_type;
                if (detailUserAgent) detailUserAgent.textContent = d.user_agent;

                if (detailMapSection) {
                    if (d.latitude && d.longitude) {
                        if (detailCoordinatesText) detailCoordinatesText.innerHTML = `<strong>Latitude:</strong> ${d.latitude} &nbsp;|&nbsp; <strong>Longitude:</strong> ${d.longitude}`;
                        if (detailGoogleMapsBtn) detailGoogleMapsBtn.href = d.map_url;
                        if (detailMapIframe) detailMapIframe.src = d.osm_embed_url;
                        detailMapSection.classList.remove('d-none');
                    } else {
                        detailMapSection.classList.add('d-none');
                    }
                }

                if (modalLoadingSpinner) modalLoadingSpinner.classList.add('d-none');
                if (modalDetailContent) modalDetailContent.classList.remove('d-none');
            }
        })
        .catch(err => {
            if (modalLoadingSpinner) modalLoadingSpinner.classList.add('d-none');
            if (window.showError) {
                window.showError(err.message || 'Terjadi kesalahan saat memuat detail data.');
            } else {
                alert(err.message || 'Terjadi kesalahan saat memuat detail data.');
            }
            bsModalDetail.hide();
        });
    });
});
