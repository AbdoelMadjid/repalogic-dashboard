<!-- MODAL PETUNJUK OPERASIONALISASI BILINGUAL -->
<div class="modal fade" id="bilingualGuideModal" tabindex="-1" aria-labelledby="bilingualGuideModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info-subtle text-info">
                <h5 class="modal-title fw-bold" id="bilingualGuideModalTitle">
                    <i class="ti ti-language me-2 fs-18"></i> Petunjuk Operasionalisasi Sistem Bilingual (Multi-Bahasa)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- INFOGRAPH CARD / SUMMARY -->
                <div class="alert alert-info border-info-subtle d-flex align-items-start gap-3 mb-4">
                    <i class="ti ti-info-circle fs-24 text-info flex-shrink-0 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1 text-info">Konsep Utama Sistem Bilingual</h6>
                        <p class="mb-0 fs-13">
                            Sistem bilingual pada Repalogic Dashboard bekerja secara 100% dinamis tanpa reload halaman dengan menghubungkan
                            <strong>Atribut <code>data-lang</code></strong> pada menu dengan <strong>Kamus Terjemahan (file <code>id.json</code> &amp; <code>en.json</code>)</strong>.
                        </p>
                    </div>
                </div>

                <!-- ALUR LANGKAH OPERASIONAL -->
                <h6 class="fw-bold text-uppercase fs-12 text-muted mb-3"><i class="ti ti-list-check me-1"></i> Langkah Praktis Menambah / Mengelola Menu Bilingual:</h6>

                <div class="timeline-steps">
                    <!-- STEP 1 -->
                    <div class="border rounded p-3 mb-3 bg-light-subtle">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary px-2 py-1 me-2">Langkah 1</span>
                            <h6 class="mb-0 fw-semibold text-dark"><i class="ti ti-menu-2 me-1"></i> Pengaturan Menu &amp; Translation Key (Data Lang)</h6>
                        </div>
                        <p class="fs-13 text-muted mb-0 ms-1">
                            Buka halaman <strong>Manajemen Menu</strong> (<code>/admin/dukunganaplikasi/menu</code>). Saat menambah atau mengedit menu, isi field 
                            <strong class="text-dark">Translation Key (Data Lang)</strong> (contoh: <code>laporan-keuangan</code>). 
                            Jika dibiarkan kosong, sistem secara otomatis membuat key dari nama menu Anda (misal: <em>Laporan Keuangan</em> &rarr; <code>laporan-keuangan</code>).
                        </p>
                    </div>

                    <!-- STEP 2 -->
                    <div class="border rounded p-3 mb-3 bg-light-subtle">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success px-2 py-1 me-2">Langkah 2</span>
                            <h6 class="mb-0 fw-semibold text-dark"><i class="ti ti-world me-1"></i> Pengelolaan Terjemahan kata di Modul Translation</h6>
                        </div>
                        <p class="fs-13 text-muted mb-0 ms-1">
                            Buka halaman <strong>Terjemahan Bahasa</strong> (<code>/admin/dukunganaplikasi/translation</code>). Cari atau tambah key 
                            <code>laporan-keuangan</code>, lalu masukkan terjemahan:
                        </p>
                        <ul class="fs-13 text-muted mb-0 mt-2">
                            <li><strong>Bahasa Indonesia (ID):</strong> <code>Laporan Keuangan</code></li>
                            <li><strong>Bahasa Inggris (EN):</strong> <code>Financial Reports</code></li>
                        </ul>
                        <p class="fs-12 text-muted mb-0 mt-2 italic">
                            <i class="ti ti-check text-success me-1"></i> Perubahan disimpan langsung ke file <code>id.json</code> &amp; <code>en.json</code> di server tanpa perlu akses coding manual.
                        </p>
                    </div>

                    <!-- STEP 3 -->
                    <div class="border rounded p-3 bg-light-subtle">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-info px-2 py-1 me-2">Langkah 3</span>
                            <h6 class="mb-0 fw-semibold text-dark"><i class="ti ti-flag me-1"></i> Pengujian Alih Bahasa di Topbar</h6>
                        </div>
                        <p class="fs-13 text-muted mb-0 ms-1">
                            Ganti bahasa melalui tombol bendera di Topbar atas (Indonesia / English). Teks menu dan grup menu di Sidebar akan secara otomatis berganti bahasa secara <em>real-time</em>!
                        </p>
                    </div>
                </div>

                <!-- SAFE FALLBACK NOTICE -->
                <div class="mt-4 p-3 bg-warning-subtle border border-warning-subtle rounded-3">
                    <h6 class="fw-bold text-warning-emphasis mb-1"><i class="ti ti-shield-check me-1"></i> Garansi Tampilan Tetap Aman (Safe Fallback)</h6>
                    <p class="mb-0 fs-12 text-warning-emphasis">
                        Jika suatu menu baru belum sempat didaftarkan terjemahannya pada modul <strong>Terjemahan Bahasa</strong>, sistem secara aman akan tetap menampilkan Nama Asli menu dari database. Teks tampilan di layar tidak akan pernah kosong atau rusak.
                    </p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>
