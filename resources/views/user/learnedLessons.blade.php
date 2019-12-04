@extends('layouts/users/dashboard')
@section('pageTitle','Learned Lessons | FELS')
@section('content')
<div class="border h-100 shadow">
    <nav class="navbar navbar-dark bg-primary">
        <div class="navbar-brand"><span class="lead"><strong>{{$user->name}}'s learned lessons</strong></span></div>
    </nav>
    <div>
        <div class="container">
            <div class="row">
                @foreach($activities as $activity)
                <div class="col-2 m-2">
                    <img src="{{asset('storage/'.$user->avatar_url)}}" alt="" class="img-fluid rounded-circle m-3">
                </div>
                <div class="col-8 m-2">
                    <div class="my-3">
                        {!!$activity['message']!!}<br>
                        {{$activity['updated_at']->diffForHumans()}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection