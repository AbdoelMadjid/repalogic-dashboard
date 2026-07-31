@extends('layouts.vertical', ['title' => 'Theme Skin Setup'])

@section('css')
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Theme Skin Setup'])

    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="font-weight-semibold mb-0">Using Pre-built Themes from INSPINIA v4.0</h4>
            </div>

            <div class="card-body">
                <p class="text-muted mb-4">Switch between multiple built-in themes by setting the data-skin attribute in the
                    <html> tag. Themes like Classic, Material, Modern, SaaS, Flat, and Minimal are pre-configured for quick
                    integration and visual consistency across your layout.
                </p>

                <h5 class="mb-2">Classic Theme (Default Classic Theme)</h5>
                <div
                    class="alert alert-primary alert-bordered border-start border-primary d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div class="fw-bold text-decoration-underline">
                        INSPINIA comes with the Classic Theme set as the Default.
                    </div>
                    <a href="https://webapplayers.com/inspinia/classic/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>


                <h5 class="mb-2">Material Theme</h5>
                <div
                    class="alert alert-secondary alert-bordered border-start border-secondary d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div>
                        Set <code>data-skin="material"</code> in the <code>&lt;html&gt;</code> tag to use the Material
                        theme.
                    </div>
                    <a href="https://webapplayers.com/inspinia/material/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>


                <h5 class="mb-2">Modern Theme</h5>
                <div
                    class="alert alert-success alert-bordered border-start border-success d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div>
                        Set <code>data-skin="modern"</code> in the <code>&lt;html&gt;</code> tag to use the Modern theme.
                    </div>
                    <a href="https://webapplayers.com/inspinia/modern/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>

                <h5 class="mb-2">SaaS Theme</h5>
                <div class="alert alert-info alert-bordered border-start border-info d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div>
                        Set <code>data-skin="saas"</code> in the <code>&lt;html&gt;</code> tag to use the SaaS theme.
                    </div>
                    <a href="https://webapplayers.com/inspinia/saas/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>

                <h5 class="mb-2">Flat Theme</h5>
                <div
                    class="alert alert-purple alert-bordered border-start border-purple d-flex align-items-center gap-2 mb-3">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div>
                        Set <code>data-skin="flat"</code> in the <code>&lt;html&gt;</code> tag to use the Flat theme.
                    </div>
                    <a href="https://webapplayers.com/inspinia/flat/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>

                <h5 class="mb-2">Minimal Theme</h5>
                <div
                    class="alert alert-danger alert-bordered border-start border-danger d-flex align-items-center gap-2 mb-0">
                    <i class="ti ti-info-circle fs-20"></i>
                    <div>
                        Set <code>data-skin="minimal"</code> in the <code>&lt;html&gt;</code> tag to use the Minimal theme.
                    </div>
                    <a href="https://webapplayers.com/inspinia/minimal/index.html" target="_blank"
                        class="btn btn-dark ms-auto">Preview</a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
