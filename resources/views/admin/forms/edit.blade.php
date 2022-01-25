<?php /** @var \App\Models\Form $form */ ?>

@extends('master', ['title' => trans('form.action.edit')])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.forms.index') }}">{{ trans('form.heading.list') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('form.action.edit') }}</li>
        </ol>
    </nav>

    <h1>{{ trans('form.action.edit') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.forms.update', $form->slug) }}" method="post">
                {{ method_field('put') }}
                {{ csrf_field() }}

                <div class="mb-3">
                    <label class="form-label" for="slug">{{ trans('form.label.slug') }}</label>
                    <input class="form-control" type="text" name="slug" id="slug" value="{{ $form->slug }}" required>
                    <span
                        class="help-block">{{ trans('form.help.available_at_url', ['url' => url('forms/' . $form->slug)]) }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="title">{{ trans('form.label.title') }}</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{ $form->title }}" required>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="accept_submissions"
                               id="accept_submissions" value="1" {{ $form->accept_submissions ? 'checked' : '' }}>
                        <label class="form-check-label"
                               for="accept_submissions">{{ trans('form.label.accept_submissions') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="send_email_to">{{ trans('form.label.send_email_to') }}</label>
                    <input class="form-control" type="text" name="send_email_to" id="send_email_to"
                           value="{{ $form->send_email_to }}">
                    <span class="help-block">{{ trans('form.help.send_email_to') }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label"
                           for="confirmation_message">{{ trans('form.label.confirmation_message') }}</label>
                    <textarea class="form-control" name="confirmation_message" id="confirmation_message"
                              style="min-height: 10em;">{{ $form->confirmation_message }}</textarea>
                    <span class="help-block">{{ trans('form.help.confirmation_message') }}</span>
                    <span class="help-block">{{ trans('form.help.confirmation_formatting') }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label"
                           for="confirmation_email_field">{{ trans('form.label.confirmation_email_field') }}</label>
                    <input class="form-control" type="text" name="confirmation_email_field"
                           id="confirmation_email_field" value="{{ $form->confirmation_email_field }}">
                    <span class="help-block">{{ trans('form.help.confirmation_email_field') }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="redirect_to_url">{{ trans('form.label.redirect_to_url') }}</label>
                    <input class="form-control" type="url" name="redirect_to_url" id="redirect_to_url"
                           value="{{ $form->redirect_to_url }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="owner_email">{{ trans('form.label.owner_email') }}</label>
                    <input class="form-control" type="email" name="owner_email" id="owner_email"
                           value="{{ $form->owner_email }}">
                    <span class="help-block">{{ trans('form.help.owner_email') }}</span>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="owner_name">{{ trans('form.label.owner_name') }}</label>
                    <input class="form-control" type="text" name="owner_name" id="owner_name"
                           value="{{ $form->owner_name }}">
                    <span class="help-block">{{ trans('form.help.owner_name') }}</span>
                </div>

                <input class="btn btn-primary" type="submit" value="{{ trans('form.action.save') }}">
            </form>
            <form action="{{ route('admin.forms.destroy', $form->slug) }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}

                <input class="btn btn-danger" type="submit" value="{{ trans('form.action.delete') }}"
                       onclick="return confirm('{{ trans('admin.sure_to_delete', ['item' => $form->title]) }}')">
            </form>
        </div>
    </div>

    <h2>{{ trans('field.heading.list') }}</h2>

    <div class="row">
        <div class="col-md-6">
            @forelse($form->fields as $field)
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.forms.fields.update', [$form->slug, $field->slug]) }}"
                              method="post">
                            {{ method_field('put') }}
                            {{ csrf_field() }}

                            <div class="mb-3">
                                <label class="form-label"
                                       for="field-{{ $field->id }}-slug">{{ trans('field.label.slug') }}</label>
                                <input class="form-control" type="text" name="slug" id="field-{{ $field->id }}-slug"
                                       value="{{ $field->slug }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                       for="field-{{ $field->id }}-title">{{ trans('field.label.title') }}</label>
                                <input class="form-control" type="text" name="title" id="field-{{ $field->id }}-title"
                                       value="{{ $field->title }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                       for="field-{{ $field->id }}-rules">{{ trans('field.label.rules') }}</label>
                                <input class="form-control" type="text" name="rules" id="field-{{ $field->id }}-rules"
                                       value="{{ $field->rules }}">
                                <span class="help-block">{{ trans('field.help.rules') }}</span>
                            </div>

                            <input class="btn btn-primary" type="submit" value="{{ trans('field.action.save') }}">
                        </form>
                        <form action="{{ route('admin.forms.fields.destroy', [$form->slug, $field->slug]) }}"
                              method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}

                            <input class="btn btn-danger" type="submit" value="{{ trans('field.action.delete') }}"
                                   onclick="return confirm('{{ trans('admin.sure_to_delete', ['item' => $field->title]) }}')">
                        </form>
                    </div>
                </div>
            @empty
                <p>{{ trans('field.heading.none') }}</p>
            @endforelse

            <h2>{{ trans('field.action.create') }}</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.forms.fields.store', $form->slug) }}" method="post">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label class="form-label" for="field-new-slug">{{ trans('field.label.slug') }}</label>
                            <input class="form-control" type="text" name="slug" id="field-new-slug" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="field-new-title">{{ trans('field.label.title') }}</label>
                            <input class="form-control" type="text" name="title" id="field-new-title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="field-new-rules">{{ trans('field.label.rules') }}</label>
                            <input class="form-control" type="text" name="rules" id="field-new-rules">
                            <span class="help-block">{{ trans('field.help.rules') }}</span>
                        </div>

                        <input class="btn btn-primary" type="submit" value="{{ trans('field.action.save') }}">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2>{{ trans('validation_help.title') }}</h2>
                    <p>{{ trans('validation_help.intro') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
