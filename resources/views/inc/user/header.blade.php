<!-- begin app-header -->
<header class="app-header top-bar">
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-header d-flex align-items-center">
                        <a class="mobile-toggle"><i class="ti ti-align-right"></i><i class="ti ti-close"></i></a>
                        <a class="navbar-brand" href="index.php">
                            <img src="{{ asset('images/logo2.png')}}" class="img-fluid logo-desktop" alt="logo" />
                            <img src="{{ asset('images/logo-icon.png')}}" class="img-fluid logo-mobile" alt="logo" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-align-left"></i>
                        <i class="ti ti-close"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            
                            <ul class="navbar-nav nav-right ml-auto">                               
                                <li>
                                    <a href="{{route('user.logout')}}"> 
                                        <i class="zmdi zmdi-power pr-2"></i>
                                    </a>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </nav>
</header>