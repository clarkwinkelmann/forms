@extends('master', ['title' => trans('form.action.create')])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.forms.index') }}">{{ trans('form.heading.list') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('form.action.create') }}</li>
        </ol>
    </nav>

    <h1>{{ trans('form.action.create') }}</h1>

    <form action="{{ route('admin.forms.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="slug">{{ trans('form.label.slug') }}</label>
            <input class="form-control" type="text" name="slug" id="slug" required>
        </div>

        <div class="form-group">
            <label for="title">{{ trans('form.label.title') }}</label>
            <input class="form-control" type="text" name="title" id="title" required>
        </div>

        <input class="btn btn-primary" type="submit" value="{{ trans('form.action.save') }}">
    </form>
@stop
