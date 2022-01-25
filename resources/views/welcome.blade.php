@extends('master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>{{ trans('welcome.title') }}</h1>
            <p>{!! str_replace("\n", '</p><p>', e(trans('welcome.body'))) !!}</p>
        </div>
    </div>
@endsection
