@extends('layouts.admin.app')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Data 
                <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="assign-data" data-class="bg-gradient-dark" style="display:none"><span class="text-white" href="">assign</span></button>
                <select class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="tr-drop" data-class="bg-gradient-dark" style="display:none">
                  @if(count($trainer) > 0)
                  <option value='0'>select trainer</option>
                      @foreach($trainer as $t)
                          <option value="{{$t['trainer_id']}}">{{$t['name']}}</option>
                      @endforeach
                  @else
                         <span>*no active trainers</span>    
                  @endif
                 

                  </select> 
                  <select class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="em-drop" data-class="bg-gradient-dark" style="display:none">
                  @if(count($employee) > 0)
                  <option value='0'>select employee</option>
                      @foreach($employee as $e)
                          <option value="{{$e['employee_id']}}">{{$t['name']}}</option>
                      @endforeach
                  @else
                         <span>*no active trainers</span>    
                  @endif
                 

                  </select> 
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="trainer" data-class="bg-gradient-dark" ><span class="text-white" href="">+ Trainer </span></button>
                  <button class="btn bg-gradient-dark px-3 mb-0 rf-btn active" id="employee" data-class="bg-gradient-dark" ><span class="text-white" href="">+ Employee</span></button>
                  
                </h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                  <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      <input type="checkbox" id="customers-select-all" name="customer-select-all">
                  </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone Number</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                    </tr>
                  </thead>
                  <tbody>
                      @if(count($data) > 0)
                      @foreach($data as $d)
                    <tr>
                      <td>
                        <input type="checkbox"  name="customer-select" value="{{$d['customer_id']}}">
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$d['name']}}</p>
                      </td>
                      <td class="align-middle text-sm">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['mobile']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['email']}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$d['address']}}</span>
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