<!-- Header -->
<header id="js-header" class="u-header">
  <div class="u-header__section">
    <!-- Topbar -->
    <div class="g-bg-main">
      <div class="container g-py-5">
        <ul class="list-inline d-flex align-items-center g-mb-0">
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-brd-around g-brd-white-opacity-0_2 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 g-rounded-20 text-uppercase g-px-20 g-py-10" href="{{ route('education.apply') }}">Apply for Fall intake</a>
          </li>

          <!-- Language -->
          <li class="list-inline-item g-pos-rel ml-lg-auto">
            <a id="language-dropdown-invoker" class="d-none d-sm-flex align-items-center u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-pl-0 g-pl-10--lg g-pr-10 g-py-15" href="#"
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
              <svg xmlns="http://www.w3.org/2000/svg" height="11" width="27" viewBox="0 0 640 480">
                <defs>
                  <clipPath id="a">
                    <path fill-opacity=".67" d="M-85.333 0h682.67v512h-682.67z"/>
                  </clipPath>
                </defs>
                <g clip-path="url(#a)" transform="translate(80) scale(.94)">
                  <g stroke-width="1pt">
                    <path fill="#006" d="M-256 0H768.02v512.01H-256z"/>
                    <path d="M-256 0v57.244l909.535 454.768H768.02V454.77L-141.515 0H-256zM768.02 0v57.243L-141.515 512.01H-256v-57.243L653.535 0H768.02z" fill="#fff"/>
                    <path d="M170.675 0v512.01h170.67V0h-170.67zM-256 170.67v170.67H768.02V170.67H-256z" fill="#fff"/>
                    <path d="M-256 204.804v102.402H768.02V204.804H-256zM204.81 0v512.01h102.4V0h-102.4zM-256 512.01L85.34 341.34h76.324l-341.34 170.67H-256zM-256 0L85.34 170.67H9.016L-256 38.164V0zm606.356 170.67L691.696 0h76.324L426.68 170.67h-76.324zM768.02 512.01L426.68 341.34h76.324L768.02 473.848v38.162z" fill="#c00"/>
                  </g>
                </g>
              </svg>
              English
              <i class="g-ml-3 fa fa-angle-down"></i>
            </a>

            <ul id="language-dropdown" class="list-unstyled u-shadow-v39 g-brd-around g-brd-4 g-brd-white g-bg-secondary g-pos-abs g-left-0 g-z-index-99 g-mt-5"
                aria-labelledby="language-dropdown-invoker">
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="#">
                  <svg class="mr-1 g-ml-minus-10" xmlns="http://www.w3.org/2000/svg" height="11" width="27" viewBox="0 0 640 480">
                    <defs>
                      <clipPath id="b">
                        <path fill-opacity=".67" d="M-85.333 0h682.67v512h-682.67z"/>
                      </clipPath>
                    </defs>
                    <g clip-path="url(#b)" transform="translate(80) scale(.94)">
                      <g stroke-width="1pt">
                        <path fill="#006" d="M-256 0H768.02v512.01H-256z"/>
                        <path d="M-256 0v57.244l909.535 454.768H768.02V454.77L-141.515 0H-256zM768.02 0v57.243L-141.515 512.01H-256v-57.243L653.535 0H768.02z" fill="#fff"/>
                        <path d="M170.675 0v512.01h170.67V0h-170.67zM-256 170.67v170.67H768.02V170.67H-256z" fill="#fff"/>
                        <path d="M-256 204.804v102.402H768.02V204.804H-256zM204.81 0v512.01h102.4V0h-102.4zM-256 512.01L85.34 341.34h76.324l-341.34 170.67H-256zM-256 0L85.34 170.67H9.016L-256 38.164V0zm606.356 170.67L691.696 0h76.324L426.68 170.67h-76.324zM768.02 512.01L426.68 341.34h76.324L768.02 473.848v38.162z" fill="#c00"/>
                      </g>
                    </g>
                  </svg>
                  English
                </a>
              </li>
              <li class="dropdown-item g-px-0 g-py-2">
                <a class="nav-link d-flex align-items-center g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="#">
                  <svg class="mr-1 g-ml-minus-10" xmlns="http://www.w3.org/2000/svg" height="11" width="27" viewBox="0 0 640 480">
                    <g fill-rule="evenodd" stroke-width="1pt">
                      <path fill="#fff" d="M0 0h640v480H0z"/>
                      <path fill="#0039a6" d="M0 160.003h640V480H0z"/>
                      <path fill="#d52b1e" d="M0 319.997h640V480H0z"/>
                    </g>
                  </svg>
                  Russian
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
              Jump To
              <i class="g-ml-3 fa fa-angle-down"></i>
            </a>
            <ul id="jump-to-dropdown" class="list-unstyled u-shadow-v39 g-brd-around g-brd-4 g-brd-white g-bg-secondary g-pos-abs g-left-0 g-z-index-99 g-mt-13"
                aria-labelledby="jump-to-dropdown-invoker">
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.apply') }}">Apply Now</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.campus-life') }}">Campus Life</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.research') }}">Research</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.help') }}">Help</a>
              </li>
              <li class="dropdown-item g-brd-bottom g-brd-2 g-brd-white g-px-0 g-py-2">
                <a class="nav-link g-color-main g-color-primary--hover g-bg-secondary-dark-v2--hover g-font-size-default" href="{{ route('education.contacts') }}">Contacts</a>
              </li>
              <li class="dropdown-item g-px-0 g-py-2">
                @if (Route::has('login'))
                  @auth
                    <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ url('/dashboard') }}">Dashboard</a>
                  @else
                    <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ route('login') }}">Sign in</a>
                  @endauth
                @else
                  <a class="nav-link g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-default" href="{{ route('login') }}">Sign in</a>
                @endif
              </li>
            </ul>
          </li>
          <!-- End Jump To -->

          <!-- Links -->
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.campus-life') }}">Campus Life</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.research') }}">Research</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.help') }}">Help</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            <a class="u-link-v5 g-color-white-opacity-0_7 g-color-white--hover g-font-size-12 text-uppercase g-px-10 g-py-15" href="{{ route('education.contacts') }}">Contacts</a>
          </li>
          <li class="list-inline-item d-none d-lg-inline-block">
            @if (Route::has('login'))
                @auth
                    <a class="u-link-v5 u-shadow-v19 g-color-white--hover g-bg-white g-bg-primary--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-10" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="u-link-v5 u-shadow-v19 g-color-white--hover g-bg-white g-bg-primary--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-10" href="{{ route('login') }}">Sign in</a>
                    @if (Route::has('register'))
                        <a class="u-link-v5 u-shadow-v19 g-color-white g-bg-primary g-bg-primary-light-v1--hover g-font-size-12 text-uppercase g-rounded-20 g-px-18 g-py-8 g-ml-5" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
          </li>
          <!-- End Links -->

          <!-- Search -->
          <li class="list-inline-item g-ml-15--lg ml-auto">
            <form id="searchform-1" class="input-group u-shadow-v19 g-brd-primary--focus g-rounded-20">
              <input class="form-control g-brd-none g-bg-white g-font-size-12 text-uppercase g-rounded-left-20 g-pl-20 g-py-9" type="text" placeholder="Search here ...">
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
                Pages
                <i class="hs-icon hs-icon-arrow-bottom g-font-size-11 g-ml-7"></i>
              </a>

              <!-- Mega Menu -->
              <div class="w-100 hs-mega-menu u-shadow-v39 g-brd-around g-brd-7 g-brd-white g-bg-secondary g-text-transform-none g-pa-30 g-pa-50--lg g-my-20 g-my-0--lg" aria-labelledby="mega-menu-label-1">
                <span class="d-block h1 g-brd-bottom g-brd-2 g-brd-main pb-2 mb-5">Pages</span>

                <div class="row">
                  <div class="col-sm-6 col-lg-3">
                    <!-- Links -->
                    <ul class="list-unstyled g-pr-30 mb-0">
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.programs') }}">
                          Programs
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.future-students') }}">
                          Future Students
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.current-students') }}">
                          Current Students
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
                          Faculty &amp; Staff
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.events') }}">
                          Events
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.alumni') }}">
                          Alumni
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
                          Campus Life
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.research') }}">
                          Research
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.apply') }}">
                          Apply
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
                          Contacts
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('education.help') }}">
                          Help
                          <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                        </a>
                      </li>
                      <li class="py-2">
                        @if (Route::has('login'))
                            @auth
                                <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ url('/dashboard') }}">
                                  Dashboard
                                  <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">dashboard</i>
                                </a>
                            @else
                                <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('login') }}">
                                  Sign in
                                  <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                                </a>
                            @endauth
                        @else
                            <a class="d-flex g-color-main g-color-primary--hover g-text-underline--none--hover g-py-5" href="{{ route('login') }}">
                              Sign in
                              <i class="g-color-primary g-font-size-15 g-pos-rel g-top-5 ml-auto material-icons">arrow_forward</i>
                            </a>
                        @endif
                      </li>
                      <li class="py-2">
                        <a class="d-flex g-brd-top g-brd-primary g-color-main g-color-primary--hover g-text-underline--none--hover g-pt-15 g-pb-5" href="{{ url('/') }}">
                          Main Home
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
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.programs') }}">
                Programs
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.future-students') }}">
                Future Students
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.current-students') }}">
                Current Students
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.faculty-and-staff') }}">
                Faculty &amp; Staff
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-px-15--lg g-py-10 g-py-30--lg" href="{{ route('education.events') }}">
                Events
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link g-color-primary--hover g-font-size-15 g-font-size-17--xl g-pl-15--lg g-pr-0--lg g-py-10 g-py-30--lg" href="{{ route('education.alumni') }}">
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
