@extends('layouts.admin.dapp')
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">{{$admin->name}}</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
          <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
              <div class="card">
                  <div class="card-header p-3 pt-2">
                      <div class="text-start pt-1">
                          <h3 class="text-capitalize">Companies</h3>
                          <hr class="dark horizontal my-0">
                          <h4 class="mb-0" style="color: #bc6060;">{{$data['companies']}}</h4>
                      </div>
                  </div>
                  <div class="card-footer p-3">
                  </div>
              </div>
          </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="text-start pt-1">
                  <h3 class="text-capitalize">Total Active Users</h3>
                  <hr class="dark horizontal my-0">
                <h4 class="mb-0" style="color: #bc6060;">{{$data['users']}}</h4>
              </div>
            </div>

              <div class="card-footer p-3">
              </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="text-start pt-1">
                  <h3 class="text-capitalize">Verified Users</h3>
                  <hr class="dark horizontal my-0">
                <h4 class="mb-0" style="color: #bc6060;">{{$data['verified-users']}}</h4>
              </div>

            </div>
              <div class="card-footer p-3">
              </div>
          </div>
        </div>

      </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="text-start pt-1">
                            <h3 class="text-capitalize">Total Transaction Amount</h3>
                            <hr class="dark horizontal my-0">
                            <h4 class="mb-0" style="color: #bc6060;">{{$data['s_transactions']}}</h4>
                        </div>

                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

        </div>
    </div>
  </main>
@endsection
