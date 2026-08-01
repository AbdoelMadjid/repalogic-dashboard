@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Banner -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-primary bg-gradient text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-white text-primary fw-semibold px-3 py-1.5 rounded-pill mb-3">Layout Architecture</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="layouts-option">Layout Options & Customization</h2>
                    <p class="text-white-50 fs-16 mb-0">Learn how to customize page layouts via HTML attributes on the root `<html>` tag or Blade section wrappers.</p>
                </div>
            </div>
        </div>

        <!-- HTML Attributes Table -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-code me-2 text-primary"></i>HTML Layout Configuration Attributes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0 align-middle">
                            <thead class="bg-light bg-opacity-50 fs-xxs text-uppercase">
                                <tr>
                                    <th>Attribute</th>
                                    <th>Options / Values</th>
                                    <th>Default</th>
                                    <th>Description</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>data-layout</code></td>
                                    <td><code>vertical</code>, <code>topnav</code></td>
                                    <td><code>vertical</code></td>
                                    <td>Sets primary navigation layout (Vertical Sidenav vs Horizontal Topbar)</td>
                                    <td><a href="{{ route('template.layouts.options.horizontal') }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i> Topnav Preview</a></td>
                                </tr>
                                <tr>
                                    <td><code>data-layout-width</code></td>
                                    <td><code>fluid</code>, <code>boxed</code></td>
                                    <td><code>fluid</code></td>
                                    <td>Controls main container width (Full screen fluid vs Centered boxed container)</td>
                                    <td><a href="{{ route('template.layouts.options.boxed') }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i> Boxed Preview</a></td>
                                </tr>
                                <tr>
                                    <td><code>data-sidenav-size</code></td>
                                    <td><code>default</code>, <code>compact</code>, <code>condensed</code>, <code>offcanvas</code></td>
                                    <td><code>default</code></td>
                                    <td>Controls sidebar width and expansion behavior</td>
                                    <td><a href="{{ route('template.layouts.options.compact') }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i> Compact Preview</a></td>
                                </tr>
                                <tr>
                                    <td><code>data-topbar-color</code></td>
                                    <td><code>light</code>, <code>dark</code>, <code>gray</code>, <code>gradient</code></td>
                                    <td><code>light</code></td>
                                    <td>Sets the topbar header background color theme</td>
                                    <td><a href="{{ route('template.layouts.topbar.dark') }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="ti ti-external-link me-1"></i> Dark Topbar</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blade Section Usage Code Example -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-brand-php me-2 text-primary"></i>Passing Custom Attributes in Blade Views</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted fs-14 mb-3">In any Blade view in `resources/views/template/`, pass customized attributes via <code>{{ '@' }}section('html_attribute')</code>:</p>
                    <div class="bg-dark text-white p-3 rounded-3 font-monospace fs-13">
                        <div class="text-success">{{ '@' }}extends('layouts.vertical')</div>
                        <br>
                        <div class="text-warning">{{ '@' }}section('html_attribute') data-layout-width="boxed" data-topbar-color="dark" {{ '@' }}endsection</div>
                        <br>
                        <div>{{ '@' }}section('content')</div>
                        <div class="text-muted ps-3">&lt;!-- Your Page Content --&gt;</div>
                        <div>{{ '@' }}endsection</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
