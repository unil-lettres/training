<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('status/ajax-status-options', 'StatusCrudController@statusOptions');
    CRUD::resource('status', 'StatusCrudController');
    Route::get('type/ajax-type-options', 'TypeCrudController@typeOptions');
    CRUD::resource('type', 'TypeCrudController');
    CRUD::resource('training', 'TrainingCrudController');
    CRUD::resource('request', 'RequestCrudController');
}); // this should be the absolute last line of this file