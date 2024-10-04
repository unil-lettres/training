<?php

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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::group([
    'middleware' => ['auth'],
    'as' => 'front.',
], function () {
    Route::get('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::resource('request', RequestController::class)->only([
        'index', 'create', 'store',
    ]);
});

Route::get('/login')
    ->name('login')
    ->middleware('auth_method');

Route::get('/login/aai')
    ->middleware('check_aai');

Auth::routes([
    'register' => false,
    'login' => false,
]);
