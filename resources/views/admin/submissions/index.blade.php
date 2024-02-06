<?php /** @var \App\Models\Submission[]|\Illuminate\Database\Eloquent\Collection $submissions */ ?>

@extends('master', ['title' => trans('submission.heading.list')])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.forms.index') }}">{{ trans('form.heading.list') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('form.heading.list') }}</li>
        </ol>
    </nav>

    <h1>{{ trans('submission.heading.list_for', ['form' => $form->title]) }}</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('submission.label.created_at') }}</th>
            <th>{{ trans('submission.label.preview') }}</th>
            <th>{{ trans('admin.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($submissions as $submission)
            <tr>
                <td>
                    {{ $submission->created_at }}
                    @if($submission->is_spam)
                        <span class="badge text-bg-danger">Spam</span>
                    @endif
                </td>
                <td>
                    @foreach($submission->fields as $field)
                        <div class="form-group">
                            <label>{{ $field->title }}</label>
                            <p>{{ $field->pivot->value }}</p>
                        </div>
                    @endforeach
                </td>
                <td>
                    <a class="btn btn-secondary"
                       href="{{ route('admin.forms.submissions.show', [$form->slug, $submission->id]) }}">{{ trans('submission.action.show') }}</a>
                    <form action="{{ route('admin.forms.submissions.show', [$form->slug, $submission->id]) }}"
                          method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <input class="btn btn-danger" type="submit" value="{{ trans('submission.action.delete') }}"
                               onclick="return confirm('{{ trans('admin.sure_to_delete', ['item' => $submission->created_at]) }}')">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td><em>{{ trans('submission.heading.none') }}</em></td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $submissions->links() }}
@stop
