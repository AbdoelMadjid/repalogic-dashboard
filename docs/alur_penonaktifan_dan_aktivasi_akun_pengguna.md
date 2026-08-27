# Dokumentasi Alur Penonaktifan Mandiri & Aktivasi Kembali Akun Pengguna (Account Lifecycle Management)

> **Status Sistem:** Production-Ready (Enterprise Grade)  
> **Lokasi File Dokumentasi:** `docs/alur_penonaktifan_dan_aktivasi_akun_pengguna.md`  
> **Terakhir Diperbarui:** 27 Agustus 2026  

---

## 📋 1. Pendahuluan & Ringkasan Eksekutif

Sistem **Siklus Hidup Akun Pengguna (*User Account Lifecycle Management*)** dirancang untuk memberikan kendali transparan dan aman bagi pengguna yang ingin menonaktifkan akunnya secara mandiri (*self-service deactivation*), sekaligus menyediakan mekanisme terstruktur bagi akun nonaktif (*inactive*) untuk mengajukan permohonan aktivasi kembali (*account reactivation*) kepada Administrator.

Arsitektur ini menerapkan prinsip **Verifikasi & Persetujuan Administrator Terpusat (*Admin-Assisted Lifecycle Control*)**:
1. Pengguna aktif dapat mengajukan permohonan penonaktifan akun melalui menu **Profil Pengguna** (`admin/profil-pengguna`) pada zona bahaya (*Danger Zone*).
2. Pengajuan permohonan penonaktifan otomatis memicu notifikasi real-time pada **Pusat Notifikasi Topbar Administrator** dengan badge merah **"Minta Nonaktif"**.
3. Administrator meninjau dan mengeksekusi penonaktifan akun pada tabel **Manajemen Pengguna** (`admin/manajemenpengguna/users`) melalui tombol **"Nonaktifkan"**.
4. Pengguna yang akunnya dinonaktifkan tidak dapat masuk (*login*) ke sistem dan disajikan banner peringatan interaktif beserta tombol tindakan langsung menuju halaman pengajuan aktivasi (`/request-activation`).
5. Pengajuan aktivasi kembali akun diverifikasi oleh Administrator melalui notifikasi badge hijau **"Minta Aktivasi"** dan tombol **"Aktifkan"** pada tabel admin.

---

## 🔄 2. Diagram Alur Kerja Siklus Hidup Akun (Workflow Diagram)

```mermaid
flowchart TD
    subgraph Fase_1 [Fase 1: Permohonan Penonaktifan Akun (User Aktif)]
        A[Pengguna Aktif Masuk ke /admin/profil-pengguna] --> B[Scroll ke Zona Bahaya di Bawah Data KTP]
        B --> C[Klik Tombol 'Minta Nonaktifkan Akun']
        C --> D[Isi Alasan Penonaktifan pada Modal Form]
        D --> E[Submit ke ProfilPenggunaController@requestDeactivation]
        E --> F[Update DB: deactivation_requested_at=now, deactivation_reason=text]
        F --> G[Tampilkan Banner Status Pengajuan Kuning & Tombol Batalkan]
    end

    subgraph Fase_2 [Fase 2: Eksekusi Penonaktifan oleh Administrator]
        F --> H[NotificationService Mendeteksi deactivation_requested_at]
        H --> I[Lonceng Topbar Admin Menampilkan Badge Merah 'Minta Nonaktif']
        I --> J[Admin Klik Notifikasi Topbar -> Buka users?search=Nama]
        J --> K[Tabel Admin Menampilkan Badge 'Minta Nonaktif' & Tombol Merah 'Nonaktifkan']
        K --> L[Admin Klik Tombol 'Nonaktifkan' + Konfirmasi SweetAlert2]
        L --> M[Update DB: status='inactive', deactivation_requested_at=null]
    end

    subgraph Fase_3 [Fase 3: Pengajuan Aktivasi Kembali (User Nonaktif)]
        M --> N[Pengguna Nonaktif Coba Login di /login]
        N --> O[Login Gagal: Muncul Banner Merah 'Akun Dinonaktifkan']
        O --> P[Pengguna Klik Tombol 'Ajukan Permohonan Aktivasi Akun']
        P --> Q[Buka Halaman Publik /request-activation]
        Q --> R[Input Email Terdaftar & Catatan Permohonan Aktivasi]
        R --> S[Submit ke AccountReactivationController@store]
        S --> T[Update DB: reactivation_requested_at=now, reactivation_reason=text]
        T --> U[Redirect ke /login dengan Banner Sukses Hijau]
    end

    subgraph Fase_4 [Fase 4: Persetujuan Aktivasi oleh Administrator]
        T --> V[NotificationService Mendeteksi reactivation_requested_at]
        V --> W[Lonceng Topbar Admin Menampilkan Badge Hijau 'Minta Aktivasi']
        W --> X[Admin Klik Notifikasi Topbar -> Buka users?search=Nama]
        X --> Y[Tabel Admin Menampilkan Badge 'Minta Aktivasi' & Tombol Hijau 'Aktifkan']
        Y --> Z[Admin Klik Tombol 'Aktifkan' + Konfirmasi SweetAlert2]
        Z --> AA[Update DB: status='active', reactivation_requested_at=null]
        AA --> AB([Akun Berhasil Aktif Kembali & Pengguna Dapat Login])
    end
```

