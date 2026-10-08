<!-- PANEL 1: IDENTITAS & KTP -->
<div class="tab-pane fade show active" id="tab-ktp" role="tabpanel" aria-labelledby="tab-ktp-btn">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-id me-1.5"></i> Detail Kelengkapan Data KTP & Alamat</h5>
        </div>
        <div class="card-body">
            @php
                $detail = $user->detail ?? new \App\Models\UserDetail();
            @endphp

            <form action="{{ route('admin.profil-pengguna.update-detail') }}" method="POST" enctype="multipart/form-data" id="form-user-detail">
                @csrf

                <div class="table-responsive">
                    <table class="table table-hover align-middle border mb-0">
                        <thead class="table-light align-middle text-center text-nowrap">
                            <tr class="align-middle text-center text-nowrap">
                                <th class="text-center align-middle text-nowrap" style="width: 32%;">Rincian Identitas KTP</th>
                                <th class="text-center align-middle text-nowrap">Nilai / Input Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-credit-card me-1.5 text-muted"></i> NIK (Nomor Induk Kependudukan)
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="nik" name="nik" value="{{ old('nik', $detail->nik) }}" placeholder="16 Digit NIK KTP" maxlength="20">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-brand-whatsapp me-1.5 text-success"></i> Nomor Telepon / WhatsApp
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light text-muted"><i class="ti ti-phone"></i></span>
                                        <input type="text" class="form-control form-control-sm" id="telepon" name="telepon" value="{{ old('telepon', $detail->telepon) }}" placeholder="Contoh: 081234567890" maxlength="30">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-user me-1.5 text-muted"></i> Nama Lengkap (Sesuai KTP)
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="nama_ktp" name="nama_ktp" value="{{ old('nama_ktp', $detail->nama_ktp ?? $user->name) }}" placeholder="Nama lengkap sesuai KTP">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-map-pin me-1.5 text-muted"></i> Tempat & Tanggal Lahir
                                </td>
                                <td>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-sm" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $detail->tempat_lahir) }}" placeholder="Kota / Tempat Lahir">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control form-control-sm" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $detail->tanggal_lahir ? $detail->tanggal_lahir->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-gender-bigender me-1.5 text-muted"></i> Jenis Kelamin
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $detail->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-droplet me-1.5 text-muted"></i> Golongan Darah
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" id="golongan_darah" name="golongan_darah">
                                        <option value="">-- Pilih Golongan Darah --</option>
                                        <option value="A" {{ old('golongan_darah', $detail->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('golongan_darah', $detail->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('golongan_darah', $detail->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('golongan_darah', $detail->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-building-church me-1.5 text-muted"></i> Agama
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" id="agama" name="agama">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam" {{ old('agama', $detail->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama', $detail->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katholik" {{ old('agama', $detail->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                        <option value="Hindu" {{ old('agama', $detail->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama', $detail->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Khonghucu" {{ old('agama', $detail->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-heart me-1.5 text-muted"></i> Status Perkawinan
                                </td>
                                <td>
                                    <select class="form-select form-select-sm" id="status_perkawinan" name="status_perkawinan">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Belum Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_perkawinan', $detail->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-briefcase me-1.5 text-muted"></i> Pekerjaan
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $detail->pekerjaan) }}" placeholder="e.g. Karyawan Swasta, PNS, Pengusaha">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-world me-1.5 text-muted"></i> Kewarganegaraan
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="kewarganegaraan" name="kewarganegaraan" value="{{ old('kewarganegaraan', $detail->kewarganegaraan ?? 'WNI') }}" placeholder="WNI / WNA">
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-home me-1.5 text-muted"></i> Alamat Jalan / Rumah
                                </td>
                                <td>
                                    <textarea class="form-control form-control-sm" id="alamat_jalan" name="alamat_jalan" rows="2" placeholder="Nama Jalan, Nomor Rumah, Dusun / Komplek">{{ old('alamat_jalan', $detail->alamat_jalan) }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-map me-1.5 text-muted"></i> RT / RW / Blok
                                </td>
                                <td>
                                    <div class="row g-2">
                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">RT</span>
                                                <input type="text" class="form-control form-control-sm" id="rt" name="rt" value="{{ old('rt', $detail->rt) }}" placeholder="001">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">RW</span>
                                                <input type="text" class="form-control form-control-sm" id="rw" name="rw" value="{{ old('rw', $detail->rw) }}" placeholder="005">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">Blok</span>
                                                <input type="text" class="form-control form-control-sm" id="blok" name="blok" value="{{ old('blok', $detail->blok) }}" placeholder="Blok A3">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-building-community me-1.5 text-muted"></i> Desa / Kelurahan & Kecamatan
                                </td>
                                <td>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-sm" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $detail->desa_kelurahan) }}" placeholder="Desa / Kelurahan">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-sm" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $detail->kecamatan) }}" placeholder="Kecamatan">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark text-nowrap align-middle">
                                    <i class="ti ti-map-2 me-1.5 text-muted"></i> Kabupaten/Kota, Provinsi & Kode Pos
                                </td>
                                <td>
                                    <div class="row g-2">
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control form-control-sm" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $detail->kabupaten_kota) }}" placeholder="Kabupaten / Kota">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-sm" id="provinsi" name="provinsi" value="{{ old('provinsi', $detail->provinsi) }}" placeholder="Provinsi">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $detail->kode_pos) }}" placeholder="Kode Pos" maxlength="10">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-dark align-top">
                                    <div class="d-flex align-items-center gap-1.5 mb-2">
                                        <i class="ti ti-photo text-muted fs-15"></i>
                                        <span class="text-nowrap">Foto Dokumen KTP</span>
                                    </div>
                                    <div id="ktp-preview-wrapper" class="{{ !empty($detail?->foto_ktp_url) ? '' : 'd-none' }} mt-2 pe-1">
                                        <div class="position-relative border rounded p-1.5 shadow-sm bg-light mb-2 w-100 text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-preview-ktp" title="Klik untuk memperbesar Foto KTP">
                                            <img src="{{ !empty($detail?->foto_ktp) && \Illuminate\Support\Facades\Storage::disk('public')->exists($detail->foto_ktp) ? asset('storage/' . $detail->foto_ktp) : asset('assets/images/stock/small-1.jpg') }}" id="ktp-preview-img" alt="Foto KTP" class="img-fluid rounded w-100" style="max-height: 180px; object-fit: contain; background: #ffffff;" />
                                        </div>
                                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                            <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-preview-ktp">
                                                <i class="ti ti-zoom-in me-1"></i> Preview
                                            </button>
                                            @if (!empty($detail?->foto_ktp_url))
                                                <a href="{{ $detail->foto_ktp_url }}" download="KTP-{{ \Illuminate\Support\Str::slug($user->name) }}" class="btn btn-xs btn-outline-secondary" id="btn-download-ktp">
                                                    <i class="ti ti-download me-1"></i> Unduh
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-top">
                                    <div>
                                        <label for="foto_ktp_input" class="form-label fs-12 text-muted mb-1 fw-semibold">
                                            {{ !empty($detail?->foto_ktp_url) ? 'Ganti / Unggah Berkas KTP Baru:' : 'Unggah Berkas KTP:' }}
                                        </label>
                                        <input class="form-control form-control-sm" type="file" id="foto_ktp_input" name="foto_ktp" accept="image/*" />
                                        <span class="fs-11 text-muted mt-1 d-block">Format berkas: JPG, PNG, WEBP (Maksimal 2MB).</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-end pt-3">
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Kelengkapan Data KTP
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
