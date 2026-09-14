@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/translation.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title')

    <div class="outlook-box">
        <!-- LEFT SIDEBAR: DOMAIN KAMUS & NAVIGASI -->
        <div class="offcanvas-lg offcanvas-start outlook-left-menu outlook-left-menu-md" tabindex="-1" id="translationSidebaroffcanvas">
            <div class="card h-100 mb-0 rounded-end-0 d-flex flex-column">
                <div class="card-body p-3 flex-grow-1 d-flex flex-column" id="translation-sidebar-scroll-container">
                    <button type="button" class="btn btn-outline-info fw-medium w-100 flex-shrink-0" data-bs-toggle="modal" data-bs-target="#bilingualGuideModal" title="Petunjuk Lengkap Bilingual i18n">
                        <i class="ti ti-help-circle me-1.5 align-middle fs-base"></i>
                        <span class="align-middle">Petunjuk Lengkap</span>
                    </button>

                    <div class="list-group list-group-flush list-custom mt-3">
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action translation-tab-filter {{ $activeModule === 'all' ? 'active' : '' }}" data-tab-module="all">
                            <i class="ti ti-folders me-1.5 opacity-75 fs-lg align-middle"></i>
                            <span class="align-middle flex-grow-1 text-truncate">Semua Domain</span>
                            <span class="badge align-middle bg-primary-subtle text-primary border fs-xxs float-end ms-1">{{ $moduleCounts['all'] ?? 0 }}</span>
                        </a>

                        <div class="list-group-item mt-2 text-uppercase fs-xxs fw-bold text-muted font-monospace py-2">
                            <span class="align-middle">Domain Kamus i18n</span>
                        </div>

                        @foreach ($modules as $modKey => $modInfo)
                            <a href="javascript:void(0);" class="list-group-item list-group-item-action translation-tab-filter {{ $activeModule === $modKey ? 'active' : '' }}" data-tab-module="{{ $modKey }}">
                                <i class="{{ $modInfo['icon'] }} me-1.5 opacity-75 fs-lg align-middle"></i>
                                <span class="align-middle flex-grow-1 text-truncate" title="{{ $modInfo['name'] }}">{{ $modInfo['name'] }}</span>
                                <span class="badge align-middle {{ $modInfo['badge'] }} border fs-xxs float-end ms-1">{{ $moduleCounts[$modKey] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT MAIN CONTENT: DAFTAR TERJEMAHAN & PENCARIAN -->
        <div class="card h-100 mb-0 rounded-start-0 flex-grow-1 border-start-0 d-flex flex-column overflow-hidden">
            <div class="card-header bg-white py-2.5 px-3 border-bottom justify-content-between d-flex flex-wrap align-items-center gap-2 flex-shrink-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-lg-none d-inline-flex">
                        <button class="btn btn-default btn-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#translationSidebaroffcanvas" aria-controls="translationSidebaroffcanvas" title="Buka Menu Modul">
                            <i class="ti ti-menu-4 fs-lg"></i>
                        </button>
                    </div>

                    <div>
                        <h5 class="card-title text-dark mb-0 d-flex align-items-center gap-2" id="active-domain-title">
                            <i class="ti ti-folders text-primary" id="active-domain-icon"></i>
                            <span id="active-domain-name">Semua Domain Terjemahan</span>
                            <span class="badge bg-primary-subtle text-primary border fs-11" id="active-domain-badge">{{ $moduleCounts['all'] ?? 0 }} Key</span>
                        </h5>
                        <p class="text-muted fs-12 mb-0 d-none d-sm-block mt-0.5" id="active-domain-desc">Menampilkan seluruh kamus terjemahan bilingual dari semua domain aplikasi.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                    <!-- Live Search -->
                    <div class="app-search">
                        <input type="search" id="table-search-input" class="form-control form-control-sm" placeholder="Cari key atau teks..." />
                        <i class="ti ti-search app-search-icon text-muted"></i>
                    </div>

                    <!-- Page Size Selector -->
                    <div>
                        <select id="table-length-select" class="form-select form-select-sm" style="min-width: 105px;">
                            <option value="10">10 baris</option>
                            <option value="25" selected>25 baris</option>
                            <option value="50">50 baris</option>
                            <option value="100">100 baris</option>
                            <option value="all">Semua</option>
                        </select>
                    </div>

                    @can('create dukunganaplikasi/translation')
                        <button type="button" class="btn btn-sm btn-primary btn-translation-action" id="btn-header-create" data-action="create" data-module="sidebar_menu" title="Tambah Key Terjemahan Baru">
                            <i class="ti ti-plus me-0 me-md-1.5"></i><span class="d-none d-md-inline">Tambah Key Terjemahan</span>
                        </button>
                    @endcan
                </div>
            </div>

            <!-- TABLE CONTENT BODY (DEDICATED INTERNAL SCROLL CONTAINER) -->
            <div class="card-body p-0 flex-grow-1" id="translation-table-scroll-container">
                <div class="table-responsive mb-0">
                    <table id="translation-table" class="table table-hover table-bordered align-middle w-100 mb-0">
                        <thead class="table-light align-middle text-center text-nowrap">
                            <tr>
                                <th style="width: 50px;" class="align-middle text-center text-nowrap">NO</th>
                                <th style="width: 190px;" class="align-middle text-center text-nowrap">MODUL / DOMAIN</th>
                                <th class="align-middle text-center text-nowrap">KEY TERJEMAHAN (DATA-LANG)</th>
                                <th class="align-middle text-center text-nowrap">BAHASA INDONESIA (ID)</th>
                                <th class="align-middle text-center text-nowrap">BAHASA INGGRIS (EN)</th>
                                <th style="width: 120px;" class="align-middle text-center text-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($translations as $item)
                                <tr class="translation-row" data-module="{{ $item['module'] }}">
                                    <td class="text-center fw-semibold text-muted translation-no align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle text-center text-nowrap">
                                        <span class="badge {{ $item['module_badge'] }} border fs-11">
                                            <i class="{{ $item['module_icon'] }} me-1"></i>{{ $item['module_name'] }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <code class="bg-light text-primary border px-2 py-1 rounded fs-12 fw-semibold">{{ $item['key'] }}</code>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-dark fw-medium">{{ $item['text_id'] }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-muted fst-italic">{{ $item['text_en'] }}</span>
                                    </td>
                                    <td class="text-center text-nowrap align-middle">
                                        @can('read dukunganaplikasi/translation')
                                            <button type="button" class="btn btn-sm btn-outline-info btn-translation-action me-1" data-action="view" data-row='@json($item)' title="Detail"><i class="ti ti-eye"></i></button>
                                        @endcan
                                        @can('update dukunganaplikasi/translation')
                                            <button type="button" class="btn btn-sm btn-outline-warning btn-translation-action me-1" data-action="edit" data-row='@json($item)' title="Edit"><i class="ti ti-edit"></i></button>
                                        @endcan
                                        @can('delete dukunganaplikasi/translation')
                                            <form action="{{ route('admin.dukunganaplikasi.translation.destroy', urlencode($item['key'])) }}" method="POST" class="d-inline" data-confirm="Hapus key terjemahan &quot;{{ $item['key'] }}&quot; dari modul {{ $item['module_name'] }}?">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="module" value="{{ $item['module'] }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-state-row">
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <div class="text-center py-3">
                                            <i class="ti ti-language-off fs-1 text-muted opacity-50 mb-2 d-block"></i>
                                            <h6 class="text-dark mb-1">Belum ada data terjemahan</h6>
                                            <p class="text-muted fs-12 mb-0">Klik tombol Tambah Key Terjemahan untuk menambahkan kamus baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FOOTER INFO & PAGINATION -->
            <div class="card-footer bg-white border-top py-2.5 px-3 d-flex flex-wrap align-items-center justify-content-between gap-2 flex-shrink-0">
                <div class="fs-13 text-muted" id="table-info-bar">
                    Menampilkan <strong>{{ count($translations) }}</strong> data terjemahan
                </div>
                <div>
                    <ul class="pagination pagination-sm m-0" id="table-pagination"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FORM TERJEMAHAN -->
    <div class="modal fade" id="translationModal" tabindex="-1" aria-labelledby="translationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="translationForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title text-white" id="translationModalTitle"><i class="ti ti-language me-1"></i> Form Key Terjemahan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        @include('admin.dukunganaplikasi.partials.translation_form')
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Terjemahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.TranslationConfig = {
            activeModule: "{{ $activeModule }}",
            modules: @json($modules),
            moduleCounts: @json($moduleCounts),
            routes: {
                store: "{{ route('admin.dukunganaplikasi.translation.store') }}",
                updateTemplate: "{{ route('admin.dukunganaplikasi.translation.update', ':key') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/translation.js') }}"></script>
    @include('admin.dukunganaplikasi.partials.bilingual_guide_modal')
@endsection
