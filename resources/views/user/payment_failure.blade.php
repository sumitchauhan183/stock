@extends('layouts.user.app')
@section('content')
<div class="SignUpWrapper">
		<div class="container">
			<div class="SignupHeader"><img src="{{ asset('images/logo2.png')}}" class="img-fluid logo-desktop" alt="logo" /></div>
			<div class="SignUpForm" class="mt-3 mt-sm-5">
				<div class="RightSymble"><i class="fe fe-check text-primary font-30"></i></div>
				<h3>Registration Confirmed!</h3>
                <h3>Payment Failure!</h3>
				<h5>Thank You</h3>
				<div class="row">
					<div class="col-12 mt-3 text-center ConfirmBtnBox">
						<a href="{{route('user.login')}}" class="BtnBox">OK</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
    @endsection