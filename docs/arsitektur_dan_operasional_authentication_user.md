# 🔐 Dokumentasi Arsitektur & Operasional Autentikasi Pengguna (User Authentication & Lifecycle Management)

> **Status Sistem:** Production-Ready (Enterprise Grade Modular Architecture)  
> **Lokasi File Dokumentasi:** `docs/arsitektur_dan_operasional_authentication_user.md`  
> **Aplikasi:** REPALOGIC Dashboard  
> **Terakhir Diperbarui:** 04 September 2026 09:22 WIB  

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
    A(["Pengguna Membuka /register"]) --> B["Isi Form: Nama, Email, Password, Syarat Ketentuan"]
    B --> C{"Validasi Form Lengkap?"}
    C -- "Tidak" --> D["Tampilkan Notifikasi Error Real-Time di Bawah Input"]
    D --> B
    C -- "Ya" --> E["Submit Data ke RegisteredUserController"]
    
    E --> F["Simpan User di DB dengan status = 'pending'"]
    F --> G["Redirect ke /login dengan Banner Info Pendaftaran Berhasil"]
    
    G --> H{"Pengguna Coba Login Sebelum Disetujui?"}
    H -- "Ya (Status Pending)" --> I["Blokir Login & Banner: Menunggu Persetujuan Admin"]
    
    F --> J["NotificationService Mendeteksi Akun Pending"]
    J --> K["Muncul Badge Merah & Item Notifikasi pada Lonceng Topbar Admin"]
    
    K --> L["Admin Klik Notifikasi Topbar / Buka admin/manajemenpengguna/users"]
    L --> M{"Admin Ambil Keputusan"}
    
    M -- "Klik Setujui" --> N["Update User: status='active', approved_at=now, approved_by=admin_id"]
    N --> O["Otomatis Berikan Spatie Role 'user'"]
    O --> P(["Pengguna Sukses Login & Masuk ke Dashboard"])
    
    M -- "Klik Tolak" --> Q["Buka Modal Alasan Penolakan"]
    Q --> R["Submit Alasan: status='rejected', rejection_reason=alasan"]
    R --> S["Status Berubah ke Badge Merah 'Pendaftaran Ditolak'"]
    
    S --> T{"Pengguna Ditolak Coba Login?"}
    T -- "Ya" --> U["Blokir Login & Banner Merah: Ditolak + Alasan Admin"]
    U --> V["Pengguna Buka /register untuk Daftar Ulang"]
    V --> W["RegisteredUserController Otomatis Hapus Record Old Rejected User"]
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
        
        K -- "Klik Nonaktifkan" --> L["Update DB: status='inactive', deactivation_requested_at=null"]
        
        K -- "Klik Tolak Nonaktif" --> M["Buka Modal Form Alasan Penolakan Admin"]
        M --> N["Submit ke UserController@rejectDeactivation"]
        N --> O["Update DB: deactivation_requested_at=null, status tetap 'active'"]
        O --> P["Sistem Otomatis Buat Record di Tabel messages & notifications"]
        P --> Q["Dropdown Pesan Topbar User Menampilkan 'Penonaktifan Ditolak'"]
    end
```

---

## 🛡️ 3. Keamanan, Rate Limiting & Proteksi Sesi

1. **Security Rate Limiting**:
   - Throttle key berdasarkan gabungan alamat IP dan email pengguna.
   - Otomatis melakukan *lockout* sementara jika batas maksimal kegagalan tercapai.
2. **Zero-Trust Session Invalidation**:
   - Ketika akun dinonaktifkan atau ditolak oleh Administrator, seluruh sesi aktif dari user target langsung diinvalidasi secara instan dari database/session store.
3. **Impersonation Safety**:
   - Fitur pergantian akun menyimpan sesi asli administrator di `session('admin_impersonator_id')` untuk menjamin kemudahan kembali (*switch-back*) tanpa merusak audit log.

---

> 📌 **Dokumentasi ini dikelola secara resmi oleh Tim Pengembang REPALOGIC Dashboard.**
