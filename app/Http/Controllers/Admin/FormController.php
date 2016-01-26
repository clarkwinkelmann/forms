<?php namespace App\Http\Controllers\Admin;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use App\Form;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormController extends Controller {

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
			'slug'                     => 'required|alpha_dash|unique:forms,slug',
			'title'                    => 'required|string',
		]);

		$form = new Form;

		$form->slug = $request->get('slug');
		$form->title = $request->get('title');

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
			'slug'                     => 'required|alpha_dash|unique:forms,slug,' . $form->id,
			'title'                    => 'required|string',
			'accept_submissions'       => 'sometimes|accepted',
			'send_email_to'            => 'sometimes|string',
			'confirmation_message'     => 'sometimes|string',
			'confirmation_email_field' => 'sometimes|exists:fields,slug,form_id,' . $form->id,
			'redirect_to_url'          => 'sometimes|url',
			'owner_email'              => 'sometimes|email',
			'owner_name'               => 'sometimes|string',
		]);

		$form->slug = $request->get('slug');
		$form->title = $request->get('title');
		$form->accept_submissions = !!$request->get('accept_submissions', false);
		$form->send_email_to = $request->get('send_email_to', '') == '' ? null : $request->get('send_email_to');
		$form->confirmation_message = $request->get('confirmation_message', '') == '' ? null : $request->get('confirmation_message');
		$form->confirmation_email_field = $request->get('confirmation_email_field', '') == '' ? null : $request->get('confirmation_email_field');
		$form->redirect_to_url = $request->get('redirect_to_url', '') == '' ? null : $request->get('redirect_to_url');
		$form->owner_email = $request->get('owner_email', '') == '' ? null : $request->get('owner_email');
		$form->owner_name = $request->get('owner_name', '') == '' ? null : $request->get('owner_name');

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
