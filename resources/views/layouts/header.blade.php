<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('pageTitle','FELS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="main.js"></script>
    <style>
        @yield('style')
    </style>
</head>

<body>
    @component('/component/users/navbar')
    @endcomponent
    @yield('body')
</body>

</html>