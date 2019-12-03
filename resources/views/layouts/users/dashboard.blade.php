@extends('layouts/header')
@section('body')
@include('components/users/navbar')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="p-3">
                <div class="row border shadow p-3">
                    <div class="col col-md-12">
                        <div class="rounded mx-auto d-block" style="width:80%;">
                            <img src="https://dl.dropboxusercontent.com/s/uldslccwxdp2mdb/default.jpg" alt="" class="img-fluid rounded-circle">
                        </div>
                    </div>
                    <div class="col col-md-12 my-auto">
                        <div class="text-center">
                            <span class="lead mx-auto">
                                <h3>{{$user->name}}</h3>
                            </span>
                        </div>
                        <div class="my-3"></div>
                        <div class="text-center">
                            <a href="/profile/{{$user->id}}/learnedwords">Learned {{$user->learnedWord->count()}} words</a>
                        </div>
                        <div class="text-center">
                            <a href="/profile/{{$user->id}}/learnedlessons">Learned {{$user->learnedLesson->count()}} lessons</a>
                        </div>
                    </div>
                </div>
            </div>
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

        <div class="col-md-8 p-3">
            @yield('content')
        </div>
    </div>
    @endsection