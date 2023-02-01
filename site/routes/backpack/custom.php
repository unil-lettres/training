<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
Route::get('status/ajax-status-options', 'StatusCrudController@statusOptions');
    Route::crud('status', 'StatusCrudController');
    Route::get('category/ajax-category-options', 'CategoryCrudController@categoryOptions');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('training', 'TrainingCrudController');
    Route::crud('request', 'RequestCrudController');
    Route::get('dashboard', 'DashboardController@dashboard');
}); // this should be the absolute last line of this file
