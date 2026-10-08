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

<!-- Card Motto Hidup / Kutipan Profil -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-quote me-1"></i> Motto Hidup / Kutipan Profil</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.profil-pengguna.update-motto') }}" method="POST" id="form-update-motto">
            @csrf
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="motto_input" class="form-label fs-13 fw-semibold text-dark mb-0">Motto / Kata-Kata Bijak:</label>
                    <button type="button" class="btn btn-xs btn-outline-primary d-inline-flex align-items-center gap-1 rounded-pill px-2 py-0.5" id="btn-random-motto" title="Pilih motto acak yang inspiratif">
                        <i class="ti ti-dice fs-14"></i>
                        <span>Acak Motto</span>
                    </button>
                </div>
                <textarea name="motto" id="motto_input" rows="3" class="form-control" placeholder="Tuliskan motto hidup Anda..." maxlength="255" required>{{ old('motto', $user->motto) }}</textarea>
                <span class="fs-12 text-muted d-block mt-1">Motto ini akan ditampilkan di atas banner foto sampul Anda.</span>
            </div>

            <!-- Pratinjau Visual Motto (di atas Foto Sampul) -->
            <div class="mb-3">
                <label class="form-label fs-12 fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                    <i class="ti ti-eye text-primary fs-15"></i> Pratinjau Visual Motto:
                </label>
                <div id="motto-preview-container" class="position-relative overflow-hidden rounded border shadow-sm p-3 d-flex align-items-center justify-content-center text-center"
                    style="min-height: 80px; background-image: url('{{ $user->cover_bg_url }}'); background-size: cover; background-position: center {{ $user->cover_position_y }}%;">
                    <div id="motto-preview-overlay" class="position-absolute top-0 start-0 w-100 h-100"
                        style="background: linear-gradient(to top, {{ $rgbaCover }}, {{ $rgbaTop }}); backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; -webkit-backdrop-filter: {{ $blurPx > 0 ? 'blur('.$blurPx.'px)' : 'none' }}; pointer-events: none;"></div>
                    <div id="motto-mini-preview-text" class="position-relative z-1 fst-italic fw-medium px-2"
                        style="color: {{ old('motto_color', $user->motto_color) }}; font-size: 0.95rem; text-shadow: {{ in_array(strtolower(old('motto_color', $user->motto_color)), ['#000000', '#111827', '#1f2937', '#0f172a']) ? '0 1px 4px rgba(255, 255, 255, 0.8)' : '0 1px 4px rgba(0, 0, 0, 0.8)' }};">
                        "{{ old('motto', $user->motto ?? 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.') }}"
                    </div>
                </div>
                <span class="fs-11 text-muted d-block mt-1">Pratinjau langsung warna teks motto di atas foto sampul profil Anda.</span>
            </div>

            <!-- Pilihan Warna Teks Motto -->
            <div class="mb-3 p-2 bg-light rounded border">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="motto_color_input" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                        <i class="ti ti-palette text-primary fs-15"></i> Warna Teks Motto:
                    </label>
                    <span id="motto-color-val" class="badge bg-primary-subtle text-primary font-monospace fs-11 fw-bold">{{ old('motto_color', $user->motto_color) }}</span>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-1.5 mt-2">
                    <input type="color" class="form-control form-control-color border-0 p-0 rounded-circle cursor-pointer flex-shrink-0" id="motto_color_input" name="motto_color" value="{{ old('motto_color', $user->motto_color) }}" title="Pilih warna kustom" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px;">
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#ffffff' ? 'active' : '' }}" data-color="#ffffff" style="background-color: #ffffff; border: 2px solid #cbd5e1 !important;" title="Putih (#ffffff)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ in_array(strtolower(old('motto_color', $user->motto_color)), ['#000000', '#111827']) ? 'active' : '' }}" data-color="#111827" style="background-color: #111827;" title="Hitam (#111827)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f59e0b' ? 'active' : '' }}" data-color="#f59e0b" style="background-color: #f59e0b;" title="Kuning Emas (#f59e0b)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#06b6d4' ? 'active' : '' }}" data-color="#06b6d4" style="background-color: #06b6d4;" title="Cyan (#06b6d4)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#10b981' ? 'active' : '' }}" data-color="#10b981" style="background-color: #10b981;" title="Hijau Neon (#10b981)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f43f5e' ? 'active' : '' }}" data-color="#f43f5e" style="background-color: #f43f5e;" title="Merah Rose (#f43f5e)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#f97316' ? 'active' : '' }}" data-color="#f97316" style="background-color: #f97316;" title="Oranye (#f97316)"></span>
                    <span role="button" tabindex="0" class="btn-motto-color-swatch {{ strtolower(old('motto_color', $user->motto_color)) === '#8b5cf6' ? 'active' : '' }}" data-color="#8b5cf6" style="background-color: #8b5cf6;" title="Ungu (#8b5cf6)"></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                <i class="ti ti-device-floppy me-1"></i> Simpan Motto Hidup
            </button>
        </form>
    </div>
</div>