---

## 🗄️ 3. Arsitektur Database & Schema Metadata

### 3.1 Perubahan Schema pada Tabel `users`
Dukungan siklus hidup penonaktifan dan aktivasi akun didukung oleh migrasi database:
1. `database/migrations/2026_08_27_090000_add_deactivation_requested_at_to_users_table.php`
2. `database/migrations/2026_08_27_093000_add_reactivation_requested_at_to_users_table.php`

```sql
ALTER TABLE `users`
  ADD `deactivation_requested_at` TIMESTAMP NULL AFTER `password_reset_requested_at`,
  ADD `deactivation_reason` TEXT NULL AFTER `deactivation_requested_at`,
  ADD `reactivation_requested_at` TIMESTAMP NULL AFTER `deactivation_reason`,
  ADD `reactivation_reason` TEXT NULL AFTER `reactivation_requested_at`;
```

### 3.2 Metadata Kolom & Fungsinya

| Nama Kolom | Tipe Data | Nullable | Keterangan & Fungsi |
| :--- | :--- | :--- | :--- |
| `status` | `enum('pending','active','inactive')` | Tidak (`default: 'active'`) | Status operasional akun pengguna. |
| `deactivation_requested_at` | `timestamp` | Ya | Waktu pengguna mengajukan permohonan penonaktifan akun. |
| `deactivation_reason` | `text` | Ya | Alasan/catatan penonaktifan yang dituliskan oleh pengguna. |
| `reactivation_requested_at` | `timestamp` | Ya | Waktu pengguna nonaktif mengajukan permohonan aktivasi kembali. |
| `reactivation_reason` | `text` | Ya | Alasan/catatan permohonan pengaktifan kembali akun. |

---

## 🧩 4. Rincian Implementasi Kode & Logika Controller

### 4.1 Model User ([app/Models/User.php](file:///f:/laragon/finaly/repalogic-dashboard/app/Models/User.php))
Model `User` dilengkapi helper method untuk mendeteksi status permohonan secara ekspresif:

```php
// Cek apakah akun sedang mengajukan penonaktifan
public function isDeactivationRequested(): bool
{
    return !is_null($this->deactivation_requested_at);
}

// Cek apakah akun sedang mengajukan aktivasi kembali
public function isReactivationRequested(): bool
{
    return !is_null($this->reactivation_requested_at);
}
```

---

### 4.2 Sisi Pengguna Aktif: Profil Pengguna ([ProfilPenggunaController.php](file:///f:/laragon/finaly/repalogic-dashboard/app/Http/Controllers/Admin/ProfilPenggunaController.php))

1. **Pengajuan Permohonan Nonaktif:**
   ```php
   public function requestDeactivation(Request $request)
   {
       $user = auth()->user();
       $request->validate(['reason' => 'nullable|string|max:500']);

       $user->update([
           'deactivation_requested_at' => now(),
           'deactivation_reason' => $request->input('reason'),
       ]);

       $this->notifySuccess('Permintaan penonaktifan akun berhasil dikirimkan ke Administrator.', 'Permintaan Terkirim');
       return redirect()->route('admin.profil-pengguna.index');
   }
   ```

2. **Pembatalan Permohonan Nonaktif Mandiri:**
   ```php
   public function cancelDeactivation()
   {
       $user = auth()->user();
       $user->update([
           'deactivation_requested_at' => null,
           'deactivation_reason' => null,
       ]);

       $this->notifySuccess('Permintaan penonaktifan akun berhasil dibatalkan.', 'Dibatalkan');
       return redirect()->route('admin.profil-pengguna.index');
   }
   ```

---

### 4.3 Sisi Pengguna Nonaktif: Pengajuan Aktivasi ([AccountReactivationController.php](file:///f:/laragon/finaly/repalogic-dashboard/app/Http/Controllers/Auth/AccountReactivationController.php))

1. **Form Publik:** `GET /request-activation` (`auth.request-activation`).
2. **Pemrosesan Permohonan:**
   ```php
   public function store(Request $request): RedirectResponse
   {
       $request->validate([
           'email' => ['required', 'email'],
           'reason' => ['nullable', 'string', 'max:500'],
       ]);

       $user = User::where('email', $request->email)->first();

       if (!$user) {
           throw ValidationException::withMessages([
               'email' => ['Alamat email tidak ditemukan dalam sistem kami.'],
           ]);
       }

       if ($user->status === 'active') {
           return redirect()->route('login')->with('info_message', 'Akun Anda sudah berstatus AKTIF.');
       }

       if ($user->status === 'pending') {
           return redirect()->route('login')->with('registered_pending', 'Akun Anda saat ini masih dalam antrean persetujuan pendaftaran mandiri.');
       }

       $user->update([
           'reactivation_requested_at' => now(),
           'reactivation_reason' => $request->input('reason'),
       ]);

       return redirect()->route('login')->with('reactivation_success', 'Permohonan aktivasi akun berhasil dikirimkan ke Administrator.');
   }
   ```

