<?php
	$form = $submission->form;
?>

<p>{{ trans('submission.heading.new_submission_on', ['form' => $form->title]) }}</p>

<dl>
	<dt>{{ trans('submission.label.created_at') }}</dt>
	<dd>{{ $submission->created_at }}</dd>
</dl>

@foreach($form->fields as $field)
<?php
	$field_data = $submission->field($field);
?>
<dl>
	<dt>{{ $field->title }}</dl>
	@if(is_null($field_data))
	<dd><em>{{ trans('field.label.no_value') }}</em></dd>
	@else
	<dd>{{ $field_data->pivot->value }}</dd>
	@endif
</dl>
@endforeach
