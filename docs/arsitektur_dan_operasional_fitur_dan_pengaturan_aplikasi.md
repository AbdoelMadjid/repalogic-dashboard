# ⚙️ Dokumentasi Arsitektur & Operasional Fitur dan Pengaturan Aplikasi

> **Status Modul:** Production-Ready (Enterprise Grade Modular Architecture)  
> **Lokasi File Dokumentasi:** `docs/arsitektur_dan_operasional_fitur_dan_pengaturan_aplikasi.md`  
> **Route URL:** `/admin/dukunganaplikasi/fitur-aplikasi`  
> **Controller:** [`App\Http\Controllers\Admin\DukunganAplikasi\FiturAplikasiController`](../app/Http/Controllers/Admin/DukunganAplikasi/FiturAplikasiController.php)  
> **Model Database:** [`App\Models\Admin\DukunganAplikasi\FiturAplikasi`](../app/Models/Admin/DukunganAplikasi/FiturAplikasi.php) & [`App\Models\Admin\DukunganAplikasi\AppSetting`](../app/Models/Admin/DukunganAplikasi/AppSetting.php)  
> **Aset Terpisah (Rule 15):** [`public/assets/css/admin/dukunganaplikasi/fitur-aplikasi.css`](../public/assets/css/admin/dukunganaplikasi/fitur-aplikasi.css) & [`public/assets/js/admin/dukunganaplikasi/fitur-aplikasi.js`](../public/assets/js/admin/dukunganaplikasi/fitur-aplikasi.js)  
> **Terakhir Diperbarui:** 04 September 2026 11:35 WIB  

---

## 📋 1. Pendahuluan & Ringkasan Modul

Modul **Fitur Aplikasi & Pusat Pengaturan Sistem** pada REPALOGIC Dashboard dirancang sebagai **Hub Kontrol Terpadu** (*Control Center*) dengan antarmuka **Card with Tabs (`.card-tabs` & `.nav-bordered`)** terstandarisasi. Modul ini mengelola visibilitas komponen antarmuka, pengaturan keamanan sesi, mode pemeliharaan operasional, sinkronisasi polling real-time, serta pemeliharaan cache server secara instan tanpa perlu memodifikasi kode sumber.

