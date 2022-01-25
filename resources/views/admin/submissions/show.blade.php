<?php
/** @var \App\Models\Submission $submission */
/** @var \App\Models\Field[] $fields */
?>

@extends('master', ['title' => trans('submission.action.show')])

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.forms.index') }}">{{ trans('form.heading.list') }}</a></li>
        <li>
            <a href="{{ route('admin.forms.submissions.index', $form->slug) }}">{{ trans('submission.heading.list') }}</a>
        </li>
        <li class="active">{{ trans('submission.action.edit') }}</li>
    </ol>

    <h1>{{ trans('submission.heading.single_for', ['form' => $form->title]) }}</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('field.heading.single') }}</th>
            <th>{{ trans('field.label.value') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ trans('submission.label.created_at') }}</td>
            <td>{{ $submission->created_at }}</td>
        </tr>
        @foreach($fields as $field)
            <tr>
                <td>{{ $field->title }}</td>
                <td>{{ $field->pivot->value }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(is_null($submission->user_referer))
        <p>{{ trans('submission.message.meta_sentence', ['ip' => $submission->user_ip, 'agent' => $submission->user_agent]) }}</p>
    @else
        <p>{{ trans('submission.message.meta_sentence_ref', ['ip' => $submission->user_ip, 'agent' => $submission->user_agent, 'referer' => $submission->user_referer]) }}</p>
    @endif

    <form action="{{ route('admin.forms.submissions.show', [$form->slug, $submission->id]) }}" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" value="{{ trans('submission.action.delete') }}"
               onclick="return confirm('{{ trans('admin.sure_to_delete', ['item' => $submission->created_at]) }}')">
    </form>
@stop
