<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<ul class="nav justify-content-center">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/category">Category</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/post"> Post </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/tag"> Tag </a>
    </li>
</ul>
<div class="container-fluid">
    @yield('content')
</div>


</body>
</html>