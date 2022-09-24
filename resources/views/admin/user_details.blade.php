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
                                    <th width="20%">USER ID</th>
                                    <td>{{$users->user_id}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">USERNAME</th>
                                    <td>{{$users->username}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">NAME</th>
                                    <td>{{$users->first_name}} {{$users->last_name}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">EMAIL</th>
                                    <td>{{$users->email}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">CITY</th>
                                    <td>{{$users->city}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">STATE</th>
                                    <td>{{$users->state}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">COUNTRY</th>
                                    <td>{{$users->country}}</td>
                                </tr>
                                <tr>
                                    <th width="20%">PINCODE</th>
                                    <td>{{$users->zipcode}}</td>
                                </tr>

                                <tr>
                                    <th width="20%">EMAIL VERIFICATION</th>
                                    <td>{{$users->email_verified}}</td>
                                </tr>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4" style="    padding: 10px 30px;">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Tools</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tooldatatable">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tool ID</th>
                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Purchased Tools</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Purchase Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expiry Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($tools) > 0)
                                    @foreach($tools as $t)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$t['tool_id']}}</p>
                                            </td>
                                            <td>
                                                @if($t['tool']==1)
                                                    <p class="text-xs text-start font-weight-bold mb-0">1) Find Value Stocks</p>
                                                @elseif($t['tool']==2)
                                                    <p class="text-xs text-start font-weight-bold mb-0">1) Optimize Investment Mix</p>
                                                @else
                                                    <p class="text-xs text-start font-weight-bold mb-0">1) Find Value Stocks</p>
                                                    <p class="text-xs text-start font-weight-bold mb-0">2) Optimize Investment Mix</p>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-xs  font-weight-bold mb-0">{{$t['purchase_date']}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">{{$t['expiry_date']}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4" style="    padding: 10px 30px;">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Payments</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="paymentdatatable">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PAYMENT ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TRASSACTION ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">AMOUNT</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($transactions) > 0)
                                    @foreach($transactions as $t)
                                        <tr>
                                            <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{$t['payment_id']}}</p>
                                            </td>
                                            <td>
                                                <a href="../../transaction/details/@php echo base64_encode($t['transaction_id']) @endphp"><p class="text-xs text-center font-weight-bold mb-0">{{$t['transaction_id']}}</p></a>
                                            </td>
                                            <td>
                                                <p class="text-xs  font-weight-bold mb-0">{{$t['transaction_amount']}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">{{$t['transaction_status']}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
