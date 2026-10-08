# 📘 Arsitektur & Panduan Operasional Pengaturan Profil Pengguna (User Profile & Self-Service Settings)

> **Judul Dokumen:** Arsitektur, Klasifikasi Sifat Fitur & Panduan Teknis Pengaturan Mandiri Profil Pengguna  
> **Lokasi File:** `docs/arsitektur_dan_operasional_pengaturan_profil_pengguna.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Modul Terkait:** Profil Pengguna (`/admin/profil-pengguna`)  
> **Versi Rilis:** `v3.5.0`  
> **Tanggal Pembaharuan:** 08 Oktober 2026  

---

## 📑 1. Ikhtisar & Tujuan Modul (*Executive Summary*)

Modul **Profil Pengguna (`/admin/profil-pengguna`)** di REPALOGIC Dashboard berfungsi sebagai **Pusat Pengaturan Mandiri (*Unified Self-Service Hub*)** bagi setiap pengguna terdaftar. Modul ini memungkinkan pengguna untuk mengelola identitas kependudukan fisik, keamanan akun tingkat lanjut (2FA TOTP), foto sampul header dinamis, serta 7 kluster preferensi operasional aplikasi secara terpadu.

Tujuan utama dari arsitektur ini adalah:
1. **Pemisahan Sifat Pengaturan**: Membedakan secara tegas antara opsi yang **berdampak pada visibilitas publik/sosial bagi pengguna lain** dan opsi yang **khusus untuk preferensi kenyamanan kerja pengguna itu sendiri**.
2. **Efisiensi Basis Data Tanpa Redundansi Kolom**: Seluruh preferensi personal disimpan ke dalam skema JSON `settings` pada tabel `user_configs`.
3. **Modularitas Kode (*Component-Based Partials*)**: Seluruh kartu (*card*), widget, tab, dan dialog modal dipecah ke dalam folder parsial mandiri di `resources/views/admin/profil-pengguna/partials/` guna mempermudah pemeliharaan jangka panjang.

---

## 🧭 2. Klasifikasi Sifat & Dampak Fitur (*Feature Classification*)

Setiap opsi pengaturan pada profil pengguna diklasifikasikan ke dalam 2 kategori utama dengan pemisahan konteks yang jelas:

```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                          KLASIFIKASI PENGATURAN PROFIL PENGGUNA                             │
├──────────────────────────────────────────────┬──────────────────────────────────────────────┤
│ 🌐 1. PUBLIK / SOSIAL (PUBLIC & SOCIAL)      │ ⚙️ 2. PERSONAL / PRIVAT (SELF PREFERENCES)   │
├──────────────────────────────────────────────┼──────────────────────────────────────────────┤
│ • Dampak: Terlihat/Dirasakan Pengguna Lain   │ • Dampak: Hanya untuk Layar & Browser Sendiri│
│ • Tempat: Direktori Pengguna, Chat, Perteman │ • Tempat: Tema, Notifikasi, Tabel, Auto-Lock │
│ • Konteks Mandiri: Pemilik Akun Tetap Dapat  │ • Konteks Sesi: Berlaku Eksklusif untuk Akun │
│   Melihat Datanya di Banner Profil Pribadi   │   yang Sedang Login di Perangkat Tersebut    │
└──────────────────────────────────────────────┴──────────────────────────────────────────────┘
```

> **📌 Prinsip Konteks Tampilan (Self-View vs Public-View):**
> - **Konteks Konsumsi Sendiri (*Self-View* di `/admin/profil-pengguna`)**: Pemilik akun selalu dapat melihat metrik miliknya sendiri (Poin Login, Total Suka, Teman) di banner profilnya. Jika fitur disembunyikan dari publik, banner menampilkan lencana informatif `<i class="ti ti-eye-off"></i>` (Disembunyikan dari Publik).
> - **Konteks Publik (*Public-View* di Direktori Dashboard & Kontak)**: Pengaturan privasi berlaku aktif bagi pengguna lain. Jika dinonaktifkan, orang lain tidak dapat melihat poin login, tidak dapat menyukai profil, dan disesuaikan izin interaksinya.

---

### 🌐 Kategori A: Pengaturan Publik / Sosial (*Public & Social Facing*)
Pengaturan ini mengontrol bagaimana profil Anda ditampilkan kepada orang lain serta membatasi interaksi masuk dari pengguna lain di sistem:

| No | Nama Fitur / Opsi | Pilihan Nilai | Dampak Bagi Pengguna Lain (Publik) | Tampilan pada Pemilik Akun (Self-View) | Implementasi Teknis di Kode |
|:---:|---|---|---|---|---|
| **A.1** | **Tampilkan Poin Login di Banner** (`privacy.show_points`) | • `Aktif (Default)`<br>• `Nonaktif (Sembunyikan)` | Baris Poin Login disembunyikan dari kartu kontak direktori publik saat dilihat pengguna lain. | Tetap tampil di banner profil pribadi dengan badge informatif jika nonaktif. | • [hero-overview.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/admin/profil-pengguna/partials/hero-overview.blade.php)<br>• [dashboard.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/dashboard.blade.php)<br>• `$user->getSetting('privacy.show_points')` |
| **A.2** | **Izinkan Tombol Suka Profil** (`privacy.allow_likes`) | • `Aktif (Default)`<br>• `Nonaktif (Sembunyikan)` | Pengguna lain tidak dapat menekan tombol *Like* (tombol dinonaktifkan dengan status privat). | Pemilik akun tetap dapat melihat total suka yang pernah terkumpul. | • [hero-overview.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/admin/profil-pengguna/partials/hero-overview.blade.php)<br>• [dashboard.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/dashboard.blade.php)<br>• `FriendshipController` |
| **A.3** | **Visibilitas Profil Pengguna** (`privacy.profile_visibility`) | • `Publik (Semua User)`<br>• `Hanya Teman Terhubung`<br>• `Privat (Hanya Admin)` | Mengatur siapa saja yang memiliki hak akses untuk membuka halaman detail profil dan riwayat aktivitas publik Anda. | Pemilik akun dan Superadmin selalu memiliki hak akses penuh ke profilnya. | • `ProfilPenggunaController`<br>• Middleware Otorisasi Profil |
| **A.4** | **Izin Permintaan Pertemanan** (`privacy.allow_friend_requests`) | • `Buka untuk Siapa Saja`<br>• `Hanya Teman dari Teman`<br>• `Tutup Permintaan Baru` | Pengguna lain di luar lingkaran tidak dapat menekan tombol "+ Tambah Teman" (muncul badge privat). | Pemilik akun tetap dapat menerima ajakan yang sudah ada dan mengelola daftar temannya. | • [dashboard.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/dashboard.blade.php)<br>• `FriendshipController@sendRequest` |
| **A.5** | **Izin Penerimaan Pesan Masuk** (`chat.who_can_message`) | • `Semua Pengguna`<br>• `Hanya Teman Terhubung`<br>• `Nonaktifkan Obrolan Baru` | Tombol kirim pesan dinonaktifkan atau disembunyikan bagi orang luar yang belum berteman. | Pemilik akun tetap dapat membuka ruang pesan dan membalas obrolan yang sudah berjalan. | • [dashboard.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/dashboard.blade.php)<br>• `MessagesController@sendMessage` |
| **A.6** | **Tanda Terima Baca (*Read Receipts*)** (`chat.read_receipts`) | • `Aktif (Centang Biru)`<br>• `Nonaktif (Privat)` | Lawan bicara tidak mendapatkan tanda centang ganda biru saat Anda membaca pesannya. | Pemilik akun tetap dapat membaca riwayat obrolan secara nyaman. | • `MessagesController@markAsRead`<br>• Chat Box Blade View |
| **A.7** | **Status Kehadiran / Terakhir Dilihat** (`chat.online_status_visibility`) | • `Semua Orang (Online)`<br>• `Hanya Teman`<br>• `Sembunyikan (Ghost Mode)` | Titik hijau *Online* disembunyikan dari kartu direktori dan kontak (Anda selalu tampil offline bagi orang lain). | Pemilik akun tetap mengetahui status koneksi perambannya sendiri. | • [dashboard.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/dashboard.blade.php)<br>• Realtime Presence Polling di `app.js` |

---

### ⚙️ Kategori B: Pengaturan Personal / Mandiri (*Personal Self-Preferences*)
Pengaturan ini hanya berdampak pada kenyamanan visual, audio, performa, dan keamanan sesi pada perangkat/browser pengguna itu sendiri:

| No | Nama Fitur / Opsi | Pilihan Nilai | Dampak Bagi Pengguna Sendiri | Implementasi Teknis di Kode |
|:---:|---|---|---|---|
| **B.1** | **Mode Tema Antarmuka** (`appearance.theme_mode`) | • `Light Mode (Terang)`<br>• `Dark Mode (Gelap)`<br>• `System (Otomatis OS)` | Menyesuaikan skema warna dashboard agar nyaman di mata saat bekerja siang atau malam hari. | • Kolom `user_configs.theme_mode`<br>• Atribut `data-bs-theme` pada tag `<html>` |
| **B.2** | **Gaya Menu Navigasi Samping** (`appearance.sidebar_style`) | • `Standar Terbuka`<br>• `Ringkas (Hover Expand)`<br>• `Ikon Saja (Mini View)` | Memberikan ruang kerja layar yang lebih lapang bagi laptop/komputer dengan resolusi kecil. | • Atribut `data-sidebar-size` di layout [vertical.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/layouts/vertical.blade.php) |
| **B.3** | **Kepadatan Tabel Data** (`appearance.table_density`) | • `Standar (Nyaman)`<br>• `Rapat (Compact View)` | Memaksimalkan jumlah baris data yang terlihat di layar tanpa banyak melakukan scrolling. | • Kelas CSS `.table-sm` / `.table-normal` |
| **B.4** | **Kurangi Efek Animasi** (`appearance.reduce_motion`) | • `Aktif (Animasi Lengkap)`<br>• `Hemat Daya (No Motion)` | Meringankan beban kerja kartu grafis (GPU) dan menghemat daya baterai laptop. | • Kelas CSS `.reduce-motion` pada `<body>` |
| **B.5** | **Suara Notifikasi Obrolan** (`chat.sound_alert`) | • `Pop Message`<br>• `Ding Soft`<br>• `Default Chime`<br>• `Mute (Hening)` | Nada audio sintetis Web Audio API yang berbunyi ketika ada pesan chat baru masuk ke dashboard. | • [profil-pengguna.js](file:///c:/laragon/finnally/repalogic-dashboard/public/assets/js/admin/profil-pengguna.js#L1073-L1155) via Web Audio API |
| **B.6** | **Perilaku Tombol Enter Chat** (`chat.send_on_enter`) | • `Enter = Kirim Pesan`<br>• `Shift + Enter = Kirim` | Kenyamanan pengetikan pesan panjang vs obrolan singkat responsif. | • Event listener `keydown` textarea chat |
| **B.7** | **Notifikasi Desktop Browser** (`notifications.browser_push`) | • Switch Toggle On/Off | Menampilkan pop-up pemberitahuan sistem di sudut layar saat aplikasi sedang diminimalkan. | • JavaScript `Notification.requestPermission()` |
| **B.8** | **Suara Lonceng Pemberitahuan** (`notifications.sound_chime`) | • Switch Toggle On/Off | Mengaktifkan bunyi lonceng (*chime*) lembut saat ada notifikasi umum baru di topbar. | • Script polling notifikasi di `notifications.blade.php` |
| **B.9** | **Filter Kategori Notifikasi** (`notifications.events.*`) | • ☑ `Pertemanan`<br>• ☑ `Suka Profil`<br>• ☑ `Pesan Masuk`<br>• ☑ `Keamanan Akun`<br>• ☑ `Pengumuman Global` | Pengguna hanya menerima notifikasi yang relevan dengan kebutuhan mereka tanpa terganggu notifikasi yang tidak diinginkan. | • Filter query `ActivityLog` & notifikasi polling |
| **B.10** | **Batas Waktu Layar Kunci** (`lock_screen.auto_lock_timeout`) | • `0 (Manual Saja)`<br>• `5 / 15 / 30 / 60 Menit` | Mengunci layar dashboard secara otomatis jika mouse/keyboard tidak ada aktivitas dalam waktu tertentu. | • Timer idle di script `lock-screen.js` |
| **B.11** | **Bahasa, Zona Waktu & Tanggal** (`localization.*`) | • Bahasa: `ID / EN`<br>• Zona: `WIB / WITA / WIT / UTC`<br>• Format: `DD/MM/YYYY`, dll | Menyesuaikan tampilan bahasa, jam log aktivitas, dan format tanggal sesuai kebiasaan pengguna. | • Middleware `LocalizationMiddleware`<br>• Carbon datetime helper |
| **B.12** | **Riwayat Aktivitas Saya** (Kluster 7) | • Tabel 15 Aktivitas Terkini | Menampilkan transparansi audit trail (waktu, modul, event, deskripsi, IP address). | • [tab-aktivitas-saya.blade.php](file:///c:/laragon/finnally/repalogic-dashboard/resources/views/admin/profil-pengguna/partials/tab-aktivitas-saya.blade.php)<br>• Model `ActivityLog` |

---

## 🗄️ 3. Skema Penyimpanan Basis Data (*Database Architecture*)

Seluruh konfigurasi mandiri profil pengguna disimpan ke dalam kolom JSON `settings` di tabel **`user_configs`**:

```json
{
  "chat": {
    "who_can_message": "everyone",
    "read_receipts": true,
    "online_status_visibility": "everyone",
    "sound_alert": "pop",
    "send_on_enter": true
  },
  "appearance": {
    "theme_mode": "light",
    "sidebar_style": "default",
    "table_density": "normal",
    "reduce_motion": false
  },
  "notifications": {
    "browser_push": true,
    "sound_chime": true,
    "events": {
      "friend_request": true,
      "profile_like": true,
      "chat_message": true,
      "security_alert": true,
      "global_announcement": true
    }
  },
  "privacy": {
    "profile_visibility": "public",
    "allow_likes": true,
    "show_points": true,
    "allow_friend_requests": "everyone"
  },
  "lock_screen": {
    "auto_lock_timeout": 15
  },
  "localization": {
    "locale": "id",
    "timezone": "Asia/Jakarta",
    "date_format": "DD/MM/YYYY"
  }
}
```

### Helper Method pada Model [`User.php`](../app/Models/User.php)
- `$user->getSetting('privacy.show_points', true)`: Mengambil nilai pengaturan tertentu dengan fallback nilai default.
- `$user->setSetting('privacy.show_points', false)`: Menyimpan atau memperbarui nilai pengaturan tertentu.
- `$user->getAllSettings()`: Mengembalikan seluruh array pengaturan terpadu beserta default yang telah di-merge.

---

## 📁 4. Struktur Folder Parsial (*Modular Partials Structure*)

Untuk kemudahan pemeliharaan dan skalabilitas, file Blade telah dipecah secara modular di dalam direktori `resources/views/admin/profil-pengguna/partials/`:

```
resources/views/admin/
├── profil-pengguna.blade.php           <-- Master View Orchestrator
└── profil-pengguna/
    └── partials/
        ├── hero-overview.blade.php             <-- Banner Foto Sampul, Avatar, Like & Poin
        ├── card-informasi-akun.blade.php       <-- Ringkasan Info Akun & WhatsApp
        ├── card-edit-profil-singkat.blade.php  <-- Form Edit Nama, Email, Password, Avatar
        ├── card-motto-hidup.blade.php          <-- Form Motto, Warna Teks & Randomizer
        ├── card-keamanan-2fa.blade.php         <-- Widget Two-Factor Authentication (2FA)
        ├── card-penonaktifan-akun.blade.php    <-- Danger Zone Permohonan Nonaktif Akun
        ├── widget-kelengkapan-profil.blade.php <-- Progress Bar Kelengkapan Profil (0-100%)
        ├── nav-tabs.blade.php                  <-- Tombol Navigasi 6 Tab Pengaturan
        ├── tab-identitas-dan-ktp.blade.php     <-- Tab 1: Form Identitas KTP & Berkas
        ├── tab-sampul-dan-tema.blade.php       <-- Tab 2: Foto Sampul & Tampilan UI
        ├── tab-pesan-dan-chat.blade.php        <-- Tab 3: Pengaturan Pesan & Obrolan
        ├── tab-notifikasi.blade.php            <-- Tab 4: Preferensi Web Push & Suara
        ├── tab-privasi-dan-sesi.blade.php      <-- Tab 5: Privasi, Lock Screen & Regional
        ├── tab-aktivitas-saya.blade.php        <-- Tab 6: Tabel Log Aktivitas Akun
        ├── modal-deactivation.blade.php        <-- Modal Dialog Alasan Nonaktif Akun
        ├── modal-preview-ktp.blade.php         <-- Modal Dialog Pratinjau Foto KTP
        ├── modal-crop-avatar.blade.php         <-- Modal Dialog Cropper.js Pemotong Foto
        └── modal-2fa.blade.php                 <-- Modal Dialog Setup 2FA & Recovery Codes
```

---

## 🔒 5. Keamanan & Audit Trail (*Security & Audit Trail*)

Setiap kali pengguna melakukan perubahan pengaturan melalui form preferensi mandiri:
1. Validasi dilakukan oleh `updateSettings(Request $request)` di [ProfilPenggunaController.php](file:///c:/laragon/finnally/repalogic-dashboard/app/Http/Controllers/Admin/ProfilPenggunaController.php).
2. Sistem otomatis mencatat entri log ke tabel `activity_logs` dengan deskripsi `"Memperbarui Preferensi & Pengaturan Mandiri Profil Pengguna"`, mencantumkan kluster yang diubah, waktu, alamat IP, dan User-Agent pengguna.
3. Notifikasi visual ditampilkan menggunakan standar SweetAlert2 helper global `window.showSuccess()`.
