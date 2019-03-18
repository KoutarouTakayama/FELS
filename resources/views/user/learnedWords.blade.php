@extends('layouts/userDashboard')
@section('pageTitle','DashBoard | FELS')
@section('avatarUrl',$user->avatar_url)
@section('userName',$user->name)
@section('content')

<div class="container">
    <div class="row">
        <div class="col-6 bg-primary text-light mb-2">
            Word
        </div>
        <div class="col-6 bg-primary text-light mb-2">
            Answer
        </div>
    </div>
    <div class="row" style="max-height:500px; overflow:scroll;">
        @foreach($learnedWords as $learnedWord)
        <div class="col-6 mb-1 mt-1">
            {{$learnedWord->word->word}}
        </div>
        <div class="col-6  mb-1 mt-1">
            {{$learnedWord->word->answer}}
        </div>
        @endforeach
    </div>
</div>
@endsection 