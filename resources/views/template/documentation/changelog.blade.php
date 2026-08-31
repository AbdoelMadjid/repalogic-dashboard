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
                                <i class="ti ti-git-commit me-1"></i> Current Build: <strong>v2.4.8</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Release Procedure Guide Card (Khusus Superadmin & Admin) -->
        @if (auth()->check() && auth()->user()->hasAnyRole(['superadmin', 'admin']))
            <div class="col-12 mb-4">
                <div class="card border border-info-subtle shadow-sm">
                    <div class="card-header bg-info-subtle py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-info-emphasis">
                            <i class="ti ti-book me-2"></i> Standar Prosedur Pembaruan Versi Rilis / Tag (Version Release Guide)
                        </h5>
                        <span class="badge bg-info text-white font-monospace">Centralized Engine</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary rounded-circle p-1.5 me-2"><i class="ti ti-settings fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">1. Update APP_VERSION</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Perbarui variabel <code>APP_VERSION</code> pada berkas <code>.env</code>, <code>.env.example</code>, dan <code>config/app.php</code>.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-success rounded-circle p-1.5 me-2"><i class="ti ti-history fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">2. Update Changelog</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Tambahkan riwayat pembaruan baru pada timeline ini dengan timestamp presisi WIB.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-warning rounded-circle p-1.5 me-2"><i class="ti ti-file-text fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">3. Update Release Doc</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Tambahkan baris rilis baru pada dokumen <code>docs/riwayat_release_dan_tag.md</code>.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-info rounded-circle p-1.5 me-2"><i class="ti ti-git-merge fs-14"></i></span>
                                        <h6 class="fw-bold mb-0 text-dark">4. Git Tag Release</h6>
                                    </div>
                                    <p class="fs-13 text-muted mb-0">
                                        Lakukan commit perubahan lalu buat tag git baru dan lakukan push tag ke repositori.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Changelog Timeline Section -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="ti ti-git-branch me-2 text-primary"></i> Timeline Pembaruan Sistem (Timeline Changelog)
                    </h5>
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1.5 rounded-pill">Production Ready</span>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-icon-bordered">
                        <!-- Version 2.4.8 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-star-filled fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3 pb-4 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.4.8</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.8</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 19:12 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Application Settings Hub &amp; Maintenance Mode Engine: 6 Interactive Control Widgets, Dynamic Idle Lock Screen, 503 Maintenance Page, Global Middleware Protection &amp; User KTP Photo Preview Modal</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Hub Panel Kontrol &amp; Pengaturan Fitur Terpadu (<code>admin/dukunganaplikasi/fitur-aplikasi</code>):</strong> Menghadirkan 6 widget interaktif untuk manajemen visibilitas fitur sistem, waktu idle auto lock, mode pemeliharaan, kebijakan keamanan autentikasi, sinkronisasi polling real-time, dan pembersih seluruh cache server.</li>
                                    <li><strong class="text-dark">Mode Pemeliharaan (Maintenance Mode) &amp; Akses Administrator:</strong> Proteksi menyeluruh via middleware <code>CheckMaintenanceMode</code> dan <code>LoginRequest</code>. Akun superadmin &amp; admin tetap memiliki akses penuh (bypass otomatis), sementara akun non-admin/tamu diblokir login dan diarahkan ke halaman responsif <code>errors/503.blade.php</code>.</li>
                                    <li><strong class="text-dark">Pengatur Waktu Idle Dinamis (Auto Screen Lock):</strong> Durasi ketidakaktifan pengguna tersinkronisasi instan antara cache server dan browser localStorage dengan tombol pengujian langsung (<code>window.lockScreen()</code>).</li>
                                    <li><strong class="text-dark">Preview Foto KTP Profil Pengguna (<code>admin/profil-pengguna</code>):</strong> Penambahan baris dokumen KTP fisik di bagian bawah tabel detail kelengkapan identitas pengguna dengan tombol preview modal ukuran penuh, unduh berkas, dan buka tab baru.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.7</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 17:18 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Cover Height Customization Engine: Real-Time Proportional Slider, Inline Presets &amp; Synchronized Aspect Ratio WYSIWYG</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pengatur Tinggi Foto Sampul Header Profil:</strong> Penambahan kontrol slider real-time (180px - 600px) dan tombol preset tinggi inline (Ringkas 220px, Standar 320px, Tinggi 450px) pada widget Foto Sampul di halaman Profil Pengguna (<code>admin/profil-pengguna</code>) yang tersimpan permanen di database.</li>
                                    <li><strong class="text-dark">Sinkronisasi Rasio Dimensi Pratinjau (Aspect Ratio WYSIWYG):</strong> Sinkronisasi rasio aspek kotak pratinjau thumbnail di sidebar dengan ukuran banner header utama secara otomatis dan responsif saat diubah maupun di-resize.</li>
                                    <li><strong class="text-dark">Sinkronisasi Halaman KTP:</strong> Header banner pada halaman kelengkapan data KTP (<code>admin/profil-pengguna/edit</code>) otomatis mengikuti preferensi tinggi yang telah disimpan.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.6</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 17:00 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Chat Suite: In-Chat Search, Pinned Messages, Emoji Reactions, Message Forwarding &amp; Voice Note Audio Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pencarian Pesan Interaktif (In-Chat Search Bar):</strong> Fitur navigasi dan penyorotan teks pesan real-time dalam obrolan aktif dengan indikator pencocokan (Match Counter misal: <em>1/3</em>), tombol navigasi Next/Prev, dan animasi pulse scroll fokus.</li>
                                    <li><strong class="text-dark">Sematkan Pesan Penting (Pinned Messages):</strong> Banner sematan elegan di bagian atas jendela obrolan dengan cuplikan teks, fungsi klik langsung menuju pesan (jump-to-message), serta aksi pin/unpin per pesan.</li>
                                    <li><strong class="text-dark">Reaksi Emoji Cepat (Message Reactions):</strong> Palette reaksi emoji melayang (👍 ❤️ 😂 😮 😢 🙏) dan badge pill interaktif di bawah setiap balon chat dengan counter jumlah reaksi dan toggle reaksi pengguna.</li>
                                    <li><strong class="text-dark">Teruskan Pesan (Forward Messages):</strong> Modal pencarian dan pemilihan kontak instan untuk meneruskan pesan teks maupun lampiran ke pengguna lain dengan label <em>"Diteruskan"</em>.</li>
                                    <li><strong class="text-dark">Perekam &amp; Pemutar Pesan Suara (Voice Note Recorder &amp; Web Audio Player):</strong> Dukungan Web Audio API MediaRecorder dengan timer durasi rekaman, tombol batal/kirim, serta pemutar audio kustom modern di dalam balon obrolan dengan progress bar yang dapat diklik (seekable).</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:36 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Clear Conversation History Engine &amp; Instant Sidebar Demotion (Keep Opponent Chat Intact)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pembersihan Riwayat Percakapan Sepihak (Clear Chat for Me):</strong> Penambahan tombol <em>"Bersihkan Obrolan"</em> di header area pesan untuk menghapus/membersihkan seluruh riwayat chat dengan kontak aktif dari tampilan pengguna, sementara lawan obrolan tetap mempertahankan seluruh riwayat pesan secara lengkap.</li>
                                    <li><strong class="text-dark">Pemindahan Kontak Instan Tanpa Refresh:</strong> Ketika seluruh obrolan dibersihkan atau pesan habis dihapus, kontak seketika (0ms delay) berpindah dari kelompok <em>"Percakapan Aktif"</em> ke <em>"Pengguna Lainnya"</em> di sidebar lengkap dengan pembaruan badge counter real-time.</li>
                                    <li><strong class="text-dark">Dukungan Flag DB deleted_for_sender &amp; deleted_for_receiver:</strong> Penambahan kolom <code>deleted_for_sender</code> dan optimalisasi <code>scopeVisibleTo()</code> sehingga pesan terkirim maupun pesan diterima dapat disembunyikan secara presisi per pengguna.</li>
                                    <li><strong class="text-dark">SweetAlert2 Confirmation Dialog:</strong> Dilengkapi dialog konfirmasi interaktif dengan pesan peringatan yang informatif dan pembaruan instan state tombol serta placeholder.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:30 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Dual-Mode Chat Message Deletion Engine (Unsend for Everyone &amp; Delete for Me)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Hapus Pesan Terkirim (Tarik untuk Semua Orang / Unsend):</strong> Pesan yang dikirim oleh pengguna aktif dapat ditarik/dihapus secara permanen dari basis data dan langsung tidak terlihat lagi pada layar lawan obrolan secara instan dan sinkron.</li>
                                    <li><strong class="text-dark">Hapus Pesan Diterima (Hapus untuk Saya / Delete for Me):</strong> Pesan dari lawan obrolan yang dihapus oleh pengguna hanya disembunyikan dari riwayat percakapan pengguna aktif via kolom <code>deleted_for_receiver</code>, sementara lawan obrolan (pengirim) tetap dapat melihat pesan tersebut secara utuh.</li>
                                    <li><strong class="text-dark">SweetAlert2 Confirmation Dialog &amp; Smooth Fadeout:</strong> Konfirmasi penghapusan pesan terstandarisasi dengan modal SweetAlert2 (Rule 9) dan animasi penghapusan elemen bubble chat yang mulus seketika.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:22 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Instant Empty History Placeholder Disappearance on First Chat Send</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pembersihan Instan Placeholder Obrolan Kosong:</strong> Kotak <em>"Belum Ada Riwayat Obrolan"</em> kini langsung hilang seketika (0ms delay) pada saat pesan pertama dikirim tanpa jeda render DOM.</li>
                                    <li><strong class="text-dark">Standarisasi ID &amp; Class Placeholder:</strong> Penyeragaman atribut <code>chat-placeholder-box</code> pada seluruh kondisi state (Blade initial load, AJAX conversation switch, dan quick transition loading) untuk pembersihan DOM yang mulus dan bebas glitch.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:15 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Zero-Latency Optimistic UI Message Sending &amp; Instant Seamless Contact Switch Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pengiriman Pesan Instan (Optimistic UI):</strong> Balon pesan yang dikirim kini langsung muncul di layar detik itu juga (0ms delay) dengan status jam/indikator pending, form langsung dibersihkan, dan auto-scroll seketika tanpa menunggu respon server.</li>
                                    <li><strong class="text-dark">Sinkronisasi Background Asinkron:</strong> Permintaan pengiriman dikirim di latar belakang. ID pesan, link lampiran, dan tanda centang terkirim diperbarui secara mulus setelah server merespon.</li>
                                    <li><strong class="text-dark">Perpindahan Kontak Seketika (Instant Contact Switch):</strong> Saat memilih atau membuat obrolan baru dengan pengguna lain, header aktif dan input chat langsung aktif dan fokus seketika dengan transisi pemuatan yang halus.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 16:05 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Chat Contact Avatar Spacing Optimization, Standard Framed Lightbox Modal Image Preview &amp; Interactive Reply Quote Jump Navigation</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Penyelarasan Spasi Avatar Kontak:</strong> Mengoreksi class layout daftar kontak obrolan sidebar ke standar <code>gap-3</code> (16px) sehingga posisi foto profil avatar dan nama pengguna berjarak proporsional dan rapi.</li>
                                    <li><strong class="text-dark">Framing Elegan Lightbox Pratinjau Gambar:</strong> Penyempurnaan modal lightbox gambar obrolan dengan dimensi standar berbingkai (<code>max-width: 580px</code>, <code>max-height: 420px</code>) dan padding vertikal luas (<code>py-5 px-4</code>) berlatar gelap halus, tetap mempertahankan unduhan file beresolusi asli via tombol <em>Unduh Asli</em>.</li>
                                    <li><strong class="text-dark">Navigasi Interaktif Kutipan Balasan Pesan (Reply Quote Jump):</strong> Kotak kutipan balasan obrolan (<em>reply quote box</em>) kini dapat diklik untuk melakukan <em>smooth scroll</em> otomatis langsung ke pesan target asal lengkap dengan animasi <em>pulse highlight</em> fokus biru yang memikat.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.4.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-31 15:30 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Impersonation Engine (Switch Akun), Floating Sticky Impersonation Alert Banner &amp; Quick Switch-Back Action Hub</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Switch Akun (User Impersonation):</strong> Administrator dengan permission <code>update manajemenpengguna/users</code> atau role <code>superadmin</code>/<code>admin</code> dapat langsung login sementara sebagai akun pengguna target tanpa memerlukan kata sandi.</li>
                                    <li><strong class="text-dark">Proteksi Sesi &amp; Keamanan Terpadu:</strong> Sesi pengguna asli disimpan secara aman di Laravel session (<code>impersonator_id</code>, <code>impersonator_name</code>, <code>impersonator_role</code>) serta pencegahan <em>nested switch</em> bertingkat dan restriksi switch ke akun diri sendiri atau akun tidak aktif.</li>
                                    <li><strong class="text-dark">Floating Sticky Impersonation Banner:</strong> Banner visual responsif di bagian atas seluruh halaman saat mode switch akun aktif, menampilkan identitas akun aktif beserta nama akun asli dan tombol cepat <em>Kembali ke Akun Utama</em>.</li>
                                    <li><strong class="text-dark">Integrasi UI Tabel Pengguna &amp; Topbar Dropdown:</strong> Penambahan tombol aksi <code>ti-replace-user</code> pada tabel Manajemen Pengguna serta opsi pengembalian sesi instan pada menu dropdown akun di topbar navbar.</li>
                                </ul>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border fs-xs">User Impersonation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Switch Akun</span>
                                    <span class="badge bg-light text-dark border fs-xs">Session Preservation</span>
                                    <span class="badge bg-light text-dark border fs-xs">Floating Impersonation Banner</span>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.5</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 16:40 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Direct Chat Image &amp; File Attachment Upload, Pre-Upload Live File Preview Bar, Image Lightbox Modal &amp; Real-Time Avatar Synchronization</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Kirim Gambar &amp; Lampiran Berkas:</strong> Penambahan tombol lampiran berkas (<code>ti-paperclip</code>) di samping tombol emoji pada formulir chat, mendukung upload gambar (JPG, PNG, WEBP, GIF) dan dokumen (PDF, DOCX, XLSX, ZIP, TXT) hingga ukuran 10 MB.</li>
                                    <li><strong class="text-dark">Bar Pratinjau Berkas Interaktif (Live Preview Bar):</strong> Penampilan thumbnail pratinjau instan untuk foto atau ikon format dokumen dengan indikator nama dan ukuran berkas sebelum pesan dikirim, lengkap dengan tombol pembatalan (<em>cancel attachment</em>).</li>
                                    <li><strong class="text-dark">Modal Lightbox Gambar &amp; Kartu Berkas Obrolan:</strong> Kartu gambar responsif dengan efek zoom saat hover yang dapat diklik untuk pratinjau resolusi tinggi pada modal lightbox (<code>#chat-image-modal</code>) serta tombol unduh langsung, dan kartu dokumen rapi dengan tombol download instan.</li>
                                    <li><strong class="text-dark">Sinkronisasi Avatar Real-Time:</strong> Pembaruan dinamis foto profil pengguna di sidebar kontak, header aktif obrolan, modal detail, dan seluruh balon pesan obrolan secara instan saat pengguna memperbarui avatar mereka tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Integrasi Skema &amp; Ringkasan Pesan:</strong> Migrasi kolom metadata lampiran (<code>attachment_name</code>, <code>attachment_type</code>, <code>attachment_size</code>) pada tabel <code>messages</code> dan pemformatan ringkasan pesan otomatis pada sidebar kontak (📷 <em>[Foto / Gambar]</em> atau 📎 <em>[Berkas]</em>).</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 16:11 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Real-Time Sidebar Contacts Sync Engine, Auto Unread Badges Counter, Background Contact Polling &amp; Message Hub Bridge</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Polling Kontak &amp; Badge Unread Real-Time:</strong> Penambahan endpoint <code>admin/profil-pengguna/messages/poll-contacts</code> yang berjalan di latar belakang setiap 3.5 detik untuk memperbarui angka pesan masuk (<em>unread counter badge</em>), cuplikan pesan terakhir, dan timestamp kontak di sidebar penerima secara otomatis tanpa reload halaman.</li>
                                    <li><strong class="text-dark">Promosi Kontak Otomatis (Auto-Promote to Recent):</strong> Kontak yang baru mengirimkan pesan otomatis dipindahkan ke posisi teratas bagian <code>Percakapan Aktif</code> secara langsung di browser penerima.</li>
                                    <li><strong class="text-dark">Sinkronisasi Penuh Topbar &amp; Chat Hub:</strong> Integrasi pembersihan badge unread otomatis saat pesan dibuka atau dibalas, serta sinkronisasi instan ke ikon amplop notifikasi topbar via <code>window.fetchMessagesSilently()</code>.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 15:58 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Chat Emoji &amp; Emotion Picker, Multi-Category Emotion Grid, Real-Time Keyword Search &amp; Cursor-Aware Insertion Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Pemilih Emoji &amp; Emoticon Interaktif:</strong> Penambahan tombol pemilih emoji (<code>ti-mood-smile</code>) pada kolom input chat dengan panel popover modern lengkap dengan bar reaksi cepat (<em>Quick Reactions</em>: 👍, ❤️, 😂, 🔥, 🎉, 🙏, 😊, 👏, 🚀).</li>
                                    <li><strong class="text-dark">Pengelompokan 5 Kategori Emoji &amp; Navigasi Tab:</strong> Struktur basis data emoji terorganisir yang mencakup kategori <em>Senyum &amp; Emosi</em> (😀), <em>Gestur &amp; Tangan</em> (👍), <em>Hati &amp; Cinta</em> (❤️), <em>Objek &amp; Simbol</em> (🎉), serta <em>Aktivitas</em> (☕).</li>
                                    <li><strong class="text-dark">Pencarian Emoji Real-Time Multibahasa:</strong> Filter pencarian emoji instan berdasarkan kata kunci dwibahasa (misal: <em>senyum, cinta, api, jempol, sedih, kopi</em> maupun tag bahasa Inggris).</li>
                                    <li><strong class="text-dark">Penyisipan Cerdas Berdasarkan Posisi Kursor (Cursor-Aware Insertion):</strong> Emoji disisipkan tepat pada posisi kursor pengguna saat ini tanpa menghilangkan fokus input atau menghapus draf teks yang sedang diketik.</li>
                                    <li><strong class="text-dark">Interaksi UI &amp; Auto-Dismiss:</strong> Penutupan otomatis popup emoji saat klik di luar area maupun penekanan tombol <code>Escape</code>, serta aktivasi tombol otomatis saat memilih kontak lawan bicara.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 15:02 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Interactive Message Reply/Quote Engine, Parent Message ID DB Schema, Dynamic Quoted Box &amp; Auto Sync Message Hub</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fitur Balas / Reply Pesan Interaktif:</strong> Penambahan tombol <code>Balas</code> pada setiap bubble pesan pengguna (baik pesan pengirim maupun lawan obrolan) serta bar pratinjau balasan di atas kolom input dengan tombol pembatalan instan.</li>
                                    <li><strong class="text-dark">Skema Database &amp; Model Relasi:</strong> Penambahan kolom <code>parent_id</code> (foreign key nullable ke <code>messages.id</code>) pada tabel <code>messages</code> serta relasi Eloquent <code>parent()</code>.</li>
                                    <li><strong class="text-dark">Kotak Kutipan Dinamis (Quote Box):</strong> Tampilan balasan pesan di dalam bubble obrolan yang menampilkan nama pengirim asal secara proporsional (misal label <code>Anda</code> pada pengirim atau Nama Lawan Chat) serta potongan teks pesan yang dibalas.</li>
                                    <li><strong class="text-dark">Penanganan Safe Payload AJAX &amp; Topbar Hub:</strong> Sanitasi parameter <code>parent_id</code> secara aman di backend controller dan frontend AJAX untuk mencegah kegagalan validasi, serta sinkronisasi otomatis ke Message Dropdown di navbar.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 14:55 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Categorized Contact Sidebar, Grouped Topbar Messages Dropdown, Smart Scroll Preservation &amp; Universal Profile Detail Modal</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pemisahan Kontak Sidebar Chat:</strong> Pengelompokan kontak menjadi bagian <code>Percakapan Aktif</code> (diurutkan berdasarkan pesan terbaru) dan <code>Pengguna Lainnya</code> dengan promosi kontak otomatis secara real-time saat obrolan baru dikirim.</li>
                                    <li><strong class="text-dark">Pengelompokan Pesan Topbar Dropdown:</strong> Pesan pada dropdown amplop topbar kini dikelompokkan 1 baris per pengirim dengan indikator badge jumlah chat baru (misal <code>3 Chat</code>), serta navigasi langsung ke halaman percakapan chat tanpa modal pop-up.</li>
                                    <li><strong class="text-dark">Notifikasi Penolakan ke Alur Chat:</strong> Penolakan permohonan registrasi/penonaktifan oleh Superadmin/Admin disimpan lengkap dengan <code>conversation_id</code> sehingga otomatis muncul di timeline obrolan pengguna.</li>
                                    <li><strong class="text-dark">Smart Scroll Position Handling:</strong> Pencegahan scroll otomatis ke bawah secara paksa ketika pengguna sedang scroll ke atas membaca riwayat pesan lama, serta eliminasi re-render DOM yang tidak perlu saat polling background.</li>
                                    <li><strong class="text-dark">Modal Detail Akun Pengguna Universal:</strong> Pengubahan tombol <code>Detail Akun</code> di header obrolan menjadi modal pop-up yang dapat diakses oleh seluruh pengguna (termasuk role User) untuk melihat profil lengkap lawan bicara.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.3.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-28 10:15 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Real-Time Notification Polling, Self-Registration Rejection Workflow, Deactivation Request Notification System &amp; Topbar Layout Refinements</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tabel Database Dedicated Messages:</strong> Pembuatan skema tabel <code>messages</code> khusus untuk arsitektur pengiriman pesan/chat antarpengguna dan notifikasi sistem dengan dukungan <code>sender_id</code>, <code>receiver_id</code>, <code>conversation_id</code>, <code>subject</code>, <code>body</code>, <code>reason</code>, dan <code>read_at</code>.</li>
                                    <li><strong class="text-dark">Tombol Pesan di Profil Pengguna:</strong> Penambahan tombol <code>Pesan</code> hijau pada header <code>admin/profil-pengguna</code> di samping kanan tombol Kelengkapan Data KTP.</li>
                                    <li><strong class="text-dark">Real-Time Messages &amp; Notification Polling:</strong> Pembaruan otomatis notifikasi &amp; pesan topbar setiap 20 detik via AJAX tanpa mengganggu timer idle atau lock screen, dengan indikator badge status <code>Belum dibaca</code> dan <code>Sudah dibaca</code>.</li>
                                    <li><strong class="text-dark">Alur Penolakan Registrasi Mandiri &amp; Non-Aktif:</strong> Penolakan permohonan penonaktifan mengirimkan pesan terintegrasi ke tabel <code>messages</code>. Mengklik notifikasi/pesan akan membuka modal detail alasan penolakan dan menandai pesan sebagai dibaca.</li>
                                    <li><strong class="text-dark">UserFactory &amp; Automated User Seeder:</strong> Konfigurasi <code>UserFactory</code> dan <code>DatabaseSeeder</code> untuk menghasilkan 10 akun dummy pengguna baru secara otomatis dengan atribusi Spatie Role <code>user</code>, penanganan status badge <code>Pendaftaran Ditolak</code> pada tabel data pengguna, dan pembaruan layout status pesan di bawah waktu topbar.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.2.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 23:28 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Login Tracking Engine, 24-Hour Point Accumulation, Geolocation Coordinates Capture &amp; Data Login Dashboard</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">24-Hour / Daily Login Points Engine:</strong> Sistem perhitungan poin cerdas dengan aturan penambahan 1 poin pada login pertama setiap hari (atau interval 24 jam). Login berulang dalam hari yang sama tidak menambah poin, tetapi seluruh riwayat sesi tetap dicatat lengkap.</li>
                                    <li><strong class="text-dark">Comprehensive Login History Audit:</strong> Pencatatan otomatis jenis browser, sistem operasi/platform, tipe perangkat (Desktop/Mobile/Tablet), alamat IP klien, tanggal &amp; waktu presisi, serta status penambahan poin pada setiap sesi login.</li>
                                    <li><strong class="text-dark">Non-Blocking Geolocation Coordinates:</strong> Pengambilan titik koordinat GPS (latitude &amp; longitude) secara asynchronous via HTML5 Geolocation API pada form login tanpa menghambat kecepatan submit pengguna.</li>
                                    <li><strong class="text-dark">Modul Admin Data Login:</strong> Antarmuka terpusat di <code>admin/manajemenpengguna/data-login</code> dengan 4 kartu statistik real-time, filter tanggal/pengguna/pencarian, Tab Pengguna Login Hari Ini, Tab Semua Riwayat Login dengan pagination, Modal Detail Sesi Login dengan integrasi OpenStreetMap &amp; Google Maps, serta fitur pembersihan log lama.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.1.4</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 23:02 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Public Landing Page Footer Overhaul, Drag &amp; Drop Website Sections Reordering, Fitur Aplikasi Header Clean-up &amp; SweetAlert2 Clean Native Restoration</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Landing Page Footer Modernization:</strong> Menghapus menu Admin dari footer publik, menstrukturisasi kategori Company &amp; Community menjadi 2 sub-kolom responsif, merombak styling dengan dark gradient, ambient glow, tombol sosial media glassmorphism, dan menyempurnakan jarak badge Hiring.</li>
                                    <li><strong class="text-dark">Website Sections Drag &amp; Drop Reordering:</strong> Mengintegrasikan SortableJS pada Konfigurasi Website dengan drag handle, live badge renumbering, dan auto-save instan via AJAX ke server.</li>
                                    <li><strong class="text-dark">Fitur Aplikasi Header Clean-up:</strong> Mengubah tombol badge "Auto-Save Instant" menjadi teks informasi yang elegan dengan ikon petir.</li>
                                    <li><strong class="text-dark">SweetAlert2 Native Restoration &amp; Firm Theme Colors:</strong> Menghapus modifikasi CSS usang dari tema Inspinia di <code>app.css</code> dan <code>app.min.css</code> yang memotong koordinat centang, serta menerapkan warna Emerald/Primary tegas <code>#10b981</code> pada ikon notifikasi.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.1.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 21:35 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Universal SweetAlert2 Notification Engine &amp; Global Helpers, High-Contrast Checkbox SVG Fix, Multi-Select Filter Sync &amp; Route Order Optimization</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Universal SweetAlert2 Global Helpers (Rule 9):</strong> Sentralisasi helper <code>window.showSuccess()</code>, <code>window.showError()</code>, <code>window.showWarning()</code>, <code>window.showConfirm()</code>, dan <code>window.showToast()</code> pada <code>notifications.blade.php</code> dengan dukungan progress bar, tombol OK, reload otomatis, dan tombol Bootstrap standar.</li>
                                    <li><strong class="text-dark">High-Contrast Vector Checkbox Styling:</strong> Penambahan render eksplisit gambar vektor SVG checkmark putih (<code>stroke-width: 3.5</code>) pada class <code>.high-contrast-checkbox:checked</code> dan <code>:indeterminate</code> agar tanda centang tampil tegas dan jelas di seluruh peramban.</li>
                                    <li><strong class="text-dark">Multi-Select Checkbox Filter Sync:</strong> Perbaikan kalkulasi baris aktif pada filter kategori sehingga fitur <em>Pilih Semua</em> bekerja akurat hanya pada item kategori yang sedang aktif (misal: 8 item pada Sidebar Menu Group).</li>
                                    <li><strong class="text-dark">Route Conflict Resolution:</strong> Penataan ulang urutan rute pada <code>routes/admin.php</code> dengan menempatkan rute statis (<code>bulk-action</code>, <code>toggle</code>, <code>toggle-group</code>) sebelum rute parameter <code>{id}</code> dan menambahkan constraint <code>->whereNumber('id')</code>.</li>
                                    <li><strong class="text-dark">Refined Toast Typography:</strong> Penyesuaian ukuran teks, dimensi ikon (1.5rem), dan ketebalan progress bar (3px) pada notifikasi Toast di sudut kanan atas agar tampak proporsional dan elegan.</li>
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
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest Release</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.1.2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 20:55 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Overhaul &amp; Refactoring Modul Fitur Aplikasi: Skema Dynamic Row CRUD, Instant AJAX Toggle, Bulk Group Action &amp; Backward-Compatible Helper Object</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Refactoring Skema Tabel <code>fitur_aplikasi</code> (Dynamic Row Architecture):</strong> Mengubah arsitektur tabel yang sebelumnya 1 row dengan puluhan kolom boolean kaku menjadi tabel baris dinamis (<code>id</code>, <code>kode_fitur</code>, <code>nama_fitur</code>, <code>kategori</code>, <code>deskripsi</code>, <code>icon</code>, <code>status</code>, <code>urutan</code>) yang dapat ditambah, diedit, dan dihapus secara leluasa.</li>
                                    <li><strong class="text-dark">Fasilitas CRUD Lengkap &amp; Modal Form Modular:</strong> Penambahan fungsi Tambah Fitur Baru, Edit Data Fitur, dan Hapus Fitur dengan konfirmasi SweetAlert2 (Rule 9) melalui partial <code>partials/fitur_aplikasi_modal.blade.php</code> (Rule 10).</li>
                                    <li><strong class="text-dark">Instant AJAX Switch Toggle &amp; Bulk Group Control:</strong> Pengalihan status fitur dapat dilakukan langsung dari tabel secara real-time via AJAX tanpa reload halaman, dilengkapi indikator badge status dan tombol pengalih massal per kategori (<em>Tampilkan Semua / Sembunyikan Semua</em>).</li>
                                    <li><strong class="text-dark">Backward-Compatible <code>FeatureSettingMap</code> Helper:</strong> Implementasi wrapper class <code>FeatureSettingMap</code> yang kompatibel dengan akses properti dinamis (<code>$appFeatures-&gt;topbar_search_box</code>) dan helper <code>FiturAplikasi::isActive('kode_fitur')</code> sehingga tidak merusak integrasi topbar maupun sidebar.</li>
                                    <li><strong class="text-dark">Seeder Bawaan Terstruktur:</strong> Penyesuaian <code>FiturAplikasiSeeder</code> untuk memuat 20 fitur bawaan standar (12 topbar header dan 8 sidebar menu groups) secara otomatis.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.1.1</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 19:10 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pengelolaan Avatar Pengguna, Visualisasi Lengkap Data Profil (user_details &amp; user_configs), Restriksi Menu Template Sidenav, Notifikasi Khusus Superadmin/Admin &amp; Perapian Estetika Validasi</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Fasilitas Pengelolaan Avatar Pengguna (User Avatar Management):</strong> Penambahan fasilitas upload foto avatar pengguna pada form modal Create &amp; Edit dengan <em>live preview</em> gambar, tombol reset foto, dan integrasi penyimpanan berkas di <code>storage/app/public/avatars</code> pada rute <code>admin/manajemenpengguna/users</code>.</li>
                                    <li><strong class="text-dark">Visualisasi Lengkap Data <code>user_details</code> &amp; <code>user_configs</code>:</strong> Penataan ulang modal form pengguna menjadi ukuran <code>modal-xl</code> dengan 3 tab navigasi terpisah (Akun &amp; Kredensial, Identitas KTP &amp; Domisili, Preferensi &amp; Foto Sampul Header) untuk memeriksa kelengkapan data NIK, alamat lengkap, foto KTP, foto sampul, motto, dan persentase kelengkapan profil.</li>
                                    <li><strong class="text-dark">Restriksi Menu Template Sidenav:</strong> Grup menu template bawaan Inspinia pada navigasi samping kini dibatasi secara eksklusif hanya untuk role <code>superadmin</code> dan <code>admin</code>, sementara <em>Special Menu</em> tetap terbuka untuk semua pengguna.</li>
                                    <li><strong class="text-dark">Isolasi Notifikasi Administratif Topbar:</strong> Notifikasi pendaftaran akun mandiri, permohonan reset password, permintaan penonaktifan, dan aktivasi akun kini hanya dikirimkan dan ditampilkan pada topbar untuk role <code>superadmin</code> dan <code>admin</code> via <code>NotificationService</code>.</li>
                                    <li><strong class="text-dark">Penyempurnaan Spacing &amp; Estetika Validasi Form Otentikasi:</strong> Penataan ulang jarak vertikal (clean spacing) pesan error validasi input dan banner status sesi pada halaman Login, Registrasi, Lupa Password, dan Pengajuan Aktivasi Akun menggunakan gaya pill-card lembut yang rapi dan elegan.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.1.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 18:15 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pembaruan Sistem Otentikasi, Idle Lock Screen, User Approval Workflow, Penonaktifan &amp; Aktivasi Akun Mandiri, Multi-Type Notification Hub &amp; Admin Reset Password</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Idle Screen Lock Otomatis:</strong> Fitur deteksi ketidakaktifan pengguna (5 menit) dengan modal lock screen AJAX, avatar pengguna, badge role, animasi getar saat sandi salah, dan integrasi topbar lock screen.</li>
                                    <li><strong class="text-dark">Alur Persetujuan Registrasi Pengguna (User Approval Workflow):</strong> Pengguna yang mendaftar mandiri berstatus <code>pending</code>, diproteksi dari login hingga disetujui, tombol persetujuan admin dengan assignment otomatis Spatie Role <code>user</code>.</li>
                                    <li><strong class="text-dark">Penonaktifan Mandiri &amp; Aktivasi Kembali Akun (Account Lifecycle):</strong> Zona bahaya penonaktifan akun pada profil pengguna, halaman pengajuan aktivasi akun nonaktif (<code>/request-activation</code>), tombol aksi admin ("Nonaktifkan" &amp; "Aktifkan"), dan integrasi SweetAlert2.</li>
                                    <li><strong class="text-dark">Pusat Notifikasi Universal Topbar (Multi-Type Notification Hub):</strong> Mengagregasikan notifikasi pendaftaran, permintaan reset password, permohonan nonaktif, permohonan aktivasi, pesan chat, dan notifikasi database Laravel via <code>NotificationService</code> terpusat sesuai standar Inspinia.</li>
                                    <li><strong class="text-dark">Permintaan Reset Password (Admin-Assisted Reset):</strong> Form forgot password dengan validasi interaktif, pengajuan permintaan reset ke administrator, tombol reset pada tabel admin ke password standar (<code>password*</code>), dan banner sukses terverifikasi.</li>
                                    <li><strong class="text-dark">Dinamisasi Branding Otentikasi &amp; Lokalisasi Bahasa Indonesia:</strong> Logo, favicon, meta title, dan teks footer form otentikasi terhubung 100% dinamis ke tabel <code>profil_aplikasi</code>, serta seluruh teks di-standarisasi ke Bahasa Indonesia.</li>
                                    <li><strong class="text-dark">Dokumentasi Resmi Alur Otentikasi:</strong> Panduan lengkap di <code>docs/arsitektur_dan_operasional_authentication_user.md</code>.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v2.0.0</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 14:35 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Engine Dinamisasi Tema &amp; Seksi Website Terpusat, Crop Simulator &amp; Arsitektur Partial Modular</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Arsitektur Tema &amp; Seksi Dinamis Terpusat:</strong> Membuat tabel database <code>website_themes</code> dan <code>website_sections</code> yang mengatur tema aktif, urutan seksi, gaya latar belakang, hingga background-image secara 100% dinamis tanpa hardcode view.</li>
                                    <li><strong class="text-dark">Interactive Crop Simulator &amp; Height Ratio:</strong> Modal pratinjau media interaktif (`#modal-preview-image`) yang dilengkapi 3 tombol simulasi tinggi seksi (<em>Pendek ~220px, Sedang ~380px, Tinggi ~550px</em>) dan range slider fokus vertikal (0-100%) dengan AJAX update tanpa reload.</li>
                                    <li><strong class="text-dark">Deteksi Otomatis Orientasi &amp; Efek Paralaks 3D:</strong> Membaca metadata dimensi gambar asli (<em>Landscape, Portrait, Square</em>), serta menambahkan opsi <code>background-size</code> (Cover/Contain), <code>background-attachment</code> (Paralaks 3D Fixed), dan soft dark backdrop blur overlay.</li>
                                    <li><strong class="text-dark">Pemisahan Partial Modal Modular (Rule 10):</strong> Memisahkan file modal menjadi 3 partial terorganisir: <code>konfigurasi_website_modal_form</code>, <code>konfigurasi_website_modal_petunjuk</code>, dan <code>konfigurasi_website_modal_tampilgambar</code>.</li>
                                    <li><strong class="text-dark">Dokumentasi Arsitektur Resmi:</strong> Dibuat panduan resmi pengembang di <code>docs/arsitektur_dinamisasi_tema_website.md</code>.</li>
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
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Build: v1.9.3</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 10:30 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Pemisahan Tabel Config User, Pengatur Posisi Sampul Interaktif, Motto Hidup &amp; Widget Progress Kelengkapan Profil</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Pemisahan Dokumen KTP &amp; Cover Header:</strong> Memisahkan tabel <code>foto_ktp</code> pada <code>user_details</code> untuk dokumen KTP fisik, dan membuat tabel baru <code>user_configs</code> (kolom <code>cover_image</code>, <code>cover_position_y</code>, <code>motto</code>) untuk konfigurasi akun.</li>
                                    <li><strong class="text-dark">Pengatur Posisi Vertikal Sampul Header:</strong> Fitur slider interaktif (0%-100%) dan tombol presisi (<em>Atas, Tengah, Bawah</em>) untuk mengatur posisi vertikal foto sampul header secara <em>real-time</em>.</li>
                                    <li><strong class="text-dark">Motto Hidup Real-time:</strong> Menambahkan kartu editor Motto Hidup dengan pratinjau ketik <em>real-time</em> di atas banner foto sampul.</li>
                                    <li><strong class="text-dark">Widget Status Kelengkapan Profil:</strong> Menambahkan widget <em>animated progress bar</em> kalkulasi kelengkapan data profil otomatis (0%-100%).</li>
                                    <li><strong class="text-dark">Toggle Password Eye Icons &amp; Rule 12:</strong> Menambahkan tombol pengintip kata sandi (kepatuhan Rule 2 &amp; Rule 7) serta menetapkan <strong>Rule 12</strong> standarisasi header widget <code>bg-primary text-white</code>.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 09:36 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Centralized Release Version Engine, Git Log Timestamps &amp; Mandatory Changelog Standard (Rule 11)</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Otomatisasi Versi Terpusat (Centralized Versioning Engine):</strong> Configured <code>config('app.version')</code> via <code>APP_VERSION</code> in <code>.env</code>. Bound Sidenav Changelog badge, Footer badge, and <code>ProfilAplikasi</code> model auto-sync to a single source of truth.</li>
                                    <li><strong class="text-dark">Waktu Presisi Rilis (Git Log Timestamps):</strong> Updated all release timeline dates to include exact commit hours and minutes (<code>HH:mm WIB</code>) fetched directly from <code>git log</code> history.</li>
                                    <li><strong class="text-dark">Standar Wajib Update Changelog (Rule 11):</strong> Documented Rule 11 in <code>.agents/AGENTS.md</code> enforcing mandatory updates to <code>changelog.blade.php</code> and <code>README.md</code> prior to git push / release.</li>
                                    <li><strong class="text-dark">Panduan Rilis Interaktif (Version Release Guide Card):</strong> Added interactive 4-step version release guide card with automatic Sidenav and Footer sync explanation.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 09:17 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Module View Hierarchy Standardization (Rule 10), Meta Title Engine &amp; Sidenav Search UI Refinements</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Standarisasi Hirarki View Modul (Rule 10):</strong> Refactored <code>translation/index.blade.php</code> into flat view <code>translation.blade.php</code> and extracted modal form to <code>partials/translation_form.blade.php</code>. Documented Rule 10 in <code>.agents/AGENTS.md</code>.</li>
                                    <li><strong class="text-dark">Penyempurnaan Engine Meta Title (<code>title-meta.blade.php</code>):</strong> Bound <code>&lt;title&gt;</code> app name dynamically to <code>ProfilAplikasi</code> model (<code>app_name</code>: <em>REPALOGIC Dashboard</em>) and removed <code>"index"</code> fallback for resource routes.</li>
                                    <li><strong class="text-dark">UI Sidenav Search Input Box (<code>sidenav.blade.php</code>):</strong> Balanced search icon position (<code>ms-2</code>), adjusted typing start padding (<code>28px</code>), and applied Bootstrap 5 standard <code>text-white</code> class for white typed text and muted placeholder text without custom CSS.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-27 08:04 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">100% Dynamic Bilingual Engine, Custom Menu Data-Lang &amp; Admin Translation Management Module</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Kolom Kustom <code>data_lang</code> pada Tabel &amp; Modal Menu:</strong> Added <code>data_lang</code> migration, Eloquent model attribute, validation rules, and input field on <code>menu.blade.php</code> allowing custom translation keys for database menus.</li>
                                    <li><strong class="text-dark">Modul Terjemahan Bahasa (<code>/admin/dukunganaplikasi/translation</code>):</strong> Built admin translation manager enabling live CRUD operations for <code>id.json</code> and <code>en.json</code> dictionary files without manual server file edits.</li>
                                    <li><strong class="text-dark">Pengelompokkan Sidebar Menu &amp; Component Labels:</strong> Grouped translation key table dynamically by Sidebar Categories (Database Menus &amp; Template Menus) with origin position badges (<code>Menu Utama</code>, <code>Sub-Menu</code>, <code>Group Header</code>, <code>Label Sistem</code>).</li>
                                    <li><strong class="text-dark">Modal Petunjuk Operasional Bilingual:</strong> Integrated interactive step-by-step guidance modal (<code>bilingual_guide_modal.blade.php</code>) accessible from both Menu Management and Translation pages.</li>
                                    <li><strong class="text-dark">Safe Fallback &amp; Standar Proyek (.agents/AGENTS.md):</strong> Preserved graceful name fallback for unmapped keys and enforced project standards (SweetAlert2 confirm, single-line centered headers, PSR-4 autoloading).</li>
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
                                        <span class="badge bg-info-subtle text-info fw-semibold fs-xs">Profile &amp; Identity</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: bbddc7b</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 16:47 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Profile Management &amp; KTP Identity Details</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Profil Pengguna (`profil-pengguna.blade.php`):</strong> Implemented comprehensive user profile interface displaying detailed KTP card identity (NIK, Nama Lengkap, Tempat/Tgl Lahir, Jenis Kelamin, Alamat, RT/RW, Kelurahan, Kecamatan, Agama, Status Perkawinan, Pekerjaan, Kewarganegaraan).</li>
                                    <li><strong class="text-dark">Avatar Image Renderer:</strong> Updated avatar image rendering to prefer custom uploaded avatars with fallback to default avatar asset (<code>$user-&gt;avatar_url</code>).</li>
                                    <li><strong class="text-dark">Role &amp; Direct Access Overview:</strong> Integrated user roles badge list and direct permissions summary into profile view tabs.</li>
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
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">App Features &amp; Backup</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: d3c1827 &amp; 57c2d7f</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 16:07 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Application Features Switcher, Database Backup/Restore &amp; App Branding Profile</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Halaman Fitur Aplikasi (`fitur-aplikasi.blade.php`):</strong> Added real-time feature switches (Topbar elements, Sidenav menu groups, Special Menu) backed by <code>FiturAplikasi</code> model settings.</li>
                                    <li><strong class="text-dark">Modul Backup DB &amp; Restore (`backup-db.blade.php`):</strong> Implemented one-click automated SQL database backups, file size tracking, file download handler, restore functionality, and selective table backup options.</li>
                                    <li><strong class="text-dark">Profil Aplikasi (`profil-aplikasi.blade.php`):</strong> Built application branding manager for dynamic logo upload (Logo Large, Logo Small, Favicon, Application Name, Tagline, Copyright text).</li>
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
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">User Management</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: 504d930 &amp; f12f6c2</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-02 09:31 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">User Management, Spatie Roles, Permissions Catalog &amp; Access Matrix Tables</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Manajemen User (`users.blade.php`):</strong> Built full user management CRUD interface with user avatar rendering, status toggling, and role assignment.</li>
                                    <li><strong class="text-dark">Manajemen Role (`role.blade.php`):</strong> Added role creation, editing, and deletion with permission count badges and role access forms.</li>
                                    <li><strong class="text-dark">Permission Matrix Table Standard (`akses_role.blade.php` &amp; `akses_user.blade.php`):</strong> Implemented Spatie permission matrix table layout (Columns: <code>MODUL / FITUR</code>, <code>CREATE</code>, <code>READ</code>, <code>UPDATE</code>, <code>DELETE</code>, <code>LAINNYA</code>, <code>SEMUA</code>) with high-contrast checkboxes and per-row <code>SEMUA</code> check/uncheck toggles.</li>
                                    <li><strong class="text-dark">Katalog Permission (`permission.blade.php`):</strong> Implemented direct permissions catalog view grouped by application features with CRUD action badges.</li>
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
                                        <span class="badge bg-primary-subtle text-primary fw-semibold fs-xs">Dynamic Menu Engine</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit: 876177d &amp; 02ddb3a</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 15:54 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Database-Driven Dynamic Menu Engine &amp; 3-Level Menu Hierarchy</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Database Menu Engine (`menu.blade.php`):</strong> Converted static sidebar menus to database-driven <code>Menu</code> Eloquent models with full management CRUD.</li>
                                    <li><strong class="text-dark">Dukungan Menu 3 Level:</strong> Enabled 3-level nested sub-menu hierarchy (Menu Utama L1, Sub-Menu L2, Sub-Sub-Menu L3) with recursive collapse rendering, order sorting, and URL path resolution (<code>getRealUrl()</code>).</li>
                                    <li><strong class="text-dark">Kolom URL &amp; Status Centered:</strong> Added URL column after Menu Name displaying resolved URL endpoints, and centered status switch toggles across all 3 levels.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 13:07 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Bilingual Internationalization Engine (ID &amp; EN),
                                    Topbar &amp; Customizer i18n</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Bilingual Language Scope (ID &amp; EN):</strong>
                                        Standardized language selection exclusively to Indonesian (<code>id</code>) and
                                        English (<code>en</code>), removing unused legacy locale files (<code>ar</code>,
                                        <code>de</code>, <code>es</code>, <code>hi</code>, <code>it</code>,
                                        <code>ru</code>). Added <code>id.json</code> matching complete translation
                                        dictionary.</li>
                                    <li><strong class="text-dark">Extended I18nManager Engine:</strong> Enhanced
                                        <code>I18nManager</code> in <code>app.js</code> with absolute translation path
                                        resolution (<code>/assets/data/translations/</code>), cache-busting query strings,
                                        dynamic document <code>&lt;title&gt;</code> updating, and support for
                                        <code>data-lang-placeholder</code>, <code>data-lang-title</code>, and
                                        <code>data-lang-alt</code>.</li>
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
                                        across variable-length translations.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 01:17 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Tabler & Lucide Full Icon Explorers & Recursive
                                    Sidenav Active Route Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tabler Icons Explorer (6,019 Icons):</strong> Implemented
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-08-01 00:41 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Documentation Module & Interactive Tree Engine</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Tambah Menu Documentation:</strong> Integrated dynamic
                                        `config/sidenav-template/documentation.php` schema for all documentation pages.</li>
                                    <li><strong class="text-dark">Persiapan & Refactor Dokumentasi:</strong> Refactored 10
                                        Documentation Blade templates (`introduction`, `getting-started`,
                                        `folder-structure`, `layouts`, `sidebar`, `topbar`, `theme-skin-setup`, `dark-mode`,
                                        `sources`, `changelog`) to
                                        <code>{{ '@' }}extends('layouts.vertical')</code>.</li>
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
                                        <span class="badge bg-warning-subtle text-warning fw-semibold fs-xs">Layout & Custom
                                            Refactor</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            3a391e2 & 5858a50</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 23:17 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Layout Group Demo & Custom Pages Refactoring</h6>
                                <ul class="text-muted fs-14 mb-3 ps-3">
                                    <li><strong class="text-dark">Refactor Template Layouts (18 Views):</strong> Converted
                                        all demo views under `template/layouts/` to
                                        <code>{{ '@' }}extends('layouts.vertical')</code> or
                                        <code>{{ '@' }}extends('layouts.horizontal')</code>.</li>
                                    <li><strong class="text-dark">Preservation of Layout Attributes:</strong> Passed
                                        layout-specific HTML attributes (`data-layout-width="boxed"`,
                                        `data-sidenav-size="compact"`, `data-topbar-color="dark"`,
                                        `class="sidebar-with-line"`) via
                                        <code>{{ '@' }}section('html_attribute')</code>.</li>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 22:51 WIB</span>
                                </div>
                                <h6 class="fw-semibold text-dark mb-2">Sidenav Auto-Scroll Centering & Component Menu Group
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
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Dynamic Routes
                                            & Titles</span>
                                        <span class="badge bg-secondary-subtle text-dark font-monospace fs-xs">Commit:
                                            8bea610 & b6d118e</span>
                                    </div>
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 22:46 WIB</span>
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
                                    <span class="text-muted fs-13"><i class="ti ti-clock me-1"></i> 2026-07-31 10:08 WIB</span>
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
