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

use Vas\Service;

Route::view('/', 'dashboard');

Route::view('compose', 'compose');
Route::view('services', 'services.index');
Route::view('inbox', 'inbox');
Route::view('outbox', 'outbox');
Route::view('subscribers', 'subscribers');
Route::view('settings', 'settings');

Route::get('services/{service}', function (Service $service) {
    return view('services.show', compact('service'));
});
