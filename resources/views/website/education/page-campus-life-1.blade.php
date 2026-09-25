@extends('website.education.index')

@section('title', 'Multipage - Education Campus Life Page | Unify - Responsive Website Template')

@section('content')
<!-- Promo Block -->
      <div class="g-flex-centered g-bg-img-hero g-bg-pos-top-center g-bg-cover g-bg-bluegray-opacity-0_2--after" style="background-image: url({{ asset('asset_education/img-temp') }}/1920x1080/img1.jpg);" data-calc-target="#js-header">
        <div class="container g-pos-rel g-z-index-1 g-py-100">
          <div class="u-shadow-v36 g-max-width-550 g-bg-main-light-v1 g-pa-50">
            <div class="g-mb-40">
              <h1 class="g-color-white g-font-size-40--md mb-3">Embrace Student Life</h1>
              <p class="g-color-white-opacity-0_8 g-font-size-18--md">Unify is Canada's most extraordinary environment for discovery and innovation that helps you to experience uni in full color.</p>
            </div>
            <a class="btn u-shadow-v32 g-brd-2 g-brd-white-opacity-0_6 g-color-white-opacity-0_8 g-color-primary--hover g-bg-white--hover g-rounded-30 g-px-35 g-py-10" href="#">See What's Happening</a>
          </div>
        </div>
      </div>
      <!-- End Promo Block -->

      <!-- Section Links -->
      <div class="g-brd-bottom g-brd-secondary-light-v2">
        <div class="container">
          <div class="g-max-width-700 text-center mx-auto">
            <!-- Section Links (Large Devices) -->
            <ul class="row list-inline g-hidden-xs-down mb-0">
              <li class="col-3 list-inline-item mr-0">
                <a class="js-go-to active u-link-v5 g-color-main g-color-primary--hover g-color-primary--active g-font-size-default text-uppercase g-py-40" href="#" data-target="#overview">Overview</a>
              </li>
              <li class="col-3 list-inline-item text-center mr-0">
                <a class="js-go-to u-link-v5 g-color-main g-color-primary--hover g-color-primary--active g-font-size-default text-uppercase g-py-40" href="#" data-target="#recognition">Recognition</a>
              </li>
              <li class="col-3 list-inline-item text-center mr-0">
                <a class="js-go-to u-link-v5 g-color-main g-color-primary--hover g-color-primary--active g-font-size-default text-uppercase g-py-40" href="#" data-target="#student-life">Student Life</a>
              </li>
              <li class="col-3 list-inline-item text-center mr-0">
                <a class="js-go-to u-link-v5 g-color-main g-color-primary--hover g-color-primary--active g-font-size-default text-uppercase g-py-40" href="#" data-target="#campus-info">Campus Info</a>
              </li>
            </ul>
            <!-- End Section Links (Large Devices) -->

            <!-- End Section Links (Small Devices) -->
            <div class="btn-group g-hidden-sm-up g-py-40" role="group">
              <button id="btnGroupDrop1" type="button" class="btn g-brd-secondary-light-v2 g-bg-white dropdown-toggle g-px-25 g-py-8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Go to section ...
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="js-go-to dropdown-item g-color-main g-color-primary--hover g-bg-transparent g-font-size-13 text-uppercase g-py-8" href="#" data-target="#overview">Overview</a>
                <a class="js-go-to dropdown-item g-color-main g-color-primary--hover g-bg-transparent g-font-size-13 text-uppercase g-py-8" href="#" data-target="#recognition">Recognition</a>
                <a class="js-go-to dropdown-item g-color-main g-color-primary--hover g-bg-transparent g-font-size-13 text-uppercase g-py-8" href="#" data-target="#student-life">Student Life</a>
                <a class="js-go-to dropdown-item g-color-main g-color-primary--hover g-bg-transparent g-font-size-13 text-uppercase g-py-8" href="#" data-target="#campus-info">Campus Info</a>
              </div>
            </div>
            <!-- End Section Links (Small Devices) -->
          </div>
        </div>
      </div>
      <!-- End Section Links -->

      <!-- Overview -->
      <div id="overview" class="container g-pt-100 g-pb-70">
        <div class="g-max-width-700 text-center mx-auto">
          <!-- Heading -->
          <div class="g-mb-70">
            <h2 class="h1 mb-3">Discover why our student experience is voted best in Canada</h2>
            <p>There’s more to uni life than what happens inside the classroom. Make the most of your opportunity to get involved in campus culture, connect with others and find support to help you succeed.</p>
          </div>
          <!-- End Heading -->

          <!-- Youtube Iframe -->
          <div class="embed-responsive embed-responsive-16by9 u-shadow-v36 g-brd-around g-brd-10 g-brd-white g-rounded-5 g-mb-80">
            <iframe src="https://www.youtube.com/embed/FxiskmF16gU?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
          </div>
          <!-- End Youtube Iframe -->
        </div>

        <!-- Facts & Figures -->
        <div class="row">
          <div class="col-md-4 g-mb-30">
            <span class="d-block g-font-weight-300 g-font-size-60 mb-3">1978</span>
            <p>Unify Campus was founded in Anthony's dorm room at the University of Unify.</p>
          </div>
          <div class="col-md-4 g-mb-30">
            <span class="d-block g-font-weight-300 g-font-size-60 mb-3">10,000+</span>
            <p>Unify has grown to a team of more than 10,000 talented individuals.</p>
          </div>
          <div class="col-md-4 g-mb-30">
            <span class="d-block g-font-weight-300 g-font-size-60 mb-3">Millions</span>
            <p>Since opening, millions of students have been graduated from the Unify University.</p>
          </div>
        </div>
        <!-- End Facts & Figures -->
      </div>
      <!-- End Overview -->

      <!-- Image -->
      <div class="clearfix">
        <img class="img-fluid" src="{{ asset('asset_education/img-temp') }}/1920x1080/img2.jpg" alt="Image Description">
      </div>
      <!-- End Image -->

      <!-- Recognition -->
      <div id="recognition" class="container g-pt-100 g-pb-70">
        <!-- Heading -->
        <div class="g-max-width-645 text-center mx-auto g-mb-60">
          <h2 class="h1 mb-3">Recognition</h2>
          <p>As a truly exceptional place to study in Ontario, we consistently win workplace recognition in our industry.</p>
        </div>
        <!-- End Heading -->

        <div class="row g-mb-60">
          <div class="col-sm-6 col-lg-3 g-mb-30">
            <!-- Research Articles -->
            <article class="u-block-hover g-min-height-250 g-bg-img-hero g-bg-cover g-bg-white-gradient-opacity-v1--after g-pos-rel" style="background-image: url({{ asset('asset_education/img-temp') }}/600x400/img1.jpg);">
              <div class="u-block-hover__additional--partially-slide-up g-pos-abs g-bottom-0 g-left-0 g-z-index-1">
                <div class="u-block-hover__visible g-pa-20">
                  <h3 class="h4 g-color-white mb-0">Professor Monica Reilly wins AFR Emerging Leader award</h3>
                </div>
                <div class="g-pa-5"></div>
              </div>
              <a class="u-link-v2 g-z-index-2" href="#"></a>
            </article>
            <!-- End Research Articles -->
          </div>

          <div class="col-sm-6 col-lg-3 g-mb-30">
            <!-- Research Articles -->
            <article>
              <div class="g-pos-rel">
                <img class="img-fluid mb-3" src="{{ asset('asset_education/img-temp') }}/600x350/img23.jpg" alt="Image Description">
                <a class="js-fancybox g-absolute-centered" href="https://www.youtube.com/watch?v=FxiskmF16gU" title="Video">
                  <span class="u-icon-v3 u-block-hover--scale g-color-main g-color-white--hover g-bg-white-opacity-0_5 g-bg-white-opacity-0_3--hover g-font-size-22 rounded-circle">
                    <i class="g-pos-rel g-left-2 fa fa-play"></i>
                  </span>
                </a>
              </div>
              <span class="d-block g-color-secondary-light-v1 g-font-weight-500 g-font-size-12 text-uppercase mb-2">Video</span>
              <h4 class="h5"><a class="js-fancybox h5 u-link-v5" href="https://www.youtube.com/watch?v=FxiskmF16gU">University authors shortlisted for state’s top history awards</a></h4>
            </article>
            <!-- End Research Articles -->
          </div>

          <div class="col-sm-6 col-lg-3 g-mb-30">
            <!-- Research Articles -->
            <article>
              <div class="g-pos-rel">
                <img class="img-fluid mb-3" src="{{ asset('asset_education/img-temp') }}/600x350/img11.jpg" alt="Image Description">
                <a class="js-fancybox g-absolute-centered" href="https://www.youtube.com/watch?v=FxiskmF16gU" title="Video">
                  <span class="u-icon-v3 u-block-hover--scale g-color-main g-color-white--hover g-bg-white-opacity-0_5 g-bg-white-opacity-0_3--hover g-font-size-22 rounded-circle">
                    <i class="g-pos-rel g-left-2 fa fa-play"></i>
                  </span>
                </a>
              </div>
              <span class="d-block g-color-secondary-light-v1 g-font-weight-500 g-font-size-12 text-uppercase mb-2">Video</span>
              <h4 class="h5"><a class="js-fancybox h5 u-link-v5" href="https://www.youtube.com/watch?v=FxiskmF16gU">Four Unify finalists announced in Eureka science awards</a></h4>
            </article>
            <!-- End Research Articles -->
          </div>

          <div class="col-sm-6 col-lg-3 g-mb-30">
            <!-- Research Articles -->
            <article class="u-block-hover g-min-height-250 g-bg-img-hero g-bg-cover g-bg-white-gradient-opacity-v1--after g-pos-rel" style="background-image: url({{ asset('asset_education/img-temp') }}/600x400/img3.jpg);">
              <div class="u-block-hover__additional--partially-slide-up g-pos-abs g-bottom-0 g-left-0 g-z-index-1">
                <div class="u-block-hover__visible g-pa-20">
                  <h3 class="h4 g-color-white mb-0">Unify researchers recognised as Superstars of STEM</h3>
                </div>
                <div class="g-pa-5"></div>
              </div>
              <a class="u-link-v2 g-z-index-2" href="#"></a>
            </article>
            <!-- End Research Articles -->
          </div>
        </div>

        <hr class="g-brd-secondary-light-v2 mt-0 g-mb-60">

        <!-- Info -->
        <div class="row text-center">
          <div class="col-md-4 g-py-15 g-mb-30">
            <div class="g-px-30--lg">
              <h3 class="h5">Extraordinary environment</h3>
              <p class="g-color-text-light-v1 mb-0">In an extraordinary environment that inspires you to new ways of thinking.</p>
            </div>
          </div>
          <div class="col-md-4 g-brd-x g-brd-secondary-light-v2 g-py-15 g-mb-30">
            <div class="g-px-30--lg">
              <h3 class="h5">Dynamic learning opportunities</h3>
              <p class="g-color-text-light-v1 mb-0">In a landscape full of dynamic learning opportunities.</p>
            </div>
          </div>
          <div class="col-md-4 g-py-15 g-mb-30">
            <div class="g-px-30--lg">
              <h3 class="h5">Endless opportunities</h3>
              <p class="g-color-text-light-v1 mb-0">In a community that provides endless opportunities for you to make impact.</p>
            </div>
          </div>
        </div>
        <!-- End Info -->
      </div>
      <!-- End Recognition -->

      <!-- Image -->
      <div class="clearfix">
        <img class="img-fluid" src="{{ asset('asset_education/img-temp') }}/1920x1080/img3.jpg" alt="Image Description">
      </div>
      <!-- End Image -->

      <!-- Student Life -->
      <div id="student-life" class="g-bg-img-hero" style="background-image: url({{ asset('asset_education/include') }}/svg/svg-bg3.svg);">
        <div class="container g-pt-100 g-pb-70">
          <div class="row justify-content-lg-center g-pb-80">
            <div class="col-lg-1 g-mb-20 g-mb-0--lg">
              <span class="u-icon-v1 u-icon-size--xl g-color-main g-bg-secondary rounded-circle">
                <i class="g-font-size-45 material-icons">supervisor_account</i>
              </span>
            </div>

            <div class="col-lg-9">
              <div class="g-pl-15--lg">
                <h3>Student Life</h3>
                <p>Your student experience isn't just about what you study - it's about the community you learn, grow, play and cheer with. <a class="u-link-v5 g-color-primary g-color-main--hover g-font-weight-500" href="#">Learn more <i class="g-font-size-13 g-pos-rel g-top-2 material-icons">arrow_forward</i></a></p>

                <div class="row">
                  <!-- Student Life List -->
                  <ul class="col-md-4 list-unstyled mb-0">
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Student resources</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Student societies &amp; clubs</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Accessible education</a>
                    </li>
                  </ul>
                  <!-- End Student Life List -->

                  <!-- Student Life List -->
                  <ul class="col-md-4 list-unstyled mb-0">
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Equity &amp; human rights</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Counselling Services</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Academic advising</a>
                    </li>
                  </ul>
                  <!-- End Student Life List -->

                  <!-- Student Life List -->
                  <ul class="col-md-4 list-unstyled mb-0">
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> International students</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Co-op, career &amp; job postings</a>
                    </li>
                    <li class="py-1"><a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
                      <i class="g-color-primary g-font-size-13 mr-2 material-icons">arrow_forward</i> Health Services</a>
                    </li>
                  </ul>
                  <!-- End Student Life List -->
                </div>
              </div>
            </div>
          </div>

          <!-- Icon Blocks -->
          <div class="row">
            <div class="col-lg-6 g-mb-30">
              <!-- Media -->
              <div class="media u-block-hover u-shadow-v34 g-bg-white rounded g-overflow-hidden g-px-40 g-py-50">
                <div class="d-flex g-mr-30">
                  <span class="u-icon-v1 u-icon-size--xl g-color-main g-color-primary--hover g-bg-secondary rounded-circle">
                    <i class="g-font-size-45 material-icons">business</i>
                  </span>
                </div>
                <div class="media-body">
                  <h3 class="h4 g-color-main g-color-primary--hover g-font-primary">Uni isn't just about study <i class="g-font-size-16 mr-2 material-icons">arrow_forward</i></h3>
                  <p class="mb-0">Our campuses play host to a range of entertainment and events throughout the year. From weekly pub trivia to live music festivals.</p>
                </div>
                <a class="u-link-v2 g-z-index-2" href="#"></a>
              </div>
              <!-- End Media -->
            </div>

            <div class="col-lg-6 g-mb-30">
              <!-- Media -->
              <div class="media u-block-hover u-shadow-v34 g-bg-white rounded g-overflow-hidden g-px-40 g-py-50">
                <div class="d-flex g-mr-30">
                  <span class="u-icon-v1 u-icon-size--xl g-color-main g-color-primary--hover g-bg-secondary rounded-circle">
                    <i class="g-font-size-45 material-icons">beach_access</i>
                  </span>
                </div>
                <div class="media-body">
                  <h3 class="h4 g-color-main g-color-primary--hover g-font-primary">Housing options <i class="g-font-size-16 mr-2 material-icons">arrow_forward</i></h3>
                  <p class="mb-0">If you're studying at Unify in September 2017, join our fantastic residence community and take advantage of everything Unify has to offer.</p>
                </div>
                <a class="u-link-v2 g-z-index-2" href="#"></a>
              </div>
              <!-- End Media -->
            </div>
          </div>
          <!-- End Icon Blocks -->
        </div>
      </div>
      <!-- End Student Life -->

      <!-- Campus Info -->
      <div id="campus-info" class="container g-pt-100">
        <div class="row align-items-center">
          <div class="col-sm-4 col-lg-2 g-mb-50">
            <!-- Icon Block -->
            <a class="d-block u-block-hover u-shadow-v39 g-brd-around g-brd-teal g-bg-teal--hover text-center rounded g-text-underline--none--hover g-transition-0_2 g-px-30 g-py-80" href="#">
              <span class="u-icon-v1 u-icon-size--lg g-color-teal g-color-white--hover g-transition-0_2">
                <i class="icon-real-estate-027 u-line-icon-pro"></i>
              </span>
              <span class="h5 d-block g-color-teal g-color-white--hover g-transition-0_2">Finding your<br>way</span>
            </a>
            <!-- End Icon Block -->
          </div>

          <div class="col-sm-4 col-lg-2 g-mb-50">
            <!-- Icon Block -->
            <a class="d-block u-block-hover u-shadow-v39 g-brd-around g-brd-blue g-bg-blue--hover text-center rounded g-text-underline--none--hover g-transition-0_2 g-px-30 g-py-80" href="#">
              <span class="u-icon-v1 u-icon-size--lg g-color-blue g-color-white--hover g-transition-0_2">
                <i class="icon-real-estate-066 u-line-icon-pro"></i>
              </span>
              <span class="h5 d-block g-color-blue g-color-white--hover g-transition-0_2">Campus accessibility</span>
            </a>
            <!-- End Icon Block -->
          </div>

          <div class="col-sm-4 col-lg-2 g-mb-50">
            <!-- Icon Block -->
            <a class="d-block u-block-hover u-shadow-v39 g-brd-around g-brd-purple g-bg-purple--hover text-center rounded g-text-underline--none--hover g-transition-0_2 g-px-30 g-py-80" href="#">
              <span class="u-icon-v1 u-icon-size--lg g-color-purple g-color-white--hover g-transition-0_2">
                <i class="icon-real-estate-015 u-line-icon-pro"></i>
              </span>
              <span class="h5 d-block g-color-purple g-color-white--hover g-transition-0_2">Housing information</span>
            </a>
            <!-- End Icon Block -->
          </div>

          <div class="col-lg-6 g-mb-50">
            <div class="g-pl-50--lg">
              <div class="mb-5">
                <h2 class="mb-3">Campus info</h2>
                <p>The University of Victoria is easy to get to and easy to get around. Connected to downtown Victoria by several major bus and bicycle routes, the campus offers ample parking and an accessible and pedestrian-friendly environment.</p>
              </div>
              <a class="btn u-shadow-v39 g-brd-main g-brd-primary--hover g-color-main g-color-white--hover g-bg-primary--hover g-font-size-default g-rounded-30 g-px-35 g-py-11" href="#">View All</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End Campus Info -->

      <!-- Call to Action -->
      <div class="g-pos-rel">
        <div class="container text-center g-pt-100 g-pb-50">
          <!-- Heading -->
          <div class="g-max-width-645 mx-auto g-mb-40">
            <h2 class="h1 mb-3">Join Unify University</h2>
            <p>Our strategy is simple: to create a place where the best researchers and most promising students can achieve their full potential.</p>
          </div>
          <!-- End Heading -->

          <a class="btn u-shadow-v33 g-color-white g-bg-primary g-bg-main--hover g-rounded-30 g-px-35 g-py-13" href="page-apply-1.html">Apply Now</a>

          <!-- SVG Shape -->
          <svg class="d-inline-block g-width-35" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 37 1" enable-background="new 0 0 37 1" xml:space="preserve">
            <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="0" y1="0.5" x2="37" y2="0.5">
              <stop  offset="0" style="stop-color:#f5f6fa"/>
              <stop  offset="1" style="stop-color:#b5b8cb"/>
            </linearGradient>
            <line fill="none" stroke="url(#SVGID_5_)" stroke-miterlimit="10" x1="37" y1="0.5" x2="0" y2="0.5"/>
          </svg>
          <!-- End SVG Shape -->

          <span class="align-middle g-color-primary mx-1">or</span>

          <!-- SVG Shape -->
          <svg class="d-inline-block g-width-35" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 37 1" enable-background="new 0 0 37 1" xml:space="preserve">
            <linearGradient id="SVGID_6_" gradientUnits="userSpaceOnUse" x1="-10" y1="-1.5" x2="27" y2="-1.5" gradientTransform="matrix(-1 0 0 -1 27 -1)">
              <stop  offset="0" style="stop-color:#f5f6fa"/>
              <stop  offset="1" style="stop-color:#b5b8cb"/>
            </linearGradient>
            <line fill="none" stroke="url(#SVGID_6_)" stroke-miterlimit="10" x1="0" y1="0.5" x2="37" y2="0.5"/>
          </svg>
          <!-- End SVG Shape -->

          <a class="btn u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-main--hover g-rounded-30 g-px-35 g-py-13" href="page-contacts-1.html">Contact Us</a>
        </div>

        <!-- SVG Background Shape -->
        <svg class="g-pos-abs g-bottom-0 g-left-0 g-z-index-minus-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 1920 323" enable-background="new 0 0 1920 323" xml:space="preserve">
          <polygon fill="#f0f2f8" points="0,323 1920,323 1920,0 "/>
          <polygon fill="#f5f6fa" points="-0.5,322.5 -0.5,131.5 658.3,212.3 "/>
        </svg>
        <!-- End SVG Background Shape -->
      </div>
      <!-- End Call to Action -->
@endsection
