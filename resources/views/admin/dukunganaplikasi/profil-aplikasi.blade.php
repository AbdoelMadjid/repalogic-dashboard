@extends('layouts.vertical')

@section('title', 'Profil Aplikasi')

@section('content')
    <link href="{{ asset('assets/css/admin/dukunganaplikasi/profil-aplikasi.css') }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Profil Aplikasi', 'subtitle' => 'Dukungan Aplikasi'])

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.dukunganaplikasi.profil-aplikasi.update') }}" method="POST" enctype="multipart/form-data" id="form-profil-aplikasi">
                @csrf

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between py-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-settings-automation fs-22"></i>
                            <h5 class="card-title text-white mb-0">Pengaturan Profil & Branding Aplikasi</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Custom Nav Tabs -->
                        <ul class="nav nav-tabs nav-bordered mb-4" role="tablist">
                            <li class="nav-item">
                                <a href="#tab-logo" data-bs-toggle="tab" aria-expanded="true" class="nav-link active py-2">
                                    <i class="ti ti-photo me-1 fs-18 align-middle"></i>
                                    <span class="d-none d-md-inline-block">Logo & Icon</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-meta" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2">
                                    <i class="ti ti-brand-meta me-1 fs-18 align-middle"></i>
                                    <span class="d-none d-md-inline-block">Identitas & Meta SEO</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab-footer" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-2">
                                    <i class="ti ti-layout-bottombar me-1 fs-18 align-middle"></i>
                                    <span class="d-none d-md-inline-block">Footer & Developer</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- TAB 1: LOGO & ICON -->
                            <div class="tab-pane show active" id="tab-logo">
                                <div class="row g-4">
                                    <!-- Logo Besar (Side Nav LG) -->
                                    <div class="col-md-4">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-header bg-light py-2 fw-semibold">
                                                <i class="ti ti-photo-heart me-1 text-primary"></i> Logo Besar (Side Nav Expanded)
                                            </div>
                                            <div class="card-body text-center d-flex flex-column align-items-center justify-content-between">
                                                <div class="mb-3 p-3 border rounded bg-dark-subtle w-100 d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                                    <img id="preview-logo-lg" 
                                                         src="{{ $profil->logo_lg ? asset('storage/' . $profil->logo_lg) : asset('assets/images/logo.png') }}" 
                                                         alt="Logo Besar" 
                                                         class="img-fluid" style="max-height: 75px; object-fit: contain;">
                                                </div>
                                                <div class="w-100 text-start">
                                                    <label for="logo_lg" class="form-label fs-13">Pilih File Logo Besar</label>
                                                    <input type="file" class="form-control form-control-sm @error('logo_lg') is-invalid @enderror" 
                                                           id="logo_lg" name="logo_lg" accept="image/*" data-preview-id="preview-logo-lg">
                                                    <div class="form-text fs-12 text-muted">Format: PNG, JPG, WEBP, SVG (Max 2MB). Rekomendasi: 180x45 px.</div>
                                                    @error('logo_lg')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logo Kecil (Side Nav SM) -->
                                    <div class="col-md-4">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-header bg-light py-2 fw-semibold">
                                                <i class="ti ti-square-asterisk me-1 text-primary"></i> Logo Kecil (Side Nav Collapsed)
                                            </div>
                                            <div class="card-body text-center d-flex flex-column align-items-center justify-content-between">
                                                <div class="mb-3 p-3 border rounded bg-dark-subtle w-100 d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                                    <img id="preview-logo-sm" 
                                                         src="{{ $profil->logo_sm ? asset('storage/' . $profil->logo_sm) : asset('assets/images/logo-sm.png') }}" 
                                                         alt="Logo Kecil" 
                                                         class="img-fluid" style="max-height: 60px; object-fit: contain;">
                                                </div>
                                                <div class="w-100 text-start">
                                                    <label for="logo_sm" class="form-label fs-13">Pilih File Logo Kecil</label>
                                                    <input type="file" class="form-control form-control-sm @error('logo_sm') is-invalid @enderror" 
                                                           id="logo_sm" name="logo_sm" accept="image/*" data-preview-id="preview-logo-sm">
                                                    <div class="form-text fs-12 text-muted">Format: PNG, JPG, WEBP, SVG (Max 2MB). Rekomendasi: 40x40 px.</div>
                                                    @error('logo_sm')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Favicon Browser -->
                                    <div class="col-md-4">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-header bg-light py-2 fw-semibold">
                                                <i class="ti ti-world-upload me-1 text-primary"></i> Favicon Browser Tab
                                            </div>
                                            <div class="card-body text-center d-flex flex-column align-items-center justify-content-between">
                                                <div class="mb-3 p-3 border rounded bg-light w-100 d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                                    <img id="preview-favicon" 
                                                         src="{{ $profil->favicon ? asset('storage/' . $profil->favicon) : asset('assets/images/favicon.ico') }}" 
                                                         alt="Favicon Browser" 
                                                         class="img-fluid" style="max-height: 48px; object-fit: contain;">
                                                </div>
                                                <div class="w-100 text-start">
                                                    <label for="favicon" class="form-label fs-13">Pilih File Favicon</label>
                                                    <input type="file" class="form-control form-control-sm @error('favicon') is-invalid @enderror" 
                                                           id="favicon" name="favicon" accept="image/*,.ico" data-preview-id="preview-favicon">
                                                    <div class="form-text fs-12 text-muted">Format: ICO, PNG, SVG (Max 1MB). Rekomendasi: 32x32 px.</div>
                                                    @error('favicon')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: IDENTITAS & META SEO -->
                            <div class="tab-pane" id="tab-meta">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="app_name" class="form-label fw-semibold">Nama Aplikasi (Title Meta Suffix) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-app-window"></i></span>
                                            <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                                   id="app_name" name="app_name" value="{{ old('app_name', $profil->app_name) }}" 
                                                   placeholder="Contoh: REPALOGIC Dashboard" required>
                                        </div>
                                        <div class="form-text fs-12">Disematkan di tab browser: <code>Judul | Nama App</code></div>
                                        @error('app_name')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="app_short_name" class="form-label fw-semibold">Nama Singkat / Brand Short Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-building-store"></i></span>
                                            <input type="text" class="form-control @error('app_short_name') is-invalid @enderror" 
                                                   id="app_short_name" name="app_short_name" value="{{ old('app_short_name', $profil->app_short_name) }}" 
                                                   placeholder="Contoh: REPALOGIC">
                                        </div>
                                        @error('app_short_name')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="app_version" class="form-label fw-semibold">Versi Aplikasi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-git-commit"></i></span>
                                            <input type="text" class="form-control @error('app_version') is-invalid @enderror" 
                                                   id="app_version" name="app_version" value="{{ old('app_version', $profil->app_version ?? 'v1.9.0') }}" 
                                                   placeholder="Contoh: v1.9.0">
                                        </div>
                                        <div class="form-text fs-12">Versi rilis aktif (e.g. <code>v1.9.0</code>)</div>
                                        @error('app_version')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="meta_author" class="form-label fw-semibold">Meta Author / Pemilik Konten</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-user-check"></i></span>
                                            <input type="text" class="form-control @error('meta_author') is-invalid @enderror" 
                                                   id="meta_author" name="meta_author" value="{{ old('meta_author', $profil->meta_author) }}" 
                                                   placeholder="Contoh: WebAppLayers / Tim IT Repalogic">
                                        </div>
                                        @error('meta_author')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="meta_description" class="form-label fw-semibold">Meta Description (Deskripsi Search Engine)</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                  id="meta_description" name="meta_description" rows="3" 
                                                  placeholder="Masukkan deskripsi singkat aplikasi untuk SEO browser...">{{ old('meta_description', $profil->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords (Kata Kunci)</label>
                                        <textarea class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                  id="meta_keywords" name="meta_keywords" rows="2" 
                                                  placeholder="Contoh: admin, dashboard, management, repalogic (dipisahkan koma)">{{ old('meta_keywords', $profil->meta_keywords) }}</textarea>
                                        @error('meta_keywords')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: FOOTER & DEVELOPER -->
                            <div class="tab-pane" id="tab-footer">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="created_year" class="form-label fw-semibold">Tahun Dibuat (Hak Cipta)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                            <input type="text" class="form-control @error('created_year') is-invalid @enderror" 
                                                   id="created_year" name="created_year" value="{{ old('created_year', $profil->created_year) }}" 
                                                   placeholder="Contoh: 2026">
                                        </div>
                                        @error('created_year')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="developer_name" class="form-label fw-semibold">Nama Pembuat / Developer</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-code"></i></span>
                                            <input type="text" class="form-control @error('developer_name') is-invalid @enderror" 
                                                   id="developer_name" name="developer_name" value="{{ old('developer_name', $profil->developer_name) }}" 
                                                   placeholder="Contoh: WebAppLayers">
                                        </div>
                                        @error('developer_name')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="developer_url" class="form-label fw-semibold">Link Website Pembuat / Developer URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-link"></i></span>
                                            <input type="url" class="form-control @error('developer_url') is-invalid @enderror" 
                                                   id="developer_url" name="developer_url" value="{{ old('developer_url', $profil->developer_url) }}" 
                                                   placeholder="https://example.com">
                                        </div>
                                        @error('developer_url')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="footer_text" class="form-label fw-semibold">Teks Tambahan Footer</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-file-text"></i></span>
                                            <input type="text" class="form-control @error('footer_text') is-invalid @enderror" 
                                                   id="footer_text" name="footer_text" value="{{ old('footer_text', $profil->footer_text) }}" 
                                                   placeholder="Contoh: Inspinia By">
                                        </div>
                                        @error('footer_text')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex align-items-center justify-content-between py-3">
                        <span class="text-muted fs-12">
                            <i class="ti ti-info-circle me-1"></i> Perubahan data profil akan langsung berdampak secara global di seluruh tampilan dashboard.
                        </span>
                        @can('update dukunganaplikasi/profil-aplikasi')
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Profil Aplikasi
                            </button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Page JS (Rule 1 & 15 Compliance) -->
    <script src="{{ asset('assets/js/admin/dukunganaplikasi/profil-aplikasi.js') }}"></script>
@endsection
