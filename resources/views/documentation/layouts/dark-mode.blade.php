@extends('layouts.vertical', ['title' => 'Dark Mode'])

@section('css')
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Document', 'title' => 'Dark Mode'])

    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Dark Mode Setting</h4>

                <div class="ms-auto">
                    <a href="https://webapplayers.com/inspinia/classic/dark.html" target="_blank"
                        class="btn btn-soft-success ms-auto">Dark Preview</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="text-muted">
                            Simply add the attribute <code>data-bs-theme="dark"</code> to the <code>&lt;html&gt;</code> tag.
                            This will enable Dark Mode instantly—no need to modify any CSS or JavaScript files.
                        </p>

                        <pre class="bg-light d-inline-flex rounded">
                                    <code class="language-html">
                                        &lt;html lang=&quot;en&quot; data-bs-theme=&quot;dark&quot;&gt;
                                    </code>
                                </pre>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>

    </div>
@endsection

@section('scripts')
@endsection
