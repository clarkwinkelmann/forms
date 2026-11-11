<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::orderBy('title')->get();

        return view('admin.forms.index', ['forms' => $forms]);
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required|alpha_dash|unique:forms,slug',
            'title' => 'required|string',
        ]);

        $form = new Form;

        $form->slug = $request->input('slug');
        $form->title = $request->input('title');

        $form->save();

        return redirect()->route('admin.forms.edit', $form->slug)
            ->with('message', trans('form.message.create_success'));
    }

    public function edit($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        return view('admin.forms.edit', ['form' => $form]);
    }

    public function update($slug, Request $request)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        $this->validate($request, [
            'slug' => 'required|alpha_dash|unique:forms,slug,' . $form->id,
            'title' => 'required|string',
            'accept_submissions' => 'nullable|boolean',
            'send_email_to' => 'nullable|string',
            'confirmation_message' => 'nullable|string',
            'confirmation_email_field' => 'nullable|exists:fields,slug,form_id,' . $form->id,
            'redirect_to_url' => 'nullable|url',
            'owner_email' => 'nullable|email',
            'owner_name' => 'nullable|string',
        ]);

        $form->slug = $request->input('slug');
        $form->title = $request->input('title');
        $form->accept_submissions = !!$request->input('accept_submissions', false);
        $form->send_email_to = $request->input('send_email_to', '') == '' ? null : $request->input('send_email_to');
        $form->confirmation_message = $request->input('confirmation_message', '') == '' ? null : $request->input('confirmation_message');
        $form->confirmation_email_field = $request->input('confirmation_email_field', '') == '' ? null : $request->input('confirmation_email_field');
        $form->redirect_to_url = $request->input('redirect_to_url', '') == '' ? null : $request->input('redirect_to_url');
        $form->owner_email = $request->input('owner_email', '') == '' ? null : $request->input('owner_email');
        $form->owner_name = $request->input('owner_name', '') == '' ? null : $request->input('owner_name');

        $form->save();

        return redirect()->route('admin.forms.edit', $form->slug)
            ->with('message', trans('form.message.edit_success'));
    }

    public function destroy($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        $form->delete();

        return redirect()->route('admin.forms.index')
            ->with('message', trans('form.message.delete_success'));
    }
}
