@extends('layouts.app')

@section('content')

<div class="BodyMiddleWrapper">
		<div class="container">
			<form class="BuildForm" action="" class="mt-3 mt-sm-5">
				<h3>Build Your Toolbox</h3>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<input type="checkbox" name="tool-one" class="form-control tool-checkbox" id="tool-one"  />
                            <label class="tool-label">Find Value Stocks</label>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<input type="checkbox" name="tool-two" class="form-control tool-checkbox" id="tool-two" />
                            <label class="tool-label">Optimize Investment Mix</label>
						</div>
					</div>
					<div class="col-12 mt-3 text-center">
						<button type="button" id="register" class="BtnBox">Go</button>
					</div>
				</div>
			</form>
		</div>
	</div>
    <div class="TirthLogo">
		<div class="container">
			<figur><img src="{{ asset('images/tlogo1.png')}}" alr="logo"></figur>
			<figur><img src="{{ asset('images/tlogo2.png')}}" alr="logo"></figur>
			<figur><img src="{{ asset('images/tlogo3.png')}}" alr="logo"></figur>
		</div>
	</div>
    <div class="BodyBottom">
		<div class="container">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
			<div class="BtnWrapp">
				<a href="javascrip:void(0)">Privacy Policy</a>
				<a href="javascrip:void(0)">Terms Of Use</a>
				<a href="javascrip:void(0)">Contact Us</a>
			</div>
		</div>
	</div>
@endsection
