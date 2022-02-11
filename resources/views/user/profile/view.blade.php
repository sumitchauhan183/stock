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
							<div class="col-md-6">
								<div class="form-group">
										<label>User Name</label>
										<input type="text" id="username" value="{{$user['username']}}" readonly class="form-control" />
										<input type="hidden" id="userid" value="{{$user['user_id']}}" readonly class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email</label>
										<input type="text" id="email" value="{{$user['email']}}" readonly class="form-control" />
									</div>
								</div>		
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name</label>
										<input type="text" id="first_name" value="{{$user['first_name']}}" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" id="last_name" value="{{$user['last_name']}}" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Country</label>
										<select name="country" id="country" class="form-control">
											<option <?php if($user['country']=='USA'): echo 'selected';endif; ?> value="USA">USA</option>
											<option <?php if($user['country']=='UAE'): echo 'selected';endif; ?> value="UAE">UAE</option>
										</select>
									</div>
								
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>City</label>
										<input type="text" id="city" value="{{$user['city']}}" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>State</label>
										<input type="text" id="state" value="{{$user['state']}}" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Zipcode</label>
										<input type="text" id="zipcode" value="{{$user['zipcode']}}" class="form-control" />
									</div>
								</div>
								</div>		
								<div class="row mt-4 justify-content-md-center">	
									<div class="col-12 mt-3 text-center">
										<button type="button" id="save_profile" class="BtnBox">Save</button>
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