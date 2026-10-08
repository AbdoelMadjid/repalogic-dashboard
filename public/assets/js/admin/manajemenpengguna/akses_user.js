/**
 * Manajemen Hak Akses Pengguna (User Access) Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/akses_user.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.AksesUserConfig || {};
    const routes = config.routes || {};
    const allRolesData = config.roles || [];

    // ==========================================
    // 1. Initialize Yajra DataTables Server-Side AJAX (Rule 23)
    // ==========================================
    let dataTable = null;
    const tableEl = document.getElementById('akses-user-table');

    if (tableEl && (window.DataTable || (window.$ && $.fn.DataTable))) {
        const DT = window.DataTable || (window.$ && $.fn.DataTable);

        dataTable = new DT(tableEl, {
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    type: 'inline'
                }
            },
            autoWidth: false,
            pageLength: 100,
            lengthMenu: [10, 25, 50, 100, 250],
            ajax: {
                url: routes.dataUrl || window.location.pathname,
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1, width: '45px', className: 'text-center align-middle font-monospace fs-12' },
                { data: 'user_formatted', name: 'name', responsivePriority: 1, className: 'align-middle' },
                { data: 'roles_formatted', name: 'roles_formatted', orderable: false, searchable: false, responsivePriority: 10002, className: 'text-center align-middle' },
                { data: 'direct_perms_formatted', name: 'direct_perms_formatted', orderable: false, searchable: false, responsivePriority: 10003, className: 'text-center align-middle' },
                { data: 'total_perms_formatted', name: 'total_perms_formatted', orderable: false, searchable: false, responsivePriority: 10004, className: 'text-center align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 10001, width: '120px', className: 'text-center align-middle text-nowrap' }
            ],
            order: [[1, 'asc']],
            language: {
                search: "",
                searchPlaceholder: "Cari pengguna...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: '<span class="text-muted fs-12"><span class="fw-semibold text-dark">_START_</span> - <span class="fw-semibold text-dark">_END_</span> <span class="text-muted">/ total</span> <span class="fw-semibold text-dark">_TOTAL_</span></span>',
                infoEmpty: '<span class="text-muted fs-12">0 entri</span>',
                infoFiltered: '<span class="text-muted fs-11">(difilter dari _MAX_ total entri)</span>',
                zeroRecords: 'Tidak ada data pengguna yang sesuai.',
                emptyTable: 'Belum ada data pengguna yang ditemukan.',
                paginate: {
                    first: '<i class="ti ti-chevrons-left"></i>',
                    previous: '<i class="ti ti-chevron-left"></i>',
                    next: '<i class="ti ti-chevron-right"></i>',
                    last: '<i class="ti ti-chevrons-right"></i>'
                }
            }
        });

        // Window resize listener to recalculate responsive columns and adjustments seamlessly (Rule 23)
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (dataTable) {
                    if (typeof dataTable.columns === 'function') {
                        dataTable.columns.adjust();
                    }
                    if (dataTable.responsive && typeof dataTable.responsive.recalc === 'function') {
                        dataTable.responsive.recalc();
                    }
                }
            }, 30);
        });
    }

    // ==========================================
    // 2. Permission Check All & Matrix Logic
    // ==========================================
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

    // ==========================================
    // 3. Modal & Action Handlers (Event Delegation)
    // ==========================================
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
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-key me-1.5"></i> Atur Hak Akses Pengguna: ${user.name}`;
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Hak Akses';

        } else if (action === 'view') {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1.5"></i> Detail Hak Akses Pengguna: ${user.name}`;
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            formInputs.forEach(input => input.disabled = true);
        }

        aksesUserModal.show();
    });
});
