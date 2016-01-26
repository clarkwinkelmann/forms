@extends('master', ['title' => trans('form.heading.list')])

@section('content')
<ol class="breadcrumb">
	<li class="active">{{ trans('form.heading.list') }}</li>
</ol>

<h1>{{ trans('form.heading.list') }}</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>{{ trans('form.label.title') }}</th>
			<th>{{ trans('form.label.slug') }}</th>
			<th>{{ trans('form.label.total_submissions') }}</th>
			<th>{{ trans('form.label.created_at') }}</th>
			<th>{{ trans('admin.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@forelse($forms as $form)
		<tr>
			<td>{{ $form->title }}</td>
			<td>{{ $form->slug }}</td>
			<td>{{ $form->submissions()->count() }}</td>
			<td>{{ $form->created_at }}</td>
			<td>
				<a class="btn btn-default" href="{{ route('admin.forms.edit', $form->slug) }}">{{ trans('form.action.edit') }}</a>
				<a class="btn btn-default" href="{{ route('admin.forms.submissions.index', $form->slug) }}">{{ trans('submission.action.show_index') }}</a>
			</td>
		</tr>
		@empty
		<tr>
			<td><em>{{ trans('form.heading.none') }}</em></td>
		</tr>
		@endforelse
	</tbody>
</table>

<div class="form-group">
	<a class="btn btn-primary" href="{{ route('admin.forms.create') }}">{{ trans('form.action.create') }}</a>
</div>

@stop
