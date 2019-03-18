@extends('layouts/htmlAndHeader')
@section('pageTitle','User List | FELS')
@section('body')
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
</div>
@endsection
@section('pagenation')
<div class="container mt-4">
    @include('layouts/pagenation')
</div>
@endsection 