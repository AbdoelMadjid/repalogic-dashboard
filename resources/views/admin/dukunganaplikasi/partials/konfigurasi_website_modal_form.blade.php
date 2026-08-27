<!-- Modal Tambah / Edit Tema Website -->
<div class="modal fade" id="modal-tambah-tema" tabindex="-1" aria-labelledby="modalTambahTemaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white fw-bold" id="modalTambahTemaLabel">
                    <i class="ti ti-palette me-1"></i> <span id="modal-tema-title">Tambah Tema Website Baru</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.store-theme') }}" method="POST" id="form-theme">
                @csrf
                <input type="hidden" name="theme_id" id="theme_id" value="">
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="theme_name" class="form-label fw-semibold text-dark">Nama Identitas Tema <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="theme_name" name="name" placeholder="Contoh: Modern Clean Theme" required>
                    </div>

                    <div class="mb-3">
                        <label for="theme_folder" class="form-label fw-semibold text-dark">Nama Folder Sub-Directory Blade <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">resources/views/website/</span>
                            <input type="text" class="form-control font-monospace" id="theme_folder" name="folder" placeholder="default" required>
                        </div>
                        <div class="form-text fs-12 text-muted">Nama folder sub-directory di <code>resources/views/website/[folder]</code> yang menyimpan file seksi blade tema ini.</div>
                    </div>

                    <div class="mb-3">
                        <label for="theme_description" class="form-label fw-semibold text-dark">Deskripsi / Catatan Tema</label>
                        <textarea class="form-control" id="theme_description" name="description" rows="3" placeholder="Keterangan singkat gaya desain dan fitur tema ini..."></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Tema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Seksi Halaman -->
