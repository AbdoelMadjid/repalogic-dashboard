@extends('layouts.vertical', ['title' => 'Akses Role'])

@section('content')
    <link href="{{ asset('assets/css/admin/manajemenpengguna/akses_role.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Akses Role'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Manajemen Hak Akses Role (Role Access Matrix)</h4>
                            <p class="text-muted fs-12 mb-0">
                                Distribusi dan kelola matriks izin Spatie Permission ke tiap peran (Role) pengguna sistem.
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- DATATABLES HEADER CONTROLS (JUMLAH BARIS & LIVE SEARCH) -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 d-flex align-items-center">
                                <label class="me-2 fs-13 text-muted mb-0">Tampilkan:</label>
                                <select id="table-length-select" class="form-select form-select-sm datatable-length-select" style="width: 120px;">
                                    <option value="10">10 baris</option>
                                    <option value="25" selected>25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="all">Semua Baris</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <div class="d-flex align-items-center datatable-search-input">
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Role:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama role...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="akses-role-table">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 60px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Nama Role</th>
                                        <th class="text-center align-middle text-nowrap">Pengguna Terhubung</th>
                                        <th class="text-center align-middle text-nowrap">Jumlah Permission Aktif</th>
                                        <th style="width: 140px;" class="text-center align-middle text-nowrap">Aksi Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        @php
                                            $badgeClass = match ($role->name) {
                                                'superadmin' => 'bg-danger',
                                                'admin' => 'bg-primary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <tr class="akses-role-row">
                                            <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge {{ $badgeClass }} fs-13 py-1 px-2 text-capitalize">
                                                    <i class="ti ti-shield me-1"></i>{{ $role->name }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    <i class="ti ti-users me-1"></i>{{ $role->users_count ?? $role->users->count() }} User
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                    <i class="ti ti-key me-1"></i>{{ $role->permissions_count ?? $role->permissions->count() }} Permission
                                                </span>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                    @can('read manajemenpengguna/akses-role')
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-akses-role-trigger" data-action="view" data-role='@json($role->load("permissions"))' title="Lihat Detail Akses"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update manajemenpengguna/akses-role')
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-akses-role-trigger" data-action="edit" data-role='@json($role->load("permissions"))' title="Atur Hak Akses"><i class="ti ti-key"></i></button>
                                                    @endcan
                                                    @can('delete manajemenpengguna/akses-role')
                                                        @if ($role->name === 'superadmin')
                                                            <button type="button" class="btn btn-sm btn-outline-secondary disabled" title="Akses Superadmin tidak dapat dikosongkan"><i class="ti ti-lock"></i></button>
                                                        @else
                                                            <form action="{{ route('admin.manajemenpengguna.akses-role.destroy', $role->id) }}" method="POST" class="d-inline" data-confirm="Kosongkan seluruh izin permission untuk role {{ $role->name }}?">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Kosongkan Akses"><i class="ti ti-trash"></i></button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data role yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ $roles->count() }}</strong> data
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                                <ul class="pagination pagination-sm m-0" id="table-pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SINGLE UNIFIED MODAL (ATUR & DETAIL HAK AKSES ROLE) -->
    <div class="modal fade" id="aksesRoleModal" tabindex="-1" aria-labelledby="aksesRoleModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="aksesRoleForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="aksesRoleModalTitle"><i class="ti ti-key me-1"></i> Atur Matriks Hak Akses Role</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-info fs-13 d-flex align-items-center mb-3">
                            <i class="ti ti-info-circle fs-18 me-2"></i>
                            <div>
                                Centang pada matriks permission untuk memberikan izin akses fitur sistem ke Role <strong id="modal_role_name_display">...</strong>.
                            </div>
                        </div>

                        @include('admin.manajemenpengguna.partials.akses_role_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Hak Akses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.AksesRoleConfig = {
            routes: {
                base: "{{ url('admin/manajemenpengguna/akses-role') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/akses_role.js') }}"></script>
@endsection
