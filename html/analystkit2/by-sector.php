<?php include 'header.php'; ?>
<!-- begin app-container -->
<div class="app-container">
	<!-- begin sidebar-nav -->
	<aside class="app-navbar">
		<?php include 'sidebarnav.php'; ?>
	</aside>
	<!-- end sidebar-nav -->
	
	<!-- end app-navbar -->
	<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="images/flag_icon1.png"> US STOCK MARKET</h1>
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
								<form action="" class="mt-3 mt-sm-5">
									<div class="row">
										<div class="col-lg-5 col-md-6">
											<label class="CustomBox2"> Information Technology
												<input type="checkbox" checked="checked">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Consumer Staples
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Financials
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-5 col-md-6">
											<label class="CustomBox2"> Consumer Discretionary
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Real Estate
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Health Care
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-5 col-md-6">
											<label class="CustomBox2"> Communication Services
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Energy
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-3 col-md-6">
											<label class="CustomBox2"> Industrial
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										
										<div class="col-lg-5 col-md-6">
											<label class="CustomBox2"> Materials
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="col-lg-4 col-md-6">
											<label class="CustomBox2"> Utilities
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
									<div class="row">
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
</div>



<!-- end app-container -->
<?php include 'footer.php'; ?>
                   
