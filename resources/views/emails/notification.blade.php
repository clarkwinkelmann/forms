<?php /** @var \App\Models\Submission $submission */ ?>

<p>{{ trans('submission.heading.new_submission_on', ['form' => $submission->form->title]) }}</p>

<dl>
    <dt>{{ trans('submission.label.created_at') }}</dt>
    <dd>{{ $submission->created_at }}</dd>
</dl>

@foreach($submission->form->fields as $field)
    <?php
    $field_data = $submission->field($field);
    ?>
    <dl>
        <dt>{{ $field->title }}</dt>
        @if(is_null($field_data))
            <dd><em>{{ trans('field.label.no_value') }}</em></dd>
        @elseif(\Illuminate\Support\Str::contains($field_data->pivot->value, ['http://', 'https://']))
            <dd><em>{{ trans('field.email_url_redacted') }}</em></dd>
        @else
            <dd>{{ $field_data->pivot->value }}</dd>
        @endif
    </dl>
@endforeach
