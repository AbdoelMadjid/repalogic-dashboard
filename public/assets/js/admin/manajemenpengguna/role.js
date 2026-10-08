/**
 * Manajemen Role Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/role.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.RoleConfig || {};
    const routes = config.routes || {};

    // ==========================================
    // 1. Initialize Yajra DataTables Server-Side AJAX (Rule 23)
    // ==========================================
    let dataTable = null;
    const tableEl = document.getElementById('role-table');

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
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-plus me-1.5"></i> Tambah Role Baru';
            roleForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Role';
            updateRowAllStates();
            updateCheckAllState();

        } else if (action === 'edit' && role) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-edit me-1.5"></i> Edit Role: ${role.name}`;
            roleForm.action = `${routes.base}/${role.id}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Perbarui Role';
            populateForm(role);

            const nameInput = document.getElementById('form_role_name');
            if (nameInput) {
                nameInput.readOnly = (role.name === 'superadmin');
            }

        } else if (action === 'view' && role) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1.5"></i> Detail Role: ${role.name}`;
            roleForm.action = '#';
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            populateForm(role);
            formInputs.forEach(input => input.disabled = true);
        }

        roleModal.show();
    });
});
