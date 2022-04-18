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
				<div class="col-gl-12 mb-30" style="width:100%">
					<div class="FindValueSecount">Optimize Investment Mix</div>
					<div class="card card-statistics h-100 mb-0">							
						<div class="card-body">
							<div class="BySetorWrapper">
								<h3 class="GrayBg">Output Interface for "MARKET MIX"</h3>		
								<ul class="MarketList">
									<li><span>LARGE GROWTH</span> <span class="text-right">18%</span></li>
									<li><span>LARGE VALUE</span> <span class="text-right">3%</span></li>
									<li><span>MID VALUE</span> <span class="text-right">15%</span></li>
									<li><span>US REAL ESTATE</span> <span class="text-right">7%</span></li>
									<li><span>INTERNATIONAL</span> <span class="text-right">22%</span></li>
									<li><span>BOND LONG</span> <span class="text-right">32%</span></li>
									<li><span>Cash</span> <span class="text-right">3%</span></li>
								</ul>					
								<form action="optimize-market-output.php" class=" mt-3 mt-sm-5">
									<div class="row OptimizeBox">
										<div class="col-lg-12 AmountBox">
											<label> AMOUNT OF INVEST</label>
											<input type="input" >			
										</div>
										<div class="col-lg-12">
											<label class="CustomBox2"> SHOW CORRELATION
												<input type="checkbox" checked>
												<span class="checkmark"></span>
											</label>			
										</div>
									</div>
									<div class="row">
										<div class="col-12 mt-3 text-center ConfirmBtnBox">
											<button type="send" class="BlueBg">Go</button>
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
                   
