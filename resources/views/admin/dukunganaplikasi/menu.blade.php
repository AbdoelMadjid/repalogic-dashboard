@extends('layouts.vertical', ['title' => 'Manajemen Menu'])

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/menu.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Dukungan Aplikasi', 'title' => 'Manajemen Menu'])
    <div class="container-fluid mt-2">
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
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#bilingualGuideModal">
                                <i class="ti ti-help-circle me-1"></i> Petunjuk Bilingual
                            </button>
                            @can('create dukunganaplikasi/menu')
                                <button type="button" class="btn btn-primary btn-sm btn-menu-action" data-action="create">
                                    <i class="ti ti-plus me-1"></i> Tambah Menu Baru
                                </button>
                            @endcan
                        </div>
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
                                    foreach ($m->subMenus as $sub) {
                                        $totalMenuCount += $sub->subMenus->count();
                                    }
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
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 60px;" class="text-center align-middle text-nowrap">Urutan</th>
                                        <th class="text-center align-middle text-nowrap">Nama Menu</th>
                                        <th class="text-center align-middle text-nowrap">URL</th>
                                        <th style="width: 150px;" class="text-center align-middle text-nowrap">Status / Switch</th>
                                        <th style="width: 170px;" class="text-center align-middle text-nowrap">Aksi</th>
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
                                                foreach ($sub->subMenus as $subChild) {
                                                    if (!$subChild->active) { $allCatActive = false; break; }
                                                }
                                            }
                                        }
                                    @endphp
                                    <!-- CATEGORY BLOCK CONTAINER (DRAGGABLE ENTIRE CATEGORY BLOCK) -->
                                    <tbody class="category-block" data-category="{{ $category }}" data-cat-slug="{{ $catSlug }}">
                                        <!-- CATEGORY HEADER ROW -->
                                        <tr class="category-header-row table-dark">
                                            <td colspan="5" class="fw-bold py-2 text-uppercase letter-spacing-1">
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
                                                $menuUrl = $menu->getRealUrl();
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
                                                    @if ($menuUrl)
                                                        <span class="text-primary font-monospace fs-12"><i class="ti ti-world me-1 text-muted"></i>{{ $menuUrl }}</span>
                                                    @else
                                                        <span class="text-muted fs-12 fst-italic">(Header Parent)</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-switch d-inline-flex align-items-center" title="Aktifkan / Nonaktifkan Menu Utama Ini Beserta Sub-menunya">
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
                                                        <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $menu->id) }}" method="POST" class="d-inline" data-confirm="Hapus menu ini beserta seluruh sub-menunya?">
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
                                                    $childUrl = $child->getRealUrl();
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
                                                        @if ($childUrl)
                                                            <span class="text-primary font-monospace fs-12"><i class="ti ti-world me-1 text-muted"></i>{{ $childUrl }}</span>
                                                        @else
                                                            <span class="text-muted fs-12 fst-italic">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch d-inline-flex align-items-center">
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
                                                            <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $child->id) }}" method="POST" class="d-inline" data-confirm="Hapus sub-menu ini beserta seluruh anak menu di bawahnya?">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                </tr>

                                                <!-- SUB-MENU LEVEL 3 ROWS -->
                                                @foreach ($child->subMenus as $subChild)
                                                    @php
                                                        $subChildTarget = $subChild->getPermissionTarget();
                                                        $subChildUrl = $subChild->getRealUrl();
                                                    @endphp
                                                    <tr class="submenu-row child-of-{{ $child->id }} child-of-{{ $menu->id }}" data-id="{{ $subChild->id }}" data-parent-id="{{ $child->id }}">
                                                        <td class="text-center text-muted fs-12">
                                                            <!-- HANDLE DRAG SUB-MENU LEVEL 3 -->
                                                            <i class="ti ti-dots-vertical text-secondary fs-14 handle-submenu me-1 cursor-pointer" title="Geser untuk mengurutkan Sub-menu Level 3 ini"></i>
                                                            <span class="order-number">{{ $loop->iteration }}</span>
                                                        </td>
                                                        <td class="ps-5">
                                                            <span class="text-muted me-1 font-monospace fs-12">└─ └─</span>
                                                            @if ($subChild->icon)
                                                                <i class="{{ $subChild->icon }} me-1 fs-16"></i>
                                                            @endif
                                                            {{ $subChild->name }}
                                                        </td>
                                                        <td>
                                                            @if ($subChildUrl)
                                                                <span class="text-primary font-monospace fs-12"><i class="ti ti-world me-1 text-muted"></i>{{ $subChildUrl }}</span>
                                                            @else
                                                                <span class="text-muted fs-12 fst-italic">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check form-switch d-inline-flex align-items-center">
                                                                <input class="form-check-input switch-toggle-status child-of-{{ $child->id }} child-of-{{ $menu->id }} cat-group-{{ $catSlug }}"
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
                                                                <form action="{{ route('admin.dukunganaplikasi.menu.destroy', $subChild->id) }}" method="POST" class="d-inline" data-confirm="Hapus sub-menu level 3 ini?">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                @empty
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data yang ditambahkan.</td>
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

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.MenuConfig = {
            totalMenuCount: {{ $totalMenuCount }},
            routes: {
                reorder: "{{ route('admin.dukunganaplikasi.menu.reorder') }}",
                toggleStatus: "{{ route('admin.dukunganaplikasi.menu.toggle-status') }}",
                store: "{{ route('admin.dukunganaplikasi.menu.store') }}",
                base: "{{ url('admin/dukunganaplikasi/menu') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/menu.js') }}"></script>
    @include('admin.dukunganaplikasi.partials.bilingual_guide_modal')
@endsection
