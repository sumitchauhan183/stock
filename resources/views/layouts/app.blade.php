<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to AnalystKit</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendors.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme-style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
    <title>{{config('app.name')}}</title>

    <style>
        
.tool-label{
    height: 40px !important;
    line-height: 45px !important;
    padding-left: 20px !important;
}

.tool-checkbox{
    width: 20px !important;
    float: left !important;
}

.HeaderWrapper {
    padding: 10px 0 !important;
}

.logo-desktop{
    width:300px;
}

input:focus{
  outline: none  !important;
  box-shadow: none  !important;
}
    </style>
</head>
<body>
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="{{ asset('images/loader.svg') }}" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->
            <!-- begin app-header -->
            
    @include('inc.navbar')
    @yield('content')

     <!-- plugins -->
     <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <!-- Modal Efects -->
    <script src="{{ asset('js/velocity.min.js') }}"></script>
    <script src="{{ asset('js/velocity.ui.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    
    {{-- Success Alert --}}
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Error Alert --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{session('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <script src="{{ asset('js/custom/home.js') }}"></script>
    <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){

        home.init();    
	    setTimeout(function() {
	        $(".alert").alert('close');
	    }, 3000);
    	});
    </script>
    
</body>
</html>