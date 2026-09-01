# 🌐 Dokumentasi Arsitektur & Operasional Sistem Bilingual (Internationalization i18n)

> **Status Modul:** Production-Ready (Enterprise Grade)  
> **Lokasi File Dokumentasi:** `docs/arsitektur_dan_operasional_bilingual.md`  
> **Route URL:** `/admin/dukunganaplikasi/translation`  
> **Controller:** `App\Http\Controllers\Admin\DukunganAplikasi\TranslationController`  
> **Berkas Kamus:** `public/assets/data/translations/id.json` & `en.json`  
> **Versi Rilis:** `v2.4.0`  
> **Terakhir Diperbarui:** 1 September 2026 21:15 WIB  

---

## 📋 1. Pendahuluan & Ringkasan Modul

Modul **Sistem Bilingual (*Internationalization & Translation Engine*)** pada REPALOGIC Dashboard dirancang sebagai arsitektur multi-bahasa terpadu dua arah (Bahasa Indonesia `ID` dan Bahasa Inggris `EN`).

Sistem ini memungkinkan alih bahasa antarmuka secara **100% dinamis dan instan tanpa reload halaman** (*zero page reload*) pada seluruh elemen navigasi sidebar, judul modul, header grup, dan label komponen dengan memanfaatkan pasangan **Atribut `data-lang`** dan **Kamus JSON Terjemahan**.

```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                            HUB ENGINE BILINGUAL & TERJEMAHAN                                │
├──────────────────────────────┬──────────────────────────────┬───────────────────────────────┤
│ 1. Kamus JSON Berjenjang     │ 2. Real-Time DOM Swapper     │ 3. Auto-Sync Model Listener   │
│ (id.json & en.json Storage)  │ (Client-side i18n Engine)    │ (Menu::saved -> Dictionary)   │
├──────────────────────────────┼──────────────────────────────┼───────────────────────────────┤
│ 4. Admin Translation Manager │ 5. Artisan CLI Code Scanner  │ 6. Safe Fallback Guarantee    │
│ (Live CRUD Key & Values)     │ (php artisan menu:lang-sync) │ (Graceful Database Fallback)  │
└──────────────────────────────┴──────────────────────────────┴───────────────────────────────┘
```

---

## 🏛️ 2. Arsitektur Inti & Alur Kerja Internasionalisasi

Sistem bilingual bekerja melalui integrasi antara sisi Backend (Laravel & JSON storage) dan sisi Frontend (Topbar Language Selector & DOM Translation Swapper).

```mermaid
flowchart TD
    subgraph A [1. Pendaftaran & Penyimpanan Kamus]
        MenuForm[Admin Menambah / Mengubah Menu] --> ModelHook[Menu::saved Lifecycle Listener]
        ModelHook --> AutoSync[syncTranslationKey: Daftarkan ke id.json & en.json]
        AdminTrans[Admin Buka /admin/dukunganaplikasi/translation] --> LiveCRUD[Live CRUD Key, Teks ID & EN]
        LiveCRUD --> SaveJSON[Simpan ke public/assets/data/translations/*.json]
    end

    subgraph B [2. Rendering Markup Blade]
        ViewComp[SidebarComposer & Blade Views] --> InjectAttr[Sematkan Atribut data-lang='...']
        InjectAttr --> DOMReady[DOM Selesai Dimuat di Browser]
    end

    subgraph C [3. Pengalihan Bahasa di Antarmuka]
        UserClick[Pengguna Klik Bendera Topbar: ID / EN] --> JSApp[app.js: Translator Engine]
        JSApp --> FetchDict[Ambil Kamus id.json atau en.json dari Cache/Server]
        FetchDict --> QueryDOM[Query Seluruh Elemen [data-lang]]
        QueryDOM --> SwapText[Ganti innerText Elemen Sesuai Kamus]
        SwapText --> SavePref[Simpan Bahasa Terpilih ke localStorage]
    end
```

---

## 📂 3. Struktur Berkas Kamus Terjemahan

Kamus terjemahan disimpan dalam format JSON terstruktur yang telah ter-indeks secara alfabetis (*ksort*):

### 3.1 Berkas `public/assets/data/translations/id.json`
```json
{
  "akses-role": "Akses Role",
  "akses-user": "Akses User",
  "backup-db": "Backup DB",
  "fitur-aplikasi": "Fitur Aplikasi",
  "konfigurasi-website": "Konfigurasi Website",
  "manajemen-pengguna": "Manajemen Pengguna",
  "menu": "Manajemen Menu",
  "profil-aplikasi": "Profil Aplikasi",
  "profil-pengguna": "Profil Pengguna",
  "terjemahan-bahasa": "Terjemahan Bahasa",
  "user": "Pengguna"
}
```

