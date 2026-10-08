<!-- MODAL SESUAIKAN & POTONG FOTO AVATAR (CROPPER.JS) -->
<div class="modal fade" id="modal-crop-avatar" tabindex="-1" aria-labelledby="modalCropAvatarLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered cropper-modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-crop fs-20"></i>
                    <h5 class="modal-title text-white mb-0" id="modalCropAvatarLabel">Sesuaikan & Potong Foto Avatar</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4 bg-light">
                <div class="row g-3 align-items-center">
                    <!-- Area Pemotong Foto -->
                    <div class="col-lg-8">
                        <div class="cropper-container-box rounded border position-relative overflow-hidden mb-2">
                            <img id="crop-source-image" src="" alt="Source Image for Cropping">
                        </div>

                        <!-- Toolbar Kontrol Cropper -->
                        <div class="p-2 bg-white rounded border d-flex flex-wrap align-items-center justify-content-between gap-1 shadow-sm">
                            <!-- Grup Zoom -->
                            <div class="btn-group btn-group-sm" role="group" aria-label="Zoom Controls">
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-zoom-in" title="Perbesar (Zoom In)">
                                    <i class="ti ti-zoom-in"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-zoom-out" title="Perkecil (Zoom Out)">
                                    <i class="ti ti-zoom-out"></i>
                                </button>
                            </div>

                            <!-- Grup Geser (Pan / Move) -->
                            <div class="btn-group btn-group-sm" role="group" aria-label="Move Controls">
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-move-left" title="Geser ke Kiri">
                                    <i class="ti ti-arrow-left"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-move-right" title="Geser ke Kanan">
                                    <i class="ti ti-arrow-right"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-move-up" title="Geser ke Atas">
                                    <i class="ti ti-arrow-up"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-move-down" title="Geser ke Bawah">
                                    <i class="ti ti-arrow-down"></i>
                                </button>
                            </div>

                            <!-- Grup Putar & Balik -->
                            <div class="btn-group btn-group-sm" role="group" aria-label="Rotate Controls">
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-rotate-left" title="Putar 90° ke Kiri">
                                    <i class="ti ti-rotate-2"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-rotate-right" title="Putar 90° ke Kanan">
                                    <i class="ti ti-rotate-clockwise-2"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btn-crop-flip-x" title="Balik Horizontal">
                                    <i class="ti ti-flip-horizontal"></i>
                                </button>
                            </div>

                            <!-- Reset Button -->
                            <button type="button" class="btn btn-sm btn-outline-danger" id="btn-crop-reset" title="Reset Posisi & Skala">
                                <i class="ti ti-refresh me-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Panel Preview & Petunjuk -->
                    <div class="col-lg-4 text-center">
                        <div class="bg-white p-3 rounded border shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold text-dark mb-3 fs-13 text-uppercase tracking-wider">
                                    <i class="ti ti-eye me-1 text-primary"></i> Live Preview Avatar
                                </h6>
                                <!-- Circular Preview -->
                                <div class="avatar-crop-preview mx-auto mb-2"></div>
                                <span class="fs-12 text-muted fw-medium d-block mb-3">Tampilan Lingkaran Profil</span>

                                <!-- Square Preview -->
                                <div class="avatar-crop-preview-square mx-auto mb-1"></div>
                                <span class="fs-11 text-muted d-block">Tampilan Kartu / Kontak</span>
                            </div>

                            <div class="alert alert-info py-2 px-2.5 fs-11 text-start mb-0 mt-3 border-0 bg-info-subtle text-info-emphasis">
                                <i class="ti ti-info-circle me-1"></i> <strong>Tips:</strong> Anda juga dapat menggeser (*drag*) dan melakukan *scroll mouse* langsung di atas gambar untuk memposisikan foto secara bebas.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2.5 px-3 d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-sm btn-primary px-4 fw-semibold" id="btn-apply-crop">
                    <i class="ti ti-check me-1.5"></i> Potong & Terapkan Foto
                </button>
            </div>
        </div>
    </div>
</div>
