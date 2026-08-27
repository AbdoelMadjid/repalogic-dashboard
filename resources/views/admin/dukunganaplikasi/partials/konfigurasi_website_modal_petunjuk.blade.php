<!-- Modal Panduan Standarisasi Seksi Halaman -->
<div class="modal fade" id="modal-panduan-seksi" tabindex="-1" aria-labelledby="modalPanduanSeksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white py-3">
                <h5 class="modal-title text-white fw-bold" id="modalPanduanSeksiLabel">
                    <i class="ti ti-book me-1"></i> Panduan Standarisasi Pembuatan Seksi Tema
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="ti ti-info-circle fs-20 text-info"></i>
                        <span class="fw-bold">Prinsip Utama Standarisasi:</span>
                    </div>
                    <p class="mb-0 fs-13">
                        Setiap file seksi Blade wajib dibuat baku dan netral tanpa menyertakan class warna latar atau class layout tambahan di dalam kode HTML. Pengaturan class latar belakang disimpan secara otomatis di kolom database <code>bg_color_class</code> dan dibungkus terpusat oleh engine sistem.
                    </p>
                </div>

                <h6 class="fw-bold text-dark mb-2">1. Tag Pembuka Seksi Baku (Outer Container):</h6>
                <p class="fs-13 text-muted mb-2">Gunakan tag murni <code>&lt;section class="section-custom" id="[target_id]"&gt;</code> tanpa menyertakan class warna (<code>bg-light</code>, <code>bg-dark</code>) atau class ekstra (<code>py-5</code>, <code>position-relative</code>, <code>overflow-hidden</code>).</p>
                <div class="bg-dark text-white p-3 rounded font-monospace fs-12 mb-4">
                    <span class="text-success">&lt;!-- BENAR: Baku, Netral &amp; Dinamis --&gt;</span><br>
                    &lt;section class="section-custom" id="[target_id]"&gt;...&lt;/section&gt;<br><br>
                    <span class="text-danger">&lt;!-- SALAH: Terkontaminasi class warna / layout keras --&gt;</span><br>
                    &lt;section class="section-custom bg-light py-5 position-relative" id="[target_id]"&gt;...&lt;/section&gt;
                </div>

                <h6 class="fw-bold text-dark mb-2">2. Anchor Target ID untuk Navigasi Navbar:</h6>
                <p class="fs-13 text-muted mb-4">Atribut <code>id="[target_id]"</code> wajib sama persis dengan nilai <strong>Anchor Target ID</strong> yang terdaftar di database agar pergerakan scroll smooth dari navbar berjalan presisi.</p>

                <h6 class="fw-bold text-dark mb-2">3. Kontras Teks Judul &amp; Kartu Konten (.card):</h6>
                <p class="fs-13 text-muted mb-4">
                    Jangan memasang class warna teks keras (seperti <code>text-dark</code>) langsung pada judul utama seksi. Gunakan tag standar <code>&lt;h2&gt;</code> dan <code>&lt;p class="text-muted"&gt;</code> agar warna judul otomatis menyesuaikan saat latar seksi diubah ke gelap/gambar. Untuk konten fitur/layanan, gunakan pembungkus kartis <code>&lt;div class="card"&gt;</code> — sistem secara otomatis menjaga teks di dalam kartu tetap berwarna gelap kontras tinggi sehingga 100% terbaca dengan tajam.
                </p>

                <h6 class="fw-bold text-dark mb-2">4. Panduan Gambar Latar Belakang (Landscape vs Portrait &amp; Paralaks):</h6>
                <p class="fs-13 text-muted mb-4">
                    Gunakan gambar berorientasi <strong>Landscape (min. 1920×1080px)</strong> agar proporsional pada layar desktop. Jika mengunggah gambar <strong>Portrait (Tegak)</strong>, atur posisi vertikal (Y) pada panel pratinjau ke area fokus utama (misal 30% atau 50%) agar bagian penting tidak terpotong. Anda juga dapat mengaktifkan opsi <strong>Fixed (Paralaks 3D)</strong> untuk menciptakan efek visual latar diam yang mewah saat di-scroll.
                </p>

                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="fw-bold text-dark mb-0">5. Struktur Kode Template Seksi Standar:</h6>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-3 btn-copy-template" id="btn-copy-template-code">
                        <i class="ti ti-copy me-1"></i> Salin Kode Template
                    </button>
                </div>
                <div class="position-relative">
                    <textarea id="raw-code-input" class="d-none"><!-- Section: [Nama Seksi Halaman] -->
<section class="section-custom" id="[target_id]">
    <div class="container">
        <!-- Section Header / Title -->
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 mb-2">
                    🚀 [Kategori / Sub-Judul Seksi]
                </span>
                <h2 class="mt-2 fw-bold">[Judul Utama Seksi Halaman]</h2>
                <p class="text-muted fs-md max-w-600 mx-auto">
                    [Deskripsi singkat seksi halaman]
                </p>
            </div>
        </div>

        <!-- Section Content Grid -->
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 border shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Item Fitur</h5>
                        <p class="text-muted fs-14">Penjelasan konten...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section></textarea>
                    <pre class="bg-light text-dark p-3 rounded border font-monospace fs-12 mb-0" id="raw-template-code" style="max-height: 250px; overflow-y: auto;">
&lt;!-- Section: [Nama Seksi Halaman] --&gt;
&lt;section class="section-custom" id="[target_id]"&gt;
    &lt;div class="container"&gt;
        &lt;!-- Section Header / Title --&gt;
        &lt;div class="row"&gt;
            &lt;div class="col-12 text-center mb-5"&gt;
                &lt;span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 mb-2"&gt;
                    🚀 [Kategori / Sub-Judul Seksi]
                &lt;/span&gt;
                &lt;h2 class="mt-2 fw-bold"&gt;[Judul Utama Seksi Halaman]&lt;/h2&gt;
                &lt;p class="text-muted fs-md max-w-600 mx-auto"&gt;
                    [Deskripsi singkat seksi halaman]
                &lt;/p&gt;
            &lt;/div&gt;
        &lt;/div&gt;

        &lt;!-- Section Content Grid --&gt;
        &lt;div class="row g-4"&gt;
            &lt;div class="col-lg-4"&gt;
                &lt;div class="card h-100 border shadow-sm"&gt;
                    &lt;div class="card-body p-4"&gt;
                        &lt;h5 class="fw-bold"&gt;Item Fitur&lt;/h5&gt;
                        &lt;p class="text-muted fs-14"&gt;Penjelasan konten...&lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/section&gt;</pre>
                </div>
            </div>
            <div class="modal-footer bg-light py-3">
                <button type="button" class="btn btn-primary px-4 fw-semibold" data-bs-dismiss="modal">Saya Paham</button>
            </div>
        </div>
    </div>
</div>
