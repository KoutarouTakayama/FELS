@extends('layouts/users/dashboard')
@section('pageTitle','DashBoard | FELS')
@section('avatarUrl',$user->avatar_url)
@section('userName',$user->name)
@section('content')

<div class="container">
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr class="bg-primary text-light">
                    <th scope="col">
                        Word
                    </th>
                    <th scope="col">
                        Answer
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($learnedWords as $learnedWord)
                <tr>
                    <td>{{$learnedWord->word->word}}</td>
                    <td>{{$learnedWord->word->answer}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection