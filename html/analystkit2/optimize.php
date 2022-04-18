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
				<div class="col-gl-12 mb-30">
					<div class="FindValueSecount">Optimize Investment Mix</div>
					<div class="card card-statistics h-100 mb-0">							
						<div class="card-body">
							<div class="BySetorWrapper">										
								<h4>Select</h4>						
								<form action="" class=" mt-3 mt-sm-5">
									<div class="row OptimizeBox">
										<div class="col-lg-12">
											<label class="CustomBox2"> MARKET MIX
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>			
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> YOUR PORTFOLIO
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>			
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> REMOVE CASH
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>				
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> ADD SHORT SELL
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>	
										</div>
									</div>
									<h4>Select</h4>	
									
									<div class="row RiskReturnWrapper">
										<div class="col-lg-4">
											<div class="RiskReturn">
												<h4>Risk</h4>												
												<label class="CustomRadioButton Yellow">
													<input type="radio" name="risk">
													<span class="checkmark"></span>
													<small>Lowest</small>
												</label>								
												<label class="CustomRadioButton Gree">
													<input type="radio" name="risk">
													<span class="checkmark"></span>
												</label>								
												<label class="CustomRadioButton Blue">
													<input type="radio" name="risk">
													<span class="checkmark"></span>
												</label>							
												<label class="CustomRadioButton Purple">
													<input type="radio" name="risk">
													<span class="checkmark"></span>
													<small>Highest</small>
												</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="RiskReturn">
												<h4>Return</h4>												
												<label class="CustomRadioButton Yellow">
													<input type="radio" name="return">
													<span class="checkmark"></span>
													<small>Lowest</small>
												</label>								
												<label class="CustomRadioButton Gree">
													<input type="radio" name="return">
													<span class="checkmark"></span>
												</label>								
												<label class="CustomRadioButton Blue">
													<input type="radio" name="return">
													<span class="checkmark"></span>
												</label>							
												<label class="CustomRadioButton Purple">
													<input type="radio" name="return">
													<span class="checkmark"></span>
													<small>Highest</small>
												</label>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="RiskReturn">
												<h4>Best Return For Risk</h4>												
												<label class="CustomRadioButton Yellow">
													<input type="radio" name="best">
													<span class="checkmark"></span>
													<small>Lowest</small>
												</label>								
												<label class="CustomRadioButton Gree">
													<input type="radio" name="best">
													<span class="checkmark"></span>
												</label>								
												<label class="CustomRadioButton Blue">
													<input type="radio" name="best">
													<span class="checkmark"></span>
												</label>							
												<label class="CustomRadioButton Purple">
													<input type="radio" name="best">
													<span class="checkmark"></span>
													<small>Highest</small>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 mt-3 text-center">
											<button type="send" class="BlueBg">View Output </button>
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
                   
