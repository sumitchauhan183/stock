<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

    <div class="collapse navbar-collapse  w-auto"  id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white @if($url=='dashboard') active bg-gradient-primary @endif" href="{{route('admin.dashboard')}}">
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if($url=='users') active bg-gradient-primary @endif " href="{{route('admin.users')}}">
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white @if($url=='tools') active bg-gradient-primary @endif " href="{{route('admin.tools')}}">
            <span class="nav-link-text ms-1">Tools</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white @if($url=='payments') active bg-gradient-primary @endif " href="{{route('admin.payments')}}">
            <span class="nav-link-text ms-1">Payments</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('admin.logout')}}">

            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
