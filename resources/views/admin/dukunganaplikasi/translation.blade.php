@extends('layouts.vertical')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/translation.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h4 class="card-title mb-1">Manajemen Terjemahan Bahasa (Bilingual i18n)</h4>
                            <p class="text-muted fs-13 mb-0">Kelola key terjemahan dikelompokkan berdasarkan **Sidebar Menu** dan **Label Komponen** aplikasi.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#bilingualGuideModal">
                                <i class="ti ti-help-circle me-1"></i> Petunjuk Bilingual
                            </button>
                            @can('create dukunganaplikasi/translation')
                                <button type="button" class="btn btn-primary btn-translation-action" data-action="create">
                                    <i class="ti ti-plus me-1"></i> Tambah Key Terjemahan
                                </button>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- HEADER CONTROLS (CATEGORY FILTER, PAGE SIZE & LIVE SEARCH) -->
                        <div class="row align-items-center mb-3 g-2">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0 text-nowrap"><i class="ti ti-filter me-1"></i> Kelompok Sidebar:</label>
                                <select id="table-category-select" class="form-select form-select-sm">
                                    <option value="all">-- Semua Kelompok Sidebar --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>
                            <div class="col-md-5 d-flex justify-content-md-end">
                                <div class="d-flex align-items-center w-100 justify-content-md-end">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Key / Teks:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik kata kunci...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="translation-table" class="table table-hover table-bordered align-middle w-100">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr>
                                        <th style="width: 50px;">NO</th>
                                        <th>KEY TERJEMAHAN (DATA-LANG)</th>
                                        <th>POSISI / LABEL SIDEBAR</th>
                                        <th>BAHASA INDONESIA (ID)</th>
                                        <th>BAHASA INGGRIS (EN)</th>
                                        <th style="width: 120px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedTranslations as $groupName => $items)
                                        <!-- GROUP HEADER ROW -->
                                        <tr class="category-header-row bg-light-subtle text-primary border-primary-subtle" data-group="{{ $groupName }}">
                                            <td colspan="6" class="fw-bold py-2 fs-13">
                                                <i class="ti ti-folder-check me-2 fs-16 text-primary"></i> {{ strtoupper($groupName) }}
                                                <span class="badge bg-primary-subtle text-primary border ms-2 fs-11">{{ count($items) }} Terjemahan</span>
                                            </td>
                                        </tr>

                                        @foreach ($items as $item)
                                            <tr class="translation-row" data-group="{{ $groupName }}">
                                                <td class="text-center fw-semibold text-muted translation-no">{{ $loop->iteration }}</td>
                                                <td>
                                                    <code class="bg-light text-primary border px-2 py-1 rounded fs-12 fw-semibold">{{ $item['key'] }}</code>
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeColor = match(true) {
                                                            str_contains($item['label'], 'Group Header') => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                                            str_contains($item['label'], 'Menu Utama') => 'bg-primary-subtle text-primary border-primary-subtle',
                                                            str_contains($item['label'], 'Sub-Menu') => 'bg-info-subtle text-info border-info-subtle',
                                                            str_contains($item['label'], 'Menu Item') => 'bg-success-subtle text-success border-success-subtle',
                                                            default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeColor }} border fs-11">
                                                        <i class="ti ti-tag me-1"></i>{{ $item['label'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-dark fw-medium">{{ $item['text_id'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted fst-italic">{{ $item['text_en'] }}</span>
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    @can('read dukunganaplikasi/translation')
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-translation-action me-1" data-action="view" data-row='@json($item)' title="Detail"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update dukunganaplikasi/translation')
                                                        <button type="button" class="btn btn-sm btn-outline-warning btn-translation-action me-1" data-action="edit" data-row='@json($item)' title="Edit"><i class="ti ti-edit"></i></button>
                                                    @endcan
                                                    @can('delete dukunganaplikasi/translation')
                                                        <form action="{{ route('admin.dukunganaplikasi.translation.destroy', urlencode($item['key'])) }}" method="POST" class="d-inline" data-confirm="Hapus key terjemahan &quot;{{ $item['key'] }}&quot; ini dari file JSON?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="ti ti-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada key terjemahan yang dibuat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Total: <strong>{{ count($translations) }}</strong> data terjemahan
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="translationForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="translationModalTitle">Form Key Terjemahan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @include('admin.dukunganaplikasi.partials.translation_form')
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Terjemahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.TranslationConfig = {
            routes: {
                store: "{{ route('admin.dukunganaplikasi.translation.store') }}",
                updateTemplate: "{{ route('admin.dukunganaplikasi.translation.update', ':key') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/translation.js') }}"></script>
    @include('admin.dukunganaplikasi.partials.bilingual_guide_modal')
@endsection
