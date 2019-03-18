<div class="col-12">
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="@yield('pagenation')1" tabindex="-1">TOP</a>
            </li>
            @if($pageNumber == 1)
            <li class="page-item active"><a class="page-link" href="@yield('pagenation'){{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 4}}">{{$pageNumber + 4}}</a></li>
            @elseif($pageNumber == 2)
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber-1}}">{{$pageNumber - 1}}</a></li>
            <li class="page-item active"><a class="page-link" href="@yield('pagenation'){{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 3}}">{{$pageNumber + 3}}</a></li>
            @else
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber - 2}}">{{$pageNumber -2}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber - 1}}">{{$pageNumber - 1}}</a></li>
            <li class="page-item active"><a class="page-link" href="@yield('pagenation'){{$pageNumber}}">{{$pageNumber}}<span class="sr-only">(current)</span></a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 1}}">{{$pageNumber + 1}}</a></li>
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 2}}">{{$pageNumber + 2}}</a></li>
            @endif
            <li class="page-item"><a class="page-link" href="@yield('pagenation'){{$pageNumber + 1}}">Next</a></li>
        </ul>
    </nav>
</div> 