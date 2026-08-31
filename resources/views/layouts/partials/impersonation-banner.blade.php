@if (session()->has('impersonator_id'))
    <div class="impersonation-banner-wrapper bg-gradient bg-warning text-dark py-2 px-3 shadow-sm border-bottom border-warning-subtle" style="position: relative; z-index: 1000;">
        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-dark text-warning p-1 rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i class="ti ti-replace-user fs-16"></i>
                </span>
                <div>
                    <span class="fw-bold fs-13">Mode Switch Akun Aktif:</span>
                    <span class="fs-13 text-dark">
                        Anda sedang menjelajah sebagai <strong>{{ auth()->user()->name }}</strong> 
                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle fs-11 ms-1">
                            {{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'User' }}
                        </span>
                        @if (session('impersonator_name'))
                            <span class="ms-1 d-none d-md-inline text-muted fs-12">
                                (Akun Asli: <strong>{{ session('impersonator_name') }}</strong>)
                            </span>
                        @endif
                    </span>
                </div>
            </div>
            <div>
                <form action="{{ route('admin.switch-back') }}" method="POST" class="d-inline" data-confirm="Kembali ke akun utama ({{ session('impersonator_name', 'Administrator') }})?" data-confirm-type="switch">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm fw-semibold shadow-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-back-up fs-15"></i>
                        <span>Kembali ke Akun Utama</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif
