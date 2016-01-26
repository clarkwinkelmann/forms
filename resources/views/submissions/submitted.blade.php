@extends('master', ['title' => trans('submission.heading.submitted')])

@section('content')

<h1>{{ trans('submission.heading.submitted') }}</h1>

<p>{{ trans('submission.message.submitted') }}</p>

@if($email_sent_successfully === true)

<div class="alert alert-info">
	<p>{{ trans('submission.message.email_sent') }}</p>
</div>

@elseif($email_sent_successfully === false)

<div class="alert alert-warning">
	<p>{{ trans('submission.message.email_failed') }}</p>
</div>

@endif

@endsection