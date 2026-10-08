<!-- Widget Progress Kelengkapan Profil -->
@php
    $completion = $user->profile_completion_percentage;
    $progressBg = $completion >= 80 ? 'bg-success' : ($completion >= 50 ? 'bg-warning' : 'bg-danger');
    $badgeBg = $completion >= 80 ? 'bg-success-subtle text-success' : ($completion >= 50 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger');
@endphp
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-chart-pie fs-20 text-primary"></i>
                <h6 class="mb-0 fw-bold text-dark">Status Kelengkapan Data Profil</h6>
            </div>
            <span class="badge {{ $badgeBg }} fs-12 fw-bold font-monospace px-2 py-1">{{ $completion }}% Terlengkap</span>
        </div>
        <div class="progress progress-sm rounded-pill mb-2" style="height: 10px;">
            <div class="progress-bar {{ $progressBg }} progress-bar-striped progress-bar-animated rounded-pill" role="progressbar" style="width: {{ $completion }}%;" aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="fs-12 text-muted d-flex align-items-center justify-content-between">
            <span>
                @if ($completion >= 100)
                    <i class="ti ti-circle-check-filled text-success me-1"></i> Data profil Anda sudah <strong>100% Lengkap!</strong>
                @else
                    <i class="ti ti-info-circle text-warning me-1"></i> Lengkapi formulir identitas KTP & rincian alamat di bawah untuk mencapai 100%.
                @endif
            </span>
        </div>
    </div>
</div>
