# 🏷️ Riwayat Release & Git Tag (Release History)

> **Lokasi File:** `docs/riwayat_release_dan_tag.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Versi Terbaru:** `v3.0.7`  
> **Terakhir Diperbarui:** 30 September 2026 14:52 WIB

---

## 📋 Tabel Riwayat Versi & Tag

Dokumentasi lengkap mengenai setiap versi rilis, git tag, waktu rilis presisi (WIB), dan ringkasan perubahan pada proyek **REPALOGIC Dashboard**.

<table width="100%">
  <thead>
    <tr>
      <th width="5%" align="center">No</th>
      <th width="12%" align="center">Tag / Versi</th>
      <th width="20%" align="center">Waktu & Tanggal Rilis (WIB)</th>
      <th width="63%" align="left">Deskripsi / Catatan Perubahan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center">1</td>
      <td align="center"><strong><code>v3.0.7</code></strong></td>
      <td align="center"><code>2026-09-30 14:52 WIB</code></td>
      <td>Integrasi Hub Riwayat Interaksi Terpadu (Unified Activity History), Media Audit Trail Engine, Scoped User History &amp; Direct Chat Action pada Direktori Dashboard (Tombol <code>Semua Riwayat</code> 1-Klik Terintegrasi dengan Sub-filter Kategori &amp; Live Search; Scoping Khusus Pengguna Login; Model &amp; Tabel <code>user_media_histories</code> untuk Audit Perubahan Foto Profil/Sampul; Aksi Direct Chat Cerdas &amp; Penyelarasan Tinggi Tombol Toolbar Direktori)</td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td align="center"><strong><code>v3.0.6</code></strong></td>
      <td align="center"><code>2026-09-30 13:30 WIB</code></td>
      <td>Overhaul Desain Header Profil Pengguna, Curated Life Mottos Engine (20 Motto Inspiratif &amp; Tombol Acak Motto), Dynamic Cover Overlay Kontak Dashboard (Warna, Opasitas, Efek Blur &amp; Polling Realtime), User Form Modal Header Preview &amp; Standardisasi Default Avatar ke <code>user-default.jpg</code></td>
    </tr>
    <tr>
      <td align="center">2</td>
      <td align="center"><strong><code>v3.0.5</code></strong></td>
      <td align="center"><code>2026-09-30 09:25 WIB</code></td>
      <td>Otomatisasi &amp; Dinamisasi Penuh Sistem Bilingual (i18n) Admin Menu &amp; Title Meta (Integrasi Tanpa Hardcode Berdasarkan Tabel Database <code>menus</code>, Sinkronisasi Otomatis Seeder &amp; GUI Menu ke Kamus JSON, Eliminasi Kedipan SessionStorage Translation Cache via Versioning v4 &amp; Auto Purge, Penyelarasan Penuh Antara Sidebar, Breadcrumb <code>page-title.blade.php</code>, dan Tab Browser <code>&lt;title&gt;</code> pada <code>title-meta.blade.php</code>)</td>
    </tr>
    <tr>
      <td align="center">3</td>
      <td align="center"><strong><code>v3.0.4</code></strong></td>
      <td align="center"><code>2026-09-30 08:02 WIB</code></td>
      <td>Integrasi Langsung Full Icons Grid pada Halaman Komponen Tabler (<code>tabler.blade.php</code>) &amp; Lucide (<code>lucide.blade.php</code>), Menampilkan Seluruh 5.000+ Ikon dengan Toolbar Pencarian Real-Time, Slider Ukuran, Color Picker, Reset, Snippet Board, dan Click-to-Copy Tanpa Menghapus Seksi Contoh (Usage, Colors, Sizes), Penghapusan Total Berkas Lama (<code>tabler-full.blade.php</code>, <code>tabler-full-icon.blade.php</code>, <code>lucide-full.blade.php</code>) &amp; Modularisasi Sub-Partials</td>
    </tr>
    <tr>
      <td align="center">4</td>
      <td align="center"><strong><code>v3.0.3</code></strong></td>
      <td align="center"><code>2026-09-30 07:54 WIB</code></td>
      <td>Penyatuan Seluruh Kelompok Menu Sidebar Template Menjadi 1 Sakelar Kontrol Terpadu (<code>menu_group_template</code> pada <code>FiturAplikasiSeeder.php</code>, <code>sidenav.blade.php</code>, dan <code>fitur-aplikasi.blade.php</code>), Pembersihan Record Database Lama (<code>menu_group_main</code>, <code>menu_group_apps</code>, <code>menu_group_custom_pages</code>, <code>menu_group_layouts</code>, <code>menu_group_components</code>, <code>menu_group_documentation</code>, <code>menu_group_menu_item</code>) Menjadi 12 Fitur Terpadu</td>
    </tr>
    <tr>
      <td align="center">5</td>
      <td align="center"><strong><code>v3.0.2</code></strong></td>
      <td align="center"><code>2026-09-30 07:45 WIB</code></td>
      <td>Pembersihan Database Fitur Special Menu (Dikeluarkan dari <code>app_features</code> dan <code>FiturAplikasiSeeder.php</code>, Tampil Permanen di Bagian Bawah Sidebar Serta Bebas Diakses Semua Role Pengguna), Pembatasan Otorisasi Akses Admin Customizer / Theme Settings di Topbar Header &amp; Offcanvas Panel (Hanya Role <code>superadmin</code> &amp; <code>admin</code> yang Dapat Melihat dan Mengakses), Pembersihan Selektor Realtime JS <code>menu_special_menu</code> di <code>fitur-aplikasi.js</code></td>
    </tr>
    <tr>
      <td align="center">6</td>
      <td align="center"><strong><code>v3.0.1</code></strong></td>
      <td align="center"><code>2026-09-29 23:40 WIB</code></td>
      <td>Universal Auth Submit Button Loading Engine (Spinner pada Login, Register, Lupa Password, Reset, Verifikasi, dll), Dukungan Aplikasi Mobile Responsive Overhaul across Menu, Profil Aplikasi, Fitur Aplikasi (Quick Intro Banner 4-Baris Terpusat, 6 Widget Setting Gap Rapih, Tab Icon-Only, Filter &amp; Bulk Actions Full-Width), Backup Database (DROP &amp; CREATE DATABASE Switch Toggle Terpusat di Atas, Form Footer Ekspor Full-Width &amp; Riwayat Header), Dashboard Hero Avatar Rounded Square (<code>rounded-3</code>, 105x105px) Matching Greeting-to-Motto Height, Strict CSS Media Query Isolation Standard (<code>@media (max-width: 767.98px)</code>) &amp; Refinement Project Rule 19</td>
    </tr>
    <tr>
      <td align="center">7</td>
      <td align="center"><strong><code>v3.0.0</code></strong></td>
      <td align="center"><code>2026-09-29 12:38 WIB</code></td>
      <td>Mobile Responsive Experience Overhaul across User Management &amp; Data Login (<code>admin/manajemenpengguna/data-login</code> &amp; <code>admin/manajemenpengguna/users</code>), Application Timezone Standardization (<code>APP_TIMEZONE=Asia/Jakarta</code>), Avatar Upload Multi-Row Sequence &amp; 2-Column Desktop Grid in User Form Modal, Centered Multi-Line Card Header &amp; Full-Width Modal Buttons, Architectural Rules Expansion (<code>.agents/AGENTS.md</code> Rules 18-22)</td>
    </tr>
    <tr>
      <td align="center">8</td>
      <td align="center"><strong><code>v2.9.9</code></strong></td>
      <td align="center"><code>2026-09-29 07:41 WIB</code></td>
      <td>Storage Symlink 1-Click Auto-Repair Engine &amp; Auto-Healing on Media Scan in Pengaturan Sistem (<code>admin/dukunganaplikasi/fitur-aplikasi</code>), Dynamic Maintenance Mode (<code>503.blade.php</code>) &amp; Sesi Kedaluwarsa (<code>419.blade.php</code>) Copyright from Profil Aplikasi, Clean URL &amp; Hashtag-Free Tab Navigation Standard (<code>.agents/AGENTS.md</code> Rule 17)</td>
    </tr>
    <tr>
      <td align="center">9</td>
      <td align="center"><strong><code>v2.9.8</code></strong></td>
      <td align="center"><code>2026-09-28 15:23 WIB</code></td>
      <td>Default Modern Theme Skin Standard, Sidenav Alignment Fix &amp; Session Auto-Migration Engine (<code>_v: 3</code>, Default skin <code>modern</code> di <code>head-css.blade.php</code>, <code>config.js</code>, <code>app.js</code>, <code>horizontal.blade.php</code>, <code>vertical.blade.php</code>, <code>AppSettingSeeder.php</code>, Sub-menu padding-inline fix pada <code>sidebar-with-line</code>, Standardisasi dot notation include Blade <code>layouts.partials.*</code>)</td>
    </tr>
    <tr>
      <td align="center">10</td>
      <td align="center"><strong><code>v2.9.7</code></strong></td>
      <td align="center"><code>2026-09-26 23:25 WIB</code></td>
      <td>Penyempurnaan Meta Title Bersih &amp; Integrasi Sistem Bilingual (i18n) Tema Education Portal (Format Judul Bersih <code>[Halaman] - Education</code>, Dynamic Language Switcher ID/EN <code>_header.blade.php</code>, Modular Translation Dictionaries <code>frontpage.json</code>, Dedicated <code>education-i18n.js</code> Engine &amp; Anti-Flicker Pre-Hydration)</td>
    </tr>
    <tr>
      <td align="center">11</td>
      <td align="center"><strong><code>v2.9.6</code></strong></td>
      <td align="center"><code>2026-09-26 21:50 WIB</code></td>
      <td>Standardisasi Route Helper Laravel Portal Education, Dedicated EducationController, Arsitektur Tema Multi-Page vs One-Page &amp; Manajemen Konfigurasi Website Dinamis (Pembersihan URL <code>page-*.blade.php</code>, Canonical Named Routes <code>education.*</code>, Direct Route Access &amp; Smart Redirect Handler)</td>
    </tr>
    <tr>
      <td align="center">12</td>
      <td align="center"><strong><code>v2.9.5</code></strong></td>
      <td align="center"><code>2026-09-26 00:15 WIB</code></td>
      <td>Default Website Landing Theme Font Assets Restoration: Penyalinan dan perbaikan font Tabler Icons (<code>tabler-icons.woff2</code>, <code>tabler-icons.woff</code>, <code>tabler-icons.ttf</code>) ke direktori <code>public/assets_default/css/fonts/</code> dan <code>public/assets_default/fonts/</code> untuk memastikan seluruh icon pada landing page default tampil sempurna</td>
    </tr>
    <tr>
      <td align="center">13</td>
      <td align="center"><strong><code>v2.9.4</code></strong></td>
      <td align="center"><code>2026-09-25 23:45 WIB</code></td>
      <td>Dynamic Multi-Theme Engine &amp; Website Sections: Integrasi Tema Unify Education Portal (13 Seksi &amp; Halaman Multipage Modular Blade), Dynamic Auth Login (<code>page-signin-1.blade.php</code>), Standardisasi Auth Menu Header (<code>@auth</code>/<code>@guest</code>), Pemisahan Aset Publik Terisolasi (<code>assets_default</code> &amp; <code>asset_education</code>) &amp; Dynamic Multipage Route Handler di <code>routes/web.php</code></td>
    </tr>
    <tr>
      <td align="center">14</td>
      <td align="center"><strong><code>v2.9.3</code></strong></td>
      <td align="center"><code>2026-09-25 21:32 WIB</code></td>
      <td>Interactive Avatar Cropper Suite (Cropper.js 1.6.2, Zoom, 4-Way Pan, Rotate 90°, Flip, Live Circular Preview, 1:1 Pixel-Perfect 400x400 Cropped Avatar, Master Uncropped Photo Memory for Seamless Re-Cropping / Edit Posisi), Deterministic Randomized Default Cover Photos Engine (<code>User::getDefaultCoverUrl</code>, 10 Stock Covers) &amp; Indonesian Names/Matching Emails in <code>UserFactory</code> (<code>fake('id_ID')</code>)</td>
    </tr>
    <tr>
      <td align="center">15</td>
      <td align="center"><strong><code>v2.9.2</code></strong></td>
      <td align="center"><code>2026-09-25 14:45 WIB</code></td>
      <td>Responsive Page Title &amp; Breadcrumb 2-Row Mobile Layout (<code>page-title.blade.php</code>, <code>flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-1 gap-sm-2</code> &amp; <code>text-start text-sm-end</code>)</td>
    </tr>
    <tr>
      <td align="center">16</td>
      <td align="center"><strong><code>v2.9.1</code></strong></td>
      <td align="center"><code>2026-09-14 23:20 WIB</code></td>
      <td>Translation Management Overhaul (File Manager Outlook-Box Split-Panel Layout, Dynamic Vertical Domain Tabs, Dedicated Internal Table Scroll Container, Sticky Table Header &amp; Zero Browser Scroll)</td>
    </tr>
    <tr>
      <td align="center">17</td>
      <td align="center"><strong><code>v2.9.0</code></strong></td>
      <td align="center"><code>2026-09-13 21:40 WIB</code></td>
      <td>Topbar Sidenav Mobile-Only Toggle Button (<code>d-flex d-lg-none</code>), Default Expanded Sidebar on Desktop, Standardized Card Header Action Buttons (2-Column Layout, Far-Right Alignment &amp; Responsive Mobile Icon-Only with Hover Title - Rule 16)</td>
    </tr>
    <tr>
      <td align="center">18</td>
      <td align="center"><strong><code>v2.8.9</code></strong></td>
      <td align="center"><code>2026-09-13 17:53 WIB</code></td>
      <td>Default Sidenav Color Gradient (<code>&lt;html data-menu-color="gradient"&gt;</code>, <code>head-css.blade.php</code>, <code>config.js</code>, <code>app.js</code>) &amp; Dynamic Session Storage Auto-Migration Engine (<code>_v: 2</code>)</td>
    </tr>
    <tr>
      <td align="center">19</td>
      <td align="center"><strong><code>v2.8.8</code></strong></td>
      <td align="center"><code>2026-09-05 11:32 WIB</code></td>
      <td>GUI Blade Script Live Code Editor Modal (Ace Editor PHP/HTML/Blade Syntax, Monokai Dark / Chrome Light Theme, Fullscreen Mode, Word Wrap, Backup Otomatis &amp; Auto View Cache Clear), Quick Snippets Injection Suite &amp; File Trigger Action in Konfigurasi Website</td>
    </tr>
    <tr>
      <td align="center">20</td>
      <td align="center"><strong><code>v2.8.7</code></strong></td>
      <td align="center"><code>2026-09-05 11:21 WIB</code></td>
      <td>Chat Message Edit Engine (Batas 10 Menit &amp; Penanda Edited), Interactive Edit Preview Bar, Real-Time In-Place Polling Sync, Dashboard Quick Access Hub (12 Sub-Menu), Fitur Aplikasi Compact Reset Button, Motto Color 2-Row Alignment, Translation Clean URL (Tanpa <code>?module=</code>) &amp; Equal-Height Active Nav Pills</td>
    </tr>
    <tr>
      <td align="center">21</td>
      <td align="center"><strong><code>v2.8.6</code></strong></td>
      <td align="center"><code>2026-09-04 14:15 WIB</code></td>
      <td>Storage Media Synchronization &amp; Orphan Cleaner Engine, High-Resolution Image Lightbox Simulator &amp; Single / Bulk Orphan Media Purging in Fitur Aplikasi</td>
    </tr>
    <tr>
      <td align="center">22</td>
      <td align="center"><strong><code>v2.8.5</code></strong></td>
      <td align="center"><code>2026-09-04 13:48 WIB</code></td>
      <td>Idle Lock Screen Seamless Re-Authentication, Global Dynamic CSRF Token Sync, Zero-419 Graceful Handler, Universal Logout Session Invalidation &amp; Custom 419 Error Template</td>
    </tr>
    <tr>
      <td align="center">23</td>
      <td align="center"><strong><code>v2.8.4</code></strong></td>
      <td align="center"><code>2026-09-04 11:35 WIB</code></td>
      <td>Card with Tabs System Control Center, Persistent Database Settings (<code>app_settings</code>), Topbar Realtime Instant DOM Toggle, Zero-Reload Bulk Actions, Active Tab Persistence &amp; Factory Reset to Seeder</td>
    </tr>
    <tr>
      <td align="center">24</td>
      <td align="center"><strong><code>v2.8.3</code></strong></td>
      <td align="center"><code>2026-09-04 09:22 WIB</code></td>
      <td>Modern 3-Dots Action Dropdown Menu in Chat Bubble (Balas, Teruskan, Pin &amp; Hapus), Streamlined Message Timestamp Footer, Inline Clean Reactions Beside Reaction Buttons &amp; Real-Time In-Place Polling Sync</td>
    </tr>
    <tr>
      <td align="center">25</td>
      <td align="center"><strong><code>v2.8.2</code></strong></td>
      <td align="center"><code>2026-09-04 09:12 WIB</code></td>
      <td>Admin Customizer Optimize Clear Engine (<code>php artisan optimize:clear</code> AJAX) &amp; Reset Layout Restoration, Topbar Language Switcher Anti-Flicker, User Profile Motto Text Color Customizer &amp; Real-Time Live Visual Cover Background Preview Sync</td>
    </tr>
    <tr>
      <td align="center">26</td>
      <td align="center"><strong><code>v2.8.1</code></strong></td>
      <td align="center"><code>2026-09-01 22:05 WIB</code></td>
      <td>Modular Translation Dictionaries Architecture (6 Isolated Domains: Sidebar Template, Sidebar Menu, Topbar, Auth, Customizer, Frontpage), Parallel i18n Loader Engine (<code>Promise.all</code>), Tab-Based Translation Manager &amp; Auto-Sync Model Hooks</td>
    </tr>
    <tr>
      <td align="center">27</td>
      <td align="center"><strong><code>v2.8.0</code></strong></td>
      <td align="center"><code>2026-09-01 21:30 WIB</code></td>
      <td>Comprehensive Technical Architecture Documentation Suite (Manajemen Menu, Pertemanan-Notifikasi-Chat Triad, Manajemen Pengguna 6-Pilar, Sistem Bilingual i18n) &amp; Standardisasi GitHub-Relative Markdown Links</td>
    </tr>
    <tr>
      <td align="center">28</td>
      <td align="center"><strong><code>v2.7.6</code></strong></td>
      <td align="center"><code>2026-09-01 17:40 WIB</code></td>
      <td>Overhaul Tata Letak &amp; Form Edit Langsung Profil Pengguna (Single-Page Profile Architecture), Restrukturisasi Tabel KTP 2-Kolom, Perapihan Card Penonaktifan Akun &amp; Perbaikan Inisialisasi Script Cover Header</td>
    </tr>
    <tr>
      <td align="center">29</td>
      <td align="center"><strong><code>v2.7.5</code></strong></td>
      <td align="center"><code>2026-09-01 16:55 WIB</code></td>
      <td>Real-Time Friendship &amp; Profile Synchronization Engine, Interactive Notification Search Auto-Fill, Contextual Filter Transitions &amp; Prioritized Contact Directory Hierarchy</td>
    </tr>
    <tr>
      <td align="center">30</td>
      <td align="center"><strong><code>v2.7.4</code></strong></td>
      <td align="center"><code>2026-09-01 14:18 WIB</code></td>
      <td>Comprehensive Friendship Network System, Profile Likes Engine, Interactive Friend Requests &amp; Dashboard Directory Filter Tabs</td>
    </tr>
    <tr>
      <td align="center">31</td>
      <td align="center"><strong><code>v2.7.3</code></strong></td>
      <td align="center"><code>2026-09-01 13:55 WIB</code></td>
      <td>WhatsApp &amp; Phone Number Field Extension in User Details, Cover Banner Motto Floating Overlay &amp; Dashboard Contacts Sync</td>
    </tr>
    <tr>
      <td align="center">32</td>
      <td align="center"><strong><code>v2.7.2</code></strong></td>
      <td align="center"><code>2026-09-01 13:48 WIB</code></td>
      <td>Dynamic User Directory &amp; Contacts Hub, Incremental 12-Card Load More Engine with Down Arrow Animation &amp; Messages Detail Cover Photo Sync</td>
    </tr>
    <tr>
      <td align="center">33</td>
      <td align="center"><strong><code>v2.7.1</code></strong></td>
      <td align="center"><code>2026-09-01 13:00 WIB</code></td>
      <td>User Profile Cover Custom Overlay Engine: Dynamic Color Picker &amp; Theme Swatches, Adjustable Overlay Opacity ($0\% - 100\%$), Layer Blur Intensity Slider ($0\text{px} - 20\text{px}$) &amp; Real-Time Live WYSIWYG Integration</td>
    </tr>
    <tr>
      <td align="center">34</td>
      <td align="center"><strong><code>v2.7.0</code></strong></td>
      <td align="center"><code>2026-09-01 11:36 WIB</code></td>
      <td>Dynamic Data-Driven &amp; Role-Based Dashboard Engine, User-Configured Cover Banner &amp; Height Sync, Precision WIB Greeting Engine, Deduplicated Chat Preview Card Suite &amp; Symmetrical Rhythm Architecture</td>
    </tr>
    <tr>
      <td align="center">35</td>
      <td align="center"><strong><code>v2.6.0</code></strong></td>
      <td align="center"><code>2026-09-01 10:45 WIB</code></td>
      <td>Bulk &amp; Quick Role Assignment Engine, Live Role &amp; Status Table Filtering, Zero-Trust Session Invalidation on Account Deactivation &amp; Deduplicated Rejection Notification Architecture</td>
    </tr>
    <tr>
      <td align="center">36</td>
      <td align="center"><strong><code>v2.5.3</code></strong></td>
      <td align="center"><code>2026-09-01 09:35 WIB</code></td>
      <td>Universal Checkbox &amp; Radio Button Design System (Spatie Matrix Table Alignment), Calibrated Toggle Switch Spacing Standard (<code>custom-datatables.css</code>), Universal Icon/Dot Spacing Utilities &amp; Ad-Hoc Margin Cleanup Across All Admin Pages</td>
    </tr>
    <tr>
      <td align="center">37</td>
      <td align="center"><strong><code>v2.5.2</code></strong></td>
      <td align="center"><code>2026-09-01 08:30 WIB</code></td>
      <td>Complete Architecture Separation of Modular External CSS &amp; JS Assets Across All Admin Pages (Rule 15), Global Custom Auth &amp; DataTables Styling, Unused Raw Asset Cleanup &amp; High-Contrast Red Notification Badge Glow</td>
    </tr>
    <tr>
      <td align="center">38</td>
      <td align="center"><strong><code>v2.5.1</code></strong></td>
      <td align="center"><code>2026-09-01 02:42 WIB</code></td>
      <td>Unified Spatie Permission Matrix Table Hierarchy, Real-Time Parent-Child Auto Check/Uncheck Sync Engine &amp; Smart Direct Permission Deduplication Filter</td>
    </tr>
    <tr>
      <td align="center">39</td>
      <td align="center"><strong><code>v2.5.0</code></strong></td>
      <td align="center"><code>2026-09-01 00:05 WIB</code></td>
      <td>Interactive Today Logins Widget Card Suite &amp; Dual View Switcher, Chat Header Online Indicator Clean-up &amp; Architecture Rule 14 (Icon &amp; Label Spacing Standard)</td>
    </tr>
    <tr>
      <td align="center">40</td>
      <td align="center"><strong><code>v2.4.9</code></strong></td>
      <td align="center"><code>2026-08-31 22:05 WIB</code></td>
      <td>Auth Security Rate Limiting Integration, Unified Form Error Aesthetics &amp; Meta Title Internationalization Sanitization</td>
    </tr>
    <tr>
      <td align="center">41</td>
      <td align="center"><strong><code>v2.4.8</code></strong></td>
      <td align="center"><code>2026-08-31 19:12 WIB</code></td>
      <td>Application Settings Hub &amp; Maintenance Mode Engine: 6 Interactive Control Widgets, Dynamic Idle Lock Screen, 503 Maintenance Page, Global Middleware Protection &amp; User KTP Photo Preview Modal</td>
    </tr>
    <tr>
      <td align="center">42</td>
      <td align="center"><strong><code>v2.4.7</code></strong></td>
      <td align="center"><code>2026-08-31 17:18 WIB</code></td>
      <td>User Profile Cover Height Customization Engine: Real-Time Proportional Slider, Inline Presets &amp; Synchronized Aspect Ratio WYSIWYG</td>
    </tr>
    <tr>
      <td align="center">43</td>
      <td align="center"><strong><code>v2.4.6</code></strong></td>
      <td align="center"><code>2026-08-31 17:00 WIB</code></td>
      <td>Interactive Chat Enhancements Suite: In-Chat Search, Pinned Messages, Emoji Reactions, Message Forwarding &amp; Voice Note Audio Engine</td>
    </tr>
    <tr>
      <td align="center">44</td>
      <td align="center"><strong><code>v2.4.5</code></strong></td>
      <td align="center"><code>2026-08-31 16:36 WIB</code></td>
      <td>Clear Conversation History Engine (Keep Opponent Chat Intact) &amp; Dual deleted_for_sender/receiver Flags</td>
    </tr>
    <tr>
      <td align="center">45</td>
      <td align="center"><strong><code>v2.4.4</code></strong></td>
      <td align="center"><code>2026-08-31 16:30 WIB</code></td>
      <td>Dual-Mode Chat Message Deletion Engine (Unsend for Everyone &amp; Delete for Me) &amp; Real-Time Sync</td>
    </tr>
    <tr>
      <td align="center">46</td>
      <td align="center"><strong><code>v2.4.3</code></strong></td>
      <td align="center"><code>2026-08-31 16:22 WIB</code></td>
      <td>Instant Empty History Placeholder Disappearance on First Chat Send &amp; Unified Placeholder Engine</td>
    </tr>
    <tr>
      <td align="center">47</td>
      <td align="center"><strong><code>v2.4.2</code></strong></td>
      <td align="center"><code>2026-08-31 16:15 WIB</code></td>
      <td>Zero-Latency Optimistic UI Message Sending &amp; Instant Seamless Contact Switch Engine</td>
    </tr>
    <tr>
      <td align="center">48</td>
      <td align="center"><strong><code>v2.4.1</code></strong></td>
      <td align="center"><code>2026-08-31 16:05 WIB</code></td>
      <td>Chat Contact Avatar Spacing Optimization, Standard Framed Lightbox Modal Image Preview &amp; Interactive Reply Quote Jump Navigation</td>
    </tr>
    <tr>
      <td align="center">49</td>
      <td align="center"><strong><code>v2.4.0</code></strong></td>
      <td align="center"><code>2026-08-31 15:30 WIB</code></td>
      <td>User Impersonation Engine (Switch Akun), Floating Sticky Impersonation Alert Banner &amp; Quick Switch-Back Action Hub</td>
    </tr>
    <tr>
      <td align="center">50</td>
      <td align="center"><strong><code>v2.3.5</code></strong></td>
      <td align="center"><code>2026-08-28 16:40 WIB</code></td>
      <td>Direct Chat Image &amp; File Attachment Upload, Pre-Upload Live File Preview Bar, Image Lightbox Modal &amp; Real-Time Avatar Synchronization</td>
    </tr>
    <tr>
      <td align="center">51</td>
      <td align="center"><strong><code>v2.3.4</code></strong></td>
      <td align="center"><code>2026-08-28 16:11 WIB</code></td>
      <td>Real-Time Sidebar Contacts Sync Engine, Auto Unread Badges Counter, Background Contact Polling &amp; Message Hub Bridge</td>
    </tr>
    <tr>
      <td align="center">52</td>
      <td align="center"><strong><code>v2.3.3</code></strong></td>
      <td align="center"><code>2026-08-28 15:58 WIB</code></td>
      <td>Interactive Chat Emoji &amp; Emotion Picker, Multi-Category Emotion Grid, Real-Time Keyword Search &amp; Cursor-Aware Insertion Engine</td>
    </tr>
    <tr>
      <td align="center">53</td>
      <td align="center"><strong><code>v2.3.2</code></strong></td>
      <td align="center"><code>2026-08-28 15:02 WIB</code></td>
      <td>Interactive Message Reply/Quote Engine, Parent Message ID DB Schema, Dynamic Quoted Box &amp; Auto Sync Message Hub</td>
    </tr>
    <tr>
      <td align="center">54</td>
      <td align="center"><strong><code>v2.3.1</code></strong></td>
      <td align="center"><code>2026-08-28 14:55 WIB</code></td>
      <td>Categorized Contact Sidebar, Grouped Topbar Messages Dropdown, Smart Scroll Preservation &amp; Universal Profile Detail Modal</td>
    </tr>
    <tr>
      <td align="center">55</td>
      <td align="center"><strong><code>v2.3.0</code></strong></td>
      <td align="center"><code>2026-08-28 11:05 WIB</code></td>
      <td>Dedicated Messages Table, UserFactory 10 Dummy Users Seeder, Real-Time Messages Polling &amp; Registration Rejection Fixes</td>
    </tr>
    <tr>
      <td align="center">56</td>
      <td align="center"><strong><code>v2.2.0</code></strong></td>
      <td align="center"><code>2026-08-27 23:28 WIB</code></td>
      <td>User Login Tracking Engine, 24-Hour Point Accumulation, Geolocation Coordinates Capture &amp; Data Login Dashboard</td>
    </tr>
    <tr>
      <td align="center">57</td>
      <td align="center"><strong><code>v2.1.4</code></strong></td>
      <td align="center"><code>2026-08-27 23:02 WIB</code></td>
      <td>Public Landing Page Footer Overhaul, Drag &amp; Drop Website Sections Reordering, Fitur Aplikasi Header Clean-up &amp; SweetAlert2 Clean Native Restoration</td>
    </tr>
    <tr>
      <td align="center">58</td>
      <td align="center"><strong><code>v2.1.3</code></strong></td>
      <td align="center"><code>2026-08-27 21:35 WIB</code></td>
      <td>Universal SweetAlert2 Notification Engine &amp; Global Helpers, High-Contrast Checkbox SVG Fix, Multi-Select Filter Sync &amp; Route Order Optimization</td>
    </tr>
    <tr>
      <td align="center">59</td>
      <td align="center"><strong><code>v2.1.2</code></strong></td>
      <td align="center"><code>2026-08-27 20:55 WIB</code></td>
      <td>Overhaul &amp; Refactoring Modul Fitur Aplikasi: Skema Dynamic Row CRUD, Instant AJAX Toggle, Bulk Group Action &amp; Backward-Compatible Helper Object</td>
    </tr>
    <tr>
      <td align="center">60</td>
      <td align="center"><strong><code>v2.1.1</code></strong></td>
      <td align="center"><code>2026-08-27 19:10 WIB</code></td>
      <td>Edit Avatar Pengguna, Tampilan Detail (user_details &amp; user_configs), Restriksi Menu Sidenav, Notifikasi Khusus Superadmin/Admin &amp; Perapian Estetika Validasi</td>
    </tr>
    <tr>
      <td align="center">61</td>
      <td align="center"><strong><code>v2.1.0</code></strong></td>
      <td align="center"><code>2026-08-27 18:15 WIB</code></td>
      <td>Pembaruan Sistem Otentikasi, Idle Lock Screen, User Approval, Penonaktifan &amp; Aktivasi Akun Mandiri, Notification Hub &amp; Admin Reset</td>
    </tr>
    <tr>
      <td align="center">62</td>
      <td align="center"><strong><code>v2.0.0</code></strong></td>
      <td align="center"><code>2026-08-27 14:35 WIB</code></td>
      <td>Engine Dinamisasi Tema &amp; Seksi Website Terpusat, Crop Simulator &amp; Arsitektur Partial Modular</td>
    </tr>
    <tr>
      <td align="center">63</td>
      <td align="center"><strong><code>v1.9.3</code></strong></td>
      <td align="center"><code>2026-08-27 10:30 WIB</code></td>
      <td>Pemisahan Tabel Config User, Pengatur Posisi Sampul Interaktif, Motto Hidup &amp; Widget Progress Kelengkapan Profil</td>
    </tr>
    <tr>
      <td align="center">64</td>
      <td align="center"><strong><code>v1.9.2</code></strong></td>
      <td align="center"><code>2026-08-27 09:36 WIB</code></td>
      <td>Centralized Versioning Engine, Git Log Timestamps &amp; Mandatory Changelog Standard (Rule 11)</td>
    </tr>
    <tr>
      <td align="center">65</td>
      <td align="center"><strong><code>v1.9.1</code></strong></td>
      <td align="center"><code>2026-08-27 09:17 WIB</code></td>
      <td>Standarisasi Hirarki View Modul (Rule 10), Meta Title Engine &amp; Refinement Sidenav Search UI</td>
    </tr>
    <tr>
      <td align="center">66</td>
      <td align="center"><strong><code>v1.9.0</code></strong></td>
      <td align="center"><code>2026-08-27 08:04 WIB</code></td>
      <td>100% Dynamic Bilingual Engine, Custom Menu Data-Lang &amp; Modul Terjemahan Bahasa</td>
    </tr>
    <tr>
      <td align="center">67</td>
      <td align="center"><strong><code>v1.8.2</code></strong></td>
      <td align="center"><code>2026-08-02 16:47 WIB</code></td>
      <td>Melengkapi halaman profil pengguna</td>
    </tr>
    <tr>
      <td align="center">68</td>
      <td align="center"><strong><code>v1.8.1</code></strong></td>
      <td align="center"><code>2026-08-02 16:07 WIB</code></td>
      <td>Tambah halaman fitur aplikasi dan backup db di dukungan aplikasi</td>
    </tr>
    <tr>
      <td align="center">69</td>
      <td align="center"><strong><code>v1.8.0</code></strong></td>
      <td align="center"><code>2026-08-02 09:31 WIB</code></td>
      <td>Tambah halaman role, permission, akses user, akses role dan user di Manajemen Pengguna</td>
    </tr>
    <tr>
      <td align="center">70</td>
      <td align="center"><strong><code>v1.7.0</code></strong></td>
      <td align="center"><code>2026-08-01 15:54 WIB</code></td>
      <td>Perbaikan ngoding &amp; optimalisasi struktur views</td>
    </tr>
    <tr>
      <td align="center">71</td>
      <td align="center"><strong><code>v1.6.0</code></strong></td>
      <td align="center"><code>2026-08-01 13:07 WIB</code></td>
      <td>Bilingual Internationalization Engine (ID &amp; EN)</td>
    </tr>
    <tr>
      <td align="center">72</td>
      <td align="center"><strong><code>v1.5.0</code></strong></td>
      <td align="center"><code>2026-08-01 01:17 WIB</code></td>
      <td>Tabler &amp; Lucide Full Icon Explorers</td>
    </tr>
    <tr>
      <td align="center">73</td>
      <td align="center"><strong><code>v1.4.0</code></strong></td>
      <td align="center"><code>2026-08-01 00:41 WIB</code></td>
      <td>Documentation Module &amp; Interactive Tree Engine</td>
    </tr>
    <tr>
      <td align="center">74</td>
      <td align="center"><strong><code>v1.3.0</code></strong></td>
      <td align="center"><code>2026-07-31 23:17 WIB</code></td>
      <td>Layout Group Demo &amp; Custom Pages Refactoring</td>
    </tr>
    <tr>
      <td align="center">75</td>
      <td align="center"><strong><code>v1.2.0</code></strong></td>
      <td align="center"><code>2026-07-31 22:51 WIB</code></td>
      <td>Sidenav Auto-Scroll Centering &amp; Component Group</td>
    </tr>
    <tr>
      <td align="center">76</td>
      <td align="center"><strong><code>v1.1.0</code></strong></td>
      <td align="center"><code>2026-07-31 22:46 WIB</code></td>
      <td>Dynamic Navigation Config &amp; Breadcrumb Engine</td>
    </tr>
    <tr>
      <td align="center">77</td>
      <td align="center"><strong><code>v1.0.0</code></strong></td>
      <td align="center"><code>2026-07-31 10:08 WIB</code></td>
      <td>Initial Project Setup</td>
    </tr>
  </tbody>
</table>

---

## 📌 Prosedur Pembaruan Rilis Versi Baru (Rule 11)

Setiap penambahan atau pembaruan fitur yang akan dirilis wajib mengikuti langkah-langkah berikut:
1. **Update `APP_VERSION`**: Ubah versi pada `.env`, `.env.example`, dan `config/app.php` (misal `v3.0.5`).
2. **Catat Changelog**: Tambahkan blok timeline baru pada `resources/views/template/documentation/changelog.blade.php` dengan timestamp WIB.
3. **Update Dokumen Rilis**: Tambahkan baris versi rilis baru pada tabel di atas (`docs/riwayat_release_dan_tag.md`).
4. **Git Commit & Tag**: Buat commit dan tag git, lalu push ke remote repository:
   ```bash
   git add .
   git commit -m "feat(modul): deskripsi rilis versi vX.Y.Z"
   git tag -a vX.Y.Z -m "Release vX.Y.Z: Deskripsi rilis..."
   git push origin main --tags
   ```
