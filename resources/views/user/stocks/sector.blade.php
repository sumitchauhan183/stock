@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> Find all Stocks > By Sector</h1>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="FindValueSecount">Find Value Stocks</div>
					<div class="card card-statistics h-100 mb-0">							
						<div class="card-body">
							<div class="BySetorWrapper">								
								<h3 class="GrayBg">By Sector</h3>						
								<h4>Select</h4>						
								<form action="{{route('user.stock.sector.result')}}" method="POST" class="mt-3 mt-sm-5">
									<div class="row">
									    <div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Financial
												<input type="checkbox" value="financial" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Services
												<input type="checkbox" value="services" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div> 
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Technology
												<input type="checkbox" value="technology" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Healthcare
												<input type="checkbox" value="healthcare" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Basic Materials
												<input type="checkbox" value="basic-materials" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Consumer Goods
											<input type="checkbox" value="consumer-goods" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Industrial Goods
												<input type="checkbox" value="industrial-goods" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Utilities
												<input type="checkbox" value="utilities" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Conglomerates
												<input type="checkbox" value="conglomerates" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										
									</div>
									<div class="row">
										<div class="col-12 mt-3 text-center">
											<button type="submit" class="BlueBg" id="search">Search <i class="zmdi zmdi-long-arrow-right zmd-fw"></i></button>
										</div>
									</div>
								</form>								
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
</div>
@endsection