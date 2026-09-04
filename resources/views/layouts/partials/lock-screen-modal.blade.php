@auth
<!-- Lock Screen Modal Backdrop & Dialog -->
<div class="modal fade" id="lockScreenModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="lockScreenModalLabel" aria-hidden="true" style="z-index: 1090;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden; background: var(--bs-card-bg, #ffffff);">
            <!-- Decorative Gradient Top Header -->
            <div class="position-relative text-center pt-4 pb-2" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(168, 85, 247, 0.08) 100%);">
                <!-- Lock Icon Badge Floating -->
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5 py-1.5 d-inline-flex align-items-center gap-1 shadow-sm fs-12">
                        <i class="ti ti-lock-filled fs-14"></i>
                        <span>Terkunci</span>
                    </span>
                </div>

                <!-- Avatar Circle with Glow & Ring -->
                <div class="d-inline-block position-relative my-2">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                        class="rounded-circle shadow-md object-fit-cover"
                        style="width: 86px; height: 86px; border: 4px solid var(--bs-card-bg, #ffffff); box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4); object-position: top;">
                    <span class="position-absolute bottom-0 end-0 bg-warning border border-2 border-white rounded-circle p-1"
                        title="Status: Idle / Terkunci" style="width: 18px; height: 18px; transform: translate(-4px, -4px);"></span>
                </div>

                <!-- User Information -->
                <h5 class="fw-bold mb-1 text-truncate px-3" id="lockScreenModalLabel">{{ auth()->user()->name }}</h5>
                <p class="text-muted fs-13 mb-0 text-truncate px-3">{{ auth()->user()->email }}</p>
                <div class="mt-1">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-0.5 fs-11 fw-medium">
                        {{ auth()->user()->role_name ?? 'User' }}
                    </span>
                </div>
            </div>

            <!-- Modal Body / Unlock Form -->
            <div class="modal-body px-4 py-3">
                <div class="text-center mb-3">
                    <p class="text-muted fs-13 mb-0">
                        Layar terkunci otomatis karena tidak ada aktivitas. Silakan masukkan password untuk melanjutkan.
                    </p>
                </div>

                <!-- Error Alert Box -->
                <div id="lockScreenErrorAlert" class="alert alert-danger d-none align-items-center py-2 px-3 fs-13 mb-3 border-0 shadow-sm" role="alert">
                    <i class="ti ti-alert-circle fs-16 me-2 flex-shrink-0"></i>
                    <div id="lockScreenErrorMessage">Password tidak sesuai.</div>
                </div>

                <form id="lockScreenForm" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="lockScreenPassword" class="form-label fs-13 fw-semibold text-muted mb-1">
                            Password Konfirmasi <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="ti ti-key fs-16 text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 border-end-0 bg-light"
                                id="lockScreenPassword" name="password" placeholder="Masukkan password Anda..." required>
                            <button class="btn btn-light border border-start-0 text-muted" type="button" id="btnToggleLockPassword" title="Lihat password">
                                <i class="ti ti-eye fs-16" id="lockPasswordEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-primary py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" id="btnSubmitUnlock">
                            <i class="ti ti-lock-open fs-16"></i>
                            <span id="btnUnlockText">Buka Kunci Layar</span>
                            <span class="spinner-border spinner-border-sm d-none" id="btnUnlockSpinner" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

                <div class="text-center pt-2 border-top mt-3">
                    <p class="text-muted fs-12 mb-0">
                        Bukan akun Anda?
                        <a href="javascript:void(0);" class="text-danger fw-semibold text-decoration-underline ms-1"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout-2 me-0.5 align-middle"></i> Keluar / Ganti Akun
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus backdrop blur saat modal lock screen aktif */
    .modal-backdrop.lock-screen-backdrop {
        background-color: rgba(15, 23, 42, 0.82) !important;
        backdrop-filter: blur(12px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(12px) saturate(180%) !important;
        z-index: 1085 !important;
    }

    #lockScreenModal .modal-content {
        animation: lockModalPop 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes lockModalPop {
        0% {
            opacity: 0;
            transform: scale(0.92) translateY(12px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .shake-animation {
        animation: shakeInput 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    }

    @keyframes shakeInput {
        10%, 90% { transform: translate3d(-2px, 0, 0); }
        20%, 80% { transform: translate3d(3px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-5px, 0, 0); }
        40%, 60% { transform: translate3d(5px, 0, 0); }
    }
</style>

@php
    $serverIdleMinutes = (int) \App\Models\Admin\DukunganAplikasi\AppSetting::get('idle_timeout_minutes', 5);
@endphp

<script>
(function() {
    'use strict';

    // Durasi Idle: Konfigurasi Terpusat dari Server Database
    let serverIdleMinutes = {{ (int) $serverIdleMinutes }};
    const STORAGE_KEY_LOCKED = 'repalogic_screen_locked';

    function getIdleTimeoutMs() {
        if (serverIdleMinutes <= 0) return 0; // 0 = Fitur Auto Lock Dinonaktifkan
        return serverIdleMinutes * 60 * 1000;
    }

    let idleTimer = null;
    let lockModalInstance = null;
    const modalElement = document.getElementById('lockScreenModal');
    const lockForm = document.getElementById('lockScreenForm');
    const passwordInput = document.getElementById('lockScreenPassword');
    const errorAlert = document.getElementById('lockScreenErrorAlert');
    const errorMessage = document.getElementById('lockScreenErrorMessage');
    const btnSubmit = document.getElementById('btnSubmitUnlock');
    const btnUnlockText = document.getElementById('btnUnlockText');
    const btnUnlockSpinner = document.getElementById('btnUnlockSpinner');
    const btnTogglePassword = document.getElementById('btnToggleLockPassword');
    const eyeIcon = document.getElementById('lockPasswordEyeIcon');

    function getModalInstance() {
        if (!modalElement) return null;
        if (!lockModalInstance && window.bootstrap && window.bootstrap.Modal) {
            lockModalInstance = new window.bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });
        }
        return lockModalInstance;
    }

    /**
     * Tampilkan Modal Lock Screen
     */
    window.lockScreen = function() {
        sessionStorage.setItem(STORAGE_KEY_LOCKED, 'true');
        const modal = getModalInstance();
        if (modal) {
            modal.show();

            // Pasang custom backdrop class untuk efek ultra-blur
            setTimeout(function() {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(function(el) {
                    el.classList.add('lock-screen-backdrop');
                });
            }, 50);

            // Bersihkan error & reset input
            if (errorAlert) errorAlert.classList.add('d-none');
            if (passwordInput) {
                passwordInput.value = '';
                setTimeout(function() {
                    passwordInput.focus();
                }, 300);
            }
        }
    };

    /**
     * Buka Kunci Modal Screen
     */
    window.unlockScreen = function() {
        sessionStorage.removeItem(STORAGE_KEY_LOCKED);
        const modal = getModalInstance();
        if (modal) {
            modal.hide();
        }
        if (passwordInput) passwordInput.value = '';
        if (errorAlert) errorAlert.classList.add('d-none');
        resetIdleTimer();
    };

    /**
     * Set Durasi Idle Baru secara instan
     */
    window.setIdleTimeoutMinutes = function(minutes) {
        serverIdleMinutes = parseInt(minutes, 10) || 0;
        resetIdleTimer();
    };

    /**
     * Reset Timer Idle
     */
    function resetIdleTimer() {
        // Jika sedang dalam status terkunci, jangan reset timer
        if (sessionStorage.getItem(STORAGE_KEY_LOCKED) === 'true') {
            return;
        }

        if (idleTimer) {
            clearTimeout(idleTimer);
            idleTimer = null;
        }

        const timeoutMs = getIdleTimeoutMs();
        if (timeoutMs > 0) {
            idleTimer = setTimeout(function() {
                window.lockScreen();
            }, timeoutMs);
        }
    }

    // Pasang listener aktivitas pengguna untuk reset timer idle
    const userActivityEvents = ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click'];
    let lastActivityTime = Date.now();

    userActivityEvents.forEach(function(eventType) {
        window.addEventListener(eventType, function() {
            const now = Date.now();
            // Throttling 1 detik agar tidak membebani event listener
            if (now - lastActivityTime > 1000) {
                lastActivityTime = now;
                resetIdleTimer();
            }
        }, { passive: true });
    });

    // Inisialisasi awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        resetIdleTimer();

        // Jika sebelumnya sudah terkunci (misal user refresh halaman saat terkunci), langsung munculkan
        if (sessionStorage.getItem(STORAGE_KEY_LOCKED) === 'true') {
            setTimeout(function() {
                window.lockScreen();
            }, 200);
        }
    });

    // Toggle Show/Hide Password
    if (btnTogglePassword && passwordInput && eyeIcon) {
        btnTogglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('ti-eye');
                eyeIcon.classList.add('ti-eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('ti-eye-off');
                eyeIcon.classList.add('ti-eye');
            }
        });
    }

    // Submit Form Unlock via AJAX
    if (lockForm) {
        lockForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const password = passwordInput.value.trim();
            if (!password) {
                if (errorAlert && errorMessage) {
                    errorMessage.textContent = 'Silakan masukkan password Anda.';
                    errorAlert.classList.remove('d-none');
                }
                if (passwordInput) passwordInput.focus();
                return;
            }

            // UI Loading State
            btnSubmit.disabled = true;
            btnUnlockText.textContent = 'Memverifikasi...';
            btnUnlockSpinner.classList.remove('d-none');
            if (errorAlert) errorAlert.classList.add('d-none');

            fetch("{{ route('lock-screen.unlock') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ password: password })
            })
            .then(async function(response) {
                const data = await response.json();
                if (response.ok && data.success) {
                    window.unlockScreen();

                    // Tampilkan notifikasi toast jika Toastr/SweetAlert tersedia
                    if (typeof Swal !== 'undefined') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Sesi Aktif Kembali'
                        });
                    }
                } else {
                    const msg = data.message || 'Password yang Anda masukkan salah.';
                    if (errorAlert && errorMessage) {
                        errorMessage.textContent = msg;
                        errorAlert.classList.remove('d-none');
                    }
                    if (modalElement) {
                        const modalContent = modalElement.querySelector('.modal-content');
                        if (modalContent) {
                            modalContent.classList.remove('shake-animation');
                            void modalContent.offsetWidth; // trigger reflow
                            modalContent.classList.add('shake-animation');
                        }
                    }
                    if (passwordInput) {
                        passwordInput.value = '';
                        passwordInput.focus();
                    }
                }
            })
            .catch(function(err) {
                console.error('Lock screen unlock error:', err);
                if (errorAlert && errorMessage) {
                    errorMessage.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    errorAlert.classList.remove('d-none');
                }
            })
            .finally(function() {
                btnSubmit.disabled = false;
                btnUnlockText.textContent = 'Buka Kunci Layar';
                btnUnlockSpinner.classList.add('d-none');
            });
        });
    }

    // Event delegation untuk tombol manual trigger lock screen (misal dari menu topbar)
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('[data-action="trigger-lock-screen"]');
        if (trigger) {
            e.preventDefault();
            window.lockScreen();
        }
    });

})();
</script>
@endauth
