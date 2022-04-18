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
								<h3 class="GrayBg">By Asset Class</h3>						
								<h4>Select</h4>						
								<form action="" class="AssetClassForm mt-3 mt-sm-5">
									<div class="row">
										<div class="col-lg-12">
											<label for="chkPassport" class="CustomBox2"> SMALL CAP
												<input id="chkPassport" type="checkbox" checked="checked">
												<span class="checkmark"></span>
											</label>
											<div id="ShowRdo" class="Radiowrapp">											
												<label id="ShowButton" class="CustomRadioButton"> US
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>								
												<label id="ShowButton" class="CustomRadioButton"> International
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>								
												<label id="ShowButton" class="CustomRadioButton"> Emerging Markets
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="col-lg-12">
											<label for="chkPassport2" class="CustomBox2"> MID CAP
												<input id="chkPassport2" type="checkbox">
												<span class="checkmark"></span>
											</label>											
											<div id="ShowRdo2" class="Radiowrapp" style="display:none">											
												<label id="ShowButton" class="CustomRadioButton"> US
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>								
												<label id="ShowButton" class="CustomRadioButton"> International
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>								
												<label id="ShowButton" class="CustomRadioButton"> Emerging Markets
													<input type="radio" name="stocks">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> LARGE CAP
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>			
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> REAL ESTATE
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>			
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> COMMODITIES
												<input type="checkbox">
												<span class="checkmark"></span>
											</label>				
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> NATURAL RESOURCES
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
                   
