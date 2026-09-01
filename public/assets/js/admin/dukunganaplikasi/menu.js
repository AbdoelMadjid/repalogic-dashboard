/**
 * Manajemen Menu Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/menu.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.MenuConfig || {};
    const totalRows = config.totalMenuCount || 0;
    const routes = config.routes || {};

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function showToast(message, type = 'success') {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        } else if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
            Toast.fire({ icon: type, title: message });
        }
    }

    // =========================================================================
    // 1. Live Instant Search Handler with Info Bar Update
    // =========================================================================
    const searchInput = document.getElementById('table-search-input');
    const infoVisibleCount = document.getElementById('info-visible-count');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            document.querySelectorAll('.category-block').forEach(block => {
                let hasVisibleChild = false;
                block.querySelectorAll('.parent-menu-row, .submenu-row').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        hasVisibleChild = true;
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const catHeader = block.querySelector('.category-header-row');
                if (catHeader) {
                    if (query === '' || hasVisibleChild) {
                        catHeader.style.display = '';
                    } else {
                        catHeader.style.display = 'none';
                    }
                }
            });

            if (infoVisibleCount) {
                infoVisibleCount.textContent = query === '' ? totalRows : visibleCount;
            }
        });
    }

    // =========================================================================
    // 2. Icon Input Live Preview
    // =========================================================================
    const formIcon = document.getElementById('form_icon');
    const formIconPreview = document.getElementById('form_icon_preview');

    if (formIcon && formIconPreview) {
        formIcon.addEventListener('input', function() {
            formIconPreview.className = this.value ? this.value : 'ti ti-category';
        });
    }

    // =========================================================================
    // 3. Drag & Drop Reordering via SortableJS (Level 1, 2, 3)
    // =========================================================================
    function postReorder(type, items, parentId = null) {
        if (!routes.reorder) return;

        fetch(routes.reorder, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                type: type,
                items: items,
                parent_id: parentId
            })
        })
        .then(res => {
            if (!res.ok) return null;
            return res.json();
        })
        .then(data => {
            if (data && data.status === 'success') {
                showToast(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            }
        })
        .catch(err => console.error(err));
    }

    // Level 1: Categories
    const mainTable = document.getElementById('main-menu-table');
    if (mainTable && typeof Sortable !== 'undefined') {
        Sortable.create(mainTable, {
            handle: '.handle-category',
            draggable: '.category-block',
            animation: 200,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function() {
                const orderedCategories = [];
                mainTable.querySelectorAll('.category-block').forEach(block => {
                    const cat = block.getAttribute('data-category');
                    if (cat) orderedCategories.push(cat);
                });
                postReorder('category', orderedCategories);
            }
        });
    }

    // Level 2 & 3: Parent Menus & Sub-Menus
    document.querySelectorAll('.category-block').forEach(catBlock => {
        if (typeof Sortable !== 'undefined') {
            const syncParentAndChildRows = function() {
                const parentRows = catBlock.querySelectorAll('.parent-menu-row');
                parentRows.forEach((pRow, index) => {
                    const parentId = pRow.getAttribute('data-id');
                    const orderEl = pRow.querySelector('.order-number');
                    if (orderEl) orderEl.textContent = index + 1;

                    const childRows = catBlock.querySelectorAll(`.child-of-${parentId}`);
                    let currentInsertRef = pRow;
                    childRows.forEach((cRow, cIndex) => {
                        currentInsertRef.after(cRow);
                        currentInsertRef = cRow;
                        const cOrderEl = cRow.querySelector('.order-number');
                        if (cOrderEl) cOrderEl.textContent = cIndex + 1;
                    });
                });
            };

            // SORTABLE LEVEL 2: PARENT MENUS
            Sortable.create(catBlock, {
                handle: '.handle-parent',
                draggable: '.parent-menu-row',
                animation: 200,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    syncParentAndChildRows();
                    const orderedParentIds = [];
                    catBlock.querySelectorAll('.parent-menu-row').forEach(pRow => {
                        const id = pRow.getAttribute('data-id');
                        if (id) orderedParentIds.push(id);
                    });
                    postReorder('parent', orderedParentIds);
                }
            });

            // SORTABLE LEVEL 3: SUB-MENUS
            const parentIdsInCat = new Set();
            catBlock.querySelectorAll('.parent-menu-row').forEach(pRow => {
                const id = pRow.getAttribute('data-id');
                if (id) parentIdsInCat.add(id);
            });

            parentIdsInCat.forEach(pId => {
                Sortable.create(catBlock, {
                    handle: '.handle-submenu',
                    draggable: `.child-of-${pId}`,
                    animation: 200,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag',
                    onEnd: function() {
                        const orderedSubIds = [];
                        catBlock.querySelectorAll(`.child-of-${pId}`).forEach((cRow, index) => {
                            const id = cRow.getAttribute('data-id');
                            if (id) orderedSubIds.push(id);
                            const orderEl = cRow.querySelector('.order-number');
                            if (orderEl) orderEl.textContent = index + 1;
                        });
                        postReorder('submenu', orderedSubIds, pId);
                    }
                });
            });
        }
    });

    // =========================================================================
    // 4. AJAX Switch Status Toggle (Event Delegation - Rule 2)
    // =========================================================================
    document.addEventListener('change', function(e) {
        const switchInput = e.target.closest('.switch-toggle-status');
        if (!switchInput || !routes.toggleStatus) return;

        const type = switchInput.getAttribute('data-type');
        const isChecked = switchInput.checked ? 1 : 0;
        const menuId = switchInput.getAttribute('data-id');
        const category = switchInput.getAttribute('data-category');
        const originalState = !switchInput.checked;

        fetch(routes.toggleStatus, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                type: type,
                active: isChecked,
                id: menuId,
                category: category
            })
        })
        .then(response => {
            if (!response.ok) return null;
            return response.json();
        })
        .then(res => {
            if (res && res.status === 'success') {
                showToast(res.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            } else {
                switchInput.checked = originalState;
            }
        })
        .catch(err => {
            console.error(err);
            switchInput.checked = originalState;
        });
    });

    // =========================================================================
    // 5. Action Modal Handler for Create, Edit, View (Event Delegation - Rule 2)
    // =========================================================================
    const modalEl = document.getElementById('menuModal');
    const menuModal = modalEl ? new bootstrap.Modal(modalEl) : null;
    const menuForm = document.getElementById('menuForm');
    const modalTitle = document.getElementById('menuModalTitle');
    const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.menu-input');

    function populateForm(menu) {
        document.getElementById('form_name').value = menu.name || '';
        document.getElementById('form_main_menu_id').value = menu.main_menu_id || '';
        document.getElementById('form_category').value = menu.category || '';
        document.getElementById('form_icon').value = menu.icon || '';
        document.getElementById('form_orders').value = menu.orders ?? 0;
        document.getElementById('form_route').value = menu.route || '';
        document.getElementById('form_url').value = menu.url || '';
        document.getElementById('form_active').checked = !!menu.active;

        document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = false);
        if (menu.permissions && menu.permissions.length > 0) {
            menu.permissions.forEach(perm => {
                const actionWord = perm.name.split(' ')[0];
                const cb = document.getElementById(`action_${actionWord}`);
                if (cb) cb.checked = true;
            });
        }

        document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = false);
        if (menu.permissions && menu.permissions.length > 0) {
            const assignedRoleNames = new Set();
            menu.permissions.forEach(perm => {
                if (perm.roles) {
                    perm.roles.forEach(r => assignedRoleNames.add(r.name));
                }
            });
            assignedRoleNames.forEach(rName => {
                const roleCb = document.getElementById(`role_${rName}`);
                if (roleCb) roleCb.checked = true;
            });
        }

        if (formIconPreview) {
            formIconPreview.className = menu.icon ? menu.icon : 'ti ti-category';
        }
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-menu-action');
        if (!btn || !menuModal || !menuForm) return;

        const action = btn.getAttribute('data-action');
        const menuDataRaw = btn.getAttribute('data-menu');
        const menu = menuDataRaw ? JSON.parse(menuDataRaw) : null;

        menuForm.reset();
        if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '';

        document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);
        document.querySelectorAll('.role-checkbox').forEach(cb => {
            cb.checked = (cb.value === 'superadmin' || cb.value === 'admin');
        });

        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');

        if (action === 'create') {
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Menu Baru';
            menuForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Menu';
            const ordersInput = document.getElementById('form_orders');
            if (ordersInput) ordersInput.value = 0;
            const activeInput = document.getElementById('form_active');
            if (activeInput) activeInput.checked = true;
            if (formIconPreview) formIconPreview.className = 'ti ti-category';

        } else if (action === 'edit' && menu) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Menu: ${menu.name}`;
            menuForm.action = `${routes.base}/${menu.id}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Menu';
            populateForm(menu);

        } else if (action === 'view' && menu) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Menu: ${menu.name}`;
            menuForm.action = '#';
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            populateForm(menu);
            formInputs.forEach(input => input.disabled = true);
        }

        menuModal.show();
    });
});
