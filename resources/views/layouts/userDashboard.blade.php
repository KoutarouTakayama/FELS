@extends('layouts/htmlAndHeader')
@section('body')
<div class="container mt-lg-4">
    <div class="row">
        <div class="col-lg-3 mt-lg-5">
            <div class="border shadow">
                <div class="m-lg-3">
                    <div class="w-50 h-50 mt-lg-5 mb-lg-4 mx-auto rounded-circle border">
                        <img src="{{asset('storage/'.$user->avatar_url)}}" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="text-lg-center mb-lg-4">
                        <span class="lead mx-auto"><strong>{{$user->name}}</strong></span>
                    </div>
                    <div class="mb-lg-2">
                        <a href="/profile/{{$user->id}}/learnedwords">Learned {{$user->learnedWord->count()}} words</a>
                    </div>
                    <div class="mb-lg-2">
                        <a href="/profile/{{$user->id}}/learnedlessons">Learned {{$user->learnedLesson->count()}} lessons</a>
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
        <div class="col-lg-1"></div>
        <div class="col-lg-8">
            @yield('content')
        </div>
    </div>
</div>
@endsection 