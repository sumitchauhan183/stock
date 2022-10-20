@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container" style="margin-top:100px;">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> <a href="{{route('user.tools.find_value_stock')}}" style="color:#016598;font-weight:600;">Find all Stocks ></a> By Sector</h1>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-12">
					<div class="card card-statistics h-100 mb-0">							
						<div class="card-body">
							<div class="BySetorWrapper">								
								<h3 class="GrayBg mt-0">By Sector</h3>						
								<h4>Select</h4>						
								<form action="{{route('user.stock.sector.result')}}" method="POST" class="mt-3 mt-sm-5">
									<div class="row">
									    <div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Financial
												<input type="checkbox" value="Financial" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Services
												<input type="checkbox" value="Services" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div> 
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Technology
												<input type="checkbox" value="Technology" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Healthcare
												<input type="checkbox" value="Healthcare" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Basic Materials
												<input type="checkbox" value="Basic Materials" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Consumer Goods
											<input type="checkbox" value="Consumer Goods" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Industrial Goods
												<input type="checkbox" value="Industrial Goods" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Utilities
												<input type="checkbox" value="Utilities" name="sector[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Conglomerates
												<input type="checkbox" value="Conglomerates" name="sector[]">
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