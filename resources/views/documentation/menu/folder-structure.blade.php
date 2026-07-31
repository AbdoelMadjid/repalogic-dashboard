@extends('layouts.vertical', ['title' => 'Folder Structure'])

@section('css')
    @vite(['node_modules/jstree/dist/themes/default/style.min.css'])
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Folder Structure'])

    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Folder Structure</h4>
            </div>
            <div class="card-body">
                <p class="text-muted fs-16 mb-3">After purchasing, extract the ZIP file you received. Inside,
                    you'll find the following files and folders exactly as listed below:
                </p>
                <div id="jstree-1">
                    <ul>
                        <li data-jstree='{ "opened" : true, "icon" : "ti ti-folder-open text-warning fs-lg" }'>
                            app
                            <ul>
                                <li>Http</li>
                                <li>Models</li>
                                <li>Providers</li>
                            </ul>
                        </li>
                        <li>bootstrap</li>
                        <li>config</li>
                        <li>database</li>
                        <li data-jstree='{ "opened" : true, "icon" : "ti ti-folder-open text-warning fs-lg" }'>
                            public
                            <ul>
                                <li>Data</li>
                                <li>Image</li>
                            </ul>
                        </li>

                        <li data-jstree='{ "opened" : true, "icon" : "ti ti-folder-open text-warning fs-lg" }'>
                            resources
                            <ul>
                                <li>js</li>
                                <li data-jstree='{ "opened" : true, "icon" : "ti ti-folder-open text-warning fs-lg" }'>
                                    scss
                                    <ul>
                                        <li
                                            data-jstree='{ "opened" : true, "icon" : "ti ti-folder-open text-warning fs-lg" }'>
                                            config
                                            <ul>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>
                                                    _themes-classic.scss
                                                    <span class="text-muted"> (INSPINIA comes
                                                        with the Classic Skin as its default
                                                        Theme.)</span>
                                                </li>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>
                                                    _themes-material.scss</li>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>
                                                    _themes-modern.scss</li>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>
                                                    _themes-saas.scss</li>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>
                                                    _themes-minimal.scss</li>
                                                <li data-jstree='{ "icon" : "ti ti-file-text text-danger fs-lg" }'><span
                                                        class="text-decoration-line-through">_themes-galaxy.scss</span>
                                                    <span class="text-muted"> COMING SOON</span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>component</li>
                                        <li>pages</li>
                                        <li>plugin</li>
                                        <li>structure</li>
                                        <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>app.scss</li>
                                    </ul>
                                </li>
                                <li>views</li>
                            </ul>
                        </li>
                        <li>routes</li>
                        <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>.env.example</li>
                        <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>composer.json</li>
                        <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>package.json</li>
                        <li data-jstree='{ "icon" : "ti ti-file-text text-success fs-lg" }'>vite.config.js</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
@endsection

@section('scripts')
    @vite(['resources/js/pages/misc-treeview.js'])
@endsection
