@extends('layouts/users/header')
@section('body')
<div class="container sm mt-lg-4 mt-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="border shadow">
                <div class="m-3 row-sm">
                    <div class="w-50 h-50 mt-3 mb-lg-4 mx-auto-lg col-3 rounded-circle border">
                        <img src="{{asset('storage/'.$user->avatar_url)}}" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div>
                        <div class="text-lg-center mb-lg-4 col-9">
                            <span class="lead mx-auto"><strong>{{$user->name}}</strong></span>
                        </div>
                        <div class="mb-lg-2">
                            <a href="/profile/{{$user->id}}/learnedwords">Learned {{$user->learnedWord->count()}} words</a>
                        </div>
                        <div class="mb-lg-2">
                            <a href="/profile/{{$user->id}}/learnedlessons">Learned {{$user->learnedLesson->count()}} lessons</a>
                        </div>
                    </div>
                    <div>
                        @if($user->id == auth()->user()->id)
                        @else
                        @if(Auth::user()->checkRelationship($user->id))
                        <form action="/relationship/unfollow" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger form-control" type="submit" name="id" value="{{$user->id}}">Unfollow</button>
                        </form>
                        @else
                        <form action="/relationship/follow" method="POST">
                            @csrf
                            <button class="btn btn-primary form-control" type="submit" name="id" value="{{$user->id}}">Follow</button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col p-5">
            @yield('content')
        </div>
    </div>
</div>
@endsection