@extends('layouts/adminForm')
@section('pageTitle','Add Category')
@section('buttonColor','primary')
@section('buttonText','Submit')
@section('formHeader')
<form action="/admin/add/category/store" method="POST">
    @csrf
    @endsection 