@php
    $hex = ltrim($user->cover_color ?: '#313a46', '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $alpha = ($user->cover_opacity ?? 60) / 100;
    $rgbaCover = "rgba({$r}, {$g}, {$b}, {$alpha})";
    $rgbaTop = "rgba({$r}, {$g}, {$b}, " . max(0, $alpha - 0.25) . ")";
    $blurPx = (int) ($user->cover_blur ?? 0);
@endphp

<!-- PANEL 2: FOTO SAMPUL & PREFERENSI TEMA/TAMPILAN -->
<div class="tab-pane fade" id="tab-cover-theme" role="tabpanel" aria-labelledby="tab-cover-theme-btn">
    <!-- Card Foto Sampul / Background Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-photo me-1.5"></i> Foto Sampul Background Header</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profil-pengguna.update-cover') }}" method="POST" enctype="multipart/form-data" id="form-update-cover">
                @csrf
                <div class="mb-2 text-center">
                    <div id="cover-preview-container" class="position-relative mb-2 overflow-hidden rounded border shadow-sm w-100"
                        style="min-height: 70px; max-height: 280px; transition: aspect-ratio 0.2s ease, height 0.2s ease;">
                        <img src="{{ $user->cover_bg_url }}" id="cover-preview-img" alt="Background Header" class="w-100 h-100 object-fit-cover" style="object-fit: cover; object-position: center {{ $user->cover_position_y }}%;" />
                        <div id="cover-preview-overlay" class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to top, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none;"></div>
                    </div>
                    <label for="cover_bg_input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-0">
                        <i class="ti ti-camera me-1.5"></i> Pilih / Ganti Foto Sampul
                    </label>
                    <input type="file" name="cover_image" id="cover_bg_input" class="d-none" accept="image/*">
                </div>

                <!-- Warna Lapisan Overlay -->
                <div class="mb-3 p-2 bg-light rounded border">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <label for="cover-color-input" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                <i class="ti ti-palette text-primary fs-15"></i> Warna Lapisan:
                            </label>
                            <input type="color" class="form-control form-control-color border-0 p-0 rounded-circle cursor-pointer flex-shrink-0" id="cover-color-input" name="cover_color" value="{{ $user->cover_color }}" title="Pilih warna kustom" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px;">
                            <div class="d-flex flex-wrap align-items-center gap-1.5">
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#313a46' ? 'active' : '' }}" data-color="#313a46" style="background-color: #313a46;" title="Dark Slate (#313a46)"></span>
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#000000' ? 'active' : '' }}" data-color="#000000" style="background-color: #000000;" title="Hitam (#000000)"></span>
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#1e3a8a' ? 'active' : '' }}" data-color="#1e3a8a" style="background-color: #1e3a8a;" title="Navy (#1e3a8a)"></span>
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#4338ca' ? 'active' : '' }}" data-color="#4338ca" style="background-color: #4338ca;" title="Indigo (#4338ca)"></span>
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#065f46' ? 'active' : '' }}" data-color="#065f46" style="background-color: #065f46;" title="Emerald (#065f46)"></span>
                                <span role="button" tabindex="0" class="btn-cover-color-swatch {{ $user->cover_color === '#701a75' ? 'active' : '' }}" data-color="#701a75" style="background-color: #701a75;" title="Fuchsia (#701a75)"></span>
                            </div>
                        </div>
                        <span id="cover-color-val" class="badge bg-primary-subtle text-primary font-monospace fs-11 fw-bold">{{ $user->cover_color }}</span>
                    </div>
                </div>

                <!-- Row Slider Ketebalan & Tingkat Blur -->
                <div class="row g-3 mb-3">
                    <!-- Slider Ketebalan Warna Overlay -->
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="cover-opacity-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-adjustments-horizontal text-primary fs-15"></i> Ketebalan Warna:
                                </label>
                                <span id="cover-opacity-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_opacity }}%</span>
                            </div>
                            <input type="range" class="form-range mb-2" id="cover-opacity-range" name="cover_opacity" min="0" max="100" step="5" value="{{ $user->cover_opacity }}">
                            <div class="d-flex justify-content-between gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="0">0% (Asli)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="60">60% (Standar)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-opacity" data-opacity="85">85% (Pekat)</button>
                            </div>
                        </div>
                    </div>

                    <!-- Slider Tingkat Blur Lapisan -->
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="cover-blur-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-blur text-primary fs-15"></i> Tingkat Blur Lapisan:
                                </label>
                                <span id="cover-blur-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_blur }}px</span>
                            </div>
                            <input type="range" class="form-range mb-2" id="cover-blur-range" name="cover_blur" min="0" max="20" step="1" value="{{ $user->cover_blur }}">
                            <div class="d-flex justify-content-between gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="0">0px (Tanpa Blur)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="6">6px (Sedang)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-blur" data-blur="14">14px (Kuat)</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row Slider Tinggi Banner & Posisi Vertikal -->
                <div class="row g-3 mb-3">
                    <!-- Slider Pengatur Tinggi Banner Sampul -->
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="cover-height-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-arrows-maximize text-primary fs-15"></i> Tinggi Banner Sampul:
                                </label>
                                <span id="cover-height-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_height }}px</span>
                            </div>
                            <input type="range" class="form-range mb-2" id="cover-height-range" name="cover_height" min="180" max="600" step="10" value="{{ $user->cover_height }}">
                            <div class="d-flex justify-content-between gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="220">Ringkas (220px)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="320">Standar (320px)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-height" data-height="450">Tinggi (450px)</button>
                            </div>
                        </div>
                    </div>

                    <!-- Slider Pengatur Posisi Vertikal -->
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="cover-position-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-arrows-vertical text-primary fs-15"></i> Posisi Atas - Bawah:
                                </label>
                                <span id="cover-position-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_position_y }}%</span>
                            </div>
                            <input type="range" class="form-range mb-2" id="cover-position-range" name="cover_position_y" min="0" max="100" value="{{ $user->cover_position_y }}">
                            <div class="d-flex justify-content-between gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="0">Atas (0%)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="50">Tengah (50%)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="100">Bawah (100%)</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                    <i class="ti ti-device-floppy me-1.5"></i> Simpan Pengaturan Foto Sampul
                </button>
            </form>
        </div>
    </div>

    <!-- Card Preferensi Tampilan & Tema (Cluster 3) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-brush me-1.5"></i> Preferensi Tampilan & Antarmuka</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profil-pengguna.update-settings') }}" method="POST" data-confirm="Simpan preferensi tampilan antarmuka Anda?">
                @csrf
                <input type="hidden" name="has_appearance_settings" value="1">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">
                            <i class="ti ti-sun-moon me-1 text-primary"></i> Mode Tema Antarmuka
                        </label>
                        <select class="form-select form-select-sm" name="appearance_theme_mode">
                            <option value="light" {{ ($settings['appearance']['theme_mode'] ?? 'light') === 'light' ? 'selected' : '' }}>Mode Terang (Light Mode)</option>
                            <option value="dark" {{ ($settings['appearance']['theme_mode'] ?? '') === 'dark' ? 'selected' : '' }}>Mode Gelap (Dark Mode)</option>
                            <option value="system" {{ ($settings['appearance']['theme_mode'] ?? '') === 'system' ? 'selected' : '' }}>Otomatis (Ikuti Sistem OS)</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Menyesuaikan skema warna tampilan dashboard.</span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">
                            <i class="ti ti-layout-sidebar me-1 text-primary"></i> Gaya Menu Navigasi Samping
                        </label>
                        <select class="form-select form-select-sm" name="appearance_sidebar_style">
                            <option value="default" {{ ($settings['appearance']['sidebar_style'] ?? 'default') === 'default' ? 'selected' : '' }}>Standar Terbuka (Default)</option>
                            <option value="compact" {{ ($settings['appearance']['sidebar_style'] ?? '') === 'compact' ? 'selected' : '' }}>Ringkas (Compact / Hover)</option>
                            <option value="icon" {{ ($settings['appearance']['sidebar_style'] ?? '') === 'icon' ? 'selected' : '' }}>Ikon Saja (Mini View)</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Mengatur lebar sidebar menu navigasi.</span>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">
                            <i class="ti ti-table me-1 text-primary"></i> Kepadatan Tabel Data
                        </label>
                        <select class="form-select form-select-sm" name="appearance_table_density">
                            <option value="normal" {{ ($settings['appearance']['table_density'] ?? 'normal') === 'normal' ? 'selected' : '' }}>Standar (Nyaman / Default)</option>
                            <option value="compact" {{ ($settings['appearance']['table_density'] ?? '') === 'compact' ? 'selected' : '' }}>Rapat (Compact View)</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Jarak padding antar baris data tabel.</span>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="appearance_reduce_motion">
                                    <i class="ti ti-sparkles-off text-primary me-1"></i> Kurangi Efek Animasi
                                </label>
                                <span class="fs-12 text-muted d-block">Meringankan beban grafis dan menghemat konsumsi daya baterai.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="appearance_reduce_motion" name="appearance_reduce_motion" value="1" {{ !empty($settings['appearance']['reduce_motion']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Preferensi Tampilan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
