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
                                <i class="ti ti-git-commit me-1"></i> Current Build: <strong>v2.1.1</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Release Procedure Guide Card -->
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
                                    Cukup ubah <code>APP_VERSION=vX.Y.Z</code> pada file <code>.env</code> / <code>config/app.php</code>. Versi pada <strong>Sidenav, Footer, &amp; DB Profil Aplikasi</strong> akan ter-update secara otomatis!
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-success rounded-circle p-1.5 me-2"><i class="ti ti-file-text fs-14"></i></span>
                                    <h6 class="fw-bold mb-0 text-dark">2. Catat Log Changelog</h6>
                                </div>
                                <p class="fs-13 text-muted mb-0">
                                    Buka <code>changelog.blade.php</code> dan tambahkan blok timeline versi rilis terbaru dengan mencantumkan timestamp (YYYY-MM-DD HH:mm WIB).
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-warning rounded-circle p-1.5 me-2"><i class="ti ti-brand-git fs-14"></i></span>
                                    <h6 class="fw-bold mb-0 text-dark">3. Catat di README.md</h6>
                                </div>
                                <p class="fs-13 text-muted mb-0">
                                    Tambahkan baris riwayat versi rilis pada tabel <em>Riwayat Release / Tag</em> di file <code>README.md</code>.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="p-3 border rounded-3 bg-light-subtle h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-danger rounded-circle p-1.5 me-2"><i class="ti ti-tag fs-14"></i></span>
                                    <h6 class="fw-bold mb-0 text-dark">4. Git Tag &amp; Push</h6>
                                </div>
                                <p class="fs-13 text-muted mb-0">
                                    Buat tag git: <code>git tag -a vX.Y.Z -m "Pesan rilis..."</code> lalu push ke remote repository: <code>git push origin main --tags</code>.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="alert alert-info border-0 mb-0 py-2.5 px-3 fs-13 d-flex align-items-center">
                                <i class="ti ti-info-circle fs-18 me-2 flex-shrink-0"></i>
                                <div>
                                    <strong>Catatan Otomatisasi Terintegrasi:</strong> Anda <em>TIDAK PERLU</em> mengubah hardcoded version pada Sidenav template, view Footer, maupun migrasi DB secara manual karena seluruh engine telah terpusat dan sinkron otomatis.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Release Timeline -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-history me-2 text-primary"></i>Git Commit Release
                        Timeline</h5>
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1">18 Versions Logged</span>
                </div>
                <div class="card-body p-4">
                    <div class="timeline timeline-icon-bordered">

                        <!-- Version 2.1.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-star-filled fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold mb-0">v2.1.1</h5>
                                        <span class="badge bg-success-subtle text-success fw-semibold fs-xs">Latest Release</span>
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
                            <div class="timeline-content ps-3.5 w-100">
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
                                    <li><strong class="text-dark">Dokumentasi Resmi Alur Otentikasi:</strong> Panduan lengkap di <code>docs/alur_registrasi_dan_persetujuan_pengguna.md</code> dan <code>docs/alur_penonaktifan_dan_aktivasi_akun_pengguna.md</code>.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Version 2.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                            <div class="timeline-content ps-3.5 w-100">
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
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.9.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.9.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-check fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.2 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-user-check fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.1 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-database fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.8.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-users fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.7.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-sitemap fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.6.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-language fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.5.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.4.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-history fs-xl text-primary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.3.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-layout-board fs-xl text-warning"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.2.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-arrows-vertical fs-xl text-info"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.1.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-route fs-xl text-success"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
                                <hr class="border-dashed my-3" />
                            </div>
                        </div>

                        <!-- Version 1.0.0 -->
                        <div class="timeline-item d-flex align-items-stretch">
                            <div class="timeline-dot">
                                <i class="ti ti-circle-check-filled fs-xl text-secondary"></i>
                            </div>
                            <div class="timeline-content ps-3.5 w-100">
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
