<!-- PANEL 5: PRIVASI, KEAMANAN SESI & REGIONAL (CLUSTER 5, 2, 6) -->
<div class="tab-pane fade" id="tab-privacy-security" role="tabpanel" aria-labelledby="tab-privacy-security-btn">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-shield-lock me-1.5"></i> Privasi Profil, Keamanan Sesi & Format Regional</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profil-pengguna.update-settings') }}" method="POST" data-confirm="Simpan pengaturan privasi & keamanan Anda?">
                @csrf
                <input type="hidden" name="has_privacy_security_settings" value="1">

                <!-- Privasi Sosial Profil -->
                <h6 class="fw-bold text-dark fs-13 mb-2 pb-1 border-bottom d-flex align-items-center gap-1.5">
                    <i class="ti ti-shield me-1 text-primary"></i> 1. Privasi Sosial & Visibilitas Profil
                </h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Visibilitas Profil Pengguna</label>
                        <select class="form-select form-select-sm" name="privacy_profile_visibility">
                            <option value="public" {{ ($settings['privacy']['profile_visibility'] ?? 'public') === 'public' ? 'selected' : '' }}>Publik (Semua Pengguna Terdaftar)</option>
                            <option value="friends" {{ ($settings['privacy']['profile_visibility'] ?? '') === 'friends' ? 'selected' : '' }}>Hanya Teman yang Terhubung</option>
                            <option value="private" {{ ($settings['privacy']['profile_visibility'] ?? '') === 'private' ? 'selected' : '' }}>Privat (Hanya Administrator)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Izin Permintaan Pertemanan</label>
                        <select class="form-select form-select-sm" name="privacy_allow_friend_requests">
                            <option value="everyone" {{ ($settings['privacy']['allow_friend_requests'] ?? 'everyone') === 'everyone' ? 'selected' : '' }}>Buka untuk Siapa Saja (Default)</option>
                            <option value="friends_of_friends" {{ ($settings['privacy']['allow_friend_requests'] ?? '') === 'friends_of_friends' ? 'selected' : '' }}>Hanya Teman dari Teman</option>
                            <option value="none" {{ ($settings['privacy']['allow_friend_requests'] ?? '') === 'none' ? 'selected' : '' }}>Tutup Permintaan Pertemanan Baru</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="privacy_allow_likes">
                                    <i class="ti ti-heart text-danger me-1"></i> Izinkan Tombol Suka Profil
                                </label>
                                <span class="fs-12 text-muted d-block">Pengguna lain dapat memberikan tanda suka pada profil Anda.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="privacy_allow_likes" name="privacy_allow_likes" value="1" {{ !empty($settings['privacy']['allow_likes']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="privacy_show_points">
                                    <i class="ti ti-trophy text-warning me-1"></i> Tampilkan Poin Login di Banner
                                </label>
                                <span class="fs-12 text-muted d-block">Menampilkan akumulasi lencana poin login di header profil.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="privacy_show_points" name="privacy_show_points" value="1" {{ !empty($settings['privacy']['show_points']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keamanan Sesi & Layar Kunci -->
                <h6 class="fw-bold text-dark fs-13 mb-2 pb-1 border-bottom d-flex align-items-center gap-1.5">
                    <i class="ti ti-lock me-1 text-primary"></i> 2. Keamanan Sesi & Layar Kunci
                </h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Batas Waktu Layar Kunci Otomatis (*Auto Lock Screen*)</label>
                        <select class="form-select form-select-sm" name="lock_screen_auto_lock_timeout">
                            <option value="0" {{ ($settings['lock_screen']['auto_lock_timeout'] ?? 15) == 0 ? 'selected' : '' }}>Nonaktifkan (Kunci Manual Saja)</option>
                            <option value="5" {{ ($settings['lock_screen']['auto_lock_timeout'] ?? 15) == 5 ? 'selected' : '' }}>5 Menit Tidak Aktif</option>
                            <option value="15" {{ ($settings['lock_screen']['auto_lock_timeout'] ?? 15) == 15 ? 'selected' : '' }}>15 Menit Tidak Aktif (Standar)</option>
                            <option value="30" {{ ($settings['lock_screen']['auto_lock_timeout'] ?? 15) == 30 ? 'selected' : '' }}>30 Menit Tidak Aktif</option>
                            <option value="60" {{ ($settings['lock_screen']['auto_lock_timeout'] ?? 15) == 60 ? 'selected' : '' }}>1 Jam Tidak Aktif</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Mengunci layar dashboard jika tidak ada interaksi mouse/keyboard.</span>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <span class="fs-13 fw-semibold text-dark d-block mb-1">
                                    <i class="ti ti-device-laptop text-primary me-1"></i> Status Sesi Perangkat
                                </span>
                                <span class="fs-12 text-muted d-block">
                                    Alamat IP: <strong class="text-dark font-monospace">{{ request()->ip() }}</strong>
                                </span>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 fs-11 fw-semibold d-inline-flex align-items-center">
                                    <i class="ti ti-shield-check me-1"></i> Sesi Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferensi Bahasa & Regional -->
                <h6 class="fw-bold text-dark fs-13 mb-2 pb-1 border-bottom d-flex align-items-center gap-1.5">
                    <i class="ti ti-world me-1 text-primary"></i> 3. Preferensi Bahasa & Format Regional
                </h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Bahasa Antarmuka</label>
                        <select class="form-select form-select-sm" name="localization_locale">
                            <option value="id" {{ ($settings['localization']['locale'] ?? 'id') === 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                            <option value="en" {{ ($settings['localization']['locale'] ?? '') === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Pilihan Zona Waktu</label>
                        <select class="form-select form-select-sm" name="localization_timezone">
                            <option value="Asia/Jakarta" {{ ($settings['localization']['timezone'] ?? 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB - UTC+7)</option>
                            <option value="Asia/Makassar" {{ ($settings['localization']['timezone'] ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA - UTC+8)</option>
                            <option value="Asia/Jayapura" {{ ($settings['localization']['timezone'] ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT - UTC+9)</option>
                            <option value="UTC" {{ ($settings['localization']['timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>UTC (Universal Time)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">Format Tampilan Tanggal</label>
                        <select class="form-select form-select-sm" name="localization_date_format">
                            <option value="DD/MM/YYYY" {{ ($settings['localization']['date_format'] ?? 'DD/MM/YYYY') === 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/YYYY (Contoh: {{ date('d/m/Y') }})</option>
                            <option value="YYYY-MM-DD" {{ ($settings['localization']['date_format'] ?? '') === 'YYYY-MM-DD' ? 'selected' : '' }}>YYYY-MM-DD (Contoh: {{ date('Y-m-d') }})</option>
                            <option value="DD MMMM YYYY" {{ ($settings['localization']['date_format'] ?? '') === 'DD MMMM YYYY' ? 'selected' : '' }}>DD MMMM YYYY (Contoh: {{ date('d F Y') }})</option>
                        </select>
                    </div>
                </div>

                <div class="text-end pt-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Preferensi Privasi & Regional
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
