<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
      href="{{ asset('frontend/') }}/node_modules/tiny-slider/dist/tiny-slider.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('frontend/') }}/node_modules/swiper/swiper-bundle.min.css" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="assets/images/favicon/favicon.ico"
    />

    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.46.0/tabler-icons.min.css"
    />
    <link
      rel="stylesheet"
      href="{{ asset('frontend/') }}/node_modules/simplebar/dist/simplebar.min.css"
    />

    <!-- Theme CSS -->
    <!-- build:css assets/css/theme.min.css -->
    <link rel="stylesheet" href="{{ asset('frontend/src') }}/assets/css/theme.css" />
    <!-- endbuild -->

    <title>Shine Beauty Care</title>
  </head>

  <body>
      
      @yield('content')
      @include('layouts.footer')
    

    <!-- Libs JS -->
    <script src="{{ asset('frontend') }}/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/node_modules/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->

    <!-- build:js assets/js/theme.min.js -->
    <script src="{{ asset('frontend/src/') }}/assets/js/main.js"></script>
    <!-- endbuild -->

    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/countdown.js"></script>

    <script src="{{ asset('frontend') }}/node_modules/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/tns-slider.js"></script>
    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/zoom.js"></script>
    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/language.js"></script>
    <!-- Swiper JS -->
    <script src="{{ asset('frontend') }}/node_modules/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/swiper.js"></script>
    <script src="{{ asset('frontend/src/') }}/assets/js/vendors/validation.js"></script>
  </body>
</html>
