@extends('master')

@section('content')
<div class="jumbotron">
	<h1>{{ trans('welcome.title') }}</h1>
	<p>{!! str_replace("\n", '</p><p>', e(trans('welcome.body'))) !!}</p>
</div>
@endsection