### 3.2 Berkas `public/assets/data/translations/en.json`
```json
{
  "akses-role": "Role Access",
  "akses-user": "User Access",
  "backup-db": "Database Backup",
  "fitur-aplikasi": "Application Features",
  "konfigurasi-website": "Website Configuration",
  "manajemen-pengguna": "User Management",
  "menu": "Menu Management",
  "profil-aplikasi": "Application Profile",
  "profil-pengguna": "User Profile",
  "terjemahan-bahasa": "Language Translation",
  "user": "Users"
}
```

---

## ⚙️ 4. Arsitektur Backend & Siklus Hidup Permintaan

Seluruh operasi manajemen kamus bahasa dikendalikan oleh Controller [`TranslationController.php`](../app/Http/Controllers/Admin/DukunganAplikasi/TranslationController.php).

### 4.1 Daftar Endpoint API Modul

| HTTP Method | Route URI | Nama Route | Fungsi & Deskripsi |
| :---: | :--- | :--- | :--- |
| `GET` | `/admin/dukunganaplikasi/translation` | `admin.dukunganaplikasi.translation.index` | Menampilkan tabel manajemen terjemahan dengan filter kategori sidebar dan pencarian live. |
| `POST` | `/admin/dukunganaplikasi/translation` | `admin.dukunganaplikasi.translation.store` | Menambahkan key terjemahan baru ke berkas `id.json` dan `en.json`. |
| `PUT / PATCH` | `/admin/dukunganaplikasi/translation/{key}` | `admin.dukunganaplikasi.translation.update` | Memperbarui nama key atau nilai teks terjemahan ID & EN. |
| `DELETE` | `/admin/dukunganaplikasi/translation/{key}` | `admin.dukunganaplikasi.translation.destroy` | Menghapus key terjemahan dari kedua berkas JSON. |

### 4.2 Auto-Sync Model Lifecycle Hook ([`Menu.php`](../app/Models/Admin/DukunganAplikasi/Menu.php))

Ketika suatu menu dibuat atau diperbarui di database, sistem secara otomatis mengeksekusi method `syncTranslationKey()`:

```php
// app/Models/Admin/DukunganAplikasi/Menu.php
public static function syncTranslationKey(Menu $menu): void
{
    $dataLang = $menu->data_lang ?: Str::slug($menu->name);
    if (empty($dataLang)) return;

    $idPath = public_path('assets/data/translations/id.json');
    $enPath = public_path('assets/data/translations/en.json');

    // 1. Baca data JSON yang ada
    // 2. Jika key belum ada, otomatis daftarkan teks ID ($menu->name)
    // 3. Otomatis terjemahkan teks EN menggunakan kamus getEnglishDefault()
    // 4. Tulis kembali berkas dengan JSON_PRETTY_PRINT & ksort
}
```

---

## ⌨️ 5. Perintah Artisan CLI Sinkronisasi Kode (`MenuLangSync`)

Tersedia perintah Artisan CLI khusus untuk memindai seluruh direktori proyek (`app`, `config`, `resources`, `routes`, `database`) guna menemukan pemanggilan `@lang('menu.*')`, `__('menu.*')`, dan atribut `data_lang`:

```bash
# Menjalankan pemindaian dan sinkronisasi otomatis
php artisan menu:lang-sync

# Menjalankan dry-run untuk melihat perubahan tanpa mengubah file
php artisan menu:lang-sync --dry-run

# Menjalankan pemindaian pada direktori tertentu
php artisan menu:lang-sync --scan=app,resources,config
```

---

## 🎨 6. Arsitektur Frontend & Topbar Language Switcher

### 6.1 Komponen Dropdown Bahasa Topbar ([`language-selector.blade.php`](../resources/views/layouts/partials/topbar/language-selector.blade.php))

```html
<div id="language-selector" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button">
            <img src="/assets/images/flags/id.svg" alt="flag" class="rounded me-2" height="18" id="selected-language-image" />
            <span id="selected-language-code">ID</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="id">
                <img src="/assets/images/flags/id.svg" class="me-1 rounded" height="18" /> Indonesia
            </a>
            <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en">
                <img src="/assets/images/flags/us.svg" class="me-1 rounded" height="18" /> English
            </a>
        </div>
    </div>
</div>
```

