# 📋 Rekomendasi Fitur & Pengaturan Profil Pengguna (User Profile & Account Settings)

> **Judul Dokumen:** Analisis Kelengkapan & Rekomendasi Penambahan Pengaturan Mandiri pada Profil Pengguna  
> **Lokasi File:** `docs/rekomendasi_pengaturan_profil_pengguna.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Status:** Usulan Rekomendasi & Rencana Peningkatan (*Roadmap Proposal*)  
> **Tanggal:** 07 Oktober 2026  

---

## 📑 1. Latar Belakang & Analisis Kondisi Saat Ini (*Current State Analysis*)

Halaman **Profil Pengguna (`/admin/profil-pengguna`)** saat ini telah memiliki fondasi fitur yang sangat baik, meliputi:
1. **Hero Overview Banner**: Menampilkan Avatar (dengan Cropper.js), Nama, Email, Peran, Poin Login, Suka Profil, Jumlah Teman, Foto Sampul Kustom, Efek Blur/Overlay, serta Motto Hidup dinamis.
2. **Informasi Akun & Edit Singkat**: Edit Nama, Email, dan Ubah Kata Sandi.
3. **Motto Hidup & Kustomisasi Warna**: Input motto dengan generator acak dan pemilih warna teks.
4. **Keamanan 2FA TOTP**: Integrasi Google Authenticator / Authy, QR code offline, kunci manual, dan 8 kode pemulihan (*recovery codes*).
5. **Permohonan Penonaktifan Akun (*Danger Zone*)**: Pengajuan penonaktifan akun ke administrator.
6. **Kelengkapan Data KTP & Alamat**: Formulir lengkap identitas kependudukan, alamat detail, dan unggah berkas KTP fisik beserta indikator kelengkapan (*Progress Bar* 0-100%).
7. **Pengaturan Foto Sampul Header**: Kustomisasi foto banner, tinggi banner, posisi vertikal, warna overlay, opasitas, dan tingkat blur.

### 🔍 Peluang Peningkatan
Seiring dengan berkembangnya modul-modul lain di REPALOGIC Dashboard (seperti **Fitur Pesan/Chat**, **Layar Kunci Otomatis**, **Notifikasi Realtime Polling**, **Sistem Pertemanan & Like Profil**, **Manajemen Bahasa/Bilingual Translation**, dan **Audit Trail Activity Log**), pengguna memerlukan **pusat kontrol preferensi mandiri (*Self-Service User Settings*)** yang tersentralisasi di halaman profil.

---

## 🎯 2. Matriks Rekomendasi Pengaturan Profil Pengguna

Berikut adalah 7 kluster pengaturan mandiri yang sangat disarankan untuk melengkapi modul Profil Pengguna:

```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                       7 KLUSTER PENGATURAN MANDIRI PROFIL PENGGUNA                          │
├──────────────────────────────┬──────────────────────────────┬───────────────────────────────┤
│ 1. Pesan & Obrolan (Chat)    │ 2. Keamanan & Layar Kunci    │ 3. Tampilan & Antarmuka (UI)  │
├──────────────────────────────┼──────────────────────────────┼───────────────────────────────┤
│ 4. Notifikasi & Suara        │ 5. Privasi & Interaksi Sosial│ 6. Bahasa & Regional (i18n)   │
├──────────────────────────────┴──────────────────────────────┴───────────────────────────────┤
│ 7. Log Aktivitas & Sesi Perangkat Aktif                                                     │
└─────────────────────────────────────────────────────────────────────────────────────────────┘
```

---

### 💬 Kluster 1: Pengaturan Pesan & Obrolan (*Messages & Chat Settings*)
Pengaturan ini memberikan kendali penuh kepada pengguna atas pengalaman berkomunikasi di fitur chat internal:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 1.1 | **Izin Penerimaan Pesan Masuk** (*Who Can Message Me*) | • `Semua Pengguna` *(Default)*<br>• `Hanya Teman yang Terhubung`<br>• `Nonaktifkan Obrolan Baru` | Mencegah pesan spam atau membatasi komunikasi hanya kepada rekan kerja/teman yang sudah dikonfirmasi. |
| 1.2 | **Tanda Terima Baca** (*Read Receipts / Centang Biru*) | • `Aktif (Tampilkan Jam Dibaca)`<br>• `Nonaktif (Privat / Sembunyikan)` | Mengontrol apakah lawan bicara dapat melihat saat pesan telah dibaca (`read_at`). |
| 1.3 | **Status Kehadiran / Terakhir Dilihat** (*Online Status & Last Seen*) | • `Semua Orang`<br>• `Hanya Teman`<br>• `Sembunyikan (Ghost Mode)` | Menjaga privasi waktu aktifitas kerja pengguna. |
| 1.4 | **Suara Notifikasi Obrolan** (*Chat Sound Alert*) | • `Default Chime`<br>• `Pop Message`<br>• `Ding Soft`<br>• `Mute (Tanpa Suara)` | Memberikan nada khusus saat pesan masuk ketika membuka dashboard. |
| 1.5 | **Perilaku Tombol Enter** (*Send on Enter*) | • `Enter = Kirim Pesan` *(Default)*<br>• `Shift + Enter = Kirim` *(Enter untuk baris baru)* | Kenyamanan pengetikan pesan panjang vs percakapan cepat. |
| 1.6 | **Daftar Kontak Diblokir** (*Blocked Users*) | Modal interaktif daftar pengguna yang diblokir + tombol `Buka Blokir` | Mengelola pemblokiran kontak yang mengganggu. |

---

### 🔐 Kluster 2: Keamanan Sesi & Layar Kunci (*Security & Lock Screen*)
Melengkapi fitur Two-Factor Authentication (2FA) yang sudah ada:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 2.1 | **Batas Waktu Layar Kunci Otomatis** (*Auto Lock Screen Timeout*) | • `Nonaktif (Manual Saja)`<br>• `5 Menit Tidak Aktif`<br>• `15 Menit Tidak Aktif`<br>• `30 Menit Tidak Aktif`<br>• `1 Jam Tidak Aktif` | Otomatis mengunci dashboard jika pengguna meninggalkan komputer tanpa logout. |
| 2.2 | **PIN Cepat Buka Layar Kunci** (*Quick Unlock PIN*) | Input 6-Digit PIN rahasia (Tersimpan *Hashed*) | Membuka modal lock-screen secara cepat tanpa perlu mengetik ulang kata sandi panjang. |
| 2.3 | **Manajemen Sesi Perangkat Aktif** (*Active Devices & Sessions*) | Tabel daftar sesi login (Perangkat, OS, Browser, IP Address, Waktu Aktif, Status "Sesi Ini") + Tombol `Keluarkan Dari Sesi Lain` | Memastikan tidak ada akses akun dari perangkat asing/tidak dikenal. |

---

### 🎨 Kluster 3: Preferensi Tampilan & Antarmuka (*Appearance & UI Preferences*)
Menyesuaikan tampilan dashboard sesuai kenyamanan visual masing-masing individu:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 3.1 | **Mode Tema Antarmuka** (*Theme Mode*) | • `Mode Terang (Light)`<br>• `Mode Gelap (Dark)`<br>• `Otomatis (Ikuti Sistem OS)` | Menyesuaikan kecerahan layar untuk kenyamanan mata saat bekerja siang/malam. |
| 3.2 | **Tampilan Menu Samping** (*Sidebar Navigation Style*) | • `Standar Terbuka (Default)`<br>• `Ringkas / Compact (Hover to Expand)`<br>• `Ikon Saja (Icon-Only Mini)` | Memberikan ruang kerja layar yang lebih lapang bagi pengguna dengan layar laptop kecil. |
| 3.3 | **Kepadatan Tabel Data** (*Table Density*) | • `Standar (Nyaman / Default)`<br>• `Rapat (Compact View)` | Memaksimalkan jumlah baris data yang terlihat di layar tanpa banyak scrolling. |
| 3.4 | **Efek Animasi Antarmuka** (*Reduce Motion*) | • `Aktif (Animasi Lengkap)`<br>• `Hemat / Ringan (Kurangi Animasi)` | Meningkatkan performa bagi perangkat berspesifikasi rendah. |

---

### 🔔 Kluster 4: Preferensi Notifikasi & Pemberitahuan (*Notification Alerts*)
Mengontrol kanal dan frekuensi pemberitahuan yang diterima:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 4.1 | **Notifikasi Desktop Browser** (*Web Push Notifications*) | Switch Toggle + Tombol `Minta Izin Notifikasi Browser` | Menampilkan pop-up notifikasi sistem di pojok layar komputer saat tab sedang di-minimize. |
| 4.2 | **Suara Lonceng Pemberitahuan** (*System Notification Chime*) | Switch Toggle On/Off | Menghidupkan/mematikan bunyi bel lonceng topbar saat ada notifikasi baru. |
| 4.3 | **Filter Kategori Pemberitahuan** (*Notification Preferences*) | Checkbox Pilihan:<br>☑ `Permintaan Pertemanan Baru`<br>☑ `Suka Profil Baru`<br>☑ `Pesan Chat Masuk`<br>☑ `Aktivitas Keamanan Akun`<br>☑ `Pengumuman Sistem Global` | Pengguna hanya menerima notifikasi yang relevan dengan kebutuhan mereka. |

---

### 🛡️ Kluster 5: Privasi Profil & Interaksi Sosial (*Social & Privacy*)
Memberikan kebebasan dalam interaksi komunitas internal:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 5.1 | **Visibilitas Profil Pengguna** (*Profile Visibility*) | • `Publik (Semua Pengguna Terdaftar)`<br>• `Hanya Teman Terhubung`<br>• `Privat (Hanya Administrator)` | Mengatur siapa saja yang dapat melihat halaman detail profil dan riwayat pengguna. |
| 5.2 | **Izin Suka Profil** (*Allow Profile Likes*) | Switch Toggle On/Off | Mengizinkan atau menyembunyikan tombol "Suka Profil" dari pengguna lain. |
| 5.3 | **Tampilkan Poin Login & Badge Prestasi** | Switch Toggle On/Off | Menampilkan / menyembunyikan badge akumulasi poin login di banner profil. |
| 5.4 | **Izin Permintaan Pertemanan** (*Friend Requests*) | • `Buka untuk Siapa Saja`<br>• `Hanya Teman dari Teman`<br>• `Tutup Permintaan Baru` | Mengontrol penerimaan relasi pertemanan baru. |

---

### 🌐 Kluster 6: Preferensi Bahasa & Format Regional (*Localization & Regional Settings*)
Terintegrasi langsung dengan modul kamus multi-bahasa yang sudah ada di sistem:

| No | Pengaturan / Opsi | Pilihan Nilai | Dampak & Kegunaan |
|---|---|---|---|
| 6.1 | **Bahasa Antarmuka Pengguna** (*User Language*) | • `🇮🇩 Bahasa Indonesia (id)` *(Default)*<br>• `🇬🇧 English (en)` | Mengubah bahasa seluruh label menu, form, tombol, dan pesan alert secara instan per pengguna. |
| 6.2 | **Pilihan Zona Waktu** (*Timezone*) | • `Asia/Jakarta (WIB - UTC+7)`<br>• `Asia/Makassar (WITA - UTC+8)`<br>• `Asia/Jayapura (WIT - UTC+9)`<br>• `UTC` | Menyesuaikan tampilan timestamp transaksi, log login, dan pesan chat sesuai wilayah kerja. |
| 6.3 | **Format Tampilan Tanggal** (*Date Format*) | • `DD/MM/YYYY` (Contoh: 07/10/2026)<br>• `YYYY-MM-DD` (Contoh: 2026-10-07)<br>• `DD MMMM YYYY` (Contoh: 07 Oktober 2026) | Menyesuaikan kebiasaan membaca tanggal masing-masing pengguna. |

---

### 📜 Kluster 7: Riwayat Aktivitas Pribadi & Keamanan Akun (*Personal Activity Log*)
Fitur transparansi bagi pengguna untuk memantau keamanan akun mereka sendiri:

| No | Fitur / Komponen | Tampilan / Fungsi | Dampak & Kegunaan |
|---|---|---|---|
| 7.1 | **Tab Riwayat Aktivitas Saya** (*My Recent Activity*) | Tabel 15-20 aktivitas terbaru: Tanggal/Jam, Modul, Tindakan (Login, Ubah Profil, Ubah Password, Kirim Pesan), Status, dan IP Address. | Pengguna dapat mengaudit aktivitas akunnya secara mandiri tanpa harus meminta log ke administrator. |
| 7.2 | **Peringatan Percobaan Login Gagal** (*Security Alerts*) | Notifikasi banner jika terdapat riwayat gagal login dengan kata sandi salah pada akun pengguna. | Mendeteksi sedini mungkin jika ada pihak lain yang mencoba menebak kata sandi akun. |

---

## 🏗️ 3. Rekomendasi Arsitektur Data & Penyimpanan (*Technical Architecture*)

Untuk menjaga performa dan kesederhanaan struktur basis data, **tidak perlu membuat banyak tabel baru**. Seluruh preferensi personal di atas dapat disimpan secara efisien pada:

### 3.1 Skema Kolom JSON di Tabel `user_configs` (Sudah Ada)
Tabel [`user_configs`](../app/Models/UserConfig.php) telah memiliki kolom `settings` (JSON) yang siap digunakan untuk menyimpan *key-value* konfigurasi pengguna:

```json
{
  "chat": {
    "who_can_message": "everyone",
    "read_receipts": true,
    "online_status_visibility": "everyone",
    "sound_alert": "pop",
    "send_on_enter": true,
    "blocked_users": []
  },
  "lock_screen": {
    "auto_lock_timeout": 15,
    "quick_pin_enabled": true,
    "quick_pin_hash": "$2y$12$..."
  },
  "appearance": {
    "theme_mode": "system",
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
      "security_alert": true
    }
  },
  "privacy": {
    "profile_visibility": "public",
    "allow_likes": true,
    "show_points": true,
    "allow_friend_requests": true
  },
  "localization": {
    "locale": "id",
    "timezone": "Asia/Jakarta",
    "date_format": "DD/MM/YYYY"
  }
}
```

### 3.2 Trait Helper `HasUserSettings` pada Model `User`
Membuat trait atau method pembantu pada model `User`:
- `$user->getSetting('chat.read_receipts', true)`
- `$user->setSetting('chat.sound_alert', 'pop')`
- `$user->isUserBlocked($targetUserId)`

---

## 🖥️ 4. Rekomendasi Tata Letak Antarmuka (*UI/UX Layout Proposal*)

Agar halaman Profil Pengguna tidak terasa padat atau membingungkan, disarankan membagi area utama menjadi **Tab Navigasi Bebas Hashtag (Sesuai Aturan Baku Rule 17 & 18)**:

```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│ HERO OVERVIEW BANNER (Avatar Cropper, Cover Header, Poin, Teman, Suka, Motto)               │
├─────────────────────────────────────────────────────────────────────────────────────────────┤
│ TAB NAVIGASI PROFIL (Button Data-BS-Target, Responsive Mobile Icon+Badge):                  │
│ [ 🪪 Identitas & KTP ]  [ 💬 Pesan & Privasi ]  [ 🔔 Notifikasi & UI ]  [ 🔐 Keamanan & Sesi ]  [ 📜 Aktivitas Saya ] │
├─────────────────────────────────────────────────────────────────────────────────────────────┤
│ KONTEN AKTIF TAB:                                                                           │
│ - Menampilkan form dan kontrol yang rapi sesuai kluster pengaturan di atas.                 │
│ - Menggunakan komponen switch toggle Bootstrap 5 native (Rule 22: Zero Redundant CSS).     │
│ - Tombol simpan dengan konfirmasi SweetAlert2 (Rule 9).                                    │
└─────────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 📌 5. Rekomendasi Skala Prioritas Implementasi (*Implementation Priority Roadmap*)

