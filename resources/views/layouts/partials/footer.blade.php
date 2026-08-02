<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                © {{ $appProfil->created_year ?? date('Y') }}
                {{ $appProfil->footer_text ?? 'Inspinia By' }}
                @if(!empty($appProfil->developer_url))
                    <a href="{{ $appProfil->developer_url }}" target="_blank" class="fw-semibold text-reset">{{ $appProfil->developer_name ?? 'WebAppLayers' }}</a>
                @else
                    <span class="fw-semibold">{{ $appProfil->developer_name ?? 'WebAppLayers' }}</span>
                @endif
            </div>
            <div class="col-md-6">
                <div class="text-md-end d-none d-md-block">
                    <span class="badge bg-primary-subtle text-primary font-monospace me-1">{{ $appProfil->app_version ?? 'v1.9.0' }}</span>
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