<div class="modal fade" id="modal-tambah-seksi" tabindex="-1" aria-labelledby="modalTambahSeksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white fw-bold" id="modalTambahSeksiLabel">
                    <i class="ti ti-plus me-1"></i> Tambah Seksi Halaman Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.dukunganaplikasi.konfigurasi-website.store-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="website_theme_id" value="{{ $activeTheme->id ?? '' }}">

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_section_name" class="form-label fw-semibold text-dark">Nama Seksi Halaman <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="add_section_name" name="section_name" placeholder="Contoh: Banner Promo Spesial" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_section_file" class="form-label fw-semibold text-dark">Nama File Blade Template <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">website/{{ $activeTheme->folder ?? 'default' }}/</span>
                                    <input type="text" class="form-control font-monospace" id="add_section_file" name="section_file" placeholder="section-promo.blade.php" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_nav_title" class="form-label fw-semibold text-dark">Judul Menu Navigasi (Navbar)</label>
                                <input type="text" class="form-control" id="add_nav_title" name="nav_title" placeholder="Contoh: Promo">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="add_target_id" class="form-label fw-semibold text-dark">Anchor Target ID (#)</label>
                                <input type="text" class="form-control font-monospace" id="add_target_id" name="target_id" placeholder="promo">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="add_orders" class="form-label fw-semibold text-dark">Urutan Tampil (Orders)</label>
                                <input type="number" class="form-control" id="add_orders" name="orders" value="{{ ($activeTheme->sections->max('orders') ?? 0) + 1 }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="add_bg_type" class="form-label fw-semibold text-dark">Gaya Latar Belakang (Background Style)</label>
                                <select class="form-select select-bg-type" id="add_bg_type" name="bg_type" data-container-id="add_container_bg_image">
                                    <option value="default">⚪ section-custom (Standar Putih / Tanpa Border)</option>
                                    <option value="light">🌤️ section-custom bg-light bg-opacity-30 border-top border-bottom (Latar Terang Soft)</option>
                                    <option value="secondary">🔘 section-custom bg-body-secondary border-top border-bottom (Latar Abu Secondary)</option>
                                    <option value="dark">🌙 section-custom bg-dark text-white (Latar Gelap Modern)</option>
                                    <option value="primary">🔵 section-custom bg-primary text-white (Latar Warna Utama)</option>
                                    <option value="image">🖼️ background-image (Unggah Gambar Background Kustom)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="add_container_bg_image">
                        <div class="col-md-12">
                            <div class="card border border-info border-opacity-50 bg-info-subtle mb-3">
                                <div class="card-body p-3">
                                    <label for="add_bg_image_file" class="form-label fw-bold text-dark mb-2">
                                        <i class="ti ti-photo me-1 text-info"></i> Unggah Gambar Background Seksi Kustom
                                    </label>

                                    <!-- Live Preview Box untuk File Baru Ditambah -->
                                    <div class="mb-3 d-none" id="add_bg_image_preview_box">
                                        <span class="fs-12 text-muted d-block mb-1 fw-semibold">Pratinjau Gambar Terpilih:</span>
                                        <div class="border rounded p-2 bg-white text-center shadow-sm" style="background-color: #f8fafc;">
                                            <img src="" id="add_bg_image_preview" class="img-fluid rounded border" style="max-height: 180px; object-fit: contain; width: auto;">
                                        </div>
                                    </div>

                                    <input type="file" class="form-control mb-1" id="add_bg_image_file" name="bg_image_file" accept="image/*">
                                    <div class="form-text fs-12 text-muted mt-0">
                                        <i class="ti ti-info-circle me-1 text-info"></i> Format: JPG, PNG, WEBP, SVG (Maks 2MB). Setelah disimpan, klik thumbnail di tabel untuk menguji &amp; mengatur posisi fokus gambar.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark d-block">Pengaturan Opsi</label>
                                <div class="d-flex align-items-center gap-4 mt-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="add_is_active" name="is_active" value="1" checked>
                                        <label class="form-check-input-label fw-semibold text-dark ms-1" for="add_is_active">Aktifkan Seksi</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="add_show_in_nav" name="show_in_nav" value="1" checked>
                                        <label class="form-check-input-label fw-semibold text-dark ms-1" for="add_show_in_nav">Tampilkan di Navbar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="ti ti-plus me-1"></i> Simpan Seksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Seksi Halaman -->
<div class="modal fade" id="modal-edit-seksi" tabindex="-1" aria-labelledby="modalEditSeksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title text-white fw-bold" id="modalEditSeksiLabel">Edit Seksi Halaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="form-edit-seksi" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_section_name" class="form-label fw-semibold text-dark">Nama Seksi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_section_name" name="section_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_section_file" class="form-label fw-semibold text-dark">Nama File View (.blade.php) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_section_file" name="section_file" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_nav_title" class="form-label fw-semibold text-dark">Judul Menu Navbar</label>
                                <input type="text" class="form-control" id="edit_nav_title" name="nav_title">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_target_id" class="form-label fw-semibold text-dark">Anchor Target ID (#id)</label>
                                <input type="text" class="form-control" id="edit_target_id" name="target_id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_orders" class="form-label fw-semibold text-dark">Urutan Tampil (Orders)</label>
                                <input type="number" class="form-control" id="edit_orders" name="orders">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_bg_type" class="form-label fw-semibold text-dark">Gaya Latar Belakang (Background Style)</label>
                                <select class="form-select select-bg-type" id="edit_bg_type" name="bg_type" data-container-id="edit_container_bg_image">
                                    <option value="default">⚪ section-custom (Standar Putih / Tanpa Border)</option>
                                    <option value="light">🌤️ section-custom bg-light bg-opacity-30 border-top border-bottom (Latar Terang Soft)</option>
                                    <option value="secondary">🔘 section-custom bg-body-secondary border-top border-bottom (Latar Abu Secondary)</option>
                                    <option value="dark">🌙 section-custom bg-dark text-white (Latar Gelap Modern)</option>
                                    <option value="primary">🔵 section-custom bg-primary text-white (Latar Warna Utama)</option>
                                    <option value="image">🖼️ background-image (Unggah Gambar Background Kustom)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="edit_container_bg_image">
                        <div class="col-md-12">
                            <div class="card border border-info border-opacity-50 bg-info-subtle mb-3">
                                <div class="card-body p-3">
                                    <label for="edit_bg_image_file" class="form-label fw-bold text-dark mb-2">
                                        <i class="ti ti-photo me-1 text-info"></i> Unggah / Ganti Gambar Background Seksi Kustom
                                    </label>
                                    
                                    <div class="mb-3 d-none" id="edit_bg_image_preview_box">
                                        <span class="fs-12 text-muted d-block mb-1 fw-semibold" id="edit_bg_preview_label">Gambar Background Aktif Saat Ini:</span>
                                        <div class="border rounded p-2 bg-white text-center shadow-sm" style="background-color: #f8fafc;">
                                            <img src="" id="edit_bg_image_preview" class="img-fluid rounded border" style="max-height: 180px; object-fit: contain; width: auto;">
                                        </div>
                                    </div>

                                    <input type="file" class="form-control mb-1" id="edit_bg_image_file" name="bg_image_file" accept="image/*">
                                    <div class="form-text fs-12 text-muted mt-0">
                                        <i class="ti ti-info-circle me-1 text-info"></i> Format: JPG, PNG, WEBP, SVG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti gambar.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark d-block">Pengaturan Opsi</label>
                                <div class="d-flex align-items-center gap-4 mt-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                        <label class="form-check-input-label fw-semibold text-dark ms-1" for="edit_is_active">Aktifkan Seksi</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_show_in_nav" name="show_in_nav" value="1">
                                        <label class="form-check-input-label fw-semibold text-dark ms-1" for="edit_show_in_nav">Tampilkan di Navbar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
