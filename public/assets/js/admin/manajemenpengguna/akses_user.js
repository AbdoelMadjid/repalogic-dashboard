/**
 * Manajemen Hak Akses Pengguna (User Access) Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/akses_user.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.AksesUserConfig || {};
    const routes = config.routes || {};
    const allRolesData = config.roles || [];

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
        document.querySelectorAll('.akses-user-row').forEach(row => {
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
                tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> pengguna';
            } else if (pageSize === Infinity) {
                tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> pengguna`;
            } else {
                tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> pengguna`;
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

    // Auto-select permissions when Role Checkbox is checked
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('user-role-checkbox')) {
            const isChecked = e.target.checked;
            const roleName = e.target.value;
            const roleObj = allRolesData.find(r => r.name === roleName);
            if (roleObj && roleObj.permissions) {
                roleObj.permissions.forEach(perm => {
                    const permCb = document.querySelectorAll(`input[name="permissions[]"][value="${perm.name}"]`);
                    permCb.forEach(cb => {
                        if (!cb.disabled) {
                            if (isChecked) {
                                cb.checked = true;
                            } else {
                                // Only uncheck if no other checked role has this permission
                                const otherCheckedRoles = Array.from(document.querySelectorAll('.user-role-checkbox:checked')).map(el => el.value);
                                const stillHasPerm = allRolesData.some(r => otherCheckedRoles.includes(r.name) && r.permissions.some(p => p.name === perm.name));
                                if (!stillHasPerm) {
                                    cb.checked = false;
                                }
                            }
                        }
                    });
                });
            }
            syncAllParentMenuStates();
            updateRowAllStates();
            updateCheckAllState();
        }
    });

    // Modal & Action Handlers (Event Delegation)
    const aksesUserModalElement = document.getElementById('aksesUserModal');
    const aksesUserModal = aksesUserModalElement ? new bootstrap.Modal(aksesUserModalElement) : null;
    const aksesUserForm = document.getElementById('aksesUserForm');
    const modalTitle = document.getElementById('aksesUserModalTitle');
    const modalUserNameDisplay = document.getElementById('modal_user_name_display');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.user-role-checkbox, .role-permission-checkbox, .check-row-all, #check_all_permissions');

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-akses-user-trigger');
        if (!btn || !aksesUserModal || !aksesUserForm) return;
        e.preventDefault();

        const action = btn.getAttribute('data-action');
        const userDataRaw = btn.getAttribute('data-user');
        const user = userDataRaw ? JSON.parse(userDataRaw) : null;

        if (!user) return;

        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');

        document.querySelectorAll('.user-role-checkbox, .role-permission-checkbox, .check-row-all, #check_all_permissions').forEach(cb => {
            cb.checked = false;
        });

        const nameInput = document.getElementById('form_user_name');
        if (nameInput) nameInput.value = user.name || '';
        const emailInput = document.getElementById('form_user_email');
        if (emailInput) emailInput.value = user.email || '';
        if (modalUserNameDisplay) modalUserNameDisplay.textContent = `${user.name} (${user.email})`;
        aksesUserForm.action = `${routes.base}/${user.id}`;

        // 1. Check active roles
        const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
        userRoles.forEach(rName => {
            const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
            roleCb.forEach(cb => cb.checked = true);
        });

        // 2. Check active permissions
        const userPerms = user.all_permission_names || user.direct_permission_names || (user.permissions ? user.permissions.map(p => p.name || p) : []);
        userPerms.forEach(pName => {
            const permCb = document.querySelectorAll(`input[name="permissions[]"][value="${pName}"]`);
            permCb.forEach(cb => cb.checked = true);
        });

        syncAllParentMenuStates();
        updateRowAllStates();
        updateCheckAllState();

        if (action === 'edit') {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-key me-1"></i> Atur Hak Akses Pengguna: ${user.name}`;
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Hak Akses';

        } else if (action === 'view') {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Hak Akses Pengguna: ${user.name}`;
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            formInputs.forEach(input => input.disabled = true);
        }

        aksesUserModal.show();
    });
});