### Struktur Desain Tab Antarmuka:
```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                       PUSAT KONTROL & FITUR APLIKASI  [Kembalikan Default]                  │
├──────────────────────────────────────────────────────────────┬──────────────────────────────┤
│  [⚙️ Pengaturan Sistem]                                       │  [🎛️ Visibilitas Fitur]      │
├──────────────────────────────────────────────────────────────┴──────────────────────────────┤
│  TAB 1: PENGATURAN SISTEM & KEBIJAKAN                                                       │
│  ├── 1. Waktu Idle & Auto Lock Screen (Durasi sesi aktif & lock screen)                     │
│  ├── 2. Mode Pemeliharaan Sistem (Maintenance bypass & custom message)                      │
│  ├── 3. Kebijakan Keamanan Akun (Rate limiting & approval registrasi)                       │
│  ├── 4. Sinkronisasi Polling & Notifikasi (Interval live update & sound/toast)              │
│  └── 5. Cache & Optimasi Kinerja Server (Pembersihan multi-layer cache sistem)              │
├─────────────────────────────────────────────────────────────────────────────────────────────┤
│  TAB 2: VISIBILITAS FITUR & KOMPONEN UI                                                     │
│  ├── Quick Metrics Banner & Progress Bar Rasio Fitur Aktif                                  │
│  └── Tabel Manajemen Visibilitas Fitur (Realtime instant DOM toggle, filter, bulk actions)  │
└─────────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 🛠️ 2. Arsitektur Panel Pengaturan & Penyimpanan Persisten

### 2.1 Model & Tabel `app_settings` (Penyimpanan Konfigurasi Persisten)
Seluruh parameter pengaturan sistem kini disimpan secara persisten di tabel database `app_settings` melalui model [`AppSetting`](../app/Models/Admin/DukunganAplikasi/AppSetting.php) dengan mekanisme *Dual-Layer Caching & Fallback Dictionary*:
- **Model Methods:** `AppSetting::get($key, $default)` dan `AppSetting::set($key, $value)`.
- **Cache Lifecycle:** Cache dibersihkan dan diperbarui secara otomatis setiap kali setting diubah (`AppSetting::clearCache()`).
- **Daftar Kunci Parameter:**
  - `idle_timeout_minutes`: Batas menit idle sebelum auto-lock screen (default: `5`).
  - `maintenance_mode`: Status aktif mode pemeliharaan (default: `0`).
  - `maintenance_message`: Teks pengumuman mode pemeliharaan.
  - `rate_limit_attempts`: Batas maksimal percobaan login gagal (default: `5`).
  - `auto_user_approval`: Status persetujuan otomatis registrasi akun baru (default: `0`).
  - `new_device_alert`: Notifikasi deteksi login perangkat baru (default: `1`).
  - `polling_interval`: Interval detik background polling notifikasi/chat (default: `20`).
  - `sound_notification`: Sakelar audio chime notifikasi (default: `1`).
  - `toast_notification`: Sakelar non-blocking toast pop-up (default: `1`).

### 2.2 Rincian 5 Kartu Pengaturan Sistem (Tab 1)
1. **Waktu Idle & Auto Lock Screen:**
   - Menyimpan durasi waktu idle ke database dan menyinkronkan langsung ke `localStorage.setItem('repalogic_idle_timeout_minutes', mins)`.
   - Terintegrasi dengan modal [`lock-screen-modal.blade.php`](../resources/views/layouts/partials/lock-screen-modal.blade.php) sehingga durasi efektif berlaku untuk seluruh level pengguna (Superadmin, Admin, Operator, User).
   - Tombol **Uji Kunci** untuk pengujian modal lock screen seketika.
2. **Mode Pemeliharaan Sistem (Maintenance Mode):**
   - Mengaktifkan pengalihan halaman 503 dan penolakan login untuk akun non-admin, sementara Superadmin & Admin tetap memiliki hak bypass.
3. **Kebijakan Keamanan Akun:**
   - Mengatur batas login gagal, persetujuan pendaftaran user, dan proteksi perangkat baru.
4. **Sinkronisasi Polling & Notifikasi Live:**
   - Mengatur interval polling chat topbar, lonceng notifikasi, serta efek suara/toast.
5. **Cache & Optimasi Kinerja Server:**
   - Membersihkan seluruh layer cache aplikasi (Blade views, configuration, routes, application cache store) dengan satu klik.

---

## 🎛️ 3. Arsitektur Visibilitas Fitur & Sinkronisasi Real-Time (Tab 2)

### 3.1 Realtime DOM Manipulation Engine
Setiap komponen Topbar Header dan grup menu Sidebar telah dioptimasi dengan arsitektur visibilitas realtime:
- **Atribut Identifier:** Setiap elemen antarmuka di Topbar ([`topbar.blade.php`](../resources/views/layouts/partials/topbar.blade.php)) dan Sidebar ([`sidenav.blade.php`](../resources/views/layouts/partials/sidenav.blade.php)) memiliki atribut `data-feature="kode_fitur"`.
- **Instant JS Toggle Helper:**
  Fungsi `toggleFeatureElementInDOM(featureCode, isChecked)` pada [`fitur-aplikasi.js`](../public/assets/js/admin/dukunganaplikasi/fitur-aplikasi.js) langsung memanipulasi visibilitas elemen DOM seketika saat sakelar tabel diubah via AJAX:
  - Kotak Pencarian (`#search-box` / `topbar_search_box`)
  - Mega Menu Header & Apps (`#megamenu-header`, `#megamenu-apps`)
  - Theme Light/Dark Toggler (`#theme-toggler` / `topbar_theme_toggler`)
  - Shortcut Apps Grid (`#apps-dropdown-rounded` / `topbar_apps_dropdown`)
  - Pesan Obrolan Topbar (`#simple-messages-dropdown` / `topbar_messages`)
  - Lonceng Notifikasi Alert (`#notification-dropdown-alert` / `topbar_notifications`)
  - Mode Layar Penuh (`#fullscreen-toggler` / `topbar_fullscreen`)
  - Mode Monokrom (`#monochrome-toggler` / `topbar_monochrome`)
  - Panel Theme Settings Customizer (`#theme-settings-toggler` / `topbar_customizer`)
  - Pemilih Bahasa i18n (`#language-selector` / `topbar_language`)
  - Template Sidebar Menu Groups (`menu_group_main`, `menu_group_apps`, `menu_special_menu`, dll.)

