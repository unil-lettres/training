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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/logout', function () {
    backpack_auth()->logout();
    return redirect()->route('home');
})->name('logout');

Route::resource('request', 'RequestController')->only([
    'create', 'store'
])->middleware(['auth']);

Route::redirect('/login', '/shibboleth-login')->name('login');
