@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container" style="margin-top:100px;">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> <a href="{{route('user.tools.find_value_stock')}}" style="color:#016598;font-weight:600;">Find all Stocks ></a> By Asset Class </h1>
						</div>
					</div>
				</div>
			</div>	
            <div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">							
						<div class="card-body">
							<div class="BySetorWrapper">								
								<h3 class="GrayBg mt-0">By Asset Class</h3>						
													
								<form action="{{route('user.stock.assets.result')}}" method="POST" class="mt-3 mt-sm-5">
									<div class="row">
									    <div class="col-lg-10 offset-md-1 col-md-10">
									        <h4>Select</h4>	
									        <div class="row">
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Large Cap
												<input type="checkbox" value="large-cap" name="asset[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Mid Cap
												<input type="checkbox" value="mid-cap" name="asset[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Small Cap
												<input type="checkbox" value="small-cap" name="asset[]">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Micro Cap
											<input type="checkbox" value="micro-cap" name="asset[]">
												<span class="checkmark"></span>
											</label>
										</div>
										</div>
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