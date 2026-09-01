/**
 * Manajemen Role Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/role.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.RoleConfig || {};
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
        document.querySelectorAll('.role-row').forEach(row => {
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
                tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> data';
            } else if (pageSize === Infinity) {
                tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> data`;
            } else {
                tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> data`;
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

    // Permission Check All Handler (Header SEMUA Checkbox)
    const checkAllPerms = document.getElementById('check_all_permissions');
    if (checkAllPerms) {
        checkAllPerms.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.role-permission-checkbox, .check-row-all').forEach(cb => {
                if (!cb.disabled) {
                    cb.checked = isChecked;
                }
            });
            syncAllParentMenuStates();
        });
    }

    // Helper to automatically sync all parent menu states
    function syncAllParentMenuStates() {
        // 1. Process Level 2 submenus that have Level 3 children
        document.querySelectorAll('.child-row[data-menu-id]').forEach(row => {
            const cMenuId = row.getAttribute('data-menu-id');
            const level3Children = document.querySelectorAll(`.role-permission-checkbox[data-parent-menu-id="${cMenuId}"]`);
            if (level3Children.length > 0) {
                const checkedLevel3 = document.querySelectorAll(`.role-permission-checkbox[data-parent-menu-id="${cMenuId}"]:checked`);
                if (checkedLevel3.length > 0) {
                    let readCb = row.querySelector(`.role-permission-checkbox[data-action="read"]`) || row.querySelector(`.role-permission-checkbox`);
                    if (readCb && !readCb.disabled) readCb.checked = true;
                } else {
                    row.querySelectorAll('.role-permission-checkbox').forEach(cb => {
                        if (!cb.disabled) cb.checked = false;
                    });
                }
            }
        });

        // 2. Process Level 1 Menu Utama (parents)
        document.querySelectorAll('.parent-row[data-menu-id]').forEach(row => {
            const pMenuId = row.getAttribute('data-menu-id');
            const allChildren = document.querySelectorAll(
                `.role-permission-checkbox[data-parent-menu-id="${pMenuId}"], ` +
                `.role-permission-checkbox[data-root-parent-id="${pMenuId}"]`
            );
            if (allChildren.length > 0) {
                const checkedChildren = document.querySelectorAll(
                    `.role-permission-checkbox[data-parent-menu-id="${pMenuId}"]:checked, ` +
                    `.role-permission-checkbox[data-root-parent-id="${pMenuId}"]:checked`
                );
                if (checkedChildren.length > 0) {
                    let readCb = row.querySelector(`.role-permission-checkbox[data-action="read"]`) || row.querySelector(`.role-permission-checkbox`);
                    if (readCb && !readCb.disabled) readCb.checked = true;
                } else {
                    row.querySelectorAll('.role-permission-checkbox').forEach(cb => {
                        if (!cb.disabled) cb.checked = false;
                    });
                }
            }
        });
    }

    // Permission Row Check All & Individual Permission Checkboxes (Event Delegation)
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('check-row-all')) {
            const targetClass = e.target.getAttribute('data-target-class');
            if (targetClass) {
                document.querySelectorAll(`.${targetClass}`).forEach(cb => {
                    if (!cb.disabled) {
                        cb.checked = e.target.checked;
                    }
                });
            }
            syncAllParentMenuStates();
            updateRowAllStates();
            updateCheckAllState();
        } else if (e.target && e.target.classList.contains('role-permission-checkbox')) {
            syncAllParentMenuStates();
            updateRowAllStates();
            updateCheckAllState();
        }
    });

    // Update row-all and check-all checkbox states based on checked items
    function updateRowAllStates() {
        document.querySelectorAll('.check-row-all').forEach(rowAll => {
            const targetClass = rowAll.getAttribute('data-target-class');
            if (targetClass) {
                const items = document.querySelectorAll(`.${targetClass}`);
                const checkedItems = document.querySelectorAll(`.${targetClass}:checked`);
                if (items.length > 0) {
                    rowAll.checked = (items.length === checkedItems.length);
                }
            }
        });
    }

    function updateCheckAllState() {
        const checkAll = document.getElementById('check_all_permissions');
        const totalItems = document.querySelectorAll('.role-permission-checkbox').length;
        const checkedItems = document.querySelectorAll('.role-permission-checkbox:checked').length;
        if (checkAll && totalItems > 0) {
            checkAll.checked = (totalItems === checkedItems);
        }
    }

    // Modal & Action Handlers (Event Delegation)
    const roleModalElement = document.getElementById('roleModal');
    const roleModal = roleModalElement ? new bootstrap.Modal(roleModalElement) : null;
    const roleForm = document.getElementById('roleForm');
    const modalTitle = document.getElementById('roleModalTitle');
    const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.role-input, .check-row-all, #check_all_permissions');

    function populateForm(role) {
        const nameInput = document.getElementById('form_role_name');
        if (nameInput) nameInput.value = role.name || '';

        if (role.permissions && role.permissions.length > 0) {
            role.permissions.forEach(perm => {
                const permCb = document.querySelectorAll(`input[value="${perm.name}"]`);
                permCb.forEach(cb => cb.checked = true);
            });
        }
        updateRowAllStates();
        updateCheckAllState();
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-role-action');
        if (!btn || !roleModal || !roleForm) return;
        e.preventDefault();

        const action = btn.getAttribute('data-action');
        const roleDataRaw = btn.getAttribute('data-role');
        const role = roleDataRaw ? JSON.parse(roleDataRaw) : null;

        roleForm.reset();
        if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '';
        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');

        document.querySelectorAll('.role-permission-checkbox, .check-row-all, #check_all_permissions').forEach(cb => {
            cb.checked = false;
        });

        if (action === 'create') {
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Role Baru';
            roleForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Role';
            updateRowAllStates();
            updateCheckAllState();

        } else if (action === 'edit' && role) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Role: ${role.name}`;
            roleForm.action = `${routes.base}/${role.id}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Role';
            populateForm(role);

            const nameInput = document.getElementById('form_role_name');
            if (nameInput) {
                nameInput.readOnly = (role.name === 'superadmin');
            }

        } else if (action === 'view' && role) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Role: ${role.name}`;
            roleForm.action = '#';
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            populateForm(role);
            formInputs.forEach(input => input.disabled = true);
        }

        roleModal.show();
    });
});
