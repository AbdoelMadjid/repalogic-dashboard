<!-- Modal Preview Gambar Full, Height Ratio Simulator & Slider Posisi -->
<div class="modal fade" id="modal-preview-image" tabindex="-1" aria-labelledby="modalPreviewImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-2.5 px-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-photo me-1 text-info fs-18"></i>
                    <h6 class="modal-title text-white fw-bold mb-0" id="modalPreviewImageLabel">
                        Pratinjau Gambar: <span id="preview-image-title" class="text-info font-monospace"></span>
                    </h6>
                    <span id="preview-image-orient-badge" class="badge bg-primary-subtle text-primary font-monospace fs-11 ms-2">Landscape (1920x1080px)</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 bg-dark text-center overflow-hidden position-relative">
                <!-- Alert Warning khusus Gambar Portrait -->
                <div class="alert alert-warning border-0 py-1.5 px-3 mb-3 text-start fs-12 d-none" id="preview-portrait-alert">
                    <i class="ti ti-info-circle me-1 text-warning"></i>
                    <strong>Tips Gambar Potret (Portrait):</strong> Gambar tegak ini akan menyesuaikan secara dinamis dengan tinggi konten seksi. Atur slider posisi (Y) di bawah untuk memfokuskan bagian terbaik gambar.
                </div>

                <!-- Height Ratio Simulator Controls -->
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fs-12 text-white-50 d-flex align-items-center gap-1">
                        <i class="ti ti-aspect-ratio text-info"></i> Simulasi Tinggi Seksi:
                    </span>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Height Ratio Simulator">
                        <button type="button" class="btn btn-xs btn-primary text-white fw-bold btn-sim-height active" data-height="220px">Pendek (~220px)</button>
                        <button type="button" class="btn btn-xs btn-outline-light text-white fw-semibold btn-sim-height" data-height="380px">Sedang (~380px)</button>
                        <button type="button" class="btn btn-xs btn-outline-light text-white fw-semibold btn-sim-height" data-height="550px">Tinggi (~550px)</button>
                    </div>
                </div>

                <!-- Preview Crop Live Simulation Box -->
                <div class="position-relative overflow-hidden rounded border border-secondary mb-3 shadow" id="sim-preview-container" style="height: 220px; transition: height 0.3s ease;">
                    <img src="" id="modal-preview-img-target" class="w-100 h-100" style="object-fit: cover; object-position: center 50%; transition: object-position 0.1s ease;">
                    <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white px-2 py-1 fs-11 font-monospace rounded-top-end">
                        <i class="ti ti-eye me-1 text-info"></i> Simulation Crop Seksi
                    </div>
                </div>

                <!-- Slider & Mode Control Panel -->
                <div class="p-3 bg-secondary bg-opacity-25 rounded border border-secondary text-start">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="modal_preview_bg_pos_range" class="form-label fs-12 fw-bold text-white mb-0 d-flex align-items-center gap-1">
                            <i class="ti ti-arrows-vertical text-info fs-15"></i> Geser Posisi Vertikal Gambar (Fokus Tampilan):
                        </label>
                        <span id="modal_preview_bg_pos_val" class="badge bg-info text-dark font-monospace fs-12 fw-bold">50%</span>
                    </div>
                    <input type="range" class="form-range mb-2" id="modal_preview_bg_pos_range" min="0" max="100" value="50">
                    <div class="d-flex justify-content-between gap-1 mb-3">
                        <button type="button" class="btn btn-xs btn-light text-dark fw-bold py-1 px-2.5 btn-preset-modal-pos" data-pos="0">Atas (0%)</button>
                        <button type="button" class="btn btn-xs btn-light text-dark fw-bold py-1 px-2.5 btn-preset-modal-pos" data-pos="50">Tengah (50%)</button>
                        <button type="button" class="btn btn-xs btn-light text-dark fw-bold py-1 px-2.5 btn-preset-modal-pos" data-pos="100">Bawah (100%)</button>
                    </div>

                    <div class="row g-2 pt-2 border-top border-secondary border-opacity-50">
                        <div class="col-md-6">
                            <label for="modal_preview_bg_size" class="form-label fs-12 text-white-50 mb-1">Ukuran Latar (Background Size):</label>
                            <select class="form-select form-select-sm bg-dark text-white border-secondary" id="modal_preview_bg_size">
                                <option value="cover">🖼️ Cover (Mengisi Seksi - Default)</option>
                                <option value="contain">📐 Contain (Tampak Utuh Tanpa Cut)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_preview_bg_attachment" class="form-label fs-12 text-white-50 mb-1">Efek Scroll / Paralaks:</label>
                            <select class="form-select form-select-sm bg-dark text-white border-secondary" id="modal_preview_bg_attachment">
                                <option value="scroll">📜 Scroll (Standar Ikut Scroll)</option>
                                <option value="fixed">✨ Fixed (Efek Paralaks 3D Diam)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark border-top border-secondary py-2 px-3 d-flex justify-content-between align-items-center">
                <span class="fs-12 text-white-50">
                    <i class="ti ti-info-circle me-1 text-info"></i> Atur posisi &amp; efek lalu klik simpan.
                </span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary fw-semibold px-3" id="btn-save-preview-pos">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Posisi &amp; Efek
                    </button>
                    <button type="button" class="btn btn-sm btn-light text-dark fw-bold px-3" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
