@extends('layouts.vertical')

@section('title', 'Konfigurasi Website & Engine Tema')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/konfigurasi-website.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Dukungan Aplikasi', 'title' => 'Konfigurasi Website'])

    <div class="container-fluid mt-2">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">
                    <i class="ti ti-layout-web text-primary me-2"></i> Konfigurasi Website &amp; Engine Tema
                </h4>
                <p class="text-muted fs-13 mb-0">Kelola identitas tema tampilan depan (landing page), urutan seksi halaman, dan menu navigasi navbar secara dinamis.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary fw-semibold px-3">
                    <i class="ti ti-external-link me-1"></i> Pratinjau Website Utama
                </a>
            </div>
        </div>

        <!-- Alert Status Tema Aktif -->
        @if ($activeTheme)
            <div class="alert alert-primary border-primary-subtle d-flex align-items-center justify-content-between mb-4 shadow-sm">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-md bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                        <i class="ti ti-browser fs-24"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-primary-emphasis">Tema Aktif Sekarang: {{ $activeTheme->name }}</h6>
                        <p class="fs-12 text-muted mb-0">
                            File template Blade dimuat dari folder: <code class="bg-primary-subtle text-primary px-2 py-0.5 rounded font-monospace">resources/views/website/{{ $activeTheme->folder }}/</code> | Total Seksi: <strong>{{ $activeTheme->sections->count() }} Seksi</strong>
                        </p>
                    </div>
                </div>
                <span class="badge bg-success px-3 py-2 fs-12 fw-bold font-monospace">TEMA UTAMA AKTIF</span>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <!-- 1. Widget Daftar Identitas Tema Website -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="card-title text-white mb-0 fw-bold">
                            <i class="ti ti-palette me-1"></i> Daftar Identitas Tema Website
                        </h5>
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold px-3 btn-tambah-tema">
                            <i class="ti ti-plus me-1"></i> Tambah Tema Baru
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @forelse ($themes as $th)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border {{ $th->id == ($activeTheme->id ?? 0) ? 'border-primary shadow-sm bg-primary-subtle' : 'border-gray-200' }} h-100 position-relative">
                                        <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="fw-bold text-dark mb-0 fs-15">{{ $th->name }}</h6>
                                                    @if ($th->is_active)
                                                        <span class="badge bg-success text-white px-2 py-1 fs-11">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary-subtle text-dark px-2 py-1 fs-11">Non-Aktif</span>
                                                    @endif
                                                </div>
                                                <p class="fs-12 text-muted mb-2">
                                                    <i class="ti ti-folder me-1 text-primary"></i> Folder: <code class="text-dark font-monospace">website/{{ $th->folder }}/</code>
                                                </p>
                                                <p class="fs-13 text-muted mb-3">
                                                    {{ $th->description ?: 'Tidak ada catatan deskripsi tema.' }}
                                                </p>
                                            </div>

                                            <div class="pt-3 border-top d-flex align-items-center justify-content-between gap-2">
                                                <span class="fs-12 text-muted">
                                                    <i class="ti ti-layers-subtract me-1"></i> {{ $th->sections->count() }} Seksi
                                                </span>
                                                <div class="d-flex align-items-center gap-1">
                                                    @if (!$th->is_active)
                                                        <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.activate-theme', $th->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success px-2 py-1 fs-12 fw-semibold" title="Aktifkan Tema Ini">
                                                                <i class="ti ti-circle-check me-1"></i> Aktifkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('admin.dukunganaplikasi.konfigurasi-website.index', ['theme_id' => $th->id]) }}" class="btn btn-sm {{ $th->id == ($activeTheme->id ?? 0) ? 'btn-primary' : 'btn-outline-primary' }} px-2 py-1 fs-12 fw-semibold">
                                                        <i class="ti ti-settings me-1"></i> Kelola Seksi
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 fs-12 btn-edit-tema" 
                                                        data-theme-id="{{ $th->id }}"
                                                        data-theme-name="{{ $th->name }}"
                                                        data-theme-folder="{{ $th->folder }}"
                                                        data-theme-description="{{ $th->description }}">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-4 text-muted">Belum ada tema website yang terdaftar.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Widget Pengaturan Seksi Halaman & Navigation Menu -->
            @if ($activeTheme)
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti ti-list-check fs-20 text-primary"></i>
                                <h5 class="card-title text-dark mb-0 fw-bold">
                                    Kelola Seksi Halaman &amp; Menu Navigasi (Tema: <span class="text-primary">{{ $activeTheme->name }}</span>)
                                </h5>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-info btn-sm fw-semibold px-3 btn-panduan-seksi">
                                    <i class="ti ti-book me-1"></i> Panduan Standarisasi Seksi
                                </button>
                                <button type="button" class="btn btn-primary btn-sm fw-semibold px-3 btn-tambah-seksi">
                                    <i class="ti ti-plus me-1"></i> Tambah Seksi Halaman
                                </button>
                            </div>
                        </div>
                        <div class="alert alert-info border-0 rounded-0 mb-0 py-2 px-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 fs-13">
                                <i class="ti ti-info-circle fs-16 text-info"></i>
                                <span><strong>Standarisasi Seksi:</strong> Gunakan tag murni <code>&lt;section class="section-custom" id="..."&gt;</code> di file Blade. Latar belakang &amp; kontras teks dikelola dinamis via sistem.</span>
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-info p-0 fw-semibold text-decoration-none btn-panduan-seksi">
                                Lihat Panduan Complete <i class="ti ti-arrow-right"></i>
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.reorder-sections') }}" method="POST" id="form-reorder-sections">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light align-middle text-center text-nowrap">
                                            <tr class="align-middle text-center text-nowrap">
                                                <th class="text-center align-middle text-nowrap" style="width: 80px;"><i class="ti ti-arrows-sort me-1"></i> Urutan</th>
                                                <th class="text-start align-middle text-nowrap">Nama Seksi Halaman</th>
                                                <th class="text-start align-middle text-nowrap">File Blade Template</th>
                                                <th class="text-start align-middle text-nowrap">Anchor Target (#id)</th>
                                                <th class="text-center align-middle text-nowrap">Menu Navbar</th>
                                                <th class="text-center align-middle text-nowrap">Status Seksi</th>
                                                <th class="text-center align-middle text-nowrap">Gaya Latar (Background)</th>
                                                <th class="text-center align-middle text-nowrap" style="width: 100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable-sections-list">
                                            @forelse ($activeTheme->sections as $sec)
                                                <tr class="section-row" data-id="{{ $sec->id }}">
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex align-items-center justify-content-center gap-1.5">
                                                            <span class="drag-handle-section text-muted cursor-grab p-1" title="Drag & drop untuk mengubah urutan seksi">
                                                                <i class="ti ti-menu-2 fs-18"></i>
                                                            </span>
                                                            <span class="badge bg-light text-dark fw-bold font-monospace border px-2 py-1 order-badge fs-12">
                                                                {{ $sec->orders }}
                                                            </span>
                                                            <input type="hidden" name="orders[{{ $sec->id }}]" value="{{ $sec->orders }}" class="order-input">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle fw-semibold text-dark">
                                                        {{ $sec->section_name }}
                                                        @if ($sec->nav_title)
                                                            <span class="fs-12 text-muted d-block fw-normal">(Navbar: "{{ $sec->nav_title }}")</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle font-monospace text-primary fs-12">
                                                        website/{{ $activeTheme->folder }}/{{ $sec->section_file }}
                                                    </td>
                                                    <td class="align-middle font-monospace text-muted fs-12">
                                                        #{{ $sec->target_id ?: $sec->section_key }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @if ($sec->show_in_nav)
                                                            <span class="badge bg-info-subtle text-info px-2 py-1"><i class="ti ti-eye me-1"></i> Tampil</span>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-muted px-2 py-1"><i class="ti ti-eye-off me-1"></i> Sembunyi</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.toggle-active-section', $sec->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm border-0 bg-transparent p-0" title="Klik untuk Ubah Status">
                                                                @if ($sec->is_active)
                                                                    <span class="badge bg-success-subtle text-success px-2 py-1.5 fs-12"><i class="ti ti-check me-1"></i> Aktif</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger px-2 py-1.5 fs-12"><i class="ti ti-x me-1"></i> Non-Aktif</span>
                                                                @endif
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        @php
                                                            $bgBadges = [
                                                                'default'   => ['bg-secondary-subtle text-secondary', 'section-custom'],
                                                                'light'     => ['bg-light text-dark border', 'light soft'],
                                                                'secondary' => ['bg-secondary text-white', 'body-secondary'],
                                                                'dark'      => ['bg-dark text-white', 'bg-dark'],
                                                                'primary'   => ['bg-primary text-white', 'bg-primary'],
                                                                'image'     => ['bg-info text-white', 'background-image'],
                                                            ];
                                                            $bgTypeKey = $sec->bg_type ?? 'default';
                                                            $badgeInfo = $bgBadges[$bgTypeKey] ?? $bgBadges['default'];
                                                        @endphp
                                                        <span class="badge {{ $badgeInfo[0] }} px-2 py-1 font-monospace fs-11">
                                                            {{ $badgeInfo[1] }}
                                                        </span>
                                                        @if ($bgTypeKey === 'image' && $sec->bg_image)
                                                            <div class="mt-1 d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                                                <div class="border rounded p-0.5 bg-white shadow-sm overflow-hidden cursor-pointer btn-preview-full-img" 
                                                                    style="width: 48px; height: 28px;" 
                                                                    title="Klik untuk pratinjau & atur posisi"
                                                                    data-section-id="{{ $sec->id }}"
                                                                    data-img-url="{{ asset('storage/' . $sec->bg_image) }}"
                                                                    data-section-name="{{ $sec->section_name }}"
                                                                    data-pos-y="{{ $sec->bg_position_y ?? 50 }}"
                                                                    data-bg-size="{{ $sec->bg_size ?? 'cover' }}"
                                                                    data-bg-attachment="{{ $sec->bg_attachment ?? 'scroll' }}"
                                                                    data-img-w="{{ $sec->bg_image_width }}"
                                                                    data-img-h="{{ $sec->bg_image_height }}"
                                                                    data-img-orient="{{ $sec->bg_image_orientation }}">
                                                                    <img src="{{ asset('storage/' . $sec->bg_image) }}" alt="Thumbnail Background" class="w-100 h-100 rounded-1" style="object-fit: cover; object-position: center {{ $sec->bg_position_y ?? 50 }}%;">
                                                                </div>
                                                                <span class="badge bg-primary-subtle text-primary fs-11 font-monospace py-1" title="Posisi Vertikal Gambar">Y: {{ $sec->bg_position_y ?? 50 }}%</span>
                                                                @if ($sec->bg_attachment === 'fixed')
                                                                    <span class="badge bg-warning-subtle text-warning fs-10 font-monospace py-0.5 px-1" title="Efek Paralaks Fixed">✨ Paralaks</span>
                                                                @endif
                                                            </div>
                                                            @if ($sec->bg_image_orientation)
                                                                <span class="fs-10 font-monospace text-muted d-block mt-0.5">
                                                                    {{ $sec->bg_image_orientation === 'portrait' ? '📱 Portrait' : ($sec->bg_image_orientation === 'landscape' ? '🖼️ Landscape' : '⏹️ Square') }}
                                                                    @if ($sec->bg_image_width && $sec->bg_image_height)
                                                                        ({{ $sec->bg_image_width }}x{{ $sec->bg_image_height }}px)
                                                                    @endif
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                                            <button type="button" class="btn btn-sm btn-outline-warning px-2 py-1 btn-edit-seksi"
                                                                data-section-id="{{ $sec->id }}"
                                                                data-section-name="{{ $sec->section_name }}"
                                                                data-section-file="{{ $sec->section_file }}"
                                                                data-nav-title="{{ $sec->nav_title }}"
                                                                data-target-id="{{ $sec->target_id }}"
                                                                data-orders="{{ $sec->orders }}"
                                                                data-bg-type="{{ $sec->bg_type ?? 'default' }}"
                                                                data-bg-image="{{ $sec->bg_image ? asset('storage/' . $sec->bg_image) : '' }}"
                                                                data-bg-position-y="{{ $sec->bg_position_y ?? 50 }}"
                                                                data-is-active="{{ $sec->is_active ? 1 : 0 }}"
                                                                data-show-in-nav="{{ $sec->show_in_nav ? 1 : 0 }}"
                                                                title="Edit Seksi">
                                                                <i class="ti ti-edit"></i>
                                                            </button>
                                                            <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.destroy-section', $sec->id) }}" method="POST" class="d-inline" data-confirm="Apakah Anda yakin ingin menghapus seksi halaman &quot;{{ $sec->section_name }}&quot;?">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Hapus Seksi">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4 text-muted">
                                                        Belum ada seksi halaman yang terdaftar untuk tema ini. Klik <strong>"Tambah Seksi Halaman"</strong> di atas.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if ($activeTheme->sections->isNotEmpty())
                                    <div class="card-footer bg-light p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <span class="fs-13 text-muted d-flex align-items-center gap-1">
                                            <i class="ti ti-arrows-sort text-primary fs-16"></i>
                                            <span>Geser ikon baris (<i class="ti ti-menu-2 fs-14"></i>) untuk mengubah urutan seksi secara instan (tersimpan otomatis).</span>
                                        </span>
                                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">
                                            <i class="ti ti-check me-1"></i> Simpan Urutan Manual
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Render Modals -->
    @include('admin.dukunganaplikasi.partials.konfigurasi_website_modal_form')
    @include('admin.dukunganaplikasi.partials.konfigurasi_website_modal_petunjuk')
    @include('admin.dukunganaplikasi.partials.konfigurasi_website_modal_tampilgambar')

    <!-- SortableJS Plugin Asset -->
    <script src="{{ asset('assets/plugins/sortablejs/Sortable.min.js') }}"></script>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.KonfigurasiWebsiteConfig = {
            routes: {
                reorderSections: "{{ route('admin.dukunganaplikasi.konfigurasi-website.reorder-sections') }}",
                updateSectionPosition: "{{ url('admin/dukunganaplikasi/konfigurasi-website/update-section-position') }}",
                updateSection: "{{ url('admin/dukunganaplikasi/konfigurasi-website/update-section') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/konfigurasi-website.js') }}"></script>
@endsection
