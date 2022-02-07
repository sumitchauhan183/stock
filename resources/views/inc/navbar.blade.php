
<header class="HeaderWrapper">
		<div class="container">
			<div  class="row">
		<div class="col-md-6" >
			<img src="{{ asset('images/logo.png') }}" class="img-fluid logo-desktop" alt="logo" />
		</div>
		@if($url!='login' && $url != 'payment')
		<div class="col-md-6" style="text-align: right;">
						<div class="form-group">
							<label>already have an account? <a href="{{ route('user.login') }}">Login Now</a></label>
						</div>
					</div>
					<div>
					</div>
		@endif			
	</header>