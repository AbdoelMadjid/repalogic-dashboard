@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-primary bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-white text-primary fw-semibold px-3 py-1.5 rounded-pill mb-3">Version
                                Release History</span>
                            <h2 class="fw-bold text-white mb-2" data-lang="changelog">Changelog & Git Commit History</h2>
                            <p class="text-white-50 fs-16 mb-0">
                                Comprehensive timeline tracking of all architecture updates, menu refactoring, dynamic route
                                integrations, and fixes synced with GitHub commits.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <span
                                class="badge bg-white bg-opacity-20 text-white fs-14 px-3 py-2 border border-white border-opacity-20 rounded-3">
                                <i class="ti ti-git-commit me-1"></i> Current Build:
                                <strong>{{ config('app.version') }}</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Release Procedure Guide Card (Khusus Superadmin & Admin) -->
        @if (auth()->check() &&
                auth()->user()->hasAnyRole(['superadmin', 'admin']))
            <div class="col-12 mb-4">
                <div class="card border border-info-subtle shadow-sm">
                    <div class="card-header bg-info-subtle py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-info-emphasis">
                            <i class="ti ti-book me-2"></i> Standar Prosedur Pembaruan Versi Rilis / Tag (Version Release
                            Guide)
                        </h5>
                        <span class="badge bg-info text-white font-monospace">Centralized Engine</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary rounded-circle p-1.5 me-2"><i
                                                class="ti ti-settings fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">1. Update APP_VERSION</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Perbarui konstanta <code>APP_VERSION</code> pada <code>.env</code>,
                                        <code>.env.example</code>, dan <code>config/app.php</code>.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-success rounded-circle p-1.5 me-2"><i
                                                class="ti ti-history fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">2. Update Changelog View</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Tambahkan item timeline dengan timestamp presisi WIB di
                                        <code>resources/views/template/documentation/changelog.blade.php</code>.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-warning text-white rounded-circle p-1.5 me-2"><i
                                                class="ti ti-file-text fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">3. Update Release Doc</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Perbarui tabel riwayat release pada file
                                        <code>docs/riwayat_release_dan_tag.md</code>.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-danger rounded-circle p-1.5 me-2"><i
                                                class="ti ti-tag fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">4. Git Commit &amp; Tag</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Lakukan commit dengan format konvensional lalu buat tag release (contoh: <code>git
                                            tag -a v2.7.6 -m "Release v2.7.6"</code>).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Changelog Timeline Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="ti ti-timeline text-primary fs-20"></i>
                        <span>Linimasa Pembaruan Aplikasi</span>
                    </h5>
                    <span class="badge bg-primary-subtle text-primary font-monospace">Full History</span>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-icon-bordered">
                        <!-- Version 2.8.7 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-star-filled fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.7</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.7</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-05 10:55 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Chat Message Edit Engine (Batas Waktu 10 Menit &amp; Penanda Edited), Interactive Edit Preview Bar, Real-Time Polling Sync &amp; In-Place DOM Mutation</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fasilitas Edit Pesan Chat (<code>MessageController.php</code> &amp; <code>routes/admin.php</code>):</strong> Menyediakan endpoint <code>PUT /admin/profil-pengguna/messages/{id}</code> untuk memperbarui teks pesan obrolan yang dikirim oleh pengguna aktif dengan validasi ketat batas waktu maksimal 10 menit (<code>$message->created_at->addMinutes(10)->isFuture()</code>).</li>
                                    <li><strong class="text-dark">Skema Database &amp; Model (<code>2026_09_05_000001_add_edited_columns_to_messages_table.php</code> &amp; <code>Message.php</code>):</strong> Menambahkan kolom <code>is_edited</code> (boolean) dan <code>edited_at</code> (timestamp) pada tabel <code>messages</code> serta method helper <code>isEditableBy($userId)</code>.</li>
                                    <li><strong class="text-dark">Interactive Edit Preview Bar (<code>messages.blade.php</code> &amp; <code>messages.css</code>):</strong> Menghadirkan banner mode edit <code>#edit-preview-container</code> di atas bar input pesan lengkap dengan badge batas 10 menit, tombol pembatalan cepat (X), dan dukungan tombol keyboard <code>Escape</code>.</li>
                                    <li><strong class="text-dark">Penanda Teks Edited Transparan (<code>messages.blade.php</code> &amp; <code>messages.js</code>):</strong> Menampilkan indikator halus <code>(diedit)</code> di sebelah penanda waktu pesan baik saat render awal Blade maupun sinkronisasi real-time via background polling.</li>
                                    <li><strong class="text-dark">Sinkronisasi Polling In-Place &amp; Optimistic Update (<code>messages.js</code>):</strong> Memperbarui balon teks pesan, data atribut reply/edit, dan cuplikan pesan terakhir pada kontak sidebar seketika (0ms delay) tanpa merusak posisi scroll percakapan.</li>
                                    <li><strong class="text-dark">Penyempurnaan Antarmuka Fitur Aplikasi &amp; Tata Letak Linimasa (<code>fitur-aplikasi.blade.php</code> &amp; <code>changelog.blade.php</code>):</strong> Mengalibrasi ukuran tombol <em>Kembalikan Default</em> dengan ukuran ringkas (compact <code>btn-sm py-0 px-1.5 fs-12</code>) agar penanda aktif tab menempel rapi pada garis bawah header serta merapikan struktur kontainer <code>card-body p-4</code> pada halaman linimasa changelog.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.8.6 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.6</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.6</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-04 14:15 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Storage Media Synchronization &amp; Orphan Cleaner Engine, High-Resolution Image Lightbox Simulator &amp; Single / Bulk Orphan Media Purging in Fitur Aplikasi</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pusat Sinkronisasi Media Storage (<code>FiturAplikasiController.php</code> &amp; <code>routes/admin.php</code>):</strong> Menghadirkan engine pemindaian media penyimpanan server (<code>public</code> disk) terhadap seluruh entitas database terkait (<code>users</code>, <code>user_details</code>, <code>user_configs</code>, <code>profil_aplikasi</code>, <code>website_sections</code>, <code>messages</code>). Mengkategorikan media secara presisi menjadi berkas aktif (valid) dan berkas tidak terpakai (orphan).</li>
                                    <li><strong class="text-dark">Widget Kartu ke-6 Pengaturan Sistem (<code>fitur-aplikasi.blade.php</code>):</strong> Menambahkan kartu pengaturan sistem ke-6 <em>Sinkronisasi Media Storage</em> dengan indikator status dinamis, badge folder, serta tombol pemicu pemindaian modal terintegrasi.</li>
                                    <li><strong class="text-dark">Modal Interaktif Sinkronisasi &amp; Pembersih (<code>storage_image_sync_modal.blade.php</code>):</strong> Menyediakan 4 KPI ringkasan (Total Gambar Storage, Valid di Database, Gambar Sampah Orphan, dan Estimasi Ruang Hemat), filter folder dinamis, pencarian instan, dan tabel data orphan dengan thumbnail responsif.</li>
                                    <li><strong class="text-dark">Pratinjau Resolusi Tinggi / Lightbox Simulator (<code>storage_image_sync_modal.blade.php</code>):</strong> Memungkinkan administrator melihat pratinjau gambar resolusi asli lengkap dengan informasi detail lokasi storage, nama berkas, ukuran, direktori, dan tanggal modifikasi sebelum memutuskan untuk menghapus.</li>
                                    <li><strong class="text-dark">Eksekusi Pembersihan Multi-Mode (<code>fitur-aplikasi.js</code> &amp; <code>fitur-aplikasi.css</code>):</strong> Mendukung penghapusan satuan, penghapusan massal melalui kotak centang (bulk action), dan penghapusan seluruh gambar orphan dengan konfirmasi universal SweetAlert2 serta pembaruan statistik tanpa reload halaman.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.8.5 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.5</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-04 13:48 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Idle Lock Screen Seamless Re-Authentication, Global Dynamic CSRF Token Sync, Zero-419 Graceful Handler, Universal Logout Session Invalidation &amp; Custom 419 Error Template</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Penanganan Otentikasi Ulang Layar Terkunci (<code>LockScreenController.php</code> &amp; <code>lock-screen-modal.blade.php</code>):</strong> Memungkinkan pengguna yang ditinggalkan <em>idle</em> melebihi masa sesi untuk tetap dapat membuka kunci layar menggunakan password akunnya tanpa terblokir pesan <em>"kesalahan jaringan"</em>. Sistem memvalidasi password dan meregenerasi sesi otentikasi serta token CSRF baru secara mulus di latar belakang.</li>
                                    <li><strong class="text-dark">Pengecualian CSRF &amp; Graceful TokenMismatchException (<code>bootstrap/app.php</code>):</strong> Mendaftarkan rute <code>lock-screen/unlock</code> dan <code>logout</code> dalam pengecualian validasi CSRF serta menambahkan interceptor <code>TokenMismatchException</code> terpusat. Request AJAX mengembalikan respon JSON terstruktur (status 419/401) dan request web otomatis dialihkan ke halaman login tanpa menampilkan layar putih <em>419 Page Expired</em>.</li>
                                    <li><strong class="text-dark">Penyempurnaan Rute &amp; Aksi Logout (<code>routes/auth.php</code>):</strong> Mendukung metode <code>GET</code> dan <code>POST</code> pada rute <code>/logout</code> serta memastikan klik tombol <em>Keluar / Ganti Akun</em> pada modal lock screen mengeksekusi logout dan pembersihan sesi dengan sempurna.</li>
                                    <li><strong class="text-dark">Sinkronisasi Global Token CSRF Dinamis (<code>title-meta.blade.php</code>, <code>dashboard.js</code> &amp; <code>lock-screen-modal.blade.php</code>):</strong> Menyediakan fungsi global <code>window.getCsrfToken()</code> dan <code>window.setCsrfToken()</code>. Seluruh modul AJAX interaktif (Pertemanan, Like Profil, Notifikasi, Pesan, Konfigurasi) kini mengambil token CSRF terkini secara dinamis pada setiap request, sehingga tidak mengalami galat <em>CSRF token mismatch</em> setelah sesi diperbarui dari layar kunci.</li>
                                    <li><strong class="text-dark">Halaman Kesalahan Branded 419 (<code>resources/views/errors/419.blade.php</code>):</strong> Menyediakan template halaman khusus <em>419 Page Expired</em> bertema Repalogic Dashboard dengan tombol navigasi cepat <em>Masuk Kembali</em> dan <em>Muat Ulang Halaman</em>.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Idle Lock Screen</span>
                                    <span class="badge bg-light text-dark border fs-xs">Session Re-Auth</span>
                                    <span class="badge bg-light text-dark border fs-xs">CSRF Protection</span>
                                    <span class="badge bg-light text-dark border fs-xs">Zero 419 Error</span>
                                    <span class="badge bg-light text-dark border fs-xs">Custom 419 Page</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.8.4 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.4</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-04 11:35 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Card with Tabs System Control Center, Persistent Database Settings (`app_settings`), Topbar Realtime Instant DOM Toggle, Zero-Reload Bulk Actions, Active Tab Persistence &amp; Factory Reset to Seeder</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Arsitektur Card with Tabs Terstandarisasi (<code>fitur-aplikasi.blade.php</code> &amp; <code>fitur-aplikasi.css</code>):</strong> Merestrukturisasi halaman kontrol fitur menjadi 2 tab navigasi (<em>Tab 1: Pengaturan Sistem</em> dan <em>Tab 2: Visibilitas Fitur &amp; Komponen</em>) menggunakan standar tema <code>.card-tabs</code> dan <code>.card-header-tabs.nav-bordered</code> yang bersih dan responsif.</li>
                                    <li><strong class="text-dark">Penyimpanan Pengaturan Persisten Database (<code>AppSetting.php</code> &amp; <code>AppSettingSeeder.php</code>):</strong> Migrasi penyimpanan seluruh pengaturan sistem (Idle Timeout, Maintenance Mode, Rate Limit, Polling Interval, Audio &amp; Toast Notification) ke tabel persisten <code>app_settings</code> dengan dual-layer caching dan kamus fallback default.</li>
                                    <li><strong class="text-dark">Engine Visibilitas Realtime Topbar Header &amp; Sidebar (<code>topbar.blade.php</code> &amp; <code>fitur-aplikasi.js</code>):</strong> Menghilangkan server-side omission pada partial Topbar sehingga seluruh elemen selalu ada di DOM dengan atribut <code>data-feature</code>. Fungsi <code>toggleFeatureElementInDOM</code> langsung menampilkan atau menyembunyikan elemen Topbar &amp; grup menu Sidebar secara instan saat sakelar tabel diubah via AJAX tanpa reload.</li>
                                    <li><strong class="text-dark">Persistensi Tab Aktif &amp; Aksi Massal Tanpa Reload (<code>fitur-aplikasi.js</code>):</strong> Menjaga tab aktif pengguna melalui <code>localStorage</code> dan URL hash (<code>history.replaceState</code>). Aksi massal (Aktifkan, Nonaktifkan, Hapus Terpilih) kini mengeksekusi pembaruan status dan DOM secara instan tanpa reload halaman, memastikan pengguna tetap di tab aktif.</li>
                                    <li><strong class="text-dark">Fitur Kembalikan Default Pabrik (Factory Reset to Seeder):</strong> Menambahkan tombol <em>Kembalikan Default</em> di header kartu dengan dialog konfirmasi SweetAlert2 untuk mereset seluruh nilai <code>app_settings</code> dan status <code>fitur_aplikasi</code> kembali ke data seeder bawaan secara otomatis.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Control Center</span>
                                    <span class="badge bg-light text-dark border fs-xs">Card with Tabs</span>
                                    <span class="badge bg-light text-dark border fs-xs">Realtime Topbar Toggle</span>
                                    <span class="badge bg-light text-dark border fs-xs">AppSetting Model</span>
                                    <span class="badge bg-light text-dark border fs-xs">Reset to Seeder</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.8.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-04 09:22 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Modern 3-Dots Action Dropdown Menu in Chat Bubble (Balas, Teruskan, Pin &amp; Hapus), Streamlined Message Timestamp Footer &amp; Inline Clean Reaction Results</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Menu Aksi Titik Tiga (3-Dots Dropdown) di Sudut Bubble Chat (<code>messages.blade.php</code> &amp; <code>messages.js</code>):</strong> Merapikan tata letak tombol aksi pesan dengan mengemas opsi <em>Balas</em>, <em>Teruskan</em>, <em>Pin / Lepas Pin</em>, dan <em>Hapus Pesan</em> ke dalam tombol titik tiga (<em>three-dots ellipsis menu</em>) pada sudut kiri atas untuk lawan bicara dan sudut kanan atas untuk pesan sendiri.</li>
                                    <li><strong class="text-dark">Penataan Hasil Reaksi Emosi Bersih di Samping Tombol Reaksi:</strong> Hasil reaksi emoji kini ditampilkan sejajar langsung di samping tombol reaksi emoji tanpa badge/border (hanya emotikon dan angka). Pada pesan sendiri, hasil reaksi berada di sebelah kanan tombol reaksi. Pada pesan lawan bicara, hasil reaksi berada di sebelah kiri tombol reaksi.</li>
                                    <li><strong class="text-dark">Penyederhanaan Baris Informasi Bawah Bubble Chat:</strong> Membersihkan deretan tombol aksi di bawah bubble pesan sehingga hanya menampilkan waktu pengiriman, lencana sematan (<em>pinned badge</em>), dan tombol reaksi emoji beserta hasil reaksinya secara elegan dan proporsional.</li>
                                    <li><strong class="text-dark">Sinkronisasi Real-Time Reaksi Emoji &amp; Sematan Pin Lawan Bicara (<code>messages.js</code>):</strong> Menambahkan mekanisme <em>in-place selective DOM sync</em> pada polling berkala percakapan. Saat lawan bicara menambahkan/menghapus reaksi emoji atau menyematkan/melepas pin pesan, perubahan langsung ter-update secara otomatis di layar lawan bicara tanpa me-reset posisi scroll pengguna atau mengganggu pemutaran audio.</li>
                                    <li><strong class="text-dark">Desain &amp; Transisi Dropdown Interaktif (<code>messages.css</code>):</strong> Menambahkan efek visual blur halus pada tombol titik tiga dengan opasitas adaptif saat hover, dropdown menu beranimasi lembut, serta pemisahan opsi aksi berbahaya (<em>Hapus</em>) dengan warna merah dan garis pemisah.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Messages &amp; Chat</span>
                                    <span class="badge bg-light text-dark border fs-xs">3-Dots Dropdown Menu</span>
                                    <span class="badge bg-light text-dark border fs-xs">Inline Clean Reactions</span>
                                    <span class="badge bg-light text-dark border fs-xs">Emoji Placement Alignment</span>
                                    <span class="badge bg-light text-dark border fs-xs">Chat Bubble Refinement</span>
                                    <span class="badge bg-light text-dark border fs-xs">Optimistic UI Sync</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.8.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.8.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-04 09:12 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Admin Customizer Optimize Clear Engine &amp; Reset Layout Restoration, Topbar Language Anti-Flicker, User Profile Motto Text Color Customizer &amp; Real-Time Live Visual Cover Background Preview</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tombol Aksi Cepat "Optimize Clear" pada Kustomisasi Admin (<code>customizer.blade.php</code> &amp; <code>DashboardController.php</code>):</strong> Menggantikan tombol "Beli Sekarang" dengan tombol interaktif untuk menjalankan perintah <code>php artisan optimize:clear</code> secara asinkron (AJAX) lengkap dengan dialog konfirmasi SweetAlert2 dan notifikasi status real-time.</li>
                                    <li><strong class="text-dark">Perbaikan Reset Layout Kustomisasi (<code>app.js</code> &amp; <code>config.js</code>):</strong> Menyelaraskan tombol "Atur Ulang" agar mengembalikan seluruh konfigurasi tema ke nilai bawaan murni tanpa tertimpa atau terpolusi oleh cache sessionStorage.</li>
                                    <li><strong class="text-dark">Pencegahan Kedipan Topbar Pemilihan Bahasa (<code>language-selector.blade.php</code>):</strong> Mengoptimalkan render dropdown bahasa pada topbar saat navigasi halaman sehingga transisi perpindahan menu berjalan mulus tanpa flicker visual.</li>
                                    <li><strong class="text-dark">Kustomisasi Warna Teks Motto Hidup &amp; Migrasi Skema (<code>user_configs</code>):</strong> Menambahkan kolom <code>motto_color</code> pada tabel database serta kontrol input pemilih warna kustom dan 8 preset swatch warna teks pada kartu Motto Hidup di profil pengguna.</li>
                                    <li><strong class="text-dark">Kotak Pratinjau Visual Motto Berbasis Background Foto Sampul:</strong> Menghadirkan kotak pratinjau langsung teks motto yang terintegrasi secara visual dengan foto sampul, lapisan warna (*overlay*), opasitas, dan tingkat blur foto sampul profil pengguna secara real-time.</li>
                                    <li><strong class="text-dark">Pemisahan Total Handler &amp; Kelas Swatch (Rule 2 Compliance):</strong> Mengisolasi kelas swatch foto sampul (<code>.btn-cover-color-swatch</code>) dan swatch motto (<code>.btn-motto-color-swatch</code>) sehingga aksi pemilihan warna pada motto tidak mempengaruhi pengaturan latar foto sampul.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Admin Customizer</span>
                                    <span class="badge bg-light text-dark border fs-xs">Optimize Clear</span>
                                    <span class="badge bg-light text-dark border fs-xs">Motto Color Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">Live Visual Cover Preview</span>
                                    <span class="badge bg-light text-dark border fs-xs">Anti-Flicker Topbar</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.8.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.8.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 22:05
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Modular Translation Dictionaries Architecture (6
                                    Isolated Domains), Parallel i18n Loader Engine (`Promise.all`), Tab-Based Translation
                                    Manager &amp; Auto-Sync Model Hooks</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Arsitektur 6 Domain Kamus Modular Terisolasi:</strong>
                                        Memecah kamus monolitik menjadi 6 sub-file terpisah di
                                        <code>public/assets/data/translations/id/</code> dan <code>en/</code>:
                                        <code>sidebar_template.json</code>, <code>sidebar_menu.json</code>,
                                        <code>topbar.json</code>, <code>auth.json</code>, <code>customizer.json</code>, dan
                                        <code>frontpage.json</code>.</li>
                                    <li><strong class="text-dark">Parallel i18n Loader Engine (<code>I18nManager</code> di
                                            <code>app.js</code>):</strong> Mengadopsi <code>Promise.allSettled</code> untuk
                                        memuat seluruh modul kamus secara simultan dari server/cache dan menggabungkannya ke
                                        dalam satu runtime dictionary memori yang sangat cepat (&lt; 5ms) dengan graceful
                                        fallback ke root JSON.</li>
                                    <li><strong class="text-dark">Navigasi Tab Interaktif di Admin Manager
                                            (<code>translation.blade.php</code>):</strong> Panel manajemen terjemahan kini
                                        dilengkapi Nav Pills Tab per domain modul dengan counter badge real-time, pencarian
                                        responsif, dan pembaruan URL query param tanpa reload (History API).</li>
                                    <li><strong class="text-dark">Penyelarasan Model Hook &amp; CRUD Berbasis Domain
                                            (<code>TranslationController.php</code> &amp; <code>Menu.php</code>):</strong>
                                        Aksi simpan/edit/hapus dan event <code>Menu::saved</code> kini secara presisi
                                        menulis langsung ke sub-kamus domain bersangkutan serta menjaga file master
                                        auto-merged tetap sinkron.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Modular i18n Suite</span>
                                    <span class="badge bg-light text-dark border fs-xs">6 Domain Dictionaries</span>
                                    <span class="badge bg-light text-dark border fs-xs">Parallel Loader Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">Tab-Based Admin UI</span>
                                    <span class="badge bg-light text-dark border fs-xs">Auto-Sync Model Hooks</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.8.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.8.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.8.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 21:30
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Comprehensive Technical Architecture Documentation
                                    Suite (Manajemen Menu, Pertemanan-Notifikasi-Chat Triad, Manajemen Pengguna 6-Pilar
                                    &amp; Sistem Bilingual i18n) &amp; Standardisasi GitHub-Relative Markdown Links</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Arsitektur &amp; Operasional Manajemen Menu
                                            (<code>docs/arsitektur_dan_operasional_manajemen_menu.md</code>):</strong>
                                        Dokumentasi komprehensif struktur navigasi hierarkis 3-level (Kategori &gt; Menu
                                        Utama &gt; Sub-Menu L2 &amp; L3), drag &amp; drop reordering SortableJS, cascading
                                        status toggle berjenjang, sinkronisasi otomatis Spatie permission CRUD, auto-sync
                                        kamus bilingual multi-bahasa, dan dynamic sidebar <code>SidebarComposer</code>.</li>
                                    <li><strong class="text-dark">Arsitektur &amp; Operasional Pertemanan, Notifikasi &amp;
                                            Chat Triad
                                            (<code>docs/arsitektur_dan_operasional_pertemanan_notifikasi_chat.md</code>):</strong>
                                        Dokumentasi mendalam triad ekosistem sosial interaktif (ajakan berteman, profile
                                        likes, lonceng notifikasi real-time, intersepsi deep link dashboard, mutasi kartu
                                        chat 1-on-1, dan quad-polling synchronization engine).</li>
                                    <li><strong class="text-dark">Arsitektur &amp; Operasional Manajemen Pengguna
                                            (<code>docs/arsitektur_dan_operasional_manajemen_pengguna.md</code>):</strong>
                                        Dokumentasi lengkap 6 sub-modul inti: Role, Permission, Akses Role matrix table,
                                        Akses User direct permissions, Users lifecycle (approval, impersonation,
                                        deactivation, bulk role), dan Data Login audit trail.</li>
                                    <li><strong class="text-dark">Arsitektur &amp; Operasional Sistem Bilingual
                                            (<code>docs/arsitektur_dan_operasional_bilingual.md</code>):</strong>
                                        Dokumentasi lengkap engine multi-bahasa dua arah (ID &amp; EN), kamus
                                        <code>id.json</code> &amp; <code>en.json</code>, alih bahasa instan tanpa reload
                                        melalui atribut <code>data-lang</code>, model listener <code>Menu::saved</code>, dan
                                        artisan scanner CLI <code>menu:lang-sync</code>.</li>
                                    <li><strong class="text-dark">Standardisasi Tautan Markdown Relatif GitHub:</strong>
                                        Pembersihan seluruh tautan protokol absolut lokal (<code>file:///</code>) pada
                                        seluruh berkas dokumentasi menjadi relative repository path
                                        (<code>../app/...</code>, <code>../resources/...</code>, <code>../public/...</code>)
                                        untuk penjelajahan langsung dan mulus di repositori GitHub.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Technical Docs Suite</span>
                                    <span class="badge bg-light text-dark border fs-xs">Menu Management Arch</span>
                                    <span class="badge bg-light text-dark border fs-xs">Social Triad Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">User Management 6-Pillars</span>
                                    <span class="badge bg-light text-dark border fs-xs">Bilingual i18n Arch</span>
                                    <span class="badge bg-light text-dark border fs-xs">GitHub-Relative Links</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.6 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.6</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.6</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 17:40
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Overhaul Tata Letak &amp; Form Edit Langsung Profil
                                    Pengguna (Single-Page Architecture), Restrukturisasi Tabel KTP 2-Kolom, Perapihan Card
                                    Penonaktifan Akun &amp; Perbaikan Inisialisasi Script Cover Header</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Single-Page Direct Profile Management
                                            Architecture:</strong> Eliminasi halaman edit terpisah
                                        (<code>admin/profil-pengguna/edit</code>) dan modal edit profil cepat. Seluruh
                                        formulir (Edit Profil Singkat, Motto Hidup, Detail KTP &amp; Alamat, Pengaturan Foto
                                        Sampul, dan Penonaktifan Akun) kini terintegrasi langsung pada route
                                        <code>admin/profil-pengguna</code>.</li>
                                    <li><strong class="text-dark">Restrukturisasi Tabel 2-Kolom Detail KTP &amp;
                                            Alamat:</strong> Transformasi antarmuka pengisian data KTP menjadi format tabel
                                        2-kolom yang elegan dan presisi. Kolom kiri memuat label identitas beserta thumbnail
                                        foto KTP berukuran proporsional yang dilengkapi tombol <em>Preview</em> dan
                                        <em>Unduh</em> di bawah foto, sedangkan kolom kanan memuat kontrol input/upload
                                        data.</li>
                                    <li><strong class="text-dark">Penyelarasan Tata Letak Kolom Sidebar:</strong>
                                        Memindahkan kartu <em>Permohonan Penonaktifan Akun</em> ke bawah kartu <em>Motto
                                            Hidup</em> pada kolom kiri dengan tata letak vertikal terstruktur (judul,
                                        deskripsi, dan tombol aksi berukuran penuh) serta penyematan badge <em>Danger
                                            Zone</em> sejajar di samping judul.</li>
                                    <li><strong class="text-dark">Perbaikan Sintaks &amp; Inisialisasi Script Eksternal
                                            Cover Header:</strong> Pembersihan deklarasi variabel duplikat pada
                                        <code>profil-pengguna.js</code> dan standardisasi pemuatan fungsi inisialisasi
                                        dengan pengecekan <code>document.readyState</code>, memulihkan seluruh
                                        fungsionalitas real-time live preview (swatch warna, slider opacity, blur, height,
                                        dan posisi vertikal).</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Profile Layout Overhaul</span>
                                    <span class="badge bg-light text-dark border fs-xs">Single-Page Architecture</span>
                                    <span class="badge bg-light text-dark border fs-xs">2-Column KTP Table</span>
                                    <span class="badge bg-light text-dark border fs-xs">Cover Header JS Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Danger Zone Card Clean-up</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.5 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.5</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 16:55
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Real-Time Friendship &amp; Profile Synchronization
                                    Engine, Interactive Notification Search Auto-Fill, Contextual Filter Transitions &amp;
                                    Prioritized Contact Directory Hierarchy</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Real-Time Full User Profile &amp; Friendship Polling
                                            Engine:</strong> Sinkronisasi latar belakang setiap 3.5 detik pada endpoint
                                        <code>admin/friendships/poll-dashboard</code> untuk memperbarui seluruh data
                                        pengguna (foto sampul banner, avatar profil, motto hidup, nomor WhatsApp/telepon,
                                        domisili, pekerjaan, poin login, jumlah suka profil, status ajakan berteman, serta
                                        status online/offline) secara instan tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Hierarki Pengurutan Prioritas Direktori Kontak:</strong>
                                        Menyusun kartu pengguna secara cerdas dengan hierarki: (1) Akun Profil Sendiri di
                                        posisi terdepan, (2) Teman yang sedang Online, (3) Teman yang sedang Offline, (4)
                                        Bukan teman tetapi sedang Online, dan (5) Bukan teman yang sedang Offline.</li>
                                    <li><strong class="text-dark">Auto-Fill Search &amp; Auto-Focus dari Notifikasi Ajakan
                                            Berteman:</strong> Mengklik notifikasi ajakan berteman di topbar langsung
                                        menutup dropdown, mengisi nama pengirim ke input live search, mengaktifkan tab
                                        'Ajakan Masuk', dan mengarahkan tampilan ke kartu kontak yang bersangkutan.</li>
                                    <li><strong class="text-dark">Transisi Tab Filter &amp; Reset Pencarian
                                            Responsif:</strong> Saat ajakan berteman diterima, kolom pencarian otomatis
                                        dikosongkan dan tab berpindah ke 'Teman Saya'. Saat ajakan ditolak, kolom pencarian
                                        dikosongkan dan tab berpindah ke 'Semua'.</li>
                                    <li><strong class="text-dark">Robust Multi-Attempt Friendship Re-request
                                            Engine:</strong> Menangani pengajuan kembali ajakan berteman setelah sebelumnya
                                        pernah ditolak atau dibatalkan tanpa terjadi benturan database unique constraint.
                                    </li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Real-Time Profile Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Prioritized Contact
                                        Hierarchy</span>
                                    <span class="badge bg-light text-dark border fs-xs">Notification Search Autofill</span>
                                    <span class="badge bg-light text-dark border fs-xs">Friendship Re-Request Engine</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.4 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.4</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 14:18
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Comprehensive Friendship Network System, Profile
                                    Likes Engine, Interactive Friend Requests &amp; Dashboard Directory Filter Tabs</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Sistem Manajemen Pertemanan &amp; Ajakan Berteman (Friend
                                            Requests):</strong> Implementasi database migration <code>friendships</code>
                                        (<code>sender_id</code>, <code>receiver_id</code>, <code>status:
                                            pending|accepted|rejected</code>), integrasi model <code>Friendship</code>,
                                        serta <code>FriendshipController</code> untuk mengirim ajakan, membatalkan ajakan,
                                        menerima/menolak ajakan, dan menghapus pertemanan (<em>unfriend</em>) dengan
                                        konfirmasi SweetAlert2.</li>
                                    <li><strong class="text-dark">Fasilitas Apresiasi Suka Profil (Profile Likes
                                            Engine):</strong> Implementasi database migration <code>profile_likes</code>
                                        dengan relasi unik antar pengguna, tombol like melayang (<em>glassmorphism love
                                            button</em>) di sudut atas cover kartu kontak dengan efek detak jantung
                                        (<em>heart-pulse animation</em>) dan update hitungan like secara instan via AJAX
                                        tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Tab Filter Jaringan Pertemanan pada Direktori
                                            Dashboard:</strong> Menyediakan navigasi filter cepat di bagian atas konten
                                        widget direktori pengguna (Semua Pengguna, Teman Saya, Ajakan Masuk dengan badge
                                        merah, dan Ajakan Terkirim) yang terintegrasi secara mulus dengan live keyword
                                        search di header dan paginasi tombol panah muat lebih banyak.</li>
                                    <li><strong class="text-dark">Integrasi Notifikasi &amp; Statistik Profil:</strong>
                                        Penambahan statistik total teman dan total like profil pada kartu ringkasan hero
                                        dashboard serta halaman Profil Pengguna, ditambah integrasi notifikasi otomatis saat
                                        menerima ajakan berteman baru di dropdown topbar notifikasi.</li>
                                    <li><strong class="text-dark">Real-Time Full User Profile &amp; Friendship Polling
                                            Engine:</strong> Sinkronisasi data real-time otomatis setiap 3.5 detik tanpa
                                        reload halaman pada endpoint <code>admin/friendships/poll-dashboard</code> untuk
                                        memperbarui seluruh data pengguna (foto sampul banner, avatar profil, motto hidup,
                                        nomor WhatsApp/telepon, domisili, pekerjaan, poin login, jumlah suka profil, status
                                        ajakan berteman, serta status online/offline) secara instan.</li>
                                    <li><strong class="text-dark">Sistem Hierarki Pengurutan Kartu Kontak Direktori
                                            Pengguna:</strong> Kartu kontak pengguna diurutkan secara cerdas berdasarkan
                                        prioritas relasi dan kehadiran: (1) Profil kita sendiri selalu berada di urutan
                                        terdepan, (2) Teman yang sedang online, (3) Teman yang sedang offline, (4) Pengguna
                                        lain yang sedang online, dan (5) Pengguna lain yang sedang offline.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Friendship Network</span>
                                    <span class="badge bg-light text-dark border fs-xs">Profile Likes Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">Friend Requests (Ajakan
                                        Berteman)</span>
                                    <span class="badge bg-light text-dark border fs-xs">Directory Friendship Tabs</span>
                                    <span class="badge bg-light text-dark border fs-xs">SweetAlert2 Friend
                                        Confirmations</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 13:55
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">WhatsApp &amp; Phone Number Field Extension in User
                                    Details, Instant Click-to-Chat Integration &amp; Dashboard Contacts Directory Sync</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Penambahan Kolom Telepon pada
                                            <code>user_details</code>:</strong> Menambahkan kolom <code>telepon</code>
                                        (string 30, nullable) melalui database migration terstruktur, integrasi model
                                        <code>UserDetail</code> ($fillable, $appends), dan accessor cerdas
                                        <code>telepon_wa_url</code> yang mengonversi format nomor lokal (<code>08xxx</code>)
                                        menjadi tautan pesan instan resmi WhatsApp (<code>https://wa.me/628xxx</code>).</li>
                                    <li><strong class="text-dark">Visualisasi Telepon &amp; WhatsApp di Widget Dashboard
                                            (<code>dashboard.blade.php</code>):</strong> Menampilkan nomor telepon /
                                        WhatsApp pada setiap kartu kontak di widget Direktori Pengguna &amp; Kontak lengkap
                                        dengan ikon WhatsApp hijau, tautan langsung ke WhatsApp Web/App, serta penambahan
                                        atribut pencarian <code>data-search-phone</code> untuk filter instan berdasarkan
                                        nomor HP.</li>
                                    <li><strong class="text-dark">Form Kelengkapan Profil &amp; Modal Detail
                                            Pengguna:</strong> Menyediakan input nomor telepon/WhatsApp pada form edit
                                        profil KTP (<code>admin/profil-pengguna/edit</code>), visualisasi pada kartu
                                        ringkasan profil dan tabel rincian KTP, sinkronisasi pada modal detail akun obrolan
                                        (<code>#user-detail-modal</code>), serta pembaruan data pengguna di Manajemen
                                        Pengguna.</li>
                                    <li><strong class="text-dark">Kutipan Motto Mengambang di Atas Foto Sampul (Cover
                                            Banner Overlay):</strong> Menempatkan teks motto langsung di atas banner foto
                                        sampul setiap kartu pengguna dengan lapisan gradien kontras dan bayangan teks
                                        (`contact-cover-motto`), persis seperti pada halaman Profil Pengguna. Hal ini
                                        memastikan teks kutipan langsung terbaca tanpa perlu diklik, sekaligus menjamin
                                        tinggi seluruh kartu direktori tetap 100% simetris dan seragam.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">User Details Telepon</span>
                                    <span class="badge bg-light text-dark border fs-xs">WhatsApp Click-to-Chat</span>
                                    <span class="badge bg-light text-dark border fs-xs">Dashboard Contact Phone Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Cover Motto Overlay</span>
                                    <span class="badge bg-light text-dark border fs-xs">Profile Completeness Score</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 13:48
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dynamic User Directory &amp; Contacts Hub,
                                    Incremental 12-Card Load More Engine with Down Arrow Animation &amp; Messages Detail
                                    Cover Photo Sync</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Widget Penuh Direktori Pengguna &amp; Kontak
                                            (<code>dashboard.blade.php</code>):</strong> Menyajikan widget direktori kontak
                                        responsif dengan kartu pengguna (berdasar inspirasi
                                        <code>template/apps/users/contacts</code>) yang dilengkapi banner foto sampul
                                        dinamis (<code>$u-&gt;cover_bg_url</code>), avatar bertumpuk (*overlapping*), status
                                        kehadiran online/offline, rincian metadata (pekerjaan, domisili, poin login), tombol
                                        kirim pesan instan, dan penempatan kartu akun sendiri di paling kiri atas (*slot
                                        #1*).</li>
                                    <li><strong class="text-dark">Pola Perluasan *Incremental Load More* dengan Anak Panah
                                            ke Bawah:</strong> Menampilkan 12 kartu pengguna awal dan tombol *"Tampilkan 12
                                        Pengguna Berikutnya"* beranimasi membal lembut (<code>.animated-bounce-down</code>)
                                        yang otomatis berpindah ke bawah setiap kali diklik dan hilang secara otomatis saat
                                        seluruh data telah ditampilkan.</li>
                                    <li><strong class="text-dark">Pencarian Langsung Terintegrasi (*Live Search*):</strong>
                                        Fitur *instant client-side search* berdasarkan nama, email, domisili/kota, dan
                                        pekerjaan yang secara cerdas me-reset batas *load more* tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Modal Detail Akun Pesan dengan Foto Sampul Dinamis
                                            (<code>admin/profil-pengguna/messages</code>):</strong> Mengintegrasikan banner
                                        foto sampul pengguna (<code>$user-&gt;cover_bg_url</code>), perataan vertikal
                                        (<code>$user-&gt;cover_position_y</code>), motto kutipan, dan overlay kontras tinggi
                                        pada bagian atas modal *Detail Akun* (<code>#user-detail-modal</code>), lengkap
                                        dengan sinkronisasi instan via AJAX dan event delegation.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">User Directory Hub</span>
                                    <span class="badge bg-light text-dark border fs-xs">Incremental Load More</span>
                                    <span class="badge bg-light text-dark border fs-xs">Down Arrow Animation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Messages Modal Cover Sync</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 13:00
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Cover Custom Overlay Engine: Dynamic
                                    Color Picker &amp; Theme Swatches, Adjustable Overlay Opacity (0% - 100%), Layer Blur
                                    Intensity Slider (0px - 20px) &amp; Real-Time Live WYSIWYG Integration</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Dynamic Color Picker &amp; Theme Swatches:</strong>
                                        Memungkinkan pengguna memilih warna dasar lapisan overlay foto sampul menggunakan
                                        color picker kustom dan 6 palet preset warna tema cepat.</li>
                                    <li><strong class="text-dark">Adjustable Overlay Opacity Slider (0% - 100%):</strong>
                                        Menghadirkan pengaturan ketebalan warna overlay dari 0% (transparan penuh / foto
                                        murni) hingga 100% (pekat) dengan preset instan (0%, 60%, 85%).</li>
                                    <li><strong class="text-dark">Layer Blur Intensity Slider (0px - 20px):</strong>
                                        Memberikan kebebasan mengatur tingkat blur lapisan dari 0px (tanpa blur / foto tajam
                                        jernih) hingga 20px (efek *frosted glass blur*) dengan preset cepat (0px, 6px,
                                        14px).</li>
                                    <li><strong class="text-dark">Real-Time WYSIWYG Integration
                                            (<code>profil-pengguna.js</code>):</strong> Perubahan warna, ketebalan, dan blur
                                        langsung ter-render secara instan (*real-time*) di banner header utama dan kotak
                                        preview mini sebelum form disimpan.</li>
                                    <li><strong class="text-dark">Preserved Native Architecture &amp; Sidebar
                                            Flow:</strong> Mempertahankan 100% struktur halaman asli, alur cropping tinggi
                                        bingkai banner, posisi vertikal, ganti foto sampul, motto, avatar, dan dokumen KTP
                                        tanpa gangguan.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Dynamic Cover Overlay</span>
                                    <span class="badge bg-light text-dark border fs-xs">Color Swatches</span>
                                    <span class="badge bg-light text-dark border fs-xs">Adjustable Blur Intensity</span>
                                    <span class="badge bg-light text-dark border fs-xs">Live WYSIWYG Preview</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.7.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.7.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.7.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 11:36
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dynamic Data-Driven &amp; Role-Based Dashboard
                                    Engine, User-Configured Cover Banner &amp; Height Sync, Precision WIB Greeting Engine,
                                    Deduplicated Chat Preview Card Suite &amp; Symmetrical Rhythm Architecture</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Dynamic Data-Driven Dashboard Architecture
                                            (<code>DashboardController.php</code>):</strong> Transformasi penuh halaman
                                        utama dari dummy template menjadi dasbor live analitik yang menyajikan KPI ringkasan
                                        akun, ApexCharts tren login &amp; pendaftaran 7 hari, Donut Chart distribusi Spatie
                                        Role, Pusat Tindakan Tertunda (Persetujuan &amp; Penonaktifan Akun), serta Pintasan
                                        Cepat (*Quick Action Tiles*).</li>
                                    <li><strong class="text-dark">Dual Role-Based Dashboard View (Admin vs Regular
                                            User):</strong> Menyajikan dasbor terpisah berbasis hak akses; Superadmin/Admin
                                        mendapatkan metrik operasional sistem, sedangkan pengguna umum (Role: User)
                                        disajikan statistik personal (Poin Login, Obrolan Saya, Status Verifikasi, Progres
                                        Kelengkapan Profil %, dan Riwayat Sesi Masuk).</li>
                                    <li><strong class="text-dark">Hero Greeting Card dengan Foto Sampul Dinamis &amp;
                                            Sinkronisasi Ketinggian:</strong> Mengintegrasikan foto sampul profil kustom
                                        (<code>$user-&gt;cover_bg_url</code>), perataan vertikal
                                        (<code>$user-&gt;cover_position_y</code>), dan pengaturan tinggi banner kustom
                                        (<code>min-height: @{{ $user - > cover_height }}px</code>) dengan lapisan *dark
                                        glassmorphism overlay* untuk kontras teks optimal.</li>
                                    <li><strong class="text-dark">Mesin Sapaan Waktu Presisi WIB
                                            (<code>Asia/Jakarta</code>):</strong> Engine greeting dinamis (*Selamat Pagi,
                                        Siang, Sore, Malam*) yang diselaraskan dengan zona waktu lokal Indonesia Barat.</li>
                                    <li><strong class="text-dark">Hierarki Metadata &amp; Irama Garis Vertikal
                                            Simetris:</strong> Penataan terstruktur baris informasi di bawah login terakhir
                                        (Email • Role Utama Tunggal • Poin Login Keemasan) tanpa badge, serta pembagian
                                        jarak simetris (8px / <code>0.5rem</code>) menuju garis pembatas dan kutipan motto
                                        profil.</li>
                                    <li><strong class="text-dark">Widget Obrolan Elegan &amp; Bebas Duplikasi
                                            (<code>.chat-preview-item</code>):</strong> Pengelompokan percakapan berbasis
                                        kontak lawan bicara (1 kontak = 1 baris preview dengan pesan terbaru), pemotongan
                                        foto avatar proporsional (<code>object-position: top</code>), dan penataan layout
                                        lega dengan stempel waktu dan cuplikan teks satu baris.</li>
                                    <li><strong class="text-dark">Universal Accessor &amp; Safe Seeder Fallbacks:</strong>
                                        Penggunaan menyeluruh <code>$user-&gt;avatar_url</code>, perbaikan rute Spatie role
                                        (<code>admin.manajemenpengguna.role.index</code>), serta perlindungan *null-safety*
                                        menjamin dasbor 100% aman saat dieksekusi <code>php artisan migrate --seed</code>.
                                    </li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Role-Based Dashboard</span>
                                    <span class="badge bg-light text-dark border fs-xs">ApexCharts KPI Suite</span>
                                    <span class="badge bg-light text-dark border fs-xs">Custom Cover &amp; Height
                                        Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Deduplicated Chat Hub</span>
                                    <span class="badge bg-light text-dark border fs-xs">WIB Time Engine</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.6.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.6.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.6.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 10:45
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Bulk &amp; Quick Role Assignment Engine, Live Role
                                    &amp; Status Table Filtering, Zero-Trust Session Invalidation on Account Deactivation
                                    &amp; Deduplicated Rejection Notification Architecture</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fasilitas Penetapan Role Massal &amp; Aksi Cepat
                                            (<code>admin/manajemenpengguna/users</code>):</strong> Checkbox seleksi tabel
                                        multi-halaman (<code>#check-all-page-users</code>,
                                        <code>#check-all-global-users</code>, <code>.user-check-item</code>), toolbar
                                        dinamis dengan badge counter <code>[X] terpilih</code>, tombol aksi massal, serta
                                        tombol aksi cepat per-baris (<code>.btn-quick-role</code>) berikon perisai untuk
                                        mengonfigurasi role pengguna secara instan.</li>
                                    <li><strong class="text-dark">Dialog Modal Penetapan Peran Terpadu
                                            (<code>bulk_role_modal.blade.php</code>):</strong> Mendukung 3 mode tindakan
                                        fleksibel (<em>Sync</em>, <em>Append</em>, <em>Remove</em>), single-user profile
                                        preview card dengan avatar dan role aktif saat ini, multi-user avatar chips, serta
                                        matriks pilihan role Spatie dengan proteksi konfirmasi SweetAlert2.</li>
                                    <li><strong class="text-dark">Live Table Filters (Role &amp; Status) &amp; Reset
                                            Control:</strong> Integrasi filter dropdown <em>Role</em> dan <em>Status
                                            Akun</em> (Aktif, Menunggu Persetujuan, Nonaktif, Ditolak) pada DataTables
                                        header bar, serta tombol <em>Reset Filter</em> 1-klik yang tersinkronisasi dengan
                                        pagination dan checklist.</li>
                                    <li><strong class="text-dark">Zero-Trust Active Session Termination
                                            (<code>TrackUserActivity.php</code>):</strong> Pemutusan sesi aktif instan
                                        (<code>Auth::logout()</code>, penghapusan database sessions &amp; online cache) saat
                                        admin menonaktifkan akun pengguna yang sedang berada di dashboard, dilengkapi
                                        penerusan error bag <code>inactive</code> dan alert banner merah di halaman login
                                        dengan tombol langsung menuju permohonan aktivasi akun.</li>
                                    <li><strong class="text-dark">Pemberitahuan Penolakan Terstruktur &amp; Penghapusan
                                            Duplikasi:</strong> Menghilangkan duplikasi teks alasan pada body pesan
                                        notifikasi penolakan registrasi dan penonaktifan akun, memusatkan tampilan alasan ke
                                        dalam kotak merah <em>Alasan dari Admin</em>, dan membersihkan record pesan yang ada
                                        di database.</li>
                                    <li><strong class="text-dark">Standarisasi Warna Checkbox Indeterminate
                                            (<code>:indeterminate</code>):</strong> Menyelaraskan warna checkbox tanda minus
                                        (<em>partially selected</em>) dengan warna primary blue tema di level modul
                                        (<code>users.css</code>) dan global (<code>custom-datatables.css</code>).</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Bulk Role Assignment</span>
                                    <span class="badge bg-light text-dark border fs-xs">Quick Role Action</span>
                                    <span class="badge bg-light text-dark border fs-xs">Live Role &amp; Status
                                        Filters</span>
                                    <span class="badge bg-light text-dark border fs-xs">Zero-Trust Session
                                        Invalidation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Clean Notification
                                        Architecture</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.5.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.5.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.5.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 09:35
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Universal Checkbox &amp; Radio Button Design System
                                    (Spatie Matrix Table Alignment), Calibrated Toggle Switch Spacing Standard
                                    (<code>custom-datatables.css</code>), Universal Icon/Dot Spacing Utilities &amp; Ad-Hoc
                                    Margin Cleanup Across All Admin Pages</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Standarisasi Universal Checkbox &amp; Radio Button
                                            (Section 6 <code>custom-auth.css</code>):</strong> Mengadopsi desain checklist
                                        elegan dari Spatie Permission Matrix Table (dimensi <code>1.25em</code>, border
                                        <code>2px solid #475569</code>, centang modern <code>#0d6efd</code> dengan elevasi
                                        glow) ke seluruh komponen form checkbox dan radio button di semua halaman inti,
                                        modal popup, dan tabel data.</li>
                                    <li><strong class="text-dark">Kalibrasi Jarak Presisi Toggle Switch
                                            (<code>custom-datatables.css</code>):</strong> Penyesuaian padding container
                                        (<code>2.85em</code>), lebar switch (<code>2.35em</code>), dan net gap
                                        <code>0.5em</code> (~7px) ke label teks sehingga presisi dan proporsional.
                                        Dilengkapi aturan khusus standalone switch di dalam tabel data untuk menghilangkan
                                        <em>ghost padding</em>.</li>
                                    <li><strong class="text-dark">Penyelarasan Spasi Ikon &amp; Status Presence (Rule 14
                                            &amp; Section 7 <code>custom-auth.css</code>):</strong> Implementasi utilitas
                                        <code>.me-1.5</code>, <code>.ms-1.5</code>, dan <code>.gap-1.5</code> (6px) untuk
                                        menjaga jarak harmonis antara ikon/dot indikator dengan teks label pada Data Login,
                                        User Profile, dan modul lainnya.</li>
                                    <li><strong class="text-dark">Pembersihan Kelas Ad-hoc &amp; Inline Style
                                            Overrides:</strong> Menghapus class <code>ps-4</code>, <code>ms-2</code>,
                                        <code>.switch-large</code>, dan inline styles duplikat pada
                                        <code>fitur-aplikasi.blade.php</code>, <code>fitur_aplikasi_modal.blade.php</code>,
                                        <code>backup-db.blade.php</code>, serta file form modul manajemen pengguna.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Universal Checkbox System</span>
                                    <span class="badge bg-light text-dark border fs-xs">Calibrated Switch Spacing</span>
                                    <span class="badge bg-light text-dark border fs-xs">Architecture Rule 14</span>
                                    <span class="badge bg-light text-dark border fs-xs">Ad-Hoc Class Cleanup</span>
                                    <span class="badge bg-light text-dark border fs-xs">Visual Consistency</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.5.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.5.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.5.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 08:30
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Complete Architecture Separation of Modular External
                                    CSS &amp; JS Assets Across All Admin Pages (Rule 15), Global Custom Auth &amp;
                                    DataTables Styling, Unused Raw Asset Cleanup &amp; High-Contrast Red Notification Badge
                                    Glow</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pemisahan Aset Eksternal Modular (Rule 15
                                            Compliance):</strong> Seluruh kode CSS dan JavaScript yang sebelumnya berada
                                        inline di dalam Blade view pada semua modul admin telah diekstrak menjadi file
                                        eksternal 1-to-1 di <code>public/assets/css/admin/</code> dan
                                        <code>public/assets/js/admin/</code> (mencakup modul Profil Pengguna, Messages,
                                        Menu, Role, Permission, Akses Role, Akses User, Users, Data Login, Profil Aplikasi,
                                        Fitur Aplikasi, Backup DB, Translation, dan Konfigurasi Website).</li>
                                    <li><strong class="text-dark">Arsitektur Bridge Data Dinamis:</strong> Penggunaan objek
                                        konfigurasi global terstandarisasi (<code>window.ModuleNameConfig</code>) sebagai
                                        jembatan passing data server ke file JavaScript eksternal secara aman dan
                                        terisolasi.</li>
                                    <li><strong class="text-dark">Pembersihan Aset Mentah &amp; Direktori Font Tak
                                            Terpakai:</strong> Menghapus direktori <code>public/assets/css/s/</code> dan
                                        berkas <code>css2</code>, <code>css2-1</code> s.d. <code>css2-11</code> sisa crawler
                                        Google Fonts yang tidak lagi digunakan sistem.</li>
                                    <li><strong class="text-dark">Efek Glow &amp; Drop-Shadow Merah Notifikasi:</strong>
                                        Penyempurnaan styling badge notifikasi merah pada icon topbar dan form input saat
                                        kondisi invalid/error dengan efek ambient shadow konsisten.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Modular External CSS &amp;
                                        JS</span>
                                    <span class="badge bg-light text-dark border fs-xs">Architecture Rule 15</span>
                                    <span class="badge bg-light text-dark border fs-xs">Asset Cleanup</span>
                                    <span class="badge bg-light text-dark border fs-xs">Dynamic Server Bridge</span>
                                    <span class="badge bg-light text-dark border fs-xs">UI Consistency</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.5.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.5.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.5.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 02:42
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Unified Spatie Permission Matrix Table Hierarchy,
                                    Real-Time Parent-Child Auto Check/Uncheck Sync Engine &amp; Smart Direct Permission
                                    Deduplication Filter</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Standarisasi Matriks Permission Spatie:</strong>
                                        Penyatuan layout tabel matriks hak akses secara seragam pada seluruh modul Manajemen
                                        Pengguna (<code>role</code>, <code>akses-role</code>, dan <code>akses-user</code>)
                                        dengan dukungan visual hierarki Menu Utama (Level 1), Submenu (Level 2), Sub-submenu
                                        (Level 3), serta izin sistem Standalone.</li>
                                    <li><strong class="text-dark">Sinkronisasi Otomatis Induk-Anak (Auto Parent-Child
                                            Sync):</strong> Implementasi <code>syncAllParentMenuStates()</code> untuk
                                        otomatis mencentang hak akses <code>read</code> pada Menu Utama ketika salah satu
                                        aksi di submenu dipilih, dan otomatis menghilangkan seluruh centang pada baris Menu
                                        Utama ketika semua submenunya dikosongkan.</li>
                                    <li><strong class="text-dark">Smart Row &amp; Master Check All Sync:</strong>
                                        Sinkronisasi dua arah tombol baris <strong>SEMUA</strong> dan header <strong>Pilih
                                            Semua Permission</strong> yang otomatis tercentang ketika seluruh aksi aktif dan
                                        otomatis batal jika ada salah satu aksi yang tidak aktif.</li>
                                    <li><strong class="text-dark">Penyaringan Cerdas Izin Langsung (Direct Permission
                                            Deduplication):</strong> Sistem secara otomatis menyaring dan hanya menyimpan
                                        izin tambahan yang belum tercakup oleh role terpilih, mencegah duplikasi data izin
                                        bawaan role ke tabel <code>model_has_permissions</code>.</li>
                                    <li><strong class="text-dark">Pemuatan Lengkap Hak Akses Role (Inherited Permissions
                                            Loading):</strong> Modal <code>akses-user</code> kini membaca seluruh izin
                                        bawaan role (<code>all_permission_names</code>) sehingga pengguna dengan role
                                        Superadmin atau role lainnya langsung tercentang penuh dan sinkron secara
                                        <em>real-time</em> saat role diganti.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Permission Matrix Table</span>
                                    <span class="badge bg-light text-dark border fs-xs">Parent-Child Sync Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">Direct Permission
                                        Deduplication</span>
                                    <span class="badge bg-light text-dark border fs-xs">Role-to-Permissions Realtime
                                        Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Spatie Laravel Permission</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.5.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xs text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.5.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.5.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-09-01 00:05
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Today Logins Widget Card Suite, Dual
                                    View Switcher, Chat Header Online Indicator Clean-up &amp; Rule 14 (Icon &amp; Label
                                    Spacing Standard)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Widget Kartu Pengguna Login Hari Ini:</strong>
                                        Transformasi tampilan daftar pengguna aktif hari ini menjadi Card Grid modern
                                        interaktif terinspirasi dari <code>moreapps/manage</code> lengkap dengan avatar
                                        border dinamis, badge online pulse, role pill, dan total akumulasi poin login.</li>
                                    <li><strong class="text-dark">Tata Letak Informasi Sesi 2-Baris Vertikal:</strong>
                                        Penataan panel informasi sesi login (Login Terakhir, Perangkat &amp; Browser, Alamat
                                        IP &amp; Sesi) dengan format 2 baris vertikal yang lapang, terstruktur, berjarak
                                        lega, dan bebas tumpang tindih.</li>
                                    <li><strong class="text-dark">Dual Mode View Switcher:</strong> Tombol pengalih
                                        tampilan (Widget Kartu vs Tabel Baris) dengan penyimpanan status otomatis pada
                                        <code>localStorage</code>.</li>
                                    <li><strong class="text-dark">Perbaikan Modal Detail Login (Null-Safety):</strong>
                                        Penambahan baris tipe perangkat (<code>detailDeviceType</code>) dan null-check
                                        defensive pada JavaScript handler untuk mencegah error <code>Cannot set properties
                                            of null</code>.</li>
                                    <li><strong class="text-dark">Pembersihan Indikator Online Header Chat:</strong>
                                        Menghapus ikon titik bulat statis di samping teks "Online Sekarang" pada header
                                        obrolan di <code>messages.blade.php</code> karena status kehadiran sudah terwakili
                                        jelas oleh online dot pada sudut avatar.</li>
                                    <li><strong class="text-dark">Standarisasi Rule 14 (Icon and Label Spacing):</strong>
                                        Penambahan aturan proyek wajib pada <code>AGENTS.md</code> terkait standar spasi
                                        eksplisit antara ikon dan label teks di seluruh komponen aplikasi.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Data Login Card Widgets</span>
                                    <span class="badge bg-light text-dark border fs-xs">Dual View Switcher</span>
                                    <span class="badge bg-light text-dark border fs-xs">Chat Header Polish</span>
                                    <span class="badge bg-light text-dark border fs-xs">Modal Null-Safety</span>
                                    <span class="badge bg-light text-dark border fs-xs">Rule 14 Standard</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.9 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-md text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.9</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.9</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 22:05
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Auth Security Rate Limiting Integration, Unified
                                    Form Error Aesthetics &amp; Meta Title Internationalization Sanitization</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Integrasi Rate Limit &amp; Auto Approval
                                            Pengguna:</strong> Menghubungkan pengaturan keamanan akun dari cache ke
                                        <code>LoginRequest</code> (kuota percobaan gagal) dengan banner notifikasi lockout
                                        di bagian atas form login serta aktivasi otomatis registrasi baru dari
                                        <code>RegisteredUserController</code>.</li>
                                    <li><strong class="text-dark">Estetika Kolom Validasi Input Autentikasi:</strong>
                                        Harmonisasi warna border, background, dan icon sisi kiri/kanan input group menjadi
                                        merah lembut terpadu saat input berstatus invalid pada halaman Login, Register,
                                        Forgot Password, dan Permohonan Aktivasi.</li>
                                    <li><strong class="text-dark">Pembersihan Suffix Meta Title Template:</strong>
                                        Menghapus teks template statis pada <code>title-meta.blade.php</code> dan
                                        <code>I18nManager</code> di <code>app.js</code> agar judul tab browser 100%
                                        konsisten dengan data dinamis nama halaman dan nama aplikasi.</li>
                                    <li><strong class="text-dark">Perbaikan Ikon &amp; Branding Halaman 503
                                            Maintenance:</strong> Penyesuaian ukuran ikon perkakas dan integrasi data
                                        dinamis <code>ProfilAplikasi</code> (favicon, logo, judul) pada halaman pemeliharaan
                                        sistem.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Rate Limit Engine</span>
                                    <span class="badge bg-light text-dark border fs-xs">Auth Input Aesthetics</span>
                                    <span class="badge bg-light text-dark border fs-xs">Meta Title Fix</span>
                                    <span class="badge bg-light text-dark border fs-xs">503 Page Branding</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.8 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-dot fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.8</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.8</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 19:12
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Application Settings Hub &amp; Maintenance Mode
                                    Engine: 6 Interactive Control Widgets, Dynamic Idle Lock Screen, 503 Maintenance Page,
                                    Global Middleware Protection &amp; User KTP Photo Preview Modal</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Hub Panel Kontrol &amp; Pengaturan Fitur Terpadu
                                            (<code>admin/dukunganaplikasi/fitur-aplikasi</code>):</strong> Menghadirkan 6
                                        widget interaktif untuk manajemen visibilitas fitur sistem, waktu idle auto lock,
                                        mode pemeliharaan, kebijakan keamanan autentikasi, sinkronisasi polling real-time,
                                        dan pembersih seluruh cache server.</li>
                                    <li><strong class="text-dark">Mode Pemeliharaan (Maintenance Mode) &amp; Akses
                                            Administrator:</strong> Proteksi menyeluruh via middleware
                                        <code>CheckMaintenanceMode</code> dan <code>LoginRequest</code>. Akun superadmin
                                        &amp; admin tetap memiliki akses penuh (bypass otomatis), sementara akun
                                        non-admin/tamu diblokir login dan diarahkan ke halaman responsif
                                        <code>errors/503.blade.php</code>.</li>
                                    <li><strong class="text-dark">Pengatur Waktu Idle Dinamis (Auto Screen Lock):</strong>
                                        Durasi ketidakaktifan pengguna tersinkronisasi instan antara cache server dan
                                        browser localStorage dengan tombol pengujian langsung
                                        (<code>window.lockScreen()</code>).</li>
                                    <li><strong class="text-dark">Preview Foto KTP Profil Pengguna
                                            (<code>admin/profil-pengguna</code>):</strong> Penambahan baris dokumen KTP
                                        fisik di bagian bawah tabel detail kelengkapan identitas pengguna dengan tombol
                                        preview modal ukuran penuh, unduh berkas, dan buka tab baru.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Settings Hub</span>
                                    <span class="badge bg-light text-dark border fs-xs">Maintenance Mode</span>
                                    <span class="badge bg-light text-dark border fs-xs">Idle Lock Screen</span>
                                    <span class="badge bg-light text-dark border fs-xs">Cache Optimizer</span>
                                    <span class="badge bg-light text-dark border fs-xs">KTP Preview Modal</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.7 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-dot fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.7</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.7</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 17:18
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Cover Height Customization Engine:
                                    Real-Time Proportional Slider, Inline Presets &amp; Synchronized Aspect Ratio WYSIWYG
                                </h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pengatur Tinggi Foto Sampul Header Profil:</strong>
                                        Penambahan kontrol slider real-time (180px - 600px) dan tombol preset tinggi inline
                                        (Ringkas 220px, Standar 320px, Tinggi 450px) pada widget Foto Sampul di halaman
                                        Profil Pengguna (<code>admin/profil-pengguna</code>) yang tersimpan permanen di
                                        database.</li>
                                    <li><strong class="text-dark">Sinkronisasi Rasio Dimensi Pratinjau (Aspect Ratio
                                            WYSIWYG):</strong> Sinkronisasi rasio aspek kotak pratinjau thumbnail di sidebar
                                        dengan ukuran banner header utama secara otomatis dan responsif saat diubah maupun
                                        di-resize.</li>
                                    <li><strong class="text-dark">Sinkronisasi Halaman KTP:</strong> Header banner pada
                                        halaman kelengkapan data KTP (<code>admin/profil-pengguna/edit</code>) otomatis
                                        mengikuti preferensi tinggi yang telah disimpan.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Cover Height Slider</span>
                                    <span class="badge bg-light text-dark border fs-xs">Inline Presets</span>
                                    <span class="badge bg-light text-dark border fs-xs">Aspect Ratio WYSIWYG</span>
                                    <span class="badge bg-light text-dark border fs-xs">Live Preview</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.6 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-dot fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.6</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.6</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 17:00
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Chat Suite: In-Chat Search, Pinned
                                    Messages, Emoji Reactions, Message Forwarding &amp; Voice Note Audio Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pencarian Pesan Interaktif (In-Chat Search Bar):</strong>
                                        Fitur navigasi dan penyorotan teks pesan real-time dalam obrolan aktif dengan
                                        indikator pencocokan (Match Counter misal: <em>1/3</em>), tombol navigasi Next/Prev,
                                        dan animasi pulse scroll fokus.</li>
                                    <li><strong class="text-dark">Sematkan Pesan Penting (Pinned Messages):</strong> Banner
                                        sematan elegan di bagian atas jendela obrolan dengan cuplikan teks, fungsi klik
                                        langsung menuju pesan (jump-to-message), serta aksi pin/unpin per pesan.</li>
                                    <li><strong class="text-dark">Reaksi Emoji Cepat (Message Reactions):</strong> Palette
                                        reaksi emoji melayang (👍 ❤️ 😂 😮 😢 🙏) dan badge pill interaktif di bawah setiap
                                        balon chat dengan counter jumlah reaksi dan toggle reaksi pengguna.</li>
                                    <li><strong class="text-dark">Teruskan Pesan (Forward Messages):</strong> Modal
                                        pencarian dan pemilihan kontak instan untuk meneruskan pesan teks maupun lampiran ke
                                        pengguna lain dengan label <em>"Diteruskan"</em>.</li>
                                    <li><strong class="text-dark">Perekam &amp; Pemutar Pesan Suara (Voice Note Recorder
                                            &amp; Web Audio Player):</strong> Dukungan Web Audio API MediaRecorder dengan
                                        timer durasi rekaman, tombol batal/kirim, serta pemutar audio kustom modern di dalam
                                        balon obrolan dengan progress bar yang dapat diklik (seekable).</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">In-Chat Search</span>
                                    <span class="badge bg-light text-dark border fs-xs">Pinned Messages</span>
                                    <span class="badge bg-light text-dark border fs-xs">Message Reactions</span>
                                    <span class="badge bg-light text-dark border fs-xs">Forward Message</span>
                                    <span class="badge bg-light text-dark border fs-xs">Voice Note</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.5 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-dot fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.5</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:36
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Clear Conversation History Engine &amp; Instant
                                    Sidebar Demotion (Keep Opponent Chat Intact)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pembersihan Riwayat Percakapan Sepihak (Clear Chat for
                                            Me):</strong> Penambahan tombol <em>"Bersihkan Obrolan"</em> di header area
                                        pesan untuk menghapus/membersihkan seluruh riwayat chat dengan kontak aktif dari
                                        tampilan pengguna, sementara lawan obrolan tetap mempertahankan seluruh riwayat
                                        pesan secara lengkap.</li>
                                    <li><strong class="text-dark">Pemindahan Kontak Instan Tanpa Refresh:</strong> Ketika
                                        seluruh obrolan dibersihkan atau pesan habis dihapus, kontak seketika (0ms delay)
                                        berpindah dari kelompok <em>"Percakapan Aktif"</em> ke <em>"Pengguna Lainnya"</em>
                                        di sidebar lengkap dengan pembaruan badge counter real-time.</li>
                                    <li><strong class="text-dark">Dukungan Flag DB deleted_for_sender &amp;
                                            deleted_for_receiver:</strong> Penambahan kolom <code>deleted_for_sender</code>
                                        dan optimalisasi <code>scopeVisibleTo()</code> sehingga pesan terkirim maupun pesan
                                        diterima dapat disembunyikan secara presisi per pengguna.</li>
                                    <li><strong class="text-dark">SweetAlert2 Confirmation Dialog:</strong> Dilengkapi
                                        dialog konfirmasi interaktif dengan pesan peringatan yang informatif dan pembaruan
                                        instan state tombol serta placeholder.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Clear Conversation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Instant Sidebar Demotion</span>
                                    <span class="badge bg-light text-dark border fs-xs">Keep Opponent Chat</span>
                                    <span class="badge bg-light text-dark border fs-xs">deleted_for_sender</span>
                                    <span class="badge bg-light text-dark border fs-xs">Chat Engine</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.4 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.4</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:30
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dual-Mode Chat Message Deletion Engine (Unsend for
                                    Everyone &amp; Delete for Me)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Hapus Pesan Terkirim (Tarik untuk Semua Orang /
                                            Unsend):</strong> Pesan yang dikirim oleh pengguna aktif dapat ditarik/dihapus
                                        secara permanen dari basis data dan langsung tidak terlihat lagi pada layar lawan
                                        obrolan secara instan dan sinkron.</li>
                                    <li><strong class="text-dark">Hapus Pesan Diterima (Hapus untuk Saya / Delete for
                                            Me):</strong> Pesan dari lawan obrolan yang dihapus oleh pengguna hanya
                                        disembunyikan dari riwayat percakapan pengguna aktif via kolom
                                        <code>deleted_for_receiver</code>, sementara lawan obrolan (pengirim) tetap dapat
                                        melihat pesan tersebut secara utuh.</li>
                                    <li><strong class="text-dark">SweetAlert2 Confirmation Dialog &amp; Smooth
                                            Fadeout:</strong> Konfirmasi penghapusan pesan terstandarisasi dengan modal
                                        SweetAlert2 (Rule 9) dan animasi penghapusan elemen bubble chat yang mulus seketika.
                                    </li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Delete for Everyone</span>
                                    <span class="badge bg-light text-dark border fs-xs">Delete for Me</span>
                                    <span class="badge bg-light text-dark border fs-xs">Dual Mode Message Deletion</span>
                                    <span class="badge bg-light text-dark border fs-xs">Chat Engine</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:22
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Instant Empty History Placeholder Disappearance on
                                    First Chat Send</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pembersihan Instan Placeholder Obrolan Kosong:</strong>
                                        Kotak <em>"Belum Ada Riwayat Obrolan"</em> kini langsung hilang seketika (0ms delay)
                                        pada saat pesan pertama dikirim tanpa jeda render DOM.</li>
                                    <li><strong class="text-dark">Standarisasi ID &amp; Class Placeholder:</strong>
                                        Penyeragaman atribut <code>chat-placeholder-box</code> pada seluruh kondisi state
                                        (Blade initial load, AJAX conversation switch, dan quick transition loading) untuk
                                        pembersihan DOM yang mulus dan bebas glitch.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Placeholder Cleanup</span>
                                    <span class="badge bg-light text-dark border fs-xs">Zero Delay</span>
                                    <span class="badge bg-light text-dark border fs-xs">Instant First Message</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:15
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Zero-Latency Optimistic UI Message Sending &amp;
                                    Instant Seamless Contact Switch Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pengiriman Pesan Instan (Optimistic UI):</strong> Balon
                                        pesan yang dikirim kini langsung muncul di layar detik itu juga (0ms delay) dengan
                                        status jam/indikator pending, form langsung dibersihkan, dan auto-scroll seketika
                                        tanpa menunggu respon server.</li>
                                    <li><strong class="text-dark">Sinkronisasi Background Asinkron:</strong> Permintaan
                                        pengiriman dikirim di latar belakang. ID pesan, link lampiran, dan tanda centang
                                        terkirim diperbarui secara mulus setelah server merespon.</li>
                                    <li><strong class="text-dark">Perpindahan Kontak Seketika (Instant Contact
                                            Switch):</strong> Saat memilih atau membuat obrolan baru dengan pengguna lain,
                                        header aktif dan input chat langsung aktif dan fokus seketika dengan transisi
                                        pemuatan yang halus.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Optimistic UI</span>
                                    <span class="badge bg-light text-dark border fs-xs">Zero Delay</span>
                                    <span class="badge bg-light text-dark border fs-xs">Instant Contact Switch</span>
                                    <span class="badge bg-light text-dark border fs-xs">Seamless Sync</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:05
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Chat Contact Avatar Spacing Optimization, Standard
                                    Framed Lightbox Modal Image Preview &amp; Interactive Reply Quote Jump Navigation</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Penyelarasan Spasi Avatar Kontak:</strong> Mengoreksi
                                        class layout daftar kontak obrolan sidebar ke standar <code>gap-3</code> (16px)
                                        sehingga posisi foto profil avatar dan nama pengguna berjarak proporsional dan rapi.
                                    </li>
                                    <li><strong class="text-dark">Framing Elegan Lightbox Pratinjau Gambar:</strong>
                                        Penyempurnaan modal lightbox gambar obrolan dengan dimensi standar berbingkai
                                        (<code>max-width: 580px</code>, <code>max-height: 420px</code>) dan padding vertikal
                                        luas (<code>py-5 px-4</code>) berlatar gelap halus, tetap mempertahankan unduhan
                                        file beresolusi asli via tombol <em>Unduh Asli</em>.</li>
                                    <li><strong class="text-dark">Navigasi Interaktif Kutipan Balasan Pesan (Reply Quote
                                            Jump):</strong> Kotak kutipan balasan obrolan (<em>reply quote box</em>) kini
                                        dapat diklik untuk melakukan <em>smooth scroll</em> otomatis langsung ke pesan
                                        target asal lengkap dengan animasi <em>pulse highlight</em> fokus biru yang memikat.
                                    </li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Messages Refinement</span>
                                    <span class="badge bg-light text-dark border fs-xs">Avatar Spacing</span>
                                    <span class="badge bg-light text-dark border fs-xs">Framed Image Modal</span>
                                    <span class="badge bg-light text-dark border fs-xs">Reply Quote Jump</span>
                                    <span class="badge bg-light text-dark border fs-xs">Pulse Highlight</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.4.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.4.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 15:30
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Impersonation Engine (Switch Akun), Floating
                                    Sticky Impersonation Alert Banner &amp; Quick Switch-Back Action Hub</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Switch Akun (User Impersonation):</strong>
                                        Administrator dengan permission <code>update manajemenpengguna/users</code> atau
                                        role <code>superadmin</code>/<code>admin</code> dapat langsung login sementara
                                        sebagai akun pengguna target tanpa memerlukan kata sandi.</li>
                                    <li><strong class="text-dark">Proteksi Sesi &amp; Keamanan Terpadu:</strong> Sesi
                                        pengguna asli disimpan secara aman di Laravel session (<code>impersonator_id</code>,
                                        <code>impersonator_name</code>, <code>impersonator_role</code>) serta pencegahan
                                        <em>nested switch</em> bertingkat dan restriksi switch ke akun diri sendiri atau
                                        akun tidak aktif.</li>
                                    <li><strong class="text-dark">Floating Sticky Impersonation Banner:</strong> Banner
                                        visual responsif di bagian atas seluruh halaman saat mode switch akun aktif,
                                        menampilkan identitas akun aktif beserta nama akun asli dan tombol cepat <em>Kembali
                                            ke Akun Utama</em>.</li>
                                    <li><strong class="text-dark">Integrasi UI Tabel Pengguna &amp; Topbar
                                            Dropdown:</strong> Penambahan tombol aksi <code>ti-replace-user</code> pada
                                        tabel Manajemen Pengguna serta opsi pengembalian sesi instan pada menu dropdown akun
                                        di topbar navbar.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">User Impersonation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Switch Akun</span>
                                    <span class="badge bg-light text-dark border fs-xs">Session Preservation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Floating Impersonation
                                        Banner</span>
                                    <span class="badge bg-light text-dark border fs-xs">Quick Switch-Back</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.5 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.5</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 16:40
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Direct Chat Image &amp; File Attachment Upload,
                                    Pre-Upload Live File Preview Bar, Image Lightbox Modal &amp; Real-Time Avatar
                                    Synchronization</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Kirim Gambar &amp; Lampiran Berkas:</strong>
                                        Penambahan tombol lampiran berkas (<code>ti-paperclip</code>) di samping tombol
                                        emoji pada formulir chat, mendukung upload gambar (JPG, PNG, WEBP, GIF) dan dokumen
                                        (PDF, DOCX, XLSX, ZIP, TXT) hingga ukuran 10 MB.</li>
                                    <li><strong class="text-dark">Bar Pratinjau Berkas Interaktif (Live Preview
                                            Bar):</strong> Penampilan thumbnail pratinjau instan untuk foto atau ikon format
                                        dokumen dengan indikator nama dan ukuran berkas sebelum pesan dikirim, lengkap
                                        dengan tombol pembatalan (<em>cancel attachment</em>).</li>
                                    <li><strong class="text-dark">Modal Lightbox Gambar &amp; Kartu Berkas
                                            Obrolan:</strong> Kartu gambar responsif dengan efek zoom saat hover yang dapat
                                        diklik untuk pratinjau resolusi tinggi pada modal lightbox
                                        (<code>#chat-image-modal</code>) serta tombol unduh langsung, dan kartu dokumen rapi
                                        dengan tombol download instan.</li>
                                    <li><strong class="text-dark">Sinkronisasi Avatar Real-Time:</strong> Pembaruan dinamis
                                        foto profil pengguna di sidebar kontak, header aktif obrolan, modal detail, dan
                                        seluruh balon pesan obrolan secara instan saat pengguna memperbarui avatar mereka
                                        tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Integrasi Skema &amp; Ringkasan Pesan:</strong> Migrasi
                                        kolom metadata lampiran (<code>attachment_name</code>, <code>attachment_type</code>,
                                        <code>attachment_size</code>) pada tabel <code>messages</code> dan pemformatan
                                        ringkasan pesan otomatis pada sidebar kontak (📷 <em>[Foto / Gambar]</em> atau 📎
                                        <em>[Berkas]</em>).</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">Chat File Attachment</span>
                                    <span class="badge bg-light text-dark border fs-xs">Image Upload &amp; Lightbox</span>
                                    <span class="badge bg-light text-dark border fs-xs">Live Attachment Preview</span>
                                    <span class="badge bg-light text-dark border fs-xs">Real-Time Avatar Sync</span>
                                    <span class="badge bg-light text-dark border fs-xs">Document Download Card</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.4 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.4</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 16:11
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Real-Time Sidebar Contacts Sync Engine, Auto Unread
                                    Badges Counter, Background Contact Polling &amp; Message Hub Bridge</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Polling Kontak &amp; Badge Unread Real-Time:</strong>
                                        Penambahan endpoint <code>admin/profil-pengguna/messages/poll-contacts</code> yang
                                        berjalan di latar belakang setiap 3.5 detik untuk memperbarui angka pesan masuk
                                        (<em>unread counter badge</em>), cuplikan pesan terakhir, dan timestamp kontak di
                                        sidebar penerima secara otomatis tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Promosi Kontak Otomatis (Auto-Promote to
                                            Recent):</strong> Kontak yang baru mengirimkan pesan otomatis dipindahkan ke
                                        posisi teratas bagian <code>Percakapan Aktif</code> secara langsung di browser
                                        penerima.</li>
                                    <li><strong class="text-dark">Sinkronisasi Penuh Topbar &amp; Chat Hub:</strong>
                                        Integrasi pembersihan badge unread otomatis saat pesan dibuka atau dibalas, serta
                                        sinkronisasi instan ke ikon amplop notifikasi topbar via
                                        <code>window.fetchMessagesSilently()</code>.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border fs-xs">Sidebar Contact Polling</span>
                                    <span class="badge bg-light text-muted border fs-xs">Auto Unread Badge</span>
                                    <span class="badge bg-light text-muted border fs-xs">Live Contact Reorder</span>
                                    <span class="badge bg-light text-muted border fs-xs">Message Hub Sync</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 15:58
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Chat Emoji &amp; Emotion Picker,
                                    Multi-Category Emotion Grid, Real-Time Keyword Search &amp; Cursor-Aware Insertion
                                    Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Pemilih Emoji &amp; Emoticon Interaktif:</strong>
                                        Penambahan tombol pemilih emoji (<code>ti-mood-smile</code>) pada kolom input chat
                                        dengan panel popover modern lengkap dengan bar reaksi cepat (<em>Quick
                                            Reactions</em>: 👍, ❤️, 😂, 🔥, 🎉, 🙏, 😊, 👏, 🚀).</li>
                                    <li><strong class="text-dark">Pengelompokan 5 Kategori Emoji &amp; Navigasi
                                            Tab:</strong> Struktur basis data emoji terorganisir yang mencakup kategori
                                        <em>Senyum &amp; Emosi</em> (😀), <em>Gestur &amp; Tangan</em> (👍), <em>Hati &amp;
                                            Cinta</em> (❤️), <em>Objek &amp; Simbol</em> (🎉), serta <em>Aktivitas</em> (☕).
                                    </li>
                                    <li><strong class="text-dark">Pencarian Emoji Real-Time Multibahasa:</strong> Filter
                                        pencarian emoji instan berdasarkan kata kunci dwibahasa (misal: <em>senyum, cinta,
                                            api, jempol, sedih, kopi</em> maupun tag bahasa Inggris).</li>
                                    <li><strong class="text-dark">Penyisipan Cerdas Berdasarkan Posisi Kursor (Cursor-Aware
                                            Insertion):</strong> Emoji disisipkan tepat pada posisi kursor pengguna saat ini
                                        tanpa menghilangkan fokus input atau menghapus draf teks yang sedang diketik.</li>
                                    <li><strong class="text-dark">Interaksi UI &amp; Auto-Dismiss:</strong> Penutupan
                                        otomatis popup emoji saat klik di luar area maupun penekanan tombol
                                        <code>Escape</code>, serta aktivasi tombol otomatis saat memilih kontak lawan
                                        bicara.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border fs-xs">Chat Emoji Picker</span>
                                    <span class="badge bg-light text-muted border fs-xs">Emotion Grid</span>
                                    <span class="badge bg-light text-muted border fs-xs">Real-Time Emoji Search</span>
                                    <span class="badge bg-light text-muted border fs-xs">Cursor-Aware Insertion</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 15:02
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Message Reply/Quote Engine, Parent
                                    Message ID DB Schema, Dynamic Quoted Box &amp; Auto Sync Message Hub</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Balas / Reply Pesan Interaktif:</strong> Penambahan
                                        tombol <code>Balas</code> pada setiap bubble pesan pengguna (baik pesan pengirim
                                        maupun lawan obrolan) serta bar pratinjau balasan di atas kolom input dengan tombol
                                        pembatalan instan.</li>
                                    <li><strong class="text-dark">Skema Database &amp; Model Relasi:</strong> Penambahan
                                        kolom <code>parent_id</code> (foreign key nullable ke <code>messages.id</code>) pada
                                        tabel <code>messages</code> serta relasi Eloquent <code>parent()</code>.</li>
                                    <li><strong class="text-dark">Kotak Kutipan Dinamis (Quote Box):</strong> Tampilan
                                        balasan pesan di dalam bubble obrolan yang menampilkan nama pengirim asal secara
                                        proporsional (misal label <code>Anda</code> pada pengirim atau Nama Lawan Chat)
                                        serta potongan teks pesan yang dibalas.</li>
                                    <li><strong class="text-dark">Penanganan Safe Payload AJAX &amp; Topbar Hub:</strong>
                                        Sanitasi parameter <code>parent_id</code> secara aman di backend controller dan
                                        frontend AJAX untuk mencegah kegagalan validasi, serta sinkronisasi otomatis ke
                                        Message Dropdown di navbar.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border fs-xs">Message Reply</span>
                                    <span class="badge bg-light text-muted border fs-xs">Quote Engine</span>
                                    <span class="badge bg-light text-muted border fs-xs">Parent Message ID</span>
                                    <span class="badge bg-light text-muted border fs-xs">AJAX Payload Fix</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-filled fs-xl text-muted opacity-50"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 14:55
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Categorized Contact Sidebar, Grouped Topbar Messages
                                    Dropdown, Smart Scroll Preservation &amp; Universal Profile Detail Modal</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pemisahan Kontak Sidebar Chat:</strong> Pengelompokan
                                        kontak menjadi bagian <code>Percakapan Aktif</code> (diurutkan berdasarkan pesan
                                        terbaru) dan <code>Pengguna Lainnya</code> dengan promosi kontak otomatis secara
                                        real-time saat obrolan baru dikirim.</li>
                                    <li><strong class="text-dark">Pengelompokan Pesan Topbar Dropdown:</strong> Pesan pada
                                        dropdown amplop topbar kini dikelompokkan 1 baris per pengirim dengan indikator
                                        badge jumlah chat baru (misal <code>3 Chat</code>), serta navigasi langsung ke
                                        halaman percakapan chat tanpa modal pop-up.</li>
                                    <li><strong class="text-dark">Notifikasi Penolakan ke Alur Chat:</strong> Penolakan
                                        permohonan registrasi/penonaktifan oleh Superadmin/Admin disimpan lengkap dengan
                                        <code>conversation_id</code> sehingga otomatis muncul di timeline obrolan pengguna.
                                    </li>
                                    <li><strong class="text-dark">Smart Scroll Position Handling:</strong> Pencegahan
                                        scroll otomatis ke bawah secara paksa ketika pengguna sedang scroll ke atas membaca
                                        riwayat pesan lama, serta eliminasi re-render DOM yang tidak perlu saat polling
                                        background.</li>
                                    <li><strong class="text-dark">Modal Detail Akun Pengguna Universal:</strong> Pengubahan
                                        tombol <code>Detail Akun</code> di header obrolan menjadi modal pop-up yang dapat
                                        diakses oleh seluruh pengguna (termasuk role User) untuk melihat profil lengkap
                                        lawan bicara.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border">Categorized Contacts</span>
                                    <span class="badge bg-light text-muted border">Grouped Topbar Messages</span>
                                    <span class="badge bg-light text-muted border">Smart Scroll Preservation</span>
                                    <span class="badge bg-light text-muted border">Universal Profile Modal</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.3.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.3.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.3.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 10:15
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Real-Time Notification Polling, Self-Registration
                                    Rejection Workflow, Deactivation Request Notification System &amp; Topbar Layout
                                    Refinements</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tabel Database Dedicated Messages:</strong> Pembuatan
                                        skema tabel <code>messages</code> khusus untuk arsitektur pengiriman pesan/chat
                                        antarpengguna dan notifikasi sistem dengan dukungan <code>sender_id</code>,
                                        <code>receiver_id</code>, <code>conversation_id</code>, <code>subject</code>,
                                        <code>body</code>, <code>reason</code>, dan <code>read_at</code>.</li>
                                    <li><strong class="text-dark">Tombol Pesan di Profil Pengguna:</strong> Penambahan
                                        tombol <code>Pesan</code> hijau pada header <code>admin/profil-pengguna</code> di
                                        samping kanan tombol Kelengkapan Data KTP.</li>
                                    <li><strong class="text-dark">Real-Time Messages &amp; Notification Polling:</strong>
                                        Pembaruan otomatis notifikasi &amp; pesan topbar setiap 20 detik via AJAX tanpa
                                        mengganggu timer idle atau lock screen, dengan indikator badge status <code>Belum
                                            dibaca</code> dan <code>Sudah dibaca</code>.</li>
                                    <li><strong class="text-dark">Alur Penolakan Registrasi Mandiri &amp;
                                            Non-Aktif:</strong> Penolakan permohonan penonaktifan mengirimkan pesan
                                        terintegrasi ke tabel <code>messages</code>. Mengklik notifikasi/pesan akan membuka
                                        modal detail alasan penolakan dan menandai pesan sebagai dibaca.</li>
                                    <li><strong class="text-dark">UserFactory &amp; Automated User Seeder:</strong>
                                        Konfigurasi <code>UserFactory</code> dan <code>DatabaseSeeder</code> untuk
                                        menghasilkan 10 akun dummy pengguna baru secara otomatis dengan atribusi Spatie Role
                                        <code>user</code>, penanganan status badge <code>Pendaftaran Ditolak</code> pada
                                        tabel data pengguna, dan pembaruan layout status pesan di bawah waktu topbar.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border">Dedicated Messages Table</span>
                                    <span class="badge bg-light text-muted border">Chat Architecture</span>
                                    <span class="badge bg-light text-muted border">UserFactory 10 Dummy Users</span>
                                    <span class="badge bg-light text-muted border">Real-Time Polling</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.2.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.2.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.2.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 23:28
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Login Tracking Engine, 24-Hour Point
                                    Accumulation, Geolocation Coordinates Capture &amp; Data Login Dashboard</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">24-Hour / Daily Login Points Engine:</strong> Sistem
                                        perhitungan poin cerdas dengan aturan penambahan 1 poin pada login pertama setiap
                                        hari (atau interval 24 jam). Login berulang dalam hari yang sama tidak menambah
                                        poin, tetapi seluruh riwayat sesi tetap dicatat lengkap.</li>
                                    <li><strong class="text-dark">Comprehensive Login History Audit:</strong> Pencatatan
                                        otomatis jenis browser, sistem operasi/platform, tipe perangkat
                                        (Desktop/Mobile/Tablet), alamat IP klien, tanggal &amp; waktu presisi, serta status
                                        penambahan poin pada setiap sesi login.</li>
                                    <li><strong class="text-dark">Non-Blocking Geolocation Coordinates:</strong>
                                        Pengambilan titik koordinat GPS (latitude &amp; longitude) secara asynchronous via
                                        HTML5 Geolocation API pada form login tanpa menghambat kecepatan submit pengguna.
                                    </li>
                                    <li><strong class="text-dark">Modul Admin Data Login:</strong> Antarmuka terpusat di
                                        <code>admin/manajemenpengguna/data-login</code> dengan 4 kartu statistik real-time,
                                        filter tanggal/pengguna/pencarian, Tab Pengguna Login Hari Ini, Tab Semua Riwayat
                                        Login dengan pagination, Modal Detail Sesi Login dengan integrasi OpenStreetMap
                                        &amp; Google Maps, serta fitur pembersihan log lama.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border">Login Tracker</span>
                                    <span class="badge bg-light text-muted border">Daily Points Engine</span>
                                    <span class="badge bg-light text-muted border">Geolocation GPS</span>
                                    <span class="badge bg-light text-muted border">Data Login Module</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.1.4 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.4</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.1.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 23:02
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Public Landing Page Footer Overhaul, Drag &amp; Drop
                                    Website Sections Reordering, Fitur Aplikasi Header Clean-up &amp; SweetAlert2 Clean
                                    Native Restoration</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Landing Page Footer Modernization:</strong> Menghapus
                                        menu Admin dari footer publik, menstrukturisasi kategori Company &amp; Community
                                        menjadi 2 sub-kolom responsif, merombak styling dengan dark gradient, ambient glow,
                                        tombol sosial media glassmorphism, dan menyempurnakan jarak badge Hiring.</li>
                                    <li><strong class="text-dark">Website Sections Drag &amp; Drop Reordering:</strong>
                                        Mengintegrasikan SortableJS pada Konfigurasi Website dengan drag handle, live badge
                                        renumbering, dan auto-save instan via AJAX ke server.</li>
                                    <li><strong class="text-dark">Fitur Aplikasi Header Clean-up:</strong> Mengubah tombol
                                        badge "Auto-Save Instant" menjadi teks informasi yang elegan dengan ikon petir.</li>
                                    <li><strong class="text-dark">SweetAlert2 Native Restoration &amp; Firm Theme
                                            Colors:</strong> Menghapus modifikasi CSS usang dari tema Inspinia di
                                        <code>app.css</code> dan <code>app.min.css</code> yang memotong koordinat centang,
                                        serta menerapkan warna Emerald/Primary tegas <code>#10b981</code> pada ikon
                                        notifikasi.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-muted border">Website Footer</span>
                                    <span class="badge bg-light text-muted border">Drag &amp; Drop SortableJS</span>
                                    <span class="badge bg-light text-muted border">SweetAlert2 Native</span>
                                    <span class="badge bg-light text-muted border">UI/UX Polish</span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2.1.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.1.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 21:35
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Universal SweetAlert2 Notification Engine &amp;
                                    Global Helpers, High-Contrast Checkbox SVG Fix, Multi-Select Filter Sync &amp; Route
                                    Order Optimization</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Universal SweetAlert2 Global Helpers (Rule 9):</strong>
                                        Sentralisasi helper <code>window.showSuccess()</code>,
                                        <code>window.showError()</code>, <code>window.showWarning()</code>,
                                        <code>window.showConfirm()</code>, dan <code>window.showToast()</code> pada
                                        <code>notifications.blade.php</code> dengan dukungan progress bar, tombol OK, reload
                                        otomatis, dan tombol Bootstrap standar.</li>
                                    <li><strong class="text-dark">High-Contrast Vector Checkbox Styling:</strong>
                                        Penambahan render eksplisit gambar vektor SVG checkmark putih (<code>stroke-width:
                                            3.5</code>) pada class <code>.high-contrast-checkbox:checked</code> dan
                                        <code>:indeterminate</code> agar tanda centang tampil tegas dan jelas di seluruh
                                        peramban.</li>
                                    <li><strong class="text-dark">Multi-Select Checkbox Filter Sync:</strong> Perbaikan
                                        kalkulasi baris aktif pada filter kategori sehingga fitur <em>Pilih Semua</em>
                                        bekerja akurat hanya pada item kategori yang sedang aktif (misal: 8 item pada
                                        Sidebar Menu Group).</li>
                                    <li><strong class="text-dark">Route Conflict Resolution:</strong> Penataan ulang urutan
                                        rute pada <code>routes/admin.php</code> dengan menempatkan rute statis
                                        (<code>bulk-action</code>, <code>toggle</code>, <code>toggle-group</code>) sebelum
                                        rute parameter <code>{id}</code> dan menambahkan constraint
                                        <code>->whereNumber('id')</code>.</li>
                                    <li><strong class="text-dark">Refined Toast Typography:</strong> Penyesuaian ukuran
                                        teks, dimensi ikon (1.5rem), dan ketebalan progress bar (3px) pada notifikasi Toast
                                        di sudut kanan atas agar tampak proporsional dan elegan.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.1.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.2</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest
                                            Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.1.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 20:55
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Overhaul &amp; Refactoring Modul Fitur Aplikasi:
                                    Skema Dynamic Row CRUD, Instant AJAX Toggle, Bulk Group Action &amp; Backward-Compatible
                                    Helper Object</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Refactoring Skema Tabel <code>fitur_aplikasi</code>
                                            (Dynamic Row Architecture):</strong> Mengubah arsitektur tabel yang sebelumnya 1
                                        row dengan puluhan kolom boolean kaku menjadi tabel baris dinamis (<code>id</code>,
                                        <code>kode_fitur</code>, <code>nama_fitur</code>, <code>kategori</code>,
                                        <code>deskripsi</code>, <code>icon</code>, <code>status</code>, <code>urutan</code>)
                                        yang dapat ditambah, diedit, dan dihapus secara leluasa.</li>
                                    <li><strong class="text-dark">Fasilitas CRUD Lengkap &amp; Modal Form Modular:</strong>
                                        Penambahan fungsi Tambah Fitur Baru, Edit Data Fitur, dan Hapus Fitur dengan
                                        konfirmasi SweetAlert2 (Rule 9) melalui partial
                                        <code>partials/fitur_aplikasi_modal.blade.php</code> (Rule 10).</li>
                                    <li><strong class="text-dark">Instant AJAX Switch Toggle &amp; Bulk Group
                                            Control:</strong> Pengalihan status fitur dapat dilakukan langsung dari tabel
                                        secara real-time via AJAX tanpa reload halaman, dilengkapi indikator badge status
                                        dan tombol pengalih massal per kategori (<em>Tampilkan Semua / Sembunyikan
                                            Semua</em>).</li>
                                    <li><strong class="text-dark">Backward-Compatible <code>FeatureSettingMap</code>
                                            Helper:</strong> Implementasi wrapper class <code>FeatureSettingMap</code> yang
                                        kompatibel dengan akses properti dinamis
                                        (<code>$appFeatures-&gt;topbar_search_box</code>) dan helper
                                        <code>FiturAplikasi::isActive('kode_fitur')</code> sehingga tidak merusak integrasi
                                        topbar maupun sidebar.</li>
                                    <li><strong class="text-dark">Seeder Bawaan Terstruktur:</strong> Penyesuaian
                                        <code>FiturAplikasiSeeder</code> untuk memuat 20 fitur bawaan standar (12 topbar
                                        header dan 8 sidebar menu groups) secara otomatis.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.1.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.1.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 19:10
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pengelolaan Avatar Pengguna, Visualisasi Lengkap
                                    Data Profil (user_details &amp; user_configs), Restriksi Menu Template Sidenav,
                                    Notifikasi Khusus Superadmin/Admin &amp; Perapian Estetika Validasi</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fasilitas Pengelolaan Avatar Pengguna (User Avatar
                                            Management):</strong> Penambahan fasilitas upload foto avatar pengguna pada form
                                        modal Create &amp; Edit dengan <em>live preview</em> gambar, tombol reset foto, dan
                                        integrasi penyimpanan berkas di <code>storage/app/public/avatars</code> pada rute
                                        <code>admin/manajemenpengguna/users</code>.</li>
                                    <li><strong class="text-dark">Visualisasi Lengkap Data <code>user_details</code> &amp;
                                            <code>user_configs</code>:</strong> Penataan ulang modal form pengguna menjadi
                                        ukuran <code>modal-xl</code> dengan 3 tab navigasi terpisah (Akun &amp; Kredensial,
                                        Identitas KTP &amp; Domisili, Preferensi &amp; Foto Sampul Header) untuk memeriksa
                                        kelengkapan data NIK, alamat lengkap, foto KTP, foto sampul, motto, dan persentase
                                        kelengkapan profil.</li>
                                    <li><strong class="text-dark">Restriksi Menu Template Sidenav:</strong> Grup menu
                                        template bawaan Inspinia pada navigasi samping kini dibatasi secara eksklusif hanya
                                        untuk role <code>superadmin</code> dan <code>admin</code>, sementara <em>Special
                                            Menu</em> tetap terbuka untuk semua pengguna.</li>
                                    <li><strong class="text-dark">Isolasi Notifikasi Administratif Topbar:</strong>
                                        Notifikasi pendaftaran akun mandiri, permohonan reset password, permintaan
                                        penonaktifan, dan aktivasi akun kini hanya dikirimkan dan ditampilkan pada topbar
                                        untuk role <code>superadmin</code> dan <code>admin</code> via
                                        <code>NotificationService</code>.</li>
                                    <li><strong class="text-dark">Penyempurnaan Spacing &amp; Estetika Validasi Form
                                            Otentikasi:</strong> Penataan ulang jarak vertikal (clean spacing) pesan error
                                        validasi input dan banner status sesi pada halaman Login, Registrasi, Lupa Password,
                                        dan Pengajuan Aktivasi Akun menggunakan gaya pill-card lembut yang rapi dan elegan.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.1.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-git-commit fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.1.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 18:15
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pembaruan Sistem Otentikasi, Idle Lock Screen, User
                                    Approval Workflow, Penonaktifan &amp; Aktivasi Akun Mandiri, Multi-Type Notification Hub
                                    &amp; Admin Reset Password</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Idle Screen Lock Otomatis:</strong> Fitur deteksi
                                        ketidakaktifan pengguna (5 menit) dengan modal lock screen AJAX, avatar pengguna,
                                        badge role, animasi getar saat sandi salah, dan integrasi topbar lock screen.</li>
                                    <li><strong class="text-dark">Alur Persetujuan Registrasi Pengguna (User Approval
                                            Workflow):</strong> Pengguna yang mendaftar mandiri berstatus
                                        <code>pending</code>, diproteksi dari login hingga disetujui, tombol persetujuan
                                        admin dengan assignment otomatis Spatie Role <code>user</code>.</li>
                                    <li><strong class="text-dark">Penonaktifan Mandiri &amp; Aktivasi Kembali Akun (Account
                                            Lifecycle):</strong> Zona bahaya penonaktifan akun pada profil pengguna, halaman
                                        pengajuan aktivasi akun nonaktif (<code>/request-activation</code>), tombol aksi
                                        admin ("Nonaktifkan" &amp; "Aktifkan"), dan integrasi SweetAlert2.</li>
                                    <li><strong class="text-dark">Pusat Notifikasi Universal Topbar (Multi-Type
                                            Notification Hub):</strong> Mengagregasikan notifikasi pendaftaran, permintaan
                                        reset password, permohonan nonaktif, permohonan aktivasi, pesan chat, dan notifikasi
                                        database Laravel via <code>NotificationService</code> terpusat sesuai standar
                                        Inspinia.</li>
                                    <li><strong class="text-dark">Permintaan Reset Password (Admin-Assisted
                                            Reset):</strong> Form forgot password dengan validasi interaktif, pengajuan
                                        permintaan reset ke administrator, tombol reset pada tabel admin ke password standar
                                        (<code>password*</code>), dan banner sukses terverifikasi.</li>
                                    <li><strong class="text-dark">Dinamisasi Branding Otentikasi &amp; Lokalisasi Bahasa
                                            Indonesia:</strong> Logo, favicon, meta title, dan teks footer form otentikasi
                                        terhubung 100% dinamis ke tabel <code>profil_aplikasi</code>, serta seluruh teks
                                        di-standarisasi ke Bahasa Indonesia.</li>
                                    <li><strong class="text-dark">Dokumentasi Resmi Alur Otentikasi:</strong> Panduan
                                        lengkap di <code>docs/arsitektur_dan_operasional_authentication_user.md</code>.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.0.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v2.0.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 14:35
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Engine Dinamisasi Tema &amp; Seksi Website Terpusat,
                                    Crop Simulator &amp; Arsitektur Partial Modular</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Arsitektur Tema &amp; Seksi Dinamis Terpusat:</strong>
                                        Membuat tabel database <code>website_themes</code> dan <code>website_sections</code>
                                        yang mengatur tema aktif, urutan seksi, gaya latar belakang, hingga background-image
                                        secara 100% dinamis tanpa hardcode view.</li>
                                    <li><strong class="text-dark">Interactive Crop Simulator &amp; Height Ratio:</strong>
                                        Modal pratinjau media interaktif (`#modal-preview-image`) yang dilengkapi 3 tombol
                                        simulasi tinggi seksi (<em>Pendek ~220px, Sedang ~380px, Tinggi ~550px</em>) dan
                                        range slider fokus vertikal (0-100%) dengan AJAX update tanpa reload.</li>
                                    <li><strong class="text-dark">Deteksi Otomatis Orientasi &amp; Efek Paralaks
                                            3D:</strong> Membaca metadata dimensi gambar asli (<em>Landscape, Portrait,
                                            Square</em>), serta menambahkan opsi <code>background-size</code>
                                        (Cover/Contain), <code>background-attachment</code> (Paralaks 3D Fixed), dan soft
                                        dark backdrop blur overlay.</li>
                                    <li><strong class="text-dark">Pemisahan Partial Modal Modular (Rule 10):</strong>
                                        Memisahkan file modal menjadi 3 partial terorganisir:
                                        <code>konfigurasi_website_modal_form</code>,
                                        <code>konfigurasi_website_modal_petunjuk</code>, dan
                                        <code>konfigurasi_website_modal_tampilgambar</code>.</li>
                                    <li><strong class="text-dark">Dokumentasi Arsitektur Resmi:</strong> Dibuat panduan
                                        resmi pengembang di <code>docs/arsitektur_dinamisasi_tema_website.md</code>.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.9.3 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-point-filled fs-xl text-muted"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.9.3</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v1.9.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 10:30
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pemisahan Tabel Config User, Pengatur Posisi Sampul
                                    Interaktif, Motto Hidup &amp; Widget Progress Kelengkapan Profil</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pemisahan Dokumen KTP &amp; Cover Header:</strong>
                                        Memisahkan tabel <code>foto_ktp</code> pada <code>user_details</code> untuk dokumen
                                        KTP fisik, dan membuat tabel baru <code>user_configs</code> (kolom
                                        <code>cover_image</code>, <code>cover_position_y</code>, <code>motto</code>) untuk
                                        konfigurasi akun.</li>
                                    <li><strong class="text-dark">Pengatur Posisi Vertikal Sampul Header:</strong> Fitur
                                        slider interaktif (0%-100%) dan tombol presisi (<em>Atas, Tengah, Bawah</em>) untuk
                                        mengatur posisi vertikal foto sampul header secara <em>real-time</em>.</li>
                                    <li><strong class="text-dark">Motto Hidup Real-time:</strong> Menambahkan kartu editor
                                        Motto Hidup dengan pratinjau ketik <em>real-time</em> di atas banner foto sampul.
                                    </li>
                                    <li><strong class="text-dark">Widget Status Kelengkapan Profil:</strong> Menambahkan
                                        widget <em>animated progress bar</em> kalkulasi kelengkapan data profil otomatis
                                        (0%-100%).</li>
                                    <li><strong class="text-dark">Toggle Password Eye Icons &amp; Rule 12:</strong>
                                        Menambahkan tombol pengintip kata sandi (kepatuhan Rule 2 &amp; Rule 7) serta
                                        menetapkan <strong>Rule 12</strong> standarisasi header widget <code>bg-primary
                                            text-white</code>.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.9.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.9.2</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v1.9.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 09:36
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Centralized Release Version Engine, Git Log
                                    Timestamps &amp; Mandatory Changelog Standard (Rule 11)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Otomatisasi Versi Terpusat (Centralized Versioning
                                            Engine):</strong> Configured <code>config('app.version')</code> via
                                        <code>APP_VERSION</code> in <code>.env</code>. Bound Sidenav Changelog badge, Footer
                                        badge, and <code>ProfilAplikasi</code> model auto-sync to a single source of truth.
                                    </li>
                                    <li><strong class="text-dark">Waktu Presisi Rilis (Git Log Timestamps):</strong>
                                        Updated all release timeline dates to include exact commit hours and minutes
                                        (<code>HH:mm WIB</code>) fetched directly from <code>git log</code> history.</li>
                                    <li><strong class="text-dark">Standar Wajib Update Changelog (Rule 11):</strong>
                                        Documented Rule 11 in <code>.agents/AGENTS.md</code> enforcing mandatory updates to
                                        <code>changelog.blade.php</code> and <code>README.md</code> prior to git push /
                                        release.</li>
                                    <li><strong class="text-dark">Panduan Rilis Interaktif (Version Release Guide
                                            Card):</strong> Added interactive 4-step version release guide card with
                                        automatic Sidenav and Footer sync explanation.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.9.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.9.1</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v1.9.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 09:17
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Module View Hierarchy Standardization (Rule 10),
                                    Meta Title Engine &amp; Sidenav Search UI Refinements</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Standarisasi Hirarki View Modul (Rule 10):</strong>
                                        Refactored <code>translation/index.blade.php</code> into flat view
                                        <code>translation.blade.php</code> and extracted modal form to
                                        <code>partials/translation_form.blade.php</code>. Documented Rule 10 in
                                        <code>.agents/AGENTS.md</code>.</li>
                                    <li><strong class="text-dark">Penyempurnaan Engine Meta Title
                                            (<code>title-meta.blade.php</code>):</strong> Bound <code>&lt;title&gt;</code>
                                        app name dynamically to <code>ProfilAplikasi</code> model (<code>app_name</code>:
                                        <em>REPALOGIC Dashboard</em>) and removed <code>"index"</code> fallback for resource
                                        routes.</li>
                                    <li><strong class="text-dark">UI Sidenav Search Input Box
                                            (<code>sidenav.blade.php</code>):</strong> Balanced search icon position
                                        (<code>ms-2</code>), adjusted typing start padding (<code>28px</code>), and applied
                                        Bootstrap 5 standard <code>text-white</code> class for white typed text and muted
                                        placeholder text without custom CSS.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.9.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.9.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build:
                                            v1.9.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 08:04
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">100% Dynamic Bilingual Engine, Custom Menu Data-Lang
                                    &amp; Admin Translation Management Module</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Kolom Kustom <code>data_lang</code> pada Tabel &amp;
                                            Modal Menu:</strong> Added <code>data_lang</code> migration, Eloquent model
                                        attribute, validation rules, and input field on <code>menu.blade.php</code> allowing
                                        custom translation keys for database menus.</li>
                                    <li><strong class="text-dark">Modul Terjemahan Bahasa
                                            (<code>/admin/dukunganaplikasi/translation</code>):</strong> Built admin
                                        translation manager enabling live CRUD operations for <code>id.json</code> and
                                        <code>en.json</code> dictionary files without manual server file edits.</li>
                                    <li><strong class="text-dark">Pengelompokkan Sidebar Menu &amp; Component
                                            Labels:</strong> Grouped translation key table dynamically by Sidebar Categories
                                        (Database Menus &amp; Template Menus) with origin position badges (<code>Menu
                                            Utama</code>, <code>Sub-Menu</code>, <code>Group Header</code>, <code>Label
                                            Sistem</code>).</li>
                                    <li><strong class="text-dark">Modal Petunjuk Operasional Bilingual:</strong> Integrated
                                        interactive step-by-step guidance modal
                                        (<code>bilingual_guide_modal.blade.php</code>) accessible from both Menu Management
                                        and Translation pages.</li>
                                    <li><strong class="text-dark">Safe Fallback &amp; Standar Proyek
                                            (.agents/AGENTS.md):</strong> Preserved graceful name fallback for unmapped keys
                                        and enforced project standards (SweetAlert2 confirm, single-line centered headers,
                                        PSR-4 autoloading).</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.8.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-user-check fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.2</h5>
                                        <span class="badge bg-info-subtle text-info fw-semibold fs-xs">Profile &amp;
                                            Identity</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            bbddc7b</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 16:47
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Management &amp; KTP Identity Details
                                </h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Profil Pengguna
                                            (`profil-pengguna.blade.php`):</strong> Implemented comprehensive user profile
                                        interface displaying detailed KTP card identity (NIK, Nama Lengkap, Tempat/Tgl
                                        Lahir, Jenis Kelamin, Alamat, RT/RW, Kelurahan, Kecamatan, Agama, Status Perkawinan,
                                        Pekerjaan, Kewarganegaraan).</li>
                                    <li><strong class="text-dark">Avatar Image Renderer:</strong> Updated avatar image
                                        rendering to prefer custom uploaded avatars with fallback to default avatar asset
                                        (<code>$user-&gt;avatar_url</code>).</li>
                                    <li><strong class="text-dark">Role &amp; Direct Access Overview:</strong> Integrated
                                        user roles badge list and direct permissions summary into profile view tabs.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.8.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-database fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.1</h5>
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">App Features
                                            &amp; Backup</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            d3c1827 &amp; 57c2d7f</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 16:07
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Application Features Switcher, Database
                                    Backup/Restore &amp; App Branding Profile</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Fitur Aplikasi
                                            (`fitur-aplikasi.blade.php`):</strong> Added real-time feature switches (Topbar
                                        elements, Sidenav menu groups, Special Menu) backed by <code>FiturAplikasi</code>
                                        model settings.</li>
                                    <li><strong class="text-dark">Modul Backup DB &amp; Restore
                                            (`backup-db.blade.php`):</strong> Implemented one-click automated SQL database
                                        backups, file size tracking, file download handler, restore functionality, and
                                        selective table backup options.</li>
                                    <li><strong class="text-dark">Profil Aplikasi (`profil-aplikasi.blade.php`):</strong>
                                        Built application branding manager for dynamic logo upload (Logo Large, Logo Small,
                                        Favicon, Application Name, Tagline, Copyright text).</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.8.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-users fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.8.0</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">User
                                            Management</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            504d930 &amp; f12f6c2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 09:31
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Management, Spatie Roles, Permissions Catalog
                                    &amp; Access Matrix Tables</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Manajemen User (`users.blade.php`):</strong> Built full
                                        user management CRUD interface with user avatar rendering, status toggling, and role
                                        assignment.</li>
                                    <li><strong class="text-dark">Manajemen Role (`role.blade.php`):</strong> Added role
                                        creation, editing, and deletion with permission count badges and role access forms.
                                    </li>
                                    <li><strong class="text-dark">Permission Matrix Table Standard (`akses_role.blade.php`
                                            &amp; `akses_user.blade.php`):</strong> Implemented Spatie permission matrix
                                        table layout (Columns: <code>MODUL / FITUR</code>, <code>CREATE</code>,
                                        <code>READ</code>, <code>UPDATE</code>, <code>DELETE</code>, <code>LAINNYA</code>,
                                        <code>SEMUA</code>) with high-contrast checkboxes and per-row <code>SEMUA</code>
                                        check/uncheck toggles.</li>
                                    <li><strong class="text-dark">Katalog Permission (`permission.blade.php`):</strong>
                                        Implemented direct permissions catalog view grouped by application features with
                                        CRUD action badges.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.7.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-sitemap fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.7.0</h5>
                                        <span class="badge bg-primary-subtle text-primary fw-semibold fs-xs">Dynamic Menu
                                            Engine</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            876177d &amp; 02ddb3a</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 15:54
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Database-Driven Dynamic Menu Engine &amp; 3-Level
                                    Menu Hierarchy</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Database Menu Engine (`menu.blade.php`):</strong>
                                        Converted static sidebar menus to database-driven <code>Menu</code> Eloquent models
                                        with full management CRUD.</li>
                                    <li><strong class="text-dark">Dukungan Menu 3 Level:</strong> Enabled 3-level nested
                                        sub-menu hierarchy (Menu Utama L1, Sub-Menu L2, Sub-Sub-Menu L3) with recursive
                                        collapse rendering, order sorting, and URL path resolution
                                        (<code>getRealUrl()</code>).</li>
                                    <li><strong class="text-dark">Kolom URL &amp; Status Centered:</strong> Added URL
                                        column after Menu Name displaying resolved URL endpoints, and centered status switch
                                        toggles across all 3 levels.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.6.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-language fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.6.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Bilingual
                                            i18n Engine</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 13:07
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Bilingual Internationalization Engine (ID &amp; EN),
                                    Topbar &amp; Customizer i18n</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Bilingual Language Scope (ID &amp; EN):</strong>
                                        Standardized language selection exclusively to Indonesian (<code>id</code>) and
                                        English (<code>en</code>), removing unused legacy locale files (<code>ar</code>,
                                        <code>de</code>, <code>es</code>, <code>hi</code>, <code>it</code>,
                                        <code>ru</code>). Added <code>id.json</code> matching complete translation
                                        dictionary.
                                    </li>
                                    <li><strong class="text-dark">Extended I18nManager Engine:</strong> Enhanced
                                        <code>I18nManager</code> in <code>app.js</code> with absolute translation path
                                        resolution (<code>/assets/data/translations/</code>), cache-busting query strings,
                                        dynamic document <code>&lt;title&gt;</code> updating, and support for
                                        <code>data-lang-placeholder</code>, <code>data-lang-title</code>, and
                                        <code>data-lang-alt</code>.
                                    </li>
                                    <li><strong class="text-dark">Topbar &amp; Search Inputs i18n:</strong> Applied
                                        bilingual translation to Topbar search input, search modal, Mega Menu, Apps
                                        dropdown, Notifications, Messages, and User Profile dropdown.</li>
                                    <li><strong class="text-dark">Admin Customizer &amp; Sidenav i18n:</strong> Fully
                                        internationalized <code>customizer.blade.php</code> (Theme Select, Color Scheme,
                                        Topbar Color, Sidenav Color, Sidebar Size, Layout Width, Direction, Position, User
                                        Info, Buttons) and Sidenav search placeholder.</li>
                                    <li><strong class="text-dark">Layout Flex Safety:</strong> Added
                                        <code>flex-shrink-0</code> to Topbar Apps avatar icon containers
                                        (<code>.avatar-md.flex-shrink-0</code>) to ensure icon boxes remain perfectly square
                                        across variable-length translations.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.5.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.5.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Full Icon
                                            Explorers</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 01:17
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Tabler & Lucide Full Icon Explorers & Recursive
                                    Sidenav Active Route Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tabler Icons Explorer (6,019 Icons):</strong>
                                        Implemented
                                        `tabler-full.blade.php` displaying full 6,019 Tabler vector icons with live search,
                                        size select (16-64px), color picker, interactive snippet board, smooth auto scroll
                                        on click, and click-to-copy HTML code.</li>
                                    <li><strong class="text-dark">Lucide Icons Explorer (309+ Icons):</strong> Implemented
                                        `lucide-full.blade.php` matching the exact Tabler pattern with SVG render, snippet
                                        preview, live search, and copy snippet action.</li>
                                    <li><strong class="text-dark">Icon Preview UI Enhancement:</strong> Updated
                                        `tabler-full.blade.php` and `lucide-full.blade.php` Preview Icon card layout to
                                        display the icon name centered directly below the icon while scaling the preview
                                        icon with the Icon Size selector.</li>
                                    <li><strong class="text-dark">Recursive Active Menu Engine:</strong> Updated
                                        `_item.blade.php` with recursive active checking
                                        (<code>str_starts_with($currentRoute, $item['route'] . '-')</code>) so parent
                                        dropdowns (`Icons`) auto-expand and child menu items (`Tabler`, `Lucide`) stay
                                        highlighted when navigating to `-full` sub-routes.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.4.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.4.0</h5>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            e7c036f & 588b10a</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 00:41
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Documentation Module & Interactive Tree Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tambah Menu Documentation:</strong> Integrated dynamic
                                        `config/sidenav-template/documentation.php` schema for all documentation pages.</li>
                                    <li><strong class="text-dark">Persiapan & Refactor Dokumentasi:</strong> Refactored 10
                                        Documentation Blade templates (`introduction`, `getting-started`,
                                        `folder-structure`, `layouts`, `sidebar`, `topbar`, `theme-skin-setup`, `dark-mode`,
                                        `sources`, `changelog`) to
                                        <code>{{ '@' }}extends('layouts.vertical')</code>.
                                    </li>
                                    <li><strong class="text-dark">Interactive Directory Tree:</strong> Upgraded
                                        `folder-structure.blade.php` to use authentic INSPINIA jsTree
                                        (`plugins-treeview.js`) with `wholerow` full-width node highlights and custom file
                                        icons.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.3.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-layout-board fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.3.0</h5>
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">Layout &
                                            Custom
                                            Refactor</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            3a391e2 & 5858a50</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 23:17
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Layout Group Demo & Custom Pages Refactoring</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Refactor Template Layouts (18 Views):</strong> Converted
                                        all demo views under `template/layouts/` to
                                        <code>{{ '@' }}extends('layouts.vertical')</code> or
                                        <code>{{ '@' }}extends('layouts.horizontal')</code>.
                                    </li>
                                    <li><strong class="text-dark">Preservation of Layout Attributes:</strong> Passed
                                        layout-specific HTML attributes (`data-layout-width="boxed"`,
                                        `data-sidenav-size="compact"`, `data-topbar-color="dark"`,
                                        `class="sidebar-with-line"`) via
                                        <code>{{ '@' }}section('html_attribute')</code>.
                                    </li>
                                    <li><strong class="text-dark">Refactor Custom Group:</strong> Refactored auth basic,
                                        card, split, error pages, and custom plugin pages under `template/custom/`.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.2.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-arrows-vertical fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.2.0</h5>
                                        <span class="badge bg-info-subtle text-info fw-semibold fs-xs">Sidenav &
                                            Components</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            7cbf31c & 2f7585d</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 22:51
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Sidenav Auto-Scroll Centering & Component Menu
                                    Group
                                </h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Perbaikan Scroll Otomatis Sidenav:</strong> Implemented
                                        `centerActiveMenuItem` script in `sidenav.blade.php` to smoothly scroll active
                                        sub-menu items to 50% vertical center of the sidebar container.</li>
                                    <li><strong class="text-dark">Refactor Kelompok Menu Component & Apps:</strong>
                                        Converted UI elements, charts (Apex & ECharts), forms, tables, icons, and maps views
                                        under `template/components/` and `template/apps/`.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.1.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-route fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.1.0</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Dynamic
                                            Routes
                                            & Titles</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            8bea610 & b6d118e</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 22:46
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dynamic Navigation Config & Multi-Word Breadcrumb
                                    Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Perbaikan Page-Title & Breadcrumb:</strong> Updated
                                        `page-title.blade.php` and `title-meta.blade.php` to recursively search
                                        `config('sidenav-template')` for exact multi-word page titles.</li>
                                    <li><strong class="text-dark">Breadcrumb Root Label:</strong> Replaced root breadcrumb
                                        label `Inspinia` with `Template`, and omitted leaf page title from right-hand
                                        breadcrumb trail.</li>
                                    <li><strong class="text-dark">Routing dan Rekursif Menu:</strong> Implemented dynamic
                                        route resolver `routes/template.php` mapping Blade view hierarchy to dot-notation
                                        routes.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 1.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v1.0.0</h5>
                                        <span class="badge bg-secondary-subtle text-secondary fw-semibold fs-xs">Initial
                                            Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            bbc6dc0 - e6f6c13</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 10:08
                                        WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Initial Project Release & Repository Setup</h6>
                                <ul class="text-muted fs-14 mb-0 ps-3">
                                    <li>Initial commit and repository initialization for Repalogic Dashboard template.</li>
                                    <li>Setup core Laravel 12 architecture, Vite asset bundler, and SCSS theme files.</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
