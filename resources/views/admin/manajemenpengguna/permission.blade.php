@extends('layouts.vertical', ['title' => 'Data Permission'])

@section('content')
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/admin/manajemenpengguna/permission.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', ['subtitle' => 'Manajemen Pengguna', 'title' => 'Data Permission'])
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-2">
                        <div>
                            <h5 class="card-title mb-0 fw-bold d-flex flex-column flex-md-row align-items-center text-dark">
                                <i class="ti ti-key text-primary fs-22 fs-md-18 me-0 me-md-2 mb-1 mb-md-0"></i>
                                <span>Data Permission System</span>
                            </h5>
                            <p class="text-muted fs-12 mb-0 mt-1 mt-md-0.5 text-center text-md-start">
                                Draf pendaftaran tipe aksi izin (CRUD) per Modul / Fitur Aplikasi dan distribusinya ke Role.
                            </p>
                        </div>
                        @can('create manajemenpengguna/permission')
                            <div class="card-header-actions d-flex align-items-center gap-2 text-nowrap flex-shrink-0">
                                <button type="button" class="btn btn-primary btn-sm btn-modul-permission-trigger" data-type="create" title="Tambah Permission Baru">
                                    <i class="ti ti-plus me-1.5"></i>
                                    <span>Tambah Permission Baru</span>
                                </button>
                            </div>
                        @endcan
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

                        <table class="table table-hover align-middle mb-0 w-100 table-custom-datatable" id="permission-table">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr>
                                    <th>No</th>
                                    <th>Modul / Fitur Aplikasi</th>
                                    <th>Tipe Aksi Terdaftar (CRUD)</th>
                                    <th>Ditugaskan Ke Role</th>
                                    <th>Jumlah Izin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                    <div class="modal-footer d-flex flex-column-reverse flex-sm-row justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="ti ti-device-floppy me-1.5"></i> Simpan Permission</button>
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
        window.PermissionConfig = {
            routes: {
                dataUrl: "{{ route('admin.manajemenpengguna.permission.index') }}",
                store: "{{ route('admin.manajemenpengguna.permission.store') }}",
                base: "{{ url('admin/manajemenpengguna/permission') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/admin/manajemenpengguna/permission.js') }}"></script>
@endsection
