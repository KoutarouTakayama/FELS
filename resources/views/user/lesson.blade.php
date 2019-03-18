@extends('layouts/htmlAndHeader')
@section('pageTitle',$category->title . ' | FELS')
@section('body')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="border m-3">
                {{$category->title}}
            </div>
        </div>
        <div class="col-6">
            <div class="border m-3">
                {{$learnedWords->count() + 1}} of {{$category->word->count()}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 border">
            <div class="border m-3">
                {{$word->word}}
            </div>
        </div>
        <div class="col-6 border">
            @foreach($choices as $choice)
            <div class="border m-3">
                <form action="/answer/{{$word->id}}" method="POST">
                    @csrf
                    <button class="btn btn-primary form-control" name="choice" value="{{$choice}}">{{$choice}}</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 