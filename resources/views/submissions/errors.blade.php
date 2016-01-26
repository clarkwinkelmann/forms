@extends('master', ['title' => trans('submission.heading.errors_occurred')])

@section('content')

<h1>{{ trans('submission.heading.errors_occurred') }}</h1>

<p>{{ trans('submission.message.errors_occurred') }}</p>

<div class="alert alert-danger">
	<ul>
		@foreach($messages->all() as $message)
		<li>{{ $message }}</li>
		@endforeach
	</ul>
</div>

<p>{{ trans('submission.message.should_retry') }}</p>

@endsection
