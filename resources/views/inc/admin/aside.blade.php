
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{route('admin.dashboard')}}" >
        <img src="{{ asset('resources/img/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">{{ config('app.name', 'Laravel') }}</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='dashboard'): echo 'active bg-gradient-primary'; endif; ?> " href="{{route('admin.dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='employees'): echo 'active bg-gradient-primary'; endif; ?>" href="{{route('admin.employees')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Employees</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='trainers'): echo 'active bg-gradient-primary'; endif; ?>" href="{{route('admin.trainers')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Trainers</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='hrs'): echo 'active bg-gradient-primary'; endif; ?>" href="{{route('admin.hrs')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">HR</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='data'): echo 'active bg-gradient-primary'; endif; ?>" href="{{route('admin.data')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">archive</i>
            </div>
            <span class="nav-link-text ms-1">Data</span>
          </a>
        </li>
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white <?php if($page=='profile'): echo 'active bg-gradient-primary'; endif; ?>" href="{{route('admin.profile')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>

        <li class="nav-item">
                        <a class="nav-link text-white " href="{{route('admin.logout')}}" >
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
                                    </a>
                                    
                        </li>  

      </ul>
    </div>
    
  </aside>