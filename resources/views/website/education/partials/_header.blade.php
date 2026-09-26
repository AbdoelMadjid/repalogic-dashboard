@php
    $currentLang = request()->cookie('__THEME_LANG__', 'id');
    $isEn = $currentLang === 'en';
    $currentFlag = $isEn ? asset('assets/images/flags/us.svg') : asset('assets/images/flags/id.svg');
    $currentLabel = $isEn ? 'English' : 'Indonesia';
    $currentCode = $isEn ? 'EN' : 'ID';
@endphp

<!-- Header -->
<header id="js-header" class="u-header">
  <div class="u-header__section">
    <!-- Topbar -->
    <div class="g-bg-main">
      <div class="container g-py-5">
        <ul class="list-inline d-flex align-items-center g-mb-0">
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-brd-around g-brd-white-opacity-0_2 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 g-rounded-20 text-uppercase g-px-20 g-py-10" href="{{ route('education.apply') }}" data-lang="education-apply-fall">Apply for Fall intake</a>
          </li>

          <!-- Language -->
          <li class="list-inline-item g-pos-rel ml-lg-auto" id="education-language-selector">
            <a id="language-dropdown-invoker" class="d-none d-sm-flex align-items-center u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-pl-0 g-pl-10--lg g-pr-10 g-py-15" href="javascript:void(0);"
               aria-controls="language-dropdown"
               aria-haspopup="true"
               aria-expanded="false"
               data-dropdown-event="hover"
               data-dropdown-target="#language-dropdown"
               data-dropdown-type="css-animation"
               data-dropdown-duration="100"
               data-dropdown-hide-on-scroll="true"
               data-dropdown-animation-in="fadeIn"
               data-dropdown-animation-out="fadeOut">
              <img id="edu-selected-lang-img" src="{{ $currentFlag }}" alt="{{ $currentLabel }}" class="rounded mr-2" style="width: 20px; height: 14px; object-fit: cover;" />
              <span id="edu-selected-lang-code">{{ $currentLabel }}</span>
              <i class="g-ml-3 fa fa-angle-down"></i>
            </a>

            <ul id="language-dropdown" class="list-unstyled u-shadow-v39 g-brd-around g-brd-4 g-brd-white g-bg-secondary g-pos-abs g-left-0 g-z-index-99 g-mt-5"
                aria-labelledby="language-dropdown-invoker">
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="javascript:void(0);" data-translator-lang="id" title="Indonesia">
                  <img src="{{ asset('assets/images/flags/id.svg') }}" alt="Indonesia" class="mr-2 rounded" style="width: 20px; height: 14px; object-fit: cover;" data-translator-image />
                  <span data-lang="education-lang-indonesia">Indonesia</span>
                </a>
              </li>
              <li class="dropdown-item g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="javascript:void(0);" data-translator-lang="en" title="English">
                  <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English" class="mr-2 rounded" style="width: 20px; height: 14px; object-fit: cover;" data-translator-image />
                  <span data-lang="education-lang-english">English</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- End Language -->

          <!-- Jump To -->
          <li class="list-inline-item g-pos-rel">
            <a id="jump-to-dropdown-invoker" class="d-block d-lg-none u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-py-7" href="#"
               aria-controls="jump-to-dropdown"
               aria-haspopup="true"
               aria-expanded="false"
               data-dropdown-event="hover"
               data-dropdown-target="#jump-to-dropdown"
               data-dropdown-type="css-animation"
               data-dropdown-duration="0"
               data-dropdown-hide-on-scroll="true"
               data-dropdown-animation-in="fadeIn"
               data-dropdown-animation-out="fadeOut">
              <span data-lang="education-jump-to">Jump To</span>
              <i class="g-ml-3 fa fa-angle-down"></i>
            </a>
            <ul id="jump-to-dropdown" class="list-unstyled u-shadow-v39 g-brd-around g-brd-4 g-brd-white g-bg-secondary g-pos-abs g-left-0 g-z-index-99 g-mt-13"
                aria-labelledby="jump-to-dropdown-invoker">
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.apply') }}" data-lang="education-apply-now">Apply Now</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.campus-life') }}" data-lang="education-campus-life">Campus Life</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.research') }}" data-lang="education-research">Research</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.help') }}" data-lang="education-help">Help</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.contacts') }}" data-lang="education-contacts">Contacts</a>
              </li>
              <!-- Mobile Language Switches -->
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="javascript:void(0);" data-translator-lang="id">
                  <img src="{{ asset('assets/images/flags/id.svg') }}" alt="Indonesia" class="mr-2 rounded" style="width: 18px; height: 12px; object-fit: cover;" />
                  Bahasa Indonesia
                </a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="javascript:void(0);" data-translator-lang="en">
                  <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English" class="mr-2 rounded" style="width: 18px; height: 12px; object-fit: cover;" />
                  English
                </a>
              </li>
              <li class="dropdown-item g-px-0 g-py-2">
                @if (Route::has('login'))
                  @auth
                    <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ url('/dashboard') }}" data-lang="education-dashboard">Dashboard</a>
                  @else
                    <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ route('login') }}" data-lang="education-sign-in">Sign in</a>
                  @endauth
                @else
                  <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ route('login') }}" data-lang="education-sign-in">Sign in</a>
                @endif
              </li>
            </ul>
          </li>
          <!-- End Jump To -->

          <!-- Links -->
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.campus-life') }}" data-lang="education-campus-life">Campus Life</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.research') }}" data-lang="education-research">Research</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.help') }}" data-lang="education-help">Help</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.contacts') }}" data-lang="education-contacts">Contacts</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            @if (Route::has('login'))
                @auth
                    <a class="u-link-v5 u-shadow-v19 g-color-white--hover g-bg-white g-bg-primary--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-10" href="{{ url('/dashboard') }}" data-lang="education-dashboard">Dashboard</a>
                @else
                    <a class="u-link-v5 u-shadow-v19 g-color-white--hover g-bg-white g-bg-primary--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-10" href="{{ route('login') }}" data-lang="education-sign-in">Sign in</a>
                    @if (Route::has('register'))
                        <a class="u-link-v5 u-shadow-v19 g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-5" href="{{ route('register') }}" data-lang="education-register">Register</a>
                    @endif
                @endauth
            @endif
          </li>
          <!-- End Links -->

          <!-- Search -->
          <li class="list-inline-item g-ml-15--lg ml-auto">
            <form id="searchform-1" class="input-group u-shadow-v19 g-brd-primary--focus g-rounded-20">
              <input class="form-control g-brd-none g-bg-white g-font-size-12 text-uppercase g-rounded-left-20 g-pl-20 g-py-9" type="text" placeholder="Search here ..." data-lang-placeholder="education-search-placeholder">
              <button class="btn input-group-addon d-flex align-items-center g-brd-none g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-13 g-rounded-right-20 g-transition-0_2" type="button">
                <i class="fa fa-search"></i>
              </button>
            </form>
          </li>
          <!-- End Search -->
        </ul>
      </div>
    </div>
    <!-- End Topbar -->

    <div class="container">
      <!-- Nav -->
      <nav class="js-mega-menu navbar navbar-expand-lg g-px-0 g-py-5 g-py-0--lg">
        <!-- Logo -->
        <a class="navbar-brand g-max-width-170 g-max-width-200--lg" href="{{ url('/') }}">
          @if ($appProfil && !empty($appProfil->logo_lg) && Storage::disk('public')->exists($appProfil->logo_lg))
            <img class="img-fluid g-hidden-lg-down" src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" style="max-height: 40px; object-fit: contain;">
            <img class="img-fluid g-hidden-lg-up" src="{{ asset('storage/' . $appProfil->logo_lg) }}" alt="{{ $appProfil->app_name }}" style="max-height: 35px; object-fit: contain;">
          @else
            <img class="img-fluid g-hidden-lg-down" src="{{ asset('asset_education/img') }}/logo/logo.png" alt="Logo">
            <img class="img-fluid g-width-80 g-hidden-md-down g-hidden-xl-up" src="{{ asset('asset_education/img') }}/logo/logo-mini.png" alt="Logo">
            <img class="img-fluid g-hidden-lg-up" src="{{ asset('asset_education/img') }}/logo/logo.png" alt="Logo">
          @endif
        </a>
        <!-- End Logo -->

        <!-- Responsive Toggle Button -->
        <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0" type="button"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="navBar"
                data-toggle="collapse"
                data-target="#navBar">
          <span class="hamburger hamburger--slider g-px-0">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </span>
        </button>
        <!-- End Responsive Toggle Button -->

        <!-- Navigation -->
        <div id="navBar" class="collapse navbar-collapse">
          <ul class="navbar-nav align-items-lg-center g-py-30 g-py-0--lg ml-auto">
            <!-- Pages - Mega Menu -->
            <li class="nav-item hs-has-mega-menu"
                data-animation-in="fadeIn"
                data-animation-out="fadeOut"
                data-position="left">
              <a id="mega-menu-label-1" class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="#"
                 aria-haspopup="true"
                 aria-expanded="false">
                <span data-lang="education-pages">Pages</span>
                <i class="hs-icon hs-icon-arrow-bottom g-font-size-11 g-ml-7"></i>
              </a>

              <!-- Mega Menu -->
              <div class="w-100 hs-mega-menu u-shadow-v39 g-brd-around g-brd-7 g-brd-white g-bg-secondary g-text-transform-none g-pa-30 g-pa-50--lg g-my-20 g-my-0--lg" aria-labelledby="mega-menu-label-1">
                <span class="d-block h1 g-brd-bottom g-brd-2 g-brd-main pb-2 mb-5" data-lang="education-pages">Pages</span>

                <div class="row">
                  <div class="col-sm-6 col-lg-3">
                    <!-- Links -->
                    <ul class="list-unstyled g-pr-30 mb-0">
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.programs') }}">
                          <span data-lang="education-programs">Programs</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.future-students') }}">
                          <span data-lang="education-future-students">Future Students</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.current-students') }}">
                          <span data-lang="education-current-students">Current Students</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                    </ul>
                    <!-- End Links -->
                  </div>

                  <div class="col-sm-6 col-lg-3">
                    <!-- Links -->
                    <ul class="list-unstyled g-pr-30 mb-0">
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.faculty-and-staff') }}">
                          <span data-lang="education-faculty-and-staff">Faculty &amp; Staff</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.events') }}">
                          <span data-lang="education-events">Events</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.alumni') }}">
                          <span data-lang="education-alumni">Alumni</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                    </ul>
                    <!-- End Links -->
                  </div>

                  <div class="col-sm-6 col-lg-3">
                    <!-- Links -->
                    <ul class="list-unstyled g-pr-30 mb-0">
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.campus-life') }}">
                          <span data-lang="education-campus-life">Campus Life</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.research') }}">
                          <span data-lang="education-research">Research</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.apply') }}">
                          <span data-lang="education-apply-now">Apply</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                    </ul>
                    <!-- End Links -->
                  </div>

                  <div class="col-sm-6 col-lg-3">
                    <!-- Links -->
                    <ul class="list-unstyled g-pr-30 mb-0">
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.contacts') }}">
                          <span data-lang="education-contacts">Contacts</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.help') }}">
                          <span data-lang="education-help">Help</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        @if (Route::has('login'))
                            @auth
                                <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ url('/dashboard') }}">
                                  <span data-lang="education-dashboard">Dashboard</span>
                                  <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">dashboard</i>
                                </a>
                            @else
                                <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('login') }}">
                                  <span data-lang="education-sign-in">Sign in</span>
                                  <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                                </a>
                            @endauth
                        @else
                            <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('login') }}">
                              <span data-lang="education-sign-in">Sign in</span>
                              <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                            </a>
                        @endif
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-brd-top g-brd-primary g-color-main g-color-primary--hover g-text-underline--none--hover g-pt-15 g-pb-5" href="{{ url('/') }}">
                          <span data-lang="education-main-home">Main Home</span>
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                    </ul>
                    <!-- End Links -->
                  </div>
                </div>
              </div>
              <!-- End Mega Menu -->
            </li>
            <!-- End Pages - Mega Menu -->

            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.programs') }}" data-lang="education-programs">
                Programs
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.future-students') }}" data-lang="education-future-students">
                Future Students
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.current-students') }}" data-lang="education-current-students">
                Current Students
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.faculty-and-staff') }}" data-lang="education-faculty-and-staff">
                Faculty &amp; Staff
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.events') }}" data-lang="education-events">
                Events
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-pl-15--lg g-pr-0--lg g-py-10 g-py-30--lg" href="{{ route('education.alumni') }}" data-lang="education-alumni">
                Alumni
              </a>
            </li>
          </ul>
        </div>
        <!-- End Navigation -->
      </nav>
      <!-- End Nav -->
    </div>
  </div>
</header>
<!-- End Header -->
