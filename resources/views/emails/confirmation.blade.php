{!! $html_message  !!}

<p>{{ trans('submission.message.below_summary') }}</p>

<dl>
    <dt>{{ trans('submission.label.created_at') }}</dt>
    <dd>{{ $submission->created_at }}</dd>
</dl>

@foreach($submission->fields as $field)
    <dl>
        <dt>{{ $field->title }}</dt>
        <dd>{{ $field->pivot->value }}</dd>
    </dl>
@endforeach
