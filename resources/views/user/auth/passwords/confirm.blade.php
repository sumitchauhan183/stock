@extends('layouts.user.app')
@section('content')
<div class="SignUpWrapper">
		<div class="container">
			<div class="SignUpForm" class="mt-3 mt-sm-5">
				<h3>Password Successfuly Reset!</h3>
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