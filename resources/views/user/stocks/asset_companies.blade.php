@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> Find all Stocks > By Asset Class > Companies</h1>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">							
						
						<div class="ListWrapper">	
                            
                            <div class="row ListHead">
								<a href="javascript:void(0)">
									<div class="TicketBox">Ticker</div>
									<div class="NameBox">Name</div>
								</a>
							</div>	
                            @foreach ( $companies as $c)
                            <div class="row ListBox">
								<a href="{{env('APP_URL').'user/stocks/companies/'.$c->ticker}}">
									<div class="ListLeftBox">{{$c->ticker}}</div>
									<div class="ListRightBox">{{$c->name}}</div>
								</a>
							</div>
                            @endforeach		
							
						</div>
					</div>
				</div>
			</div>		
		</div>
</div>
@endsection