---

### 4.4 Sisi Administrator: Modul Manajemen Pengguna ([UserController.php](file:///f:/laragon/finaly/repalogic-dashboard/app/Http/Controllers/Admin/ManajemenPengguna/UserController.php))

1. **Eksekusi Penonaktifan Akun:**
   ```php
   public function deactivate($id)
   {
       $user = User::findOrFail($id);
       $user->update([
           'status' => 'inactive',
           'deactivation_requested_at' => null,
           'deactivation_reason' => null,
       ]);

       $this->notifySuccess("Akun pengguna \"{$user->name}\" telah dinonaktifkan sesuai permohonan.");
       return redirect()->route('admin.manajemenpengguna.users.index');
   }
   ```

2. **Eksekusi Pengaktifan Kembali Akun:**
   ```php
   public function activate($id)
   {
       $user = User::findOrFail($id);
       $user->update([
           'status' => 'active',
           'reactivation_requested_at' => null,
           'reactivation_reason' => null,
       ]);

       $this->notifySuccess("Akun pengguna \"{$user->name}\" berhasil diaktifkan kembali.");
       return redirect()->route('admin.manajemenpengguna.users.index');
   }
   ```

---

## 🔔 5. Integrasi Universal Notification Hub ([NotificationService.php](file:///f:/laragon/finaly/repalogic-dashboard/app/Services/NotificationService.php))

Pusat notifikasi topbar secara otomatis menangkap seluruh permohonan penonaktifan dan aktivasi secara terstruktur:

| Tipe Permohonan | Kategori | Ikon Tabler | Warna Badge | Aksi URL Klik |
| :--- | :--- | :--- | :--- | :--- |
| **Penonaktifan Akun** | `deactivate_request` | `ti ti-user-x` | Merah (`bg-danger-subtle text-danger`) | `admin/manajemenpengguna/users?search={Name}` |
| **Aktivasi Kembali** | `activation_request` | `ti ti-user-check` | Hijau (`bg-success-subtle text-success`) | `admin/manajemenpengguna/users?search={Name}` |

---

## 🔒 6. Matriks Kepatuhan Arsitektur & Aturan Proyek

| Aturan Proyek | Status Kepatuhan | Rincian Implementasi |
| :--- | :---: | :--- |
| **Rule 1: Script in `@yield('content')`** | ✅ Terpenuhi | Script validasi real-time diletakkan di dalam `@section('content')` sebelum `@endsection`. |
| **Rule 2: Event Delegation for Buttons** | ✅ Terpenuhi | Tombol interaktif dan aksi tabel memanfaatkan event delegation standar. |
| **Rule 4: Natural Page Scrolling in Modals** | ✅ Terpenuhi | Modal pengajuan alasan penonaktifan menggunakan dialog modal standar Bootstrap (`modal-md`) tanpa scroll internal buatan. |
| **Rule 7: Forbidden `data-target`** | ✅ Terpenuhi | Seluruh elemen custom data atribut menggunakan `data-user`, `data-action`, atau `data-confirm`. |
| **Rule 9: SweetAlert2 `data-confirm`** | ✅ Terpenuhi | Tombol "Nonaktifkan", "Aktifkan", dan "Batalkan" menggunakan atribut `data-confirm="..."` yang terintegrasi SweetAlert2. |
| **Rule 12: Standard Card Header Styling** | ✅ Terpenuhi | Kartu zona bahaya menggunakan `class="card-header bg-danger text-white py-3"` dengan judul `<h5 class="card-title text-white mb-0 fw-bold">`. |

---

## 📖 7. Panduan Operasional Administrator & Pengguna

### Bagi Pengguna:
1. **Untuk Meminta Penonaktifan:** Masuk ke menu *Profil Pengguna*, scroll ke kartu *Permohonan Penonaktifan Akun* di bagian bawah, klik tombol *Minta Nonaktifkan Akun*, isi alasan (opsional), dan klik *Kirim Permohonan*.
2. **Untuk Membatalkan:** Klik tombol *Batalkan Permohonan Penonaktifan* pada banner kuning status di halaman profil.
3. **Untuk Mengaktifkan Kembali Akun:** Buka halaman login, klik tautan *Ajukan Permohonan Aktivasi Akun*, masukkan email terdaftar dan catatan permohonan, lalu kirim.

### Bagi Administrator:
1. Notifikasi badge merah *Minta Nonaktif* atau badge hijau *Minta Aktivasi* akan muncul pada lonceng topbar.
2. Klik notifikasi untuk langsung menuju baris pengguna di modul *Manajemen Pengguna*.
3. Klik tombol merah **"Nonaktifkan"** atau tombol hijau **"Aktifkan"** untuk mengeksekusi permohonan. Status akun dan badge notifikasi akan ter-update otomatis secara seketika.
