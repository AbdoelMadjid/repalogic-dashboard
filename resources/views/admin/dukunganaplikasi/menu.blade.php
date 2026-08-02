@extends('layouts.vertical')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Daftar Menu Aplikasi (Live Search & Reordering 3 Level)</h4>
                            <p class="text-muted fs-12 mb-0">
                                🟡 <i class="ti ti-grip-vertical text-warning"></i> Drag <strong>Kategori</strong> (seluruh isi di bawahnya ikut).  
                                🔵 <i class="ti ti-menu-2 text-primary"></i> Drag <strong>Menu Utama</strong> (sub-menu di bawahnya ikut).  
                                ⚪ <i class="ti ti-dots-vertical text-secondary"></i> Drag <strong>Sub-Menu</strong> (hanya dalam menu utamanya).
                            </p>
                        </div>
                        @can('create dukunganaplikasi/menu')
                            <button type="button" class="btn btn-primary btn-sm btn-menu-action" data-action="create">
                                <i class="ti ti-plus me-1"></i> Tambah Menu Baru
                            </button>
                        @endcan
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @php
                            $totalMenuCount = 0;
                            foreach ($groupedMenus as $catMenus) {
                                $totalMenuCount += $catMenus->count();
                                foreach ($catMenus as $m) {
                                    $totalMenuCount += $m->subMenus->count();
                                }
                            }
                        @endphp

                        <!-- DATATABLES HEADER CONTROLS (JUMLAH BARIS & LIVE SEARCH) -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm datatable-length-select">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <div class="d-flex align-items-center datatable-search-input">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Menu:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama menu...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <!-- MAIN TABLE CONTAINING MULTIPLE TBODY CATEGORY BLOCKS -->
                            <table class="table table-hover align-middle table-bordered mb-0 table-custom-datatable" id="main-menu-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;" class="text-center">Urutan</th>
                                        <th>Nama Menu</th>
                                        <th style="width: 150px;">Status / Switch</th>
                                        <th style="width: 170px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                @forelse ($groupedMenus as $category => $categoryMenus)
                                    @php
                                        $catSlug = Str::slug($category);
                                        $allCatActive = true;
                                        foreach ($categoryMenus as $m) {
                                            if (!$m->active) { $allCatActive = false; break; }
                                            foreach ($m->subMenus as $sub) {
                                                if (!$sub->active) { $allCatActive = false; break; }
                                            }
                                        }
                                    @endphp
                                    <!-- CATEGORY BLOCK CONTAINER (DRAGGABLE ENTIRE CATEGORY BLOCK) -->
                                    <tbody class="category-block" data-category="{{ $category }}" data-cat-slug="{{ $catSlug }}">
                                        <!-- CATEGORY HEADER ROW -->
                                        <tr class="category-header-row table-dark">
                                            <td colspan="4" class="fw-bold py-2 text-uppercase letter-spacing-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <!-- HANDLE DRAG CATEGORY -->
                                                        <i class="ti ti-grip-vertical text-warning fs-18 handle-category me-2 cursor-pointer" title="Geser untuk memindahkan SELURUH Kategori ini beserta isinya"></i>
                                                        <i class="ti ti-folder me-1 text-warning fs-16"></i> Kategori: {{ $category }}
                                                    </div>
                                                    <div class="form-check form-switch m-0 me-3" title="Aktifkan / Nonaktifkan Seluruh Menu di Kategori Ini">
                                                        <input class="form-check-input switch-toggle-status" type="checkbox"
                                                            data-type="category"
                                                            data-category="{{ $category }}"
                                                            data-cat-slug="{{ $catSlug }}"
                                                            {{ $allCatActive ? 'checked' : '' }}>
                                                        <label class="form-check-label text-white fs-12 ms-1 fw-normal">Switch Kategori</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        @foreach ($categoryMenus as $menuIndex => $menu)
                                            @php
                                                $parentTarget = $menu->getPermissionTarget();
                                            @endphp
                                            <!-- PARENT MENU ROW -->
                                            <tr class="parent-menu-row table-primary-subtle fw-semibold" data-id="{{ $menu->id }}" data-category="{{ $category }}">
                                                <td class="text-center">
                                                    <!-- HANDLE DRAG PARENT MENU -->
                                                    <i class="ti ti-menu-2 text-primary fs-16 handle-parent me-1 cursor-pointer" title="Geser untuk memindahkan Menu Utama ini beserta sub-menunya"></i>
                                                    <span class="order-number">{{ $loop->iteration }}</span>
                                                </td>
                                                <td>
                                                    @if ($menu->icon)
                                                        <i class="{{ $menu->icon }} me-1 fs-18"></i>
                                                    @endif
                                                    {{ $menu->name }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch" title="Aktifkan / Nonaktifkan Menu Utama Ini Beserta Sub-menunya">
                                                        <input class="form-check-input switch-toggle-status switch-parent-{{ $menu->id }} cat-group-{{ $catSlug }}"
                                                            type="checkbox"
                                                            data-type="parent"
                                                            data-id="{{ $menu->id }}"
                                                            data-cat-slug="{{ $catSlug }}"
                                                            {{ $menu->active ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-1 fs-12 status-label-{{ $menu->id }}">{{ $menu->active ? 'Aktif' : 'Nonaktif' }}</label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @can('read ' . $parentTarget)
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-menu-action" data-action="view" data-menu='@json($menu)' title="Detail"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update ' . $parentTarget)
                                                        <button type="button" class="btn btn-sm btn-outline-warning btn-menu-action" data-action="edit" data-menu='@json($menu)' title="Edit"><i class="ti ti-edit"></i></button>
                                                    @endcan
                                                    @can('delete ' . $parentTarget)
                                                        <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini beserta seluruh sub-menunya?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>

                                            <!-- SUB-MENU ROWS -->
                                            @foreach ($menu->subMenus as $child)
                                                @php
                                                    $childTarget = $child->getPermissionTarget();
                                                @endphp
                                                <tr class="submenu-row child-of-{{ $menu->id }}" data-id="{{ $child->id }}" data-parent-id="{{ $menu->id }}">
                                                    <td class="text-center text-muted fs-12">
                                                        <!-- HANDLE DRAG SUB-MENU -->
                                                        <i class="ti ti-dots-vertical text-secondary fs-14 handle-submenu me-1 cursor-pointer" title="Geser untuk mengurutkan Sub-menu ini di dalam menu utamanya"></i>
                                                        <span class="order-number">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td class="ps-4">
                                                        <span class="text-muted me-1">└─</span>
                                                        @if ($child->icon)
                                                            <i class="{{ $child->icon }} me-1 fs-16"></i>
                                                        @endif
                                                        {{ $child->name }}
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input switch-toggle-status child-of-{{ $menu->id }} cat-group-{{ $catSlug }}"
                                                                type="checkbox"
                                                                data-type="submenu"
                                                                data-id="{{ $child->id }}"
                                                                data-parent-id="{{ $menu->id }}"
                                                                data-cat-slug="{{ $catSlug }}"
                                                                {{ $child->active ? 'checked' : '' }}>
                                                            <label class="form-check-label ms-1 fs-12 status-label-{{ $child->id }}">{{ $child->active ? 'Aktif' : 'Nonaktif' }}</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @can('read ' . $childTarget)
                                                            <button type="button" class="btn btn-sm btn-outline-info btn-menu-action" data-action="view" data-menu='@json($child)' title="Detail"><i class="ti ti-eye"></i></button>
                                                        @endcan
                                                        @can('update ' . $childTarget)
                                                            <button type="button" class="btn btn-sm btn-outline-warning btn-menu-action" data-action="edit" data-menu='@json($child)' title="Edit"><i class="ti ti-edit"></i></button>
                                                        @endcan
                                                        @can('delete ' . $childTarget)
                                                            <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sub-menu ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                <!-- LEVEL 3 SUB-MENUS -->
                                                @if ($child->subMenus && $child->subMenus->count() > 0)
                                                    @foreach ($child->subMenus as $subChild)
                                                        @php
                                                            $subChildTarget = $subChild->getPermissionTarget();
                                                        @endphp
                                                        <tr class="submenu-row child-of-{{ $child->id }}" data-id="{{ $subChild->id }}" data-parent-id="{{ $child->id }}">
                                                            <td class="text-center text-muted fs-12">
                                                                <i class="ti ti-dots-vertical text-secondary fs-14 handle-submenu me-1 cursor-pointer" title="Geser untuk mengurutkan Sub-menu ini"></i>
                                                                <span class="order-number">{{ $loop->iteration }}</span>
                                                            </td>
                                                            <td class="ps-5">
                                                                <span class="text-muted me-1">└─ └─</span>
                                                                @if ($subChild->icon)
                                                                    <i class="{{ $subChild->icon }} me-1 fs-16"></i>
                                                                @endif
                                                                {{ $subChild->name }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input switch-toggle-status child-of-{{ $child->id }} cat-group-{{ $catSlug }}"
                                                                        type="checkbox"
                                                                        data-type="submenu"
                                                                        data-id="{{ $subChild->id }}"
                                                                        data-parent-id="{{ $child->id }}"
                                                                        data-cat-slug="{{ $catSlug }}"
                                                                        {{ $subChild->active ? 'checked' : '' }}>
                                                                    <label class="form-check-label ms-1 fs-12 status-label-{{ $subChild->id }}">{{ $subChild->active ? 'Aktif' : 'Nonaktif' }}</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                @can('read ' . $subChildTarget)
                                                                    <button type="button" class="btn btn-sm btn-outline-info btn-menu-action" data-action="view" data-menu='@json($subChild)' title="Detail"><i class="ti ti-eye"></i></button>
                                                                @endcan
                                                                @can('update ' . $subChildTarget)
                                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-menu-action" data-action="edit" data-menu='@json($subChild)' title="Edit"><i class="ti ti-edit"></i></button>
                                                                @endcan
                                                                @can('delete ' . $subChildTarget)
                                                                    <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $subChild->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus sub-menu ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                                    </form>
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                @empty
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data yang ditambahkan.</td>
                                        </tr>
                                    </tbody>
                                @endforelse
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR (UNIVERSAL GLOBAL FORMAT) -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Total: <strong id="info-visible-count">{{ $totalMenuCount }}</strong> data
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <ul class="pagination pagination-sm m-0" id="table-pagination">
                                    <li class="page-item disabled" title="Halaman Awal">
                                        <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-left fs-14"></i></a>
                                    </li>
                                    <li class="page-item disabled" title="Sebelumnya">
                                        <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left fs-14"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                    <li class="page-item disabled" title="Berikutnya">
                                        <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right fs-14"></i></a>
                                    </li>
                                    <li class="page-item disabled" title="Halaman Akhir">
                                        <a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-right fs-14"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SINGLE UNIFIED MODAL (CREATE, EDIT, VIEW/SHOW) -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="menuForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalTitle">Menu Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.dukunganaplikasi.partials.menu_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SortableJS Plugin Asset -->
    <script src="{{ asset('assets/plugins/sortablejs/Sortable.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalRows = {{ $totalMenuCount }};

            // Live Instant Search Handler with Info Bar Update
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

            const menuModal = new bootstrap.Modal(document.getElementById('menuModal'));
            const menuForm = document.getElementById('menuForm');
            const modalTitle = document.getElementById('menuModalTitle');
            const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
            const btnSubmitForm = document.getElementById('btnSubmitForm');
            const formInputs = document.querySelectorAll('.menu-input');

            const formIcon = document.getElementById('form_icon');
            const formIconPreview = document.getElementById('form_icon_preview');

            if (formIcon && formIconPreview) {
                formIcon.addEventListener('input', function() {
                    formIconPreview.className = this.value ? this.value : 'ti ti-category';
                });
            }

            function showToast(message, icon = 'success') {
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                    Toast.fire({ icon: icon, title: message });
                }
            }

            function postReorder(type, items, parentId = null) {
                fetch("{{ route('admin.dukunganaplikasi.menu.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: type,
                        items: items,
                        parent_id: parentId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 400);
                    }
                })
                .catch(err => console.error(err));
            }

            // 1. DRAG & DROP LEVEL 1: CATEGORIES
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

            // 2 & 3. DRAG & DROP LEVEL 2 & 3: PARENT MENUS & SUB-MENUS
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

            // AJAX Switch Toggle Handler
            document.querySelectorAll('.switch-toggle-status').forEach(switchInput => {
                switchInput.addEventListener('change', function() {
                    const type = this.getAttribute('data-type');
                    const isChecked = this.checked ? 1 : 0;
                    const menuId = this.getAttribute('data-id');
                    const category = this.getAttribute('data-category');
                    const catSlug = this.getAttribute('data-cat-slug');

                    const originalState = !this.checked;

                    fetch("{{ route('admin.dukunganaplikasi.menu.toggle-status') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            type: type,
                            active: isChecked,
                            id: menuId,
                            category: category
                        })
                    })
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success') {
                            showToast(res.message, 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 400);
                        } else {
                            this.checked = originalState;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        this.checked = originalState;
                    });
                });
            });

            // Action handler for Create, Edit, View
            document.querySelectorAll('.btn-menu-action').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    const menuDataRaw = this.getAttribute('data-menu');
                    const menu = menuDataRaw ? JSON.parse(menuDataRaw) : null;

                    menuForm.reset();
                    methodSpoofingContainer.innerHTML = '';

                    document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);
                    document.querySelectorAll('.role-checkbox').forEach(cb => {
                        cb.checked = (cb.value === 'superadmin' || cb.value === 'admin');
                    });

                    formInputs.forEach(input => input.disabled = false);
                    btnSubmitForm.classList.remove('d-none');

                    if (action === 'create') {
                        modalTitle.innerHTML = '<i class="ti ti-plus me-1"></i> Tambah Menu Baru';
                        menuForm.action = "{{ route('admin.dukunganaplikasi.menu.store') }}";
                        btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Menu';
                        document.getElementById('form_orders').value = 0;
                        document.getElementById('form_active').checked = true;
                        if (formIconPreview) formIconPreview.className = 'ti ti-category';

                    } else if (action === 'edit' && menu) {
                        modalTitle.innerHTML = `<i class="ti ti-edit me-1"></i> Edit Menu: ${menu.name}`;
                        menuForm.action = `{{ url('admin/dukunganaplikasi/menu') }}/${menu.id}`;
                        methodSpoofingContainer.innerHTML = '@method("PUT")';
                        btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Menu';
                        populateForm(menu);

                    } else if (action === 'view' && menu) {
                        modalTitle.innerHTML = `<i class="ti ti-eye me-1"></i> Detail Menu: ${menu.name}`;
                        menuForm.action = '#';
                        btnSubmitForm.classList.add('d-none');
                        populateForm(menu);
                        formInputs.forEach(input => input.disabled = true);
                    }

                    menuModal.show();
                });
            });

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
                } else {
                    document.querySelectorAll('.action-checkbox').forEach(cb => cb.checked = true);
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

                const checkedRoles = document.querySelectorAll('.role-checkbox:checked');
                if (checkedRoles.length === 0) {
                    document.querySelectorAll('.role-checkbox').forEach(cb => {
                        cb.checked = (cb.value === 'superadmin' || cb.value === 'admin');
                    });
                }

                if (formIconPreview) {
                    formIconPreview.className = menu.icon ? menu.icon : 'ti ti-category';
                }
            }
        });
    </script>
@endsection
