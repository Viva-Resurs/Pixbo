<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::resource('play', 'PlayerController');

Route::get('admin/screengroups/{screengroup}/screens', 'Admin\ScreenGroupsController@screens');
Route::post('admin/screengroups/{screengroup}/screens/{screens}/remove_association', 'Admin\ScreenGroupsController@remove_association');

Route::get('/', 'PagesController@home');
Route::get('admin/dashboard', 'PagesController@dashboard');
//Route::get('admin/calendars', 'PagesController@calendars');
Route::post('admin/screengroups/{screengroups}/addphoto', 'Admin\ScreenGroupsController@addScreenFromPhoto');
Route::post('admin/screens/addphoto', 'Admin\ScreensController@addScreenFromPhoto');

Route::get('/api/screengroups', function () {
    $screengroups = App\ScreenGroup::all(['id', 'name']);
    return $screengroups->map(function ($screengroups) {
        return [
            'text' => $screengroups->name,
            'value' => $screengroups->id,
        ];
    })->toArray();
});

Route::get('/api/tags', function () {
    $tags = App\Tag::all(['id', 'name']);
    return $tags->map(function ($tags) {
        return [
            'name' => $tags->name,
            'id' => $tags->id,
        ];
    })->toArray();
});

Route::get('/api/screen/{id}', function ($id) {
    $screen = App\Screen::where('id', $id)->with(['event', 'tags', 'screengroups'])->first();
    return $screen;
});

Route::post('/api/screen/{id}', 'Admin\ScreensController@update');

// Route::get('/event', function () {
//     event('GenerateShadowEvents', EventMeta::first());
// });

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth',
], function () {

    Route::get('admin', function () {
        return redirect('/admin/dashboard');
    });
    Route::resource('admin/clients', 'ClientsController');
    //Route::resource('admin/screengroups/{screengroup_id}/tickers', 'TickersController');
    Route::resource('admin/tickers', 'TickersController');
    Route::resource('admin/screengroups', 'ScreenGroupsController');
    Route::resource('admin/screens', 'ScreensController');
    Route::resource('admin/photos', 'PhotosController');
    Route::resource('admin/events', 'EventsController');
    Route::resource('admin/eventmetas', 'EventMetasController');
    Route::resource('admin/users', 'UsersController');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

/**
 * Top menu
 */
Menu::make('topNav', function ($menu) {

    $menu->add(trans('messages.screen_groups'), 'admin/screengroups');
    $menu->add(trans('messages.clients'), 'admin/clients');
    $menu->add(trans('messages.screens'), 'admin/screens');
    $menu->add(trans('messages.users'), 'admin/users');
    $menu->add(trans('messages.settings'), 'settings');
});
