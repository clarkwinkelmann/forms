<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function index($form_slug)
    {
        $form = Form::where('slug', $form_slug)->firstOrFail();

        $submissions = $form->submissions()->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.submissions.index', [
            'form' => $form,
            'submissions' => $submissions,
        ]);
    }

    public function show($form_slug, $submission_id)
    {
        $submission = Submission::findOrFail($submission_id);

        $fields = $submission->fields()->orderBy('title')->get();

        return view('admin.submissions.show', [
            'form' => $submission->form,
            'submission' => $submission,
            'fields' => $fields,
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
