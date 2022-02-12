@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> Tools</h1>
						</div>
					</div>
				</div>
			</div>	
				
			<div class="row">
				<div class="col-md-12 mb-30">
					<div class="card card-statistics h-100 mb-0">						
						<div class="card-body">
								<div class="row">
								@if($tools)
								  @if($tools['tool']==1)
								  <div class=" col-md-12 ">
									<div class="col-md-12">
									   <p><b>Name:</b>  Find Value Stocks</p>
									</div>
									<div class="col-md-12">
									   <p><b>Purchase On:</b>  {{date('Y-m-d', strtotime($tools['purchase_date']))}}</p>
									</div>
									<div class="col-md-12">
									   <p><b>Expire On:</b>  {{date('Y-m-d', strtotime($tools['expiry_date']))}}</p>
									</div>
								  </div>
								  @elseif($tools['tool']==2)
								  <div class=" col-md-12">
									<div class="col-md-12">
									   <p><b>Name:</b>  Optimize Investment Mix</p>
									</div>
									<div class="col-md-12">
									   <p><b>Purchase On:</b>  {{date('Y-m-d', strtotime($tools['purchase_date']))}}</p>
									</div>
									<div class="col-md-12">
									   <p><b>Expire On:</b>  {{date('Y-m-d', strtotime($tools['expiry_date']))}}</p>
									</div>
								  </div>
								  @elseif($tools['tool']==3)
								  <div class="col-md-6">
									<div class="col-md-12">
									   <p><b>Name:</b>  Find Value Stocks</p>
									</div>
									<div class="col-md-12">
									   <p><b>Purchase On:</b>  {{date('Y-m-d', strtotime($tools['purchase_date']))}}</p>
									</div>
									<div class="col-md-12">
									   <p><b>Expire On:</b>  {{date('Y-m-d', strtotime($tools['expiry_date']))}}</p>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="col-md-12">
									   <p><b>Name:</b>  Optimize Investment Mix</p>
									</div>
									<div class="col-md-12">
									   <p><b>Purchase On:</b>  {{date('Y-m-d', strtotime($tools['purchase_date']))}}</p>
									</div>
									<div class="col-md-12">
									   <p><b>Expire On:</b>  {{date('Y-m-d', strtotime($tools['expiry_date']))}}</p>
									</div>
								  </div>
								  @endif
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
</div>
@endsection