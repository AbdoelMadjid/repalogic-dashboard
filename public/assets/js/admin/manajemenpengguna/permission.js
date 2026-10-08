/**
 * Manajemen Permission Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/permission.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.PermissionConfig || {};
    const routes = config.routes || {};

    // ==========================================
    // 1. Initialize Yajra DataTables Server-Side AJAX (Rule 23)
    // ==========================================
    let dataTable = null;
    const tableEl = document.getElementById('permission-table');

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
                { data: 'target_formatted', name: 'target_formatted', responsivePriority: 1, className: 'align-middle' },
                { data: 'crud_formatted', name: 'crud_formatted', orderable: false, searchable: false, responsivePriority: 10002, className: 'align-middle' },
                { data: 'roles_formatted', name: 'roles_formatted', orderable: false, searchable: false, responsivePriority: 10003, className: 'align-middle' },
                { data: 'count_formatted', name: 'count_formatted', orderable: false, searchable: false, responsivePriority: 10004, className: 'text-center align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 10001, width: '120px', className: 'text-center align-middle text-nowrap' }
            ],
            order: [[1, 'asc']],
            language: {
                search: "",
                searchPlaceholder: "Cari modul / fitur...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: '<span class="text-muted fs-12"><span class="fw-semibold text-dark">_START_</span> - <span class="fw-semibold text-dark">_END_</span> <span class="text-muted">/ total</span> <span class="fw-semibold text-dark">_TOTAL_</span></span>',
                infoEmpty: '<span class="text-muted fs-12">0 entri</span>',
                infoFiltered: '<span class="text-muted fs-11">(difilter dari _MAX_ total entri)</span>',
                zeroRecords: 'Tidak ada data permission yang sesuai.',
                emptyTable: 'Belum ada data permission yang ditemukan.',
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
    // 2. Modal & Action Handlers (Event Delegation)
    // ==========================================
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
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-plus me-1.5"></i> Tambah Permission Baru';
            permissionForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Simpan Permission';

            document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);

        } else if (actionType === 'edit' && target) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-edit me-1.5"></i> Edit Permission Modul: ${target}`;
            permissionForm.action = `${routes.base}/${firstId}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1.5"></i> Perbarui Permission';

            const targetInput = document.getElementById('form_permission_target');
            if (targetInput) targetInput.value = target;
            const menuInput = document.getElementById('form_permission_menu_id');
            if (menuInput) menuInput.value = menuId || '';

            document.querySelectorAll('.action-checkbox').forEach(cb => {
                cb.checked = actionsArr.includes(cb.value);
            });

        } else if (actionType === 'view' && target) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1.5"></i> Detail Permission Modul: ${target}`;
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
