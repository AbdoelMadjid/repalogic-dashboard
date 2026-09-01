@extends('layouts.vertical')

@section('title', 'Kelengkapan Data KTP & Alamat')

@section('content')
    <link href="{{ asset('assets/css/admin/profil-pengguna.css') }}" rel="stylesheet" type="text/css" />

    <!-- Header Page Title -->
    @include('layouts.partials.page-title', ['title' => 'Kelengkapan Data KTP & Alamat', 'subtitle' => 'Profil Pengguna'])

    <div class="row">
        <div class="col-12">
            <article class="card card-out-of-container border-top-0 shadow-sm mb-4">
                <div class="position-relative card-side-img overflow-hidden"
                    style="height: {{ min($user->cover_height, 280) }}px; background-image: url('{{ $user->cover_bg_url }}'); background-size: cover; background-position: center {{ $user->cover_position_y }}%;">
                    <div class="p-4 card-img-overlay rounded-start-0 flex-column gap-2 auth-overlay d-flex align-items-center justify-content-center">
                        <h3 class="text-white mb-0 fst-italic text-center px-3">"{{ $user->motto }}"</h3>
                    </div>
                </div>
            </article>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-id fs-22"></i>
                        <h5 class="card-title text-white mb-0">Kelengkapan Data Identitas KTP</h5>
                    </div>
                    <a href="{{ route('admin.profil-pengguna.index') }}" class="btn btn-light btn-sm text-primary fw-semibold">
                        <i class="ti ti-arrow-left me-1"></i> Kembali ke Profil
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.profil-pengguna.update-detail') }}" method="POST" enctype="multipart/form-data" id="form-user-detail">
                        @csrf

                        <!-- SECTION 1: DATA IDENTITAS KTP -->
                        <h5 class="mb-4 text-uppercase bg-light-subtle p-2 border-dashed border rounded border-light d-flex align-items-center gap-2 text-primary fw-bold fs-14">
                            <i class="ti ti-credit-card fs-20"></i> 1. Identitas Kependudukan (Sesuai KTP)
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label fw-semibold text-dark">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $detail->nik) }}" placeholder="16 Digit NIK KTP" maxlength="20">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label fw-semibold text-dark d-flex align-items-center justify-content-between">
                                        <span><i class="ti ti-brand-whatsapp text-success me-1"></i> Nomor Telepon / WhatsApp</span>
                                        <span class="badge bg-success-subtle text-success fs-xxs">WhatsApp Link</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="ti ti-phone"></i></span>
                                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $detail->telepon) }}" placeholder="Contoh: 081234567890" maxlength="30">
                                    </div>
                                    <div class="form-text fs-11 text-muted mt-1">Nomor telepon/WA aktif untuk komunikasi dan direktori kontak.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_ktp" class="form-label fw-semibold text-dark">Nama Lengkap Sesuai KTP</label>
                                    <input type="text" class="form-control" id="nama_ktp" name="nama_ktp" value="{{ old('nama_ktp', $detail->nama_ktp ?? $user->name) }}" placeholder="Nama lengkap sesuai KTP">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label fw-semibold text-dark">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $detail->tempat_lahir) }}" placeholder="Kota / Kabupaten Lahir">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold text-dark">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $detail->tanggal_lahir ? $detail->tanggal_lahir->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold text-dark">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="golongan_darah" class="form-label fw-semibold text-dark">Golongan Darah</label>
                                    <select class="form-select" id="golongan_darah" name="golongan_darah">
                                        <option value="">-- Pilih --</option>
                                        <option value="A" {{ old('golongan_darah', $detail->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('golongan_darah', $detail->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('golongan_darah', $detail->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('golongan_darah', $detail->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="agama" class="form-label fw-semibold text-dark">Agama</label>
                                    <select class="form-select" id="agama" name="agama">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam" {{ old('agama', $detail->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama', $detail->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katholik" {{ old('agama', $detail->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                        <option value="Hindu" {{ old('agama', $detail->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', $detail->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Khonghucu" {{ old('agama', $detail->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status_perkawinan" class="form-label fw-semibold text-dark">Status Perkawinan</label>
                                    <select class="form-select" id="status_perkawinan" name="status_perkawinan">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Belum Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label fw-semibold text-dark">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $detail->pekerjaan) }}" placeholder="e.g. Karyawan Swasta, PNS, Pengusaha">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kewarganegaraan" class="form-label fw-semibold text-dark">Kewarganegaraan</label>
                                    <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan', $detail->kewarganegaraan ?? 'WNI') }}" placeholder="WNI / WNA">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: RINCIAN ALAMAT TERPISAH -->
                        <h5 class="mb-4 text-uppercase bg-light-subtle p-2 border-dashed border rounded border-light d-flex align-items-center gap-2 text-primary fw-bold fs-14">
                            <i class="ti ti-map-pin fs-20"></i> 2. Rincian Alamat Domisili KTP (Terpisah)
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="alamat_jalan" class="form-label fw-semibold text-dark">Alamat Jalan / Rumah</label>
                                    <textarea class="form-control" id="alamat_jalan" name="alamat_jalan" rows="2" placeholder="Nama Jalan, Nomor Rumah, Dusun / Komplek">{{ old('alamat_jalan', $detail->alamat_jalan) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rt" class="form-label fw-semibold text-dark">RT</label>
                                    <input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt', $detail->rt) }}" placeholder="e.g. 001">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rw" class="form-label fw-semibold text-dark">RW</label>
                                    <input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw', $detail->rw) }}" placeholder="e.g. 005">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="blok" class="form-label fw-semibold text-dark">Blok / Gang</label>
                                    <input type="text" class="form-control" id="blok" name="blok" value="{{ old('blok', $detail->blok) }}" placeholder="e.g. Blok A3 / Gang Kenanga">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desa_kelurahan" class="form-label fw-semibold text-dark">Desa / Kelurahan</label>
                                    <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $detail->desa_kelurahan) }}" placeholder="Nama Desa / Kelurahan">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label fw-semibold text-dark">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $detail->kecamatan) }}" placeholder="Nama Kecamatan">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kabupaten_kota" class="form-label fw-semibold text-dark">Kabupaten / Kota</label>
                                    <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $detail->kabupaten_kota) }}" placeholder="Nama Kabupaten / Kota">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label fw-semibold text-dark">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $detail->provinsi) }}" placeholder="Nama Provinsi">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kode_pos" class="form-label fw-semibold text-dark">Kode Pos</label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $detail->kode_pos) }}" placeholder="e.g. 40123" maxlength="10">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: FOTO KTP -->
                        <h5 class="mb-4 text-uppercase bg-light-subtle p-2 border-dashed border rounded border-light d-flex align-items-center gap-2 text-primary fw-bold fs-14">
                            <i class="ti ti-camera fs-20"></i> 3. Berkas Foto KTP
                        </h5>

                        <div class="mb-4 p-3 bg-light rounded border">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    @if (!empty($detail->foto_ktp) && Storage::disk('public')->exists($detail->foto_ktp))
                                        <img src="{{ asset('storage/' . $detail->foto_ktp) }}" id="ktp-preview-img" alt="Foto KTP" class="img-fluid rounded border shadow-sm" style="max-height: 120px;" />
                                    @else
                                        <img src="{{ asset('assets/images/stock/small-1.jpg') }}" id="ktp-preview-img" alt="Preview KTP" class="img-fluid rounded border shadow-sm" style="max-height: 120px;" />
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <label for="foto_ktp_input" class="form-label fw-bold text-dark fs-14">Unggah Berkas Foto Kartu KTP</label>
                                    <input class="form-control" type="file" id="foto_ktp_input" name="foto_ktp" accept="image/*" />
                                    <span class="fs-12 text-muted mt-1 d-block">Unggah berkas foto dokumen KTP fisik yang jelas (Maksimal 2MB).</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <a href="{{ route('admin.profil-pengguna.index') }}" class="btn btn-secondary px-4 fw-semibold">
                                <i class="ti ti-arrow-left me-1"></i> Batal / Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Kelengkapan Data KTP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Page JS (Rule 1 Compliance: Place scripts inside @section('content') before @endsection) --}}
    <script src="{{ asset('assets/js/admin/profil-pengguna.js') }}"></script>
@endsection
