@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Data 
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" data-class="bg-gradient-dark" ><a class="text-white" href="{{route('admin.data.assign')}}">+ ASSIGN </a></button>
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" data-class="bg-gradient-dark" ><a class="text-white" href="{{route('admin.data.add')}}">+ ADD</a></button></h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                  <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone Number</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                      @if(count($data) > 0)
                      @foreach($data as $d)
                    <tr>
                      
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$d['name']}}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['mobile']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['email']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['address']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="badge badge-sm bg-gradient-success">{{$d['status']}}</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection