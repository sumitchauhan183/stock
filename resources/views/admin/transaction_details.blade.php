@extends('layouts.admin.dapp')
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{$page}}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">{{$title}}</h6>
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

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4" style="    padding: 10px 30px;">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Details</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" width="50%">
                                <tbody>
                                <tr>
                                    <th width="20%">PAYMENT ID</th>
                                    <td>{{$transactions->payment_id}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">USER ID</th>
                                    <td><a href="../../user/details/@php echo base64_encode($transactions['user_id']) @endphp">{{$transactions->user_id}}</a></td>
                                </tr>
                                <tr>
                                    <th width="20%">TRANSACTION ID</th>
                                    <td>{{$transactions->transaction_id}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">TRANSACTION STATUS</th>
                                    <td>{{$transactions->transaction_status}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">TRANSACTION AMOUNT</th>
                                    <td>{{$transactions->transaction_amount}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                <table>
                                        @php
                                         $data = json_decode($transactions->transaction_data);
                                        @endphp
                                        @foreach($data as $d=>$v)
                                            <tr>
                                                <th width="20%">{{$d}}</th>
                                                <td >{{$v}}</td>
                                            </tr>
                                        @endforeach
                                </table>
                                    </td>
                                </tr>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
