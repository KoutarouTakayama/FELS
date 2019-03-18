@extends('layouts/adminForm')
@section('pageTitle','Category Edit | Admin')
@section('titleValue',$category->title)
@section('descriptionValue',$category->description)
@section('formHeader')
<form action="/admin/category/{{$category->id}}/restore" method="POST">
    @csrf
    @method('PATCH')
    @endsection 