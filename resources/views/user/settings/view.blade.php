@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> Settings</h1>
						</div>
					</div>
				</div>
			</div>	
					
			<div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">						
						<div class="card-body">
						<div class="row">
								  <div class=" col-md-12 ">
									<div class="col-md-12">
									   <p style="cursor:pointer;" id="change_password"><b>Change Password</b></p>
									   <input type="hidden" id="user_id" value="{{$user['user_id']}}" >
									</div>
									<div class="col-md-12">
									   <p><b>Email verification</b>
									@if($user['email_verified']=='YES')
									  <span style="color: aqua;
													background: white;
													border: 1px solid black;
													padding: 5px;
													border-radius: 5px;
													margin-left: 50px;
													font-weight: bolder;">verified</span>
									@else
									  <span style="color: red;
													padding: 5px;
													margin-left: 50px;
													font-weight: bolder;" id="send_mail_verification">send verification mail</span>
									@endif
									</p>
									</div>
								  </div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
@endsection