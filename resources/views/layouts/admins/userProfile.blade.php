<div class="container mt-4">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="col-6 mx-auto">
                <img src=@yield('avatarUrl') class="img-fluid rounded-circle">
            </div>
            <label for="name">Name</label>
            <input class="form-control" type="text" value="@yield('nameValue')" @yield('readonlyName','')>

            <label class="mt-3" for="email">E-mail</label>
            <input class="form-control" type="mail" value="@yield('emailValue')" @yield('readonlyEmail','')>
        </div>
        <div class="ciol-2"></div>
    </div>
</div>