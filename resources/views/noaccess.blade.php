@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>

                <div class="card-body">
                    You are not an Authorised User.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection