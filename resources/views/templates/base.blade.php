<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    @if(session()->has('error'))
        <div class="d-flex flex-column align-items-center">
            <div class="alert alert-warning mw-100 mt-2">
                {{ session()->pull('error') }}
            </div>
        </div>
    @endif
    @yield('content')
</body>
</html>
