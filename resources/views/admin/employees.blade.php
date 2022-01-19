@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Employees <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" data-class="bg-gradient-dark" ><a class="text-white" href="{{route('admin.employee.add')}}">+ ADD</a></button></h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Code</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                      @if(count($employees) > 0)
                      @foreach($employees as $emp)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{env('APP_URL').'/'.$emp['profile_image']}}" class="avatar avatar-sm me-3 border-radius-lg" alt="{{$emp['username']}}">
                          </div>
                          <p class="text-xs font-weight-bold mb-0">{{$emp['employee_code']}}</p>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$emp['username']}}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-secondary text-xs font-weight-bold">{{$emp['email']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="badge badge-sm bg-gradient-success">{{$emp['status']}}</span>
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