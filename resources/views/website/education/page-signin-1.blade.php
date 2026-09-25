@extends('website.education.index')

@section('title', 'Masuk ke Akun | ' . ($appProfil->app_name ?? 'REPALOGIC Dashboard'))

@section('content')
<!-- Signin Form -->
<div class="g-bg-img-hero g-bg-pos-top-center" style="background-image: url({{ asset('asset_education/include') }}/svg/svg-bg2.svg);">
  <div class="container g-pt-80 g-pb-80 g-pb-120--lg">
    <div class="g-pos-rel">
      <div class="row">
        <div class="col-md-6">
          <!-- Heading -->
          <div class="g-mb-30">
            <span class="d-block g-color-primary g-font-weight-700 g-font-size-13 text-uppercase g-mb-10">Portal Autentikasi</span>
            <h2 class="h1 mb-3">Masuk ke {{ $appProfil->app_name ?? 'REPALOGIC' }}</h2>
            <p class="g-color-text-light-v1">
              Dengan masuk, Anda mendapatkan akses resmi ke seluruh aplikasi, data akademik, dan layanan terintegrasi sesuai hak akses akun Anda.
            </p>
          </div>
          <!-- End Heading -->
        </div>
      </div>

      <div class="row justify-content-between">
        <div class="col-md-6 col-lg-5 order-md-2 g-pos-abs--md g-top-0 g-right-0">
          
          <!-- Alerts / Notifications -->
          @if (session('registered_pending'))
            <div class="alert alert-info alert-dismissible fade show g-bg-blue-opacity-0_1 g-color-blue g-brd-around g-brd-blue-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-info-circle mr-1"></i> Pendaftaran Berhasil!</strong>
              <div class="g-font-size-13">{{ session('registered_pending') }}</div>
            </div>
          @endif

          @if (session('reset_requested'))
            <div class="alert alert-success alert-dismissible fade show g-bg-green-opacity-0_1 g-color-green g-brd-around g-brd-green-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-check-circle mr-1"></i> Permintaan Reset Terkirim!</strong>
              <div class="g-font-size-13">{{ session('reset_requested') }}</div>
            </div>
          @endif

          @if ($errors->has('throttle'))
            <div class="alert alert-danger alert-dismissible fade show g-bg-red-opacity-0_1 g-color-red g-brd-around g-brd-red-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-shield mr-1"></i> Akses Login Dikunci Sementara</strong>
              <div class="g-font-size-13">{{ $errors->first('throttle') }}</div>
            </div>
          @endif

          @if (session('reactivation_success'))
            <div class="alert alert-success alert-dismissible fade show g-bg-green-opacity-0_1 g-color-green g-brd-around g-brd-green-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-user-check mr-1"></i> Permohonan Aktivasi Terkirim!</strong>
              <div class="g-font-size-13">{{ session('reactivation_success') }}</div>
            </div>
          @endif

          @if (session('info_message'))
            <div class="alert alert-info alert-dismissible fade show g-bg-blue-opacity-0_1 g-color-blue g-brd-around g-brd-blue-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <div class="g-font-size-13">{{ session('info_message') }}</div>
            </div>
          @endif

          @if (session('error_message') && !$errors->has('inactive') && !$errors->has('rejected') && !$errors->has('unapproved'))
            <div class="alert alert-danger alert-dismissible fade show g-bg-red-opacity-0_1 g-color-red g-brd-around g-brd-red-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-exclamation-triangle mr-1"></i> Pemberitahuan Akun</strong>
              <div class="g-font-size-13">{{ session('error_message') }}</div>
            </div>
          @endif

          @if ($errors->has('unapproved'))
            <div class="alert alert-warning alert-dismissible fade show g-bg-yellow-opacity-0_1 g-color-yellow-dark-v1 g-brd-around g-brd-yellow-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-clock-o mr-1"></i> Menunggu Persetujuan Admin</strong>
              <div class="g-font-size-13">{{ $errors->first('unapproved') }}</div>
            </div>
          @endif

          @if ($errors->has('rejected'))
            <div class="alert alert-danger alert-dismissible fade show g-bg-red-opacity-0_1 g-color-red g-brd-around g-brd-red-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-user-times mr-1"></i> Pengajuan Pendaftaran Ditolak</strong>
              <div class="g-font-size-13 mb-2">{{ $errors->first('rejected') }}</div>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-sm btn-danger g-rounded-20 g-px-15 g-py-5 text-white">
                  <i class="fa fa-user-plus mr-1"></i> Daftar Ulang
                </a>
              @endif
            </div>
          @endif

          @if ($errors->has('inactive'))
            <div class="alert alert-danger alert-dismissible fade show g-bg-red-opacity-0_1 g-color-red g-brd-around g-brd-red-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-ban mr-1"></i> Akun Dinonaktifkan</strong>
              <div class="g-font-size-13 mb-2">{{ $errors->first('inactive') }}</div>
              @if (Route::has('activation.request'))
                <a href="{{ route('activation.request') }}" class="btn btn-sm btn-danger g-rounded-20 g-px-15 g-py-5 text-white">
                  <i class="fa fa-user-check mr-1"></i> Ajukan Aktivasi Akun
                </a>
              @endif
            </div>
          @endif

          @if ($errors->has('maintenance'))
            <div class="alert alert-danger alert-dismissible fade show g-bg-red-opacity-0_1 g-color-red g-brd-around g-brd-red-opacity-0_3 g-rounded-6 g-pa-15 g-mb-20" role="alert">
              <strong class="d-block g-font-weight-700 g-mb-5"><i class="fa fa-wrench mr-1"></i> Mode Pemeliharaan Aktif</strong>
              <div class="g-font-size-13">{{ $errors->first('maintenance') }}</div>
            </div>
          @endif

          <!-- Signin Card Form -->
          <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
            @csrf
            <input type="hidden" name="latitude" id="loginLatitude" value="">
            <input type="hidden" name="longitude" id="loginLongitude" value="">

            <div id="signin">
              <div class="u-shadow-v35 g-bg-white rounded g-px-35 g-py-40">
                <h3 class="h5 g-font-weight-700 g-mb-25 text-center">Masuk ke Akun Anda</h3>

                <!-- Email Input -->
                <div class="g-mb-20">
                  <label class="g-color-text-light-v1 g-font-weight-600 g-font-size-13" for="email">
                    Alamat Email <span class="g-color-red">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-prepend g-width-50 g-brd-secondary-light-v2 g-bg-transparent g-rounded-right-0">
                      <div class="input-group-text justify-content-center w-100 g-bg-secondary g-brd-secondary-light-v2">
                        <i class="icon-finance-067 u-line-icon-pro"></i>
                      </div>
                    </span>
                    <input class="form-control g-brd-secondary-light-v2 g-bg-secondary g-bg-secondary-dark-v1--focus g-rounded-left-0 g-px-20 g-py-12 @error('email') is-invalid g-brd-red--focus @enderror"
                           type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="nama@domain.com"
                           autocomplete="email"
                           required
                           autofocus>
                  </div>
                  @error('email')
                    <div class="text-danger g-font-size-12 g-mt-5 d-flex align-items-center">
                      <i class="fa fa-exclamation-circle mr-1"></i> {{ $message }}
                    </div>
                  @enderror
                  <div id="emailFeedback" class="text-danger g-font-size-12 g-mt-5 d-none align-items-center">
                    <i class="fa fa-exclamation-circle mr-1"></i> <span id="emailFeedbackText"></span>
                  </div>
                </div>

                <!-- Password Input -->
                <div class="g-mb-20">
                  <label class="g-color-text-light-v1 g-font-weight-600 g-font-size-13" for="userPassword">
                    Kata Sandi <span class="g-color-red">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-prepend g-width-50 g-brd-secondary-light-v2 g-bg-transparent g-rounded-right-0">
                      <div class="input-group-text justify-content-center w-100 g-bg-secondary g-brd-secondary-light-v2">
                        <i class="icon-finance-135 u-line-icon-pro"></i>
                      </div>
                    </span>
                    <input class="form-control g-brd-secondary-light-v2 g-bg-secondary g-bg-secondary-dark-v1--focus g-rounded-0 g-px-20 g-py-12 @error('password') is-invalid g-brd-red--focus @enderror"
                           type="password"
                           id="userPassword"
                           name="password"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           required>
                    <span class="input-group-append">
                      <button class="btn g-bg-secondary g-brd-secondary-light-v2 g-color-text-light-v1 g-px-15" type="button" id="btnTogglePassword" title="Lihat / Sembunyikan Kata Sandi">
                        <i class="fa fa-eye" id="passwordEyeIcon"></i>
                      </button>
                    </span>
                  </div>
                  @error('password')
                    <div class="text-danger g-font-size-12 g-mt-5 d-flex align-items-center">
                      <i class="fa fa-exclamation-circle mr-1"></i> {{ $message }}
                    </div>
                  @enderror
                  <div id="passwordFeedback" class="text-danger g-font-size-12 g-mt-5 d-none align-items-center">
                    <i class="fa fa-exclamation-circle mr-1"></i> <span id="passwordFeedbackText"></span>
                  </div>
                </div>

                <!-- Remember & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center g-mb-25">
                  <label class="form-check-label d-flex align-items-center g-font-size-13 g-color-text-light-v1 cursor-pointer mb-0">
                    <input type="checkbox" name="remember" id="rememberMe" class="mr-2" {{ old('remember') ? 'checked' : '' }}>
                    Ingat Saya
                  </label>

                  @if (Route::has('password.request'))
                    <a class="g-color-primary g-font-size-13 g-text-underline--none--hover" href="{{ route('password.request') }}">
                      Lupa Password?
                    </a>
                  @endif
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="submit" class="btn u-shadow-v33 g-color-white g-bg-primary g-bg-main--hover g-font-size-default rounded g-px-25 g-py-12 w-100 g-font-weight-600" id="btnSubmitLogin">
                    Masuk ke Akun
                  </button>
                </div>
              </div>

              <!-- Footer Links -->
              <div class="text-center g-pt-25">
                @if (Route::has('register'))
                  <p class="g-color-text-light-v1 g-font-size-14 mb-1">
                    Belum memiliki akun? <a class="g-font-weight-600 g-color-primary" href="{{ route('register') }}">Daftar Akun Baru</a>
                  </p>
                @endif
                @if (Route::has('activation.request'))
                  <p class="g-color-text-light-v1 g-font-size-13 mb-0">
                    Akun dinonaktifkan? <a class="g-font-weight-600 g-color-red" href="{{ route('activation.request') }}">Ajukan Aktivasi</a>
                  </p>
                @endif
              </div>
            </div>
          </form>
          <!-- End Signin Card Form -->

          <hr class="g-hidden-md-up g-my-40">
        </div>

        <!-- Left Security Guidelines Column -->
        <div class="col-md-6 order-md-1">
          <div class="g-max-width-450">
            <!-- Media 1 -->
            <div class="media align-items-center g-mb-30">
              <div class="d-flex mr-4">
                <span class="u-icon-v1 u-icon-size--lg u-shadow-v32 g-color-primary g-bg-secondary rounded-circle">
                  <i class="material-icons">security</i>
                </span>
              </div>
              <div class="media-body">
                <h4 class="h6 g-font-weight-700 g-mb-5">Keamanan Akun Terlindungi</h4>
                <p class="g-font-size-14 g-color-text-light-v1 mb-0">
                  Pastikan alamat situs selalu diawali dengan protokol resmi (HTTPS) dan jangan pernah membagikan kata sandi Anda kepada pihak lain.
                </p>
              </div>
            </div>
            <!-- End Media 1 -->

            <!-- Media 2 -->
            <div class="media align-items-center g-mb-30">
              <div class="d-flex mr-4">
                <span class="u-icon-v1 u-icon-size--lg u-shadow-v32 g-color-primary g-bg-secondary rounded-circle">
                  <i class="material-icons">verified_user</i>
                </span>
              </div>
              <div class="media-body">
                <h4 class="h6 g-font-weight-700 g-mb-5">Akses Sistem Terpusat</h4>
                <p class="g-font-size-14 g-color-text-light-v1 mb-0">
                  Satu akun terverifikasi memberikan hak akses penuh ke modul akademik, administrasi, dan layanan portal sesuai peran yang diberikan.
                </p>
              </div>
            </div>
            <!-- End Media 2 -->

            <!-- Media 3 -->
            <div class="media align-items-center">
              <div class="d-flex mr-4">
                <span class="u-icon-v1 u-icon-size--lg u-shadow-v32 g-color-primary g-bg-secondary rounded-circle">
                  <i class="material-icons">help_outline</i>
                </span>
              </div>
              <div class="media-body">
                <h4 class="h6 g-font-weight-700 g-mb-5">Butuh Bantuan Masuk?</h4>
                <p class="g-font-size-14 g-color-text-light-v1 mb-0">
                  Jika Anda mengalami kendala saat login atau memerlukan pemulihan akun, hubungi pusat bantuan atau administrator sistem.
                </p>
              </div>
            </div>
            <!-- End Media 3 -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Signin Form -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const emailFeedback = document.getElementById('emailFeedback');
    const emailFeedbackText = document.getElementById('emailFeedbackText');

    const passwordInput = document.getElementById('userPassword');
    const passwordFeedback = document.getElementById('passwordFeedback');
    const passwordFeedbackText = document.getElementById('passwordFeedbackText');

    const btnTogglePassword = document.getElementById('btnTogglePassword');
    const passwordEyeIcon = document.getElementById('passwordEyeIcon');

    let isFormSubmitted = false;
    let hasServerEmailError = {{ $errors->has('email') ? 'true' : 'false' }};
    let hasServerPasswordError = {{ $errors->has('password') ? 'true' : 'false' }};

    // Toggle Password Visibility
    if (btnTogglePassword && passwordInput && passwordEyeIcon) {
        btnTogglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            passwordEyeIcon.classList.toggle('fa-eye', !isPassword);
            passwordEyeIcon.classList.toggle('fa-eye-slash', isPassword);
        });
    }

    // Helper Validasi Format Email
    function checkEmailFormat(val) {
        if (!val.includes('@') || !val.includes('.')) {
            return false;
        }
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(val);
    }

    function showEmailError(msg) {
        if (emailFeedbackText && emailFeedback && emailInput) {
            emailFeedbackText.textContent = msg;
            emailInput.classList.add('is-invalid');
            emailFeedback.classList.remove('d-none');
            emailFeedback.classList.add('d-flex');
        }
    }

    function hideEmailError() {
        if (emailFeedback && emailInput) {
            emailInput.classList.remove('is-invalid');
            emailFeedback.classList.add('d-none');
            emailFeedback.classList.remove('d-flex');
        }
    }

    function validateEmail(forceValidation) {
        if (!emailInput) return true;
        const val = emailInput.value.trim();

        if (!val) {
            if (forceValidation || isFormSubmitted) {
                showEmailError('Alamat email wajib diisi.');
                return false;
            } else {
                hideEmailError();
                return false;
            }
        }

        if (!checkEmailFormat(val)) {
            showEmailError('Format email tidak valid.');
            return false;
        }

        hideEmailError();
        return true;
    }

    function showPasswordError(msg) {
        if (passwordFeedbackText && passwordFeedback && passwordInput) {
            passwordFeedbackText.textContent = msg;
            passwordInput.classList.add('is-invalid');
            passwordFeedback.classList.remove('d-none');
            passwordFeedback.classList.add('d-flex');
        }
    }

    function hidePasswordError() {
        if (passwordFeedback && passwordInput) {
            passwordInput.classList.remove('is-invalid');
            passwordFeedback.classList.add('d-none');
            passwordFeedback.classList.remove('d-flex');
        }
    }

    function validatePassword(forceValidation) {
        if (!passwordInput) return true;
        const val = passwordInput.value;

        if (!val) {
            if (forceValidation || isFormSubmitted) {
                showPasswordError('Kata sandi harus diisi.');
                return false;
            } else {
                hidePasswordError();
                return false;
            }
        }

        hidePasswordError();
        return true;
    }

    if (emailInput) {
        emailInput.addEventListener('input', function () {
            hasServerEmailError = false;
            const val = emailInput.value.trim();
            if (val === '') {
                if (isFormSubmitted) {
                    showEmailError('Alamat email wajib diisi.');
                } else {
                    hideEmailError();
                }
            } else {
                validateEmail(false);
            }
        });

        emailInput.addEventListener('blur', function () {
            if (hasServerEmailError) return;
            if (emailInput.value.trim() !== '' || isFormSubmitted) {
                validateEmail(true);
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            hasServerPasswordError = false;
            const val = passwordInput.value;
            if (!val) {
                if (isFormSubmitted) {
                    showPasswordError('Kata sandi harus diisi.');
                }
            } else {
                hidePasswordError();
            }
        });

        passwordInput.addEventListener('blur', function () {
            if (hasServerPasswordError) return;
            if (!passwordInput.value && !isFormSubmitted) {
                hidePasswordError();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            isFormSubmitted = true;
            const isEmailValid = validateEmail(true);
            const isPasswordValid = validatePassword(true);

            if (!isEmailValid || !isPasswordValid) {
                e.preventDefault();
                if (!isEmailValid && emailInput) {
                    emailInput.focus();
                } else if (!isPasswordValid && passwordInput) {
                    passwordInput.focus();
                }
            }
        });
    }

    // Capture Geolocation Coordinates
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latEl = document.getElementById('loginLatitude');
                const lngEl = document.getElementById('loginLongitude');
                if (latEl && lngEl) {
                    latEl.value = position.coords.latitude;
                    lngEl.value = position.coords.longitude;
                }
            },
            function (error) {
                console.debug('Geolocation info:', error.message);
            },
            { timeout: 6000, enableHighAccuracy: false, maximumAge: 60000 }
        );
    }
});
</script>
@endsection
