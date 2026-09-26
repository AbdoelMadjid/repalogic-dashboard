<!-- Footer -->
<footer class="g-bg-secondary g-pt-100 g-pb-50">
  <div class="container">
    <div class="row g-mb-40">
      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.future-students') }}" data-lang="education-future-students">Future Students</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.current-students') }}" data-lang="education-current-students">Current Students</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.alumni') }}" data-lang="education-alumni">Alumni</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.faculty-and-staff') }}" data-lang="education-faculty-and-staff">Faculty &amp; Staff</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#" data-lang="education-donors">Donors</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.events') }}" data-lang="education-news-media">News &amp; Media</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.research') }}" data-lang="education-research-innovation">Research &amp; Innovation</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.programs') }}" data-lang="education-academics">Academics</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.programs') }}" data-lang="education-programs-study">Programs of Study</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.campus-life') }}" data-lang="education-university-life">University Life</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.contacts') }}" data-lang="education-contacts">Contacts</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.apply') }}" data-lang="education-careers">Careers</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.help') }}" data-lang="education-accessibility">Accessibility</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#" data-lang="education-privacy">Privacy</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#" data-lang="education-site-feedback">Site Feedback</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Downtown Ontario Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Mississauga Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Scarborough Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#" data-lang="education-campus-maps">Campus Maps</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#" data-lang="education-campus-safety">Campus Safety</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>
    </div>

    @php
        $createdYear = $appProfil->created_year ?? '2024';
        $currentYear = date('Y');
        $yearDisplay = ($createdYear != $currentYear) ? "{$createdYear} - {$currentYear}" : $currentYear;
        $footerText = $appProfil->footer_text ?? 'Theme By';
        $devName = $appProfil->developer_name ?? 'WebAppLayers';
        $devUrl = $appProfil->developer_url ?? '#!';
    @endphp

    <!-- Footer Copyright -->
    <div class="row justify-content-lg-center align-items-center text-center">
      <div class="col-sm-6 col-md-4 col-lg-3 order-md-3 g-mb-30">
        <a class="u-link-v5 g-color-text g-color-primary--hover" href="#">
          <i class="align-middle mr-2 icon-real-estate-027 u-line-icon-pro"></i>
          {{ $appProfil->address ?? 'Kingston, Ontario, Canada' }}
        </a>
      </div>

      <div class="col-sm-6 col-md-4 col-lg-3 order-md-2 g-mb-30">
        <!-- Social Icons -->
        <ul class="list-inline mb-0">
          <li class="list-inline-item g-mx-2">
            <a class="u-icon-v1 u-icon-size--sm u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-primary--hover rounded-circle" href="#">
              <i class="g-font-size-default fa fa-twitter"></i>
            </a>
          </li>
          <li class="list-inline-item g-mx-2">
            <a class="u-icon-v1 u-icon-size--sm u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-primary--hover rounded-circle" href="#">
              <i class="g-font-size-default fa fa-facebook"></i>
            </a>
          </li>
          <li class="list-inline-item g-mx-2">
            <a class="u-icon-v1 u-icon-size--sm u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-primary--hover rounded-circle" href="#">
              <i class="g-font-size-default fa fa-instagram"></i>
            </a>
          </li>
          <li class="list-inline-item g-mx-2">
            <a class="u-icon-v1 u-icon-size--sm u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-primary--hover rounded-circle" href="#">
              <i class="g-font-size-default fa fa-youtube"></i>
            </a>
          </li>
          <li class="list-inline-item g-mx-2">
            <a class="u-icon-v1 u-icon-size--sm u-shadow-v32 g-color-primary g-color-white--hover g-bg-white g-bg-primary--hover rounded-circle" href="#">
              <i class="g-font-size-default fa fa-linkedin"></i>
            </a>
          </li>
        </ul>
        <!-- End Social Icons -->
      </div>

      <div class="col-md-4 col-lg-3 order-md-1 g-mb-30">
        <p class="g-color-text mb-0">© {{ $yearDisplay }} {{ $appProfil->app_name ?? 'University of Unify' }}. All rights reserved.</p>
      </div>
    </div>
    <!-- End Footer Copyright -->
  </div>
</footer>
<!-- End Footer -->

<!-- Go to Top -->
<a class="js-go-to u-go-to-v1 u-shadow-v32 g-width-40 g-height-40 g-color-primary g-color-white--hover g-bg-white g-bg-main--hover g-bg-main--focus g-font-size-12 rounded-circle" href="#" data-type="fixed" data-position='{
 "bottom": 15,
 "right": 15
}' data-offset-top="400"
  data-compensation="#js-header"
  data-show-effect="slideInUp"
  data-hide-effect="slideInDown">
  <i class="hs-icon hs-icon-arrow-top"></i>
</a>
<!-- End Go to Top -->
