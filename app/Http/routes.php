<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

// Outside web because we don't require CRSF protection
Route::post('forms/{slug}', 'SubmissionController@store');

Route::group(['middleware' => ['web']], function() {
	Route::get('/', function() {
		return view('welcome');
	});

	Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth.basic'], function() {
		// Pointing home page to /admin hides the default admin route
		Route::get('/', function() {
			return redirect()->route('admin.forms.index');
		});

		Route::resource('forms',             'FormController');
		Route::resource('forms.fields',      'FormFieldController');
		Route::resource('forms.submissions', 'FormSubmissionController');
	});
});
