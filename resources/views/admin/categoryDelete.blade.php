@extends('layouts/adminForm')
@section('pageTitle','Category Delete | Admin')
@section('titleValue',$category->title)
@section('descriptionValue',$category->description)
@section('readonly','readonly')
@section('buttonColor','danger')
@section('buttonText','Delete')
@section('formHeader')
<form action="/admin/category/{{$category->id}}/delete" method="POST">
    @csrf
    @method('DELETE')
    @endsection 