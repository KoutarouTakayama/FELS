@extends('layouts/htmlAndHeader')
@section('pageTitle','Result | FELS')
@section('body')
<div class="container">
    <div class="row my-4">
        <div class="col-6 text-center">
            <h2>{{$category->title}}</h2>
        </div>
        <div class="col-6 text-center">
            <h2>{{$count}} of {{$category->word->count()}}</h2>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-hover">
                <thead class="table-primary">
                    <th class=""></th>
                    <th class="text-center">Question</th>
                    <th class="text-center">Answer</th>
                </thead>
                @foreach($words as $word)
                <tr>
                    <td class="text-center">
                        {{$word->correct ? 'O' : 'X'}}
                    </td>
                    <td class="text-center">
                        {{$word->word->word}}
                    </td>
                    <td class="text-center">
                        {{$word->word->answer}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-2"></div>
    </div>
</div>
@endsection 