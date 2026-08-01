@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-success bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-success fw-semibold px-3 py-1.5 rounded-pill mb-3">Third-Party
                        Packages</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="sources-credit">Sources & Credits</h2>
                    <p class="text-white-50 fs-16 mb-0">Official documentation links and licenses for third-party CSS, JS
                        plugins, and icon libraries integrated into INSPINIA.</p>
                </div>
            </div>
        </div>

        <!-- Plugins Table -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-code me-2 text-success"></i>Integrated Libraries &
                        Documentation Links</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0 align-middle">
                            <thead class="bg-light bg-opacity-50 fs-xxs text-uppercase">
                                <tr>
                                    <th>Plugin / Package</th>
                                    <th>Category</th>
                                    <th>Official Documentation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong class="text-primary">Bootstrap 5.3</strong></td>
                                    <td>UI Framework</td>
                                    <td><a href="https://getbootstrap.com/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            getbootstrap.com</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">ApexCharts</strong></td>
                                    <td>Data Visualization</td>
                                    <td><a href="https://apexcharts.com/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            apexcharts.com</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">ECharts</strong></td>
                                    <td>Data Visualization</td>
                                    <td><a href="https://echarts.apache.org/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            echarts.apache.org</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">DataTables</strong></td>
                                    <td>Data Tables</td>
                                    <td><a href="https://datatables.net/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            datatables.net</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">Tabler Icons</strong></td>
                                    <td>Icon Font & SVG</td>
                                    <td><a href="https://tabler.io/icons" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            tabler.io/icons</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">jsTree</strong></td>
                                    <td>Treeview Component</td>
                                    <td><a href="https://www.jstree.com/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            jstree.com</a></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-primary">SweetAlert2</strong></td>
                                    <td>Alert Dialogs</td>
                                    <td><a href="https://sweetalert2.github.io/" target="_blank"
                                            class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i>
                                            sweetalert2.github.io</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
