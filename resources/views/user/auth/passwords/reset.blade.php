@extends('layouts.user.app')

@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
        }
    </style>
    <div class="SignUpWrapper">
        <div class="container">

            <form class="SignUpForm" action="{{route('user.confirm_password')}}" class="mt-3 mt-sm-5">
                <h3>Reset your Password</h3>
                <div class="row mt-4  justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter your one-time password</label>
                            <input type="number" id="otp" class="form-control" />
                            <input type="hidden" id="user_id"  class="form-control" value="{{$user_id}}" />
                        </div>
                    </div>
                </div>
                <div class="row  justify-content-md-center">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" id="password" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row  justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="text" id="confirm" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row  justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Send one time password ? <a href="javascript:void(0)" id="resend">Send Now</a></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 text-center">
                        <button type="button" id="reset" class="BtnBox mt-0">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
