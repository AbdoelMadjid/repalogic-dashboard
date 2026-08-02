@extends('layouts.vertical')

@section('title', 'Profil Pengguna')

@section('content')
    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Profil Pengguna', 'subtitle' => 'Master Data'])

    <div class="row">
        <div class="col-12">
            <article class="card card-out-of-container border-top-0 shadow-sm mb-4">
                <div class="position-relative card-side-img overflow-hidden"
                    style="height: 250px; background-image: url('{{ asset('assets/images/profile-bg.jpg') }}')">
                    <div class="p-4 card-img-overlay rounded-start-0 auth-overlay d-flex align-items-center justify-content-center">
                        <h3 class="text-white mb-0 fst-italic">"Pengaturan Profil Akun & Data Kelengkapan Pengguna"</h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <div style="width: 90px; height: 90px; flex-shrink: 0;">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; object-fit: cover; aspect-ratio: 1 / 1;" />
                            </div>
                            <div>
                                <h4 class="text-nowrap fw-bold mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-1"><i class="ti ti-mail me-1"></i>{{ $user->email }}</p>
                                <span class="badge bg-primary-subtle text-primary fw-medium fs-xs">{{ $user->role_name }}</span>
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

                            <!-- Menu Titik 3 -->
                            <div class="dropdown">
                                <button class="btn btn-icon btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots fs-24"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-edit-profil">
                                            <i class="ti ti-user-edit me-2"></i> Edit Profil Singkat (Modal)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profil-pengguna.edit') }}">
                                            <i class="ti ti-id-badge me-2"></i> Edit Kelengkapan Data KTP
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="ti ti-user-circle me-1 text-primary"></i> Informasi Akun</h5>
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
                            <span class="fs-12 text-muted d-block">Peran / Hak Akses</span>
                            <span class="badge bg-warning-subtle text-warning fs-12 fw-semibold">{{ $user->role_name }}</span>
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
        </div>

        <!-- Detail Data KTP & Alamat Lengkap -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="ti ti-id me-1 text-primary"></i> Detail Kelengkapan Data KTP & Alamat</h5>
                    <a href="{{ route('admin.profil-pengguna.edit') }}" class="btn btn-sm btn-primary fw-semibold">
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
                            <thead class="table-light">
                                <tr>
                                    <th class="text-nowrap" style="width: 1%; white-space: nowrap;">Rincian Identitas KTP</th>
                                    <th>Nilai / Keterangan Data</th>
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
                                    style="width: 100px; height: 100px; min-width: 100px; min-height: 100px; object-fit: cover; aspect-ratio: 1 / 1;" />
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
                                    <input type="password" class="form-control" id="modal_password" name="password" placeholder="Kosongkan jika tidak diganti">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_password_confirmation" class="form-label fw-semibold text-dark">Konfirmasi Kata Sandi</label>
                                    <input type="password" class="form-control" id="modal_password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru">
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
            // Live Image Preview for Modal Avatar Upload
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
        });
    </script>
@endsection
