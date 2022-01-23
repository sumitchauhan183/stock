@extends('layouts.user.app')
@section('content')

<div class="SignUpWrapper">
		<div class="container">
			<div class="SignupHeader"><img src="{{ asset('images/logo2.png')}}" class="img-fluid logo-desktop" alt="logo" /></div>
			<form class="SignUpForm" action="payment.php" class="mt-3 mt-sm-5">
				<h3>Sign Up</h3>
				<div class="row mt-4">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" />
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" style="margin-bottom:0;">
							<label>Country</label>
							<select>
								<option>USA</option>
								<option>UAE</option>
							</select>
						</div>
					</div>					
					<div class="col-md-12">
						<div class="form-group">
							<label>City</label>
							<input type="text" class="form-control" />
						</div>
					</div>			
					<div class="col-md-12">
						<div class="form-group">
							<label>State/ Province</label>
							<input type="text" class="form-control" />
						</div>
					</div>			
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" />
						</div>
					</div>			
					<div class="col-md-6">
						<div class="form-group">
							<label>User ID</label>
							<input type="text" class="form-control" />
						</div>
					</div>			
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input type="text" class="form-control" />
						</div>
					</div>			
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="text" class="form-control" />
						</div>
					</div>
                    <div class="col-md-6">
						<div class="form-group">
							<label>already have an account? <a href="{{ route('user.login') }}">Login Now</a></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mt-3 text-center">
						<button type="send" class="BtnBox">Next</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection