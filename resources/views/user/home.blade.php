@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> US STOCK MARKET</h1>
						</div>
					</div>
				</div>
			</div>	
							
			<div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">						
						<div class="card-body">
							<div class="CotentWrapper">
								<div class="FindValue"><span>Find Value Stocks</span></div>								
								<form action="by-sector.php" class="mt-3 mt-sm-5">
									<div class="StocksWrapper">
										<h3>Categories</h3>
										<div class="LinkBox">
											<label class="CustomRadioButton"> All Stocks
												<input type="radio" name="stocks">
												<span class="checkmark"></span>
											</label>
											<label id="ShowButton" class="CustomRadioButton"> By Asset Class
												<input type="radio" name="stocks">
												<span class="checkmark"></span>
											</label>
											<label id="ShowButton1" class="CustomRadioButton"> Asset Class
												<input type="radio" name="stocks">
												<span class="checkmark"></span>
											</label>
										</div>
									</div>									
									<div id="ShowBtn" class="row">
										<div class="col-12 mt-3 text-center">
											<button type="send" class="BlueBg">Search <i class="zmdi zmdi-long-arrow-right zmd-fw"></i></button>
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