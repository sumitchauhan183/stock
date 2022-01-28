<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to AnalystKit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendors.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
    <title>{{config('app.name')}}</title>
  
</head>
<body>
    <div class="app">
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="{{ asset('images/loader.svg')}}" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader --> 
@include('inc.user.header')
<!-- begin app-container -->

<div class="app-container">
@include('inc.user.navbar')
@yield('content')
</div>
     <!-- plugins -->
     <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/canvasjs.min.js')}}"> </script>
    <!-- Modal Efects -->
    <script src="{{ asset('js/velocity.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/velocity.ui.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('js/custom.js')}}" type="text/javascript"></script>
       <!-- plugins -->
    <!-- Modal Efects -->


</div>
</div>
</body>


</html>