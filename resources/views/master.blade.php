<!doctype html>
<html lang="{{ config('locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Forms by Clark Winkelmann <https://github.com/clarkwinkelmann/forms>">

    <title>{{ $title ?? 'Forms' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Forms
        </a>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ url('/admin') }}">
                    @if (Auth::guest())
                        {{ trans('admin.area_title') }}
                    @else
                        {{ Auth::user()->email }}
                    @endif
                </a></li>
        </ul>
    </div>
</nav>

<div class="container">
    @if(isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    @yield('content')
    <hr/>
    <p class="text-center">{!! trans('welcome.find_code', ['link' => '<a href="https://github.com/clarkwinkelmann/forms">GitHub</a>']) !!}</p>
</div>
</body>
</html>