| Tahap | Kluster Fitur | Tingkat Kesulitan | Dampak Pengguna |
|---|---|---|---|
| 🟢 **Tahap 1 (Quick Win)** | • **Pengaturan Pesan & Obrolan** (Read Receipts, Online Status, Chat Sound)<br>• **Pengaturan Layar Kunci** (Auto Lock Timeout)<br>• **Pengaturan Bahasa & Format Tanggal** | Rendah - Sedang | ⭐⭐⭐⭐⭐ (Sangat Terasa Langsung) |
| 🔵 **Tahap 2 (Social & UI)** | • **Privasi Sosial & Profil** (Like toggle, Friend request toggle)<br>• **Preferensi Tampilan** (Sidebar style, Theme mode)<br>• **Notifikasi Browser & Suara** | Sedang | ⭐⭐⭐⭐ (Meningkatkan Kenyamanan) |
| 🟣 **Tahap 3 (Advanced Security)** | • **Manajemen Sesi Perangkat Aktif** (Revoke Sessions)<br>• **PIN Cepat Layar Kunci**<br>• **Tab Log Aktivitas Saya** | Sedang - Lanjutan | ⭐⭐⭐⭐⭐ (Keamanan Tingkat Lanjut) |

---

## 🏁 6. Kesimpulan

Penambahan pengaturan-pengaturan di atas akan mengubah modul **Profil Pengguna** dari sekadar form pengisian biodata menjadi **Pusat Kendali Pengguna Terpadu (*Unified User Control Center*)** yang modern, aman, dan sangat fleksibel sesuai kebutuhan masing-masing pengguna di ekosistem **REPALOGIC Dashboard**.
