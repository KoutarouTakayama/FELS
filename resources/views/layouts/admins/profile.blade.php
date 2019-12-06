@extends('layouts/admins/dashboard')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 offset-md-2">
            <div class="col-6 mx-auto">
                <img src=@yield('avatarUrl') class="img-fluid rounded-circle">
            </div>
            <label for="name">Name</label>
            <input class="form-control" type="text" value="@yield('nameValue')" @yield('readonlyName','')>

            <label class="mt-3" for="email">E-mail</label>
            <input class="form-control" type="mail" value="@yield('emailValue')" @yield('readonlyEmail','')>
        </div>
    </div>
</div>
@endsection