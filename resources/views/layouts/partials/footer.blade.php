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
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
