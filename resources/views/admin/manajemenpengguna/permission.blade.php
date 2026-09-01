@extends('layouts.vertical', ['title' => 'Data Permission'])

@section('content')
    <link href="{{ asset('assets/css/admin/manajemenpengguna/permission.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Data Permission'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Data Permission System</h4>
                            <p class="text-muted fs-12 mb-0">
                                Draf pendaftaran tipe aksi izin (CRUD) per Modul / Fitur Aplikasi dan distribusinya ke Role.
                            </p>
                        </div>
                        @can('create manajemenpengguna/permission')
                            <button type="button" class="btn btn-primary btn-sm btn-modul-permission-trigger" data-type="create">
                                <i class="ti ti-plus me-1"></i> Tambah Permission Baru
                            </button>
                        @endcan
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
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Modul / Fitur:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama modul...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="permission-table">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="text-uppercase fs-12 fw-bold text-muted border-bottom align-middle text-center text-nowrap">
                                        <th class="py-3 text-center align-middle text-nowrap" style="min-width: 250px;">MODUL / FITUR APLIKASI</th>
                                        <th class="py-3 text-center align-middle text-nowrap">TIPE AKSI TERDAFTAR (CRUD)</th>
                                        <th class="py-3 text-center align-middle text-nowrap" style="min-width: 180px;">DITUGASKAN KE ROLE</th>
                                        <th class="text-center py-3 align-middle text-nowrap" style="width: 140px;">JUMLAH IZIN</th>
                                        <th class="text-center py-3 align-middle text-nowrap" style="width: 150px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groupedPermissions as $target => $permList)
                                        @php
                                            $linkedMenu = $permList->flatMap->menus->first();
                                            $roles = $permList->flatMap->roles->unique('id');
                                            $firstPerm = $permList->first();
                                            $firstPermId = $firstPerm ? $firstPerm->id : 0;
                                            $actionsStr = implode(',', $permList->pluck('name')->map(function($n) {
                                                return strtolower(explode(' ', $n)[0] ?? '');
                                            })->toArray());
                                        @endphp
                                        <tr class="permission-row">
                                            <td class="ps-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-light text-dark font-monospace border fs-12 px-2 py-1 shadow-sm me-2">
                                                        {{ $target }}
                                                    </span>
                                                    @if ($linkedMenu)
                                                        <span class="fw-medium text-muted fs-12">({{ $linkedMenu->name }})</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($permList as $perm)
                                                        @php
                                                            $actionWord = strtoupper(explode(' ', $perm->name)[0] ?? $perm->name);
                                                            $badgeStyle = match (strtolower($actionWord)) {
                                                                'create' => 'bg-success-subtle text-success border border-success-subtle',
                                                                'read' => 'bg-info-subtle text-info border border-info-subtle',
                                                                'update' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                                'delete' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                                default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeStyle }} fw-bold px-2 py-1 fs-11" title="{{ $perm->name }}">
                                                            {{ $actionWord }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @forelse ($roles as $role)
                                                        @php
                                                            $roleBadge = match ($role->name) {
                                                                'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                                'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                                                default => 'bg-info-subtle text-info border-info-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $roleBadge }} border fs-11 text-capitalize">
                                                            {{ $role->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted fs-12">- Belum Ditugaskan -</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center py-3">
                                                <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-semibold">
                                                    {{ $permList->count() }} Akses
                                                </span>
                                            </td>
                                            <td class="text-center py-3">
                                                @can('read manajemenpengguna/permission')
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-modul-permission-trigger me-1"
                                                        data-type="view"
                                                        data-module="{{ $target }}"
                                                        data-menu-id="{{ $linkedMenu ? $linkedMenu->id : '' }}"
                                                        data-actions="{{ $actionsStr }}"
                                                        data-first-id="{{ $firstPermId }}"
                                                        title="Detail Modul">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                @endcan
                                                @can('update manajemenpengguna/permission')
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-modul-permission-trigger me-1"
                                                        data-type="edit"
                                                        data-module="{{ $target }}"
                                                        data-menu-id="{{ $linkedMenu ? $linkedMenu->id : '' }}"
                                                        data-actions="{{ $actionsStr }}"
                                                        data-first-id="{{ $firstPermId }}"
                                                        title="Edit Modul">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('delete manajemenpengguna/permission')
                                                    <form action="{{ route('admin.manajemenpengguna.permission.destroy', $firstPermId) }}" method="POST" class="d-inline" data-confirm="Hapus seluruh izin permission untuk modul {{ $target }}?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Modul"><i class="ti ti-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data modul permission yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ count($groupedPermissions) }}</strong> modul
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

    <!-- SINGLE UNIFIED MODAL (CREATE, EDIT, VIEW/SHOW) -->
    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="permissionForm" action="" method="POST">
                    @csrf
                    <div id="methodSpoofingContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="permissionModalTitle">Permission Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.manajemenpengguna.partials.permission_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1"></i> Simpan Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.PermissionConfig = {
            routes: {
                store: "{{ route('admin.manajemenpengguna.permission.store') }}",
                base: "{{ url('admin/manajemenpengguna/permission') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/permission.js') }}"></script>
@endsection
