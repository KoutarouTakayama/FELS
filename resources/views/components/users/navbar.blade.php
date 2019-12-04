<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/dashboard">FELS</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/profile/{{auth()->user()->id}}/learnedwords">Learned words</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/profile/{{auth()->user()->id}}/learnedlessons">Learned lessons</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/profile/{{auth()->user()->id}}">Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/categories/1">Categories</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/userlist/1">User List</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/settings">Settings</a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="nav-link" href="logout">Logout</a>
            </span>
        </div>
    </nav>
</div>