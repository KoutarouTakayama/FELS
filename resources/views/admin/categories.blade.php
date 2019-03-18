@extends('layouts.adminDashboard')
@section('pagetitle','Dashboard | Admin')
@section('body')
<div class="container">
    <a href="/admin/add/category"><button class="mt-4 btn btn-primary form-control">Add new Category</button></a>
    <div class="mt-4">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <td>
                        Title
                    </td>
                    <td>
                        Description
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="text-turncate" style="min-width:200px;">
                        <a href="#">{{$category->title}}</a>
                    </td>
                    <td class="text-turncate" style="width:50%; min-width:300px;">
                        {{$category->description}}
                    </td>
                    <td style="min-width:200px;">
                        <a href="/admin/add/word/{{$category->id}}">Add word</a> | <a href="/admin/category/{{$category->id}}/edit">Edit</a> | <a href="/admin/category/{{$category->id}}/destroy">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($pageNumber == 1)
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="/admin/categories/1">TOP</a></li>
            <li class="page-item active"><a class="page-link" href="/admin/categories/{{$pageNumber}}">{{$pageNumber}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 4}}">{{$pageNumber + 4}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">NEXT</a></li>
        </ul>
    </nav>
    @elseif($pageNumber == 2)
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="/admin/categories/1">TOP</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber - 1}}">{{$pageNumber - 1}}</a></li>
            <li class="page-item active"><a class="page-link" href="/admin/categories/{{$pageNumber}}">{{$pageNumber}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">NEXT</a></li>
        </ul>
    </nav>
    @else
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="/admin/categories/1">TOP</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber - 2}}">{{$pageNumber - 2}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber - 1}}">{{$pageNumber - 1}}</a></li>
            <li class="page-item active"><a class="page-link" href="/admin/categories/{{$pageNumber}}">{{$pageNumber}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            <li class="page-item"><a class="page-link" href="/admin/categories/{{$pageNumber + 1}}">NEXT</a></li>
        </ul>
    </nav>
    @endif
</div>
@endsection 