@extends('layouts.user.app')
@section('content')
<div class="SignUpWrapper">
                    @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif
		<div class="container">
			<div class="SignupHeader"><img src="{{ asset('images/logo2.png')}}" class="img-fluid logo-desktop" alt="logo" /></div>
			<form
                        role="form"
                        data-action="{{ route('user.stripe') }}"
                        method="post"
                        class="require-validation"
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form"> 
                        @csrf
				<h3>Payment Information</h3>
				<div class="row mt-4">
					<div class="col-md-7">
						
						<div class="form-group">
							<label>Card Owner:</label>
							<input type="text" class="form-control owner_name" data-name="Owner Name" />
                            <input type="text" name="user_id" data-name="User ID" value="{{$user_id}}" class="form-control hide" id="user_id"  />
						</div>
						<div class="form-group">
							<label>Card Number:</label>
							<input type="number" id="credit-card-type" data-name="Card Number" class="form-control card-number required" />
						</div>	
                        <div class="form-group" >
							<label>Card Type:</label>
                            <input type="text" id="authorizenet_cc_type" data-name="Card Type" readonly class="form-control required"/>
						</div>	
						<label>Card Expiry Date:</label>
						<div class="row">					
							<div class="col-md-6">
								<div class="form-group">
                                <label>Month</label>
                                <input
                                 class='form-control card-expiry-month required' data-name="Exp. Month" placeholder='MM' size='2'
                                 type='number'>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
                                <label>Year</label>
                                <input
                                 class='form-control card-expiry-year required' data-name="Exp. Year" placeholder='YYYY' size='4'
                                 type='number'>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Card Security Code (CCV2)</label>
									<input autocomplete='off'
                                 class='form-control card-cvc required' data-name="CVV" placeholder='ex. 311' size='4'
                                 type='number'>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Save This Card</label>
									<label class="">
										<input type="checkbox" checked="checked">
									</label>
								</div>
							</div>	
						</div>	
                        <div class='form-row row'>
                           <div class='col-md-12 error form-group hide'>
                              <div class='alert-danger alert'>Please Fill all required fields to proceed
                              </div>
                           </div>
                        </div>					
						<div class="row">
							<div class="col-12 mt-3 text-center">
								<button type="button" class="BtnBox paynow">Place Order</button>
							</div>
						</div>
					</div>	
					<div class="col-md-5">
						<div class="ValueBox">
							<strong>{{$item}}</strong>
							<b>$ {{$amount}}</b>
						</div>
						<div class="BtmTxt">
							<h3>Term $ Conditions</h3>
							<p>For trial, <a href="javascript:void()">Click here</a> to tour “use videos’’<br> 
							Can login to website 1 additional time for 50% off<br>
							Can use limited number of tools with signup<br> 
							Need to limit repeat cancellations and signups for discount. If “sign up now,” 50% off first year.</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
    @endsection