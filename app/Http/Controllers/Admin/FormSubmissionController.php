<?php namespace App\Http\Controllers\Admin;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use App\Form;
use App\Http\Controllers\Controller;
use App\Submission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller {

	public function index($form_slug)
	{
		$form = Form::where('slug', $form_slug)->firstOrFail();

		$submissions = $form->submissions()->orderBy('created_at', 'desc')->paginate(20);

		return view('admin.submissions.index', [
			'form'        => $form,
			'submissions' => $submissions,
		]);
	}

	public function show($form_slug, $submission_id)
	{
		$submission = Submission::findOrFail($submission_id);

		$fields = $submission->fields()->orderBy('title')->get();

		return view('admin.submissions.show', [
			'form'       => $submission->form,
			'submission' => $submission,
			'fields'     => $fields,
		]);
	}

	public function destroy($form_slug, $submission_id, Request $request)
	{
		$submission = Submission::findOrFail($submission_id);

		$form = $submission->form;

		$submission->delete();

		return redirect()->route('admin.forms.submissions.index', $form->slug)
				->with('message', trans('submission.message.delete_success'));
	}

}
