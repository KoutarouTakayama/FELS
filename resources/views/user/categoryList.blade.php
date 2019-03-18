@extends('layouts/htmlAndHeader')
@section('pageTitle','Category List | FELS')
@section('body')
<div class="container mt-4">
    <div class="row">
        @foreach($categories as $category)
        <div class="col-6">
            <div class="border m-4 shadow">
                <div class="m-3">
                    <strong>{{$category->title}}</strong>
                </div>
                <div class="m-3">
                    {{$category->description}}
                </div>
                <div class="m-3 text-right">
                    <a href="/category/{{$category->id}}"><button class="btn btn-primary">Start</button></a>
                </div>

            </div>
        </div>
        @endforeach
    </div>
    <div class="col-12">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="/categories/1" tabindex="-1">TOP</a>
                </li>
                @if($pageNumber == 1)
                <li class="page-item active"><a class="page-link" href="/categories/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 4}}">{{$pageNumber + 4}}</a></li>
                @elseif($pageNumber == 2)
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber-1}}">{{$pageNumber - 1}}</a></li>
                <li class="page-item active"><a class="page-link" href="/categories/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
                @else
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber - 2}}">{{$pageNumber -2}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber - 1}}">{{$pageNumber - 1}}</a></li>
                <li class="page-item active"><a class="page-link" href="/categories/{{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
                @endif
                <li class="page-item"><a class="page-link" href="/categories/{{$pageNumber + 1}}">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection 