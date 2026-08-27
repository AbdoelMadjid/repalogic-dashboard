<!-- MODAL FORM FITUR APLIKASI (TAMBAH / EDIT / DETAIL) -->
<div class="modal fade" id="fiturModal" tabindex="-1" aria-labelledby="fiturModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="fiturModalLabel">
                    <i class="ti ti-adjustments" id="modalTitleIcon"></i>
                    <span id="modalTitleText">Tambah Fitur Baru</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="fiturForm" action="{{ route('admin.dukunganaplikasi.fitur-aplikasi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="feature_id" value="">

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- KODE FITUR -->
                        <div class="col-md-6">
                            <label for="modal_kode_fitur" class="form-label fw-semibold required">
                                Kode Fitur (Identifier) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="ti ti-code"></i></span>
                                <input type="text" class="form-control" id="modal_kode_fitur" name="kode_fitur" placeholder="e.g. topbar_search_box" required pattern="^[a-zA-Z0-9_-]+$">
                            </div>
                            <small class="text-muted fs-11">Identifier unik fitur di template (gunakan huruf kecil, angka, dan underscore _).</small>
                        </div>

                        <!-- NAMA FITUR -->
                        <div class="col-md-6">
                            <label for="modal_nama_fitur" class="form-label fw-semibold required">
                                Nama Fitur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="ti ti-typography"></i></span>
                                <input type="text" class="form-control" id="modal_nama_fitur" name="nama_fitur" placeholder="e.g. Pencarian (Search Box)" required>
                            </div>
                            <small class="text-muted fs-11">Nama label fitur yang mudah dipahami oleh pengguna.</small>
                        </div>

                        <!-- KELOMPOK / KATEGORI -->
                        <div class="col-md-6">
                            <label for="modal_kategori" class="form-label fw-semibold required">
                                Kelompok / Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="ti ti-category"></i></span>
                                <select class="form-select" id="modal_kategori" name="kategori" required>
                                    <option value="topbar">Topbar Header</option>
                                    <option value="menu_group">Sidebar Menu Group</option>
                                    <option value="general">Umum / General</option>
                                    <option value="kustom">Kustom / Lainnya</option>
                                </select>
                            </div>
                            <small class="text-muted fs-11">Pilih kelompok penempatan fitur dalam sistem.</small>
                        </div>

                        <!-- IKON FITUR & PREVIEW -->
                        <div class="col-md-6">
                            <label for="modal_icon" class="form-label fw-semibold">
                                Ikon Tabler (CSS Class)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="iconPreview">
                                    <i class="ti ti-puzzle fs-18 text-primary"></i>
                                </span>
                                <input type="text" class="form-control" id="modal_icon" name="icon" placeholder="e.g. ti ti-search">
                            </div>
                            <small class="text-muted fs-11">Gunakan format icon Tabler (contoh: <code>ti ti-search</code>).</small>
                        </div>

                        <!-- URUTAN & STATUS -->
                        <div class="col-md-6">
                            <label for="modal_urutan" class="form-label fw-semibold">Urutan Tampil (Order)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="ti ti-sort-ascending-numbers"></i></span>
                                <input type="number" class="form-control" id="modal_urutan" name="urutan" value="0" min="0">
                            </div>
                            <small class="text-muted fs-11">Urutan posisi kartu/tabel (angka lebih kecil tampil lebih awal).</small>
                        </div>

                        <div class="col-md-6 d-flex flex-column justify-content-center">
                            <label class="form-label fw-semibold mb-2">Status Visibilitas Awal</label>
                            <div class="form-check form-switch form-switch-md">
                                <input class="form-check-input" type="checkbox" role="switch" id="modal_status" name="status" value="1" checked>
                                <label class="form-check-label fw-semibold ms-2" for="modal_status" id="modal_status_label">
                                    <span class="badge bg-success-subtle text-success">Aktif (Ditampilkan)</span>
                                </label>
                            </div>
                            <small class="text-muted fs-11">Tentukan apakah fitur ini langsung diaktifkan saat disimpan.</small>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="col-12">
                            <label for="modal_deskripsi" class="form-label fw-semibold">Deskripsi / Penjelasan Fitur</label>
                            <textarea class="form-control" id="modal_deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan secara ringkas fungsi dan letak fitur ini di aplikasi..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitFitur">
                        <i class="ti ti-device-floppy me-1"></i> <span id="btnSubmitText">Simpan Fitur</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
