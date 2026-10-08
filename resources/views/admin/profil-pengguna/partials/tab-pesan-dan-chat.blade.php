<!-- PANEL 3: PESAN & OBROLAN (CLUSTER 1) -->
<div class="tab-pane fade" id="tab-chat-settings" role="tabpanel" aria-labelledby="tab-chat-settings-btn">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-message-circle me-1.5"></i> Pengaturan Pesan & Obrolan (*Messages & Chat*)</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profil-pengguna.update-settings') }}" method="POST" data-confirm="Simpan pengaturan pesan & obrolan Anda?">
                @csrf
                <input type="hidden" name="has_chat_settings" value="1">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">
                            <i class="ti ti-user-check me-1 text-primary"></i> Izin Penerimaan Pesan Masuk
                        </label>
                        <select class="form-select form-select-sm" name="chat_who_can_message">
                            <option value="everyone" {{ ($settings['chat']['who_can_message'] ?? 'everyone') === 'everyone' ? 'selected' : '' }}>Semua Pengguna Terdaftar (Default)</option>
                            <option value="friends" {{ ($settings['chat']['who_can_message'] ?? '') === 'friends' ? 'selected' : '' }}>Hanya Teman yang Terhubung</option>
                            <option value="none" {{ ($settings['chat']['who_can_message'] ?? '') === 'none' ? 'selected' : '' }}>Nonaktifkan Obrolan Baru</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Mengontrol siapa saja yang dapat memulai percakapan baru dengan Anda.</span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1">
                            <i class="ti ti-eye me-1 text-primary"></i> Status Kehadiran / Terakhir Dilihat
                        </label>
                        <select class="form-select form-select-sm" name="chat_online_status_visibility">
                            <option value="everyone" {{ ($settings['chat']['online_status_visibility'] ?? 'everyone') === 'everyone' ? 'selected' : '' }}>Semua Orang (Tampilkan Status Online)</option>
                            <option value="friends" {{ ($settings['chat']['online_status_visibility'] ?? '') === 'friends' ? 'selected' : '' }}>Hanya Teman yang Terhubung</option>
                            <option value="hide" {{ ($settings['chat']['online_status_visibility'] ?? '') === 'hide' ? 'selected' : '' }}>Sembunyikan Status (Ghost Mode)</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Menjaga privasi waktu aktifitas kerja dan status login Anda.</span>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label fs-13 fw-semibold text-dark mb-1 d-flex align-items-center justify-content-between">
                            <span><i class="ti ti-volume me-1 text-primary"></i> Suara Notifikasi Obrolan Masuk</span>
                            <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2" id="btn-test-chat-sound">
                                <i class="ti ti-volume-2 me-1"></i> Tes Bunyi
                            </button>
                        </label>
                        <select class="form-select form-select-sm" name="chat_sound_alert" id="chat_sound_alert_select">
                            <option value="pop" {{ ($settings['chat']['sound_alert'] ?? 'pop') === 'pop' ? 'selected' : '' }}>Pop Message (Default Ringan)</option>
                            <option value="ding" {{ ($settings['chat']['sound_alert'] ?? '') === 'ding' ? 'selected' : '' }}>Ding Soft (Lonceng Lembut)</option>
                            <option value="default" {{ ($settings['chat']['sound_alert'] ?? '') === 'default' ? 'selected' : '' }}>Default Chime (Standar Sistem)</option>
                            <option value="mute" {{ ($settings['chat']['sound_alert'] ?? '') === 'mute' ? 'selected' : '' }}>Mute (Hening / Tanpa Suara)</option>
                        </select>
                        <span class="fs-11 text-muted d-block mt-1">Nada khusus yang berbunyi ketika ada pesan obrolan baru masuk saat membuka dashboard.</span>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="chat_read_receipts">
                                    <i class="ti ti-checks text-info me-1"></i> Tanda Terima Baca (Centang Biru)
                                </label>
                                <span class="fs-12 text-muted d-block">Lawan bicara dapat melihat tanda centang saat pesan telah Anda baca.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="chat_read_receipts" name="chat_read_receipts" value="1" {{ !empty($settings['chat']['read_receipts']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="chat_send_on_enter">
                                    <i class="ti ti-keyboard text-primary me-1"></i> Tekan Enter untuk Mengirim Pesan
                                </label>
                                <span class="fs-12 text-muted d-block">Jika nonaktif, gunakan tombol Shift + Enter untuk mengirim pesan baru.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="chat_send_on_enter" name="chat_send_on_enter" value="1" {{ !empty($settings['chat']['send_on_enter']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Pengaturan Obrolan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