### 3.2 Persistensi Tab Aktif & Zero-Reload Bulk Actions
- **Tab State Persistence:** Sistem secara otomatis menyimpan tab aktif (`#tab-settings` atau `#tab-visibility`) ke `localStorage.setItem('active_fitur_tab', targetHash)` dan URL hash browser (`history.replaceState`).
- **Zero-Reload Bulk Action:** Aksi massal (**Aktifkan Terpilih**, **Nonaktifkan Terpilih**, dan **Hapus Terpilih**) mengeksekusi pembaruan status dan DOM secara realtime tanpa me-reload halaman, sehingga pengguna tetap berada di tab aktif tanpa lompatan fokus.
- **Form Modal AJAX:** Penambahan dan pembaruan fitur via modal diproses via AJAX dengan tetap mengarahkan fokus ke `#tab-visibility`.

---

## 🔄 4. Tombol "Kembalikan Default" (Factory Reset to Seeder)

Untuk mempermudah pemulihan sistem ke setelan awal pabrik, disediakan tombol **Kembalikan Default** pada header kartu:
- **Endpoint:** `POST /admin/dukunganaplikasi/fitur-aplikasi/reset-defaults` (`admin.dukunganaplikasi.fitur-aplikasi.reset-defaults`).
- **Alur Eksekusi:**
  1. Mereset seluruh nilai `app_settings` ke kamus default [`AppSettingSeeder`](../database/seeders/AppSettingSeeder.php).
  2. Menjalankan [`FiturAplikasiSeeder`](../database/seeders/FiturAplikasiSeeder.php) untuk mengembalikan status visibilitas seluruh fitur bawaan.
  3. Mengosongkan seluruh layer cache sistem (`AppSetting::clearCache()`, `FiturAplikasi::clearCache()`, `view:clear`, `cache:clear`).
  4. Menampilkan notifikasi sukses SweetAlert2 dan menyegarkan data secara bersih.

---

## 🌐 5. Daftar Rute & Endpoint API Modul

