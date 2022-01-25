@extends('master', ['title' => trans('submission.heading.closed')])

@section('content')
    <h1>{{ trans('submission.heading.closed') }}</h1>

    <div class="alert alert-danger">
        <p>{{ trans('submission.message.closed') }}</p>
    </div>
@endsection
