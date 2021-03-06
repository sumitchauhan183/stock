<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/img/apple-icon.png')}}" >
  <link rel="icon" type="image/png" href="{{asset('admin/img/favicon.png')}}" >
  <title>
    {{$title}}
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{asset('admin/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('admin/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('admin/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
  <style>
      #sidenav-collapse-main{
          height: 80% !important;
          
      }

      .navbar-nav{
          padding-top: 20px !important;
      }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
  @include('inc.admin.sidenav')
  @yield('content')
  @include('inc.admin.plugin')
  <!--   Core JS Files   -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
  <script src="{{asset('admin/js/core/popper.min.js')}}"></script>
  <script src="{{asset('admin/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('admin/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('admin/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('admin/js/plugins/chartjs.min.js')}}"></script>

  <script src="{{asset('admin/js/plugins/chartjs.min.js')}}"></script>
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
  <script src="{{asset('admin/js/material-dashboard.min.js?v=3.0.0')}}"></script>

  @if($url=='dashboard')
  <script src="{{asset('admin/js/custom/dashboard.js')}}"></script>
  <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
          dashboard.init(); 
        });
    </script>
  @endif
</body>

</html>