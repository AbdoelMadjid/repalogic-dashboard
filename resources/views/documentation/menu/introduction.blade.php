@extends('layouts.vertical', ['title' => 'Introduction'])

@section('css')
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Introduction'])

    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="font-weight-semibold mb-0">Introduction</h4>
            </div>

            <div class="card-body">
                <div class="alert alert-success mb-3 fs-15">
                    <strong>New in v4:</strong> 6 built-in theme skins, multiple sidebar and topbar modes, scrollable and
                    boxed layouts, and a completely modular SCSS + Gulp development workflow.
                </div>

                <h5 class="text-dark fs-14 mb-2">
                    Thank you for choosing <span class="fw-semibold">INSPINIA</span> – Your Trusted Admin & Dashboard
                    Template All in One Solution.
                </h5>

                <p class="text-muted fs-14 mb-0">
                    <span class="fw-semibold">INSPINIA v4</span> is a fully reimagined version, offering enhanced design,
                    flexible layouts, and support for multiple themes, topbars, and sidebars. Whether you're building a CRM,
                    analytics dashboard, SaaS platform, or internal admin tool, INSPINIA gives you everything you need to
                    create a fast, professional, and beautiful application.
                </p>

                <p class="text-muted fs-14 mb-4">
                    This template is crafted with modern web standards and is powered by <span class="fw-semibold">Bootstrap
                        v5.3.8 and Laravel v12</span>, ensuring a responsive and scalable experience across all devices.
                </p>


                <h5 class="text-dark fs-14 mb-3">
                    If you have any questions, feedback, or need assistance, feel free to reach out via our profile:
                    <a href="https://wrapbootstrap.com/user/WebAppLayers/message"
                        target="_blank">https://wrapbootstrap.com/user/WebAppLayers/message</a>
                </h5>

                <p class="text-muted fs-14">
                    We’re here to help! This documentation provides an overview of INSPINIA’s core features, components, and
                    usage. We’ll continue to improve and expand it with future updates.
                </p>

                <p class="text-muted fs-15 mb-0">
                    Thank you once again for choosing <span class="fw-semibold">INSPINIA</span>. We hope it accelerates your
                    development and helps you deliver outstanding results.
                </p>

            </div>
        </div>


        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bold mb-0 float-end">
                            <a class="btn btn-soft-primary d-flex stretched-link"
                                href="https://webapplayers.com/inspinia/classic/index.html" target="_blank">Start now <i
                                    class="icon-base ti ti-chevron-right"></i></a>
                        </p>

                        <div class="badge badge-soft-danger p-3 mb-3">
                            <i class="icon-base ti ti-rocket fs-28"></i>
                        </div>
                        <h4>Explore INSPINIA v1.0</h4>
                        <h5 class="text-muted fs-15  mb-0">Kickstart your project with INSPINIA and easily set up theming,
                            Dark mode, and RTL support.
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