| Method | URI Route | Nama Rute | Controller & Method | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin/dukunganaplikasi/fitur-aplikasi` | `admin.dukunganaplikasi.fitur-aplikasi.index` | `FiturAplikasiController@index` | Menampilkan hub kontrol & visibilitas fitur |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi` | `admin.dukunganaplikasi.fitur-aplikasi.store` | `FiturAplikasiController@store` | Menyimpan fitur aplikasi baru (AJAX ready) |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/toggle` | `admin.dukunganaplikasi.fitur-aplikasi.toggle` | `FiturAplikasiController@toggleFeature` | Toggle status visibilitas fitur instan via AJAX |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/toggle-group` | `admin.dukunganaplikasi.fitur-aplikasi.toggle-group` | `FiturAplikasiController@toggleGroup` | Toggle masal seluruh fitur dalam satu kategori |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/bulk-action` | `admin.dukunganaplikasi.fitur-aplikasi.bulk-action` | `FiturAplikasiController@bulkAction` | Aksi masal realtime (aktifkan, nonaktifkan, hapus) |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/clear-cache` | `admin.dukunganaplikasi.fitur-aplikasi.clear-cache` | `FiturAplikasiController@clearSystemCache` | Membersihkan seluruh cache server |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/reset-defaults` | `admin.dukunganaplikasi.fitur-aplikasi.reset-defaults` | `FiturAplikasiController@resetDefaults` | Kembalikan pengaturan sistem & fitur ke seeder default |
| `POST` | `/admin/dukunganaplikasi/fitur-aplikasi/update-setting` | `admin.dukunganaplikasi.fitur-aplikasi.update-setting` | `FiturAplikasiController@updateAppSetting` | Menyimpan konfigurasi setting ke tabel `app_settings` |
| `PUT` | `/admin/dukunganaplikasi/fitur-aplikasi/{id}` | `admin.dukunganaplikasi.fitur-aplikasi.update` | `FiturAplikasiController@update` | Memperbarui data detail fitur |
| `DELETE` | `/admin/dukunganaplikasi/fitur-aplikasi/{id}` | `admin.dukunganaplikasi.fitur-aplikasi.destroy` | `FiturAplikasiController@destroy` | Menghapus fitur dari database |

---

## 📂 6. Struktur File & Komponen Terkait

```
repalogic-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/DukunganAplikasi/
│   │   │   └── FiturAplikasiController.php         # Handler hub fitur, reset defaults, cache & settings
│   │   ├── Middleware/
│   │   │   └── CheckMaintenanceMode.php           # Middleware pembatasan akses saat maintenance
│   │   └── Requests/
│   │       ├── Admin/DukunganAplikasi/
│   │       │   └── FiturAplikasiRequest.php       # Validasi form input data fitur
│   │       └── Auth/
│   │           └── LoginRequest.php               # Validasi otentikasi login & maintenance check
│   └── Models/Admin/DukunganAplikasi/
│       ├── FiturAplikasi.php                      # Model tabel fitur_aplikasi dengan caching
│       ├── AppSetting.php                         # Model tabel app_settings dengan caching & fallback
│       └── FeatureSettingMap.php                  # Safe helper object untuk cached feature flags
├── database/
│   ├── migrations/
│   │   ├── 2026_08_02_000001_create_fitur_aplikasi_table.php
│   │   └── 2026_09_04_000001_create_app_settings_table.php
│   └── seeders/
│       ├── FiturAplikasiSeeder.php                # Seeder bawaan visibilitas fitur aplikasi
│       └── AppSettingSeeder.php                   # Seeder bawaan parameter pengaturan sistem
├── public/assets/
│   ├── css/admin/dukunganaplikasi/
│   │   └── fitur-aplikasi.css                     # External CSS modul fitur aplikasi (Rule 15)
│   └── js/admin/dukunganaplikasi/
│       └── fitur-aplikasi.js                      # External JS AJAX & realtime DOM toggle (Rule 15)
├── resources/views/
│   ├── admin/dukunganaplikasi/
│   │   ├── fitur-aplikasi.blade.php               # View Card with Tabs (Pengaturan Sistem & Visibilitas)
│   │   └── partials/
│   │       └── fitur_aplikasi_modal.blade.php     # Modal form tambah & edit fitur
│   ├── layouts/partials/
│   │   ├── topbar.blade.php                       # Topbar header dengan realtime data-feature hooks
│   │   ├── topbar/*.blade.php                     # Partial item topbar header
│   │   ├── sidenav.blade.php                      # Sidebar navigation dengan realtime feature hooks
│   │   └── lock-screen-modal.blade.php            # Modal lock screen & dynamic idle timer
│   └── errors/
│       └── 503.blade.php                          # Halaman responsif 503 Mode Pemeliharaan
└── docs/
    └── arsitektur_dan_operasional_fitur_dan_pengaturan_aplikasi.md
```

---

## 💡 7. Panduan Pengujian & Verifikasi Fitur

### 7.1 Menguji Kembalikan ke Pengaturan Default (Factory Reset)
1. Buka rute `admin/dukunganaplikasi/fitur-aplikasi`.
2. Klik tombol **Kembalikan Default** berwarna merah pada header kartu di samping judul modul.
3. Konfirmasi popup SweetAlert2.
4. Sistem akan mengeksekusi reset pada seluruh pengaturan sistem dan visibilitas fitur ke konfigurasi seeder awal, mengosongkan cache, dan menyegarkan tampilan dengan tetap berada di tab aktif saat ini.

### 7.2 Menguji Visibilitas Realtime Topbar Header
1. Masuk ke **Tab 2 (Visibilitas Fitur & Komponen)**.
2. Geser sakelar pada fitur kelompok Topbar (misal: *Pencarian*, *Theme Light/Dark Switcher*, *Lonceng Notifikasi*, dll.).
3. Amati bagian atas layar: ikon/komponen Topbar akan langsung muncul atau menghilang seketika secara realtime tanpa perlu me-reload halaman.

### 7.3 Menguji Persistensi Tab Aktif
1. Pindah ke **Tab 2 (Visibilitas Fitur & Komponen)**.
2. Pilih beberapa fitur melalui checkbox baris lalu klik **Nonaktifkan Terpilih**.
3. Notifikasi sukses SweetAlert2 akan muncul dan halaman **tetap berada di Tab 2** tanpa kembali ke Tab 1.
4. Lakukan reload manual pada browser (`F5`), sistem akan secara otomatis membuka kembali Tab 2 sesuai preferensi terakhir Anda.
