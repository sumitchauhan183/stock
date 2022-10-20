@extends('layouts.user.dapp')
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_length select {
            width: 50px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
        }
    </style>
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> <a href="{{route('user.tools.find_value_stock')}}" style="color:#016598;font-weight:600;">Find all Stocks ></a> All</h1>
						</div>
					</div>
				</div>
			</div>

            <div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">

                        <div class="ListWrapper">
                            <table id="sector-list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>TypeN</th>
                                    <th>Type</th>
                                    <th>Ticker</th>
                                    <th>Name</th>
                                    <th>Stock Exchange</th>
                                    <th>Sector</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ( $companies as $c)
                                    <tr>
                                        <td></td>
                                        <td>{{$c->type}}</td>
                                        <td>
                                        @switch($c->type)
                                            @case(1)
                                                AAA
                                                @break
                                            @case(2)
                                                AA
                                                @break
                                            @case(3)
                                                A
                                                @break
                                            @case(4)
                                                BBB
                                                @break
                                            @case(5)
                                                BB
                                                @break
                                            @case(6)
                                                B
                                                @break
                                            @case(7)
                                                ---
                                                @break    
                                        @endswitch
                                        </td>
                                        <td>{{$c->ticker}}</td>
                                        <td>{{$c->legal_name}}</td>
                                        <td>{{$c->stock_exchange}}</td>
                                        <td>{{$c->sector}}</td>
                                        <td><a href="{{env('APP_URL').'user/stocks/companies/'.$c->id}}">view</a></td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>


		</div>
</div>
@endsection
