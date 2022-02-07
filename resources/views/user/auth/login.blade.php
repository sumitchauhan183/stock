@extends('layouts.user.app')

@section('content')

<div class="SignUpWrapper">
		<div class="container">
			<form class="SignUpForm" action="payment.php" class="mt-3 mt-sm-5">
				<h3>Sign in</h3>
				<div class="row mt-4 justify-content-md-center">
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="text" id="email" class="form-control" />
						</div>
					</div>	
				</div>		
				<div class="row mt-4 justify-content-md-center">	
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input type="text" id="password" class="form-control" />
						</div>
					</div>	
				</div>		
				<div class="row mt-4 justify-content-md-center">
					
                    <div class="col-md-3">
						<div class="form-group">
							<label>Not yet register? <a href="{{ route('home') }}"><br/>Register Now</a></label>
						</div>
					</div>
					<div class="col-md-3 right">
						<div class="form-group">
							<label>forgot your password ? <a href="{{ route('user.reset_password_email') }}"><br/>Reset Now</a></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mt-3 text-center">
						<button type="button" id="login" class="BtnBox">Login</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
