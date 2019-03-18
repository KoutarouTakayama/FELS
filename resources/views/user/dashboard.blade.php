@extends('layouts/userDashboard')
@section('pageTitle','DashBoard | FELS')
@section('content')
<div class="border h-100 shadow">
    <nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item text-light">
                    <span class="lead"><strong>Activities</strong></span>
                </li>
            </ul>
        </div>
    </nav>
    <div class="" style="height:500px; overflow:scroll;">
        <div class="container">
            <div class="row">
                @foreach($activities as $activity)
                <div class="col-2 m-2">
                    <img src="{{asset('storage/'.$activity['avatar_url'])}}" alt="" class="img-fluid rounded-circle m-3">
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
</div>




@endsection 