<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Outside web because we don't require CRSF protection
Route::post('forms/{slug}', 'SubmissionController@store');

Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('admin')->namespace('Admin')->middleware('auth.basic')->group(function () {
        // Pointing home page to /admin hides the default admin route
        Route::get('/', function () {
            return redirect()->route('admin.forms.index');
        });

        Route::name('admin.')->group(function () {
            Route::resource('forms', 'FormController');
            Route::resource('forms.fields', 'FormFieldController');
            Route::resource('forms.submissions', 'FormSubmissionController');
        });
    });
});
