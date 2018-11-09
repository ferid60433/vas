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


use Illuminate\Http\Request;

Route::view('/', 'dashboard');

Route::view('compose', 'compose');
Route::post('compose', 'ComposeMessageController');
Route::view('services', 'services.index');
Route::view('services/create', 'services.create');
Route::get('services/{service}/edit', function (Vas\Service $service) {
    return view('services.edit', compact('service'));
});

Route::post('services/{service}', function (Vas\Service $service, Request $request) {
    $service->update($request->only('code', 'letter', 'confirmation_message'));

    return redirect()->to('services')->with('success', 'Service updated successfully!');
});


Route::post('services', function (Vas\Http\Requests\ServiceStoreRequest $request) {
    Vas\Service::create($request->all());

    return redirect()->to('services')->with('success', 'Service registered successfully!');
});
Route::any('services/{service}/delete', function (Vas\Service $service) {
    if ($service->subscribers()->count() > 0) {
        return redirect()->to('services')->with('danger', 'Unable to delete service with a subscriber!');
    }

    $service->delete();

    return redirect()->to('services')->with('success', 'Service deleted successfully!');
});


Route::view('inbox', 'inbox');
Route::any('inbox/{inbox}', function (Vas\ReceivedMessage $inbox) {
    $inbox->delete();

    return redirect()->back()->with('success', 'Successfully deleted!');
});

Route::view('outbox', 'outbox');
Route::any('outbox/{outbox}', function (Vas\SentMessage $outbox) {
    $outbox->delete();

    return redirect()->back()->with('success', 'Successfully deleted!');
});

Route::view('subscribers', 'subscribers');
Route::view('subscribers/import', 'import');

Route::post('subscribers/import', 'SubscribersImportController');

Route::any('subscribers/{subscriber}', function (Vas\Subscriber $subscriber) {
    $subscriber->delete();

    return redirect()->back()->with('success', 'Successfully deleted!');
});


Route::view('settings', 'settings');
Route::view('settings/{setting}/edit', 'settings-update');
Route::any('settings/{setting}', function (Vas\Lookup $setting, Request $request) {
    $setting->value = $request->get('value');
    $setting->save();

    return redirect()->to('settings')->with('success', 'Successfully updated!');
});

// report
Route::get('report', 'ReportController@filter');
