@extends('layouts/htmlAndHeader')
@section('pageTitle','Settings | FELS')
@section('style')
@endsection
@section('body')
<div class="container">
    <div class="row">
        @if(session()->has('message'))
        <div class="alert alert-{{session()->get('color')}} col-12" role="alert">
            {{session()->get('message')}}
        </div>
        @endif
        @if($errors->has('avatar'))
        <span class="alert alert-danger col-12" role="alert">
            <strong>{{ $errors->first('avatar') }}</strong>
        </span>
        @endif
        <div class="col-5 pt-3 pb-5 px-3">
            <div class="border shadow pt-3 pb-5 px-3 h-100">
                <form action="/settings/profile/restore" method="POST" class="h-100 mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="h-75">
                        <label for="name" class="mt-4">Name</label>
                        <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="name" placeholder="Mt.fuji" minlength="3" maxlength="20" value="{{$user->name}}">
                        @if($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                        <label for="email" class="mt-4 ">E-mail</label>
                        <input type="mail" class="form-control" name="email" placeholder="hokkaido@sapporo.com" value="{{$user->email}}">
                        @if($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="d-flex align-items-end h-25">
                        <button type="submit" class="form-control btn btn-success">Change Your Profile</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4 pt-3 pb-5 px-3">
            <div class="border shadow pt-3 pb-5 px-3 h-100">
                <form action="/settings/password/restore" method="POST" class="h-100 mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="h-75">
                        <label for="currentPassword" class="mt-4">Current Password</label>
                        <input class="form-control {{$errors->has('currentPassword') ? 'is-invalid' : ''}}" name="currentPassword" type="password" minlength="6" placeholder="Current Password">
                        @if($errors->has('currentPassword'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('currentPassword') }}</strong>
                        </span>
                        @endif
                        <label for="newPassword" class="mt-4">New Password</label>
                        <input class="form-control {{$errors->has('newPassword') ? 'is-invalid' : ''}}" name="newPassword" type="password" minlength="6" placeholder="New Password">
                        @if($errors->has('newPassword'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('newPassword') }}</strong>
                        </span>
                        @endif
                        <label for="newPassword_confirmation" class="mt-4">New Password Confirmation</label>
                        <input class="form-control" name="newPassword_confirmation" type="password" minlength="6" placeholder="New Password">
                    </div>
                    <div class="d-flex align-items-end h-25">
                        <button type="submit" class="form-control btn btn-warning">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-3 pt-3 pb-5 px-3">
            <div class="border shadow h-100 pt-3 pb-5 px-3">
                <form action="/settings/avatar/restore" method="POST" class="h-100 mb-3" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="h-75">
                        <label for="file" class="mt-4">Current Avatar</label>
                        <div class="px-4 d-flex align-items-start">
                            <img src="{{asset('storage/'.$user->avatar_url)}}" alt="" class="border img-fluid rounded-circle">
                        </div>
                        <div class="d-flex mt-3 align-items-end">
                            <input type="file" class="form-control-file" name="avatar">
                        </div>
                    </div>
                    <div class="h-25 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary form-control">Change Avatar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 