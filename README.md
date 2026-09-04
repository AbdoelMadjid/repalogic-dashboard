## Hi there 👋

<div id="header" align="center">
  <img src="https://media.giphy.com/media/M9gbBd9nbDrOTu1Mqx/giphy.gif" width="100"/>
  <br>
  <img src="https://readme-typing-svg.herokuapp.com/?font=Righteous&size=35&center=true&vCenter=true&width=500&height=70&duration=4000&lines=Hi+There!+👋;+I'm+Abdoel+Madjid!;" />
</div>
<img src="https://i.imgur.com/dBaSKWF.gif" height="20" width="100%">

<div align="center">
  
[![GitHub WidgetBox](https://github-widgetbox.vercel.app/api/profile?username=abdoelmadjid&data=followers,repositories,stars,commits&theme=viridescent)](https://github.com/abdoelmadjid)

![](https://komarev.com/ghpvc/?username=abdoelmadjid&color=brightgreen&style=for-the-badge)
[![LinkedIn](https://img.shields.io/badge/linkedin-%230077B5.svg?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/abdoelmadjid/)
[![Gmail](https://img.shields.io/badge/%20-Send%20Mail-black?color=14171A&labelColor=ef5350&logo=gmail&logoColor=ffffff&style=for-the-badge)](mailto:abdulmadjid.mpd@gmail.com)
[![Facebook](https://img.shields.io/badge/Facebook-%231877F2.svg?style=for-the-badge&logo=Facebook&logoColor=white)](https://facebook.com/abdulmadjid.mpd)
[![Twitter](https://img.shields.io/badge/Twitter-%231DA1F2.svg?style=for-the-badge&logo=Twitter&logoColor=white)](https://x.com/AbdoelMadjid)
[![Instagram](https://img.shields.io/badge/Instagram-%405DE6.svg?style=for-the-badge&logo=Instagram&logoColor=white)](https://www.instagram.com/abdoelmadjid)

</div>

<br/>

<table align="center" width="100%" height="100%" >
   <tr>
     <td><p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p></td>
    <td><p align="center"><a href="https://webapplayers.com/inspinia/" target="_blank"><img src="https://webapplayers.com/inspinia/bootstrap/assets/images/logo-black.png" width="350" alt="Inspinia Logo"></a></p></td>
   </tr>
</table>

## About Repalogic Dashboard

**Repalogic Dashboard** adalah aplikasi sistem manajemen admin, kontrol hak akses, komunikasi internal, dan web portal modern berbasis **Laravel 13** dan **Inspinia Admin Template**. Dashboard ini dirancang menggunakan arsitektur modular (*Domain-Driven Modular Architecture*) untuk memberikan solusi enterprise yang komprehensif, fleksibel, terisolasi, serta berkinerja tinggi.

---

## 🌟 Fitur Utama (Core Features)

1. 💬 **Engine Percakapan & Chat Interaktif (*Messages Hub*)**:
   - Komunikasi dua arah real-time (*1-on-1 Direct Chat*) dengan ID deterministik.
   - **Menu Aksi Titik Tiga (*3-Dots Dropdown*)** di sudut bubble chat (*Balas, Teruskan, Pin, Hapus*).
   - **Perekam & Pemutar Pesan Suara (*Voice Note Audio Engine*)** dengan visualizer gelombang audio dan timer real-time.
   - **Hasil Reaksi Emoji Bersih Sejajar (*Inline Clean Reactions*)** di samping tombol reaksi emoji dengan sinkronisasi *in-place selective sync*.
   - **Kutipan Balasan Pesan (*Quoted Reply*)**, **Penerusan Pesan (*Forwarding*)**, dan **Penyematan Pesan (*Pinned Messages*)**.
   - **Pencarian Riwayat Obrolan (*In-Chat Search & Highlighting*)** dengan counter navigasi panah atas/bawah.
   - **Penghapusan Ganda (*Dual-Mode Deletion*)**: *Tarik untuk Semua Orang (Unsend)* vs *Hapus untuk Saya Sendiri*, serta *Pembersihan Histori Obrolan (Clear History)*.
   - Unggah lampiran foto & dokumen hingga 10 MB lengkap dengan *Live Preview Bar* dan *Lightbox Modal*.

2. 🤝 **Triad Ekosistem Sosial (Pertemanan, Like Profil & Notifikasi Lonceng)**:
   - Jaringan pertemanan internal (*Kirim Ajakan, Terima, Tolak, Batal, dan Hapus Pertemanan/Unfriend*).
   - Sistem apresiasi profil (*Profile Likes Engine*) dengan sinkronisasi angka real-time.
   - Integrasi lonceng notifikasi topbar reaktif dengan *deep linking* langsung ke kartu pengguna pada Dashboard.
   - Transformasi kartu kontak otomatis menjadi tombol obrolan aktif (*💬 Chat*) setelah berteman.

3. 🌐 **Sistem Bilingual Modular 2-Arah (*Modular i18n Engine*)**:
   - Kamus terjemahan modular terisolasi pada **6 Domain**: `sidebar_template`, `sidebar_menu`, `topbar`, `auth`, `customizer`, dan `frontpage`.
   - Paralel loader engine (`Promise.allSettled`) dengan pergantian bahasa instan *zero page reload* (< 5ms).
   - Manajemen terjemahan berbasis Nav Tab per domain dengan auto-sync model hook `Menu::saved` dan CLI code scanner `php artisan menu:lang-sync`.
   - *Pre-Hydration Anti-Flicker* pada topbar language switcher.

4. 🔐 **Manajemen Pengguna & Otorisasi Spatie Permission Matrix**:
   - 6 Sub-Modul terpadu: *Role, Permission, Akses Role, Akses User, Users Lifecycle, dan Data Login*.
   - **Tabel Matriks Hak Akses Berjenjang (*Matrix Table*)**: Pengelompokan izin `create`, `read`, `update`, `delete` berbasis Menu Utama & Sub-Menu dengan *Master Select All* dan *Row Toggle*.
   - **Siklus Hidup Akun (*Zero-Trust Lifecycle*)**: Alur registrasi mandiri, persetujuan admin (*approval*), penolakan beralasan, penonaktifan mandiri (*Danger Zone*), permohonan aktivasi kembali, dan invalidasi sesi instan.
   - **Impersonasi Akun (*Switch Account*)**: Administrator dapat masuk sebagai pengguna target dengan *floating banner switch-back*.
   - **Audit Trail Data Login**: Pelacakan IP, perangkat, platform, browser, perolehan reward poin, dan peta geolokasi OpenStreetMap.

5. 👤 **Kustomisasi Profil Pengguna & Banner Sampul WYSIWYG**:
   - Penataan profil dalam arsitektur satu halaman (*Single-Page Profile*).
   - Pengaturan interaktif foto sampul: slider tinggi proporsional, color picker & preset swatches warna overlay, slider transparansi ($0\% - 100\%$), efek blur ($0\text{px} - 20\text{px}$), dan kustomisasi warna teks motto hidup.
   - Penyimpanan data pelengkap: NIK, nomor telepon WhatsApp interaktif, alamat domisili, dan pratinjau foto KTP ukuran penuh.

6. ⚙️ **Hub Pengaturan Fitur, Mode Pemeliharaan & Kinerja Server**:
   - Panel kontrol 6 widget interaktif untuk pengawasan proporsi fitur aktif, durasi waktu idle auto lock screen, dan interval polling live.
   - **Mode Pemeliharaan (*Maintenance Mode*)**: Penguncian sistem global dengan halaman responsif 503 kustom dan bypass otomatis superadmin/admin.
   - **Admin Customizer Optimize Clear Engine**: Pembersihan serentak seluruh cache view Blade, routes, configs, database cache store, dan reset tema layout melalui AJAX.

7. 🎨 **Engine Dinamisasi Tema & Seksi Website**:
   - Pemisahan tampilan publik murni (*Loose Coupling*) antara konten Blade dengan properti layout database.
   - Dukungan variasi background (*Light, Dark, Primary, Dynamic Custom Image*), orientasi otomatis, dan efek paralaks 3D.

8. 🧭 **Manajemen Menu & Navigasi Hierarki 3-Level**:
   - Pengurutan interaktif *SortableJS Drag & Drop* multi-handle (Kategori, Menu Utama, Sub-Menu L2/L3).
   - Sakelar on/off berjenjang (*Cascading Status Toggle*) dan rendering otomatis via `SidebarComposer`.

---

## 📚 Skema dan Operasional Sistem

### 1. Skema Arsitektur & Teknologi (Tech Stack)
- **Backend Framework**: Laravel 13 (PHP 8.3+)
- **Authentication & Security**: Laravel Session Guard, Rate Limiting Lockout, Zero-Trust Session Invalidation
- **Authorization Engine**: Spatie Laravel-Permission (`spatie/laravel-permission`)
- **Data Tables Engine**: Yajra Laravel DataTables (`yajra/laravel-datatables-oracle`)
- **Frontend Stack**: Bootstrap 5, Vite, Vanilla JS & CSS terpisah (Rule 15), Inspinia Assets, SweetAlert2, Tabler Icons, Lucide Icons
- **Real-Time Polling Engine**: Quad-Polling Lightweight Background Poller (Dashboard, Lonceng Notifikasi, Topbar Pesan, Chat Aktif)

### 2. Standar Pemisahan Aset Eksternal (Rule 15 Architecture)
Seluruh style CSS kustom dan logika interaksi JavaScript dipisahkan ke dalam direktori terdedikasi di `public/assets/`:
```text
public/assets/
├── css/admin/{kelompok}/{modul}.css
└── js/admin/{kelompok}/{modul}.js
```

### 3. Struktur Hirarki Modul Backend
```text
repalogic-dashboard/
├── app/
│   ├── Http/Controllers/Admin/{Kelompok}/{Modul}Controller.php
│   ├── Http/Requests/Admin/{Kelompok}/{Modul}Request.php
│   ├── Models/Admin/{Kelompok}/{Modul}.php
│   └── ViewComposers/SidebarComposer.php
├── resources/views/
│   ├── admin/{kelompok}/{modul}.blade.php
│   └── admin/{kelompok}/partials/{sub_komponen}.blade.php
└── docs/
    └── [Berkas Dokumentasi Teknis Lengkap]
```

### 4. Direktori Dokumentasi Teknis Lengkap (`docs/`)
- 🏆 [**Ulasan & Evaluasi Menyeluruh Arsitektur Aplikasi**](docs/ulasan_dan_evaluasi_arsitektur_aplikasi.md) — Evaluasi teknis, kematangan arsitektur, kesiapan operasional enterprise, scorecard penilaian kualitas, dan analisis keunggulan sistem.
- 🏷️ [**Riwayat Lengkap Release & Git Tag**](docs/riwayat_release_dan_tag.md) — Pelacakan versi rilis dan catatan pembaruan komprehensif.
- 💬 [**Arsitektur & Operasional Fitur Chat / Messages**](docs/arsitektur_dan_operasional_fitur_chat_messages.md) — Skema database pesan, 3-dots action menu, voice note engine, inline reactions, quoted reply, dan in-place selective sync.
- 🤝 [**Arsitektur & Operasional Pertemanan, Notifikasi & Chat**](docs/arsitektur_dan_operasional_pertemanan_notifikasi_chat.md) — Alur integrasi triad sosial, ajakan berteman, profile likes, lonceng topbar, dan quad-polling engine.
- 🌐 [**Arsitektur & Operasional Sistem Bilingual (i18n)**](docs/arsitektur_dan_operasional_bilingual.md) — Arsitektur 6 domain kamus modular, parallel loader `Promise.allSettled`, dan auto-sync model listener.
- 👥 [**Arsitektur & Operasional Manajemen Pengguna**](docs/arsitektur_dan_operasional_manajemen_pengguna.md) — Panduan 6 sub-modul otorisasi Spatie Permission Matrix, users lifecycle, dan audit trail data login.
- ⚙️ [**Arsitektur & Operasional Fitur dan Pengaturan Aplikasi**](docs/arsitektur_dan_operasional_fitur_dan_pengaturan_aplikasi.md) — Hub kontrol Card with Tabs, pengaturan persisten `app_settings`, mode pemeliharaan 503, waktu idle dinamis, realtime DOM toggle, dan factory reset to seeder.
- 🧭 [**Arsitektur & Operasional Modul Manajemen Menu**](docs/arsitektur_dan_operasional_manajemen_menu.md) — Struktur hierarki menu 3 level, drag & drop SortableJS, cascading status toggle, dan SidebarComposer.
- 🔐 [**Arsitektur & Operasional Autentikasi Pengguna**](docs/arsitektur_dan_operasional_authentication_user.md) — Registrasi mandiri, persetujuan admin, penonaktifan mandiri, aktivasi kembali, dan proteksi sesi.
- 🎨 [**Arsitektur Engine Dinamisasi Tema & Seksi Website**](docs/arsitektur_dinamisasi_tema_website.md) — Panduan arsitektur *Loose Coupling*, *Crop Simulator*, paralaks 3D, dan variasi background dinamis.

### 5. Perintah Operasional Penting (Artisan CLI)
```bash
# Membersihkan seluruh cache sistem (Blade, Config, Route, Application Store)
php artisan optimize:clear

# Sinkronisasi & pemindaian otomatis key terjemahan menu ke kamus JSON modular
php artisan menu:lang-sync

# Reset cache otorisasi Spatie Permission
php artisan permission:cache-reset

# Menjalankan database seeder
php artisan db:seed

# Menjalankan worker antrean latar belakang
php artisan queue:listen

# Streaming log error dan query secara real-time
php artisan pail
```

---

## 📐 Standar Arsitektur & Pedoman Pengembangan (Project Rules & Architecture Guidelines)

Seluruh pengembang dan AI Coding Assistant (Antigravity Agent) yang berkontribusi pada repositori ini **wajib mematuhi 15 Aturan Baku Arsitektur** (`.agents/AGENTS.md`):

| No | Aturan / Standar | Ringkasan Pedoman & Implementasi |
| :---: | :--- | :--- |
| **Rule 1** | **Layout Vertikal & Penempatan Script** | Layout `resources/views/layouts/vertical.blade.php` hanya merender `@yield('content')`. Seluruh tag `<script>` halaman **WAJIB** berada di dalam `@section('content')` sebelum `@endsection`. Dilarang menggunakan `@section('script')`. |
| **Rule 2** | **Event Delegation untuk Tombol & Modal** | Aksi tombol tabel/modal wajib menggunakan *Event Delegation* (`document.addEventListener('click', function(e) { const btn = e.target.closest('.btn-action'); ... })`) agar konsisten bekerja saat live search, filter, dan pagination. |
| **Rule 3** | **Standar Autoloading PSR-4** | Penamaan class di `app/` (Controllers, Requests, Models) mematuhi standar PSR-4 sehingga tidak memerlukan `composer dump-autoload` berlebih kecuali saat pemindahan folder/namespace. |
| **Rule 4** | **Tata Letak Modal Bebas Scroll Internal** | Modal bervolume besar (seperti Matriks Permission) wajib menggunakan ukuran dialog luas (`modal-xl` / `modal-lg`) dan mengalir mengikuti scrollbar peramban utama tanpa container sempit `overflow-y: auto`. |
| **Rule 5** | **Standar Spatie Permission Matrix Table** | Form penugasan izin hak akses wajib disajikan dalam format tabel matriks: Kolom `MODUL / FITUR`, `CREATE`, `READ`, `UPDATE`, `DELETE`, `LAINNYA`, `SEMUA`, dengan checkbox kontras tinggi (`border: 2px solid #475569 !important`). |
| **Rule 6** | **Serialisasi JSON Aman untuk Grouped Collection** | Saat mengirim koleksi Eloquent hasil `->groupBy(...)` ke Blade `@json()`, **WAJIB** merantai `->values()` (contoh: `@json($collection->values())`) agar JavaScript membaca data sebagai Array murni, bukan Object non-sekuensial. |
| **Rule 7** | **Larangan Dataset `data-target` Non-Numerik** | Dilarang menggunakan atribut `data-target="..."` untuk penanda aksi JavaScript karena bertabrakan dengan fungsi `initCounter()` bawaan template yang mengubah teks elemen menjadi `NaN`. Gunakan `data-module`, `data-role`, dsb. |
| **Rule 8** | **Format Header Tabel Single-Line & Rata Tengah** | Seluruh `<thead>`, `<tr>`, dan `<th>` pada DataTables dan tabel modal wajib menerapkan class `align-middle text-center text-nowrap` agar teks header tidak terpotong atau turun baris secara tidak rapi. |
| **Rule 9** | **Universal SweetAlert2 Notification Standard** | Dilarang menggunakan `alert()` / `confirm()` bawaan browser. Gunakan atribut `<form data-confirm="...">` atau helper global SweetAlert2: `window.showSuccess()`, `window.showError()`, `window.showWarning()`, `window.showConfirm()`, dan `window.showToast()`. |
| **Rule 10** | **Hirarki Direktori Modul & Flat View Naming** | Struktur folder harus seragam antar Controller, Request, Model, dan View: `admin/{kelompok}/{modul}.blade.php`. Dilarang membuat subfolder dengan `index.blade.php`. Komponen partial diletakkan di `admin/{kelompok}/partials/`. |
| **Rule 11** | **Kewajiban Update Changelog & Release History** | Setiap penambahan atau perubahan fitur wajib memperbarui `APP_VERSION`, menambahkan linimasa waktu WIB di `resources/views/template/documentation/changelog.blade.php`, dan mencatatnya pada `docs/riwayat_release_dan_tag.md`. |
| **Rule 12** | **Warna Card Header & Styling Widget** | Card Header pengaturan utama wajib menggunakan `class="card-header bg-primary text-white py-3"` dengan judul putih. Card Header data/konten netral menggunakan `class="card-header bg-white py-3"`. Dilarang menggunakan `bg-light`. |
| **Rule 13** | **Standardisasi View Seksi Tema Website Dinamis** | Seluruh view seksi di `resources/views/website/{folder}/{file}.blade.php` wajib menggunakan pembungkus baku netral `<section class="section-custom" id="{target_id}">` tanpa hardcode background warna/gambar di Blade. |
| **Rule 14** | **Standar Jarak Ikon dan Label (Icon Spacing)** | Seluruh ikon (`<i>`, `<svg>`) yang berdampingan dengan label teks, tombol, badge, atau header tabel **WAJIB** memiliki jarak visual eksplisit (contoh: `me-1.5`, `me-2`, atau container `gap-2`). Dilarang menempel tanpa spasi. |
| **Rule 15** | **Pemisahan Aset Eksternal CSS & JS** | Seluruh kode CSS dan logika JS untuk modul admin wajib dipisahkan ke dalam berkas eksternal di `public/assets/css/admin/{kelompok}/{modul}.css` dan `public/assets/js/admin/{kelompok}/{modul}.js`. Dilarang menulis blok inline besar di Blade. |

---

## 🗺️ Roadmap / Rencana Pengembangan (Run Down Pengembangan)

Berikut adalah linimasa pencapaian dan rencana pengembangan arsitektur proyek Repalogic Dashboard:

- [x] **Fase 1: Inisialisasi Fondasi & Integrasi Layout UI Inspinia**
  - Setup Laravel 13, integrasi tema Inspinia, dan standardisasi Blade Vertical Layout (`layouts.vertical`).
  - Implementasi breadcrumb dinamis dan penjelajah ikon lengkap (Tabler & Lucide Icons).
- [x] **Fase 2: Navigasi Hierarki Dinamis & Engine Bilingual Modular**
  - Struktur menu 3-level dengan SortableJS Drag & Drop reordering dan cascading status toggle.
  - Arsitektur kamus terjemahan modular pada 6 domain terisolasi dengan Parallel Loader Engine (`Promise.allSettled`).
- [x] **Fase 3: Otorisasi Spatie Permission Matrix & Manajemen Pengguna Enterprise**
  - Sub-modul Role, Permission, Akses Role Matrix Table, Akses User Direct Permissions, Users Lifecycle, dan Data Login Audit Trail.
  - Alur persetujuan pendaftaran akun (*Approval Workflow*), impersonasi pengguna (*Switch Account*), dan invalidasi sesi instan.
- [x] **Fase 4: Hub Pengaturan Sistem, Mode Pemeliharaan & Kustomisasi Profil WYSIWYG**
  - Pusat pengaturan 6 widget, auto lock screen dengan idle timer dinamis, dan middleware proteksi 503 Maintenance Mode.
  - Editor interaktif sampul profil (slider tinggi, overlay swatches, opacity, blur, warna motto, dan WhatsApp field).
  - Dinamisasi tema & seksi landing page publik (*Loose Coupling*, paralaks 3D, crop simulator).
- [x] **Fase 5: Triad Sosial & Komunikasi Real-Time (Pertemanan, Notifikasi & Chat Messages)**
  - Jaringan pertemanan internal, tombol suka profil (*Profile Likes*), dan sinkronisasi lonceng notifikasi reaktif.
  - Engine chat percakapan *1-on-1*, menu aksi 3-titik (*3-Dots Dropdown*), reaksi emoji sejajar (*inline clean reactions*), perekam pesan suara (*Voice Note*), kutipan balasan (*Reply*), penyematan (*Pin*), penerusan (*Forward*), pencarian teks dalam chat, dan penghapusan ganda (*Dual-Mode Deletion*).
- [x] **Fase 6: Standarisasi Pemisahan Aset (Rule 15) & Optimasi Anti-Flicker**
  - Pemisahan 100% kode JavaScript dan CSS ke direktori eksternal `public/assets/` di seluruh modul admin.
  - Optimasi transisi layout tanpa kedipan (*Anti-Flicker Pre-Hydration*) dan Admin Customizer Optimize Clear Engine via AJAX.
- [ ] **Fase 7: RESTful API Integration, Web Push Notifications & Multi-Tenancy** *(Rencana Mendatang)*
  - Penyediaan API Endpoints terautentikasi (Sanctum / Passport) untuk integrasi aplikasi mobile & pihak ketiga.
  - Integrasi Web Push Notification API untuk notifikasi desktop instan di luar browser.
  - Dukungan multi-tenant arsitektur database terisolasi untuk penyedia SaaS multi-organisasi.

---

## 🚀 Langkah-langkah Git Clone & Instalasi

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek **Repalogic Dashboard** di lingkungan lokal Anda:

### 1. Prasyarat Sistem
- **PHP**: `>= 8.3` (Disarankan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`/`imagick` aktif)
- **Composer**: `>= 2.x`
- **Node.js & NPM**: `>= 18.x` / `>= 20.x`
- **Database**: MySQL / MariaDB (Rekomendasi: Laragon / XAMPP)
- **Git**

### 2. Clone Repository
Buka terminal / PowerShell, lalu jalankan perintah:
```bash
git clone https://github.com/AbdoelMadjid/repalogic-dashboard.git
cd repalogic-dashboard
```

### 3. Instalasi Dependensi PHP (Composer)
```bash
composer install
```

### 4. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
# Linux / macOS / Git Bash
cp .env.example .env

# Windows PowerShell
copy .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=repalogic_dashboard
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi & Seeder Database
Jalankan migrasi tabel beserta seeder bawaan (data role, permission, menu bawaan, & user akun awal):
```bash
php artisan migrate --seed
```

### 7. Buat Symbolic Link Storage (PENTING untuk Foto Avatar, Sampul, & Lampiran Chat)
Jalankan perintah penyambungan direktori storage publik:
```bash
php artisan storage:link
```

### 8. Instalasi Dependensi Frontend & Compile Assets
```bash
npm install
npm run build
```

### 9. Menjalankan Server Lokal
Anda dapat menjalankan server pengembangan menggunakan:

*Menggunakan Artisan Serve:*
```bash
php artisan serve
```
Akses aplikasi di browser pada alamat: **`http://127.0.0.1:8000`**

*Atau Menggunakan Script Development Lengkap (Server, Queue Worker, Pail, & Vite):*
```bash
composer run dev
```

---

## 📄 License

Proyek **Repalogic Dashboard** dilisensikan di bawah lisensi terbuka [MIT license](https://opensource.org/licenses/MIT).
