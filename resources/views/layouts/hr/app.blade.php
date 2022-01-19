
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('resources/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('resources/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('resources/css/material-dashboard.css') }}" rel="stylesheet" />

</head>

@if(session('user'))
    <body class="g-sidenav-show  bg-gray-200">
    @include('inc.hr.aside')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('inc.hr.navbar')  
    <div class="container-fluid py-4">
    @yield('content')
        @include('inc.hr.footer')
    </div>
  </main>
@else
    <body class="bg-gray-200"> 
    <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
    @yield('content')
        @include('inc.hr.footer')
    </div>
  </main>
@endif
      

        
     <!--   Core JS Files   -->
  <script src="{{ asset('resources/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('resources/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('resources/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('resources/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/material-dashboard.min.js?v=3.0.0') }}"></script> 
</body>
</html>