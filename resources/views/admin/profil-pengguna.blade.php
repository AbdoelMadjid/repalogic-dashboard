@extends('layouts.vertical')

@section('title', 'Profil Pengguna')

@section('content')
    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Profil Pengguna', 'subtitle' => 'Master Data'])

    <div class="row">
        <div class="col-12">
            <article class="card card-out-of-container border-top-0 shadow-sm mb-4">
                <div id="main-header-banner" class="position-relative card-side-img overflow-hidden"
                    style="height: 250px; background-image: url('{{ $user->cover_bg_url }}'); background-size: cover; background-position: center {{ $user->cover_position_y }}%;">
                    <div class="p-4 card-img-overlay rounded-start-0 auth-overlay d-flex align-items-center justify-content-center">
                        <h3 class="text-white mb-0 fst-italic text-center px-3" id="main-motto-display">"{{ $user->motto }}"</h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <div style="width: 90px; height: 90px; flex-shrink: 0;">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                            </div>
                            <div>
                                <h4 class="text-nowrap fw-bold mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-1"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                                <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                    <span class="badge bg-primary-subtle text-primary fw-medium px-2 py-1 fs-xs">{{ $user->role_name }}</span>
                                    <span class="badge bg-warning-subtle text-warning fw-medium px-2 py-1 fs-xs" title="Total Poin Login yang Dikumpulkan">
                                        <i class="ti ti-award me-1"></i> {{ number_format($user->login_count ?? 0) }} Poin Login
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <!-- Tombol Modal Edit Profil Utama -->
                            <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-edit-profil">
                                <i class="ti ti-edit me-1"></i> Edit Profil
                            </button>

                            <!-- Tombol Kelengkapan Data KTP -->
                            <a href="{{ route('admin.profil-pengguna.edit') }}" class="btn btn-outline-primary fw-semibold">
                                <i class="ti ti-id me-1"></i> Kelengkapan Data KTP
                            </a>

                            <!-- Tombol Pesan / Chat -->
                            <a href="{{ route('admin.profil-pengguna.messages.index') }}" class="btn btn-outline-success fw-semibold" id="btn-user-messages" title="Fitur Pesan / Obrolan">
                                <i class="ti ti-message me-1"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Personal Info -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-user-circle me-1"></i> Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="avatar-sm bg-primary-subtle text-primary d-flex align-items-center justify-content-center rounded">
                            <i class="ti ti-user fs-18"></i>
                        </div>
                        <div>
                            <span class="fs-12 text-muted d-block">Nama Lengkap</span>
                            <span class="text-dark fw-semibold fs-14">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="avatar-sm bg-info-subtle text-info d-flex align-items-center justify-content-center rounded">
                            <i class="ti ti-mail fs-18"></i>
                        </div>
                        <div>
                            <span class="fs-12 text-muted d-block">Alamat Email</span>
                            <a href="mailto:{{ $user->email }}" class="text-primary fw-semibold fs-14">{{ $user->email }}</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="avatar-sm bg-warning-subtle text-warning d-flex align-items-center justify-content-center rounded">
                            <i class="ti ti-shield-lock fs-18"></i>
                        </div>
                        <div>
                            <span class="fs-12 text-muted d-block">Peran & Akumulasi Poin</span>
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <span class="badge bg-primary-subtle text-primary fs-12 fw-semibold px-2 py-1">{{ $user->role_name }}</span>
                                <span class="badge bg-warning-subtle text-warning fs-12 fw-semibold px-2 py-1" title="Total Poin Login (Maks 1 Poin per 24 Jam)">
                                    <i class="ti ti-award me-1"></i> {{ number_format($user->login_count ?? 0) }} Poin
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="avatar-sm bg-success-subtle text-success d-flex align-items-center justify-content-center rounded">
                            <i class="ti ti-calendar fs-18"></i>
                        </div>
                        <div>
                            <span class="fs-12 text-muted d-block">Tanggal Terdaftar</span>
                            <span class="text-dark fw-semibold fs-14">{{ $user->created_at ? $user->created_at->format('d F Y (H:i)') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Foto Sampul / Background Header -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-photo me-1"></i> Foto Sampul Background Header</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-pengguna.update-cover') }}" method="POST" enctype="multipart/form-data" id="form-update-cover">
                        @csrf
                        <div class="mb-3 text-center">
                            <div class="position-relative mb-2 overflow-hidden rounded border shadow-sm" style="height: 130px;">
                                <img src="{{ $user->cover_bg_url }}" id="cover-preview-img" alt="Background Header" class="w-100 h-100 object-fit-cover" style="object-fit: cover; object-position: center {{ $user->cover_position_y }}%;" />
                            </div>
                            <label for="cover_bg_input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-2">
                                <i class="ti ti-camera me-1"></i> Pilih / Ganti Foto Sampul
                            </label>
                            <input type="file" name="cover_image" id="cover_bg_input" class="d-none" accept="image/*">
                        </div>

                        <!-- Slider Pengatur Posisi Vertikal -->
                        <div class="mb-3 p-2 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="cover-position-range" class="form-label fs-12 fw-bold text-dark mb-0 d-flex align-items-center gap-1">
                                    <i class="ti ti-arrows-vertical text-primary fs-15"></i> Posisi Atas - Bawah:
                                </label>
                                <span id="cover-pos-val" class="badge bg-primary-subtle text-primary font-monospace fs-12 fw-bold">{{ $user->cover_position_y }}%</span>
                            </div>
                            <input type="range" class="form-range mb-2" id="cover-position-range" name="cover_position_y" min="0" max="100" value="{{ $user->cover_position_y }}">
                            <div class="d-flex justify-content-between gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="0">Atas (0%)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="50">Tengah (50%)</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 btn-preset-pos" data-pos="100">Bawah (100%)</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Posisi / Foto Sampul
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Motto Hidup / Kutipan Profil -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-quote me-1"></i> Motto Hidup / Kutipan Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil-pengguna.update-motto') }}" method="POST" id="form-update-motto">
                        @csrf
                        <div class="mb-3">
                            <label for="motto_input" class="form-label fs-13 fw-semibold text-dark mb-1">Motto / Kata-Kata Bijak:</label>
                            <textarea name="motto" id="motto_input" rows="3" class="form-control" placeholder="Tuliskan motto hidup Anda..." maxlength="255" required>{{ old('motto', $user->motto) }}</textarea>
                            <span class="fs-12 text-muted d-block mt-1">Motto ini akan ditampilkan di atas banner foto sampul Anda.</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Motto Hidup
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Detail Data KTP & Alamat Lengkap -->
        <div class="col-xl-8 col-lg-7">
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
                                <i class="ti ti-info-circle text-warning me-1"></i> Lengkapi data identitas KTP & rincian alamat untuk mencapai 100%.
                            @endif
                        </span>
                        @if ($completion < 100)
                            <a href="{{ route('admin.profil-pengguna.edit') }}" class="text-primary fw-semibold text-decoration-none">Lengkapi Sekarang <i class="ti ti-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-id me-1"></i> Detail Kelengkapan Data KTP & Alamat</h5>
                    <a href="{{ route('admin.profil-pengguna.edit') }}" class="btn btn-sm btn-light text-primary fw-semibold">
                        <i class="ti ti-edit me-1"></i> Edit Data KTP
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $detail = $user->detail;
                    @endphp

                    @if (!$detail || empty($detail->nik))
                        <div class="alert alert-warning border-0 d-flex align-items-center gap-2 mb-4">
                            <i class="ti ti-alert-triangle fs-20"></i>
                            <div>
                                <strong>Data KTP Belum Lengkap:</strong> Anda belum melengkapi data identitas KTP dan rincian alamat terpisah. Silakan klik tombol <strong>Edit Data KTP</strong> untuk melengkapi profil Anda.
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle border mb-0">
                            <thead class="table-light align-middle text-center text-nowrap">
                                <tr class="align-middle text-center text-nowrap">
                                    <th class="text-center align-middle text-nowrap" style="width: 1%;">Rincian Identitas KTP</th>
                                    <th class="text-center align-middle text-nowrap">Nilai / Keterangan Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-credit-card me-1 text-muted"></i> NIK (Nomor Induk Kependudukan)</td>
                                    <td><span class="fs-13 text-dark fw-semibold">{{ $detail?->nik ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-user me-1 text-muted"></i> Nama Lengkap (Sesuai KTP)</td>
                                    <td><span class="fs-13 text-dark fw-semibold">{{ $detail?->nama_ktp ?? $user->name }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-map-pin me-1 text-muted"></i> Tempat & Tanggal Lahir</td>
                                    <td>
                                        <span class="fs-13 text-dark">
                                            {{ $detail?->tempat_lahir ?? '-' }}, {{ $detail?->tanggal_lahir ? $detail->tanggal_lahir->format('d F Y') : '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-gender-bigender me-1 text-muted"></i> Jenis Kelamin</td>
                                    <td><span class="badge bg-info-subtle text-info fs-12">{{ $detail?->jenis_kelamin ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-droplet me-1 text-muted"></i> Golongan Darah</td>
                                    <td><span class="badge bg-danger-subtle text-danger fs-12">{{ $detail?->golongan_darah ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-building-church me-1 text-muted"></i> Agama</td>
                                    <td><span class="fs-13 text-dark">{{ $detail?->agama ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-heart me-1 text-muted"></i> Status Perkawinan</td>
                                    <td><span class="fs-13 text-dark">{{ $detail?->status_perkawinan ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-briefcase me-1 text-muted"></i> Pekerjaan</td>
                                    <td><span class="fs-13 text-dark">{{ $detail?->pekerjaan ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-world me-1 text-muted"></i> Kewarganegaraan</td>
                                    <td><span class="fs-13 text-dark">{{ $detail?->kewarganegaraan ?? 'WNI' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-home me-1 text-muted"></i> Alamat Jalan / Rumah</td>
                                    <td><span class="fs-13 text-dark">{{ $detail?->alamat_jalan ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-map me-1 text-muted"></i> RT / RW / Blok</td>
                                    <td>
                                        <span class="fs-13 text-dark">
                                            RT: <strong>{{ $detail?->rt ?? '-' }}</strong> | RW: <strong>{{ $detail?->rw ?? '-' }}</strong> | Blok: <strong>{{ $detail?->blok ?? '-' }}</strong>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-building-community me-1 text-muted"></i> Desa / Kelurahan & Kecamatan</td>
                                    <td>
                                        <span class="fs-13 text-dark">
                                            Desa/Kel. {{ $detail?->desa_kelurahan ?? '-' }}, Kec. {{ $detail?->kecamatan ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark text-nowrap"><i class="ti ti-map-2 me-1 text-muted"></i> Kabupaten/Kota & Provinsi</td>
                                    <td>
                                        <span class="fs-13 text-dark">
                                            {{ $detail?->kabupaten_kota ?? '-' }}, {{ $detail?->provinsi ?? '-' }} (Kode Pos: {{ $detail?->kode_pos ?? '-' }})
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Permohonan Penonaktifan Akun (Danger Zone) -->
            <div class="card shadow-sm border border-danger-subtle mb-4">
                <div class="card-header bg-danger text-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="card-title text-white mb-0 fw-bold">
                        <i class="ti ti-user-x me-1"></i> Permohonan Penonaktifan Akun
                    </h5>
                    <span class="badge bg-white bg-opacity-25 text-white font-monospace fs-11">Danger Zone</span>
                </div>
                <div class="card-body">
                    @if ($user->isDeactivationRequested())
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-0 rounded-3" style="background-color: #fffbeb; color: #92400e;">
                            <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1">
                                <i class="ti ti-hourglass-low fs-20"></i>
                            </div>
                            <div class="w-100">
                                <h6 class="fw-bold mb-1 text-dark">Permohonan Penonaktifan Sedang Diproses</h6>
                                <p class="fs-13 mb-2 text-muted">
                                    Anda telah mengajukan permohonan penonaktifan akun pada <strong class="text-dark">{{ $user->deactivation_requested_at->format('d F Y (H:i)') }} WIB</strong>. Permintaan ini sedang menunggu tinjauan dan konfirmasi dari Administrator sistem.
                                </p>
                                @if(!empty($user->deactivation_reason))
                                    <div class="p-3 bg-white border border-warning-subtle rounded-2 fs-13 mb-2">
                                        <strong class="text-dark d-block mb-1"><i class="ti ti-notes me-1"></i>Alasan Pengajuan:</strong>
                                        <span class="text-secondary fst-italic">"{{ $user->deactivation_reason }}"</span>
                                    </div>
                                @endif
                                <form action="{{ route('admin.profil-pengguna.cancel-deactivation') }}" method="POST" data-confirm="Apakah Anda yakin ingin membatalkan permohonan penonaktifan akun Anda?">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning fw-semibold">
                                        <i class="ti ti-x me-1"></i> Batalkan Permohonan Penonaktifan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h6 class="fw-bold text-dark mb-1">Ingin menonaktifkan akun Anda?</h6>
                                <p class="text-muted fs-13 mb-0">
                                    Jika Anda ingin berhenti menggunakan layanan untuk sementara atau permanen, Anda dapat mengajukan permohonan penonaktifan akun kepada Administrator. Setelah disetujui, akun Anda tidak akan dapat digunakan untuk masuk ke dalam sistem.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <button type="button" class="btn btn-outline-danger fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-request-deactivation">
                                    <i class="ti ti-user-off me-1"></i> Minta Nonaktifkan Akun
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PERMINTAAN NONAKTIFKAN AKUN (RULE 4 COMPLIANCE) -->
    <div class="modal fade" id="modal-request-deactivation" tabindex="-1" aria-labelledby="modalRequestDeactivationLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-alert-triangle fs-22"></i>
                        <h5 class="modal-title text-white mb-0" id="modalRequestDeactivationLabel">Ajukan Penonaktifan Akun</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.profil-pengguna.request-deactivation') }}" method="POST" id="form-request-deactivation">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="alert alert-danger border-0 d-flex align-items-start gap-2 mb-3 py-2 px-3 rounded-3" style="background-color: #fef2f2; color: #991b1b;">
                            <i class="ti ti-alert-circle fs-20 flex-shrink-0 mt-1"></i>
                            <div class="fs-13">
                                <strong>Perhatian:</strong> Permintaan penonaktifan akun akan dikirimkan langsung ke Administrator. Setelah disetujui, Anda tidak akan dapat masuk kembali hingga diaktifkan oleh admin.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deactivation_reason" class="form-label fw-semibold text-dark">Alasan Penonaktifan (Opsional):</label>
                            <textarea name="reason" id="deactivation_reason" rows="3" class="form-control" placeholder="Tuliskan alasan mengapa Anda ingin menonaktifkan akun ini..." maxlength="500"></textarea>
                            <span class="fs-12 text-muted d-block mt-1">Alasan ini akan ditinjau oleh administrator sebelum akun dinonaktifkan.</span>
                        </div>
                    </div>

                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 fw-semibold">
                            <i class="ti ti-send me-1"></i> Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT PROFIL (RULE 4 COMPLIANCE: Clean modal-lg layout) -->
    <div class="modal fade" id="modal-edit-profil" tabindex="-1" aria-labelledby="modalEditProfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-user-edit fs-22"></i>
                        <h5 class="modal-title text-white mb-0" id="modalEditProfilLabel">Edit Profil Singkat</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.profil-pengguna.update-quick') }}" method="POST" enctype="multipart/form-data" id="form-quick-edit-profil">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4 text-center">
                            <div class="d-inline-block position-relative mb-2">
                                <img src="{{ $user->avatar_url }}" id="modal-avatar-preview" alt="avatar"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 100px; height: 100px; min-width: 100px; min-height: 100px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                            </div>
                            <div>
                                <label for="modal-avatar-input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-0">
                                    <i class="ti ti-camera me-1"></i> Pilih Foto Avatar
                                </label>
                                <input type="file" name="avatar" id="modal-avatar-input" class="d-none" accept="image/*">
                            </div>
                            <span class="fs-12 text-muted d-block mt-1">Format: JPG, PNG, WEBP, SVG (Maks 2MB)</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modal_name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_email" class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="modal_email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_password" class="form-label fw-semibold text-dark">Kata Sandi Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="modal_password" name="password" placeholder="Kosongkan jika tidak diganti">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password" title="Lihat/Sembunyikan Kata Sandi">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_password_confirmation" class="form-label fw-semibold text-dark">Konfirmasi Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="modal_password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password_confirmation" title="Lihat/Sembunyikan Kata Sandi">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Page JS (Rule 1 Compliance: Place scripts inside @section('content') before @endsection) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Live Image Preview for Modal Avatar Upload
            const modalAvatarInput = document.getElementById('modal-avatar-input');
            const modalAvatarPreview = document.getElementById('modal-avatar-preview');

            if (modalAvatarInput && modalAvatarPreview) {
                modalAvatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            modalAvatarPreview.src = evt.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // 2. Live Image Preview & Real-time Vertical Position Slider for Cover Background Header
            const coverInput = document.getElementById('cover_bg_input');
            const coverPreview = document.getElementById('cover-preview-img');
            const coverForm = document.getElementById('form-update-cover');
            const mainHeaderBanner = document.getElementById('main-header-banner');
            const coverPosRange = document.getElementById('cover-position-range');
            const coverPosVal = document.getElementById('cover-pos-val');
            const presetButtons = document.querySelectorAll('.btn-preset-pos');

            function updateCoverPosition(pos) {
                const posPercent = pos + '%';
                if (coverPosVal) {
                    coverPosVal.textContent = posPercent;
                }
                if (coverPosRange) {
                    coverPosRange.value = pos;
                }
                if (coverPreview) {
                    coverPreview.style.objectPosition = 'center ' + posPercent;
                }
                if (mainHeaderBanner) {
                    mainHeaderBanner.style.backgroundPosition = 'center ' + posPercent;
                }
            }

            if (coverPosRange) {
                coverPosRange.addEventListener('input', function(e) {
                    updateCoverPosition(e.target.value);
                });
            }

            presetButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const pos = this.getAttribute('data-pos');
                    updateCoverPosition(pos);
                });
            });

            if (coverInput) {
                coverInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            if (coverPreview) {
                                coverPreview.src = evt.target.result;
                            }
                            if (mainHeaderBanner) {
                                mainHeaderBanner.style.backgroundImage = 'url("' + evt.target.result + '")';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // 3. Real-time Motto Typing Preview
            const mottoInput = document.getElementById('motto_input');
            const mottoDisplay = document.getElementById('main-motto-display');
            if (mottoInput && mottoDisplay) {
                mottoInput.addEventListener('input', function() {
                    mottoDisplay.textContent = '"' + (this.value || 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.') + '"';
                });
            }

            // 4. Toggle Show/Hide Password Eye Icons (Rule 2 & Rule 7 Compliance: Event Delegation via data-input-id)
            document.addEventListener('click', function(e) {
                const toggleBtn = e.target.closest('.toggle-password');
                if (toggleBtn) {
                    const targetId = toggleBtn.getAttribute('data-input-id');
                    const inputField = document.getElementById(targetId);
                    const icon = toggleBtn.querySelector('i');

                    if (inputField) {
                        if (inputField.type === 'password') {
                            inputField.type = 'text';
                            if (icon) {
                                icon.classList.remove('ti-eye');
                                icon.classList.add('ti-eye-off');
                            }
                        } else {
                            inputField.type = 'password';
                            if (icon) {
                                icon.classList.remove('ti-eye-off');
                                icon.classList.add('ti-eye');
                            }
                        }
                    }
                }
            });
            // 5. Listener Tombol Pesan / Chat pada Header Profil Pengguna
            const btnUserMessages = document.getElementById('btn-user-messages');
            if (btnUserMessages) {
                btnUserMessages.addEventListener('click', function() {
                    const topbarMsgBtn = document.getElementById('topbar-messages-toggle-btn');
                    if (topbarMsgBtn && window.bootstrap && window.bootstrap.Dropdown) {
                        const bsDropdown = window.bootstrap.Dropdown.getOrCreateInstance(topbarMsgBtn);
                        bsDropdown.toggle();
                    } else if (typeof window.showToast === 'function') {
                        window.showToast('Fitur Pesan Siap Digunakan!', 'success');
                    }
                });
            }
        });
    </script>
@endsection
