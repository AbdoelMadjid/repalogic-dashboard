# 🔐 Dokumentasi Arsitektur & Operasional Autentikasi Pengguna (User Authentication & Lifecycle Management)

> **Status Sistem:** Production-Ready (Enterprise Grade)  
> **Lokasi File Dokumentasi:** `docs/arsitektur_dan_operasional_authentication_user.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Terakhir Diperbarui:** 28 Agustus 2026  

---

## 📋 1. Pendahuluan & Ringkasan Eksekutif

Sistem **Autentikasi & Pengelolaan Siklus Hidup Akun Pengguna (*User Authentication & Lifecycle Management Engine*)** pada REPALOGIC Dashboard dirancang dengan prinsip **Keamanan Berlapis & Verifikasi Pra-Aktivasi (*Zero-Trust Onboarding & Admin-Assisted Lifecycle Control*)**.

Berbeda dengan sistem otentikasi standar yang langsung mengizinkan akses penuh begitu formulir pendaftaran diisi, arsitektur ini membagi siklus hidup akun pengguna ke dalam dua domain operasional utama:

1. **Domain 1: Registrasi Mandiri & Persetujuan Akun (*Self-Registration & Approval Workflow*)**:
   - Pengguna baru mendaftar secara mandiri melalui `/register`.
   - Akun baru berstatus `pending` (Menunggu Persetujuan) dan tidak dapat login.
   - Administrator menerima notifikasi real-time pada topbar untuk meninjau data.
   - **Disetujui:** Akun diubah ke `active` dan otomatis diberikan Spatie Role **`user`**.
   - **Ditolak:** Akun diubah ke `rejected` dengan alasan penolakan. Pengguna diblokir saat login dengan banner alasan penolakan dan dapat mendaftar ulang.

2. **Domain 2: Siklus Hidup Penonaktifan Mandiri & Aktivasi Kembali (*Account Deactivation & Reactivation*)**:
   - Pengguna aktif dapat mengajukan permohonan penonaktifan akun secara mandiri melalui menu **Profil Pengguna** (*Danger Zone*).
   - Pengajuan penonaktifan ditinjau oleh Administrator pada tabel **Manajemen Pengguna**:
     - **Disetujui Nonaktif:** Akun diubah ke `inactive` (Pengguna tidak dapat login).
     - **Ditolak Nonaktif:** Akun tetap `active`, dan sistem otomatis mengirimkan pesan alasan penolakan ke **Dropdown Pesan Topbar Pengguna**.
   - Akun berstatus `inactive` dapat mengajukan permohonan aktivasi kembali melalui halaman publik `/request-activation`.
   - Administrator memverifikasi dan mengaktifkan kembali akun melalui notifikasi badge hijau dan tombol persetujuan di panel admin.

---

## 🔄 2. Diagram Alur Kerja Terpadu (Comprehensive Workflows)

### 2.1 Alur Kerja Registrasi Mandiri, Persetujuan & Penolakan Akun

```mermaid
flowchart TD
    A([Pengguna Membuka /register]) --> B[Isi Form: Nama, Email, Password, Syarat Ketentuan]
    B --> C{Validasi Form Lengkap?}
    C -- Tidak --> D[Tampilkan Notifikasi Error Real-Time di Bawah Input]
    D --> B
    C -- Ya --> E[Submit Data ke RegisteredUserController]
    
    E --> F[Simpan User di DB dengan status = 'pending']
    F --> G[Redirect ke /login dengan Banner Info Pendaftaran Berhasil]
    
    G --> H{Pengguna Coba Login Sebelum Disetujui?}
    H -- Ya (Status Pending) --> I[Blokir Login & Banner: Menunggu Persetujuan Admin]
    
    F --> J[NotificationService Mendeteksi Akun Pending]
    J --> K[Muncul Badge Merah & Item Notifikasi pada Lonceng Topbar Admin]
    
    K --> L[Admin Klik Notifikasi Topbar / Buka admin/manajemenpengguna/users]
    L --> M{Admin Ambil Keputusan}
    
    M -- Klik 'Setujui' --> N[Update User: status='active', approved_at=now, approved_by=admin_id]
    N --> O[Otomatis Berikan Spatie Role 'user']
    O --> P([Pengguna Sukses Login & Masuk ke Dashboard])
    
    M -- Klik 'Tolak' --> Q[Buka Modal Alasan Penolakan]
    Q --> R[Submit Alasan: status='rejected', rejection_reason=alasan]
    R --> S[Status Berubah ke Badge Merah 'Pendaftaran Ditolak']
    
    S --> T{Pengguna Ditolak Coba Login?}
    T -- Ya --> U[Blokir Login & Banner Merah: Ditolak + Alasan Admin]
    U --> V[Pengguna Buka /register untuk Daftar Ulang]
    V --> W[RegisteredUserController Otomatis Hapus Record Old Rejected User]
    W --> B
