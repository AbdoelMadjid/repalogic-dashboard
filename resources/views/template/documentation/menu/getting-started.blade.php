@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Header -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-dark text-white shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-primary text-white fw-semibold px-3 py-1.5 rounded-pill mb-3">Quick Setup Guide</span>
                    <h2 class="fw-bold text-white mb-2">Getting Started with Repalogic & INSPINIA</h2>
                    <p class="text-white-50 fs-16 mb-0">Follow this step-by-step setup guide to install dependencies, configure environment variables, and run your development server in minutes.</p>
                </div>
            </div>
        </div>

        <!-- System Prerequisites -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-checklist me-2 text-primary"></i>System Prerequisites</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light-subtle">
                                <i class="ti ti-brand-php text-primary display-6 mb-2"></i>
                                <h6 class="fw-bold mb-1">PHP >= 8.2</h6>
                                <span class="text-muted fs-12">BCMath, Ctype, Fileinfo, Mbstring</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light-subtle">
                                <i class="ti ti-box text-success display-6 mb-2"></i>
                                <h6 class="fw-bold mb-1">Composer 2.x</h6>
                                <span class="text-muted fs-12">PHP Dependency Manager</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light-subtle">
                                <i class="ti ti-brand-nodejs text-warning display-6 mb-2"></i>
                                <h6 class="fw-bold mb-1">Node.js >= 18.x</h6>
                                <span class="text-muted fs-12">JavaScript Runtime</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 bg-light-subtle">
                                <i class="ti ti-brand-vite text-info display-6 mb-2"></i>
                                <h6 class="fw-bold mb-1">Vite Build Tool</h6>
                                <span class="text-muted fs-12">Asset Bundling & HMR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step-by-Step Installation -->
        <div class="col-12 mb-4">
            <h4 class="fw-bold mb-3">Installation Steps</h4>
            <div class="d-flex flex-column gap-3">
                <!-- Step 1 -->
                <div class="card border">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-primary rounded-circle p-2 fs-16 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">1</span>
                            <div class="w-100">
                                <h5 class="fw-bold mb-1">Install PHP & Node Dependencies</h5>
                                <p class="text-muted fs-14 mb-3">Open your terminal in the project root directory and run the following commands to install PHP vendor packages and Node npm modules:</p>
                                <div class="bg-dark text-white p-3 rounded-3 font-monospace fs-13">
                                    <div class="text-success"># Install PHP packages</div>
                                    <div>composer install</div>
                                    <div class="text-success mt-2"># Install Node modules</div>
                                    <div>npm install</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="card border">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-primary rounded-circle p-2 fs-16 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">2</span>
                            <div class="w-100">
                                <h5 class="fw-bold mb-1">Configure Environment File & App Key</h5>
                                <p class="text-muted fs-14 mb-3">Duplicate the `.env.example` file to create your `.env` configuration file, then generate an application encryption key:</p>
                                <div class="bg-dark text-white p-3 rounded-3 font-monospace fs-13">
                                    <div class="text-success"># Copy environment template</div>
                                    <div>cp .env.example .env</div>
                                    <div class="text-success mt-2"># Generate app encryption key</div>
                                    <div>php artisan key:generate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="card border">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="badge bg-primary rounded-circle p-2 fs-16 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">3</span>
                            <div class="w-100">
                                <h5 class="fw-bold mb-1">Run Development Server</h5>
                                <p class="text-muted fs-14 mb-3">Start the Vite development server and Laravel local web server:</p>
                                <div class="bg-dark text-white p-3 rounded-3 font-monospace fs-13">
                                    <div class="text-success"># Start Vite HMR server</div>
                                    <div>npm run dev</div>
                                    <div class="text-success mt-2"># Start Laravel dev server</div>
                                    <div>php artisan serve</div>
                                </div>
                                <div class="mt-3">
                                    <a href="http://127.0.0.1:8000" target="_blank" class="btn btn-sm btn-primary fw-semibold"><i class="ti ti-external-link me-1"></i> Open http://127.0.0.1:8000</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
