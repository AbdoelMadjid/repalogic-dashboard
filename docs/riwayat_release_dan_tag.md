# 🏷️ Riwayat Release & Git Tag (Release History)

> **Lokasi File:** `docs/riwayat_release_dan_tag.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Versi Terbaru:** `v2.1.3`  
> **Terakhir Diperbarui:** 27 Agustus 2026  

---

## 📋 Tabel Riwayat Versi & Tag

Dokumentasi lengkap mengenai setiap versi rilis, git tag, dan ringkasan perubahan pada proyek **REPALOGIC Dashboard**.

| Tag / Versi | Tanggal Rilis | Deskripsi / Catatan Perubahan |
| :--- | :--- | :--- |
| **`v2.1.3`** | 2026-08-27 | Universal SweetAlert2 Notification Engine & Global Helpers, High-Contrast Checkbox SVG Fix, Multi-Select Filter Sync & Route Order Optimization |
| **`v2.1.2`** | 2026-08-27 | Overhaul & Refactoring Modul Fitur Aplikasi: Skema Dynamic Row CRUD, Instant AJAX Toggle, Bulk Group Action & Backward-Compatible Helper Object |
| **`v2.1.1`** | 2026-08-27 | Edit Avatar Pengguna, Tampilan Detail (user_details & user_configs), Restriksi Menu Sidenav, Notifikasi Khusus Superadmin/Admin & Perapian Estetika Validasi |
| **`v2.1.0`** | 2026-08-27 | Pembaruan Sistem Otentikasi, Idle Lock Screen, User Approval, Penonaktifan & Aktivasi Akun Mandiri, Notification Hub & Admin Reset |
| **`v2.0.0`** | 2026-08-27 | Engine Dinamisasi Tema & Seksi Website Terpusat, Crop Simulator & Arsitektur Partial Modular |
| **`v1.9.3`** | 2026-08-27 | Pemisahan Tabel Config User, Pengatur Posisi Sampul Interaktif, Motto Hidup & Widget Progress Kelengkapan Profil |
| **`v1.9.2`** | 2026-08-27 | Centralized Versioning Engine, Git Log Timestamps & Mandatory Changelog Standard (Rule 11) |
| **`v1.9.1`** | 2026-08-27 | Standarisasi Hirarki View Modul (Rule 10), Meta Title Engine & Refinement Sidenav Search UI |
| **`v1.9.0`** | 2026-08-27 | 100% Dynamic Bilingual Engine, Custom Menu Data-Lang & Modul Terjemahan Bahasa |
| **`v1.8.2`** | 2026-08-02 | Melengkapi halaman profil pengguna |
| **`v1.8.1`** | 2026-08-02 | Tambah halaman fitur aplikasi dan backup db di dukungan aplikasi |
| **`v1.8.0`** | 2026-08-02 | Tambah halaman role, permission, akses user, akses role dan user di Manajemen Pengguna |
| **`v1.7.0`** | 2026-08-01 | Perbaikan ngoding & optimalisasi struktur views |
| **`v1.6.0`** | 2026-08-01 | Bilingual Internationalization Engine (ID & EN) |
| **`v1.5.0`** | 2026-08-01 | Tabler & Lucide Full Icon Explorers |
| **`v1.4.0`** | 2026-08-01 | Documentation Module & Interactive Tree Engine |
| **`v1.3.0`** | 2026-08-01 | Layout Group Demo & Custom Pages Refactoring |
| **`v1.2.0`** | 2026-08-01 | Sidenav Auto-Scroll Centering & Component Group |
| **`v1.1.0`** | 2026-08-01 | Dynamic Navigation Config & Breadcrumb Engine |
| **`v1.0.0`** | 2026-08-01 | Initial Project Setup |

---

## 📌 Prosedur Pembaruan Rilis Versi Baru (Rule 11)

Setiap penambahan atau pembaruan fitur yang akan dirilis wajib mengikuti langkah-langkah berikut:
1. **Update `APP_VERSION`**: Ubah versi pada `.env`, `.env.example`, dan `config/app.php` (misal `v2.1.4`).
2. **Catat Changelog**: Tambahkan blok timeline baru pada `resources/views/template/documentation/changelog.blade.php` dengan timestamp WIB.
3. **Update Dokumen Rilis**: Tambahkan baris versi rilis baru pada tabel di atas (`docs/riwayat_release_dan_tag.md`).
4. **Git Commit & Tag**: Buat commit dan tag git, lalu push ke remote repository:
   ```bash
   git add .
   git commit -m "feat(modul): deskripsi rilis versi vX.Y.Z"
   git tag -a vX.Y.Z -m "Release vX.Y.Z: Deskripsi rilis..."
   git push origin main --tags
   ```
