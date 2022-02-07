@extends('layouts.user.app')

@section('content')

<div class="SignUpWrapper">
		<div class="container">
			<form class="SignUpForm" action="{{route('user.reset_password')}}" class="mt-3 mt-sm-5">
				<h3>Confirm Your Email</h3>
				<div class="row mt-4 justify-content-md-center">
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="text" id="email" class="form-control" />
						</div>
					</div>	
				</div>
				<div class="row">
					<div class="col-12 mt-3 text-center">
						<button type="button" id="confirm_email" class="BtnBox">Next</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
