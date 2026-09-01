/**
 * Manajemen Permission Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/permission.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.PermissionConfig || {};
    const routes = config.routes || {};

    let currentPage = 1;
    let pageSize = 25;

    const searchInput = document.getElementById('table-search-input');
    const lengthSelect = document.getElementById('table-length-select');
    const tableInfoBar = document.getElementById('table-info-bar');
    const paginationUl = document.getElementById('table-pagination');

    function updateTableDisplay() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedLength = lengthSelect ? lengthSelect.value : '25';
        pageSize = selectedLength === 'all' ? Infinity : parseInt(selectedLength, 10);

        let matchingRows = [];
        document.querySelectorAll('.permission-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            if (query === '' || text.includes(query)) {
                matchingRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        const totalMatching = matchingRows.length;
        const totalPages = pageSize === Infinity ? 1 : (Math.ceil(totalMatching / pageSize) || 1);

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = pageSize === Infinity ? 0 : (currentPage - 1) * pageSize;
        const endIndex = pageSize === Infinity ? totalMatching : Math.min(startIndex + pageSize, totalMatching);

        matchingRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        if (tableInfoBar) {
            if (totalMatching === 0) {
                tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> modul';
            } else if (pageSize === Infinity) {
                tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> modul`;
            } else {
                tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> modul`;
            }
        }

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        if (!paginationUl) return;

        if (totalPages <= 1 || pageSize === Infinity) {
            paginationUl.innerHTML = '';
            return;
        }

        let html = '';
        const prevDisabled = currentPage === 1 ? ' disabled' : '';
        html += `<li class="page-item${prevDisabled}" data-page="1" title="Halaman Awal"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-left fs-14"></i></a></li>`;
        html += `<li class="page-item${prevDisabled}" data-page="${currentPage - 1}" title="Sebelumnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left fs-14"></i></a></li>`;

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        for (let p = startPage; p <= endPage; p++) {
            const activeClass = p === currentPage ? ' active' : '';
            html += `<li class="page-item${activeClass}" data-page="${p}"><a class="page-link" href="javascript:void(0);">${p}</a></li>`;
        }

        const nextDisabled = currentPage === totalPages ? ' disabled' : '';
        html += `<li class="page-item${nextDisabled}" data-page="${currentPage + 1}" title="Berikutnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right fs-14"></i></a></li>`;
        html += `<li class="page-item${nextDisabled}" data-page="${totalPages}" title="Halaman Akhir"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-right fs-14"></i></a></li>`;

        paginationUl.innerHTML = html;

        paginationUl.querySelectorAll('.page-item:not(.disabled)').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetPage = parseInt(this.getAttribute('data-page'), 10);
                if (targetPage && targetPage !== currentPage) {
                    currentPage = targetPage;
                    updateTableDisplay();
                }
            });
        });
    }

    if (lengthSelect) {
        lengthSelect.addEventListener('change', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    updateTableDisplay();

    // Modal & Action Handlers (Event Delegation)
    const permissionModalElement = document.getElementById('permissionModal');
    const permissionModal = permissionModalElement ? new bootstrap.Modal(permissionModalElement) : null;
    const permissionForm = document.getElementById('permissionForm');
    const modalTitle = document.getElementById('permissionModalTitle');
    const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.permission-input');

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-modul-permission-trigger');
        if (!btn || !permissionModal || !permissionForm) return;
        e.preventDefault();

        const actionType = btn.getAttribute('data-type');
        const target = btn.getAttribute('data-module');
        const menuId = btn.getAttribute('data-menu-id');
        const actionsStr = btn.getAttribute('data-actions') || '';
        const firstId = btn.getAttribute('data-first-id') || 0;
        const actionsArr = actionsStr ? actionsStr.split(',') : [];

        permissionForm.reset();
        if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '';
        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');

        document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = false);

        if (actionType === 'create') {
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Permission Baru';
            permissionForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Permission';

            document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);

        } else if (actionType === 'edit' && target) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Permission Modul: ${target}`;
            permissionForm.action = `${routes.base}/${firstId}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Permission';

            const targetInput = document.getElementById('form_permission_target');
            if (targetInput) targetInput.value = target;
            const menuInput = document.getElementById('form_permission_menu_id');
            if (menuInput) menuInput.value = menuId || '';

            document.querySelectorAll('.action-checkbox').forEach(cb => {
                cb.checked = actionsArr.includes(cb.value);
            });

        } else if (actionType === 'view' && target) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Permission Modul: ${target}`;
            permissionForm.action = '#';
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');

            const targetInput = document.getElementById('form_permission_target');
            if (targetInput) targetInput.value = target;
            const menuInput = document.getElementById('form_permission_menu_id');
            if (menuInput) menuInput.value = menuId || '';

            document.querySelectorAll('.action-checkbox').forEach(cb => {
                cb.checked = actionsArr.includes(cb.value);
            });

            formInputs.forEach(input => input.disabled = true);
        }

        permissionModal.show();
    });
});
