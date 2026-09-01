@extends('layouts.vertical', ['title' => 'Akses User'])

@section('content')
    <link href="{{ asset('assets/css/admin/manajemenpengguna/akses_user.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Akses User'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Manajemen Hak Akses Pengguna (User Access Assignment)</h4>
                            <p class="text-muted fs-12 mb-0">
                                Kelola penugasan Peran (Role) dan Izin Khusus Langsung (Direct Permissions) per pengguna individual.
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
                                    <label class="me-2 fs-13 text-muted mb-0 text-nowrap">Cari Pengguna:</label>
                                    <input type="text" id="table-search-input" class="form-control form-control-sm" placeholder="Ketik nama atau email user...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered mb-0" id="akses-user-table">
                                <thead class="table-light align-middle text-center text-nowrap">
                                    <tr class="align-middle text-center text-nowrap">
                                        <th style="width: 60px;" class="text-center align-middle text-nowrap">#</th>
                                        <th class="text-center align-middle text-nowrap">Identitas Pengguna</th>
                                        <th class="text-center align-middle text-nowrap">Peran Utama (Role)</th>
                                        <th class="text-center align-middle text-nowrap">Izin Langsung (Direct)</th>
                                        <th class="text-center align-middle text-nowrap">Total Akses Aktif</th>
                                        <th style="width: 140px;" class="text-center align-middle text-nowrap">Aksi Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="akses-user-row">
                                            <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle me-2 object-fit-cover border" style="width: 38px; height: 38px; object-fit: cover; object-position: top;">
                                                    <div>
                                                        <h6 class="mb-0 fs-13 fw-semibold">{{ $user->name }}</h6>
                                                        <span class="text-muted fs-12">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center py-2">
                                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                    @forelse ($user->roles as $role)
                                                        @php
                                                            $badgeClass = match ($role->name) {
                                                                'superadmin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                                'admin' => 'bg-primary-subtle text-primary border-primary-subtle',
                                                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }} border fs-11 text-capitalize">
                                                            <i class="ti ti-shield me-1"></i>{{ $role->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted fs-12">- Tanpa Role -</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-center py-2">
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-12">
                                                    <i class="ti ti-key me-1"></i>{{ $user->permissions->count() }} Direct
                                                </span>
                                            </td>
                                            <td class="text-center py-2">
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12 fw-semibold">
                                                    <i class="ti ti-check me-1"></i>{{ $user->getAllPermissions()->count() }} Akses
                                                </span>
                                            </td>
                                            <td class="text-center py-2 text-nowrap">
                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                    @can('read manajemenpengguna/akses-user')
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-akses-user-trigger" data-action="view" data-user='@json($user)' title="Lihat Detail Akses"><i class="ti ti-eye"></i></button>
                                                    @endcan
                                                    @can('update manajemenpengguna/akses-user')
                                                        <button type="button" class="btn btn-sm btn-outline-primary btn-akses-user-trigger" data-action="edit" data-user='@json($user)' title="Atur Akses Pengguna"><i class="ti ti-key"></i></button>
                                                    @endcan
                                                    @can('delete manajemenpengguna/akses-user')
                                                        <form action="{{ route('admin.manajemenpengguna.akses-user.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Kosongkan seluruh izin khusus langsung (direct permissions) untuk user {{ $user->name }}?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Reset Izin Langsung"><i class="ti ti-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER INFO & PAGINATION BAR -->
                        <div class="row align-items-center mt-3">
                            <div class="col-md-6 fs-13 text-muted" id="table-info-bar">
                                Menampilkan <strong>{{ $users->count() }}</strong> pengguna
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

    <!-- SINGLE UNIFIED MODAL (ATUR & DETAIL HAK AKSES PENGGUNA) -->
    <div class="modal fade" id="aksesUserModal" tabindex="-1" aria-labelledby="aksesUserModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="aksesUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="aksesUserModalTitle"><i class="ti ti-key me-1"></i> Atur Hak Akses Individual Pengguna</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-info fs-13 d-flex align-items-center mb-3">
                            <i class="ti ti-info-circle fs-18 me-2"></i>
                            <div>
                                Anda dapat menugaskan <strong>Role Utama</strong> dan memberikan <strong>Izin Khusus Langsung (Direct Permissions)</strong> secara opsional untuk pengguna <strong id="modal_user_name_display">...</strong>.
                            </div>
                        </div>

                        @include('admin.manajemenpengguna.partials.akses_user_form')
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
        window.AksesUserConfig = {
            roles: @json($roles),
            routes: {
                base: "{{ url('admin/manajemenpengguna/akses-user') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/akses_user.js') }}"></script>
@endsection
