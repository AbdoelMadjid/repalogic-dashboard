<!-- Footer -->
<footer class="g-bg-secondary g-pt-100 g-pb-50">
  <div class="container">
    <div class="row g-mb-40">
      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.future-students') }}">Future Students</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.current-students') }}">Current Students</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.alumni') }}">Alumni</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.faculty-and-staff') }}">Faculty &amp; Staff</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Donors</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.events') }}">News &amp; Media</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.research') }}">Research &amp; Innovation</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.programs') }}">Academics</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.programs') }}">Programs of Study</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.campus-life') }}">University Life</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.contacts') }}">Contacts</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.apply') }}">Careers</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="{{ route('education.help') }}">Accessibility</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Privacy</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Site Feedback</a></li>
        </ul>
        <!-- End Footer Links -->
      </div>

      <div class="col-6 col-md-3 g-mb-20">
        <!-- Footer Links -->
        <ul class="list-unstyled">
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Downtown Ontario Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Mississauga Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Scarborough Campus</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Campus Maps</a></li>
          <li class="g-py-5"><a class="u-link-v5 g-color-footer-links g-color-primary--hover g-font-size-16" href="#">Campus Safety</a></li>
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
