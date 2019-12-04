@extends('layouts/header')
@section('pageTitle','User List | FELS')
@section('body')
@include('components/users/navbar')
<div class="container mt-5">
    <div class="row">
        @foreach($users as $user)
        <div class="col-6 p-3">
            <a href="/profile/{{$user->id}}">
                <div class="row border p-4 mx-2 shadow">
                    <div class="col-8 align-center">
                        {{$user->name}}
                    </div>
                    <div class="col-4">
                        @if($user->id == Auth::user()->id)
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
            </a>
        </div>
        @endforeach
    </div>
    <div class="col-12">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="/userlist/1" tabindex="-1">TOP</a>
                </li>
                @if($pageNumber == 1)
                <li class="page-item active"><a class="page-link" href="/userlist/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 4}}">{{$pageNumber + 4}}</a></li>
                @elseif($pageNumber == 2)
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber-1}}">{{$pageNumber - 1}}</a></li>
                <li class="page-item active"><a class="page-link" href="/userlist/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
                @else
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber - 2}}">{{$pageNumber -2}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber - 1}}">{{$pageNumber - 1}}</a></li>
                <li class="page-item active"><a class="page-link" href="/userlist/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                @endif
                <li class="page-item"><a class="page-link" href="/userlist/{{$pageNumber + 1}}">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection