@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Add New Data 
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" data-class="bg-gradient-dark" ><a class="text-white" href="{{ asset('resources/file/data.csv')}}">Demo file</a></button>
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="uploadxl" data-class="bg-gradient-dark" >+ Upload File</button> 
                  <input type="file" id="imgupload" name="imgupload" style="display:none"/>
                </h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="card-body">
              @if(session('error'))
                                   <span class="invalid-feedback" style="display:block;" role="alert">
                                        <strong>{{ session('error') }}</strong>
                                    </span>
                                @endif
                <form role="form" class="text-center" method="POST" action="{{ route('admin.data.add') }}" enctype="multipart/form-data">
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
                  <lable>Address</lable>
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address')}}" placeholder="Address" autofocus>

                                @error('address')
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
<script src="{{ asset('resources/js/admin/customer/customer.js') }}"></script>
@endsection