### 6.2 Mekanisme Client-Side i18n DOM Engine
1. Saat halaman dimuat, sistem membaca preferensi bahasa dari `localStorage.getItem('repalogic_lang') || 'id'`.
2. Ketika pengguna mengklik item bahasa (`[data-translator-lang]`), fungsi translator:
   - Memuat berkas kamus target secara asynchronous (`assets/data/translations/{lang}.json`).
   - Melakukan iterasi ke seluruh elemen DOM yang memiliki atribut `[data-lang]`.
   - Mengganti teks konten dengan padanan dari kamus JSON.
   - Memperbarui icon bendera dan label bahasa pada topbar.
   - Menyimpan pilihan ke `localStorage` agar bahasa tetap konsisten saat berpindah halaman.

---

## 🛡️ 7. Garansi Keamanan Tampilan (*Safe Fallback Mechanism*)

Sistem bilingual dilengkapi dengan mekanisme perlindungan tampilan berlapis:

```
┌─────────────────────────────────────────────────────────────────────────────────────────┐
│                           HIERARKI RESOLUSI TEKS BILINGUAL                              │
├─────────────────────────────────────────────────────────────────────────────────────────┤
│ Tingkat 1: Teks dari Kamus JSON (id.json / en.json) berdasarkan [data-lang]             │
│            ↓ (Jika key belum terdaftar di JSON)                                         │
│ Tingkat 2: Nilai Asli dari Database (Menu->name) yang di-render oleh Blade             │
│            ↓ (Jika menu bertipe template config statis)                                 │
│ Tingkat 3: Default Text / Config Title bawaan template                                 │
└─────────────────────────────────────────────────────────────────────────────────────────┘
```

> **Keunggulan:** Jika Administrator baru saja menambahkan menu baru dan belum sempat mendaftarkan kata terjemahannya, **tampilan navigasi tidak akan pernah kosong atau menampilkan error `NaN` / `undefined`**, melainkan tetap menampilkan teks asli menu database.

---

## 📑 8. Panduan Operasional & Pemecahan Masalah (Troubleshooting)

### 8.1 Panduan Langkah Demi Langkah

#### A. Menambahkan Kata Terjemahan Baru:
1. Buka **Dukungan Aplikasi > Terjemahan Bahasa** (`/admin/dukunganaplikasi/translation`).
2. Klik tombol **`+ Tambah Key Terjemahan`**.
3. Masukkan **Key Terjemahan (Slug)** (misal: `laporan-tahunan`).
4. Masukkan teks **Bahasa Indonesia** (misal: `Laporan Tahunan`).
5. Masukkan teks **Bahasa Inggris** (misal: `Annual Report`).
6. Klik **Simpan Terjemahan**. Berkas `id.json` & `en.json` di server langsung terbarui seketika!

#### B. Mengaitkan Key Terjemahan ke Menu:
1. Buka **Dukungan Aplikasi > Menu** (`/admin/dukunganaplikasi/menu`).
2. Saat membuat/mengedit menu, isi kolom **Translation Key (Data Lang)** dengan slug yang sama (misal: `laporan-tahunan`).
3. Simpan menu. Menu tersebut kini otomatis berubah saat bendera topbar diklik!

---

### 8.2 Pemecahan Masalah (Troubleshooting)

| Gejala Masalah | Penyebab Umum | Solusi Perbaikan |
| :--- | :--- | :--- |
| **Teks tidak berubah saat bendera diklik** | Elemen HTML tidak memiliki atribut `data-lang="key"` atau key tidak cocok dengan `id.json`/`en.json`. | Pastikan atribut `data-lang` terpasang pada elemen HTML dan key terdaftar pada modul Terjemahan Bahasa. |
| **Bahasa kembali ke Indonesia setelah refresh** | LocalStorage dinonaktifkan di peramban pengguna atau cache browser korup. | Periksa izin LocalStorage pada peramban web dan bersihkan cache aplikasi. |
| **Key terjemahan baru tidak muncul di tabel** | Berkas `id.json` / `en.json` tidak memiliki izin tulis (*write permission*). | Pastikan direktori `public/assets/data/translations/` memiliki izin tulis (CHMOD `775` / `777`). |

---

> 📌 **Dokumentasi ini dikelola secara resmi oleh Tim Pengembang REPALOGIC Dashboard.**  
> *Setiap penambahan key modul baru atau perubahan engine i18n wajib memperbarui berkas ini.*
