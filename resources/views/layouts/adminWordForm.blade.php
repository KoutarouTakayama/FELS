@extends('layouts/adminDashboard')
@section('body')
<div class="container mt-4">

    <form action="/admin/add/word/{{$categoryId}}/store" method="POST">
        @csrf
        <div class="row">
            <div class="col-5 p-4">
                <div>
                    <label for="word">Word</label>
                    <input class="form-control {{$errors->has('word')?'is-invalid':''}}" type="text" name="word" maxlength="50" value="{{old('word')}}" required>
                    @if($errors->has('word'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('word') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-6 p-4">
                <div class="container">
                <label for="choice">Choice</label>
                    <div class="form-inline mb-4">
                        <input class="form-control col-10 {{$errors->has('choice1')?'is-invalid':''}}" type="text" name="choice1" maxlength="50" value="{{old('choice1')}}" required>
                        <input class="radio ml-3" type="radio" name="answer" value="choice1" {{old('answer')=='choice1'?'checked':''}} required>
                        @if($errors->has('choice1'))
                        <span class="invalid-feedback" role="alert" style="height:30px;">
                            <strong>{{ $errors->first('choice1') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-inline mb-4">
                        <input class="form-control col-10 {{$errors->has('choice2')?'is-invalid':''}}" type="text" name="choice2" maxlength="50" value="{{old('choice2')}}" required>
                        <input class="radio ml-3" type="radio" name="answer" value="choice2" {{old('answer')=='choice2'?'checked':''}} required>
                        @if($errors->has('choice2'))
                        <span class="invalid-feedback" role="alert" style="height:30px;">
                            <strong>{{ $errors->first('choice2') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-inline mb-4">
                        <input class="form-control col-10 {{$errors->has('choice3')?'is-invalid':''}}" type="text" name="choice3" maxlength="50" value="{{old('choice3')}}" required>
                        <input class="radio ml-3" type="radio" name="answer" value="choice3" {{old('answer')=='choice3'?'checked':''}} required>
                        @if($errors->has('choice3'))
                        <span class="invalid-feedback" role="alert" style="height:30px;">
                            <strong>{{ $errors->first('choice3') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-inline mb-4">
                        <input class="form-control col-10 {{$errors->has('choice3')?'is-invalid':''}}" type="text" name="choice4" maxlength="50" value="{{old('choice4')}}" required>
                        <input class="radio ml-3" type="radio" name="answer" value="choice4" {{old('answer')=='choice4'?'checked':''}} required>
                        @if($errors->has('choice4'))
                        <span class="invalid-feedback" role="alert" style="height:30px;">
                            <strong>{{ $errors->first('choice4') }}</strong>
                        </span>
                        @endif
                    </div>

                    @if($errors->has('answer'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('answer') }}</strong>
                    </span>
                    @endif

                        <button class="form-control col-10 btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection