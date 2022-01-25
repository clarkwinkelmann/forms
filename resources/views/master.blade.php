<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Forms by Clark Winkelmann <https://github.com/clarkwinkelmann/forms>">

    <title>{{ $title ?? 'Forms' }}</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                Forms
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/admin') }}">
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
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @yield('content')
    <hr/>
    <p class="text-center">{!! trans('welcome.find_code', ['link' => '<a href="https://github.com/clarkwinkelmann/forms">GitHub</a>']) !!}</p>
</div>
</body>
</html>
