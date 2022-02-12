@extends('layouts.user.dapp')
@section('content')
<div class="app-main" id="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 m-b-30">
					<div class="d-block d-lg-flex flex-nowrap align-items-center">
						<div class="page-title mr-4 pr-4">
							<h1><img src="{{ asset('images/flag_icon1.png')}}"> Profile</h1>
						</div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xxl-12 mb-30">
					<div class="card card-statistics h-100 mb-0">						
						<div class="card-body">
							<div class="CotentWrapper">
							<div class="row mt-4 justify-content-md-left">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label>Password</label>
										<input type="password" id="password"  class="form-control" />
										<input type="hidden" id="user_id" value="{{$user['user_id']}}" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" id="confirm"  class="form-control" />
									</div>
								</div>
								<div class="row mt-4 justify-content-md-center">	
									<div class="col-12 mt-3 text-center">
										<button type="button" id="change_password" class="BtnBox">Change Password</button>
									</div>
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