<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Form;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    public function store($form_slug, Request $request)
    {
        $form = Form::where('slug', $form_slug)->firstOrFail();

        $this->validate($request, [
            'slug' => 'required|alpha_dash|unique:fields,slug,NULL,id,form_id,' . $form->id,
            'title' => 'required|string',
            'rules' => 'string',
        ]);

        $field = new Field;

        $field->slug = $request->get('slug');
        $field->title = $request->get('title');
        $field->rules = $request->get('rules', '');

        $form->fields()->save($field);

        return redirect()->route('admin.forms.edit', $form->slug)
            ->with('message', trans('field.message.create_success'));
    }

    public function update($form_slug, $field_slug, Request $request)
    {
        $form = Form::where('slug', $form_slug)->firstOrFail();
        $field = $form->fields()->where('slug', $field_slug)->firstOrFail();

        $this->validate($request, [
            'slug' => 'required|alpha_dash|unique:fields,slug,' . $field->id . ',id,form_id,' . $form->id,
            'title' => 'required|string',
            'rules' => 'string',
        ]);

        $field->slug = $request->get('slug');
        $field->title = $request->get('title');
        $field->rules = $request->get('rules', '');

        $field->save();

        return redirect()->route('admin.forms.edit', $form->slug)
            ->with('message', trans('field.message.edit_success'));
    }

    public function destroy($form_slug, $field_slug)
    {
        $form = Form::where('slug', $form_slug)->firstOrFail();
        $field = $form->fields()->where('slug', $field_slug)->firstOrFail();

        $field->delete();

        return redirect()->route('admin.forms.edit', $form->slug)
            ->with('message', trans('field.message.delete_success'));
    }
}
