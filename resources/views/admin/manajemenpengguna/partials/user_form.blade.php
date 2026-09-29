<ul class="nav nav-tabs nav-bordered mb-3" id="userFormTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-semibold fs-13" id="user-tab-account-btn" data-bs-toggle="tab" data-bs-target="#user-tab-account" type="button" role="tab" aria-selected="true" title="Akun & Kredensial">
            <i class="ti ti-user-circle me-0 me-md-1.5 text-primary"></i> <span class="d-none d-md-inline">Akun &amp; Kredensial</span>
        </button>
    </li>
    <li class="nav-item" role="presentation" id="tab-nav-detail">
        <button class="nav-link fw-semibold fs-13" id="user-tab-detail-btn" data-bs-toggle="tab" data-bs-target="#user-tab-detail" type="button" role="tab" aria-selected="false" title="Identitas KTP & Alamat">
            <i class="ti ti-id me-0 me-md-1.5 text-info"></i> <span class="d-none d-md-inline">Identitas KTP &amp; Alamat (<span class="text-lowercase">user_details</span>)</span>
        </button>
    </li>
    <li class="nav-item" role="presentation" id="tab-nav-config">
        <button class="nav-link fw-semibold fs-13" id="user-tab-config-btn" data-bs-toggle="tab" data-bs-target="#user-tab-config" type="button" role="tab" aria-selected="false" title="Preferensi & Sampul">
            <i class="ti ti-settings me-0 me-md-1.5 text-warning"></i> <span class="d-none d-md-inline">Preferensi &amp; Sampul (<span class="text-lowercase">user_configs</span>)</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="userFormTabsContent">
    <!-- TAB 1: AKUN & KREDENSIAL (EDITABLE) -->
    <div class="tab-pane fade show active" id="user-tab-account" role="tabpanel" aria-labelledby="user-tab-account-btn">
        <div class="row g-3">
            <!-- AVATAR UPLOAD SECTION (LEFT SIDEBAR ON DESKTOP, CENTERED ON MOBILE) -->
            <div class="col-lg-4 col-md-5">
                <div class="card border border-light-subtle bg-light-subtle h-100 mb-0">
                    <div class="card-body p-3 text-center d-flex flex-column align-items-center justify-content-center">
                        <!-- 1. Judul -->
                        <label for="form_user_avatar" class="form-label fw-semibold text-dark fs-13 mb-2">
                            <i class="ti ti-photo me-1 text-primary"></i> Foto Avatar Pengguna
                        </label>

                        <!-- 2. Photo Avatar Preview -->
                        <div class="position-relative mb-2">
                            <img id="form_avatar_preview" src="{{ asset('assets/images/users/default-avatar.svg') }}" alt="Avatar Preview" class="rounded-circle border object-fit-cover shadow-sm" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
                        </div>

                        <!-- 3. Choose File Input -->
                        <div class="w-100" style="max-width: 260px;">
                            <input type="file" name="avatar" id="form_user_avatar" class="form-control form-control-sm user-input" accept="image/jpeg,image/png,image/webp,image/jpg">
                            <input type="hidden" name="remove_avatar" id="form_remove_avatar" value="0">
                        </div>

                        <!-- 4. Keterangan Format -->
                        <small class="text-muted fs-11 mt-2">Format: JPG, PNG, WEBP. Maksimal 2MB.</small>

                        <!-- 5. Hapus Photo Button -->
                        <button type="button" class="btn btn-link text-danger p-0 fs-12 text-decoration-none d-none user-input mt-1" id="btn_reset_avatar">
                            <i class="ti ti-trash me-0.5"></i> Hapus Foto
                        </button>
                    </div>
                </div>
            </div>

            <!-- ACCOUNT DATA INPUTS (RIGHT COLUMN ON DESKTOP) -->
            <div class="col-lg-8 col-md-7">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="form_user_name" class="form-label fw-semibold text-dark fs-13">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="form_user_name" class="form-control user-input" placeholder="Masukkan nama lengkap..." required>
                    </div>

                    <div class="col-md-6">
                        <label for="form_user_email" class="form-label fw-semibold text-dark fs-13">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="form_user_email" class="form-control user-input" placeholder="contoh@domain.com" required>
                    </div>

                    <div class="col-12">
                        <label for="form_user_status" class="form-label fw-semibold text-dark fs-13">Status Akun Pengguna <span class="text-danger">*</span></label>
                        <select name="status" id="form_user_status" class="form-select user-input">
                            <option value="active">Aktif (Disetujui &amp; Dapat Login)</option>
                            <option value="pending">Menunggu Persetujuan (Pending Registration)</option>
                            <option value="inactive">Nonaktif (Akses Login Diblokir)</option>
                            <option value="rejected">Pendaftaran Ditolak (Akses Login Diblokir)</option>
                        </select>
                        <small class="text-muted fs-12 d-block mt-1">Status aktivasi akun pengguna dalam sistem.</small>
                    </div>

                    <div class="col-12">
                        <div class="card border mb-0">
                            <div class="card-header bg-light py-2">
                                <span class="fw-semibold text-dark fs-13">
                                    <i class="ti ti-shield me-1 text-primary"></i> Peran Utamakan (Spatie Role)
                                </span>
                            </div>
                            <div class="card-body py-2.5 px-3">
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($roles as $r)
                                        @php
                                            $roleBadge = match ($r->name) {
                                                'superadmin' => 'text-danger',
                                                'admin' => 'text-primary',
                                                'user' => 'text-info',
                                                default => 'text-secondary'
                                            };
                                        @endphp
                                        <div class="form-check form-check-inline m-0">
                                            <input type="checkbox" name="roles[]" value="{{ $r->name }}" id="u_role_{{ $r->id }}" class="form-check-input user-input user-role-checkbox">
                                            <label class="form-check-label fw-bold {{ $roleBadge }} text-capitalize fs-13 ms-1" for="u_role_{{ $r->id }}" style="cursor: pointer;">
                                                {{ $r->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="form_user_password" class="form-label fw-semibold text-dark fs-13" id="label_user_password">Kata Sandi (Password) <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="form_user_password" class="form-control user-input" placeholder="Minimal 8 karakter...">
                        <small class="text-muted fs-12 d-block mt-1" id="help_user_password">Wajib diisi saat membuat akun baru.</small>
                    </div>

                    <div class="col-md-6">
                        <label for="form_user_password_confirmation" class="form-label fw-semibold text-dark fs-13">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="form_user_password_confirmation" class="form-control user-input" placeholder="Ulangi kata sandi...">
                    </div>

                    <!-- AUDIT / PERSETUJUAN INFO (VIEW / EDIT MODE) -->
                    <div class="col-12 d-none" id="user_approval_audit_box">
                        <div class="p-2.5 rounded bg-light border fs-12 text-muted d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <i class="ti ti-check-circle text-success me-1"></i>
                                Disetujui Oleh: <strong id="audit_approved_by" class="text-dark">-</strong>
                            </div>
                            <div>
                                <i class="ti ti-calendar text-primary me-1"></i>
                                Tanggal Disetujui: <strong id="audit_approved_at" class="text-dark">-</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: IDENTITAS KTP & DOMISILI (user_details) -->
    <div class="tab-pane fade" id="user-tab-detail" role="tabpanel" aria-labelledby="user-tab-detail-btn">
        <!-- ALERT INFO (VIEW ONLY IF EMPTY) -->
        <div id="detail_empty_alert" class="alert alert-info d-none mb-3">
            <i class="ti ti-info-circle me-1"></i> Pengguna ini belum melengkapi rincian data KTP &amp; Alamat (<span class="text-lowercase">user_details</span>).
        </div>

        <!-- EDIT MODE: FORM INPUTS FOR USER DETAILS -->
        <div id="edit_detail_container" class="edit-only-container">
            <div class="row g-3">
                <!-- Card 1: Identitas Kependudukan (KTP) (LEFT COLUMN ON DESKTOP) -->
                <div class="col-lg-6">
                    <div class="card border shadow-none h-100 mb-0">
                        <div class="card-header bg-light py-2 px-3">
                            <h6 class="card-title fs-13 mb-0 text-dark fw-bold">
                                <i class="ti ti-id-badge text-primary me-1.5"></i> Identitas Kependudukan (KTP)
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="form_detail_nik" class="form-label fw-semibold text-dark fs-13">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="text" name="details[nik]" id="form_detail_nik" class="form-control user-input" placeholder="Masukkan 16 digit NIK..." maxlength="20">
                                </div>

                                <div class="col-12">
                                    <label for="form_detail_telepon" class="form-label fw-semibold text-dark fs-13">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="details[telepon]" id="form_detail_telepon" class="form-control user-input" placeholder="Contoh: 08123456789">
                                </div>

                                <div class="col-12">
                                    <label for="form_detail_nama_ktp" class="form-label fw-semibold text-dark fs-13">Nama Sesuai KTP</label>
                                    <input type="text" name="details[nama_ktp]" id="form_detail_nama_ktp" class="form-control user-input" placeholder="Nama lengkap sesuai KTP...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_tempat_lahir" class="form-label fw-semibold text-dark fs-13">Tempat Lahir</label>
                                    <input type="text" name="details[tempat_lahir]" id="form_detail_tempat_lahir" class="form-control user-input" placeholder="Kota / Kabupaten...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_tanggal_lahir" class="form-label fw-semibold text-dark fs-13">Tanggal Lahir</label>
                                    <input type="date" name="details[tanggal_lahir]" id="form_detail_tanggal_lahir" class="form-control user-input">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_jenis_kelamin" class="form-label fw-semibold text-dark fs-13">Jenis Kelamin</label>
                                    <select name="details[jenis_kelamin]" id="form_detail_jenis_kelamin" class="form-select user-input">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_golongan_darah" class="form-label fw-semibold text-dark fs-13">Golongan Darah</label>
                                    <select name="details[golongan_darah]" id="form_detail_golongan_darah" class="form-select user-input">
                                        <option value="">-- Pilih --</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_agama" class="form-label fw-semibold text-dark fs-13">Agama</label>
                                    <select name="details[agama]" id="form_detail_agama" class="form-select user-input">
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Kristen Katolik">Kristen Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_status_perkawinan" class="form-label fw-semibold text-dark fs-13">Status Perkawinan</label>
                                    <select name="details[status_perkawinan]" id="form_detail_status_perkawinan" class="form-select user-input">
                                        <option value="">-- Pilih --</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_pekerjaan" class="form-label fw-semibold text-dark fs-13">Pekerjaan</label>
                                    <input type="text" name="details[pekerjaan]" id="form_detail_pekerjaan" class="form-control user-input" placeholder="Pekerjaan / Profesi...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_kewarganegaraan" class="form-label fw-semibold text-dark fs-13">Kewarganegaraan</label>
                                    <select name="details[kewarganegaraan]" id="form_detail_kewarganegaraan" class="form-select user-input">
                                        <option value="WNI">WNI (Warga Negara Indonesia)</option>
                                        <option value="WNA">WNA (Warga Negara Asing)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Alamat & Domisili KTP (RIGHT COLUMN ON DESKTOP) -->
                <div class="col-lg-6">
                    <div class="card border shadow-none h-100 mb-0">
                        <div class="card-header bg-light py-2 px-3">
                            <h6 class="card-title fs-13 mb-0 text-dark fw-bold">
                                <i class="ti ti-map-pin text-danger me-1.5"></i> Alamat &amp; Domisili KTP
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="form_detail_alamat_jalan" class="form-label fw-semibold text-dark fs-13">Alamat Lengkap (Nama Jalan / Nomor)</label>
                                    <textarea name="details[alamat_jalan]" id="form_detail_alamat_jalan" rows="2" class="form-control user-input" placeholder="Masukkan alamat jalan, nomor rumah, gedung..."></textarea>
                                </div>

                                <div class="col-4">
                                    <label for="form_detail_rt" class="form-label fw-semibold text-dark fs-13">RT</label>
                                    <input type="text" name="details[rt]" id="form_detail_rt" class="form-control user-input" placeholder="001">
                                </div>

                                <div class="col-4">
                                    <label for="form_detail_rw" class="form-label fw-semibold text-dark fs-13">RW</label>
                                    <input type="text" name="details[rw]" id="form_detail_rw" class="form-control user-input" placeholder="002">
                                </div>

                                <div class="col-4">
                                    <label for="form_detail_blok" class="form-label fw-semibold text-dark fs-13">Blok / No.</label>
                                    <input type="text" name="details[blok]" id="form_detail_blok" class="form-control user-input" placeholder="A1">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_desa_kelurahan" class="form-label fw-semibold text-dark fs-13">Desa / Kelurahan</label>
                                    <input type="text" name="details[desa_kelurahan]" id="form_detail_desa_kelurahan" class="form-control user-input" placeholder="Desa / Kelurahan...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_kecamatan" class="form-label fw-semibold text-dark fs-13">Kecamatan</label>
                                    <input type="text" name="details[kecamatan]" id="form_detail_kecamatan" class="form-control user-input" placeholder="Kecamatan...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_kabupaten_kota" class="form-label fw-semibold text-dark fs-13">Kabupaten / Kota</label>
                                    <input type="text" name="details[kabupaten_kota]" id="form_detail_kabupaten_kota" class="form-control user-input" placeholder="Kabupaten / Kota...">
                                </div>

                                <div class="col-sm-6">
                                    <label for="form_detail_provinsi" class="form-label fw-semibold text-dark fs-13">Provinsi</label>
                                    <input type="text" name="details[provinsi]" id="form_detail_provinsi" class="form-control user-input" placeholder="Provinsi...">
                                </div>

                                <div class="col-12">
                                    <label for="form_detail_kode_pos" class="form-label fw-semibold text-dark fs-13">Kode Pos</label>
                                    <input type="text" name="details[kode_pos]" id="form_detail_kode_pos" class="form-control user-input" placeholder="Contoh: 40123" maxlength="10">
                                </div>

                                <div class="col-12">
                                    <label for="form_detail_foto_ktp" class="form-label fw-semibold text-dark fs-13">Upload Berkas Foto KTP</label>
                                    <input type="file" name="details[foto_ktp]" id="form_detail_foto_ktp" class="form-control user-input" accept="image/jpeg,image/png,image/webp,image/jpg">
                                    <small class="text-muted fs-11 d-block mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- VIEW MODE: READ-ONLY DISPLAY TABLES -->
        <div id="view_detail_container" class="view-only-container d-none">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border h-100 mb-0">
                        <div class="card-header bg-light py-2">
                            <h6 class="card-title fs-13 mb-0 text-dark"><i class="ti ti-id-badge me-1 text-primary"></i> Identitas Kependudukan (KTP)</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless fs-12 mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted text-nowrap" style="width: 140px;">NIK</td>
                                        <td class="fw-semibold text-dark" id="view_detail_nik">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap"><i class="ti ti-brand-whatsapp text-success me-1"></i> Telepon / WA</td>
                                        <td class="fw-semibold text-dark" id="view_detail_telepon">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Nama di KTP</td>
                                        <td class="fw-semibold text-dark" id="view_detail_nama_ktp">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Tempat, Tgl Lahir</td>
                                        <td class="text-dark" id="view_detail_ttl">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Jenis Kelamin</td>
                                        <td class="text-dark" id="view_detail_jenis_kelamin">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Golongan Darah</td>
                                        <td class="text-dark" id="view_detail_golongan_darah">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Agama</td>
                                        <td class="text-dark" id="view_detail_agama">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Status Nikah</td>
                                        <td class="text-dark" id="view_detail_status_perkawinan">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Pekerjaan</td>
                                        <td class="text-dark" id="view_detail_pekerjaan">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Kewarganegaraan</td>
                                        <td class="text-dark" id="view_detail_kewarganegaraan">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border h-100 mb-0">
                        <div class="card-header bg-light py-2">
                            <h6 class="card-title fs-13 mb-0 text-dark"><i class="ti ti-map-pin me-1 text-danger"></i> Alamat &amp; Domisili KTP</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless fs-12 mb-3">
                                <tbody>
                                    <tr>
                                        <td class="text-muted text-nowrap" style="width: 140px;">Alamat Jalan</td>
                                        <td class="text-dark" id="view_detail_alamat_jalan">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">RT / RW / Blok</td>
                                        <td class="text-dark" id="view_detail_rt_rw_blok">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Desa / Kelurahan</td>
                                        <td class="text-dark" id="view_detail_desa_kelurahan">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Kecamatan</td>
                                        <td class="text-dark" id="view_detail_kecamatan">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Kabupaten / Kota</td>
                                        <td class="text-dark" id="view_detail_kabupaten_kota">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Provinsi</td>
                                        <td class="text-dark" id="view_detail_provinsi">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted text-nowrap">Kode Pos</td>
                                        <td class="text-dark" id="view_detail_kode_pos">-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="border-top pt-2">
                                <label class="fw-semibold text-dark fs-12 mb-1 d-block"><i class="ti ti-file-text me-1 text-info"></i> Berkas Foto KTP:</label>
                                <div id="view_detail_foto_ktp_container" class="mt-1">
                                    <span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: PREFERENSI & SAMPUL (user_configs) -->
    <div class="tab-pane fade" id="user-tab-config" role="tabpanel" aria-labelledby="user-tab-config-btn">
        <div id="config_empty_alert" class="alert alert-info d-none mb-3">
            <i class="ti ti-info-circle me-1"></i> Pengguna ini menggunakan konfigurasi standar sistem.
        </div>

        <div class="row g-3">
            <!-- PROFILE COMPLETION PROGRESS BAR -->
            <div class="col-12">
                <div class="card border mb-0 bg-light-subtle">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-13 fw-semibold text-dark">
                                <i class="ti ti-chart-donut text-success me-1"></i> Kelengkapan Profil Pengguna
                            </span>
                            <span class="badge bg-primary fs-12" id="view_config_completion_badge">0%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div id="view_config_completion_bar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COVER BACKGROUND BANNER PREVIEW -->
            <div class="col-md-7">
                <div class="card border h-100 mb-0">
                    <div class="card-header bg-light py-2">
                        <h6 class="card-title fs-13 mb-0 text-dark"><i class="ti ti-photo-circle me-1 text-primary"></i> Foto Sampul Header Profil</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="rounded border overflow-hidden position-relative shadow-sm" style="height: 150px; background-color: #f1f5f9;">
                            <img id="view_config_cover_preview" src="{{ asset('assets/images/profile-bg.jpg') }}" alt="Cover Banner" class="w-100 h-100 object-fit-cover" style="object-position: center 0%;">
                        </div>
                        <small class="text-muted fs-11 d-block mt-2">
                            Posisi Vertikal Banner: <strong id="view_config_cover_pos_text" class="text-dark">0%</strong>
                        </small>
                    </div>
                </div>
            </div>

            <!-- MOTTO & THEME SETTINGS -->
            <div class="col-md-5">
                <div class="card border h-100 mb-0">
                    <div class="card-header bg-light py-2">
                        <h6 class="card-title fs-13 mb-0 text-dark"><i class="ti ti-adjustments me-1 text-info"></i> Motto &amp; Preferensi</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <label class="form-label text-muted fs-12 mb-1">Motto Hidup / Bio Kutipan:</label>
                            <div class="p-2 rounded bg-light border fs-12 fst-italic text-dark" id="view_config_motto_box">
                                "Setiap hari adalah kesempatan baru untuk belajar dan berkarya."
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-muted fs-12 mb-1">Mode Tampilan (Theme Mode):</label>
                            <div>
                                <span class="badge bg-secondary-subtle text-secondary border fs-12 text-capitalize" id="view_config_theme_badge">
                                    <i class="ti ti-sun-moon me-1"></i> Default (Light)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