```

---

### 2.2 Alur Kerja Penonaktifan Mandiri & Aktivasi Kembali Akun

```mermaid
flowchart TD
    subgraph Fase_1 ["Fase 1: Permohonan Penonaktifan Akun (User Aktif)"]
        A["Pengguna Aktif Masuk ke /admin/profil-pengguna"] --> B["Scroll ke Zona Bahaya di Bawah Data KTP"]
        B --> C["Klik Tombol 'Minta Nonaktifkan Akun'"]
        C --> D["Isi Alasan Penonaktifan pada Modal Form"]
        D --> E["Submit ke ProfilPenggunaController@requestDeactivation"]
        E --> F["Update DB: deactivation_requested_at=now, deactivation_reason=text"]
        F --> G["Tampilkan Banner Status Pengajuan Kuning & Tombol Batalkan"]
    end

    subgraph Fase_2 ["Fase 2: Keputusan Administrator (Setujui / Tolak Nonaktif)"]
        F --> H["NotificationService Mendeteksi deactivation_requested_at"]
        H --> I["Lonceng Topbar Admin Menampilkan Badge Merah 'Minta Nonaktif'"]
        I --> J["Admin Klik Notifikasi Topbar -> Buka users?search=Nama"]
        J --> K{"Admin Ambil Keputusan"}
        
        K -- Klik 'Nonaktifkan' --> L["Update DB: status='inactive', deactivation_requested_at=null"]
        
        K -- Klik 'Tolak Nonaktif' --> M["Buka Modal Form Alasan Penolakan Admin"]
        M --> N["Submit ke UserController@rejectDeactivation"]
        N --> O["Update DB: deactivation_requested_at=null, status tetap 'active'"]
        O --> P["Sistem Otomatis Buat Record di Tabel messages & notifications"]
        P --> Q["Dropdown Pesan Topbar User Menampilkan 'Penonaktifan Ditolak'"]
    end

    subgraph Fase_3 ["Fase 3: Pengajuan Aktivasi Kembali (User Nonaktif)"]
        L --> R["Pengguna Nonaktif Coba Login di /login"]
        R --> S["Login Gagal: Muncul Banner Merah 'Akun Dinonaktifkan'"]
        S --> T["Pengguna Klik Tombol 'Ajukan Permohonan Aktivasi Akun'"]
        T --> U["Buka Halaman Publik /request-activation"]
        U --> V["Input Email Terdaftar & Catatan Permohonan Aktivasi"]
        V --> W["Submit ke AccountReactivationController@store"]
        W --> X["Update DB: reactivation_requested_at=now, reactivation_reason=text"]
        X --> Y["Redirect ke /login dengan Banner Sukses Hijau"]
    end

    subgraph Fase_4 ["Fase 4: Persetujuan Aktivasi oleh Administrator"]
        X --> Z["NotificationService Mendeteksi reactivation_requested_at"]
        Z --> AA["Lonceng Topbar Admin Menampilkan Badge Hijau 'Minta Aktivasi'"]
        AA --> AB["Admin Klik Notifikasi Topbar -> Buka users?search=Nama"]
        AB --> AC["Tabel Admin Menampilkan Badge 'Minta Aktivasi' & Tombol Hijau 'Aktifkan'"]
        AC --> AD["Admin Klik Tombol 'Aktifkan' + Konfirmasi SweetAlert2"]
        AD --> AE["Update DB: status='active', reactivation_requested_at=null"]
        AE --> AF(["Akun Berhasil Aktif Kembali & Pengguna Dapat Login"])
    end
