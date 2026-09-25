<!-- JS Global Compulsory -->
<script src="{{ asset('asset_education/vendor') }}/jquery/jquery.min.js"></script>
<script src="{{ asset('asset_education/vendor') }}/jquery-migrate/jquery-migrate.min.js"></script>
<script src="{{ asset('asset_education/vendor') }}/popper.js/popper.min.js"></script>
<script src="{{ asset('asset_education/vendor') }}/bootstrap/bootstrap.min.js"></script>

<!-- JS Implementing Plugins -->
<script src="{{ asset('asset_education/vendor') }}/hs-megamenu/src/hs.megamenu.js"></script>
<script src="{{ asset('asset_education/vendor') }}/slick-carousel/slick/slick.js"></script>
<script src="{{ asset('asset_education/vendor') }}/fancybox/jquery.fancybox.min.js"></script>
<script src="{{ asset('asset_education/vendor') }}/dzsparallaxer/dzsparallaxer.js"></script>
<script src="{{ asset('asset_education/vendor') }}/dzsparallaxer/dzsscroller/scroller.js"></script>
<script src="{{ asset('asset_education/vendor') }}/dzsparallaxer/advancedscroller/plugin.js"></script>
<script src="{{ asset('asset_education/vendor') }}/hs-bg-video/hs-bg-video.js"></script>
<script src="{{ asset('asset_education/vendor') }}/hs-bg-video/vendor/player.min.js"></script>

<!-- JS Unify -->
<script src="{{ asset('asset_education/js') }}/hs.core.js"></script>
<script src="{{ asset('asset_education/js') }}/components/hs.header.js"></script>
<script src="{{ asset('asset_education/js') }}/helpers/hs.hamburgers.js"></script>
<script src="{{ asset('asset_education/js') }}/components/hs.dropdown.js"></script>
<script src="{{ asset('asset_education/js') }}/helpers/hs.height-calc.js"></script>
<script src="{{ asset('asset_education/js') }}/components/hs.carousel.js"></script>
<script src="{{ asset('asset_education/js') }}/components/hs.popup.js"></script>
<script src="{{ asset('asset_education/js') }}/components/hs.go-to.js"></script>

<!-- JS Customization -->
<script src="{{ asset('asset_education/js') }}/custom.js"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
    // initialization of header
    if ($.HSCore && $.HSCore.components && $.HSCore.components.HSHeader) {
      $.HSCore.components.HSHeader.init($('#js-header'));
    }
    if ($.HSCore && $.HSCore.helpers && $.HSCore.helpers.HSHamburgers) {
      $.HSCore.helpers.HSHamburgers.init('.hamburger');
    }

    // initialization of HSMegaMenu component
    if ($('.js-mega-menu').length && $.fn.HSMegaMenu) {
      $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
      });
    }

    // initialization of HSDropdown component
    if ($.HSCore && $.HSCore.components && $.HSCore.components.HSDropdown) {
      $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {
        afterOpen: function () {
          $(this).find('input[type="search"]').focus();
        }
      });
    }

    // initialization of carousel
    if ($.HSCore && $.HSCore.components && $.HSCore.components.HSCarousel) {
      $.HSCore.components.HSCarousel.init('[class*="js-carousel"]');
    }

    // initialization of header's height equal offset
    if ($.HSCore && $.HSCore.helpers && $.HSCore.helpers.HSHeightCalc) {
      $.HSCore.helpers.HSHeightCalc.init();
    }

    // initialization of popups
    if ($.HSCore && $.HSCore.components && $.HSCore.components.HSPopup) {
      $.HSCore.components.HSPopup.init('.js-fancybox');
    }

    // initialization of go to
    if ($.HSCore && $.HSCore.components && $.HSCore.components.HSGoTo) {
      $.HSCore.components.HSGoTo.init('.js-go-to');
    }
  });
</script>
