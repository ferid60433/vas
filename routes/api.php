<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('kannel')->group(function () {
    Route::post('received', 'Api\\KannelController@received');
    Route::get('delivered', 'Api\\KannelController@delivered')
        ->name('kannel.delivered');
});

Route::resource('service', 'Api\\ServiceController', ['except' => ['create', 'edit']]);
Route::resource('inbox', 'Api\\InboxController', ['only' => ['index', 'show']]);
Route::resource('outbox', 'Api\\OutboxController', ['only' => ['index', 'show']]);
