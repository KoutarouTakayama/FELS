<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('pageTitle')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/app.css')}}">
    <script src="main.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/admin/categories/1">E-Learning System | Admin</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/users/1">Users</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/admins/1">Admins</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">#</a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="nav-link" href="logout">Logout</a>
            </span>
        </div>
    </nav>
    @yield('body')
</body>

</html> 