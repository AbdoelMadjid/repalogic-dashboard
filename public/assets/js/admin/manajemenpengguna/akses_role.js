/**
 * Manajemen Hak Akses Role Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/akses_role.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.AksesRoleConfig || {};
    const routes = config.routes || {};

    // ==========================================
    // 1. Initialize Yajra DataTables Server-Side AJAX (Rule 23)
    // ==========================================
    let dataTable = null;
    const tableEl = document.getElementById('akses-role-table');

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
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100],
            ajax: {
                url: routes.dataUrl || window.location.pathname,
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1, width: '45px', className: 'text-center align-middle font-monospace fs-12' },
                { data: 'name_formatted', name: 'name', responsivePriority: 1, className: 'align-middle' },
                { data: 'users_count_formatted', name: 'users_count', responsivePriority: 10002, className: 'text-center align-middle' },
                { data: 'permissions_count_formatted', name: 'permissions_count', responsivePriority: 10003, className: 'text-center align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 10001, width: '120px', className: 'text-center align-middle text-nowrap' }
            ],
            order: [[1, 'asc']],
            language: {
                search: "",
                searchPlaceholder: "Cari role...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: '<span class="text-muted fs-12"><span class="fw-semibold text-dark">_START_</span> - <span class="fw-semibold text-dark">_END_</span> <span class="text-muted">/ total</span> <span class="fw-semibold text-dark">_TOTAL_</span></span>',
                infoEmpty: '<span class="text-muted fs-12">0 entri</span>',
                infoFiltered: '<span class="text-muted fs-11">(difilter dari _MAX_ total entri)</span>',
                zeroRecords: 'Tidak ada data role yang sesuai.',
                emptyTable: 'Belum ada data role yang ditemukan.',
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

    // ==========================================
    // 3. Modal & Action Handlers (Event Delegation)
    // ==========================================
    const aksesRoleModalElement = document.getElementById('aksesRoleModal');
    const aksesRoleModal = aksesRoleModalElement ? new bootstrap.Modal(aksesRoleModalElement) : null;
    const aksesRoleForm = document.getElementById('aksesRoleForm');
    const modalTitle = document.getElementById('aksesRoleModalTitle');
    const modalRoleNameDisplay = document.getElementById('modal_role_name_display');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.role-permission-checkbox, .check-row-all, #check_all_permissions');

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-akses-role-trigger');
        if (!btn || !aksesRoleModal || !aksesRoleForm) return;
        e.preventDefault();

        const action = btn.getAttribute('data-action');
        const roleDataRaw = btn.getAttribute('data-role');
        const role = roleDataRaw ? JSON.parse(roleDataRaw) : null;

        if (!role) return;

        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');

        document.querySelectorAll('.role-permission-checkbox, .check-row-all, #check_all_permissions').forEach(cb => {
            cb.checked = false;
        });

        if (modalRoleNameDisplay) modalRoleNameDisplay.textContent = role.name.toUpperCase();
        aksesRoleForm.action = `${routes.base}/${role.id}`;

        if (action === 'edit') {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-key me-1.5"></i> Atur Hak Akses Role: ${role.name}`;
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Hak Akses';

        } else if (action === 'view') {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1.5"></i> Detail Hak Akses Role: ${role.name}`;
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            formInputs.forEach(input => input.disabled = true);
        }

        // Check active permissions for this role
        if (role.permissions && role.permissions.length > 0) {
            role.permissions.forEach(perm => {
                const permCb = document.querySelectorAll(`input[value="${perm.name}"]`);
                permCb.forEach(cb => cb.checked = true);
            });
        }

        syncAllParentMenuStates();
        updateRowAllStates();
        updateCheckAllState();

        aksesRoleModal.show();
    });
});
