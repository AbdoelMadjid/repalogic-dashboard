@extends('layouts.vertical', ['title' => 'Akses Role'])

@section('content')
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/admin/manajemenpengguna/akses_role.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Akses Role'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2">
                        <div>
                            <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center text-dark">
                                <i class="ti ti-lock-access text-primary fs-22 fs-md-18 me-0 me-md-2 mb-1 mb-md-0"></i>
                                <span>Manajemen Hak Akses Role (Role Access Matrix)</span>
                            </h5>
                            <p class="text-muted fs-12 mb-0 mt-1 mt-md-0.5 text-center text-md-start">
                                Distribusi dan kelola matriks izin Spatie Permission ke tiap peran (Role) pengguna sistem.
                            </p>
                        </div>
                    </div>
                    <div class="card-body p-3">
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

                        <table class="table table-hover align-middle mb-0 w-100 table-custom-datatable" id="akses-role-table">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                    <th>Pengguna Terhubung</th>
                                    <th>Jumlah Permission Aktif</th>
                                    <th>Aksi Hak Akses</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                        <h5 class="modal-title text-white" id="aksesRoleModalTitle"><i class="ti ti-key me-1.5"></i> Atur Matriks Hak Akses Role</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-info fs-13 d-flex align-items-center mb-3">
                            <i class="ti ti-info-circle fs-18 me-2 flex-shrink-0"></i>
                            <div>
                                Centang pada matriks permission untuk memberikan izin akses fitur sistem ke Role <strong id="modal_role_name_display">...</strong>.
                            </div>
                        </div>

                        @include('admin.manajemenpengguna.partials.akses_role_form')
                    </div>
                    <div class="modal-footer d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1.5"></i> Simpan Hak Akses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DataTables Plugins -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.js') }}"></script>

    <!-- Bridge Config & Module JS (Rule 1 & 15 Compliance) -->
    <script>
        window.AksesRoleConfig = {
            routes: {
                dataUrl: "{{ route('admin.manajemenpengguna.akses-role.index') }}",
                base: "{{ url('admin/manajemenpengguna/akses-role') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/akses_role.js') }}"></script>
@endsection
