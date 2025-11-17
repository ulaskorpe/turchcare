<!DOCTYPE html>
<html lang="{{session()->get('selectedLand')}}" dir="ltr">
@include('front.partials.head')
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">


    <main>
        <div class="page-loader">
          <div class="loader">Loading...</div>
        </div>
        @include('front.partials.nav')

    @yield('main')


    <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
  </main>

    <!--
    JavaScripts
    =============================================
    -->
    <script src="{{ url('assets/lib/jquery/dist/jquery.js') }}"></script>
    <script src="{{ url('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/lib/wow/dist/wow.js') }}"></script>
    <script src="{{ url('assets/lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js') }}"></script>
    <script src="{{ url('assets/lib/isotope/dist/isotope.pkgd.js') }}"></script>
    <script src="{{ url('assets/lib/imagesloaded/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ url('assets/lib/flexslider/jquery.flexslider.js') }}"></script>
    <script src="{{ url('assets/lib/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/lib/smoothscroll.js') }}"></script>
    <script src="{{ url('assets/lib/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
    <script src="{{ url('assets/lib/simple-text-rotator/jquery.simple-text-rotator.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
    @yield('scripts')
  </body>
</html>