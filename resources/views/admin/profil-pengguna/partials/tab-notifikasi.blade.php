<!-- PANEL 4: NOTIFIKASI & SUARA (CLUSTER 4) -->
<div class="tab-pane fade" id="tab-notifications" role="tabpanel" aria-labelledby="tab-notifications-btn">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-bell me-1.5"></i> Preferensi Notifikasi & Pemberitahuan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.profil-pengguna.update-settings') }}" method="POST" data-confirm="Simpan preferensi notifikasi Anda?">
                @csrf
                <input type="hidden" name="has_notification_settings" value="1">

                <!-- Kanal Notifikasi Utama -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <label class="form-check-label fs-13 fw-semibold text-dark cursor-pointer mb-0" for="notifications_browser_push">
                                        <i class="ti ti-bell-ringing text-primary me-1"></i> Notifikasi Desktop Browser
                                    </label>
                                    <button type="button" class="btn btn-xs btn-outline-info py-0 px-2" id="btn-test-browser-push">
                                        <i class="ti ti-send me-1"></i> Tes
                                    </button>
                                </div>
                                <span class="fs-12 text-muted d-block">Menampilkan pop-up notifikasi sistem di sudut layar saat diminimalkan.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="notifications_browser_push" name="notifications_browser_push" value="1" {{ !empty($settings['notifications']['browser_push']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border h-100 d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <label class="form-check-label fs-13 fw-semibold text-dark d-block mb-1 cursor-pointer" for="notifications_sound_chime">
                                    <i class="ti ti-bell-school text-primary me-1"></i> Suara Lonceng Pemberitahuan Topbar
                                </label>
                                <span class="fs-12 text-muted d-block">Mengaktifkan bunyi ding lembut saat ada notifikasi baru di menu lonceng.</span>
                            </div>
                            <div class="form-check form-switch mb-0 fs-18 flex-shrink-0">
                                <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="notifications_sound_chime" name="notifications_sound_chime" value="1" {{ !empty($settings['notifications']['sound_chime']) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Kategori Pemberitahuan -->
                <div class="p-3 bg-light rounded border mb-3">
                    <h6 class="fw-bold text-dark fs-13 mb-2 d-flex align-items-center gap-1.5">
                        <i class="ti ti-filter text-primary fs-15"></i> Filter Kategori Notifikasi yang Diterima
                    </h6>
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notif_ev_friend" name="notifications_events_friend_request" value="1" {{ !empty($settings['notifications']['events']['friend_request']) ? 'checked' : '' }}>
                                <label class="form-check-label fs-13 text-dark" for="notif_ev_friend">
                                    Permintaan Pertemanan Baru
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notif_ev_like" name="notifications_events_profile_like" value="1" {{ !empty($settings['notifications']['events']['profile_like']) ? 'checked' : '' }}>
                                <label class="form-check-label fs-13 text-dark" for="notif_ev_like">
                                    Suka Profil Diterima
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notif_ev_chat" name="notifications_events_chat_message" value="1" {{ !empty($settings['notifications']['events']['chat_message']) ? 'checked' : '' }}>
                                <label class="form-check-label fs-13 text-dark" for="notif_ev_chat">
                                    Pesan Obrolan Masuk
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notif_ev_security" name="notifications_events_security_alert" value="1" {{ !empty($settings['notifications']['events']['security_alert']) ? 'checked' : '' }}>
                                <label class="form-check-label fs-13 text-dark" for="notif_ev_security">
                                    Peringatan Keamanan & Sesi Akun
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notif_ev_global" name="notifications_events_global_announcement" value="1" {{ !empty($settings['notifications']['events']['global_announcement']) ? 'checked' : '' }}>
                                <label class="form-check-label fs-13 text-dark" for="notif_ev_global">
                                    Pengumuman & Siaran Sistem Global
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold">
                        <i class="ti ti-device-floppy me-1.5"></i> Simpan Pengaturan Notifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