```

---

## 🗄️ 3. Arsitektur Database & Metadata Schema

Sistem autentikasi dan siklus hidup akun didukung oleh kolom-kolom status khusus pada tabel `users`:

### 3.1 Struktur Kolom Siklus Hidup pada Tabel `users`

| Nama Kolom | Tipe Data | Nullable | Default | Keterangan & Fungsi |
| :--- | :--- | :--- | :--- | :--- |
| `status` | `ENUM('pending', 'active', 'inactive', 'rejected')` | `NO` | `'active'` | Status operasional akun pengguna. |
| `approved_at` | `TIMESTAMP` | `YES` | `NULL` | Waktu persetujuan akun oleh administrator. |
| `approved_by` | `BIGINT UNSIGNED (FK)` | `YES` | `NULL` | ID user administrator yang menyetujui akun. |
| `rejection_reason` | `TEXT` | `YES` | `NULL` | Alasan penolakan pendaftaran akun oleh admin. |
| `deactivation_requested_at` | `TIMESTAMP` | `YES` | `NULL` | Waktu pengguna mengajukan permohonan penonaktifan akun. |
| `deactivation_reason` | `TEXT` | `YES` | `NULL` | Alasan penonaktifan yang diajukan oleh pengguna. |
| `reactivation_requested_at` | `TIMESTAMP` | `YES` | `NULL` | Waktu pengguna nonaktif mengajukan aktivasi kembali. |
| `reactivation_reason` | `TEXT` | `YES` | `NULL` | Alasan permohonan pengaktifan kembali akun. |

### 3.2 Spatie Role & Permission Baku
- **Role Otomatis:** `user` (diberikan saat akun disetujui).
- **Hak Akses Default:** Mengakses menu *Profil Pengguna* (`create profil-pengguna`, `read profil-pengguna`, `update profil-pengguna`) dan fitur pesan obrolan (`messages`).

---

## ⚙️ 4. Rincian Implementasi Logika Teknis

### 4.1 Registrasi Mandiri (`RegisteredUserController.php` & `register.blade.php`)
1. **Pendaftaran Akun Baru:**
   - Validasi ketat nama, format email unik, password terenkripsi (`Hash::make`), dan persetujuan syarat ketentuan (*Terms & Conditions*).
   - Akun disimpan dengan `status = 'pending'`.
   - Jika email yang didaftarkan sebelumnya berstatus `rejected`, sistem secara otomatis membersihkan rekam jejak lama agar pengguna dapat mendaftar ulang dengan data baru.
2. **Redirect & Feedback Pengguna:**
   - Dialihkan ke `/login` disertai session flash `registered_pending`.
   - Tidak melakukan *auto-login* sebelum disetujui Administrator.

### 4.2 Proteksi Login & Pemisahan Error (`LoginRequest.php` & `login.blade.php`)
Sistem memisahkan pesan kesalahan otentikasi berdasarkan kasus secara terisolasi:
1. **Email Tidak Terdaftar:** Menampilkan pesan `"User tidak terdaftar."` di bawah kolom email dan kursor otomatis fokus ke email.
2. **Password Salah:** Menampilkan pesan `"Password yang Anda masukkan salah."` di bawah kolom password.
3. **Akun Belum Disetujui (`status = 'pending'`):**
   - Mengembalikan validation key `unapproved`.
   - Dirender sebagai **Banner Peringatan Kuning/Biru di Atas Form Login**:
     > **Menunggu Persetujuan Admin**  
     > *"Akun Anda belum disetujui oleh Administrator. Silakan hubungi admin untuk aktivasi akun."*
4. **Akun Ditolak (`status = 'rejected'`):**
   - Mengembalikan validation key `rejected` beserta `rejection_reason`.
   - Dirender sebagai **Banner Peringatan Merah** lengkap dengan alasan penolakan dan tombol link menuju form pendaftaran ulang.
5. **Akun Dinonaktifkan (`status = 'inactive'`):**
   - Mengembalikan validation key `inactive`.
   - Dirender sebagai **Banner Peringatan Merah** dengan tombol tindakan langsung: **"Ajukan Permohonan Aktivasi Akun"** menuju `/request-activation`.

### 4.3 Persetujuan & Penolakan Registrasi oleh Administrator (`UserController.php`)
- **Persetujuan Akun (`approve`):**
  ```php
  public function approve($id)
  {
      $user = User::findOrFail($id);
      $user->update([
          'status' => 'active',
          'approved_at' => now(),
          'approved_by' => auth()->id(),
      ]);

      if (!$user->hasRole('user')) {
          $user->assignRole('user');
      }

      $this->notifySuccess("Akun {$user->name} berhasil disetujui dan diaktifkan.", 'Akun Diaktifkan');
      return redirect()->route('admin.manajemenpengguna.users.index');
  }
  ```
- **Penolakan Akun (`reject`):**
  ```php
  public function reject(Request $request, $id)
  {
      $user = User::findOrFail($id);
      $request->validate(['rejection_reason' => 'required|string|max:1000']);

      $user->update([
          'status' => 'rejected',
          'rejection_reason' => $request->input('rejection_reason'),
      ]);

      $this->notifySuccess("Pendaftaran akun {$user->name} berhasil ditolak.", 'Pendaftaran Ditolak');
      return redirect()->route('admin.manajemenpengguna.users.index');
  }
  ```

### 4.4 Pengajuan Penonaktifan Mandiri & Pembatalan (`ProfilPenggunaController.php`)
- Pengguna aktif dapat mengajukan penonaktifan melalui modal form pada zona bahaya profil.
- Selama pengajuan belum dieksekusi admin, pengguna dapat membatalkan pengajuan secara mandiri (*cancel deactivation*).
- Jika admin menolak penonaktifan (`rejectDeactivation`), status akun tetap `active`, dan sistem otomatis mengirimkan pesan penjelasan ke tabel `messages` yang muncul di dropdown pesan topbar pengguna.

### 4.5 Pengajuan Aktivasi Kembali Akun (`AccountReactivationController.php`)
- Pengguna yang dinonaktifkan mengisi email dan alasan permohonan pada form `/request-activation`.
- Kolom `reactivation_requested_at` dan `reactivation_reason` diperbarui.
- Lonceng topbar Administrator otomatis memunculkan badge hijau **"Minta Aktivasi"** yang mengarahkan langsung ke baris akun tersebut untuk dieksekusi.

---

## 🔔 5. Integrasi Universal Notification Hub (`NotificationService.php`)

Pusat notifikasi topbar mengagregasi seluruh aktivitas siklus hidup akun secara real-time:

| Tipe Notifikasi | Kondisi Pemicu | Badge & Warna | Target URL Admin |
| :--- | :--- | :---: | :--- |
| `registration` | Akun baru `status = 'pending'` | <span class="badge bg-danger text-white">Baru</span> | `admin/manajemenpengguna/users?search={name}` |
| `deactivate_request` | `deactivation_requested_at IS NOT NULL` | <span class="badge bg-danger text-white">Minta Nonaktif</span> | `admin/manajemenpengguna/users?search={name}` |
| `reactivate_request` | `reactivation_requested_at IS NOT NULL` | <span class="badge bg-success text-white">Minta Aktivasi</span> | `admin/manajemenpengguna/users?search={name}` |
| `chat_message` | Pesan obrolan masuk yang belum dibaca | <span class="badge bg-primary text-white">Pesan</span> | `admin/profil-pengguna/messages` |

---

## 📁 6. Daftar File & Komponen Terkait

| File Path | Deskripsi & Peran |
| :--- | :--- |
| `app/Http/Controllers/Auth/RegisteredUserController.php` | Controller pendaftaran mandiri pengguna baru. |
| `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | Controller otentikasi login dan pembersihan sesi. |
| `app/Http/Controllers/Auth/AccountReactivationController.php` | Controller publik permohonan aktivasi akun nonaktif. |
| `app/Http/Requests/Auth/LoginRequest.php` | Validasi kredensial login & pemisahan error state. |
| `app/Http/Controllers/Admin/UserController.php` | Eksekusi approve, reject, deactivate, dan activate akun admin. |
| `app/Http/Controllers/Admin/ProfilPenggunaController.php` | Pengajuan dan pembatalan penonaktifan akun mandiri. |
| `app/Services/NotificationService.php` | Engine agregator notifikasi topbar real-time. |
| `resources/views/auth/register.blade.php` | Tampilan form pendaftaran mandiri. |
| `resources/views/auth/login.blade.php` | Tampilan form login dan banner pemisahan status akun. |
| `resources/views/auth/request-activation.blade.php` | Tampilan form publik pengajuan aktivasi akun. |
| `resources/views/admin/manajemenpengguna/users.blade.php` | Tampilan tabel manajemen pengguna & modal aksi persetujuan. |
| `docs/arsitektur_dan_operasional_authentication_user.md` | File dokumentasi arsitektur dan operasional ini. |
