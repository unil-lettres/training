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

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/logout', function () {
    backpack_auth()->logout();
    return view('pages.home');
})->name('logout');

Route::resource('request', 'RequestController')->only([
  'index', 'show', 'create', 'store'
])->middleware(['auth']);

Route::redirect('/login', '/shibboleth-login')->name('login');
