@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Add New HR </h6>
              </div>
            </div>
            <div class="card-body">
              @if(session('error'))
                                   <span class="invalid-feedback" style="display:block;" role="alert">
                                        <strong>{{ session('error') }}</strong>
                                    </span>
                                @endif
                <form role="form" class="text-center" method="POST" action="{{ route('admin.hr.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline m-b-0 w-100 my-3">
                    <h5>Details</h5>
                  </div>
                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>Name</lable>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{old('name')}}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>Mobile</lable>
                    <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{old('mobile')}}"  placeholder="Mobile" autofocus>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>Email</lable>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" placeholder="Email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>Username</lable>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{old('username')}}" placeholder="Username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>Password</lable>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  name="password" placeholder="Password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>10 Digit PAN Number</lable>
                    <input id="pan" type="text" class="form-control @error('pan') is-invalid @enderror" name="pan" value="{{old('pan')}}"  placeholder="PAN No." autofocus>
                    
                                @error('pan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                  <lable>12 Digit Aadhar Number</lable>
                    <input id="aadhar" type="text" class="form-control @error('aadhar') is-invalid @enderror" name="aadhar" value="{{old('aadhar')}}" placeholder="Aadhar No." autofocus>

                                @error('aadhar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>Profile Pic </lable>
                    <input id="profilefile" type="file" class="form-control @error('profilefile') is-invalid @enderror" name="profilefile" autofocus>

                                @error('profilefile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline m-b-0 w-100 my-3">
                    <h5>Documents</h5>
                  </div>
                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>PAN </lable>
                    <input id="panfile" type="file" class="form-control @error('panfile') is-invalid @enderror" name="panfile" autofocus>

                                @error('panfile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>Aadhar </lable>
                    <input id="aadharfile" type="file" class="form-control @error('aadharfile') is-invalid @enderror" name="aadharfile" autofocus>

                                @error('aadharfile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>


                  <div class="input-group input-group-outline m-b-0 w-100 my-3">
                    <h5>Account Details</h5>
                  </div>
                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>Account Holder Name</lable>
                    <input id="accountname" type="text" class="form-control @error('accountname') is-invalid @enderror" name="accountname" value="{{old('accountname')}}" autofocus>

                                @error('accountname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>Bank Name</lable>
                    <input id="bankname" type="text" class="form-control @error('bankname') is-invalid @enderror" name="bankname"  value="{{old('bankname')}}" autofocus>

                                @error('bankname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>Account Number</lable>
                    <input id="accountnumber" type="text" class="form-control @error('accountnumber') is-invalid @enderror" name="accountnumber" value="{{old('accountnumber')}}" autofocus>

                                @error('accountnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>

                  <div class="input-group input-group-outline dib-inpt w-50 my-3">
                    <lable>IFSC Code</lable>
                    <input id="ifsc" type="text" class="form-control @error('ifsc') is-invalid @enderror" name="ifsc" value="{{old('ifsc')}}" autofocus>

                                @error('ifsc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  
                  
                  
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-40 my-4 mb-2">Submit</button>
                  </div>
                </form>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection