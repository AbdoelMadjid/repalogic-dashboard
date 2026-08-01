# Skill: Standard Prosedur Pembuatan Menu / Modul Admin

Petunjuk teknis dan aturan baku untuk pembuatan modul/menu baru pada area admin dashboard Laravel (seperti `Profil Aplikasi`, `Manajemen Pengguna`, dll).

---

## 1. Aturan Penamaan Permission Spatie
Sesuai standar antarmuka Spatie Permission di project ini:
- Format nama permission **WAJIB**: `{action} {kelompok}/{fitur}`
- Contoh:
  - `create manajemensistem/menu`
  - `read manajemensistem/menu`
  - `update manajemensistem/menu`
  - `delete manajemensistem/menu`

---

## 2. Penggunaan Directive `@can` di Blade Template
Setiap tombol aksi (Tambah, Detail, Edit, Hapus) pada file Blade **WAJIB** dibungkus dengan directive `@can`:

```blade
{{-- Tombol Tambah --}}
@can('create manajemensistem/menu')
    <button type="button" class="btn btn-primary btn-sm btn-menu-action" data-action="create">
        <i class="ti ti-plus me-1"></i> Tambah Menu Baru
    </button>
@endcan

{{-- Tombol Aksi di Baris Tabel --}}
@php
    $target = $menu->getPermissionTarget(); // e.g. "manajemensistem/menu"
@endphp

@can('read ' . $target)
    <button class="btn btn-sm btn-outline-info" data-action="view"><i class="ti ti-eye"></i></button>
@endcan

@can('update ' . $target)
    <button class="btn btn-sm btn-outline-warning" data-action="edit"><i class="ti ti-edit"></i></button>
@endcan

@can('delete ' . $target)
    <button class="btn btn-sm btn-outline-danger" data-action="delete"><i class="ti ti-trash"></i></button>
@endcan
```

---

## 3. Integrasi DataTables Yajra (Global DataTables Pattern)
Seluruh modul tabel admin didukung oleh **Yajra DataTables (`yajra/laravel-datatables-oracle`)**:

```php
// Controller index AJAX response:
if ($request->ajax() && $request->has('draw')) {
    $query = Model::query();
    return DataTables::of($query)
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
}
```

- Styling tabel dan Form Switch toggle diatur secara global melalui **`custom-datatables.css`**.
- Teks info footer menggunakan format ringkas universal: `Total: X data`.
- Tombol navigasi pagination menggunakan ikon Tabler (`ti-chevrons-left`, `ti-chevron-left`, `ti-chevron-right`, `ti-chevrons-right`).

---

## 4. SweetAlert Intercept Route Belum Siap (`.menu-unprepared`)
Pada link sidebar menu utama (`_item.blade.php`), jika menu memiliki `active = 0` atau route yang belum didaftarkan:
- Link secara otomatis ditandai dengan class `.menu-unprepared`.
- Saat diklik, SweetAlert memunculkan modal peringatan **"Belum Dapat Diakses"** dengan tombol `"OK"`.
