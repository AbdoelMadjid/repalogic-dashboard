@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/translation.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h4 class="card-title mb-1 text-dark">Manajemen Terjemahan Bahasa (Modular Bilingual i18n)</h4>
                            <p class="text-muted fs-13 mb-0">Kelola kamus terjemahan modular yang terbagi dalam domain: Sidebar Template, Menu Dinamis, Topbar, Auth, Customizer, dan Landing Page.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#bilingualGuideModal">
                                <i class="ti ti-help-circle me-1"></i> Petunjuk Bilingual
                            </button>
                            @can('create dukunganaplikasi/translation')
                                <button type="button" class="btn btn-primary btn-translation-action" data-action="create" data-module="{{ $activeModule !== 'all' ? $activeModule : 'sidebar_menu' }}">
                                    <i class="ti ti-plus me-1"></i> Tambah Key Terjemahan
                                </button>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- NAV PILLS / MODULAR DOMAIN TABS -->
                        <ul class="nav nav-pills nav-justified mb-3 p-1 bg-light rounded gap-1 flex-wrap" id="translationTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="javascript:void(0);" class="nav-link translation-tab-filter py-2 {{ $activeModule === 'all' ? 'active' : '' }}" data-tab-module="all">
                                    <i class="ti ti-folders me-1"></i> Semua Domain
                                    <span class="badge bg-secondary-subtle text-dark border ms-1 fs-11">{{ $moduleCounts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            @foreach ($modules as $modKey => $modInfo)
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link translation-tab-filter py-2 {{ $activeModule === $modKey ? 'active' : '' }}" data-tab-module="{{ $modKey }}">
                                        <i class="{{ $modInfo['icon'] }} me-1"></i> {{ $modInfo['name'] }}
                                        <span class="badge {{ $modInfo['badge'] }} border ms-1 fs-11">{{ $moduleCounts[$modKey] ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <!-- HEADER CONTROLS (PAGE SIZE & LIVE SEARCH) -->
                        <div class="row align-items-center mb-3 g-2">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>
                            <div class="col-md-8 d-flex justify-content-md-end">
                                <div class="d-flex align-items-center w-100 justify-content-md-end" style="max-width: 400px;">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-search me-1"></i> Cari Key / Teks:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik kata kunci...">
                                </div>
                            </div>
                        </div>

                        <!-- TRANSLATION TABLE -->
                        <div class="table-responsive">
                            <table id="translation-table" class="table table-hover table-bordered align-middle w-100 mb-0">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr>
                                        <th style="width: 50px;" class="align-middle text-center text-nowrap">NO</th>
                                        <th style="width: 200px;" class="align-middle text-center text-nowrap">MODUL / DOMAIN</th>
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
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada key terjemahan yang dibuat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ count($translations) }}</strong> data terjemahan
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <ul class="pagination pagination-sm m-0" id="table-pagination"></ul>
                            </div>
                        </div>
                    </div>
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
            routes: {
                store: "{{ route('admin.dukunganaplikasi.translation.store') }}",
                updateTemplate: "{{ route('admin.dukunganaplikasi.translation.update', ':key') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/translation.js') }}"></script>
    @include('admin.dukunganaplikasi.partials.bilingual_guide_modal')
@endsection
